// Bibliothèque de sections Briise : génère le balisage des blocs (valide par construction).
require('./validate_env.js');
const { createBlock: cb, serialize } = require('@wordpress/blocks');
require('@wordpress/block-library').registerCoreBlocks();

const NB = ' ';
const fr = (s) => s
  .replace(/ ([?!:;»%€])/g, NB + '$1')
  .replace(/« /g, '«' + NB)
  .replace(/(\d) (h\b|min\b|ans\b|km\b|heures\b|jours\b|mois\b|m²)/g, '$1 $2')
  .replace(/(\d) (\d{3})/g, '$1 $2')
  .replace(/'/g, '’');

const IMG = (n) => `{{IMG:${n}}}`;
const CTA = '{{CTA}}';
const CTA_LABEL = '{{CTA_LABEL}}';
const URL = (s) => `{{URL:${s}}}`;

const P = (t, cls, extra = {}) => cb('core/paragraph', { content: fr(t), ...(cls ? { className: cls } : {}), ...extra });
const H = (t, level = 2, cls, extra = {}) => cb('core/heading', { content: fr(t), level, ...(cls ? { className: cls } : {}), ...extra });
const Label = (t) => P(t, 'br-label');
const Lead = (t) => P(t, 'br-lead');
const Muted = (t) => P(t, 'br-muted');
const Img = (name, ratio = '4/3', cls = 'is-style-br-arrondi', alt = 'Photo à remplacer : décrivez ce qu’elle montre') =>
  cb('core/image', { url: IMG(name), alt: fr(alt), aspectRatio: ratio, scale: 'cover', sizeSlug: 'full', linkDestination: 'none', className: cls });
/* Photo de fond d'une tuile ou d'une carte : un bloc image ordinaire, que le client remplace ou retire. Sans elle, la tuile garde son aspect simple. */
const ImgFond = (name, cls, alt) => cb('core/image', { url: IMG(name), alt: fr(alt || 'Photo à remplacer : décrivez ce qu’elle montre'), sizeSlug: 'large', linkDestination: 'none', className: cls });
const Btn = (text, url, cls, extra = {}) => cb('core/button', { text: text === CTA_LABEL ? text : fr(text), url, ...(cls ? { className: cls } : {}), ...extra });
const Btns = (...b) => cb('core/buttons', {}, b);
const MainBtns = (second) => Btns(Btn(CTA_LABEL, CTA), ...(second ? [Btn(second[0], second[1], 'is-style-outline')] : []));
const Section = (cls, inner, extra = {}) => cb('core/group', { align: 'full', className: ('br-section ' + (cls || '')).trim(), layout: { type: 'constrained' }, ...extra }, inner);
const Box = (cls, inner, extra = {}) => cb('core/group', { className: cls, layout: { type: 'default' }, ...extra }, inner);
const Row = (cls, inner) => cb('core/group', { className: cls, layout: { type: 'flex', flexWrap: 'wrap', justifyContent: 'space-between', verticalAlignment: 'bottom' } }, inner);
const Chips = (items) => cb('core/group', { className: 'br-chips', layout: { type: 'flex', flexWrap: 'wrap' } }, items.map((i) => P(i, 'br-chip')));
const Cols = (cols, cls, extra = {}) => cb('core/columns', { ...(cls ? { className: cls } : {}), ...extra }, cols);
const Col = (inner, extra = {}) => cb('core/column', extra, inner);
const List = (items, cls = 'is-style-br-tirets') => cb('core/list', { className: cls }, items.map((i) => cb('core/list-item', { content: fr(i) })));
const Arrow = (t, url) => P(`<a href="${url}">${fr(t)}</a>`, 'br-arrow');
const Details = (q, a) => cb('core/details', { summary: fr(q) }, [P(a)]);
const Short = (code) => cb('core/shortcode', { text: code });
const Table = (head, rows, cls = 'br-table') => cb('core/table', {
  className: cls, hasFixedLayout: false,
  head: [{ cells: head.map((c) => ({ content: fr(c), tag: 'th' })) }],
  body: rows.map((r) => ({ cells: r.map((c) => ({ content: fr(c), tag: 'td' })) })),
});
const Head = (inner) => Box('br-head', inner);
const sectionHead = (title, link) => Row('br-section-head', [H(title, 2), ...(link ? [Arrow(link[0], link[1])] : [])]);
const Num = (n) => P(n, 'br-num');

const S = {};
const add = (slug, cat, title, desc, blocks) => { const b = Array.isArray(blocks) ? blocks : [blocks]; S[slug] = { cat, title, desc, blocks: b, markup: serialize(b) }; };

/* ----- Ouverture ----- */

/* En-têtes de page : la photo est l'image mise en avant de la page, affichée à sa taille réelle (nette dès 1 400 px). */
const FeatImg = (ratio = '4/3', cls = 'br-tete-media') => cb('core/post-featured-image', { aspectRatio: ratio, scale: 'cover', sizeSlug: 'full', className: cls });
const teteTexte = (titre, chapo, bouton = CTA_LABEL) => [Short('[briise_fil_ariane]'), H(titre, 1, null, { fontSize: 'huge' }), Lead(chapo), ...(bouton ? [Btns(Btn(bouton, CTA))] : [])];
const teteSplit = (titre, chapo, bouton) => Section('br-tete br-tete-split', [Cols([
  Col(teteTexte(titre, chapo, bouton), { verticalAlignment: 'center', width: '52%' }),
  Col([FeatImg()], { verticalAlignment: 'center', width: '48%' }),
], 'br-split', { verticalAlignment: 'center' })]);
const teteMosaique = (titre, chapo, bouton, imgs = [['carre-2', 'Photo à remplacer : un détail de l’ouvrage'], ['carre-3', 'Photo à remplacer : une autre réalisation']]) => Section('br-tete br-tete-mosaique', [Cols([
  Col(teteTexte(titre, chapo, bouton), { verticalAlignment: 'center', width: '46%' }),
  Col([Box('br-mosaique-tete', [FeatImg('4/5', 'br-tete-media'), ...imgs.map(([n, alt]) => Img(n, '1/1', 'br-mosaique-img', alt))])], { verticalAlignment: 'center', width: '54%' }),
], 'br-split', { verticalAlignment: 'center' })]);

add('en-tete-photo', 'ouverture', 'En-tête de page avec photo', 'Pages de service, à propos : titre et introduction à gauche, photo nette à droite. La photo est l’image mise en avant de la page (1 400 px de large au moins) ; sans elle, le texte prend toute la largeur.',
  teteSplit('Le titre de la page', 'Une ou deux phrases : ce que c’est, pour qui, le prix de départ et le délai.', CTA_LABEL));

add('en-tete-mosaique', 'ouverture', 'En-tête de page avec trois photos', 'Variante quand vous avez trois bonnes photos : titre à gauche, mosaïque à droite. La grande photo est l’image mise en avant de la page ; les deux petites se remplacent d’un clic.',
  teteMosaique('Le titre de la page', 'Une ou deux phrases : ce que c’est, pour qui, le prix de départ et le délai.', CTA_LABEL));

add('en-tete-bandeau', 'ouverture', 'En-tête bandeau photo pleine largeur', 'Photo de la page en bandeau sur toute la largeur, texte posé dessus. Réservé aux très grandes photos (2 400 px de large au moins) : sinon, préférer l’en-tête avec photo à côté.',
  cb('core/cover', {
    useFeaturedImage: true, dimRatio: 100, overlayColor: 'sombre', isUserOverlayColor: true, minHeight: 420, minHeightUnit: 'px',
    contentPosition: 'center left', align: 'full', className: 'br-banniere br-tete-photo', layout: { type: 'constrained' },
  }, [
    Box('br-banniere-inner', [
      Short('[briise_fil_ariane]'),
      H('Le titre de la page', 1, null, { fontSize: 'huge' }),
      Lead('Une ou deux phrases qui posent le sujet de la page et la réponse que le visiteur y trouvera.'),
      MainBtns(),
    ]),
  ]));

add('en-tete-page', 'ouverture', 'En-tête de page avec fil d’Ariane', 'Pour toutes les pages intérieures : fil d’Ariane automatique, titre, introduction et bouton d’action.',
  Section('br-page-head', [Head([
    Short('[briise_fil_ariane]'),
    H('Le titre de la page', 1, null, { fontSize: 'huge' }),
    Lead('Une ou deux phrases qui posent le sujet de la page et la réponse que le visiteur y trouvera.'),
    MainBtns(),
  ])]));

/* 1.9.0 : ouverture de l'accueil avec photo et étiquettes, bande de confiance, tuiles, schéma de zone. */
const Mark = (t) => `<mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-accent-color">${t}</mark>`;
const heroPhoto = ({ pastille, titre, accent, chapo, second, coches = [], img = 'portrait', alt, etiquettes = [] }) => Section('br-hero br-hero-photo', [Cols([
  Col([P(pastille, 'br-pastille'), H(titre + ' ' + Mark(accent), 1, null, { fontSize: 'huge' }), Lead(chapo), MainBtns(second), ...(coches.length ? [List(coches, 'br-coches')] : [])], { verticalAlignment: 'center', width: '52%' }),
  Col([Box('br-hero-media', [Img(img, '1/1', 'br-hero-img', alt), ...etiquettes.map(([petit, grand], i) => Box('br-etiquette-photo br-etiquette-photo--' + (i + 1), [P(petit, 'br-etiquette-petit'), P(grand, 'br-etiquette-grand')]))])], { verticalAlignment: 'center', width: '48%' }),
], 'br-split', { verticalAlignment: 'center' })], { backgroundColor: 'surface' });
const confiance = (items) => cb('core/group', { align: 'full', className: 'br-confiance-zone', layout: { type: 'default' } }, [
  cb('core/group', { className: 'br-confiance', layout: { type: 'default' } }, items.map(([ic, t, s]) => Box('br-confiance-item is-icone-' + ic, [P(t, 'br-confiance-titre'), P(s, 'br-confiance-sous')]))),
]);
const tuiles = (label, titre, items, chapo, apres = []) => Section('br-tuiles-section', [Head([Label(label), H(titre, 2), ...(chapo ? [Lead(chapo)] : [])]),
  Box('br-tuiles', items.map(([v, c, t, img, alt]) => Box('br-tuile' + (v ? ' ' + v.split(' ').map((x) => 'br-tuile--' + x).join(' ') : ''), [
    ...(img ? [ImgFond(img, 'br-tuile-fond', alt)] : []), P(c, 'br-tuile-chiffre'), P(t, 'br-tuile-texte')]))), ...apres]);
/* Zone d'intervention en liste : communes groupées par distance, calculée depuis Mon entreprise. */
const zoneListe = (label, titre, chapo, lien) => Section('br-zone-liste-section', [Cols([
  Col([Label(label), H(titre, 2), Lead(chapo), ...(lien ? [Arrow(lien[0], lien[1])] : [])], { width: '42%' }),
  Col([Short('[briise_zone_liste]')], { width: '58%' }),
], 'br-etapes-cols')]);
/* Qualifications : une ligne de logos avec le lien « Vérifier ». */
const qualifs = (titre = 'Qualifié et assuré') => Section('br-qualifs-section', [Short(`[briise_qualifications titre="${titre}"]`)]);
const zoneSchema = (label, titre, chapo, lien) => Section('br-zone-schema', [Cols([
  Col([Label(label), H(titre, 2), Lead(chapo), ...(lien ? [Arrow(lien[0], lien[1])] : [])], { verticalAlignment: 'center', width: '44%' }),
  Col([Short('[briise_zone_schema]')], { verticalAlignment: 'center', width: '56%' }),
], 'br-split', { verticalAlignment: 'center' })]);

add('bande-confiance', 'confiance', 'Bande de confiance', 'Juste sous l’ouverture, une carte qui chevauche la section du dessus : quatre garanties réelles avec leur icône. L’icône se change dans Avancé > Classes CSS : is-icone-garantie, is-icone-plan, is-icone-atelier, is-icone-avis, is-icone-delai, is-icone-prix, is-icone-local, is-icone-devis, is-icone-equipe.',
  confiance([['garantie', 'Garantie décennale', 'Attestation jointe au devis'], ['devis', 'Devis gratuit', 'Sous 5 jours ouvrés'], ['local', 'Une équipe locale', 'À votre ville et alentour'], ['avis', 'Note Google', 'À n’afficher que si elle est réelle']]));

add('zone-liste', 'contact', 'Zone d’intervention en liste', 'Les communes où vous intervenez, groupées par distance (moins de 10 km, 10 à 20 km…), puis une invitation à appeler. Les distances se calculent seules à partir de Mon entreprise > Entreprise > Communes du schéma de zone (nom ; latitude ; longitude, votre adresse en premier).',
  zoneListe('Zone d’intervention', 'Nous intervenons à 30 km autour de votre ville', 'Les secteurs où vous travaillez, en une phrase. La visite ou le devis sont-ils gratuits partout ?', ['Toutes les communes où nous intervenons', URL('zone-intervention')]));

add('qualifications', 'confiance', 'Qualifications et assurances', 'Une ligne discrète : le logo de chaque qualification (Qualibat, RGE, décennale…), une précision et le lien « Vérifier » vers l’annuaire officiel. Se remplit dans Mon entreprise > Entreprise ; une qualification périmée disparaît seule. Rien ne s’affiche si la fonction est coupée.',
  qualifs());

/* ----- Offre ----- */

// {{SERVICE:n}} : nom du n-ième service du client, {{URL:service-n}} : sa page (remplis à l'installation).
// Les anciennes « Trois cartes de service » (avec ou sans photos) sont devenues la famille Services ci-dessous.

/* ----- Familles de sections : un même contenu, plusieurs versions ------------------------
   La version est une classe de la section (br-services--bento…), choisie dans l'éditeur
   (panneau « Version », inc/familles.php) ou écrite dans le fichier de site. Le CSS est dans
   assets/css/familles.css, les onglets et les flèches dans assets/js/familles.js. */

// Services : une photo, le nom, deux phrases et le lien vers la page, pour chaque service.
const PHOTOS_SERVICES = ['paysage', 'portrait', 'carre', 'paysage-2', 'carre-2', 'carre-3'];
const PhotoService = (name, alt) => cb('core/image', { url: IMG(name), alt: fr(alt || 'Photo à remplacer : une réalisation de ce service'), sizeSlug: 'large', linkDestination: 'none', className: 'br-service-photo' });
const serviceItem = (n, o = {}) => Box('br-service', [
  PhotoService(o.img || PHOTOS_SERVICES[(n - 1) % PHOTOS_SERVICES.length], o.alt),
  Box('br-service-texte', [
    Num(String(n).padStart(2, '0')),
    H(o.nom || `{{SERVICE:${n}}}`, 3, 'br-service-nom'),
    Muted(o.texte || 'Deux phrases : pour qui est ce service, et ce qu’il change pour le client.'),
    Arrow(o.lien ? o.lien[0] : `{{SERVICE:${n}}} en détail`, o.lien ? o.lien[1] : URL(`service-${n}`)),
  ]),
]);
const VERSIONS_SERVICES = ['grille', 'bento', 'liste', 'phare', 'defile', 'onglets', 'volets'];
// La phrase d'introduction (chapo) est facultative : retirez-la, le titre reste correct seul.
// position : la place du titre (br-titre--centre…, voir inc/familles.php) ; vide = selon le site.
const services = ({ version = 'grille', titre = 'Ce que nous faisons', chapo = 'Une phrase qui présente vos services : pour qui ils sont faits, et où vous intervenez.', lien = ['Tous nos services', URL('services')], items = 4, bg = 'surface', position = 'cote' } = {}) =>
  Section(`br-services br-services--${version}${position ? ' br-titre--' + position : ''}`, [
    Row('br-section-head', [H(titre, 2), ...(chapo ? [Lead(chapo)] : []), ...(lien ? [Arrow(lien[0], lien[1])] : [])]),
    Box('br-services-liste', (Array.isArray(items) ? items : Array.from({ length: items }, () => ({}))).map((o, i) => serviceItem(i + 1, o))),
  ], bg ? { backgroundColor: bg } : {});

add('services', 'offre', 'Services (7 versions)', 'Vos services, chacun avec sa photo, son nom, deux phrases et le lien vers sa page. Choisissez la forme dans le panneau « Version » de la section : grille, grille asymétrique, liste en deux colonnes, service phare, défilement, onglets ou volets ; et la place du titre dans le panneau « Titre ». Le texte et les photos restent en place quand vous changez de version. Retirez ou dupliquez un service : chaque version s’adapte de 3 à 6 services.',
  services());

// Ouverture : pastille, grand titre (un mot surligné), phrase, bouton d'action et second bouton,
// trois atouts, et les photos. Les versions autres que « diaporama » n'affichent que la première photo.
// Une vidéo (bloc Vidéo) peut remplacer la photo dans n'importe quelle version.
const PHOTOS_OUVERTURE = ['banniere', 'paysage', 'paysage-2', 'carre'];
const PhotoOuverture = (name, alt) => cb('core/image', { url: IMG(name), alt: fr(alt || 'Photo à remplacer : votre meilleure réalisation, ou vous au travail'), sizeSlug: 'full', linkDestination: 'none', className: 'br-ouv-photo' });
const VERSIONS_OUVERTURE = ['cote', 'banniere', 'biais', 'moitie', 'arche', 'geant', 'diaporama', 'tuiles', 'mots', 'agrandi'];
// Petite photo glissée dans le titre (version « mots ») ; décorative, masquée dans les autres versions.
const PhotoMot = (name) => `<img class="br-mot-photo" src="${IMG(name)}" alt=""/>`;
const titreOuverture = (titre, motsPhotos) => {
  if (!motsPhotos.length) return titre;
  const mots = titre.split(' ');
  const coupe = Math.min(3, mots.length - 1);
  return mots.slice(0, coupe).join(' ') + ' ' + PhotoMot(motsPhotos[0]) + ' ' + mots.slice(coupe).join(' ') + (motsPhotos[1] ? ' ' + PhotoMot(motsPhotos[1]) : '');
};
// Options : infos = la carte d'infos réelles posée sur la photo (horaires du jour, prochaine date libre,
// ville : rien ne s'affiche sans données) ; bande = les services en grand, sur une bande qui défile
// (true : les quatre premiers services du client ; ou une liste de noms).
const ouverture = ({ version = 'cote', pastille = 'Votre métier · Votre ville', titre = 'Le titre qui dit ce que vous faites,', accent = 'et où', chapo = 'Une ou deux phrases : pour qui, ce qui vous distingue, et ce que le visiteur gagne à vous appeler.', second = ['Voir nos réalisations', URL('realisations')], atouts = ['Devis gratuit', 'Votre délai de réponse', 'Votre garantie'], photos = PHOTOS_OUVERTURE, motsPhotos = ['paysage', 'paysage-2'], infos = true, bande = false } = {}) => {
  const noms = bande === true ? [1, 2, 3, 4].map((n) => `{{SERVICE:${n}}}`) : (bande || []);
  return Section(`br-hero br-ouverture br-ouverture--${version}`, [
    Box('br-ouv-grille', [
      Box('br-ouv-texte', [
        P(pastille, 'br-pastille'),
        H(titreOuverture(titre, motsPhotos) + (accent ? ' ' + Mark(accent) : ''), 1, null, { fontSize: 'huge' }),
        Lead(chapo),
        MainBtns(second),
        ...(atouts.length ? [List(atouts, 'br-coches')] : []),
      ]),
      Box('br-ouv-media', [
        ...photos.map((p) => (Array.isArray(p) ? PhotoOuverture(p[0], p[1]) : PhotoOuverture(p))),
        ...(infos ? [Short('[briise_infos_ouverture]')] : []),
      ]),
    ]),
    ...(noms.length ? [cb('core/group', { align: 'full', className: 'br-defile br-defile--services', layout: { type: 'default' } }, [
      cb('core/group', { className: 'br-defile-piste', layout: { type: 'flex', flexWrap: 'wrap' } }, noms.map((t) => P(t, 'br-defile-item'))),
    ])] : []),
  ]);
};

add('ouverture', 'ouverture', 'Ouverture (10 versions)', 'Le haut de l’accueil : pastille, grand titre, phrase, bouton d’action et second bouton, trois atouts, et vos photos. Choisissez la forme dans le panneau « Version » : photo à côté, bannière plein écran, photo coupée en biais, moitié-moitié, arche, titre géant, diaporama, mosaïque en tuiles, titre avec photos ou photo qui s’agrandit. Le diaporama fait défiler en fondu les quatre photos ; la mosaïque en montre trois ; les autres versions, la première. Une carte d’infos se pose sur la photo : ouvert aujourd’hui, prochaine date libre (Horaires et annonces) et votre ville ; sans ces données, elle ne s’affiche pas. Une vidéo courte (bloc Vidéo, sans son) peut remplacer la photo : elle joue en boucle, avec un bouton pause.',
  ouverture());
add('ouverture-bande', 'ouverture', 'Ouverture avec bande de services', 'La même ouverture, avec en bas vos services en grand sur une bande qui défile doucement (pause au survol, au clavier ou avec le bouton). Les noms viennent de vos pages de service : vérifiez qu’il y en a au moins quatre, ou retirez les noms en trop.',
  ouverture({ version: 'banniere', bande: true }));

const bloc = (titre) => [
  Label('Service'), H(titre, 2),
  P('Décrivez le service concrètement : comment il se déroule, combien de temps il prend, ce que le client obtient à la fin.'),
  List(['Un bénéfice précis', 'Un deuxième bénéfice', 'Une garantie ou un engagement']),
  Arrow('Demander un devis pour ce service', CTA),
];
/* Pages de service, dans l'ordre du récit : bénéfices, choix du modèle, déroulé et prix. Toujours avec des photos. */
const benefices = (titre, items, label = 'Ce que ça change chez vous') => Section('br-benefices', [
  Head([Label(label), H(titre, 2)]),
  Cols(items.map(([img, alt, t, d]) => Col([Box('br-benefice', [Img(img, '4/3', 'is-style-br-arrondi', alt), H(t, 3), Muted(d)])]))),
]);
const modeles = (titre, intro, items, apres = [], label = 'Quel modèle choisir ?') => Section('br-modeles', [
  Head([Label(label), H(titre, 2), ...(intro ? [Lead(intro)] : [])]),
  Cols(items.map(([img, alt, t, faits]) => Col([Box('br-modele', [Img(img, '4/3', 'is-style-br-arrondi', alt), H(t, 3), ...faits.map(([k, v]) => P(`<strong>${k}</strong>${v}`, 'br-modele-fait'))])])), 'br-modeles-grille'),
  ...apres,
], { backgroundColor: 'surface' });
const etapesPhotos = (titre, items, apres = [], label = 'Comment ça se passe') => Section('br-etapes-photos', [
  Head([Label(label), H(titre, 2)]),
  Cols(items.map(([img, alt, t, d], i) => Col([Box('br-etape', [Img(img, '4/3', 'is-style-br-arrondi', alt), Num(String(i + 1)), H(t, 3), Muted(d)])])), 'br-steps'),
  ...apres,
], { backgroundColor: 'nuance' });

/* Étapes sans photo : un fil qui se remplit au défilement (motion.js).
   items : [titre, texte, durée facultative]. */
const filEtape = ([t, d, duree], i) => Box('br-fil-etape', [P(String(i + 1), 'br-fil-num'), H(t, 3), P(d, 'br-fil-texte'), ...(duree ? [P(duree, 'br-duree')] : [])]);
const etapesFrise = (titre, items, apres = [], label = 'Comment ça se passe', bg = 'nuance') => Section('br-etapes', [
  Head([Label(label), H(titre, 2)]),
  Box('br-fil br-fil--frise', items.map(filEtape)),
  ...apres,
], { backgroundColor: bg });
const etapesFil = (titre, items, cote = [], label = 'Comment ça se passe', bg = 'fond') => Section('br-etapes br-etapes-fil', [
  Cols([
    Col([Box('br-etapes-cote', [Label(label), H(titre, 2), ...cote])], { width: '42%' }),
    Col([Box('br-fil br-fil--vertical', items.map(filEtape))], { width: '58%' }),
  ], 'br-etapes-cols'),
], { backgroundColor: bg });
const prixCarte = (rows, note, head = ['Ouvrage', 'Prix posé TTC']) => Box('br-prix-carte', [Table(head, rows), Muted(note)]);
/* Ce que comprend le prix : deux listes courtes, compris et non compris. */
const compris = (oui, non = []) => Box('br-compris', [
  P('Compris dans le prix', 'br-compris-titre'), List(oui, 'br-liste-oui'),
  ...(non.length ? [P('Non compris', 'br-compris-titre is-non'), List(non, 'br-liste-non')] : []),
]);

add('benefices-photos', 'offre', 'Ce que ça change, en photos', 'Pages de service : trois bénéfices concrets pour le client, chacun avec sa photo. Ce qu’il y gagne, pas une liste de caractéristiques.',
  benefices('Ce que votre client y gagne', [
    ['carre', 'Photo à remplacer : le bénéfice en situation', 'Premier bénéfice', 'Ce que le client gagne concrètement, avec ses mots : plus de place, plus de lumière, moins d’entretien.'],
    ['carre-2', 'Photo à remplacer : le bénéfice en situation', 'Deuxième bénéfice', 'Une phrase ou deux, avec un fait précis plutôt qu’un adjectif.'],
    ['carre-3', 'Photo à remplacer : le bénéfice en situation', 'Troisième bénéfice', 'Ce qui rassure : délai, garantie, sur-mesure, propreté du chantier.'],
  ]));

add('modeles-cartes', 'offre', 'Quel modèle choisir, en cartes', 'Une carte par modèle ou par option, avec sa photo, sa place, son prix, pour qui il est fait et ses limites. Lisible sur mobile, plus parlant qu’un tableau.',
  modeles('Quel modèle pour votre projet ?', 'Une phrase qui dit de quoi dépend le bon choix : la place, l’usage, le budget.', [
    ['carre', 'Photo à remplacer : le premier modèle', 'Premier modèle', [['Idéal pour : ', 'la situation où il convient le mieux.'], ['Prix : ', 'à partir de… €.'], ['À savoir : ', 'sa limite, dite franchement.']]],
    ['carre-2', 'Photo à remplacer : le deuxième modèle', 'Deuxième modèle', [['Idéal pour : ', 'la situation où il convient le mieux.'], ['Prix : ', 'à partir de… €.'], ['À savoir : ', 'sa limite, dite franchement.']]],
    ['carre-3', 'Photo à remplacer : le troisième modèle', 'Troisième modèle', [['Idéal pour : ', 'la situation où il convient le mieux.'], ['Prix : ', 'à partir de… €.'], ['À savoir : ', 'sa limite, dite franchement.']]],
  ], [Arrow('Vous hésitez ? Nous vous conseillons gratuitement', CTA)]));

add('etapes-photos', 'parcours', 'Déroulé et prix, en photos', 'Comment ça se passe, de la visite à la fin du chantier, chaque étape avec sa photo, puis le prix et ce qui le fait varier.',
  etapesPhotos('De la première visite à la fin du chantier', [
    ['carre', 'Photo à remplacer : la visite', 'La visite', 'Ce qui se passe au premier rendez-vous, et qui vient.'],
    ['carre-2', 'Photo à remplacer : le devis', 'Le devis', 'Sous quel délai, avec quoi (plan, échantillons).'],
    ['carre-3', 'Photo à remplacer : la fabrication ou la préparation', 'La préparation', 'Combien de temps, où, par qui.'],
    ['carre', 'Photo à remplacer : la pose ou la livraison', 'La fin du chantier', 'Durée, propreté, ce que le client reçoit.'],
  ], [Table(['Prestation', 'Prix TTC'], [['Prestation la plus courante', 'À partir de… €'], ['Option fréquente', '+ … €']]), Muted('Ce qui fait varier le prix, en une phrase. Le prix exact figure sur le devis.')]));

add('service-alterne', 'offre', 'Service détaillé, image et texte alternés', 'Pages de service : chaque service avec sa photo, en alternance gauche et droite.',
  Section('', [
    Cols([Col([Img('paysage', '4/3')], { width: '50%' }), Col(bloc('Premier service'), { width: '50%', verticalAlignment: 'center' })], 'br-split', { verticalAlignment: 'center' }),
    Cols([Col(bloc('Deuxième service'), { width: '50%', verticalAlignment: 'center' }), Col([Img('paysage-2', '4/3')], { width: '50%' })], 'br-split br-alterne', { verticalAlignment: 'center' }),
  ]));

add('tableau-comparatif', 'offre', 'Tableau comparatif', 'Aider à choisir entre deux ou trois formules.',
  Section('', [
    Head([Label('Comparer'), H('Quelle formule vous convient ?', 2), Lead('Les différences essentielles, en un coup d’œil.')]),
    Table(['Critère', 'Formule essentielle', 'Formule complète'], [
      ['Pour qui', 'Un besoin ponctuel', 'Un accompagnement suivi'],
      ['Durée', '1 heure', '3 mois'],
      ['Suivi', '—', 'Un point par mois'],
      ['Tarif', '60 €', '450 €'],
    ]),
    MainBtns(),
  ]));

const tarif = (nom, prix, vedette) => Col([Box('br-card br-price' + (vedette ? ' br-price--vedette' : ''), [
  ...(vedette ? [P('Le plus choisi', 'br-chip')] : []),
  H(nom, 3), P(prix, 'br-stat'), Muted('Une phrase sur ce que comprend cette formule.'),
  List(['Ce qui est inclus', 'Un deuxième élément', 'Un troisième élément']),
  Btns(Btn('Choisir cette formule', CTA, vedette ? null : 'is-style-outline')),
])]);
add('tarifs-cartes', 'offre', 'Grille de tarifs en cartes', 'Deux à quatre formules avec leur prix ; celle du milieu est mise en avant.',
  Section('', [
    Head([Label('Tarifs'), H('Des prix clairs, sans surprise', 2)]),
    Cols([tarif('Découverte', '40 €'), tarif('Régulière', '90 €', true), tarif('Intensive', '160 €')], 'br-prices'),
  ], { backgroundColor: 'nuance' }));

add('tarifs-tableau', 'offre', 'Tableau de tarifs simple', 'Pour une liste de prestations nombreuses : une ligne par prestation.',
  Section('', [
    Head([Label('Tarifs'), H('Nos prestations et leurs prix', 2)]),
    Table(['Prestation', 'Durée', 'Prix'], [
      ['Première prestation', '30 min', '25 €'], ['Deuxième prestation', '1 h', '45 €'],
      ['Troisième prestation', '1 h 30', '65 €'], ['Forfait de quatre séances', '4 × 1 h', '160 €'],
    ]),
    Muted('Prix TTC. Une précision utile : moyens de paiement acceptés, conditions d’annulation.'),
  ]));

/* ----- Confiance ----- */

const stat = (n, t) => Col([P(n, 'br-stat'), Muted(t)]);
const avis = (txt) => Col([Box('br-card br-avis', [
  cb('core/quote', { citation: fr('Prénom N., ville') }, [P(txt)]),
])]);
const projet = (n, t) => Col([Box('br-project', [Img(n, '4/3'), Chips(['Type de projet', 'Ville']), H(t, 3), Muted('Une phrase : la demande du client et ce qui a été fait.')])]);
add('realisations', 'confiance', 'Dernières réalisations (automatique, 4 versions)', 'Accueil : les trois dernières réalisations publiées (menu Réalisations), avec un lien vers toutes. Forme au choix dans le panneau « Version » : grille, liste, une en grand, défilement. Se met à jour seule ; disparaît s’il n’y en a aucune.',
  Section('br-section-realisations br-projets br-projets--grille', [
    sectionHead('Nos dernières réalisations', ['Toutes les réalisations', URL('realisations')]),
    Short('[briise_realisations nombre="3"]'),
  ]));
add('realisations-toutes', 'confiance', 'Toutes les réalisations, avec filtres (automatique)', 'Page des réalisations : toutes les fiches publiées, avec des boutons pour filtrer par catégorie. Se met à jour seule.',
  Section('br-section-realisations', [Short('[briise_realisations filtres="1"]')]));
add('realisations-service', 'confiance', 'Réalisations de ce service (automatique, 4 versions)', 'Page de service : les réalisations rattachées à ce service. Forme au choix dans le panneau « Version » : grille, liste, une en grand, défilement. Disparaît tant qu’il n’y en a aucune.',
  Section('br-section-realisations br-projets br-projets--grille', [
    sectionHead('Nos réalisations pour ce service', ['Toutes les réalisations', URL('realisations')]),
    Short('[briise_realisations service="auto" nombre="3"]'),
  ]));
add('realisations-manuelle', 'confiance', 'Réalisations en grille (à la main)', 'Trois réalisations écrites dans la page, sans fiche. Pour un site sans la fonction Réalisations.',
  Section('', [
    sectionHead('Nos dernières réalisations', ['Toutes les réalisations', URL('realisations')]),
    Cols([projet('carre', 'Première réalisation'), projet('carre-2', 'Deuxième réalisation'), projet('carre-3', 'Troisième réalisation')], 'br-projects'),
  ]));

const avantApres = (label, titre, chapo, a = ['avant', 'Avant : décrivez l’état de départ', 'Avant'], b = ['apres', 'Après : décrivez le résultat', 'Après']) => Section('', [
  Head([Label(label), H(titre, 2), Lead(chapo)]),
  Cols([
    Col([Box('br-avap', [Img(a[0], '16/10', 'is-style-br-arrondi', a[1]), P(a[2], 'br-chip br-avap-tag')])]),
    Col([Box('br-avap', [Img(b[0], '16/10', 'is-style-br-arrondi', b[1]), P(b[2], 'br-chip br-avap-tag')])]),
  ], 'br-avant-apres br-glisse'),
  P('Faites glisser le curseur, ou passez la souris sur la photo, pour comparer.', 'br-muted br-glisse-aide'),
]);
/* ----- Parcours ----- */

add('etapes', 'parcours', 'Étapes en frise', 'Rassurer sur le déroulé : du premier contact au résultat. Une frise numérotée qui se remplit au défilement, avec la durée de chaque étape. Idéale sur l’accueil.',
  etapesFrise('Trois étapes, sans surprise', [
    ['Vous nous contactez', 'Par téléphone ou par le formulaire. Nous répondons sous 24 heures ouvrées.', 'Réponse sous 24 h'],
    ['Nous faisons le point', 'Un échange pour comprendre votre besoin, puis un devis clair et détaillé.', 'Devis gratuit'],
    ['Nous réalisons', 'Aux dates convenues, avec un interlocuteur unique du début à la fin.', 'Délai annoncé au devis'],
  ], [MainBtns()]));

add('etapes-prix', 'parcours', 'Déroulé et prix, côte à côte', 'Pages de service : les étapes sur un fil qui se remplit au défilement, et le prix dans la colonne qui reste à l’écran. Le visiteur lit le déroulé et voit le prix en même temps.',
  etapesFil('De la première visite à la fin du chantier', [
    ['La visite', 'Ce qui se passe au premier rendez-vous, et qui vient.', 'Gratuite'],
    ['Le devis', 'Avec quoi : plan, échantillons, prix détaillé.', 'Sous … jours'],
    ['La préparation', 'Où, par qui, ce que le client a à faire.', '… semaines'],
    ['La fin du chantier', 'Propreté, ce que le client reçoit, la garantie.', '… jours'],
  ], [prixCarte([['Prestation la plus courante', 'À partir de… €'], ['Option fréquente', '+ … €']], 'Ce qui fait varier le prix, en une phrase. Le prix exact figure sur le devis.', ['Prestation', 'Prix TTC']),
    compris(['La visite et le devis', 'Le matériel et la main-d’œuvre', 'Le nettoyage du chantier'], ['Ce que le client doit prévoir de son côté'])]));

add('prix-compris', 'offre', 'Prix et ce qu’il comprend', 'Les prix, puis deux listes courtes : ce qui est compris, ce qui ne l’est pas. Elles répondent à la peur numéro un du prospect, les mauvaises surprises sur le devis.',
  Section('br-prix-compris', [
    Cols([
      Col([Label('Le prix'), H('Ce que comprend le prix', 2), prixCarte([['Prestation la plus courante', 'À partir de… €'], ['Option fréquente', '+ … €']], 'Le prix exact figure sur le devis, après la visite.', ['Prestation', 'Prix TTC'])], { width: '42%' }),
      Col([Box('br-compris br-compris-cols', [
        Box('', [P('Compris dans le prix', 'br-compris-titre'), List(['La visite et le devis', 'Le matériel et la main-d’œuvre', 'La pose et le nettoyage du chantier'], 'br-liste-oui')]),
        Box('', [P('Non compris', 'br-compris-titre is-non'), List(['Ce que le client doit prévoir de son côté', 'Les travaux d’un autre corps de métier'], 'br-liste-non')]),
      ])], { width: '58%' }),
    ], 'br-etapes-cols'),
  ], { backgroundColor: 'fond' }));

add('faq', 'parcours', 'FAQ en accordéon', 'Lever les freins avant le contact. Sur la page choisie comme FAQ, les questions sont transmises à Google.',
  Section('', [Cols([
    Col([Label('Questions fréquentes'), H('Vos questions, nos réponses', 2), Muted('Vous ne trouvez pas votre réponse ?'), Arrow('Posez-nous la question', CTA)], { width: '38%' }),
    Col([
      Details('Une question que vos clients posent souvent ?', 'Une réponse directe en deux ou trois phrases. Commencez par oui ou par non quand c’est possible.'),
      Details('Combien de temps faut-il compter ?', 'Donnez un délai concret, même approximatif : c’est l’une des premières choses que l’on cherche.'),
      Details('Quels sont vos tarifs ?', 'Une fourchette honnête vaut mieux que « sur devis » seul. Renvoyez vers la page des tarifs si elle existe.'),
      Details('Intervenez-vous dans ma ville ?', 'Citez les villes ou le rayon couvert. C’est aussi utile pour le référencement local.'),
      Details('Comment se passe le paiement ?', 'Moyens acceptés, acompte éventuel, échéances.'),
    ], { width: '62%' }),
  ], 'br-split')]));

add('horaires', 'parcours', 'Horaires et planning', 'Horaires d’ouverture tirés de « Mon entreprise », et un planning de rendez-vous ou de cours. Le jour en cours est surligné.',
  Section('', [Cols([
    Col([Label('Horaires'), H('Quand nous trouver', 2), Short('[briise_horaires]')], { width: '40%' }),
    Col([
      H('Planning de la semaine', 3),
      Table(['Jour', 'Horaire', 'Activité', 'Réserver'], [
        ['Lundi', '18 h – 19 h', 'Première activité', '<a href="' + CTA + '">Réserver</a>'],
        ['Mercredi', '12 h 30 – 13 h 30', 'Deuxième activité', '<a href="' + CTA + '">Réserver</a>'],
        ['Samedi', '10 h – 11 h', 'Troisième activité', '<a href="' + CTA + '">Réserver</a>'],
      ], 'br-table br-planning'),
    ], { width: '60%' }),
  ], 'br-split')]));

/* ----- Personnes ----- */

add('dirigeant', 'personnes', 'Présentation du dirigeant', 'Quand le client choisit une personne autant qu’une entreprise : la personne derrière l’entreprise, sa photo et son parcours.',
  Section('', [Cols([
    Col([Img('portrait', '4/5', 'is-style-br-galet', 'Portrait de [prénom nom]')], { width: '42%' }),
    Col([
      Label('Qui suis-je'), H('Prénom Nom, votre métier', 2),
      P('Une phrase forte sur votre approche, celle que vous diriez à un client au premier rendez-vous.', 'br-statement'),
      P('Votre parcours en quelques lignes : formation, années d’expérience, ce qui vous a amené à ce métier. Parlez au client : ce qui compte pour lui, c’est ce que votre parcours lui apporte.'),
      Arrow('En savoir plus sur mon parcours', URL('a-propos')),
    ], { width: '58%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })]));

const membre = (img, n) => Col([Box('br-member', [Img(img, '1/1', 'is-style-br-arrondi', 'Portrait de ' + n), H(n, 3), Muted('Rôle ou spécialité')])]);
add('equipe', 'personnes', 'Équipe', 'PME et cabinets : présenter les personnes que le client rencontrera.',
  Section('', [
    Head([Label('L’équipe'), H('Les personnes qui vous accompagnent', 2)]),
    Cols([membre('carre', 'Prénom Nom'), membre('carre-2', 'Prénom Nom'), membre('carre-3', 'Prénom Nom')], 'br-team'),
  ]));

const valeur = (t) => Col([H(t, 3), Muted('Ce que cette valeur change concrètement pour le client, en une ou deux phrases.')]);
add('valeurs', 'personnes', 'Citation ou valeurs', 'Positionnement : une phrase forte et trois engagements.',
  Section('', [
    P('« Une phrase qui résume votre façon de travailler, et que vos clients pourraient répéter. »', 'br-statement br-center br-narrow'),
    Cols([valeur('Premier engagement'), valeur('Deuxième engagement'), valeur('Troisième engagement')], 'br-steps'),
  ], { backgroundColor: 'surface' }));

/* ----- Contenu ----- */

add('derniers-articles', 'contenu', 'Derniers articles', 'Les trois derniers articles du blog, mis à jour automatiquement.',
  Section('', [
    sectionHead('Nos derniers conseils', ['Tous les articles', URL('blog')]),
    cb('core/query', { queryId: 1, query: { perPage: 3, pages: 0, offset: 0, postType: 'post', order: 'desc', orderBy: 'date', author: '', search: '', exclude: [], sticky: '', inherit: false }, className: 'br-posts' }, [
      cb('core/post-template', { layout: { type: 'grid', columnCount: 3 } }, [
        Box('br-post-card', [
          cb('core/post-featured-image', { isLink: true, aspectRatio: '4/3' }),
          Box('br-post-body', [cb('core/post-date', { format: 'F Y', className: 'br-label' }), cb('core/post-title', { level: 3, isLink: true }), cb('core/post-excerpt', { excerptLength: 18, className: 'br-muted' })]),
        ]),
      ]),
    ]),
  ]));

add('pages-liees', 'contenu', 'Pages liées (automatique)', 'Pages de service : les autres services, avec un lien vers chacun. Sur une page qui a des sous-pages : la liste de ses sous-pages. Se met à jour seule.',
  Section('br-section-liees', [
    sectionHead('Nos autres services', ['Tous nos services', URL('services')]),
    Short('[briise_pages_liees]'),
  ], { backgroundColor: 'surface' }));

/* ----- Contact ----- */
add('coordonnees-carte', 'contact', 'Coordonnées (carte)', 'Téléphone, e-mail, adresse et horaires en une carte, avec le lien d’itinéraire. Se remplit depuis Mon entreprise.',
  Section('', [Short('[briise_carte_coordonnees]')]));
add('zone-carte', 'contact', 'Zone d’intervention (carte)', 'Les communes regroupées par secteur, avec téléphone et contact en bas. Se remplit depuis Mon entreprise (Secteurs de la zone).',
  Section('', [Short('[briise_carte_zone]')]));


add('bandeau-cta', 'contact', 'Bandeau d’appel à l’action', 'Fin de page : une dernière invitation à passer à l’action.',
  Section('br-cta', [Box('br-cta-inner', [
    H('Une question, un projet ?', 2), Lead('Une phrase qui lève le dernier frein : devis gratuit, réponse rapide, premier échange sans engagement.'),
    Btns(Btn(CTA_LABEL, CTA, null, { backgroundColor: 'fond', textColor: 'texte' })),
  ])], { backgroundColor: 'secondaire', textColor: 'fond' }));

add('contact', 'contact', 'Bloc contact complet', 'Coordonnées, itinéraire, horaires et réseaux, tirés de « Mon entreprise ».',
  Section('', [Cols([
    Col([Label('Contact'), H('Venir nous voir ou nous écrire', 2), Short('[briise_coordonnees]'), Short('[briise_reseaux]')], { width: '55%' }),
    Col([Box('br-card', [H('Horaires', 3), Short('[briise_horaires]')])], { width: '45%' }),
  ], 'br-split')]));

add('zone', 'contact', 'Zone d’intervention', 'Quand vous vous déplacez chez vos clients : les villes couvertes, tirées de « Mon entreprise ».',
  Section('', [
    Head([Label('Zone d’intervention'), H('Nous intervenons près de chez vous', 2), Lead('Une phrase sur votre secteur : rayon, délais de déplacement, frais éventuels.')]),
    Short('[briise_zone]'),
    Muted('Votre ville n’est pas dans la liste ? Contactez-nous, nous étudions chaque demande.'),
  ], { backgroundColor: 'nuance' }));

add('formulaire', 'contact', 'Formulaire de demande de devis', 'Le formulaire de devis (Fluent Forms, créé dans Mon entreprise > Fonctions), avec ce qui se passe après l’envoi. Sans formulaire : téléphone et e-mail.',
  Section('', [Cols([
    Col([
      Label('Votre demande'), H('Parlons de votre projet', 2),
      P('Ce qui se passe après l’envoi : sous quel délai vous répondez, et par quel moyen.'),
      List(['Réponse sous 24 heures ouvrées', 'Devis gratuit et sans engagement', 'Vos données ne servent qu’à vous répondre']),
      Short('[briise_appel]'),
    ], { width: '42%' }),
    Col([Box('br-card br-formulaire', [Short('[briise_formulaire type="devis"]')])], { width: '58%' }),
  ], 'br-split')]));
add('formulaire-contact', 'contact', 'Formulaire de contact', 'Le formulaire de contact (Fluent Forms, créé dans Mon entreprise > Fonctions). Sans formulaire : téléphone et e-mail.',
  Section('', [Cols([
    Col([
      Label('Nous écrire'), H('Une question ? Écrivez-nous', 2),
      P('Ce qui se passe après l’envoi : sous quel délai vous répondez, et par quel moyen.'),
      List(['Réponse sous 24 heures ouvrées', 'Vos données ne servent qu’à vous répondre']),
      Short('[briise_appel]'),
    ], { width: '42%' }),
    Col([Box('br-card br-formulaire', [Short('[briise_formulaire type="contact"]')])], { width: '58%' }),
  ], 'br-split')]));


/* ----- 1.13.0 : sections des métiers de l'image (ambiance Galerie), utiles aussi à d'autres métiers ----- */

/* Ouverture « choix de la prestation » : la liste des prestations avec leur prix ; au survol d'une ligne,
   la grande photo change (CSS seul, sans script). Sur mobile, chaque ligne a sa vignette. 2 à 6 lignes. */
const choixLigne = ([nom, prix, slug, img, alt]) => Box('br-choix-ligne', [
  Img(img, '1/1', 'br-choix-vignette', alt), P(`<a href="${URL(slug)}">${fr(nom)}</a>`, 'br-choix-nom'), P(prix, 'br-choix-prix'),
]);
const choixSeance = ({ lieu, titre, second, items, dispo = true }) => Section('br-hero br-choix', [Cols([
  Col([P(lieu, 'br-choix-lieu'), H(titre, 1, null, { fontSize: 'huge' }), MainBtns(second), Box('br-choix-liste', items.map(choixLigne))], { width: '52%', verticalAlignment: 'center' }),
  Col([Box('br-choix-scene', [...items.map(([, , , img, alt]) => ImgFond(img, 'br-choix-photo', alt)), ...(dispo ? [Short('[briise_disponibilite]')] : [])])], { width: '48%' }),
], 'br-split br-choix-cols')]);
add('choix-prestation', 'ouverture', 'Ouverture : liste des prestations qui change la photo', 'Accueil : le titre, puis la liste des prestations avec leur prix. Au survol d’une ligne, la grande photo change. Chaque ligne mène à sa page. Sur mobile, une vignette par ligne. De 2 à 6 lignes.',
  choixSeance({ lieu: 'Où vous recevez, ou jusqu’où vous vous déplacez', titre: 'Votre métier à Votre ville, en une phrase', second: ['Voir les tarifs', URL('tarifs')], items: [
    ['Première prestation', 'dès … €', 'service-1', 'portrait', 'Photo à remplacer : la première prestation'],
    ['Deuxième prestation', '… €', 'service-2', 'carre', 'Photo à remplacer : la deuxième prestation'],
    ['Troisième prestation', '… €', 'service-3', 'carre-2', 'Photo à remplacer : la troisième prestation'],
    ['Quatrième prestation', 'dès … €', 'service-4', 'carre-3', 'Photo à remplacer : la quatrième prestation'],
  ] }));

/* Ouverture en éventail : titre centré, cinq photos en arc dessous. */
const eventail = ({ lieu, titre, second, imgs }) => Section('br-hero br-eventail', [
  Box('br-eventail-texte', [P(lieu, 'br-choix-lieu'), H(titre, 1, null, { fontSize: 'huge' }), MainBtns(second)]),
  Box('br-eventail-photos', imgs.map(([img, alt]) => Img(img, '3/4', 'br-eventail-photo', alt))),
]);
add('ouverture-eventail', 'ouverture', 'Ouverture : titre centré et photos en éventail', 'Quand les photos sont le meilleur argument : un grand titre centré, puis cinq photos disposées en arc. Élégante sur ordinateur ; sur mobile, trois photos restent visibles.',
  eventail({ lieu: 'Où vous recevez, ou jusqu’où vous vous déplacez', titre: 'Votre métier à Votre ville, en une phrase', second: ['Voir les tarifs', URL('tarifs')],
    imgs: [['portrait', 'Photo à remplacer'], ['carre', 'Photo à remplacer'], ['carre-2', 'Photo à remplacer : la plus belle, au centre'], ['carre-3', 'Photo à remplacer'], ['paysage', 'Photo à remplacer']] }));

/* Où se passe la prestation : deux ou trois lieux, avec photo et faits ; le premier peut porter une pastille. */
const lieuCol = ([img, alt, t, d, faits, pastille], large) => Col([Box('br-lieu', [
  Box('br-lieu-media', [Img(img, '4/3', 'is-style-br-arrondi', alt), ...(pastille ? [P(pastille, 'br-pastille')] : [])]),
  H(t, 3), Muted(d), List(faits, 'br-liste-oui'),
])], large ? { width: '40%' } : {});
const lieux = ({ titre, chapo, items, bg = 'surface' }) => Section('br-lieux', [
  Row('br-section-head br-tete-deux', [H(titre, 2), Lead(chapo)]),
  Cols(items.map((it, i) => lieuCol(it, items.length === 3 && i === 0)), 'br-lieux-grille'),
], { backgroundColor: bg });
add('lieux', 'offre', 'Où se passe la prestation', 'Deux ou trois lieux possibles (chez vous, dans nos locaux, en extérieur), chacun avec sa photo et ses faits. Le premier peut porter une pastille (« Idéal pour… »).',
  lieux({ titre: 'Chez vous, dans nos locaux ou dehors : vous choisissez', chapo: 'Une phrase qui dit si le prix change selon le lieu, et jusqu’où vous vous déplacez.', items: [
    ['paysage', 'Photo à remplacer : vos locaux', 'Dans nos locaux', 'Ce que le client y trouve, en une phrase.', ['Un premier fait concret', 'Un deuxième fait', 'Un troisième fait'], 'Idéal pour…'],
    ['carre', 'Photo à remplacer : chez un client', 'Chez vous', 'Ce que ça change pour le client.', ['Un fait concret', 'La zone couverte sans frais']],
    ['carre-2', 'Photo à remplacer : en extérieur', 'En extérieur', 'Les lieux, la saison, l’heure.', ['Un fait concret', 'Une solution de repli']],
  ] }));

/* Faits à icônes : six faits courts, chacun avec une icône choisie par sa classe (br-ic-…). */
const fait = ([ic, t, d]) => Box('br-fait br-ic-' + ic, [H(t, 3), Muted(d)]);
const faitsIcones = ({ titre, chapo, img, alt, items, bg = 'surface' }) => Section('br-faits-section', [Cols([
  Col([Box('br-faits-cote', [H(titre, 2), Lead(chapo), Img(img, '4/5', 'is-style-br-arrondi', alt)])], { width: '40%' }),
  Col([Box('br-faits', items.map(fait))], { width: '60%' }),
], 'br-split')], { backgroundColor: bg });
add('faits-icones', 'offre', 'Faits concrets avec icônes', 'Un lieu, un atelier, un service : six faits courts qui rassurent, chacun avec son icône. Icônes au choix par la classe du bloc : br-ic-soleil, thermometre, fauteuil, cintre, parking, horloge, bouclier, euro, maison, appareil, coeur, accessible.',
  faitsIcones({ titre: 'Tout est prêt avant votre arrivée', chapo: 'Ce que le client n’a pas à prévoir, en une phrase.', img: 'portrait', alt: 'Photo à remplacer : un détail du lieu', items: [
    ['soleil', 'Premier fait', 'Une phrase concrète, avec un chiffre si possible.'], ['thermometre', 'Deuxième fait', 'Une phrase concrète.'],
    ['fauteuil', 'Troisième fait', 'Une phrase concrète.'], ['cintre', 'Quatrième fait', 'Une phrase concrète.'],
    ['horloge', 'Cinquième fait', 'Une phrase concrète.'], ['parking', 'Sixième fait', 'Une phrase concrète.'],
  ] }));

/* Étapes en photos, avec le numéro posé sur la photo et une pastille pour le moment. Aussi pour raconter une journée (heures). */
const etapeImage = ([img, alt, quand, t, d], i, numeros) => Box('br-etape-image', [
  Box('br-etape-media', [Img(img, '3/4', 'is-style-br-arrondi', alt), P(quand, 'br-etape-quand'), ...(numeros ? [P(String(i + 1), 'br-etape-numero')] : [])]),
  H(t, 3), Muted(d),
]);
const etapesImages = ({ titre, chapo, items, numeros = true, bg = 'surface', apres = [] }) => Section('br-etapes-images' + (numeros ? '' : ' br-etapes-images--journee'), [
  Row('br-section-head br-tete-deux', [H(titre, 2), Lead(chapo)]),
  Box('br-etapes-images-grille', items.map((it, i) => etapeImage(it, i, numeros))),
  ...apres,
], { backgroundColor: bg });
add('etapes-images', 'parcours', 'Étapes en photos, numérotées', 'Comment ça se passe, en trois à cinq photos : le numéro de l’étape est posé sur la photo, le moment (« Le jour J », « Sous 3 semaines ») dans une pastille. Quand chaque étape se montre mieux qu’elle ne se raconte.',
  etapesImages({ titre: 'Comment ça se passe, en quatre temps', chapo: 'Une phrase qui dit que le client sait à chaque étape ce qui l’attend.', items: [
    ['portrait', 'Photo à remplacer : le premier échange', 'Quand vous voulez', 'Vous réservez', 'Comment, et ce qui se passe ensuite.'],
    ['carre', 'Photo à remplacer : la préparation', 'Une semaine avant', 'On prépare', 'Ce que vous envoyez ou proposez.'],
    ['carre-2', 'Photo à remplacer : le jour J', 'Le jour J', 'La prestation', 'Durée, lieu, déroulé.'],
    ['carre-3', 'Photo à remplacer : le résultat', 'Sous … semaines', 'Le résultat', 'Ce que le client reçoit, et sous quel délai.'],
  ] }));
add('journee-racontee', 'confiance', 'Une journée racontée en photos', 'Mariage, événement, chantier d’une journée : six moments dans l’ordre, chacun avec son heure et une phrase. Montre tout ce que le client reçoit, pas seulement les plus belles photos.',
  etapesImages({ titre: 'Une journée racontée, du matin au soir', chapo: 'Qui, où, quand (avec leur accord), et pourquoi cette histoire montre ce que le client recevra vraiment.', numeros: false, items: [
    ['portrait', 'Photo à remplacer', '10 h', 'Premier moment', 'Une phrase.'], ['carre', 'Photo à remplacer', '12 h', 'Deuxième moment', 'Une phrase.'],
    ['carre-2', 'Photo à remplacer', '15 h', 'Troisième moment', 'Une phrase.'], ['carre-3', 'Photo à remplacer', '16 h', 'Quatrième moment', 'Une phrase.'],
    ['paysage', 'Photo à remplacer', '19 h 30', 'Cinquième moment', 'Une phrase.'], ['paysage-2', 'Photo à remplacer', '23 h', 'Sixième moment', 'Une phrase.'],
  ], apres: [Arrow('Voir toute l’histoire', URL('realisations'))] }));

/* Appel final sur photo : la photo à droite, un voile sombre côté texte (contraste garanti). */
const ctaPhoto = ({ titre, texte, img = 'banniere', alt = '' }) => cb('core/cover', {
  url: IMG(img), alt: fr(alt), dimRatio: 90, overlayColor: 'sombre', isUserOverlayColor: true, align: 'full', className: 'br-cta-photo', layout: { type: 'constrained' },
}, [Cols([
  Col([H(titre, 2), P(texte, 'br-lead')], { width: '60%' }),
  Col([Btns(Btn(CTA_LABEL, CTA)), Short('[briise_appel]')], { width: '40%', verticalAlignment: 'bottom' }),
], 'br-cta-photo-cols', { verticalAlignment: 'bottom' })]);
add('cta-photo', 'contact', 'Appel à l’action sur photo', 'Fin de page : le dernier appel posé sur une grande photo, assombrie du côté du texte. Le pied de page, uni, s’en détache nettement.',
  ctaPhoto({ titre: 'Une dernière invitation, courte', texte: 'Une phrase qui lève le dernier frein : prochaine date libre, réponse sous 24 h, premier échange sans engagement.' }));

/* Avis avec la note : la note moyenne et le nombre d'avis, puis trois avis courts. */
const ETOILES = '<span class="br-etoiles" aria-hidden="true">★★★★★</span>';
const avisCourt = (txt, qui, quoi) => Col([Box('br-avis-court', [P(ETOILES, 'br-avis-etoiles'), cb('core/quote', { citation: fr(`<strong>${qui}</strong><br>${quoi}`) }, [P(txt)])])]);
/* Ce que vous recevez : la livraison dessinée sur un téléphone, et trois éléments concrets. */
add('ce-que-vous-recevez', 'offre', 'Ce que vous recevez', 'Montrer concrètement le résultat livré : une galerie en ligne, un dossier, un carnet d’entretien… dessiné sur un téléphone, avec trois éléments compris.',
  Section('br-recevez', [Cols([
    Col([Box('br-telephone', [
      P('Votre galerie', 'br-telephone-titre'), P('25 photos, gardée un an', 'br-telephone-sous'),
      cb('core/gallery', { linkTo: 'none', sizeSlug: 'medium', columns: 2, imageCrop: true, className: 'br-telephone-photos' },
        ['carre', 'carre-2', 'carre-3', 'portrait'].map((n) => cb('core/image', { url: IMG(n), alt: '', sizeSlug: 'medium', linkDestination: 'none' }))),
      P('Tout télécharger', 'br-telephone-bouton'),
    ])], { width: '42%' }),
    Col([H('Ce que vous recevez', 2), Lead('Une phrase : sous quelle forme, sous quel délai, pour combien de temps.'),
      List(['<strong>Premier élément compris.</strong> Ce que c’est, concrètement.', '<strong>Deuxième élément.</strong> Une phrase.', '<strong>En option.</strong> Ce qui se commande en plus, avec son prix.'], 'br-liste-oui br-liste-detail')], { width: '58%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })]));

/* Le temps derrière le prix : un tableau des étapes et de leur durée ; la barre est dessinée par ux.js. */
add('temps-prix', 'offre', 'Pourquoi ce prix : le temps passé', 'Justifier un prix par le travail qu’il représente : chaque étape et sa durée (« 30 min », « 2 h 30 »). Une barre colorée est dessinée à partir des durées.',
  Section('br-temps-section', [Cols([
    Col([H('Pourquoi ce prix ?', 2), Lead('Une phrase : le prix d’une prestation, et le temps total qu’elle représente.')], { width: '42%', verticalAlignment: 'center' }),
    Col([cb('core/table', { className: 'br-table br-temps', hasFixedLayout: false,
      head: [{ cells: [{ content: 'Étape', tag: 'th' }, { content: 'Temps', tag: 'th' }] }],
      body: [['Préparation', '30 min'], ['La prestation', '2 h 30'], ['Tri', '1 h'], ['Finitions', '4 h'], ['Livraison', '1 h']].map((r) => ({ cells: r.map((c) => ({ content: fr(c), tag: 'td' })) })),
      foot: [{ cells: [{ content: 'Au total', tag: 'td' }, { content: fr('environ 9 h'), tag: 'td' }] }],
    })], { width: '58%' }),
  ], 'br-split')], { backgroundColor: 'surface' }));

/* Carte cadeau : un visuel de carte et l'offre. */
add('carte-cadeau', 'offre', 'Carte cadeau', 'Offrir une prestation : un visuel de carte cadeau (photo, nom, montant) et le mode d’emploi en une phrase.',
  Section('br-cadeau', [Cols([
    Col([cb('core/cover', { url: IMG('paysage'), alt: '', dimRatio: 50, overlayColor: 'sombre', isUserOverlayColor: true, className: 'br-cadeau-carte', contentPosition: 'bottom left', layout: { type: 'constrained' } }, [
      P('Carte cadeau, valable un an', 'br-cadeau-texte'), P('… €', 'br-cadeau-montant'),
    ])], { width: '45%', verticalAlignment: 'center' }),
    Col([H('Offrir une prestation', 2), Lead('Pour quelle occasion, de quel montant, envoyée comment, valable combien de temps.'), Btns(Btn('Offrir une carte cadeau', CTA))], { width: '55%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })], { backgroundColor: 'surface' }));

/* Tarifs en liste, avec vignettes : une ligne cliquable par prestation. */
const tarifLigne = ([img, alt, nom, slug, details, prix]) => Box('br-tarif-ligne', [
  Img(img, '1/1', 'br-tarif-vignette', alt), P(`<a href="${URL(slug)}">${fr(nom)}</a>`, 'br-tarif-nom'), P(details, 'br-tarif-details'), P(prix, 'br-tarif-prix'),
]);
add('tarifs-liste', 'offre', 'Tarifs en liste, avec photos', 'Toutes les prestations sur une liste : vignette, nom, ce qui est compris en quelques mots, prix. Chaque ligne mène à la page de la prestation.',
  Section('br-tarifs-liste-section', [
    Head([H('Nos tarifs, sans surprise', 2), Lead('Ce que comprennent tous les prix, en une phrase (déplacement, livraison, garantie).')]),
    Box('br-tarifs-liste', [
      ['carre', 'Photo à remplacer : la première prestation', 'Première prestation', 'service-1', 'Durée, ce qui est compris, où', 'dès … €'],
      ['carre-2', 'Photo à remplacer : la deuxième prestation', 'Deuxième prestation', 'service-2', 'Durée, ce qui est compris, où', '… €'],
      ['carre-3', 'Photo à remplacer : la troisième prestation', 'Troisième prestation', 'service-3', 'Durée, ce qui est compris, où', '… €'],
    ].map(tarifLigne)),
  ]));

/* Galerie dont chaque photo s'agrandit au clic (fermeture au clavier, photo suivante avec les flèches). */
/* Formulaire de réservation : prestation, lieu, date, coordonnées ; à côté, ce qui se passe ensuite. */
add('formulaire-reservation', 'contact', 'Formulaire de réservation', 'Page « Réserver » : le formulaire de réservation (prestation, lieu, date souhaitée, coordonnées ; créé dans Mon entreprise > Fonctions), avec à côté la prochaine date libre et ce qui se passe après l’envoi.',
  Section('br-reservation', [Cols([
    Col([Short('[briise_fil_ariane]'), H('Réserver', 1, null, { fontSize: 'xx-large' }), Lead('Trois questions et vos coordonnées : réponse sous 24 h avec nos disponibilités. Rien n’est payé à cette étape.'),
      Box('br-card br-formulaire', [Short('[briise_formulaire type="reservation"]')])], { width: '60%' }),
    Col([Box('br-reservation-cote', [
      Box('br-lieu-media', [Img('paysage', '4/3', 'is-style-br-arrondi', 'Photo à remplacer : votre lieu ou votre travail'), Short('[briise_disponibilite]')]),
      H('Et ensuite ?', 2, 'br-h3'),
      cb('core/list', { ordered: true, className: 'br-ensuite' }, [
        '<strong>Sous 24 h</strong> Nous vous répondons avec nos disponibilités.',
        '<strong>Ensuite</strong> Un appel de 15 minutes pour préparer ensemble.',
        '<strong>Pour confirmer</strong> L’acompte réserve votre date.',
      ].map((c) => cb('core/list-item', { content: fr(c) }))),
      Short('[briise_appel]'),
    ])], { width: '40%' }),
  ], 'br-split')]));

/* ----- 1.15 : ouvertures (canevas « Briise, en-têtes et pieds de page ») ----- */
const ImgLien = (name, alt, href, cls) => cb('core/image', { url: IMG(name), alt: fr(alt), sizeSlug: 'large', linkDestination: 'custom', href, ...(cls ? { className: cls } : {}) });
const porteLien = (n) => P(`<a href="${URL('service-' + n)}">{{SERVICE:${n}}}</a>`, 'br-porte-lien');

// Deux portes : réutilisable dans les fichiers de site (textes, liens des pannes, photo du projet).
// liens : [texte, adresse] ; par défaut les quatre premiers services.
const deuxPortes = ({
  titre = 'Votre métier à votre ville, en urgence ou sur rendez-vous',
  chapo = 'Une phrase de preuve : prix annoncé avant de commencer, devis signé avant les travaux, note Google réelle.',
  statut = 'Intervention possible aujourd’hui', appel = 'Appeler', sous = 'Votre problème', liens = null,
  attente = `En attendant : le geste qui limite les dégâts. <a href="${URL('faq')}">Les bons gestes</a>`,
  img = 'paysage', projetTitre = 'J’ai un projet', projetTexte = 'Installation, rénovation ou entretien : visite et devis gratuits.',
} = {}) => Section('br-ouv-portes', [
  Box('br-ouv-portes-tete', [H(titre, 1, null, { fontSize: 'xx-large' }), Lead(chapo)]),
  Cols([
    Col([Box('br-porte br-porte--urgence', [
      P(statut, 'br-porte-statut'),
      H('C’est urgent', 2, 'br-porte-titre'),
      Short(`[briise_appel texte="${appel}" intro=""]`),
      P(sous, 'br-porte-sous'),
      Box('br-porte-liens', liens ? liens.map(([t, u]) => P(`<a href="${u}">${fr(t)}</a>`, 'br-porte-lien')) : [1, 2, 3, 4].map(porteLien)),
      P(attente, 'br-porte-attente'),
    ])]),
    Col([cb('core/cover', {
      url: IMG(img), alt: '', dimRatio: 60, overlayColor: 'sombre', isUserOverlayColor: true, minHeight: 100, minHeightUnit: '%',
      contentPosition: 'bottom left', className: 'br-porte br-porte--projet', layout: { type: 'default' },
    }, [
      H(projetTitre, 2, 'br-porte-titre'),
      P(projetTexte),
      Btns(Btn(CTA_LABEL, CTA, 'is-style-outline')),
    ])]),
  ], 'br-ouv-portes-cols'),
]);
add('ouverture-deux-portes', 'ouverture', 'Deux portes : urgent ou projet', 'Quand les visiteurs arrivent avec deux besoins très différents, une urgence ou un projet : dès l’arrivée, deux chemins. « C’est urgent » : l’appel en grand, les pannes courantes qui mènent à leur page, le geste à faire en attendant. « J’ai un projet » : une photo et la demande de devis. Le téléphone vient de Mon entreprise.',
  deuxPortes());

add('ouverture-mosaique', 'ouverture', 'Accueil en mosaïque de réalisations', 'La preuve dès l’arrivée : le titre et les boutons à gauche, trois réalisations récentes à droite, chacune avec son ouvrage et sa commune. Chaque photo mène aux réalisations.',
  Section('br-ouv-mosaique', [Box('br-ouv-mosaique-grille', [
    Box('br-ouv-mosaique-texte', [
      P('Votre métier · Votre ville', 'br-pastille'),
      H('Nos derniers ouvrages, posés près de chez vous', 1, null, { fontSize: 'xx-large' }),
      Lead('Chaque projet est dessiné pour sa pièce. Voici les trois derniers, avec leur commune.'),
      MainBtns(['Toutes nos réalisations', URL('realisations')]),
    ]),
    Box('br-ouv-tuile br-ouv-tuile--haute', [ImgLien('portrait', 'Photo à remplacer : une réalisation récente', URL('realisations')), P('Type d’ouvrage, commune', 'br-ouv-legende')]),
    Box('br-ouv-tuile', [ImgLien('carre', 'Photo à remplacer : une autre réalisation', URL('realisations')), P('Type d’ouvrage, commune', 'br-ouv-legende')]),
    Box('br-ouv-tuile', [ImgLien('carre-2', 'Photo à remplacer : une troisième réalisation', URL('realisations')), P('Type d’ouvrage, commune', 'br-ouv-legende')]),
  ])]));

add('ouverture-carte', 'ouverture', 'Grande photo et carte de garanties', 'Une grande photo pleine largeur avec le titre, puis une carte posée à cheval sur la section suivante : trois faits vérifiables (délai, ancienneté, garantie) et le bouton d’action.',
  [
    cb('core/cover', {
      url: IMG('banniere'), alt: '', dimRatio: 70, overlayColor: 'sombre', isUserOverlayColor: true, minHeight: 72, minHeightUnit: 'vh',
      contentPosition: 'center left', align: 'full', className: 'br-banniere br-ouv-plein br-ouv-carte', layout: { type: 'constrained' },
    }, [Box('br-banniere-inner', [
      H('Le titre qui dit ce que vous faites, et où', 1, null, { fontSize: 'huge' }),
      Lead('Une phrase qui complète le titre : pour qui, et ce que le visiteur gagne à vous appeler.'),
    ])]),
    cb('core/group', { align: 'full', className: 'br-ouv-faits-zone', layout: { type: 'constrained' } }, [
      Box('br-ouv-faits', [
        Box('br-ouv-fait', [P('5 jours', 'br-ouv-fait-chiffre'), P('pour recevoir le devis', 'br-ouv-fait-texte')]),
        Box('br-ouv-fait', [P('Depuis 2010', 'br-ouv-fait-chiffre'), P('une entreprise locale', 'br-ouv-fait-texte')]),
        Box('br-ouv-fait', [P('Décennale', 'br-ouv-fait-chiffre'), P('sur chaque chantier', 'br-ouv-fait-texte')]),
        Btns(Btn(CTA_LABEL, CTA)),
      ]),
    ]),
  ]);

add('ouverture-avant-apres', 'ouverture', 'Accueil avec avant / après', 'Rénovation, nettoyage, aménagement : le titre à gauche, une photo avant / après à faire glisser à droite. Les deux photos doivent être prises du même endroit, avec le même cadrage.',
  Section('br-ouv-avap', [Cols([
    Col([P('Votre métier · Votre ville', 'br-pastille'), H('Le titre de la transformation', 1, null, { fontSize: 'xx-large' }), Lead('Faites glisser pour comparer : même endroit, avant et après notre passage.'), MainBtns(['Voir nos réalisations', URL('realisations')])], { verticalAlignment: 'center', width: '40%' }),
    Col([
      Cols([
        Col([Box('br-avap', [Img('avant', '4/3', 'is-style-br-arrondi', 'Avant : décrivez l’état de départ'), P('Avant', 'br-chip br-avap-tag')])]),
        Col([Box('br-avap', [Img('apres', '4/3', 'is-style-br-arrondi', 'Après : décrivez le résultat'), P('Après', 'br-chip br-avap-tag')])]),
      ], 'br-avant-apres br-glisse'),
      P('Faites glisser le curseur, ou passez la souris sur la photo.', 'br-muted br-glisse-aide'),
    ], { verticalAlignment: 'center', width: '60%' }),
  ], 'br-split', { verticalAlignment: 'center' })]));

add('ouverture-demande', 'ouverture', 'Grande photo et demande express', 'La demande dès l’arrivée : une grande photo, le titre, et à droite un formulaire de quatre champs (projet, commune, nom, téléphone) pour être rappelé. Le formulaire « Demande de rappel » se crée dans Mon entreprise > Fonctions. Idéale aussi pour une page de publicité.',
  cb('core/cover', {
    url: IMG('banniere'), alt: '', dimRatio: 70, overlayColor: 'sombre', isUserOverlayColor: true, minHeight: 80, minHeightUnit: 'vh',
    contentPosition: 'center center', align: 'full', className: 'br-banniere br-ouv-plein br-ouv-demande', layout: { type: 'constrained' },
  }, [Cols([
    Col([Label('Votre métier, votre ville'), H('Le titre qui dit ce que vous faites, et où', 1, null, { fontSize: 'huge' }), Lead('Laissez votre numéro : nous vous rappelons dans la journée ouvrée pour fixer la visite.'), List(['Visite gratuite', 'Devis sous 5 jours', 'Garantie décennale'], 'br-coches')], { verticalAlignment: 'center', width: '55%' }),
    Col([Box('br-card br-ouv-form', [P('Votre projet en 30 secondes', 'br-ouv-form-titre'), Short('[briise_formulaire type="rappel"]'), P(`Vous préférez écrire ? <a href="${CTA}">Le formulaire complet</a>`, 'br-muted br-ouv-form-lien')])], { verticalAlignment: 'center', width: '45%' }),
  ], 'br-split', { verticalAlignment: 'center' })]));


/* ----- 1.16 : sections (canevas « Briise, sections ») ----- */

// Bandes qui défilent : le contenu reste du vrai texte, éditable ; le défilement est ajouté
// par le navigateur (pause au survol, au clavier et par un bouton ; immobile si le visiteur
// a demandé moins d'animations). Sans script ou dans l'éditeur : une bande fixe qui passe à la ligne.
const Piste = (items, cls = '') => cb('core/group', { className: ('br-defile-piste ' + cls).trim(), layout: { type: 'flex', flexWrap: 'wrap' } }, items);
add('bande-preuves', 'confiance', 'Bande de preuves qui défile', 'Juste sous l’ouverture : vos garanties et vos faits courts, sur une bande qui défile doucement. De 5 à 8 faits vrais, de deux à cinq mots chacun. Le défilement s’arrête au survol, au clavier ou avec le bouton pause.',
  cb('core/group', { align: 'full', className: 'br-defile br-defile--preuves', backgroundColor: 'nuance', layout: { type: 'default' } }, [
    Piste(['Devis gratuit sous 48 h', 'Prix annoncé avant de commencer', 'Garantie décennale', 'Atelier à [ville]', 'Depuis [année]', '4,9/5 sur Google', 'Une seule équipe, de la visite à la pose']
      .map((t) => P(t, 'br-defile-item'))),
  ]));

const avisDefile = (txt, qui) => Box('br-defile-item br-avis-court', [P(ETOILES, 'br-avis-etoiles'), cb('core/quote', { citation: fr(`<strong>${qui}</strong>`) }, [P(txt)])]);
// FAQ avec recherche : les questions restent des blocs « Détails » groupés sous des intertitres ;
// le champ de recherche et les thèmes sont ajoutés par le navigateur.
add('faq-recherche', 'parcours', 'FAQ avec recherche et thèmes', 'Page FAQ ou longue liste de questions : un champ « Chercher une question » et un bouton par thème (vos intertitres) s’ajoutent seuls au-dessus. Rangez les questions sous des intertitres de niveau 3. Sur la page choisie comme FAQ, les questions sont transmises à Google.',
  Section('br-faq-cherche', [Cols([
    Col([
      Label('Questions fréquentes'), H('Vos questions avant de nous appeler', 2),
      Short('[briise_appel intro="Pas de réponse ? Nous répondons en direct."]'),
    ], { width: '34%' }),
    Col([
      H('Le devis', 3, 'br-faq-theme'),
      Details('Le devis est-il gratuit ?', 'Oui. La visite et le devis sont gratuits et sans engagement. Vous le recevez par e-mail sous [x] jours.'),
      Details('Combien de temps faut-il pour recevoir le devis ?', 'Comptez [x] jours après la visite. Le délai réel est écrit sur le devis.'),
      H('Les travaux', 3, 'br-faq-theme'),
      Details('Combien de temps durent les travaux ?', 'Donnez un délai concret, même approximatif : c’est l’une des premières choses que l’on cherche.'),
      Details('Faut-il être présent pendant le chantier ?', 'Une réponse directe en deux ou trois phrases. Commencez par oui ou par non quand c’est possible.'),
      H('Le prix et le paiement', 3, 'br-faq-theme'),
      Details('Quels sont vos tarifs ?', 'Une fourchette honnête vaut mieux que « sur devis » seul. Renvoyez vers la page des tarifs si elle existe.'),
      Details('Comment se passe le paiement ?', 'Moyens acceptés, acompte éventuel, échéances.'),
      P('Aucune question ne correspond. Appelez-nous : nous répondons en direct.', 'br-faq-vide'),
    ], { width: '66%' }),
  ], 'br-split')]));

// Où en êtes-vous ? : quatre situations du visiteur, dites à la première personne, chacune avec
// sa réponse, son prix et la page qui y répond. Tout est visible sans clic. Icône par la classe br-ic-….
const situation = ([ic, phrase, reponse, prix, lien, url]) => Box('br-situation br-ic-' + ic, [
  H(phrase, 3), Muted(reponse), P(`<strong>${fr(prix)}</strong>`, 'br-situation-prix'), Arrow(lien, url)]);
const situations = ({ label, titre, chapo, items, bg }) => Section('br-situations-section', [
  Head([Label(label), H(titre, 2), Lead(chapo)]),
  cb('core/group', { className: 'br-situations', layout: { type: 'grid', minimumColumnWidth: '14rem' } }, items.map(situation)),
], bg ? { backgroundColor: bg } : {});
add('ou-en-etes-vous', 'parcours', 'Où en êtes-vous ?', 'Quand les visiteurs arrivent dans des situations différentes : quatre cartes qui partent de leur situation, dite comme ils la diraient, avec la réponse, le prix et la page qui y répond. Tout est visible sans clic. Icône au choix par la classe du bloc : br-ic-maison, fleches, loupe, horloge, euro, bouclier, coeur, appareil. Seulement un prix réel, ou « Sur devis ».',
  situations({ label: 'Par où commencer', titre: 'Où en êtes-vous ?', chapo: 'Choisissez la phrase qui vous ressemble : vous voyez ce qui vous servira, et ce que ça coûte.', items: [
    ['maison', 'Je découvre, je ne sais pas par où commencer.', 'Ce que vous proposez pour démarrer, en une phrase.', 'Votre prix réel, ou « Sur devis »', 'Voir ce service', URL('service-1')],
    ['fleches', 'J’ai déjà essayé, sans le résultat espéré.', 'Ce que vous faites autrement, concrètement.', 'Votre prix réel, ou « Sur devis »', 'Voir ce service', URL('service-2')],
    ['loupe', 'Je sais ce que je veux, je compare.', 'Ce qui vous distingue, chiffre à l’appui.', 'Votre prix réel, ou « Sur devis »', 'Voir ce service', URL('service-3')],
    ['horloge', 'C’est pressé.', 'Votre délai réel pour intervenir ou répondre.', 'Votre prix réel, ou « Sur devis »', CTA_LABEL, CTA],
  ] }));

// Orientation compacte : « Je cherche … pour … » ; chaque ligne de la liste est une réponse
// possible (« choix 1 | choix 2 »), liée à la page qui y répond.
const orient = (a, b, n) => `<a href="${URL('service-' + n)}">${fr(a)} | ${fr(b)}</a>`;
add('orientation', 'parcours', 'Orientation : la bonne page en une phrase', 'Accueil d’une offre large : « Je cherche [choix] pour [choix] », et le bouton mène à la page qui répond. Chaque ligne de la liste est une réponse possible, écrite « premier choix | second choix », avec le lien vers sa page. Une seule partie par ligne donne un seul menu. Ajoutez une troisième partie pour nommer la page sur le bouton.',
  Section('br-oriente br-section--tight', [
    Box('br-oriente-boite', [
      H('Trouvez la page faite pour vous', 2, 'br-oriente-titre'),
      P('Je cherche … pour …', 'br-oriente-phrase'),
      cb('core/list', { className: 'br-oriente-choix' }, [
        orient('{{SERVICE:1}}', 'un particulier', 1), orient('{{SERVICE:1}}', 'une entreprise', 1),
        orient('{{SERVICE:2}}', 'un particulier', 2), orient('{{SERVICE:2}}', 'une entreprise', 2),
        orient('{{SERVICE:3}}', 'un particulier', 3),
      ].map((c) => cb('core/list-item', { content: c }))),
    ]),
  ], { backgroundColor: 'surface' }));

// Une réalisation racontée : le besoin, la solution, l'avis, le résultat. Tout est vrai et daté.
const faitRecit = (t, v) => Box('br-recit-fait', [P(t, 'br-recit-fait-nom'), P(v, 'br-recit-fait-val')]);
add('realisation-racontee', 'confiance', 'Une réalisation racontée', 'Une réalisation qui raconte votre façon de travailler : la commune et la date, trois faits (délai, durée, matériaux), le besoin, la solution, l’avis du client et le résultat. Une vraie réalisation, des photos du chantier, l’avis avec l’accord du client.',
  Section('br-recit', [Cols([
    Col([Box('br-recit-photos', [
      Img('portrait', '4/5', 'br-recit-photo', 'Photo à remplacer : l’ouvrage terminé, en entier'),
      Img('carre', '1/1', 'br-recit-detail', 'Photo à remplacer : un détail de fabrication'),
    ])], { width: '46%' }),
    Col([
      Label('Réalisation, [commune], [mois année]'),
      H('Le titre de la réalisation, avec ce qu’elle a de particulier', 2),
      Box('br-recit-faits', [faitRecit('Fabrication', '[x] semaines'), faitRecit('Pose', '[x] jour'), faitRecit('Matériaux', '[matériaux]')]),
      H('Le besoin', 3, 'br-recit-etape'), P('Ce que le client voulait, et ce qui le gênait avant. Deux phrases, avec ses mots.'),
      H('Notre solution', 3, 'br-recit-etape'), P('Ce que vous avez proposé et pourquoi : le choix technique, ce qui a été dessiné ou ajusté avec lui.'),
      cb('core/quote', { className: 'br-recit-avis', citation: fr('Prénom N., [commune]') }, [P('« L’avis réel du client, une ou deux phrases, avec son accord. »')]),
      H('Le résultat', 3, 'br-recit-etape'), P('Ce qui a changé pour le client, concrètement.'),
      Arrow('Voir nos réalisations du même type', URL('service-1')),
    ], { width: '54%' }),
  ], 'br-split')]));

// L'équipe sans fiche par personne : une photo de groupe et des faits.
const faitEquipe = (n, t) => Box('br-equipe-fait', [P(n, 'br-equipe-chiffre'), P(t, 'br-equipe-texte')]);
add('equipe-photo', 'personnes', 'L’équipe en une photo et quatre faits', 'Quand vous êtes plusieurs : une photo de groupe devant l’atelier ou le camion, et quatre faits qui rassurent (nombre de personnes, sous-traitance, interlocuteur unique, ancienneté), sans fiche par personne. Seul ? Préférez « Présentation du dirigeant ».',
  Section('br-equipe-photo', [Cols([
    Col([Img('paysage', '3/2', 'is-style-br-arrondi', 'Photo à remplacer : toute l’équipe devant l’atelier ou le camion')], { width: '56%', verticalAlignment: 'center' }),
    Col([
      Label('L’équipe'), H('Une équipe, du premier appel à la pose', 2),
      Box('br-equipe-faits', [
        faitEquipe('[4]', 'personnes, toutes salariées'),
        faitEquipe('0', 'chantier confié à un sous-traitant'),
        faitEquipe('1', 'interlocuteur, de la visite à la pose'),
        faitEquipe('[2011]', 'année d’ouverture de l’atelier'),
      ]),
      Arrow('Qui sommes-nous', URL('a-propos')),
    ], { width: '44%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })]));

add('realisations-galerie', 'confiance', 'Galerie de réalisations filtrable (automatique)', 'Toutes les réalisations publiées en grande galerie de photos, avec un bouton par catégorie et le nombre de réalisations. Chaque photo mène à sa fiche. Se met à jour seule.',
  Section('br-section-realisations', [
    sectionHead('Nos réalisations'),
    Short('[briise_realisations filtres="1" forme="galerie" niveau="3"]'),
  ]));

add('zone-plan', 'contact', 'Zone d’intervention sur un plan', 'Les communes sur un vrai plan : le visiteur choisit la sienne et voit la distance et le délai de visite. Le plan est fabriqué une fois, à partir des communes du schéma de zone (Mon entreprise > Entreprise ; nom ; latitude ; longitude ; délai facultatif), et enregistré sur votre site : aucun service extérieur n’est chargé chez le visiteur.',
  Section('br-zone-plan', [
    Head([Label('Zone d’intervention'), H('Nous intervenons autour de [ville]', 2), Lead('Choisissez votre commune : vous voyez la distance et le délai habituel de visite.')]),
    Short('[briise_zone_plan]'),
  ], { backgroundColor: 'surface' }));


/* ----- 1.17 : conversion (canevas « Briise, conversion ») ----- */

// Estimateur : le tableau EST le barème. Chaque ligne : la question, un choix, le montant bas et haut
// qu'il ajoute. Une question à un seul choix devient une case à cocher. Sans script : le tableau reste lisible.
add('estimateur', 'offre', 'Estimateur de budget', 'Trois questions, une fourchette de prix honnête, puis la demande de devis. Le barème est le tableau : une ligne par choix (question, choix, montant bas, montant haut, ajoutés au total). Une question avec un seul choix devient une case à cocher. Les montants viennent du client, constatés sur ses chantiers.',
  Section('br-estim', [Cols([
    Col([
      Label('Estimer votre budget'), H('Combien coûte votre projet ?', 2),
      Lead('Trois questions, une fourchette honnête. Le prix exact est donné après la visite, gratuite.'),
      Table(['Question', 'Choix', 'De (€)', 'À (€)'], [
        ['Forme', 'Droit', '3 200', '4 500'],
        ['Forme', 'Quart tournant', '4 200', '6 000'],
        ['Forme', 'Hélicoïdal', '5 200', '7 800'],
        ['Marches', 'Acier', '0', '0'],
        ['Marches', 'Chêne', '600', '900'],
        ['Avec garde-corps à l’étage', 'Oui', '900', '900'],
      ], 'br-table br-estim-bareme'),
    ], { width: '56%' }),
    Col([Box('br-estim-resultat', [
      P('Budget habituel, fourni et posé', 'br-estim-label'),
      P('Choisissez vos réponses : la fourchette s’affiche ici.', 'br-estim-montant'),
      P('Fourchette indicative, constatée sur nos chantiers de l’an passé. Le prix exact est écrit sur le devis.', 'br-estim-note'),
      MainBtns(),
    ])], { width: '44%' }),
  ], 'br-split')], { backgroundColor: 'surface' }));

add('formulaire-etapes', 'contact', 'Formulaire de devis en trois étapes', 'Le formulaire de devis découpé en trois étapes courtes : le projet, les détails, les coordonnées. Une demande commencée par le projet va plus souvent au bout. À côté : ce qui se passe ensuite, et le téléphone. Sans script, le formulaire s’affiche en entier.',
  Section('br-form-etapes-section', [Cols([
    Col([
      Label('Demande de devis'), H('Votre projet en trois étapes', 2),
      Lead('Une minute suffit. Nous vous rappelons pour préciser, puis nous venons mesurer.'),
      Short('[briise_formulaire type="devis" etapes="1"]'),
    ], { width: '60%' }),
    Col([Box('br-card br-suite', [
      H('Ce qui se passe ensuite', 3),
      cb('core/list', { ordered: true, className: 'br-suite-liste' }, [
        'Nous vous appelons sous [48 h ouvrées].',
        'Visite gratuite pour prendre les mesures.',
        'Devis détaillé sous [5 jours].',
      ].map((t) => cb('core/list-item', { content: fr(t) }))),
      Short('[briise_appel intro="Plus simple au téléphone ?"]'),
    ])], { width: '40%' }),
  ], 'br-split')]));

const prepa = (ic, t, d) => Box('br-prepa-item br-ic-' + ic, [H(t, 3), Muted(d)]);
add('preparez-demande', 'contact', 'Préparez votre demande', 'Juste avant le formulaire ou sur la page de devis : les trois choses à avoir sous la main pour une réponse rapide et juste. Icônes au choix par la classe du bloc (br-ic-appareil, metre, calendrier, maison, euro, horloge…).',
  Section('br-prepa', [Cols([
    Col([
      Label('Avant de demander'), H('Préparez votre demande en 2 minutes', 2),
      Lead('Avec ces trois éléments, nous vous répondons plus vite et plus juste.'),
      Btns(Btn('J’ai tout, je fais ma demande', CTA)),
    ], { width: '40%' }),
    Col([Box('br-prepa-liste', [
      prepa('appareil', 'Deux ou trois photos', 'L’endroit vu de loin, puis de près. Le téléphone suffit.'),
      prepa('metre', 'Une mesure', 'La hauteur sous plafond, une longueur, une surface. Une estimation suffit.'),
      prepa('calendrier', 'La commune et vos dates', 'Où se trouve le chantier, et pour quand vous aimeriez que ce soit fait.'),
    ])], { width: '60%' }),
  ], 'br-split')]));

const doc = (t, d, nom) => Box('br-doc', [P('PDF', 'br-doc-type'), Box('br-doc-texte', [H(t, 3), Muted(d)]),
  cb('core/file', { href: '#', fileName: fr(nom), showDownloadButton: false, className: 'br-doc-fichier' })]);
add('documents-garanties', 'confiance', 'Garanties et documents à télécharger', 'Vos attestations en PDF : assurance décennale, qualification, Kbis. Remplacez chaque fichier (bouton « Remplacer » du bloc) et mettez la date à jour chaque année. Une attestation périmée fait plus de tort que pas d’attestation.',
  Section('br-docs', [
    Head([Label('Garanties'), H('Nos garanties, sur pièces', 2), Lead('Pas besoin de nous croire sur parole : téléchargez nos attestations. Elles sont mises à jour chaque année.')]),
    Box('br-docs-liste', [
      doc('Attestation d’assurance décennale', '[Assureur], valable jusqu’au [date]', 'Télécharger l’attestation décennale'),
      doc('Certificat de qualification', '[Qualibat, RGE…], numéro [à compléter]', 'Télécharger le certificat'),
      doc('Extrait Kbis de moins de 3 mois', '[Nom de l’entreprise], SIRET [à compléter]', 'Télécharger le Kbis'),
    ]),
  ]));

const suite = (quand, quoi) => Box('br-merci-etape', [P(quand, 'br-merci-quand'), P(quoi)]);
add('merci-suite', 'contact', 'Page merci : la suite', 'Pour la page qui s’affiche après l’envoi d’un formulaire (Mon entreprise > Fonctions > Formulaires) : la confirmation, les étapes datées, le téléphone, et de quoi patienter. La page est retirée de Google automatiquement.',
  Section('br-merci', [
    Box('br-merci-tete', [
      H('Merci, votre demande est bien partie', 1, 'br-merci-titre', { fontSize: 'xx-large' }),
      Lead('Un e-mail de confirmation vient de vous être envoyé. Voici la suite.'),
    ]),
    Box('br-merci-etapes', [
      suite('Sous 48 h ouvrées', 'Nous vous appelons pour comprendre le projet.'),
      suite('Sous 1 semaine', 'Visite gratuite chez vous pour les mesures.'),
      suite('5 jours après', 'Vous recevez le devis détaillé.'),
    ]),
    Cols([
      Col([Box('br-card br-merci-appel', [H('Une question d’ici là ?', 2, 'br-merci-sous'), Short('[briise_appel intro="Appelez-nous, c’est la même personne qui suit votre demande."]')])], { width: '45%' }),
      Col([Box('br-merci-attente', [
        H('En attendant', 2, 'br-merci-sous'),
        cb('core/list', { className: 'br-merci-liens' }, [
          `<a href="${URL('realisations')}">Voir nos dernières réalisations</a>`,
          `<a href="${URL('service-1')}">Tout savoir sur {{SERVICE:1}}</a>`,
          `<a href="${URL('faq')}">Les questions qu’on nous pose avant la visite</a>`,
        ].map((t) => cb('core/list-item', { content: t }))),
      ])], { width: '55%' }),
    ], 'br-merci-bas'),
  ]));

/* ----- Familles « Preuves » : avis, chiffres, comparaison ------------------------------
   Même principe que Services et Ouverture : une section, plusieurs versions (inc/familles.json),
   le CSS dans assets/css/familles.css. Uniquement des contenus réels : les textes ci-dessous
   disent quoi mettre, ils ne sont jamais à publier tels quels. */

// Avis : la note Google (facultative) et quatre avis. Chaque avis peut avoir la photo de la
// réalisation dont il parle (montrée dans les versions « grand avis » et « mur »).
const AVIS_EXEMPLES = [
  ['Recopiez ici un avis réel, mot pour mot. Les plus convaincants racontent une situation précise et son résultat.', 'Prénom N.', 'Prestation, ville', 'paysage'],
  ['Un deuxième avis, d’un autre type de client, pour que chacun s’y retrouve.', 'Prénom N.', 'Prestation, ville', 'carre'],
  ['Un avis qui parle du prix ou du devis : c’est la crainte numéro un.', 'Prénom N.', 'Prestation, ville', 'paysage-2'],
  ['Un quatrième avis, court. Au-delà, renvoyez vers votre fiche Google.', 'Prénom N.', 'Prestation, ville', 'carre-2'],
];
const temoin = ([txt, qui, quoi, img]) => Box('br-temoin', [
  ...(img ? [cb('core/image', { url: IMG(img), alt: fr('Photo à remplacer : la réalisation dont parle ce client'), sizeSlug: 'large', linkDestination: 'none', className: 'br-temoin-photo' })] : []),
  P(ETOILES, 'br-avis-etoiles'),
  cb('core/quote', { citation: fr(`<strong>${qui}</strong><br>${quoi}`), className: 'br-temoin-citation' }, [P(fr(txt))]),
]);
const NOTE_GOOGLE = P(`<strong class="br-note-chiffre">4,9</strong> <span class="br-note-detail">${ETOILES}<span>sur 5, 62 avis Google</span></span>`, 'br-note');
const VERSIONS_AVIS = ['grille', 'note', 'grand', 'mur', 'defile'];
const avisSection = ({ version = 'grille', titre = 'Ce qu’en disent nos clients', chapo = '', lien = ['Tous les avis sur Google', '#'], note = true, items = AVIS_EXEMPLES, bg = 'surface', position = 'centre' } = {}) =>
  Section(`br-temoignages br-temoignages--${version}${position ? ' br-titre--' + position : ''}`, [
    Row('br-section-head', [H(titre, 2), ...(chapo ? [Lead(chapo)] : []), ...(lien ? [Arrow(lien[0], lien[1])] : [])]),
    Box('br-temoignages-corps', [
      ...(note ? [Box('br-temoignages-note', [NOTE_GOOGLE])] : []),
      Box('br-temoin-liste', items.map(temoin)),
    ]),
  ], bg ? { backgroundColor: bg } : {});
add('avis', 'confiance', 'Avis (5 versions)', 'La note Google et quatre avis de clients, chacun avec la photo de la réalisation dont il parle. Choisissez la forme dans le panneau « Version » : grille, note en avant, un avis en grand, mur d’avis ou défilement. Uniquement la vraie note et des avis réels, recopiés mot pour mot avec l’accord de leur auteur (jamais pour une profession réglementée). Retirez la note si vous n’avez pas de fiche Google.',
  avisSection());

// Chiffres : trois ou quatre preuves chiffrées, vraies et vérifiables, et une photo.
const CHIFFRES_EXEMPLES = [['15 ans', 'd’expérience dans le métier'], ['400', 'clients accompagnés'], ['48 h', 'pour recevoir votre devis'], ['4,9/5', 'note moyenne sur Google']];
const VERSIONS_CHIFFRES = ['ligne', 'cartes', 'tuiles', 'bande', 'photo'];
const chiffresSection = ({ version = 'ligne', label = 'En chiffres', titre = 'Ce qui fait la différence', chapo = 'Une phrase qui dit ce que ces chiffres garantissent à vos clients.', items = CHIFFRES_EXEMPLES, photo = 'paysage', position = 'filet' } = {}) =>
  Section(`br-chiffres br-chiffres--${version}${position ? ' br-titre--' + position : ''}`, [
    Head([Label(label), H(titre, 2), ...(chapo ? [Lead(chapo)] : [])]),
    Box('br-chiffres-corps', [
      Box('br-chiffres-liste', items.map(([v, t]) => Box('br-chiffre', [P(v, 'br-stat'), Muted(t)]))),
      ...(photo ? [cb('core/image', { url: IMG(photo), alt: fr('Photo à remplacer : votre équipe ou votre travail'), sizeSlug: 'large', linkDestination: 'none', className: 'br-chiffres-photo' })] : []),
    ]),
  ]);
add('chiffres', 'confiance', 'Chiffres (5 versions)', 'Trois ou quatre preuves chiffrées et une photo. Choisissez la forme dans le panneau « Version » : en ligne, en cartes, en tuiles avec la photo, sur une bande foncée, ou posés sur la photo. Les chiffres comptent jusqu’à leur valeur quand la section apparaît (une valeur purement numérique, avec au plus une unité courte). Uniquement des chiffres vrais et vérifiables.',
  chiffresSection());

// Comparaison : « Ce que vous évitez avec nous ». Une ligne par sujet : ce qu'on voit souvent, ce que
// vous faites. Ne jamais nommer ni viser un concurrent : décrire des pratiques, pas des entreprises.
const COMPARAISON_EXEMPLES = [
  ['Un devis vague, des suppléments à la fin', 'Un prix détaillé, tenu jusqu’au bout'],
  ['Des semaines sans nouvelles', 'Une réponse sous 48 h, un interlocuteur unique'],
  ['Un chantier laissé en l’état', 'Un chantier propre, chaque soir'],
  ['Personne quand il y a un souci', 'Une garantie écrite, et on revient'],
];
const VERSIONS_COMPARAISON = ['colonnes', 'lignes'];
const comparaison = ({ version = 'colonnes', label = 'Pourquoi nous', titre = 'Ce que vous évitez avec nous', chapo = 'Ce qui agace le plus dans votre métier, et ce que vous faites autrement. Des faits que vous tenez, jamais un concurrent nommé.', tetes = ['Ce qu’on voit souvent', 'Avec nous'], items = COMPARAISON_EXEMPLES, photo = 'paysage', position = 'geant' } = {}) =>
  Section(`br-comparaison br-comparaison--${version}${position ? ' br-titre--' + position : ''}`, [
    Head([Label(label), H(titre, 2), ...(chapo ? [Lead(chapo)] : [])]),
    Box('br-comparaison-corps', [
      ...(photo ? [cb('core/image', { url: IMG(photo), alt: fr('Photo à remplacer : votre travail, soigné'), sizeSlug: 'large', linkDestination: 'none', className: 'br-comparaison-photo' })] : []),
      Box('br-comparaison-table', [
        Box('br-comparaison-ligne br-comparaison-tetes', [P(tetes[0], 'br-comparaison-autres'), P(tetes[1], 'br-comparaison-nous')]),
        ...items.map(([a, n]) => Box('br-comparaison-ligne', [P(a, 'br-comparaison-autres'), P(n, 'br-comparaison-nous')])),
      ]),
    ]),
  ]);
add('comparaison', 'confiance', 'Ce que vous évitez avec nous (2 versions)', 'Ce qui agace le plus les clients dans votre métier, et ce que vous faites autrement, ligne par ligne, avec une photo. Choisissez la forme dans le panneau « Version » : deux colonnes ou lignes face à face. Des pratiques que vous tenez vraiment ; ne nommez ni ne visez jamais un concurrent.',
  comparaison());

/* ----- Familles « Preuves » (suite) : galerie, logos, avant / après ----------------------- */

// Galerie : six photos ; chacune s'agrandit en plein écran au clic ou au clavier.
const PHOTOS_GALERIE = ['paysage', 'portrait', 'carre', 'carre-2', 'paysage-2', 'carre-3'];
const VERSIONS_GALERIE = ['mosaique', 'grille', 'bande', 'polaroid', 'grande'];
const galerieSection = ({ version = 'mosaique', label = 'En images', titre = 'Un aperçu de notre travail', photos = PHOTOS_GALERIE, position = 'centre' } = {}) =>
  Section(`br-galeries br-galeries--${version}${position ? ' br-titre--' + position : ''}`, [
    Head([Label(label), H(titre, 2)]),
    cb('core/gallery', { linkTo: 'none', sizeSlug: 'large', className: 'br-mosaique br-galeries-photos', columns: 3, imageCrop: true },
      photos.map((n, i) => cb('core/image', { url: IMG(n), alt: fr('Photo ' + (i + 1) + ' à remplacer : décrivez ce qu’elle montre'), sizeSlug: 'large', linkDestination: 'none', lightbox: { enabled: true } }))),
  ]);
add('galerie', 'confiance', 'Galerie (5 versions)', 'Six photos de votre travail, de votre lieu ou de votre équipe ; chacune s’agrandit en plein écran au clic ou au clavier. Choisissez la forme dans le panneau « Version » : mosaïque, grille régulière, bande qui défile, photos posées en vrac ou une en grand. Le texte alternatif de chaque photo décrit vraiment ce qu’elle montre.',
  galerieSection());

// Logos : clients, partenaires, labels. Seulement avec leur accord ; le nom en texte alternatif.
const VERSIONS_LOGOS = ['ligne', 'grille', 'defile', 'discrets'];
const logosSection = ({ version = 'ligne', label = 'Ils nous font confiance', n = 6 } = {}) =>
  Section(`br-section--tight br-partenaires br-partenaires--${version}`, [
    P(label, 'br-label br-center'),
    cb('core/group', { className: 'br-logos', layout: { type: 'flex', flexWrap: 'wrap', justifyContent: 'center' } },
      Array.from({ length: n }, (_, i) => cb('core/image', { url: IMG('logo-' + ((i % 5) + 1)), alt: fr('Nom du client, du partenaire ou du label ' + (i + 1)), sizeSlug: 'full', linkDestination: 'none', width: '140px' }))),
  ]);
add('logos', 'confiance', 'Logos (4 versions)', 'Les clients, partenaires ou labels qui vous font confiance, en logos. Choisissez la forme dans le panneau « Version » : en ligne, en grille de cartes, en bande qui défile (pause au survol, au clavier ou avec le bouton) ou discrets, à côté de leur titre. Un logo par client, son nom en texte alternatif, seulement avec son accord.',
  logosSection());

// Avant / après : deux photos prises du même endroit, avec le même cadrage.
const VERSIONS_AVANT_APRES = ['cote', 'glisse', 'medaillon'];
const avantApresSection = ({ version = 'glisse', label = 'Avant / après', titre = 'Le titre de la transformation', chapo = 'Le contexte en une phrase : la demande, la contrainte, le délai.', position = '' } = {}) =>
  Section(`br-transformation br-transformation--${version}${position ? ' br-titre--' + position : ''}`, [
    Head([Label(label), H(titre, 2), ...(chapo ? [Lead(chapo)] : [])]),
    Cols([
      Col([Box('br-avap', [Img('avant', '16/10', 'is-style-br-arrondi', 'Avant : décrivez l’état de départ'), P('Avant', 'br-chip br-avap-tag')])]),
      Col([Box('br-avap', [Img('apres', '16/10', 'is-style-br-arrondi', 'Après : décrivez le résultat'), P('Après', 'br-chip br-avap-tag')])]),
    ], 'br-avant-apres'),
    P('Faites glisser le curseur, ou passez la souris sur la photo, pour comparer.', 'br-muted br-glisse-aide'),
  ]);
add('avant-apres', 'confiance', 'Avant / après (3 versions)', 'Montrer une transformation : la photo d’avant et celle d’après. Choisissez la forme dans le panneau « Version » : côte à côte, à faire glisser (une seule photo coupée par un curseur) ou l’après en grand avec l’avant en médaillon. Pour le curseur, les deux photos doivent être prises du même endroit, avec le même cadrage.',
  avantApresSection());

const out = {}; for (const k in S) out[k] = { cat: S[k].cat, title: S[k].title, desc: S[k].desc, markup: S[k].markup };
require('fs').mkdirSync(require('path').join(__dirname, 'build'), { recursive: true });
require('fs').writeFileSync(require('path').join(__dirname, 'build', 'br_sections.json'), JSON.stringify(out, null, 1));
module.exports = { galerieSection, VERSIONS_GALERIE, logosSection, VERSIONS_LOGOS, avantApresSection, VERSIONS_AVANT_APRES, avisSection, temoin, VERSIONS_AVIS, chiffresSection, VERSIONS_CHIFFRES, comparaison, VERSIONS_COMPARAISON, services, serviceItem, VERSIONS_SERVICES, ouverture, VERSIONS_OUVERTURE, deuxPortes, situations, choixSeance, eventail, lieux, faitsIcones, etapesImages, ctaPhoto, avisCourt, tarifLigne, ETOILES, Row, ImgFond, Mark, heroPhoto, confiance, tuiles, zoneSchema, S, cb, serialize, P, H, Label, Lead, Muted, Section, Box, Head, Short, MainBtns, List, fr, CTA, CTA_LABEL, URL, Img, Btn, Btns, Cols, Col, Arrow, Table, Num, teteSplit, teteMosaique, benefices, modeles, etapesPhotos, avantApres, etapesFrise, etapesFil, prixCarte, compris, zoneListe, qualifs, ImgFond };
console.log(Object.keys(S).length, 'sections');
