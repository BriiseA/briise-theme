# Outils de l'agence (hors thème)

Ces scripts fabriquent les fichiers du thème ; ils ne sont pas inclus dans `briise.zip`.

| Script | Produit |
| --- | --- |
| `build_br_sections.js` | Balisage des sections (83 aujourd’hui) (blocs générés avec `@wordpress/blocks`, donc valides) |
| `write_sections.py` | Fichiers `patterns/section-*.php` à partir des sections |
| `build_br_kits.js` | `inc/demarrage.json` : site de base et ouvertures ; `inc/kits.json` : modèles de page, pages légales ; fonction `rythme()` pour les fichiers de site |
| `catalogue.py` | `catalogue-sections.md` : chaque section, à quoi elle sert, ce dont elle a besoin |
| `parcours.json` | Grille des questions du visiteur (réflexion, pas un kit) |
| `contraste.py` | Vérification AA de la palette de base et des couleurs de chaque site d'exemple (lancée par GitHub à chaque envoi) |
| `validate.js` | Contrôle de validité des blocs |
| `exemples/build_lison.js` | Fichier de site d'exemple `exemples/site-lison.json` (cliente fictive Lison Vautrin, photographe à Olivet) |
| `exemples/build_briise.js` | Fichier du site de l'agence `exemples/site-briise.json` |
| `parcours.json` | Les cinq parcours de départ (urgence, projet, réservation, conseil, commerce) : question du visiteur, action, ordre de l'accueil, pages |
| `variantes.json`, `registre-sites.json`, `registre.py` | Catalogue des pièces qui différencient un site, combinaison de chaque site, et contrôle anti-ressemblance (au moins 3 pièces différentes de chaque site, ouverture différente des 2 derniers) |
| `apercu.js` | Aperçu dans WordPress Playground, sans rien installer : `node apercu.js site-client.json` (le site du client importé) ou `node apercu.js --catalogue` (toutes les sections et leurs versions, choix de l'en-tête, du pied et des fonds). Écrit `build/apercu-….html`, à ouvrir dans un navigateur. `--branche nom` pour essayer une branche |
| `methode/nouveau-site-briise/SKILL.md` | La méthode de création d'un site client (compétence de Claude), tenue à jour avec le thème. Après une modification, la téléverser dans claude.ai (Réglages > Capacités > Compétences) |
| `banc/lancer.sh` | Banc d'essai : WordPress neuf, import du site de Lison Vautrin, vérifications, accessibilité, captures. Lancé par GitHub à chaque envoi et avant chaque publication |

Installation : `npm ci` dans ce dossier. Les scripts écrivent leurs fichiers de travail dans `build/` (ignoré par Git) et les fichiers du thème à leur place dans le dépôt.

Après toute modification d'une section : `node build_br_sections.js && python3 write_sections.py && node build_br_kits.js && python3 catalogue.py && node exemples/build_lison.js`, puis `bash banc/lancer.sh`. Le banc échoue si les fichiers enregistrés ne correspondent pas à ce que produisent les outils.
