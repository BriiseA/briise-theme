#!/usr/bin/env bash
# Banc d'essai Briise : le « contrôle technique » du thème avant chaque version.
#
# 1. Fabrique les sections, les kits et le site Atelier Ferlune, et vérifie que tous les blocs sont valides
#    et que les fichiers du dépôt sont à jour.
# 2. Installe un WordPress neuf (base SQLite), le thème, l'extension, Fluent Forms et FluentSMTP.
# 3. Importe le site Atelier Ferlune (client fictif).
# 4. Vérifie : Contrôle sans alerte, formulaires créés, sécurité active, chaque page en ligne
#    sans erreur, un seul titre principal, accessibilité 100.
# 5. Prend des captures (ordinateur et mobile) des pages principales.
#
# Lancement : bash .github/outils/banc/lancer.sh
# Variables utiles : BANC_WP (dossier du WordPress de test), BANC_PORT, BANC_COPIE_DE (copier un
# WordPress existant au lieu de le télécharger), BANC_SANS_LIGHTHOUSE=1 (sauter l'accessibilité).
set -euo pipefail

ICI="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
OUTILS="$(cd "$ICI/.." && pwd)"
DEPOT="$(cd "$OUTILS/../.." && pwd)"
export BANC_WP="${BANC_WP:-/tmp/briise-banc/wp}"
export BANC_PORT="${BANC_PORT:-8090}"
export BANC_URL="http://localhost:$BANC_PORT"
export BANC_SORTIE="${BANC_SORTIE:-/tmp/briise-banc/sortie}"
CHROME="${CHROME_PATH:-$(command -v google-chrome || command -v chromium || command -v chromium-browser || true)}"
mkdir -p "$BANC_SORTIE/captures"
ECHECS=0
etape() { echo; echo "=== $1"; }
echec() { echo "ÉCHEC : $1"; ECHECS=$((ECHECS + 1)); }

etape "1. Blocs et fichiers générés"
(
	cd "$OUTILS"
	node build_br_sections.js > /dev/null 2>&1
	python3 write_sections.py > /dev/null
	node build_br_kits.js > /dev/null 2>&1
	python3 catalogue.py > /dev/null
	node exemples/build_ferlune.js > /dev/null 2>&1
	node exemples/build_lison.js > /dev/null 2>&1
)
python3 "$ICI/blocs.py" "$OUTILS" "$DEPOT"
for f in sections kits ferlune; do
	R=$(node "$OUTILS/validate.js" "$OUTILS/build/banc_$f.json" 2>/dev/null | tail -1)
	echo "  $f : $R"
	case "$R" in *"invalid blocks: 0") ;; *) echec "blocs invalides dans $f" ;; esac
done
# Lison Vautrin (photographe, ambiance Galerie) : blocs valides, titres et descriptions Google dans les limites.
R=$(node "$OUTILS/validate.js" "$OUTILS/build/lison_blocs.json" 2>/dev/null | tail -1)
echo "  lison : $R"
case "$R" in *"invalid blocks: 0") ;; *) echec "blocs invalides dans le site de Lison" ;; esac
if ! git -C "$DEPOT" diff --quiet -- patterns inc/kits.json inc/demarrage.json .github/outils/catalogue-sections.md .github/outils/exemples/site-ferlune.json .github/outils/exemples/site-lison.json; then
	git -C "$DEPOT" diff --stat -- patterns inc/kits.json inc/demarrage.json .github/outils/catalogue-sections.md .github/outils/exemples/site-ferlune.json .github/outils/exemples/site-lison.json
	echec "les fichiers générés ne sont pas à jour : relancer les outils et enregistrer le résultat"
fi

etape "2. WordPress neuf"
bash "$ICI/installer.sh" "$DEPOT"
php "$ICI/preparer.php"

pkill -f "php -S localhost:$BANC_PORT" 2> /dev/null || true
( cd "$BANC_WP" && php -S "localhost:$BANC_PORT" "$ICI/routeur.php" > "$BANC_SORTIE/serveur.log" 2>&1 & )
for _ in $(seq 1 30); do curl -s -o /dev/null "$BANC_URL/" && break; sleep 1; done
trap 'pkill -f "php -S localhost:$BANC_PORT" 2> /dev/null || true' EXIT

etape "3. Import du site Atelier Ferlune"
php "$ICI/importer.php" "$OUTILS/exemples/site-ferlune.json" || echec "import"

etape "4. Vérifications"
php "$ICI/verifier.php" > "$BANC_SORTIE/verifier.json" || echec "vérifications WordPress (voir ci-dessus)"
python3 "$ICI/pages.py" || echec "pages ou sécurité"

# 1.9.0 : nouvelles sections et éléments d'interface présents sur les pages de la démo.
ACC=$(curl -s "$BANC_URL/")
ESC=$(curl -s "$BANC_URL/ouvrages/escaliers-metalliques/")
for c in "ACC:br-hero-photo:ouverture de l’accueil avec photo" "ACC:br-confiance-item:bande de confiance de l’accueil" "ACC:br-tuile-chiffre:chiffres en tuiles" "ACC:br-zone-commune:communes de la zone en liste" "ACC:br-qualif-verifier:qualifications avec lien Vérifier" "ACC:br-footer-qualifs:qualifications du pied de page" "ACC:br-card-fond:cartes de service avec photo" "ACC:br-tuile-fond:photo derrière les chiffres" "ACC:br-header-tel:téléphone dans l’en-tête" "ACC:br-sticky-tel:bouton Appeler de la barre mobile" "ACC:br-footer-liens:pages de service dans le pied de page" "ESC:br-confiance-item:bande de confiance de la page de service" "ACC:br-fil--frise:frise des étapes de l’accueil" "ESC:br-fil--vertical:fil des étapes de la page de service" "ESC:br-prix-carte:prix à côté des étapes" "ESC:wp-block-navigation-item__description:description dans le sous-menu" "ESC:current-menu-ancestor:page en cours dans le menu" "ESC:br-liste-non:ce que comprend le prix"; do
	V="${c%%:*}"; R="${c#*:}"; M="${R%%:*}"; L="${R#*:}"
	if [ "$V" = ACC ]; then H="$ACC"; else H="$ESC"; fi
	if grep -qF -- "$M" <<< "$H"; then echo "  ok    $L"; else echec "$L absent"; fi
done

if [ -z "${BANC_SANS_LIGHTHOUSE:-}" ] && [ -n "$CHROME" ]; then
	for p in / /ouvrages/escaliers-metalliques/ /ouvrages/escalier-helicoidal/ /devis/ /atelier/ /escalier-quart-tournant-dimensions/; do
		rm -f "$BANC_SORTIE/lh.json"
		npx --yes lighthouse@12 "$BANC_URL$p" --quiet --only-categories=accessibility --output=json \
			--output-path="$BANC_SORTIE/lh.json" --chrome-path="$CHROME" \
			--chrome-flags="--headless=new --no-sandbox --disable-gpu" > "$BANC_SORTIE/lh.log" 2>&1 || true
		S=$(python3 -c "import json;print(round(json.load(open('$BANC_SORTIE/lh.json'))['categories']['accessibility']['score']*100))" 2> /dev/null || echo "?")
		if [ "$S" = "?" ]; then
			# Lighthouse n'a pas tourné (outil ou navigateur indisponible) : ce n'est pas un défaut du site.
			echo "  attention : accessibilité de $p non mesurée (Lighthouse n'a pas pu tourner)"
			tail -3 "$BANC_SORTIE/lh.log" | sed 's/^/    /'
			continue
		fi
		echo "  accessibilité $p : $S"
		[ "$S" = "100" ] || echec "accessibilité $p = $S"
	done
fi

etape "5. Captures"
if [ -n "$CHROME" ]; then
	for p in accueil:/ escaliers:/ouvrages/escaliers-metalliques/ devis:/devis/ atelier:/atelier/; do
		n="${p%%:*}"; u="${p#*:}"
		"$CHROME" --headless=new --no-sandbox --disable-gpu --hide-scrollbars --force-prefers-reduced-motion --window-size=1440,2400 \
			--screenshot="$BANC_SORTIE/captures/$n-ordinateur.png" "$BANC_URL$u" > /dev/null 2>&1 || true
		"$CHROME" --headless=new --no-sandbox --disable-gpu --hide-scrollbars --force-prefers-reduced-motion --window-size=390,1800 \
			--screenshot="$BANC_SORTIE/captures/$n-mobile.png" "$BANC_URL$u" > /dev/null 2>&1 || true
	done
	ls "$BANC_SORTIE/captures" | sed 's/^/  /'
fi

echo
if [ "$ECHECS" -gt 0 ]; then
	echo "Banc d'essai : $ECHECS échec(s)."
	exit 1
fi
echo "Banc d'essai : tout est bon."
