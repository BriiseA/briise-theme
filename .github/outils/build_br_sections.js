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

add('hero-image', 'ouverture', 'Hero avec image', 'Ouverture de l’accueil ou d’une page de service : titre, phrase d’accroche, deux boutons, photo.',
  Section('br-hero', [Cols([
    Col([
      Chips(['Atout n° 1', 'Atout n° 2', 'Votre ville']),
      H('Le titre qui dit ce que vous faites, et où', 1, null, { fontSize: 'huge' }),
      Lead('Une ou deux phrases pour dire à qui vous vous adressez et ce qui vous distingue. Restez concret : un visiteur décide en quelques secondes s’il est au bon endroit.'),
      MainBtns(['Découvrir nos services', URL('services')]),
    ], { verticalAlignment: 'center', width: '56%' }),
    Col([Img('portrait', '4/5', 'is-style-br-galet')], { verticalAlignment: 'center', width: '44%' }),
  ], 'br-split', { verticalAlignment: 'center' })]));

add('hero-banniere', 'ouverture', 'Hero bannière plein écran', 'Grande photo pleine largeur, titre et bouton posés dessus. Le voile sombre garantit la lisibilité, quelle que soit la photo.',
  cb('core/cover', {
    url: IMG('banniere'), alt: '', dimRatio: 70, overlayColor: 'sombre', isUserOverlayColor: true, minHeight: 68, minHeightUnit: 'vh',
    contentPosition: 'bottom left', align: 'full', className: 'br-banniere', layout: { type: 'constrained' },
  }, [
    Box('br-banniere-inner', [
      Label('Votre activité, votre ville'),
      H('Un titre court, qui donne envie', 1, null, { fontSize: 'huge' }),
      Lead('Une phrase qui complète le titre. La photo doit montrer votre travail, votre lieu ou votre équipe : pas une image de banque d’images.'),
      MainBtns(['Voir nos réalisations', URL('realisations')]),
    ]),
  ]));

add('hero-texte', 'ouverture', 'Hero texte seul', 'Ouverture sobre, sans image : pages intérieures, pages légales, pages de contenu.',
  Section('br-page-head', [Head([
    Label('Rubrique'),
    H('Le titre de la page', 1, null, { fontSize: 'huge' }),
    Lead('Une phrase d’introduction qui résume ce que le visiteur va trouver sur cette page.'),
  ])]));

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
  Box('br-tuiles', items.map(([v, c, t]) => Box('br-tuile' + (v ? ' br-tuile--' + v : ''), [P(c, 'br-tuile-chiffre'), P(t, 'br-tuile-texte')]))), ...apres]);
const zoneSchema = (label, titre, chapo, lien) => Section('br-zone-schema', [Cols([
  Col([Label(label), H(titre, 2), Lead(chapo), ...(lien ? [Arrow(lien[0], lien[1])] : [])], { verticalAlignment: 'center', width: '44%' }),
  Col([Short('[briise_zone_schema]')], { verticalAlignment: 'center', width: '56%' }),
], 'br-split', { verticalAlignment: 'center' })]);

add('accueil-photo', 'ouverture', 'Accueil texte et photo avec étiquettes', 'Ouverture de l’accueil : titre, phrase et boutons à gauche, une vraie photo à droite avec deux étiquettes posées dessus (prix de départ, délai, garantie). Sur mobile, le titre et le bouton restent visibles sans défiler.',
  heroPhoto({ pastille: 'Votre métier · Votre ville', titre: 'Le titre qui dit ce que vous faites,', accent: 'et où', chapo: 'Une ou deux phrases : pour qui, ce qui vous distingue, et ce que le visiteur gagne à vous appeler.', second: ['Voir nos réalisations', URL('realisations')], coches: ['Devis gratuit', 'Votre délai de réponse', 'Votre garantie'], img: 'portrait', alt: 'Photo à remplacer : votre travail, votre atelier ou votre équipe', etiquettes: [['À partir de', '000 € posé'], ['Délai', '2 semaines']] }));

add('bande-confiance', 'confiance', 'Bande de confiance', 'Juste sous l’ouverture, une carte qui chevauche la section du dessus : quatre garanties réelles avec leur icône. L’icône se change dans Avancé > Classes CSS : is-icone-garantie, is-icone-plan, is-icone-atelier, is-icone-avis, is-icone-delai, is-icone-prix, is-icone-local, is-icone-devis, is-icone-equipe.',
  confiance([['garantie', 'Garantie décennale', 'Attestation jointe au devis'], ['devis', 'Devis gratuit', 'Sous 5 jours ouvrés'], ['local', 'Une équipe locale', 'À votre ville et alentour'], ['avis', 'Note Google', 'À n’afficher que si elle est réelle']]));

add('tuiles-chiffres', 'confiance', 'Chiffres en tuiles', 'Vos preuves en chiffres, en tuiles de tailles différentes : une grande pour le chiffre le plus fort, les autres autour. Les chiffres comptent jusqu’à leur valeur quand la section apparaît.',
  tuiles('Pourquoi nous choisir', 'Ce qui fait la différence', [['grande', '100 %', 'Le chiffre le plus fort, avec une phrase qui dit ce qu’il garantit au client.'], ['large', '3D', 'Un avantage concret, en une phrase.'], ['', '5 jours', 'Un délai que vous tenez.'], ['accent', '1', 'seul interlocuteur, du devis à la fin du chantier']]));

add('zone-schema', 'contact', 'Zone d’intervention en schéma', 'Un schéma de la zone : votre adresse au centre, le rayon d’intervention et les communes où vous travaillez. Il se dessine à partir de Mon entreprise > Coordonnées > Communes du schéma (nom ; latitude ; longitude).',
  zoneSchema('Zone d’intervention', 'Nous intervenons à 30 km autour de votre ville', 'Les communes principales de votre zone, et ce qui se passe au-delà.', ['Toutes les communes où nous intervenons', URL('zone-intervention')]));

/* ----- Offre ----- */

// {{SERVICE:n}} : nom du n-ième service du client, {{URL:service-n}} : sa page (remplis à l'installation).
const carte = (n) => Col([Box('br-card', [
  Num('0' + n), H(`{{SERVICE:${n}}}`, 3), Muted('Deux phrases pour décrire ce service, pour qui il est fait et ce qu’il apporte.'),
  Arrow(`{{SERVICE:${n}}} en détail`, URL(`service-${n}`)),
])]);
add('trois-cartes', 'offre', 'Trois cartes de service', 'Présenter l’offre en trois blocs, chacun menant à sa page.',
  Section('', [
    sectionHead('Ce que nous faisons', ['Tous nos services', URL('services')]),
    Cols([carte(1), carte(2), carte(3)]),
  ], { backgroundColor: 'surface' }));

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
add('chiffres-cles', 'confiance', 'Chiffres clés', 'Quatre preuves rapides. Uniquement des chiffres vrais et vérifiables.',
  Section('br-section--tight', [Cols([stat('15 ans', 'd’expérience dans le métier'), stat('400', 'clients accompagnés'), stat('48 h', 'pour recevoir votre devis'), stat('4,9/5', 'note moyenne sur Google')], 'br-stats-row')]));

const avis = (txt) => Col([Box('br-card br-avis', [
  cb('core/quote', { citation: fr('Prénom N., ville') }, [P(txt)]),
])]);
add('temoignages', 'confiance', 'Témoignages', 'Trois avis de clients. Uniquement des avis réels, avec l’accord de leur auteur.',
  Section('', [
    sectionHead('Ce que disent nos clients', ['Tous les avis sur Google', '#']),
    Cols([
      avis('Recopiez ici un avis réel, mot pour mot. Les plus convaincants racontent une situation précise et son résultat.'),
      avis('Un deuxième avis, idéalement d’un autre type de client, pour que chacun s’y retrouve.'),
      avis('Un troisième avis, court. Trois avis suffisent : au-delà, renvoyez vers votre fiche Google.'),
    ]),
  ], { backgroundColor: 'surface' }));

add('logos', 'confiance', 'Logos de clients ou labels', 'Certifications, labels, partenaires ou clients connus, en une ligne.',
  Section('br-section--tight', [
    P('Ils nous font confiance', 'br-label br-center'),
    cb('core/group', { className: 'br-logos', layout: { type: 'flex', flexWrap: 'wrap', justifyContent: 'center' } },
      [1, 2, 3, 4, 5].map((i) => cb('core/image', { url: IMG('logo-' + i), alt: fr('Nom du partenaire ou du label ' + i), sizeSlug: 'full', linkDestination: 'none', width: '140px' }))),
  ]));

const projet = (n, t) => Col([Box('br-project', [Img(n, '4/3'), Chips(['Type de projet', 'Ville']), H(t, 3), Muted('Une phrase : la demande du client et ce qui a été fait.')])]);
add('realisations', 'confiance', 'Dernières réalisations (automatique)', 'Accueil : les trois dernières réalisations publiées (menu Réalisations), avec un lien vers toutes. Se met à jour seule ; disparaît s’il n’y en a aucune.',
  Section('br-section-realisations', [
    sectionHead('Nos dernières réalisations', ['Toutes les réalisations', URL('realisations')]),
    Short('[briise_realisations nombre="3"]'),
  ]));
add('realisations-toutes', 'confiance', 'Toutes les réalisations, avec filtres (automatique)', 'Page des réalisations : toutes les fiches publiées, avec des boutons pour filtrer par catégorie. Se met à jour seule.',
  Section('br-section-realisations', [Short('[briise_realisations filtres="1"]')]));
add('realisations-service', 'confiance', 'Réalisations de ce service (automatique)', 'Page de service : les réalisations rattachées à ce service. Disparaît tant qu’il n’y en a aucune.',
  Section('br-section-realisations', [
    sectionHead('Nos réalisations pour ce service', ['Toutes les réalisations', URL('realisations')]),
    Short('[briise_realisations service="auto" nombre="3"]'),
  ]));
add('realisations-manuelle', 'confiance', 'Réalisations en grille (à la main)', 'Trois réalisations écrites dans la page, sans fiche. Pour un site sans la fonction Réalisations.',
  Section('', [
    sectionHead('Nos dernières réalisations', ['Toutes les réalisations', URL('realisations')]),
    Cols([projet('carre', 'Première réalisation'), projet('carre-2', 'Deuxième réalisation'), projet('carre-3', 'Troisième réalisation')], 'br-projects'),
  ]));

add('avant-apres', 'confiance', 'Avant / après', 'Deux photos côte à côte pour montrer une transformation.',
  Section('', [
    Head([Label('Avant / après'), H('Le titre de la transformation', 2), Lead('Le contexte en une phrase : la demande, la contrainte, le délai.')]),
    Cols([
      Col([Box('br-avap', [Img('avant', '4/3', 'is-style-br-arrondi', 'Avant : décrivez l’état de départ'), P('Avant', 'br-chip br-avap-tag')])]),
      Col([Box('br-avap', [Img('apres', '4/3', 'is-style-br-arrondi', 'Après : décrivez le résultat'), P('Après', 'br-chip br-avap-tag')])]),
    ], 'br-avant-apres'),
  ]));

const avantApres = (label, titre, chapo, a = ['avant', 'Avant : décrivez l’état de départ', 'Avant'], b = ['apres', 'Après : décrivez le résultat', 'Après']) => Section('', [
  Head([Label(label), H(titre, 2), Lead(chapo)]),
  Cols([
    Col([Box('br-avap', [Img(a[0], '16/10', 'is-style-br-arrondi', a[1]), P(a[2], 'br-chip br-avap-tag')])]),
    Col([Box('br-avap', [Img(b[0], '16/10', 'is-style-br-arrondi', b[1]), P(b[2], 'br-chip br-avap-tag')])]),
  ], 'br-avant-apres br-glisse'),
  P('Faites glisser le curseur, ou passez la souris sur la photo, pour comparer.', 'br-muted br-glisse-aide'),
]);
add('avant-apres-glisse', 'confiance', 'Avant / après à faire glisser', 'Une seule photo coupée par un curseur : on glisse pour passer de l’avant à l’après. Les deux photos doivent être prises du même endroit, avec le même cadrage ; sinon, préférer « Avant / après » côte à côte.',
  avantApres('Avant / après', 'Le titre de la transformation', 'Le contexte en une phrase : la demande, la contrainte, le délai.'));

add('galerie', 'confiance', 'Galerie en mosaïque', 'Six photos en mosaïque : lieu, ambiance, détails du travail.',
  Section('', [
    Head([Label('En images'), H('Un aperçu de notre univers', 2)]),
    cb('core/gallery', { linkTo: 'none', sizeSlug: 'large', className: 'br-mosaique', columns: 3, imageCrop: true },
      ['paysage', 'portrait', 'carre', 'carre-2', 'paysage-2', 'carre-3'].map((n, i) => cb('core/image', { url: IMG(n), alt: fr('Photo ' + (i + 1) + ' à remplacer'), sizeSlug: 'large', linkDestination: 'none' }))),
  ]));

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
  ], [prixCarte([['Prestation la plus courante', 'À partir de… €'], ['Option fréquente', '+ … €']], 'Ce qui fait varier le prix, en une phrase. Le prix exact figure sur le devis.', ['Prestation', 'Prix TTC'])]));

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

add('dirigeant', 'personnes', 'Présentation du dirigeant', 'Professions libérales et artisans : la personne derrière l’entreprise.',
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

add('zone', 'contact', 'Zone d’intervention', 'Artisans et services à domicile : les villes couvertes, tirées de « Mon entreprise ».',
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

const out = {}; for (const k in S) out[k] = { cat: S[k].cat, title: S[k].title, desc: S[k].desc, markup: S[k].markup };
require('fs').mkdirSync(require('path').join(__dirname, 'build'), { recursive: true });
require('fs').writeFileSync(require('path').join(__dirname, 'build', 'br_sections.json'), JSON.stringify(out, null, 1));
module.exports = { Mark, heroPhoto, confiance, tuiles, zoneSchema, S, cb, serialize, P, H, Label, Lead, Muted, Section, Box, Head, Short, MainBtns, List, fr, CTA, CTA_LABEL, URL, Img, Btn, Btns, Cols, Col, Arrow, Table, Num, teteSplit, teteMosaique, benefices, modeles, etapesPhotos, avantApres, etapesFrise, etapesFil, prixCarte };
console.log(Object.keys(S).length, 'sections');
