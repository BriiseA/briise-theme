"""Prépare les fichiers que validate.js contrôle : sections, pages des kits, pages de Delaunay."""
import json
import pathlib
import sys

outils, depot = pathlib.Path(sys.argv[1]), pathlib.Path(sys.argv[2])
build = outils / 'build'

sections = json.load(open(build / 'br_sections.json'))
json.dump({'sections': {k: v['markup'] for k, v in sections.items()}, 'home': ''}, open(build / 'banc_sections.json', 'w'))

kits = json.load(open(depot / 'inc' / 'kits.json'))
pages = {}
for nom, kit in kits['kits'].items():
    for p in kit['pages']:
        pages[nom + '/' + p['slug']] = p['markup']
for nom, m in kits['modeles'].items():
    pages['modele/' + nom] = m['markup']
for p in kits.get('legales', []):
    if isinstance(p, dict) and 'markup' in p:
        pages['legale/' + p.get('slug', '')] = p['markup']
json.dump({'sections': pages, 'home': ''}, open(build / 'banc_kits.json', 'w'))

(build / 'banc_delaunay.json').write_text((build / 'delaunay_blocs.json').read_text())
print(f"  {len(sections)} sections, {len(pages)} pages de kits")
