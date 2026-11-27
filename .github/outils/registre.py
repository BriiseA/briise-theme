#!/usr/bin/env python3
"""Vérifie qu'un nouveau site ne ressemble pas trop aux sites déjà faits.

  python3 registre.py lison                     contrôle un site du registre contre les autres
  python3 registre.py --essai entete=barre-infos ouverture=deux-portes cartes=photo-haut titres=grand-numero pied=compact angles=droits relief=bordure
                                                contrôle une combinaison avant de l'ajouter
  python3 registre.py --libres                  pièces disponibles les moins utilisées
"""
import json, sys, os
from collections import Counter
ICI = os.path.dirname(os.path.abspath(__file__))
V = json.load(open(os.path.join(ICI, 'variantes.json')))
R = json.load(open(os.path.join(ICI, 'registre-sites.json')))
PIECES = V['regles']['pieces_comparees']
MINI = V['regles']['differences_minimum']
DERNIERS = V['regles']['ouverture_differente_des_derniers']

def libres():
    for p in PIECES:
        usage = Counter(s.get(p) for s in R['sites'])
        dispo = [(n, e) for n, e in V['pieces'][p].items()]
        dispo.sort(key=lambda x: (x[1] != 'existe', usage[x[0]]))
        print(f"{p:10} " + ', '.join(f"{n}{'' if e == 'existe' else ' (à créer)'} ×{usage[n]}" for n, e in dispo))

def controle(c, autres):
    ok = True
    for p in PIECES:
        if c.get(p) not in V['pieces'][p]:
            print(f"  ? {p} = {c.get(p)!r} : absent du catalogue variantes.json"); ok = False
        elif V['pieces'][p][c[p]] != 'existe':
            print(f"  · {p} = {c[p]} : pièce encore à créer")
    for s in autres:
        diff = [p for p in PIECES if c.get(p) != s.get(p)]
        commun = [p for p in PIECES if p not in diff]
        etat = 'ok' if len(diff) >= MINI else 'TROP PROCHE'
        if len(diff) < MINI: ok = False
        print(f"  {etat:11} contre {s['nom']:10} {len(diff)} différences (en commun : {', '.join(commun) or 'rien'})")
    recents = [s['ouverture'] for s in autres[-DERNIERS:]]
    if c.get('ouverture') in recents:
        print(f"  TROP PROCHE ouverture « {c['ouverture']} » déjà utilisée par un des {DERNIERS} derniers sites"); ok = False
    print('Résultat :', 'combinaison acceptée' if ok else 'à revoir')
    return ok

a = sys.argv[1:]
if not a or a[0] == '--libres':
    libres(); sys.exit(0)
if a[0] == '--essai':
    c = dict(x.split('=', 1) for x in a[1:])
    sys.exit(0 if controle(c, R['sites']) else 1)
noms = [s['nom'] for s in R['sites']]
if a[0] not in noms:
    sys.exit(f"{a[0]} n'est pas dans le registre ({', '.join(noms)})")
i = noms.index(a[0])
sys.exit(0 if controle(R['sites'][i], R['sites'][:i]) else 1)
