# Outils de l'agence (hors thème)

Ces scripts fabriquent les fichiers du thème ; ils ne sont pas inclus dans `briise.zip`.

| Script | Produit |
| --- | --- |
| `build_br_sections.js` | Balisage des 40 sections (blocs générés avec `@wordpress/blocks`, donc valides) |
| `write_sections.py` | Fichiers `patterns/section-*.php` à partir des sections |
| `build_br_kits.js` | `inc/kits.json` : pages des trois kits et pages légales |
| `make_variations.py` | Ambiances `styles/*.json` |
| `contraste.py` | Vérification AA des ambiances (lancée par GitHub à chaque envoi) |
| `validate.js` | Contrôle de validité des blocs |
| `exemples/build_ferlune.js` | Fichier de site d'exemple `exemples/site-ferlune.json` (client fictif Atelier Ferlune, métallerie à Saran) |
| `parcours.json` | Les cinq parcours de départ (urgence, projet, réservation, conseil, commerce) : question du visiteur, action, ordre de l'accueil, pages |
| `variantes.json`, `registre-sites.json`, `registre.py` | Catalogue des pièces qui différencient un site, combinaison de chaque site, et contrôle anti-ressemblance (au moins 3 pièces différentes de chaque site, ouverture différente des 2 derniers) |
| `banc/lancer.sh` | Banc d'essai : WordPress neuf, import de l'Atelier Ferlune, vérifications, accessibilité, captures. Lancé par GitHub à chaque envoi et avant chaque publication |

Installation : `npm ci` dans ce dossier. Les scripts écrivent leurs fichiers de travail dans `build/` (ignoré par Git) et les fichiers du thème à leur place dans le dépôt.

Après toute modification d'une section ou d'un kit : `node build_br_sections.js && python3 write_sections.py && node build_br_kits.js && node exemples/build_ferlune.js`, puis `bash banc/lancer.sh`. Le banc échoue si les fichiers enregistrés ne correspondent pas à ce que produisent les outils.
