// Fichier de site : Atelier Ferlune (client fictif, test du process Briise).
const B = require('../build_br_sections.js');
const { cb, serialize, P, H, Label, Lead, Muted, Section, Box, Head, Short, List, fr, CTA, CTA_LABEL, URL } = B;
const { cloneBlock } = require('@wordpress/blocks');

/* Helpers absents des exports du thème (mêmes définitions que build_br_sections.js). */
const IMG = (n) => `{{IMG:${n}}}`;
const Img = (name, ratio, alt, cls = 'is-style-br-arrondi') => cb('core/image', { url: IMG(name), alt: fr(alt), aspectRatio: ratio, scale: 'cover', sizeSlug: 'full', linkDestination: 'none', className: cls });
const Btn = (text, url, cls, extra = {}) => cb('core/button', { text: text === CTA_LABEL ? text : fr(text), url, ...(cls ? { className: cls } : {}), ...extra });
const Btns = (...b) => cb('core/buttons', {}, b);
const Row = (cls, inner) => cb('core/group', { className: cls, layout: { type: 'flex', flexWrap: 'wrap', justifyContent: 'space-between', verticalAlignment: 'bottom' } }, inner);
const Chips = (items) => cb('core/group', { className: 'br-chips', layout: { type: 'flex', flexWrap: 'wrap' } }, items.map((i) => P(i, 'br-chip')));
const Cols = (cols, cls, extra = {}) => cb('core/columns', { ...(cls ? { className: cls } : {}), ...extra }, cols);
const Col = (inner, extra = {}) => cb('core/column', extra, inner);
const A = (t, slug) => `<a href="${URL(slug)}">${t}</a>`;
const Arrow = (t, url) => P(`<a href="${url}">${fr(t)}</a>`, 'br-arrow');
const Details = (q, a) => cb('core/details', { summary: fr(q) }, [P(a)]);
const Table = (head, rows) => cb('core/table', {
  className: 'br-table', hasFixedLayout: false,
  head: [{ cells: head.map((c) => ({ content: fr(c), tag: 'th' })) }],
  body: rows.map((r) => ({ cells: r.map((c) => ({ content: fr(c), tag: 'td' })) })),
});
const sectionHead = (title, link) => Row('br-section-head', [H(title, 2), ...(link ? [Arrow(link[0], link[1])] : [])]);
const Num = (n) => P(n, 'br-num');

/* Photos (fichiers ferlune-*.jpg, placés par nom depuis la Médiathèque). */
const F = (n) => 'ferlune-' + n;
const ESC = F('escalier-droit'), HEL = F('escalier-helicoidal'), GCV = F('garde-corps-verre'), GCT = F('garde-corps-terrasse');
const VC = F('verriere-cuisine'), VB = F('verriere-bureau'), PC = F('portail-coulissant'), PB = F('portail-battant');
const SOUD = F('atelier-soudure'), ATEL = F('atelier'), DET = F('detail-acier'), TH = F('thomas'), PLAN = F('plan-3d');

/* Rythme des couleurs : copie de rythme() de build_br_kits.js. */
const CLAIRS = ['fond', 'surface', 'nuance'];
const fondDe = (b) => (b.name === 'core/cover' ? 'photo' : (b.attributes.backgroundColor || 'fond'));
const passe = (b) => /br-confiance-zone/.test(b.attributes.className || '');
const rythme = (blocks) => {
  const out = [];
  blocks.forEach((b, i) => {
    if (passe(b)) { out.push(b); return; }
    const prev = [...out].reverse().find((x) => !passe(x));
    const f = fondDe(b);
    if (prev && !/br-page-head/.test(prev.attributes.className || '') && fondDe(prev) === f && CLAIRS.includes(f)) {
      const suite = blocks.slice(i + 1).find((x) => !passe(x));
      const next = suite ? fondDe(suite) : null;
      const choix = CLAIRS.find((c) => c !== f && c !== next);
      out.push(cloneBlock(b, { backgroundColor: choix === 'fond' ? undefined : choix }));
    } else out.push(b);
  });
  return out;
};

/* ---------- Sections paramétrées ---------- */
const tete = (h1, lead, bouton = CTA_LABEL) => Section('br-page-head', [Head([
  Short('[briise_fil_ariane]'), H(h1, 1, null, { fontSize: 'huge' }), Lead(lead), Btns(Btn(bouton, CTA)),
])]);
// Pages d'ouvrages : en-tête avec la photo de la page (image mise en avant).
const teteP = (h1, lead, bouton = CTA_LABEL) => cb('core/cover', {
  useFeaturedImage: true, dimRatio: 100, overlayColor: 'sombre', isUserOverlayColor: true, minHeight: 420, minHeightUnit: 'px',
  contentPosition: 'center left', align: 'full', className: 'br-banniere br-tete-photo', layout: { type: 'constrained' },
}, [Box('br-banniere-inner', [Short('[briise_fil_ariane]'), H(h1, 1, null, { fontSize: 'huge' }), Lead(lead), Btns(Btn(bouton, CTA))])]);
const bandeau = (titre, texte, bouton = CTA_LABEL) => Section('br-cta', [Box('br-cta-inner', [
  H(titre, 2), Lead(texte), Btns(Btn(bouton, CTA, null, { backgroundColor: 'fond', textColor: 'texte' })),
])], { backgroundColor: 'secondaire', textColor: 'fond' });
const faq = (titre, qs, bg) => Section('', [Cols([
  Col([Label('Questions fréquentes'), H(titre, 2), Muted('Une autre question ? Thomas vous répond au téléphone.'), Arrow('Poser votre question', CTA)], { width: '38%' }),
  Col(qs.map(([q, a]) => Details(q, a)), { width: '62%' }),
], 'br-split')], bg ? { backgroundColor: bg } : {});
const liees = (titre = 'Nos autres ouvrages') => Section('br-section-liees', [
  sectionHead(titre, ['Voir tous nos ouvrages', URL('ouvrages')]), Short('[briise_pages_liees]'),
], { backgroundColor: 'surface' });
const tarifs = (titre, rows, note) => Section('', [
  Head([Label('Prix indicatifs'), H(titre, 2)]), Table(['Ouvrage', 'Prix posé TTC'], rows), Muted(note),
], { backgroundColor: 'nuance' });
const projet = (img, ouvrage, ville, titre, phrase, alt) => Col([Box('br-project', [Img(img, '4/3', alt), Chips([ouvrage, ville]), H(titre, 3), Muted(phrase)])]);
// Grilles automatiques (fiches de réalisation) : accueil = 3 dernières, page de service = celles du service.
const grille = (titre, lien) => Section('br-section-realisations', [sectionHead(titre, lien),
  Short(titre.startsWith('Nos dernières') ? '[briise_realisations nombre="3"]' : '[briise_realisations service="auto" nombre="3"]')]);
const rangs = (items) => { const r = []; for (let i = 0; i < items.length; i += 3) r.push(Cols(items.slice(i, i + 3), 'br-projects')); return r; };
const alterne = (blocs) => Section('', blocs.map(([img, alt, label, titre, texte], i) => {
  const t = Col([Label(label), H(titre, 2), ...texte.map((x) => P(x))], { width: '50%', verticalAlignment: 'center' });
  const p = Col([Img(img, '4/3', alt)], { width: '50%' });
  return Cols(i % 2 ? [t, p] : [p, t], i % 2 ? 'br-split br-alterne' : 'br-split', { verticalAlignment: 'center' });
}));
const avis = (txt, qui) => Col([Box('br-card br-avis', [cb('core/quote', { citation: fr(qui) }, [P(txt)])])]);
const AVIS = Section('', [
  sectionHead('Ce que disent nos clients', ['Tous les avis sur Google', 'https://www.google.com/maps/search/Atelier+Ferlune+Saran']),
  Cols([
    avis('Thomas a dessiné l’escalier en 3D avant de le fabriquer : le résultat est exactement celui du plan.', 'Claire M., Ingré (avis fictif)'),
    avis('Garde-corps posé en une journée, propre et dans les délais annoncés.', 'Julien R., Olivet (avis fictif)'),
    avis('Très bon conseil sur la verrière, on a gagné beaucoup de lumière dans la cuisine.', 'Sophie L., Saran (avis fictif)'),
  ]),
], { backgroundColor: 'surface' });

/* Récit des pages de service (sections du thème) : en-tête photo, bénéfices, modèles, preuve, déroulé et prix. */
const { teteSplit, teteMosaique, benefices, modeles, etapesPhotos, etapesFrise, etapesFil, prixCarte, compris, avantApres, heroPhoto, confiance, tuiles, zoneSchema, zoneListe, qualifs, ImgFond } = B;
const CONF = [['garantie', 'Garantie décennale', '10 ans, attestation jointe au devis'], ['plan', 'Plan 3D offert', 'Votre ouvrage vu dans votre pièce'], ['atelier', '100 % fait à Saran', 'Sans sous-traitance ni catalogue'], ['delai', 'Devis sous 5 jours', 'Après une visite gratuite']];
const conseil = (t = 'Vous hésitez ? Thomas vous conseille pendant la visite gratuite') => Arrow(t, CTA);
const guideCarte = (titre, texte, slug) => Col([Box('br-card', [H(titre, 3), Muted(texte), Arrow('Lire le guide', URL(slug))])]);
// La preuve : les réalisations du service, et qui les fabrique (une ligne, une photo, le lien vers l'atelier).
const preuve = (titre) => Section('br-section-realisations', [
  sectionHead(titre, ['Toutes nos réalisations', URL('realisations')]),
  Short('[briise_realisations service="auto" nombre="3"]'),
  Box('br-qui', [Img(TH, '1/1', 'Thomas Ferlune au poste de soudure de l’atelier', 'br-qui-photo'), P(`Fabriqués par Thomas et Karim dans notre atelier de Saran, depuis 2011. ${A('L’histoire de l’Atelier Ferlune', 'atelier')}.`)]),
]);
const prixTable = (rows, note, oui, non) => [prixCarte(rows, note), ...(oui ? [compris(oui, non)] : [])];

/* ---------- Pages ---------- */
const pages = [];
const page = (slug, titre, seo_titre, seo_description, blocs, extra = {}) =>
  pages.push({ slug, titre, seo_titre, seo_description, markup: serialize(rythme(blocs)), ...extra });

// Accueil
page('accueil', 'Accueil', 'Métallier à Saran : escaliers, garde-corps sur mesure',
  'Atelier Ferlune dessine, fabrique à Saran et pose escaliers, garde-corps, verrières et portails sur mesure. Devis et plan 3D sous 5 jours.', [
  heroPhoto({
    pastille: 'Métallerie sur mesure · Saran',
    titre: 'Escaliers, garde-corps et verrières sur mesure,', accent: 'fabriqués à Saran',
    chapo: 'Nous dessinons vos ouvrages en acier, les fabriquons dans notre atelier et les posons chez vous, dans un rayon de 35 km. Le devis est gratuit.',
    second: ['Voir nos réalisations', URL('realisations')],
    coches: ['Visite et devis gratuits', 'Plan 3D sous 5 jours', 'Garantie décennale'],
    img: ESC, alt: 'Escalier en acier noir à main courante lumineuse et marches en bois clair',
    etiquettes: [['Escalier droit posé', 'dès 4 800 €'], ['Fabriqué à Saran', 'depuis 2011']],
  }),
  Section('', [
    sectionHead('Ce que nous fabriquons', ['Tous nos ouvrages sur mesure', URL('ouvrages')]),
    P(`Escaliers, garde-corps et verrières d’intérieur, et aussi ${A('nos portails et portillons en acier', 'portails')}.`),
    Cols([
      ['01', 'Escaliers métalliques', 'Droits, quart tournants ou hélicoïdaux, marches en acier ou en chêne.', 'Escaliers métalliques en détail', 'escaliers-metalliques', HEL, 'Escalier hélicoïdal en acier et verre vu d’en haut'],
      ['02', 'Garde-corps et rampes', 'Pour une mezzanine, un escalier ou une terrasse, en acier ou en acier et verre.', 'Garde-corps en détail', 'garde-corps', GCV, 'Garde-corps en verre sur une terrasse en hauteur'],
      ['03', 'Verrières d’intérieur', 'Une verrière atelier pour faire entrer la lumière sans ouvrir la pièce.', 'Verrières d’intérieur en détail', 'verrieres-interieur', VC, 'Verrière noire entre une cuisine blanche et la salle à manger'],
    ].map(([n, t, d, l, s, img, alt]) => Col([Box('br-card', [ImgFond(img, 'br-card-fond', alt), Num(n), H(t, 3), Muted(d), Arrow(l, URL(s))])]))),
  ], { backgroundColor: 'surface' }),
  grille('Nos dernières réalisations', ['Toutes nos réalisations', URL('realisations')]),
  qualifs(),
  etapesFrise('Votre projet en quatre étapes', [
    ['Visite et mesures', 'Thomas vient chez vous, écoute votre projet et prend les cotes.', 'Gratuite'],
    ['Plan 3D et devis', 'Vous recevez le devis et le plan 3D de l’ouvrage dans votre pièce.', 'Sous 5 jours ouvrés'],
    ['Fabrication à l’atelier', 'Découpe, soudure et finition à Saran, selon l’ouvrage.', '3 à 8 semaines'],
    ['Pose', 'Ceux qui ont fabriqué votre ouvrage viennent le poser.'],
  ]),
  AVIS,
  zoneListe('Zone d’intervention', 'Nous intervenons à Saran et à 35 km autour', 'Métropole d’Orléans, Beauce et Val de Loire. La visite et le devis sont gratuits dans toute la zone.', ['Toutes les communes où nous intervenons', URL('zone-intervention')]),
  bandeau('Un projet d’escalier, de garde-corps ou de verrière ?', 'Le devis est gratuit, avec un plan 3D de votre ouvrage.'),
]);

// Ouvrages (page parente)
page('ouvrages', 'Ouvrages sur mesure', 'Métallerie sur mesure près d’Orléans : nos ouvrages',
  'Escaliers, garde-corps, verrières d’intérieur et portails en acier, dessinés en 3D et fabriqués dans notre atelier de Saran. Devis gratuit.', [
  teteSplit('Métallerie sur mesure : nos ouvrages', 'Chaque ouvrage est dessiné pour votre maison, fabriqué dans notre atelier de Saran et posé par l’équipe qui l’a fabriqué.'),
  Section('br-section-liees', [H('Chaque ouvrage en détail', 2), Short('[briise_pages_liees]')], { backgroundColor: 'surface' }),
  alterne([[ATEL, 'L’atelier de Saran : établis, pont roulant et presse plieuse', 'L’atelier', 'Fabriqué à Saran, dans la teinte de votre choix', [
    'Nous travaillons l’acier dans notre atelier de Saran : découpe, soudure, assemblage. Rien n’est sous-traité, rien ne vient d’un catalogue.',
    'Le thermolaquage est réalisé chez un partenaire situé à 15 km, dans toutes les teintes RAL. Pour les escaliers, les marches peuvent être en acier ou en chêne.',
  ]]]),
  faq('Les questions qu’on nous pose', [
    ['Le devis est-il gratuit ?', 'Oui. Thomas vient prendre les mesures chez vous, puis vous recevez le devis et un plan 3D sous 5 jours ouvrés.'],
    ['Êtes-vous couverts par une garantie décennale ?', 'Oui. Atelier Ferlune est assurée en garantie décennale ; l’attestation est jointe à chaque devis (fictif).'],
    ['Quels sont vos délais ?', 'Comptez 3 à 5 semaines pour un garde-corps, 3 à 4 semaines pour une verrière, 5 à 7 semaines pour un portail et 6 à 8 semaines pour un escalier, à partir de l’acceptation du devis.'],
    ['Faites-vous le dépannage de serrures ?', 'Non. Nous ne faisons plus de serrurerie ni de portes de garage : nous fabriquons uniquement des ouvrages sur mesure.'],
  ], 'nuance'),
  Section('', [
    sectionHead('Nos guides pour bien choisir'),
    Cols([
      guideCarte('Escalier quart tournant', 'Haut ou bas, gauche ou droit, et le calcul de la place au sol.', 'escalier-quart-tournant-dimensions'),
      guideCarte('Verrière de cuisine', 'Ce qu’elle apporte, ses limites, le vitrage et le prix.', 'verriere-cuisine'),
      guideCarte('Norme garde-corps', 'Ce que change la norme révisée depuis 2026.', 'norme-garde-corps'),
    ]),
  ], { backgroundColor: 'surface' }),
  bandeau('Un ouvrage sur mesure en tête ?', 'Décrivez-nous votre projet : nous venons prendre les mesures, gratuitement.'),
], { menu: true, image: SOUD });

// Escaliers
page('escaliers-metalliques', 'Escaliers métalliques', 'Escalier métallique sur mesure à Saran, dès 4 800 €',
  'Escaliers en acier droits, quart tournants, hélicoïdaux ou à limon central, fabriqués à Saran et posés. Devis gratuit avec plan 3D.', [
  teteSplit('Escaliers métalliques sur mesure', 'Un escalier en acier dessiné à vos cotes, fabriqué dans notre atelier de Saran et posé chez vous : à partir de 4 800 € posé pour un escalier droit, 6 à 8 semaines de fabrication.', 'Demander un devis pour votre escalier'),
  confiance(CONF),
  benefices('Pourquoi un escalier en acier', [
    [HEL, 'Escalier hélicoïdal en acier et verre, baigné de lumière', 'Il laisse passer la lumière', 'L’acier est si solide qu’une structure fine suffit. L’escalier paraît léger, et la pièce garde sa lumière et sa profondeur.'],
    [DET, 'Soudure en cours à l’atelier, sous les étincelles', 'Il ne grince pas', 'Les pièces sont soudées : rien ne prend de jeu avec les années. Avec des marches en chêne, le bruit des pas reste doux.'],
    [PLAN, 'Plan d’un escalier en acier tracé avant la fabrication', 'Il passe chez vous, même si rien n’est droit', 'Nous le dessinons à vos cotes, relevées au laser, et vous le voyez en 3D dans votre pièce avant la fabrication.'],
  ]),
  modeles('Droit, quart tournant, hélicoïdal ou limon central ?', 'Le bon escalier dépend surtout de la place dont vous disposez et de l’endroit où il doit arriver à l’étage.', [
    [ESC, 'Escalier en acier noir à main courante lumineuse', 'Droit', [['Place : ', 'la plus longue, environ 3,5 m pour un étage.'], ['Confort : ', 'le plus confortable.'], ['Prix posé : ', 'dès 4 800 €.'], ['Idéal pour : ', 'un long mur libre.']]],
    [PLAN, 'Plan d’un escalier qui tourne sur un palier', 'Quart tournant', [['Place : ', `il tourne dans un angle, moins long qu’un droit. ${A('Calculer la place d’un quart tournant', 'escalier-quart-tournant-dimensions')}.`], ['Confort : ', 'très bon.'], ['Prix posé : ', '7 000 à 14 000 €.'], ['Idéal pour : ', 'arriver à l’étage dans une autre direction.']]],
    [HEL, 'Escalier hélicoïdal en acier et verre', 'Hélicoïdal', [['Place : ', 'un cercle de 1,20 à 1,60 m de diamètre.'], ['À savoir : ', 'monter un meuble y est difficile.'], ['Prix posé : ', '9 000 à 16 000 € (fictif).'], ['Idéal pour : ', `une petite entrée, des combles. ${A('Tout sur l’escalier hélicoïdal', 'escalier-helicoidal')}.`]]],
    [SOUD, 'Soudure d’une pièce d’escalier à l’atelier', 'Limon central', [['Ce que c’est : ', 'une seule poutre sous les marches, l’escalier semble flotter.'], ['Place : ', 'celle d’un droit ou d’un quart tournant.'], ['Prix posé : ', '9 000 à 16 000 € (fictif).'], ['Idéal pour : ', 'une pièce de vie lumineuse.']]],
  ], [Muted(`Marches en chêne ou en acier, sur toutes les formes : le chêne apporte de la chaleur et adoucit le bruit des pas ; l’acier ne demande aucun entretien et reçoit un revêtement antidérapant discret. La rampe et ${A('le garde-corps de mezzanine', 'garde-corps')} sont fabriqués dans le même acier.`), conseil()]),
  preuve('Des escaliers réalisés près de chez vous'),
  avantApres('Du plan 3D à la pose', 'L’escalier que vous validez, l’escalier que vous recevez', 'Avant la fabrication, vous voyez votre escalier en plan et en 3D. Voici le plan validé par un client, et l’escalier posé six semaines plus tard (fictif).',
    [PLAN, 'Plan de l’escalier en acier, validé avant la fabrication', 'Plan 3D'], [ESC, 'Le même escalier posé, main courante éclairée', 'Posé']),
  etapesFil('De la visite à la pose, et le prix', [
    ['La visite', 'Thomas mesure au laser la hauteur à monter et la trémie, c’est-à-dire l’ouverture dans le plafond.', 'Gratuite'],
    ['Le plan 3D et le devis', 'Vous voyez l’escalier dans votre pièce et recevez le prix définitif.', 'Sous 5 jours ouvrés'],
    ['La fabrication', 'À l’atelier de Saran : découpe, soudure, thermolaquage dans la teinte choisie.', '6 à 8 semaines'],
    ['La pose', 'Par ceux qui l’ont fabriqué. L’ancien escalier est démonté et emporté (fictif).', '1 à 2 jours'],
  ], prixTable([['Escalier droit', 'À partir de 4 800 €'], ['Quart tournant', '7 000 à 14 000 €'], ['Hélicoïdal ou limon central', '9 000 à 16 000 € (fictif)']],
    'Ce qui fait varier le prix : le nombre de marches, la forme, les marches en chêne, la rampe et la teinte. Le prix du devis ne change plus ensuite.',
    ['La visite et la prise des cotes', 'Le plan 3D de l’escalier dans votre pièce', 'La fabrication et le thermolaquage dans la teinte choisie', 'La pose par l’équipe de l’atelier', 'Le démontage et l’enlèvement de l’ancien escalier'],
    ['L’agrandissement de la trémie, l’ouverture dans le plafond : c’est un travail de maçon, nous vous orientons (fictif)', 'Les reprises de peinture autour de l’escalier'])),
  faq('Vos questions sur les escaliers', [
    ['Un escalier en métal est-il bruyant ?', 'Moins qu’on ne le croit. La structure soudée ne grince pas ; le bruit vient des marches. Avec des marches en chêne, ou un revêtement sur les marches en acier, le pas reste discret.'],
    ['Escalier en kit ou sur mesure : lequel choisir ?', 'Un escalier en kit coûte moins cher mais suit des dimensions standard. Si votre trémie, votre hauteur sous plafond ou vos murs sortent du standard, le sur-mesure s’adapte à votre maison, et vous voyez le résultat en 3D avant la fabrication.'],
    ['J’ai de jeunes enfants : les marches ouvertes sont-elles dangereuses ?', 'Nous pouvons fermer l’espace entre les marches avec des contremarches, ou le réduire avec une barre. Nous en parlons pendant la visite, selon l’âge des enfants.'],
    ['Quelle hauteur pour la rampe ?', `Elle doit respecter la norme NF P01-012 révisée, qui couvre aussi les rampes d’escalier. Nous expliquons ce qu’elle impose dans ${A('notre guide sur la hauteur réglementaire d’une rampe', 'norme-garde-corps')}.`],
  ], 'nuance'),
  liees(),
  bandeau('Un projet d’escalier ?', 'Visite et devis gratuits, plan 3D sous 5 jours ouvrés.', 'Demander un devis pour votre escalier'),
], { parent: 'ouvrages', menu: true, menu_description: 'Droits, quart tournants, à limon central', image: ESC });

// Escalier hélicoïdal
page('escalier-helicoidal', 'Escalier hélicoïdal', 'Escalier hélicoïdal en métal sur mesure à Saran',
  'Escalier hélicoïdal en acier, rond ou carré, dessiné au bon diamètre et fabriqué à Saran. Moins de 2 m² au sol. Devis gratuit avec plan 3D.', [
  teteSplit('Escalier hélicoïdal sur mesure', 'Un escalier en colimaçon en acier, dessiné au diamètre qui convient à votre pièce et fabriqué dans notre atelier de Saran : à partir de 9 000 € posé (fictif), 6 à 8 semaines de fabrication.', 'Demander un devis pour votre escalier'),
  confiance(CONF),
  benefices('Un escalier qui tient dans un coin de pièce', [
    [PLAN, 'Plan d’escalier tracé à l’atelier', 'Moins de 2 m² au sol', 'Un hélicoïdal de 1,40 m de diamètre tient dans un carré de 1,40 m de côté. Un escalier droit demande environ 3,5 m de long.'],
    [DET, 'Soudure soignée à l’atelier, sous les étincelles', 'Une vraie pièce de décoration', 'Il se voit sous tous les angles : nous soignons chaque soudure, et vous choisissez la teinte, les marches et la main courante.'],
    [ATEL, 'L’atelier de Saran, où l’escalier est préparé en plusieurs parties', 'Pas de gros travaux', 'Il est livré en plusieurs parties qui passent par une porte, puis assemblé chez vous en une journée.'],
  ]),
  modeles('Rond ou carré, et quel diamètre ?', 'Plus le diamètre est grand, plus l’escalier est confortable. Le bon choix dépend de la place et de l’usage : un accès de temps en temps ou l’escalier principal de la maison.', [
    [HEL, 'Escalier hélicoïdal rond en acier et verre', 'Rond', [['Idéal pour : ', 'le milieu d’une pièce ou une trémie ronde.'], ['Ce qui plaît : ', 'le plus léger à l’œil.'], ['Prix posé : ', '9 000 à 12 000 € (fictif).']]],
    [SOUD, 'Soudure d’un escalier à l’atelier', 'Carré', [['Idéal pour : ', 'un angle de pièce ou une trémie carrée.'], ['Ce qui plaît : ', 'aucune place perdue dans les coins.'], ['Prix posé : ', '12 000 à 16 000 € (fictif), un peu plus d’acier.']]],
  ], [
    Table(['Diamètre', 'Place au sol', 'Confort', 'Idéal pour'], [
      ['1,20 m', 'Environ 1,5 m²', 'Passage étroit', 'Des combles, un accès occasionnel'],
      ['1,40 m', 'Environ 2 m²', 'Correct au quotidien', 'Une mezzanine, une chambre à l’étage'],
      ['1,60 m et plus', 'À partir de 2,6 m²', 'Confortable, même un carton dans les bras', 'L’escalier principal de la maison'],
    ]),
    Muted('Métal ou béton ? Un hélicoïdal en béton est massif et très silencieux, mais il pèse plusieurs tonnes : il faut souvent renforcer le plancher. En acier, il reste fin et se pose en une journée ; avec des marches en chêne, il gagne en chaleur et en silence.'),
    Box('br-card', [H('À savoir avant de choisir', 3), List([
      'Monter un meuble encombrant est difficile : un lit ou une armoire passe démonté, ou par une fenêtre.',
      'Les marches sont plus étroites côté centre : on pose le pied côté extérieur.',
      `Pour une personne âgée, ${A('un escalier quart tournant', 'escalier-quart-tournant-dimensions')} reste plus confortable.`,
    ])]),
    conseil(),
  ]),
  preuve('Escaliers hélicoïdaux réalisés'),
  etapesFil('De la visite à la pose, et le prix', [
    ['La visite', 'Thomas mesure la hauteur à monter et la trémie : son ouverture doit être au moins aussi grande que l’escalier.', 'Gratuite'],
    ['Le plan 3D', 'Nous comparons deux ou trois diamètres dans votre pièce, pour voir le passage et la place qui reste.', 'Sous 5 jours ouvrés'],
    ['La fabrication', 'Chaque marche est découpée au laser et soudée sur le fût central.', '6 à 8 semaines'],
    ['La pose', 'Livré en plusieurs parties et assemblé sur place, avec la main courante et le garde-corps de l’étage.', 'En une journée'],
  ], prixTable([['Rond, 1,20 à 1,40 m', '9 000 à 12 000 € (fictif)'], ['Rond de 1,60 m et plus, ou carré', '12 000 à 16 000 € (fictif)']],
    'Ce qui fait varier le prix : le diamètre, la hauteur à monter, les marches en chêne et le garde-corps autour de la trémie à l’étage.')),
  faq('Vos questions sur l’escalier hélicoïdal', [
    ['Quel est le diamètre minimum d’un escalier hélicoïdal ?', 'Nous descendons rarement sous 1,20 m : en dessous, le passage devient trop étroit pour un usage régulier. Pour monter tous les jours, comptez 1,40 m ou plus.'],
    ['Escalier hélicoïdal ou colimaçon : quelle différence ?', 'Aucune : ce sont deux noms pour le même escalier, dont les marches tournent autour d’un axe central.'],
    ['Peut-on avoir des marches en bois ?', 'Oui. Les marches en chêne se fixent sur la structure en acier ; elles adoucissent le bruit des pas et réchauffent l’ensemble.'],
    ['Est-il sûr pour les enfants ?', `Oui, avec un garde-corps à barreaux verticaux le long de l’escalier et autour de la trémie, à la hauteur fixée par ${A('la norme garde-corps révisée', 'norme-garde-corps')}.`],
  ], 'nuance'),
  liees(),
  bandeau('Un escalier hélicoïdal pour votre maison ?', 'Visite et devis gratuits, avec plusieurs diamètres comparés en 3D.', 'Demander un devis pour votre escalier'),
], { parent: 'ouvrages', menu: true, menu_description: 'Gain de place, autour d’un fût central', image: HEL });

// Garde-corps
page('garde-corps', 'Garde-corps et rampes', 'Garde-corps sur mesure à Saran, dès 390 € le mètre',
  'Garde-corps et rampes en acier ou acier et verre pour mezzanine, escalier ou terrasse, conformes à la norme révisée. Fabriqués à Saran.', [
  teteSplit('Garde-corps et rampes sur mesure', 'Garde-corps de mezzanine, d’escalier ou de terrasse, fabriqués à Saran et posés en 3 à 5 semaines : à partir de 390 € le mètre linéaire posé.', 'Demander un devis pour votre garde-corps'),
  confiance(CONF),
  benefices('Un garde-corps qui protège sans enfermer', [
    [GCT, 'Garde-corps à barreaux verticaux en acier le long d’une allée', 'Vos enfants en sécurité', `Chaque garde-corps suit la norme révisée en 2024 : hauteur, écart entre les barreaux, rien sur quoi grimper. ${A('Ce que dit la norme', 'norme-garde-corps')}.`],
    [HEL, 'Garde-corps en verre le long d’un escalier hélicoïdal', 'La vue et la lumière gardées', 'Des montants fins, du verre ou des barreaux espacés : la mezzanine reste ouverte sur la pièce.'],
    [DET, 'Soudure à l’atelier, avant galvanisation et thermolaquage', 'Presque aucun entretien', 'L’acier est thermolaqué, c’est-à-dire recouvert d’une peinture cuite au four. Dehors, il est aussi galvanisé contre la rouille.'],
  ]),
  modeles('Barreaux, verre, câbles ou tôle perforée ?', 'Le remplissage, c’est ce qui ferme l’espace entre la main courante et le sol. Il décide du style, de la vue et du prix.', [
    [GCT, 'Garde-corps à barreaux verticaux en acier', 'Barreaux verticaux', [['Vous voyez : ', 'un style atelier, la vue en partie dégagée.'], ['Avec de jeunes enfants : ', 'très sûr, rien à escalader.'], ['Prix posé : ', 'dès 390 € le mètre.']]],
    [GCV, 'Garde-corps en verre sur une terrasse en hauteur', 'Verre', [['Vous voyez : ', 'la vue entièrement dégagée, toute la lumière.'], ['Avec de jeunes enfants : ', 'très sûr, rien à escalader.'], ['Entretien : ', 'les traces de doigts à nettoyer.'], ['Prix posé : ', 'dès 650 € le mètre (fictif).']]],
    [ATEL, 'L’atelier de Saran, où les garde-corps sont fabriqués', 'Câbles tendus', [['Vous voyez : ', 'presque rien, très léger.'], ['Avec de jeunes enfants : ', 'déconseillé, les câbles horizontaux s’escaladent.'], ['Prix posé : ', 'dès 450 € le mètre (fictif).']]],
    [PC, 'Tôle d’acier découpée de motifs, ici sur un portail', 'Tôle perforée', [['Vous voyez : ', 'un écran graphique qui cache sans assombrir.'], ['Avec de jeunes enfants : ', 'très sûr, rien à escalader.'], ['Prix posé : ', 'dès 480 € le mètre (fictif).']]],
  ], [Muted(`Pour un escalier, la rampe et le garde-corps sont assortis, ou dessinés avec ${A('un escalier en acier sur mesure', 'escaliers-metalliques')}.`), conseil()]),
  preuve('Garde-corps réalisés près de chez vous'),
  etapesFil('De la visite à la pose, et le prix', [
    ['La visite', 'Thomas regarde sur quoi le garde-corps sera fixé : dalle, bord de mezzanine, mur ou terrasse étanche.', 'Gratuite'],
    ['Le plan 3D et le devis', 'Avec la hauteur et l’écartement conformes à la norme.', 'Sous 5 jours ouvrés'],
    ['La fabrication', 'À l’atelier de Saran, thermolaquage compris.', '3 à 5 semaines'],
    ['La pose', 'Vous recevez le certificat de conformité pour votre assurance.', 'Le plus souvent en une journée'],
  ], prixTable([['Garde-corps acier', 'À partir de 390 € le mètre linéaire'], ['Garde-corps acier et verre', 'À partir de 650 € le mètre linéaire (fictif)'], ['Rampe d’escalier seule', 'À partir de 180 € le mètre linéaire (fictif)']],
    'Ce qui fait varier le prix : la longueur, le remplissage, les fixations et la teinte. Le prix du devis est le prix final.')),
  faq('Vos questions sur les garde-corps', [
    ['Quelle hauteur pour un garde-corps de mezzanine ?', 'Au moins 1 mètre, mesuré depuis la zone où l’on se tient ; la norme révisée demande une hauteur plus grande si un appui permet de grimper. Nous vérifions chaque cas lors de la visite.'],
    ['Mon garde-corps actuel est-il aux normes ?', 'La norme révisée s’applique aux nouveaux travaux, pas aux garde-corps existants. Si vous remplacez ou ajoutez un garde-corps, il doit la respecter. Lors de la visite, Thomas vous dit si le vôtre présente un risque, par exemple pour un jeune enfant.'],
    ['Et si le verre se casse ?', 'Nous posons du verre feuilleté : deux vitres collées par un film. S’il casse, les morceaux restent collés au film et le garde-corps continue de retenir.'],
    ['Un garde-corps de terrasse rouille-t-il ?', 'Non s’il est galvanisé puis thermolaqué : le zinc protège l’acier, la peinture protège le zinc. Un rinçage à l’eau une fois par an suffit.'],
  ], 'nuance'),
  liees(),
  bandeau('Un garde-corps à créer ou à remplacer ?', 'Visite et devis gratuits, plan 3D sous 5 jours ouvrés.', 'Demander un devis pour votre garde-corps'),
], { parent: 'ouvrages', menu: true, menu_description: 'Mezzanines, escaliers, terrasses', image: GCV });

// Verrières
page('verrieres-interieur', 'Verrières d’intérieur', 'Verrière d’intérieur sur mesure à Saran, dès 750 €/m²',
  'Verrières atelier en acier dessinées à vos dimensions, fabriquées à Saran et posées en une journée. Devis gratuit avec plan 3D.', [
  teteSplit('Verrières d’intérieur sur mesure', 'Une verrière atelier en acier, dessinée à vos dimensions et fabriquée à Saran : à partir de 750 € le m² posé, 3 à 4 semaines de fabrication.', 'Demander un devis pour votre verrière'),
  confiance(CONF),
  benefices('La lumière d’une pièce ouverte, le calme d’une pièce fermée', [
    [VB, 'Cloison vitrée à profils noirs dans un bureau lumineux', 'La lumière du jour partout', 'Une pièce sombre, un couloir ou une entrée reçoivent la lumière des fenêtres voisines.'],
    [VC, 'Verrière noire entre une cuisine et la salle à manger', 'Les odeurs et le bruit restent de leur côté', 'Contrairement à une cuisine ouverte, la verrière sépare les pièces. Avec un vitrage acoustique, le bruit passe beaucoup moins.'],
    [SOUD, 'Profil de verrière soudé à l’atelier', 'Sans gros travaux', 'Fabriquée à l’atelier et posée en une journée, sur une cloison existante ou entre le sol et le plafond.'],
  ]),
  modeles('Quelle verrière pour quelle pièce ?', 'Quatre façons de poser une verrière, selon ce que vous voulez séparer.', [
    [VC, 'Verrière noire de cuisine', 'Sur un muret', [['Posée : ', 'sur un muret d’environ 1 m.'], ['Idéal pour : ', `${A('une cuisine', 'verriere-cuisine')} qui garde ses meubles hauts.`], ['Prix posé : ', 'dès 750 € le m².']]],
    [VB, 'Cloison vitrée toute hauteur à profils noirs', 'Toute hauteur', [['Posée : ', 'du sol au plafond, sans cloison.'], ['Idéal pour : ', 'séparer un bureau ou une chambre d’un séjour.'], ['Prix posé : ', 'dès 750 € le m².']]],
    [VB, 'Cloison vitrée avec porte, profils noirs', 'Avec porte', [['Posée : ', 'toute hauteur, porte battante ou coulissante.'], ['Idéal pour : ', 'un bureau, une suite parentale.'], ['Prix posé : ', 'porte en plus (fictif).']]],
    [DET, 'Assemblage d’un profil en acier à l’atelier', 'Petite verrière haute', [['Posée : ', 'en bande en haut d’une cloison.'], ['Idéal pour : ', 'une entrée ou un couloir sombre, une salle de bains.'], ['Prix posé : ', 'dès 750 € le m².']]],
  ], [Muted('Côté vitrage : clair pour la lumière, dépoli pour ne pas être vu (salle de bains, chambre), feuilleté acoustique pour le bruit (bureau, séjour).'), conseil()]),
  preuve('Verrières réalisées près de chez vous'),
  etapesFil('De la visite à la pose, et le prix', [
    ['La visite', 'Thomas vérifie la cloison. Si c’est un mur porteur, il faut d’abord l’ouvrir avec un maçon : nous vous le disons tout de suite.', 'Gratuite'],
    ['Le plan 3D et le devis', 'Avec les traverses alignées sur vos meubles.', 'Sous 5 jours ouvrés'],
    ['La fabrication', 'Les profils en acier sont coupés, soudés et laqués à l’atelier de Saran.', '3 à 4 semaines'],
    ['La pose', 'Les reprises de plâtre sont faites par notre partenaire plaquiste (fictif).', 'En une journée'],
  ], prixTable([['Verrière atelier en acier', 'À partir de 750 € le m²'], ['Exemple : verrière de cuisine de 2,40 × 1,20 m', 'Environ 2 200 € posée (fictif)']],
    'Ce qui fait varier le prix : la surface, la présence d’une porte, le type de vitrage et la teinte.')),
  faq('Vos questions sur les verrières', [
    ['Une verrière d’intérieur laisse-t-elle passer le bruit ?', 'Oui, davantage qu’un mur plein. Nous proposons un vitrage feuilleté acoustique qui réduit nettement le passage du bruit, par exemple entre une cuisine et un salon (fictif).'],
    ['Est-ce difficile à nettoyer ?', `Comme une fenêtre, avec un produit à vitres. Côté cuisine, comptez un nettoyage un peu plus fréquent : nous en parlons dans ${A('notre guide de la verrière de cuisine', 'verriere-cuisine')}.`],
    ['Combien de temps pour la fabrication ?', '3 à 4 semaines après l’acceptation du devis, puis une journée de pose.'],
  ], 'nuance'),
  liees(),
  bandeau('Plus de lumière dans votre maison ?', 'Visite et devis gratuits, plan 3D sous 5 jours ouvrés.', 'Demander un devis pour votre verrière'),
], { parent: 'ouvrages', menu: true, menu_description: 'Atelier, pour faire entrer la lumière', image: VC });

// Portails
page('portails', 'Portails et portillons', 'Portail acier sur mesure à Saran : battant, coulissant',
  'Portails en acier battants ou coulissants et portillons, galvanisés et thermolaqués, fabriqués à Saran en 5 à 7 semaines. Devis gratuit.', [
  teteSplit('Portails et portillons en acier sur mesure', 'Portails battants ou coulissants et portillons assortis, fabriqués dans notre atelier de Saran en 5 à 7 semaines : à partir de 2 900 € posé pour un portail battant (fictif).', 'Demander un devis pour votre portail'),
  confiance(CONF),
  benefices('Un portail en acier fait pour durer', [
    [PB, 'Portail battant et portillon en métal blanc', 'Pas de rouille, pas de peinture à refaire', 'Il est galvanisé, plongé dans un bain de zinc qui protège l’acier, puis thermolaqué : une peinture cuite au four, dans la teinte de votre choix.'],
    [ATEL, 'L’atelier de Saran, où chaque portail est fabriqué à vos mesures', 'Fait pour votre entrée', 'Une allée en pente, des piliers qui ne sont pas d’aplomb, une largeur hors standard : nous le dessinons à vos mesures.'],
    [DET, 'Soudure d’un cadre de portail à l’atelier', 'Tout assorti', 'Portillon, clôture et boîte aux lettres reprennent le même dessin et la même teinte.'],
  ]),
  modeles('Battant ou coulissant ?', 'Tout dépend de la place derrière le portail et de la pente de votre allée.', [
    [PB, 'Portail battant à deux vantaux et portillon', 'Battant', [['Place : ', 'derrière le portail, l’ouverture des deux vantaux.'], ['Allée en pente : ', 'difficile, les vantaux frottent.'], ['Motorisation : ', 'simple et économique.'], ['Prix posé : ', 'dès 2 900 € (fictif).']]],
    [PC, 'Portail coulissant gris en tôle découpée', 'Coulissant', [['Place : ', 'sur le côté, la largeur du passage.'], ['Allée en pente : ', 'aucun problème, il ne touche pas le sol.'], ['Motorisation : ', 'recommandée au-delà de 4 m.'], ['Prix posé : ', 'dès 3 800 € (fictif).']]],
  ], [Muted('Acier ou aluminium ? L’acier est plus lourd et très rigide : il résiste aux chocs et se répare par soudure ; galvanisé et thermolaqué, il ne rouille pas. L’aluminium ne rouille jamais et pèse moins lourd, mais il se déforme plus facilement sous un choc. Nous ne le fabriquons pas : si c’est votre choix, nous vous le dirons honnêtement.'), conseil()]),
  preuve('Portails réalisés près de chez vous'),
  etapesFil('De la visite à la pose, et le prix', [
    ['La visite', 'Thomas mesure l’entrée, la pente et les piliers, et regarde où passer le câble du moteur.', 'Gratuite'],
    ['Le plan et la mairie', 'Avec le devis, vous recevez le plan et la teinte : de quoi faire la déclaration en mairie si votre commune la demande.'],
    ['La fabrication', 'Soudure, galvanisation, thermolaquage.', '5 à 7 semaines'],
    ['La pose', 'Un électricien partenaire raccorde le moteur (fictif).', '1 à 2 jours'],
  ], prixTable([['Portail battant', 'À partir de 2 900 € (fictif)'], ['Portail coulissant', 'À partir de 3 800 € (fictif)'], ['Portillon assorti', 'À partir de 900 € (fictif)']],
    'Ce qui fait varier le prix : la largeur, le type d’ouverture, le dessin du remplissage, la motorisation et la teinte.')),
  faq('Vos questions sur les portails', [
    ['Faut-il une autorisation pour changer de portail ?', 'Cela dépend de votre commune : le plan local d’urbanisme peut demander une déclaration préalable ou imposer une hauteur ou une teinte. Renseignez-vous en mairie avant la commande ; nous vous fournissons le plan et la teinte pour votre dossier.'],
    ['Un portail en acier rouille-t-il ?', 'Non s’il est galvanisé puis thermolaqué, comme tous les nôtres. Un lavage à l’eau une ou deux fois par an suffit.'],
    ['Peut-on le motoriser plus tard ?', 'Oui, à condition de le prévoir dès la fabrication : nous ajoutons les renforts et le passage du câble, même si le moteur arrive plus tard.'],
  ], 'nuance'),
  liees(),
  bandeau('Un portail à remplacer ?', 'Visite et devis gratuits, plan 3D sous 5 jours ouvrés.', 'Demander un devis pour votre portail'),
], { parent: 'ouvrages', menu: true, menu_description: 'Battants ou coulissants, motorisés', image: PC });

// Réalisations
page('realisations', 'Réalisations', 'Nos réalisations : escaliers, garde-corps, verrières',
  'Escaliers, garde-corps, verrières et portails fabriqués dans notre atelier de Saran et posés autour d’Orléans : photos de chantiers avec la commune.', [
  teteSplit('Nos réalisations en métallerie', 'Des chantiers récents, avec la commune et l’année. Chaque ouvrage est fabriqué dans notre atelier de Saran.', CTA_LABEL),
  Section('br-section-realisations', [
    Short('[briise_realisations filtres="1"]'),
    P(`Des chantiers dans votre secteur ? ${A('Voir notre zone d’intervention', 'zone-intervention')}. Qui viendra chez vous ? ${A('Thomas ou Karim, l’équipe de l’atelier', 'atelier')}.`),
  ]),
  Section('', [
    Head([Label('Du plan à la pose'), H('L’escalier validé sur plan, puis posé', 2), Lead('Le plan remis avec le devis, et le même escalier six semaines plus tard (fictif).')]),
    Cols([
      Col([Box('br-avap', [Img(PLAN, '4/3', 'Plan de l’escalier en acier, validé avant la fabrication'), P('Plan', 'br-chip br-avap-tag')])]),
      Col([Box('br-avap', [Img(ESC, '4/3', 'Le même escalier posé, main courante éclairée'), P('Posé', 'br-chip br-avap-tag')])]),
    ], 'br-avant-apres'),
  ], { backgroundColor: 'nuance' }),
  AVIS,
  bandeau('Un projet comparable ?', 'Visite et devis gratuits, plan 3D sous 5 jours ouvrés.'),
], { menu: true, image: GCV });

// Zone
page('zone-intervention', 'Zone d’intervention', 'Métallier à Saran et autour d’Orléans',
  'Atelier Ferlune intervient à 35 km autour de Saran : Ingré, Olivet, Fleury-les-Aubrais, Chécy, Meung-sur-Loire… Devis gratuit sur place.', [
  teteSplit('Métallier à Saran et autour d’Orléans', 'Nous intervenons dans un rayon de 35 km autour de notre atelier de Saran : métropole d’Orléans, Beauce et Val de Loire.', CTA_LABEL),
  Section('', [
    Short('[briise_carte_zone titre="Nos communes et nos chantiers"]'),
    Muted(`Précisions sous chaque commune : chantiers fictifs pour le test. Voir aussi ${A('nos portails et portillons en acier', 'portails')}.`),
  ], { backgroundColor: 'surface' }),
  faq('Vos questions sur nos déplacements', [
    ['Venez-vous dans ma commune ?', 'Oui si elle est à moins de 35 km de Saran ; au-delà, appelez-nous, nous étudions chaque demande.'],
    ['Le déplacement pour le devis est-il payant ?', 'Non, la visite et le devis sont gratuits dans un rayon de 35 km autour de Saran (fictif).'],
  ], 'nuance'),
  bandeau('Vous êtes dans notre secteur ?', 'Demandez votre visite : elle est gratuite.'),
], { menu: true, image: PB });

// L'atelier
page('atelier', 'L’atelier', 'L’Atelier Ferlune, métallier à Saran depuis 2011',
  'Thomas Ferlune et son équipe dessinent, fabriquent et posent vos ouvrages en acier depuis leur atelier de Saran, ouvert en 2011.', [
  teteMosaique('L’Atelier Ferlune à Saran', 'Trois personnes, un atelier de 400 m² et les mêmes mains du dessin à la pose, depuis 2011.', false, [[SOUD, 'Soudeur au travail à l’atelier, sous les étincelles'], [DET, 'Soudure en cours sous la lumière de l’arc']]),
  Section('', [Cols([
    Col([Img(TH, '4/5', 'Thomas Ferlune au poste de soudure de l’atelier', 'is-style-br-galet')], { width: '42%' }),
    Col([
      Label('Le fondateur'), H('Thomas Ferlune, métallier', 2),
      P('Je dessine chaque ouvrage pour la maison où il va vivre, et je viens le poser moi-même.', 'br-statement'),
      P('Thomas a travaillé 9 ans chez un métallier de Chartres avant de créer l’atelier à Saran en 2011. Il fait lui-même les visites, les plans 3D et les devis, et participe à chaque pose.'),
    ], { width: '58%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })]),
  Section('', [Cols([
    Col([
      Label('Notre histoire'), H('Quinze ans de métallerie à Saran', 2),
      ...[
        ['2002', 'Thomas entre en apprentissage chez un métallier de Chartres. Il y reste neuf ans, des grilles anciennes aux escaliers contemporains.'],
        ['2011', 'Il ouvre son atelier à Saran, seul, dans un local de 120 m² (fictif). Premiers garde-corps et premiers portails pour les maisons du quartier.'],
        ['2016', 'Karim, soudeur, rejoint l’atelier. Les escaliers sur mesure deviennent la spécialité de la maison.'],
        ['2019', 'L’atelier s’installe dans la zone artisanale de Saran : 400 m², une table de découpe laser et un poste de dessin 3D (fictif).'],
        ['2023', 'Lucas arrive comme apprenti. La transmission du métier fait partie du travail.'],
        ['Aujourd’hui', 'Plus de 600 ouvrages posés à moins de 35 km de l’atelier (fictif).'],
      ].map(([an, t]) => Box('br-histoire', [P(an, 'br-histoire-an'), P(t)])),
    ], { width: '58%' }),
    Col([Img(ATEL, '4/5', 'L’atelier de 400 m² dans la zone artisanale de Saran')], { width: '42%', verticalAlignment: 'center' }),
  ], 'br-split')]),
  Section('', [
    Head([Label('Ce que ça vous garantit'), H('Pourquoi confier votre maison à un atelier comme le nôtre', 2)]),
    Cols([
      ['Nous serons encore là', 'Quinze ans d’existence et une garantie décennale sur chaque ouvrage (fictif) : votre garantie a quelqu’un pour la tenir.'],
      ['Les mêmes personnes, du devis à la pose', 'Celui qui prend vos mesures dessine l’ouvrage, et ceux qui le fabriquent viennent le poser. Rien ne se perd entre deux interlocuteurs.'],
      ['Un atelier près de chez vous', 'À moins de 35 km : un réglage, une pièce à reprendre, et nous revenons dans la semaine (fictif).'],
    ].map(([t, d]) => Col([Box('br-card', [H(t, 3), Muted(d)])]))),
  ], { backgroundColor: 'nuance' }),
  Section('', [
    Head([Label('L’équipe'), H('Ceux qui fabriquent et qui posent', 2)]),
    Cols([[TH, 'Thomas Ferlune', 'Visites, plans 3D, fabrication et pose', 'Thomas Ferlune à l’atelier'], [SOUD, 'Karim', 'Soudeur à l’atelier depuis 2016, fabrication et pose', 'Karim au travail, masque de soudure baissé'], [DET, 'Lucas', 'Apprenti métallier (fictif)', 'Soudure en cours à l’atelier']]
      .map(([i, n, r, alt]) => Col([Box('br-member', [Img(i, '1/1', alt), H(n, 3), Muted(r)])])), 'br-team'),
  ], { backgroundColor: 'surface' }),
  Section('', [
    Head([Label('En images'), H('L’atelier', 2)]),
    cb('core/gallery', { linkTo: 'none', sizeSlug: 'large', className: 'br-mosaique', columns: 3, imageCrop: true },
      [[ATEL, 'L’atelier : établis, pont roulant et presse plieuse'], [SOUD, 'Soudure d’une pièce à l’atelier'], [DET, 'Gerbe d’étincelles pendant une soudure'], [ESC, 'Un escalier fabriqué à l’atelier, posé chez un client'], [GCV, 'Un garde-corps en verre posé sur une terrasse'], [VC, 'Une verrière de cuisine posée']].map(([n, alt]) => cb('core/image', { url: IMG(n), alt: fr(alt), sizeSlug: 'large', linkDestination: 'none' }))),
    Arrow('Voir ce que nous avons fabriqué', URL('realisations')),
  ]),
  bandeau('Un projet à nous confier ?', 'Thomas vient vous voir, gratuitement, pour en parler sur place.'),
], { menu: true, image: TH });

// Devis
page('devis', 'Demander un devis', 'Demander un devis de métallerie à Saran',
  'Devis gratuit après une visite chez vous, avec un plan 3D de votre ouvrage sous 5 jours ouvrés. Escaliers, garde-corps, verrières, portails.', [
  Section('br-page-head', [Head([
    Short('[briise_fil_ariane]'), H('Demander un devis', 1, null, { fontSize: 'huge' }),
    Lead('Gratuit : Thomas vient prendre les mesures, puis vous recevez sous 5 jours ouvrés le devis et le plan 3D.'),
    Short('[briise_appel texte="Appeler Thomas"]'),
  ])]),
  Section('', [Cols([
    Col([Box('br-card br-formulaire', [Short('[briise_formulaire type="devis"]')])], { width: '58%' }),
    Col([
      H('Ce qui se passe ensuite', 2),
      P('Thomas vous rappelle pour fixer la visite. Vous avez des photos de l’endroit ? Joignez-les en répondant à l’e-mail de confirmation.'),
      List(['Visite et devis gratuits dans notre zone', 'Plan 3D joint au devis', 'Vos données servent uniquement à vous répondre']),
      P(`Avant d’envoyer : ${A('vérifier que nous venons chez vous', 'zone-intervention')}.`),
    ], { width: '42%' }),
  ], 'br-split')]),
  Section('', [Short('[briise_carte_coordonnees titre="Nous trouver"]')], { backgroundColor: 'surface' }),
  faq('Avant de demander', [
    ['Combien de temps pour recevoir le devis ?', '5 jours ouvrés après la visite, avec le plan 3D.'],
    ['La visite est-elle payante ?', 'Non, la visite et le devis sont gratuits dans notre zone d’intervention (fictif).'],
    ['Que préparer avant la visite ?', `Quelques photos de l’endroit, les dimensions approximatives si vous les avez, et vos envies : teinte, acier ou bois, style. ${A('Thomas ou Karim viendra chez vous', 'atelier')}.`],
  ], 'nuance'),
]);

// Guide
page('norme-garde-corps', 'Norme garde-corps', 'Norme garde-corps NF P01-012 : ce qui change en 2026',
  'Depuis le 1er janvier 2026, tout nouveau garde-corps doit suivre la norme NF P01-012 révisée. Ce qui change, ce qui ne change pas, quoi vérifier.', [
  Section('br-page-head', [Head([
    Short('[briise_fil_ariane]'), H('Garde-corps : ce que change la norme NF P01-012 révisée', 1, null, { fontSize: 'huge' }),
    Lead('Depuis le 1er janvier 2026, tout nouveau garde-corps ou rampe d’escalier doit respecter la version 2024 de la norme NF P01-012. Voici ce qui change pour un particulier.'),
  ])]),
  Section('', [Box('br-narrow', [
    Img(GCV, '16/9', 'Garde-corps en verre sur une terrasse en hauteur'),
    H('L’essentiel en six points', 2),
    P('<strong>Une norme révisée après 36 ans.</strong> La NF P01-012 datait de 1988. Sa nouvelle version a été publiée par l’Afnor le 22 novembre 2024.'),
    P('<strong>Quand elle s’applique.</strong> Depuis juin 2025 pour les projets soumis à une autorisation d’urbanisme, et depuis le 1er janvier 2026 pour tous les autres travaux. La version de 1988 ne s’applique plus.'),
    P('<strong>À quoi elle s’applique.</strong> Aux garde-corps et aux rampes d’escalier des bâtiments, privés ou publics, et à leurs abords. Elle vise les nouveaux ouvrages, pas les garde-corps déjà en place.'),
    P('<strong>Pourquoi elle a changé.</strong> Un jeune enfant pouvait escalader un garde-corps conforme à l’ancienne version. La nouvelle norme vise à limiter ce risque.'),
    P('<strong>Ce qui ne change pas.</strong> Les cas où un garde-corps est obligatoire, selon la hauteur de chute, restent les mêmes.'),
    P('<strong>Ce qui change.</strong> La hauteur se mesure depuis la « zone d’activité », là où l’on se tient, avec un minimum de 1 mètre, rehaussé si un appui permet de grimper. Les notions de zone de stationnement normal ou précaire disparaissent. Les vides du remplissage sont contrôlés avec des gabarits.'),
    Muted('Sources : <a href="https://www.afnor.org/en/news/health-and-safety-at-work/guardrail-standard-better-protect-children/">Afnor</a> ; <a href="https://www.ffbatiment.fr/actualites-batiment/actualite-bam/norme-des-garde-corps-revisee-quels-changements-pour-les-constructeurs">FFB, les changements</a> ; <a href="https://www.ffbatiment.fr/actualites-batiment/actualite-bam/norme-garde-corps-revisee-novembre-2024-applicable-janvier-2026">FFB, l’application au 1er janvier 2026</a>. Relu par Thomas Ferlune, métallier.'),
  ])]),
  faq('Vos questions sur la norme', [
    ['Dois-je remplacer mon garde-corps existant ?', 'Non, la norme révisée vise les nouveaux travaux. Mais si vous le remplacez, le nouveau doit la respecter ; et si un jeune enfant vit chez vous, un ancien garde-corps à barreaux horizontaux mérite d’être vérifié.'],
    ['Quelle hauteur pour un garde-corps de mezzanine ?', 'Au moins 1 mètre depuis la zone où l’on se tient, davantage si un meuble ou un muret permet de prendre appui.'],
    ['La norme concerne-t-elle les rampes d’escalier ?', `Oui, la version 2024 couvre aussi les rampes d’escalier. Voir ${A('nos garde-corps conformes à la norme', 'garde-corps')}.`],
  ], 'nuance'),
  bandeau('Un garde-corps à remplacer ou à créer ?', 'Nous le dessinons selon la norme révisée. Visite et devis gratuits.'),
]);


// Guide : escalier quart tournant
page('escalier-quart-tournant-dimensions', 'Escalier quart tournant : dimensions', 'Escalier quart tournant : dimensions et calcul simple',
  'Haut ou bas, gauche ou droit, nombre de marches, place au sol : comment calculer un escalier quart tournant, avec un exemple chiffré.', [
  Section('br-page-head', [Head([
    Short('[briise_fil_ariane]'), H('Escalier quart tournant : dimensions, place et calcul', 1, null, { fontSize: 'huge' }),
    Lead('Un escalier quart tournant tourne d’un quart de tour pour arriver à l’étage dans une autre direction. Il tient dans un angle de pièce, là où un escalier droit demanderait environ 3,5 m de long.'),
  ])]),
  Section('', [Box('br-narrow', [
    Img(PLAN, '16/9', 'Plan d’un escalier qui tourne sur un palier'),
    H('Haut, bas, gauche, droit : les quatre mots à connaître', 2),
    P('<strong>Quart tournant haut</strong> : le virage est en haut, juste avant l’étage. On monte d’abord tout droit. C’est la forme la plus courante quand l’escalier longe un mur puis doit s’orienter vers un couloir.'),
    P('<strong>Quart tournant bas</strong> : le virage est en bas, dès les premières marches. Pratique quand l’escalier part d’un couloir ou d’une porte.'),
    P('<strong>Gauche ou droit</strong> : le sens dans lequel l’escalier tourne quand on le monte. Pour savoir lequel il vous faut, placez-vous en bas, face à la montée, et regardez de quel côté se trouve l’arrivée à l’étage.'),
    H('Les dimensions qui comptent', 2),
    Table(['Mesure', 'Ce que c’est', 'Repère courant'], [
      ['Hauteur à monter', 'Du sol du bas au sol fini de l’étage', 'Souvent 2,50 à 2,80 m'],
      ['Hauteur de marche', 'La hauteur d’une marche à l’autre', '17 à 20 cm'],
      ['Giron', 'La profondeur où l’on pose le pied', '22 à 28 cm'],
      ['Largeur', 'La largeur de passage', '70 à 90 cm'],
      ['Échappée', 'La hauteur libre au-dessus de la tête', 'Au moins 1,90 m, 2 m pour être à l’aise'],
    ]),
    P('Pour qu’un escalier soit agréable à monter, on utilise la règle de Blondel : deux hauteurs de marche plus un giron doivent faire entre 60 et 64 cm, la longueur d’un pas.'),
    H('Un exemple de calcul', 2),
    List([
      'Hauteur à monter : 2,70 m.',
      'Avec des marches de 18 cm : 2,70 ÷ 0,18 = 15 marches.',
      'Giron selon Blondel : 63 − 2 × 18 = 27 cm, que l’on ramène souvent à 25 cm pour gagner de la place.',
      'Longueur à parcourir : 14 girons de 25 cm, soit 3,50 m, répartis dans le virage.',
      'Place au sol : par exemple un angle d’environ 2,80 m sur 1,50 m, au lieu de 3,50 m de long en droit.',
    ]),
    Muted('Repères indicatifs. Les cotes exactes se relèvent au laser, car un plafond ou un mur n’est jamais parfaitement droit.'),
    H('En acier, ce que ça change', 2),
    P(`Un quart tournant en acier reste fin et laisse passer la lumière, même dans une petite entrée. En version limon central, une seule poutre passe sous les marches. Prix posé : 7 000 à 14 000 € à l’Atelier Ferlune. Comparez les formes sur ${A('notre page escaliers métalliques sur mesure', 'escaliers-metalliques')}, ou, si la place manque vraiment, ${A('l’escalier hélicoïdal', 'escalier-helicoidal')}.`),
    Muted('Rédigé et relu par Thomas Ferlune, métallier.'),
  ])]),
  faq('Vos questions sur le quart tournant', [
    ['Combien de marches pour un escalier quart tournant ?', 'Cela dépend de la hauteur à monter : environ 14 marches pour 2,50 m, 15 pour 2,70 m, avec des marches de 18 cm.'],
    ['Quelle place minimum pour un quart tournant ?', 'Pour un étage classique, comptez un angle d’environ 2,50 à 3 m d’un côté et 1,30 à 1,60 m de l’autre. Plus petit, il devient raide ou étroit.'],
    ['Haut ou bas : lequel est le plus confortable ?', 'Les deux se valent à la montée. Le choix dépend de l’endroit d’où part l’escalier et de celui où il doit arriver.'],
  ], 'nuance'),
  bandeau('Un escalier quart tournant à faire chez vous ?', 'Thomas relève les cotes au laser et vous montre l’escalier en 3D. Visite et devis gratuits.', 'Demander un devis pour votre escalier'),
]);

// Guide : verrière de cuisine
page('verriere-cuisine', 'Verrière de cuisine', 'Verrière de cuisine : avantages, limites et prix',
  'Verrière entre cuisine et salon, petite verrière ou toute hauteur : ce qu’elle apporte, ses limites, le vitrage à choisir et le prix.', [
  Section('br-page-head', [Head([
    Short('[briise_fil_ariane]'), H('Verrière de cuisine : avantages, limites et prix', 1, null, { fontSize: 'huge' }),
    Lead('Une verrière de cuisine apporte la lumière d’une cuisine ouverte en gardant les odeurs et le bruit de leur côté. Voici ce qu’elle change, ses limites et ce qu’elle coûte.'),
  ])]),
  Section('', [Box('br-narrow', [
    Img(VC, '16/9', 'Verrière noire entre une cuisine et la salle à manger'),
    H('Ce qu’elle apporte', 2),
    List([
      'La lumière du salon arrive jusqu’au plan de travail, ou l’inverse.',
      'Les odeurs de cuisson et le bruit de la hotte restent dans la cuisine.',
      'Vous voyez le salon, et les enfants, pendant que vous cuisinez.',
      'Les meubles hauts restent en place si la verrière est posée sur un muret.',
    ]),
    H('Ses limites', 2),
    List([
      'Elle ne remplace pas une hotte : les vitres côté cuisine se nettoient plus souvent.',
      'Elle laisse passer plus de bruit qu’un mur, sauf avec un vitrage acoustique.',
      'Si la cloison est un mur porteur, il faut d’abord l’ouvrir avec un maçon.',
    ]),
    H('Trois façons de la poser', 2),
    Table(['Configuration', 'Pour qui'], [
      ['Sur un muret, entre cuisine et salon', 'Garder ses meubles et son plan de travail contre la cloison'],
      ['Toute hauteur, avec ou sans porte', 'Une cuisine qui donne sur le séjour, sans cloison du tout'],
      ['Petite verrière haute', 'Une cuisine sombre côté entrée ou couloir, sans perdre de mur'],
    ]),
    H('Quel vitrage près de la cuisson ?', 2),
    P('Nous posons du verre feuilleté : s’il casse, les morceaux restent collés au film. Près des plaques, nous gardons une distance de sécurité avec la verrière, vérifiée sur le plan 3D. Pour le bruit, le feuilleté acoustique fait une vraie différence.'),
    H('Combien coûte une verrière de cuisine ?', 2),
    P(`À partir de 750 € le m² posé à l’Atelier Ferlune. Exemple : une verrière de 2,40 m sur 1,20 m au-dessus d’un muret coûte environ 2 200 € posée (fictif). Une porte, un vitrage acoustique ou une forme spéciale augmentent le prix. Tous les détails sont sur ${A('notre page verrières d’intérieur sur mesure', 'verrieres-interieur')}.`),
    H('Verrière en kit ou sur mesure ?', 2),
    P('Une verrière en kit, vendue en grande surface, coûte moins cher. Elle existe en tailles standard, et c’est à vous de l’adapter et de la poser. Sur mesure, elle suit vos murs, même s’ils ne sont pas droits, s’aligne sur vos meubles et arrive posée en une journée.'),
    Muted('Rédigé et relu par Thomas Ferlune, métallier.'),
  ])]),
  faq('Vos questions sur la verrière de cuisine', [
    ['Une verrière de cuisine laisse-t-elle passer les odeurs ?', 'Non si elle est fixe : elle ferme la cuisine comme une cloison. Avec un châssis ouvrant pour aérer, un peu d’air passe quand il est ouvert.'],
    ['Faut-il une autorisation ?', 'Non pour une cloison intérieure non porteuse. En copropriété, ouvrir un mur porteur demande l’accord du syndic.'],
    ['Combien de temps pour la pose ?', 'Une journée, après 3 à 4 semaines de fabrication.'],
  ], 'nuance'),
  bandeau('Une verrière pour votre cuisine ?', 'Visite et devis gratuits, avec la verrière en 3D dans votre cuisine.', 'Demander un devis pour votre verrière'),
]);

/* Fiches de réalisation (fictives). La dernière est volontairement courte : test du seuil de 150 mots. */
const realisations = [
  { titre: 'Escalier quart tournant à marches en chêne à Ingré', image: ESC, ville: 'Ingré', date: '2025-09', service: 'escaliers-metalliques', categories: ['Escalier'],
    resume: 'Structure acier noire et marches en chêne massif dans une maison des années 1930.',
    demande: ['Dans une maison des années 1930, la famille voulait remplacer un escalier en bois raide et bruyant par un escalier plus doux à monter, sans perdre de place dans l’entrée. La trémie n’était pas d’équerre et le mur porteur penchait de deux centimètres.'],
    solution: ['Thomas a relevé les cotes au laser, puis dessiné en 3D un quart tournant de quatorze marches qui suit le mur existant. Le limon et les crémaillères sont en acier de 8 mm, découpés et soudés à l’atelier de Saran, puis thermolaqués en noir mat.',
      'Les marches en chêne massif, huilées, sont fixées par en dessous : aucune vis ne se voit. Le chêne atténue le bruit des pas et réchauffe l’ensemble. La rampe, en fer plat de 40 mm, prolonge le garde-corps de l’étage. Fabrication en cinq semaines, pose en deux jours par l’équipe qui l’a fabriqué, sans toucher au carrelage de l’entrée (client fictif).',
      'Le devis, remis cinq jours après la visite avec le plan 3D, est resté le prix final : aucune surprise sur la facture.'] },
  { titre: 'Escalier droit à limon central à Saran', image: SOUD, ville: 'Saran', date: '2024-11', service: 'escaliers-metalliques', categories: ['Escalier'],
    resume: 'Un limon central en acier anthracite pour un escalier léger dans un loft.',
    demande: ['Pour un ancien atelier transformé en loft, le propriétaire cherchait un escalier qui laisse passer la lumière et ne coupe pas la pièce en deux. Il voulait une ligne simple, en accord avec les poutres métalliques d’origine.'],
    solution: ['Nous avons proposé un escalier droit à limon central : une seule poutre en acier sous les marches, qui donne l’impression que l’escalier flotte. Le limon, en tube de 200 par 100 mm, est ancré dans la dalle et dans la mezzanine.',
      'Les marches en tôle pliée de 6 mm reçoivent un revêtement antidérapant discret. Teinte anthracite, assortie aux poutres existantes. Le garde-corps de la mezzanine a été prolongé dans le même acier. Le plan 3D a permis de vérifier la hauteur sous plafond à chaque marche avant la fabrication, ce qui a évité de reprendre la trémie. Pose en une journée (client fictif).',
      'Le client a validé la teinte sur un échantillon d’acier thermolaqué apporté lors de la deuxième visite, à côté des poutres, à la lumière du jour.'] },
  { titre: 'Escalier hélicoïdal en acier brut verni à Olivet', image: DET, ville: 'Olivet', date: '2024-05', service: 'escalier-helicoidal', categories: ['Escalier'],
    resume: 'Un escalier hélicoïdal de 1,40 m de diamètre pour gagner de la place dans une entrée.',
    demande: ['La cliente voulait accéder à des combles aménagés depuis une entrée étroite. Un escalier droit aurait pris presque toute la pièce : il fallait un escalier compact, mais confortable à monter tous les jours.'],
    solution: ['Nous avons dessiné un escalier hélicoïdal de 1,40 m de diamètre, autour d’un fût central en acier. Chaque marche est découpée au laser et soudée sur le fût à l’atelier, puis l’ensemble est livré en trois parties pour passer par la porte d’entrée.',
      'L’acier est laissé brut, simplement verni, pour garder les traces de la fabrication que la cliente aimait sur nos photos. La main courante suit la courbe sans interruption. L’escalier occupe moins de deux mètres carrés au sol, et la porte du placard voisin s’ouvre toujours en entier. Pose en une journée, finitions comprises (client fictif).',
      'Le diamètre a été choisi avec la cliente sur le plan 3D, en comparant trois versions, pour que le passage reste confortable même avec un carton dans les bras.'] },
  { titre: 'Escalier hélicoïdal carré pour une mezzanine à Ingré', image: HEL, ville: 'Ingré', date: '2025-11', service: 'escalier-helicoidal', categories: ['Escalier'],
    resume: 'Un hélicoïdal carré de 1,50 m logé dans l’angle d’un séjour, marches en chêne.',
    demande: ['Les propriétaires avaient aménagé une mezzanine au-dessus du séjour, accessible par une échelle de meunier. Ils voulaient un vrai escalier, sûr pour leurs deux enfants, sans sacrifier le coin du séjour où se trouve le canapé.'],
    solution: ['La trémie existante était carrée : nous avons proposé un escalier hélicoïdal carré de 1,50 m de côté, qui occupe exactement l’angle sans laisser de coin perdu. Le fût central et les supports de marches sont en acier noir mat, les marches en chêne huilé.',
      'Un garde-corps à barreaux verticaux suit toute la montée et fait le tour de la trémie à l’étage, à la hauteur fixée par la norme révisée. Le plan 3D a permis de vérifier que la porte de la mezzanine s’ouvre encore entièrement. L’escalier a été livré en quatre parties et monté en une journée, sans toucher au parquet du séjour (client fictif).',
      'Les enfants montent désormais seuls à la mezzanine, et l’échelle a rejoint le grenier.'] },
  { titre: 'Garde-corps de mezzanine en acier et verre à Olivet', image: GCV, ville: 'Olivet', date: '2025-06', service: 'garde-corps', categories: ['Garde-corps'],
    resume: 'Un garde-corps acier et verre conforme à la norme, pour garder la vue sur le séjour.',
    demande: ['L’ancien garde-corps de la mezzanine, à barreaux horizontaux, était facile à escalader pour les enfants et cachait la vue sur le séjour. Les propriétaires voulaient plus de sécurité sans fermer l’espace.'],
    solution: ['Nous avons dessiné un garde-corps à montants en acier noir et remplissage en verre feuilleté de 10 mm, à la hauteur fixée par la norme NF P01-012 révisée en 2024. Les montants sont fixés en applique sur le chant de la dalle, ce qui libère toute la surface de la mezzanine.',
      'Le verre arrive à 5 cm du sol : aucun jouet ne peut tomber en contrebas. Les montants ont été fabriqués et thermolaqués à l’atelier, le verre posé sur place avec des pinces en inox. La vue sur le séjour est entièrement dégagée, et le garde-corps a été posé en une matinée (client fictif).',
      'Avant la pose, nous avons remis aux propriétaires la fiche technique du verre et le certificat de conformité, utiles pour leur assurance habitation.'] },
  { titre: 'Garde-corps de terrasse en acier thermolaqué à Fleury-les-Aubrais', image: GCT, ville: 'Fleury-les-Aubrais', date: '2025-04', service: 'garde-corps', categories: ['Garde-corps'],
    resume: 'Barreaux verticaux et acier thermolaqué anthracite pour une terrasse en hauteur.',
    demande: ['Une terrasse surélevée de 1,20 m, sans protection depuis la construction de la maison. Les propriétaires voulaient un garde-corps solide, qui résiste à la pluie sans entretien, et qui ne ressemble pas à une clôture de chantier.'],
    solution: ['Nous avons choisi des barreaux verticaux en acier, espacés de 10 cm selon la norme, avec une lisse haute large qui sert aussi d’appui. Après la soudure, chaque élément est galvanisé puis thermolaqué en anthracite : cette double protection évite la rouille pendant des années, même en plein air.',
      'Les platines de fixation ont été dessinées pour ne pas percer l’étanchéité de la terrasse. Douze mètres linéaires ont été posés en une journée, avec un portillon assorti en haut de l’escalier extérieur pour le chien de la famille. Un rinçage à l’eau une fois par an suffit comme entretien (client fictif).',
      'Les propriétaires ont choisi l’anthracite après avoir vu deux échantillons posés contre leur façade, pour que le garde-corps se fonde dans la maison plutôt que de la masquer.'] },
  { titre: 'Verrière de cuisine noire à Saran', image: VC, ville: 'Saran', date: '2026-02', service: 'verrieres-interieur', categories: ['Verrière'],
    resume: 'Une verrière atelier entre la cuisine et le salon, pour la lumière sans les odeurs.',
    demande: ['La cuisine fermée de cette maison de ville manquait de lumière, mais les propriétaires ne voulaient pas d’une cuisine ouverte à cause des odeurs et du bruit de la hotte. Ils cherchaient une séparation lumineuse.'],
    solution: ['Nous avons remplacé une partie de la cloison par une verrière atelier de 2,40 m de large, sur une allège de 1 m pour garder les meubles hauts d’un côté. Les profils en acier de 30 mm, peints en noir mat, sont fabriqués à l’atelier et assemblés sur place.',
      'Le vitrage feuilleté laisse passer la lumière du salon jusqu’au plan de travail, tandis que la cuisine reste fermée. Un petit châssis ouvrant permet d’aérer. Le plan 3D a servi à choisir la hauteur des traverses pour qu’elles tombent à l’alignement des meubles. Pose en une journée, avec la reprise de plâtre par notre partenaire (client fictif).',
      'Les propriétaires ont gardé leurs meubles de cuisine : la verrière a été dessinée autour d’eux, au centimètre, plutôt que l’inverse.'] },
  { titre: 'Verrière de bureau avec porte à Ingré', image: VB, ville: 'Ingré', date: '2025-10', service: 'verrieres-interieur', categories: ['Verrière'],
    resume: 'Un bureau isolé du bruit dans un grand séjour, grâce à une verrière avec porte battante.',
    demande: ['En télétravail trois jours par semaine, le client voulait un vrai bureau au fond de son séjour, isolé du bruit de la maison, sans créer une pièce sombre et sans travaux de maçonnerie.'],
    solution: ['Nous avons fabriqué une verrière toute hauteur avec une porte battante intégrée, posée entre le sol et le plafond, sans cloison. Le verre feuilleté acoustique de 44.2 réduit nettement le bruit de la télévision et des conversations.',
      'La porte, en acier et verre, ferme avec une serrure magnétique silencieuse. Les profils noirs reprennent ceux des fenêtres de la maison. Le bureau reçoit la lumière des baies du séjour, et le séjour garde sa profondeur. Fabrication en trois semaines, pose en une journée, et aucun gravat dans la maison (client fictif).',
      'Le client a pu travailler dès le lendemain de la pose. Il nous a confié ensuite la rampe de son escalier, dans le même acier noir que la verrière.'] },
  { titre: 'Portail coulissant en acier à Saint-Jean-de-Braye', image: PC, ville: 'Saint-Jean-de-Braye', date: '2025-03', service: 'portails', categories: ['Portail'],
    resume: 'Un portail coulissant motorisé de 4 m pour une entrée en pente.',
    demande: ['L’entrée de la propriété est en pente et étroite : un portail battant aurait frotté sur le sol en s’ouvrant. Les propriétaires voulaient un portail motorisé, solide, qui ne laisse pas voir le jardin depuis la route.'],
    solution: ['Nous avons dessiné un portail coulissant autoportant de 4 m, qui ne touche pas le sol pendant la course : il glisse sur des galets fixés sur un socle, à côté de l’entrée. La pente n’a donc aucune importance.',
      'Le remplissage en lames d’acier horizontales, à claire-voie fermée, cache le jardin tout en laissant passer le vent. Le portail est galvanisé, thermolaqué en gris anthracite, et équipé d’un moteur avec télécommande et cellules de sécurité. Le portillon voisin a été assorti. Pose en deux jours, avec le raccordement du moteur par un électricien partenaire (client fictif).',
      'Le moteur choisi fonctionne aussi en cas de coupure de courant grâce à un déverrouillage manuel, montré aux propriétaires le jour de la pose.'] },
  { titre: 'Portail battant et portillon à Chécy', image: PB, ville: 'Chécy', date: '2024-08', service: 'portails', categories: ['Portail'],
    demande: ['Un portail battant et son portillon, assortis à la clôture existante.'],
    solution: ['Acier galvanisé et thermolaqué vert sapin (client fictif).'] },
];

const site = {
  entreprise: {
    name: 'Atelier Ferlune', slogan: 'Métallier à Saran, ouvrages sur mesure',
    type: 'HomeAndConstructionBusiness',
    description: 'Métallier à Saran : escaliers, garde-corps, verrières d’intérieur et portails sur mesure, dessinés en 3D, fabriqués dans notre atelier et posés par l’équipe (client fictif).',
    email: 'contact@briise.fr', telephone: '06 00 00 00 00',
    street: 'Zone artisanale (adresse fictive)', postal_code: '45770', city: 'Saran', country: 'FR',
    areas: ['Saran', 'Ingré', 'Fleury-les-Aubrais', 'Olivet', 'Saint-Jean-de-Braye', 'Chécy', 'Orléans', 'Meung-sur-Loire'],
    instagram: '', google: 'https://www.google.com/maps/search/Atelier+Ferlune+Saran',
    person_name: 'Thomas Ferlune', person_job: 'Métallier, fondateur',
    precision_telephone: 'Thomas décroche lui-même', precision_email: 'Réponse sous 48 h ouvrées (fictif)', precision_adresse: 'Atelier sur rendez-vous',
    badge_coord_titre: 'Visite et devis gratuits', badge_coord_texte: 'Plan 3D sous 5 jours ouvrés',
    badge_zone_titre: 'Déplacement gratuit', badge_zone_texte: 'Dans un rayon de 35 km',
    zone_rayon: '35',
    qualifications: [
      { nom: 'Garantie décennale', detail: 'Exemple Assurances (fictif)', numero: '000000' },
      { nom: 'Qualibat', detail: 'Métallerie, serrurerie (fictif)', numero: 'E-000000', fin: '2028-03-31', lien: 'https://www.qualibat.com/' },
    ],
    zone_points: ['Saran ; 47.950 ; 1.877', 'Orléans ; 47.902 ; 1.909', 'Ingré ; 47.919 ; 1.823', 'Fleury-les-Aubrais ; 47.933 ; 1.917', 'Olivet ; 47.863 ; 1.900', 'Saint-Jean-de-Braye ; 47.913 ; 1.971', 'Chécy ; 47.894 ; 2.023', 'Meung-sur-Loire ; 47.828 ; 1.700'].join('\n'),
    zone_secteurs: [
      '# Autour de l’atelier | Saran et environs', 'Saran | atelier et siège', 'Fleury-les-Aubrais | garde-corps de terrasse', 'Ingré | escalier, verrière, garde-corps',
      '# Métropole d’Orléans | Tout le secteur', 'Olivet | escalier, garde-corps', 'Saint-Jean-de-Braye | portail coulissant', 'Chécy | portail et portillon', 'Orléans',
      '# Beauce et Val de Loire | Jusqu’à 35 km', 'Meung-sur-Loire', '+ autres communes sur demande',
    ].join('\n'),
  },
  legal: {
    raison_sociale: 'Atelier Ferlune SARL', forme: 'SARL', capital: '10 000 € (fictif)', siren: '000 000 000 (fictif)', rcs: 'Orléans',
    siege: 'Zone artisanale, 45770 Saran (adresse fictive)', directeur: 'Thomas Ferlune',
    hebergeur_nom: 'Hébergeur à définir (fictif)', realisation: 'Briise',
  },
  annonces: {
    jours: Object.fromEntries([1, 2, 3, 4, 5, 6, 7].map((n) => [n, n <= 5 ? { ouvert: true, plages: [['07:30', '12:00'], ['13:30', '17:00']] } : { ouvert: false, plages: [['', ''], ['', '']] }])),
    note: 'Rendez-vous possibles le samedi matin.',
  },
  ambiance: 'acier', couleurs: { accent: '#a83d0c' },
  cta: 'devis', cta_label: 'Demander un devis', accueil: 'accueil', personne: 'atelier', blog: '',
  statut: 'publish',
  realisations,
  pages,
};
require('fs').writeFileSync(require('path').join(__dirname, 'site-ferlune.json'), JSON.stringify(site, null, 1));
// Pour validate.js
const o = {}; pages.forEach((p) => { o[p.slug] = p.markup; });
require('fs').mkdirSync(require('path').join(__dirname, '..', 'build'), { recursive: true });
require('fs').writeFileSync(require('path').join(__dirname, '..', 'build', 'ferlune_blocs.json'), JSON.stringify({ sections: o, home: '' }));
console.log(pages.length, 'pages ;', pages.map((p) => p.slug).join(', '));
