import json
R='/home/claude/briise-theme/'
NAMES={'fond':'Fond','clair':'Fond clair (cartes)','surface':'Surface','nuance':'Nuance','texte':'Texte','texte-doux':'Texte secondaire','accent':'Accent','secondaire':'Secondaire','deco':'Décor (formes, jamais du texte)','sombre':'Fond sombre'}
ORDER=list(NAMES)
SYS="-apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif"
SERIF="Georgia, 'Times New Roman', serif"
def var(face, files, fam, fallback, weight='100 900', italic=None):
    ff=[{'fontFamily':fam,'fontStyle':'normal','fontWeight':weight,'fontDisplay':'swap','src':[f'file:./assets/fonts/{files}']}]
    if italic: ff.append({'fontFamily':fam,'fontStyle':'italic','fontWeight':weight,'fontDisplay':'swap','src':[f'file:./assets/fonts/{italic}']})
    return ff
def static(fam, files):
    return [{'fontFamily':fam,'fontStyle':st,'fontWeight':w,'fontDisplay':'swap','src':[f'file:./assets/fonts/{f}']} for f,w,st in files]
def font(slug, fam, fallback, faces):
    return {'slug':slug,'name':('Titres' if slug=='titres' else 'Texte')+' : '+fam,'fontFamily':f"'{fam}', {fallback}",'fontFace':faces}

V={
 'lumiere':dict(title='Lumière',desc='Douce et élégante : photographes, esthétique, événementiel.',
  pal=dict(fond='#faf6f2',clair='#ffffff',surface='#eee3da',nuance='#e7ebe3',texte='#2b2523',**{'texte-doux':'#66595a'},accent='#8a5444',secondaire='#56614f',deco='#d8b4a2',sombre='#2b2523'),
  fonts=[font('titres','Cormorant Garamond',SERIF,var(0,'cormorant-garamond-latin-wght-normal.woff2','Cormorant Garamond',SERIF,'300 700',italic='cormorant-garamond-latin-wght-italic.woff2')),
         font('texte','DM Sans',SYS,var(0,'dm-sans-latin-wght-normal.woff2','DM Sans',SYS,'100 1000',italic='dm-sans-latin-wght-italic.woff2'))],
  rayon=dict(grand='4px',moyen='4px',petit='2px',bouton='999px'),blob='50% 50% 0 0 / 40% 40% 0 0',
  heading={'typography':{'fontWeight':'500','lineHeight':'1.05','letterSpacing':'-0.01em'}},
  extra={'h1':{'typography':{'fontStyle':'normal'}}}),
 'atelier':dict(title='Atelier',desc='Contrastée et industrielle : bâtiment, métallerie, garages.',
  pal=dict(fond='#f1f0ec',clair='#ffffff',surface='#dddbd3',nuance='#e7e3d4',texte='#15171a',**{'texte-doux':'#474c52'},accent='#a83d0c',secondaire='#2c3a46',deco='#e86a2c',sombre='#15171a'),
  fonts=[font('titres','Barlow Condensed',SYS,static('Barlow Condensed',[('barlow-condensed-latin-600-normal.woff2','600','normal'),('barlow-condensed-latin-700-normal.woff2','700','normal')])),
         font('texte','Barlow',SYS,static('Barlow',[('barlow-latin-400-normal.woff2','400','normal'),('barlow-latin-400-italic.woff2','400','italic'),('barlow-latin-500-normal.woff2','500','normal'),('barlow-latin-600-normal.woff2','600','normal')]))],
  rayon=dict(grand='2px',moyen='2px',petit='2px',bouton='2px'),blob='0',
  heading={'typography':{'fontWeight':'700','lineHeight':'0.98','letterSpacing':'0','textTransform':'uppercase'}},
  extra={'h3':{'typography':{'textTransform':'none','letterSpacing':'0'}}}),
 'cabinet':dict(title='Cabinet',desc='Sobre et rassurante : avocats, experts-comptables, santé.',
  pal=dict(fond='#fbfbf9',clair='#ffffff',surface='#e7ecf2',nuance='#ecefe8',texte='#1a2332',**{'texte-doux':'#4b5666'},accent='#1d4f7c',secondaire='#365646',deco='#c3a46a',sombre='#142033'),
  fonts=[font('titres','Source Serif 4',SERIF,var(0,'source-serif-4-latin-wght-normal.woff2','Source Serif 4',SERIF,'200 900',italic='source-serif-4-latin-wght-italic.woff2')),
         font('texte','Source Sans 3',SYS,var(0,'source-sans-3-latin-wght-normal.woff2','Source Sans 3',SYS,'200 900',italic='source-sans-3-latin-wght-italic.woff2'))],
  rayon=dict(grand='10px',moyen='8px',petit='4px',bouton='6px'),blob='12px',
  heading={'typography':{'fontWeight':'600','lineHeight':'1.12','letterSpacing':'-0.01em'}},extra={}),
 'comptoir':dict(title='Comptoir',desc='Vive et conviviale : restaurants, commerces, loisirs.',
  pal=dict(fond='#fff8ee',clair='#ffffff',surface='#ffe2bf',nuance='#dcf0e5',texte='#2a1c13',**{'texte-doux':'#5c4738'},accent='#b5311a',secondaire='#1c6649',deco='#ffad29',sombre='#2a1c13'),
  fonts=[font('titres','Fredoka',SYS,var(0,'fredoka-latin-wght-normal.woff2','Fredoka',SYS,'300 700')),
         font('texte','Nunito',SYS,var(0,'nunito-latin-wght-normal.woff2','Nunito',SYS,'200 1000',italic='nunito-latin-wght-italic.woff2'))],
  rayon=dict(grand='28px',moyen='20px',petit='10px',bouton='999px'),blob='42% 58% 61% 39% / 47% 41% 59% 53%',
  heading={'typography':{'fontWeight':'600','lineHeight':'1.04','letterSpacing':'-0.015em'}},extra={}),
 'charte-client':dict(title='Charte du client',desc='Point de départ neutre à remplir avec la charte graphique du client.',
  pal=dict(fond='#ffffff',clair='#ffffff',surface='#f0f0f0',nuance='#f4f4f1',texte='#1a1a1a',**{'texte-doux':'#555555'},accent='#0b57d0',secondaire='#333333',deco='#cccccc',sombre='#1a1a1a'),
  fonts=[{'slug':'titres','name':'Titres : police système','fontFamily':SYS},{'slug':'texte','name':'Texte : police système','fontFamily':SYS}],
  rayon=dict(grand='12px',moyen='10px',petit='6px',bouton='8px'),blob='12px',
  heading={'typography':{'fontWeight':'700','lineHeight':'1.1','letterSpacing':'-0.02em'}},extra={}),
}
for slug,v in V.items():
    pal=[{'slug':k,'name':NAMES[k],'color':v['pal'][k]} for k in ORDER]
    els={'heading':v['heading']}; els.update(v['extra'])
    if slug in ('atelier','cabinet','comptoir'):
        els['button']={'color':{'background':'var:preset|color|accent','text':'var:preset|color|fond'},':hover':{'color':{'background':'var:preset|color|texte','text':'var:preset|color|fond'}}}
    d={'$schema':'https://schemas.wp.org/trunk/theme.json','version':3,'title':v['title'],'description':v['desc'],
       'settings':{'color':{'palette':pal},'typography':{'fontFamilies':v['fonts']},'custom':{'rayon':v['rayon'],'forme':{'blob':v['blob']}}},
       'styles':{'elements':els}}
    json.dump(d,open(R+f'styles/{slug}.json','w'),ensure_ascii=False,indent='\t'); open(R+f'styles/{slug}.json','a').write('\n')
print('ok')
