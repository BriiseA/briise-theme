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

Installation : `npm install` dans ce dossier. Les chemins en tête de script sont à adapter à la machine.
