// Aperçu dans WordPress Playground, sans rien installer.
//
//   node apercu.js exemples/site-lison.json        un fichier de site : le site importé, prêt à parcourir
//   node apercu.js --catalogue                     toutes les familles et leurs versions sur une page,
//                                                  avec le choix de l'en-tête, du pied et des fonds
//   option --branche nom                           thème et extension pris sur cette branche GitHub (main par défaut)
//   option --local                                 CSS, scripts et réglages des familles pris dans ce dossier (essai avant envoi)
//   option --photos photos.json                    { "nom-de-l-image": "https://…" } : ces photos sont ajoutées à la
//                                                  Médiathèque avant l'import, sous leur nom, et prennent leur place
//
// Écrit build/apercu-<nom>.html : l'ouvrir dans un navigateur (double-clic). La page lance Playground avec
// le thème et l'extension de la branche, puis importe le fichier comme « Importer un fichier de site ».
// Les photos du client n'y sont pas : les images d'exemple du thème prennent leur place.
const fs = require('fs');
const path = require('path');

const args = process.argv.slice(2);
const branche = args.includes('--branche') ? args[args.indexOf('--branche') + 1] : 'main';
const catalogue = args.includes('--catalogue');
const photos = args.includes('--photos') ? JSON.parse(fs.readFileSync(args[args.indexOf('--photos') + 1], 'utf8')) : {};
const fichier = args.find((a, i) => !a.startsWith('--') && !['--branche', '--photos'].includes(args[i - 1]));
if (!catalogue && !fichier) {
  console.log('Usage : node apercu.js fichier-de-site.json | --catalogue [--branche nom]');
  process.exit(1);
}

const DEPOT = 'https://github.com/BriiseA/briise-theme';
const IMG_THEME = '/wp-content/themes/briise/assets/images/sections/';
const locaux = args.includes('--local') ? ['assets/css', 'assets/js'].flatMap((d) => fs.readdirSync(path.join(__dirname, '..', '..', d)).filter((n) => /.(css|js)$/.test(n)).map((n) => d + '/' + n)).concat(['inc/familles.json', 'inc/familles.php', 'theme.json']) : [];
const installer = [
  { step: 'installPlugin', pluginData: { resource: 'git:directory', url: DEPOT, ref: branche, refType: 'branch', path: 'extension/briise-socle' }, options: { activate: true, targetFolderName: 'briise-socle' } },
  { step: 'installTheme', themeData: { resource: 'git:directory', url: DEPOT, ref: branche, refType: 'branch', path: '/' }, options: { activate: true, targetFolderName: 'briise' } },
  ...locaux.map((p) => ({ step: 'writeFile', path: '/wordpress/wp-content/themes/briise/' + p, data: fs.readFileSync(path.join(__dirname, '..', '..', p), 'utf8') })),
];
const debutPhp = `<?php
require '/wordpress/wp-load.php';
wp_set_current_user( 1 );
foreach ( array( 1, 2 ) as $id ) { wp_delete_post( $id, true ); }
`;

let bp;
let nom;
if (catalogue) {
  nom = 'catalogue';
  const sec = require('./build/br_sections.json');
  const F = require('../../inc/familles.json').familles;
  const V = require('./variantes.json').pieces;
  const remplir = (m) => m.replace(/\{\{IMG:([a-z0-9-]+)\}\}/g, (_, n) => IMG_THEME + n + '.svg').replace(/\{\{URL:[^}]*\}\}/g, '#')
    .replace(/\{\{CTA_LABEL\}\}/g, 'Prendre rendez-vous').replace(/\{\{CTA\}\}/g, '#').replace(/\{\{SERVICE:(\d)\}\}/g, (_, n) => 'Service ' + n);
  const changer = (m, cls, def, v) => m.split(cls + '\\u002d\\u002d' + def).join(cls + '\\u002d\\u002d' + v)
    .split(cls + '--' + def + '"').join(cls + '--' + v + '"').split(cls + '--' + def + ' ').join(cls + '--' + v + ' ');
  const barre = 'background:#111;color:#fff;font:600 15px/1.4 system-ui,sans-serif;padding:12px 24px;margin:0;scroll-margin-top:80px';
  let contenu = '';
  const sommaire = [];
  let n = 0;
  const bloc = (id, titre, m) => { n++; contenu += `<!-- wp:html --><p id="${id}" style="${barre}">${n} · ${titre} <a href="#sommaire" style="color:#9cf;margin-left:12px;font-weight:400">sommaire ↑</a></p><!-- /wp:html -->\n` + remplir(m) + '\n'; };
  const enFamille = new Set();
  for (const [cle, fam] of Object.entries(F)) {
    const base = (sec[fam.section] || {}).markup;
    if (!base) continue;
    enFamille.add(fam.section);
    const liens = [];
    for (const [v, [lib]] of Object.entries(fam.variantes)) {
      const id = 'f-' + cle + '-' + v;
      bloc(id, fam.nom + ' : ' + lib, changer(base, fam.classe, fam.defaut, v));
      liens.push(`<a href="#${id}">${lib}</a>`);
    }
    sommaire.push(`<li><strong>${fam.nom}</strong> : ${liens.join(' · ')}</li>`);
  }
  const seules = Object.entries(sec).filter(([k]) => !enFamille.has(k));
  seules.forEach(([k, s]) => bloc('s-' + k, s.title, s.markup));
  sommaire.push(`<li><strong>Autres sections (${seules.length})</strong> : ${seules.map(([k, s]) => `<a href="#s-${k}">${s.title}</a>`).join(' · ')}</li>`);
  const pieces = (p) => Object.keys(V[p]).map((v) => `<a href="?${p}=${v}#sommaire">${v}</a>`).join(' · ');
  const fonds = fs.readFileSync(path.join(__dirname, 'apercu-fonds.html'), 'utf8');
  contenu = `<!-- wp:html --><div id="sommaire" style="font:15px/1.6 system-ui,sans-serif;max-width:1100px;margin:24px auto;padding:24px;background:#fff;color:#111;border:1px solid #ddd;border-radius:12px"><h2 style="margin:0 0 8px;font:700 22px system-ui">Catalogue des sections Briise (${n} blocs)</h2><p style="margin:0 0 12px;color:#555">Textes et images d’exemple. En bas à gauche : fonds blanc, gris, noir ou alternés.</p><ul style="margin:0 0 16px;padding-left:18px">${sommaire.join('')}</ul><p style="margin:0"><strong>En-têtes :</strong> ${pieces('entete')}</p><p style="margin:6px 0 0"><strong>Pieds de page :</strong> ${pieces('pied')}</p></div><!-- /wp:html -->\n<!-- wp:html -->${fonds}<!-- /wp:html -->\n` + contenu;
  const mu = `<?php
add_filter( 'option_briise_apparence', 'briise_apercu_pieces' );
add_filter( 'default_option_briise_apparence', 'briise_apercu_pieces' );
function briise_apercu_pieces( $o ) {
	$o = is_array( $o ) ? $o : array();
	foreach ( array( 'entete', 'pied' ) as $c ) {
		if ( ! empty( $_GET[ $c ] ) ) { $o[ $c ] = sanitize_key( $_GET[ $c ] ); }
	}
	return $o;
}
`;
  bp = { landingPage: '/catalogue/', steps: [...installer,
    { step: 'writeFile', path: '/wordpress/wp-content/mu-plugins/apercu-pieces.php', data: mu },
    { step: 'writeFile', path: '/wordpress/wp-content/catalogue.html', data: contenu },
    { step: 'runPHP', code: debutPhp + `wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Catalogue', 'post_name' => 'catalogue', 'post_content' => wp_slash( file_get_contents( WP_CONTENT_DIR . '/catalogue.html' ) ), 'page_template' => 'page-sans-titre' ) );\nupdate_option( 'blogname', 'Catalogue Briise' );\n` },
  ] };
} else {
  nom = path.basename(fichier, '.json');
  const site = JSON.parse(fs.readFileSync(fichier, 'utf8'));
  site.statut = 'publish';
  // Oublis fréquents, signalés avant l'aperçu.
  const manques = [];
  if (!site.accueil) manques.push('« accueil » (adresse de la page d’accueil) : sans elle, l’accueil affiche les articles');
  if (!site.couleurs) manques.push('« couleurs » : le site restera en noir, blanc et gris');
  if (JSON.stringify(site).includes('"ambiance"')) manques.push('« ambiance » : clé ancienne, ignorée');
  manques.forEach((m) => console.log('Attention : clé ' + m));
  bp = { landingPage: '/', steps: [...installer,
    { step: 'writeFile', path: '/wordpress/wp-content/site.json', data: JSON.stringify(site) },
    { step: 'runPHP', code: debutPhp + `require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
foreach ( json_decode( ${JSON.stringify(JSON.stringify(photos))}, true ) as $nom => $url ) {
	$tmp = download_url( $url, 60 );
	if ( ! is_wp_error( $tmp ) ) { media_handle_sideload( array( 'name' => sanitize_title( $nom ) . '.jpg', 'tmp_name' => $tmp ), 0 ); }
}
$plan = briise_plan_depuis_fichier( file_get_contents( WP_CONTENT_DIR . '/site.json' ) );
$r = is_wp_error( $plan ) ? array( 'erreur' => $plan->get_error_message() ) : briise_plan_installer( $plan );
update_option( 'briise_apercu_rapport', $r );
` },
  ] };
}
bp = { $schema: 'https://playground.wordpress.net/blueprint-schema.json', preferredVersions: { php: '8.3', wp: 'latest' }, features: { networking: true }, login: true, ...bp };

const sortie = path.join(__dirname, 'build', `apercu-${nom}.html`);
fs.mkdirSync(path.dirname(sortie), { recursive: true });
const donnees = JSON.stringify(JSON.stringify(bp)).replace(/</g, '\\u003c');
fs.writeFileSync(sortie, `<!doctype html><meta charset="utf-8"><title>Aperçu ${nom}</title>
<p style="font:16px system-ui;padding:24px">Ouverture de l’aperçu dans WordPress Playground (une à deux minutes)…</p>
<script>location.href = 'https://playground.wordpress.net/#' + encodeURIComponent(${donnees});</script>
`);
console.log('Aperçu :', sortie, '(' + Math.round(fs.statSync(sortie).size / 1024) + ' Ko, branche ' + branche + ')');
