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
| `exemples/build_delaunay.js` | Fichier de site d'exemple `exemples/site-delaunay.json` (client fictif Delaunay) |
| `banc/lancer.sh` | Banc d'essai : WordPress neuf, import de Delaunay, vérifications, accessibilité, captures. Lancé par GitHub à chaque envoi et avant chaque publication |

Installation : `npm ci` dans ce dossier. Les scripts écrivent leurs fichiers de travail dans `build/` (ignoré par Git) et les fichiers du thème à leur place dans le dépôt.

Après toute modification d'une section ou d'un kit : `node build_br_sections.js && python3 write_sections.py && node build_br_kits.js && node exemples/build_delaunay.js`, puis `bash banc/lancer.sh`. Le banc échoue si les fichiers enregistrés ne correspondent pas à ce que produisent les outils.
