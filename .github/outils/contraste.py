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
t=json.load(open(root+'/theme.json')); ok&=check('Galet (défaut)',{c['slug']:c['color'] for c in t['settings']['color']['palette']})
for f in sorted(glob.glob(root+'/styles/*.json')):
    v=json.load(open(f)); ok&=check(v['title'],{c['slug']:c['color'] for c in v['settings']['color']['palette']})
sys.exit(0 if ok else 1)
