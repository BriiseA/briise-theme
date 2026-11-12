import json,re
R='/home/claude/briise-theme/'
d=json.load(open('/home/claude/validate/br_sections.json'))
CATS={'ouverture':'Ouverture','offre':'Offre','confiance':'Confiance','parcours':'Parcours','personnes':'Personnes','contenu':'Contenu','contact':'Contact'}
for slug,s in d.items():
    m=s['markup']
    m=re.sub(r'\{\{IMG:([a-z0-9-]+)\}\}',lambda x:"<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/%s.svg' ) ); ?>"%x.group(1),m)
    m=m.replace('{{CTA_LABEL}}',"<?php echo esc_html( $briise['cta_label'] ); ?>").replace('{{CTA}}',"<?php echo esc_url( $briise['cta_url'] ); ?>")
    m=re.sub(r'\{\{SERVICE:(\d)\}\}',lambda x:['Premier','Deuxième','Troisième','Quatrième','Cinquième','Sixième'][int(x.group(1))-1]+' service',m)
    m=re.sub(r'\{\{URL:service-\d\}\}','{{URL:services}}',m)
    m=re.sub(r'\{\{URL:([a-z0-9-]*)\}\}',lambda x:"<?php echo esc_url( home_url( '/%s' ) ); ?>"%(x.group(1)+'/' if x.group(1) else ''),m)
    head=f"""<?php
/**
 * Title: {CATS[s['cat']]} : {s['title']}
 * Slug: briise/{slug}
 * Categories: briise-{s['cat']}
 * Description: {s['desc']}
 * Viewport Width: 1400
 */
$briise = briise_entreprise();
?>
"""
    open(R+f'patterns/section-{slug}.php','w').write(head+m+'\n')
print(len(d))
