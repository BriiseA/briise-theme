import json,sys,glob,os
def lum(h):
    h=h.lstrip('#'); r,g,b=[int(h[i:i+2],16)/255 for i in (0,2,4)]
    f=lambda c: c/12.92 if c<=0.03928 else ((c+0.055)/1.055)**2.4
    return 0.2126*f(r)+0.7152*f(g)+0.0722*f(b)
def cr(a,b):
    la,lb=sorted([lum(a),lum(b)],reverse=True); return (la+0.05)/(lb+0.05)
PAIRS=[('texte',x,4.5) for x in ('fond','clair','surface','nuance')]+[('texte-doux',x,4.5) for x in ('fond','clair','surface')]+[('accent',x,4.5) for x in ('fond','clair')]+[('fond','accent',4.5),('fond','texte',4.5),('fond','sombre',4.5),('surface','sombre',4.5),('fond','secondaire',4.5),('secondaire','fond',4.5),('secondaire','clair',4.5),('secondaire','nuance',4.5),('sombre','surface',4.5),('texte','deco',3.0)]
def check(name,pal):
    bad=[]
    for a,b,m in PAIRS:
        r=cr(pal[a],pal[b])
        if r<m: bad.append(f'{a} sur {b}: {r:.2f} (min {m})')
    print(f"{name:22s}", 'OK' if not bad else 'ÉCHEC: '+'; '.join(bad))
    return not bad
ok=True
root=sys.argv[1] if len(sys.argv)>1 else '.'
# La palette de base (theme.json), puis celle de chaque site d'exemple : la base, avec les couleurs du client
# (clé « couleurs » du fichier de site) par-dessus.
t=json.load(open(root+'/theme.json',encoding='utf-8')); base={c['slug']:c['color'] for c in t['settings']['color']['palette']}
ok&=check('Palette de base',base)
for f in sorted(glob.glob(root+'/.github/outils/exemples/site-*.json')):
    v=json.load(open(f,encoding='utf-8'))
    if v.get('couleurs'):
        ok&=check(os.path.basename(f),{**base,**{k:c for k,c in v['couleurs'].items() if k in base}})
sys.exit(0 if ok else 1)
