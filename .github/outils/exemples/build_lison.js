// Fichier de site : Lison Vautrin Photographie (cliente fictive, test du process Briise sur un métier de l'image).
// Prix, avis, dates et lieux de réception sont inventés pour le test et signalés « fictif » sur le site.
const B = require('../build_br_sections.js');
const {
  cb, serialize, P, H, Lead, Muted, Section, Box, Head, Short, List, fr, CTA, CTA_LABEL, URL, Img, Btn, Btns, Cols, Col, Arrow,
  choixSeance, lieux, faitsIcones, etapesImages, ctaPhoto, avisCourt, tarifLigne, ETOILES, Row, compris,
} = B;
const { cloneBlock } = require('@wordpress/blocks');

const IMG = (n) => `{{IMG:${n}}}`;
const A = (t, slug) => `<a href="${URL(slug)}">${t}</a>`;
const Details = (q, a) => cb('core/details', { summary: fr(q) }, [P(a)]);
const GOOGLE = 'https://www.google.com/maps/search/Lison+Vautrin+Photographie+Olivet';

/* Rythme des couleurs : les sections alternent strictement le fond clair et le rose poudré (la teinte « nuance »,
   beige, n'est pas utilisée chez Lison). Les photos pleine largeur (appel final) gardent leur fond. */
const rythme = (blocks) => {
  let i = 0;
  return blocks.map((b) => {
    if (b.name === 'core/cover') return b;
    const bg = i++ % 2 ? 'surface' : undefined;
    return cloneBlock(b, { backgroundColor: bg });
  });
};

/* Les adresses des pages : une requête principale par page (étude sémantique du 22 novembre 2026). */
const S = {
  naissance: 'photographe-naissance-orleans', grossesse: 'photographe-grossesse-orleans', famille: 'photographe-famille-orleans',
  couple: 'seance-photo-couple-orleans', mariage: 'photographe-mariage-orleans', studio: 'studio-photo-olivet',
};

/* ---------- Sections paramétrées ---------- */
// Tête d'une page de séance : titre, chapô, boutons, trois chiffres ; la photo porte la prochaine date libre.
const teteSeance = ({ h1, lead, btns, stats, img, alt, dispo = true }) => Section('br-hero br-tete-seance', [Cols([
  Col([Short('[briise_fil_ariane]'), H(h1, 1, null, { fontSize: 'xx-large' }), Lead(lead), Btns(...btns),
    ...(stats ? [Box('br-stats', stats.map(([v, t]) => P(`<strong>${v}</strong> ${t}`, 'br-stat')))] : [])], { width: '54%', verticalAlignment: 'center' }),
  Col([Box('br-lieu-media br-tete-seance-media', [Img(img, '4/5', 'is-style-br-arrondi', alt), ...(dispo ? [Short('[briise_disponibilite]')] : [])])], { width: '46%', verticalAlignment: 'center' }),
], 'br-split', { verticalAlignment: 'center' })]);
const teteTexte = (h1, lead, btns = []) => Section('br-page-head', [Head([Short('[briise_fil_ariane]'), H(h1, 1, null, { fontSize: 'xx-large' }), Lead(lead), ...(btns.length ? [Btns(...btns)] : [])])]);
const tetes = (titre, chapo, lien) => Row('br-section-head br-tete-deux', [H(titre, 2), Box('', [Lead(chapo), ...(lien ? [Arrow(lien[0], lien[1])] : [])])]);

// Photos récentes : mosaïque de trois photos (la première en grand), agrandies au clic.
const galerie = (titre, chapo, lien, photos, bg) => Section('br-galerie-section', [
  tetes(titre, chapo, lien),
  cb('core/gallery', { linkTo: 'none', sizeSlug: 'large', className: photos.length > 4 ? 'br-mosaique br-mosaique-dense' : 'br-mosaique', columns: photos.length > 4 ? 4 : 3, imageCrop: true },
    photos.map(([n, alt]) => cb('core/image', { url: IMG(n), alt: fr(alt), sizeSlug: 'large', linkDestination: 'none', lightbox: { enabled: true } }))),
], bg ? { backgroundColor: bg } : {});

const avisNote = (titre, avis, bg) => Section('br-avis-note', [
  Row('br-section-head br-tete-deux', [H(titre, 2), P(`<strong class="br-note-chiffre">4,9</strong> <span class="br-note-detail">${ETOILES}<span>sur 5, 62 avis Google (fictif)</span></span>`, 'br-note')]),
  Cols(avis.map(([t, qui, quoi]) => avisCourt(`« ${t} »`, qui, quoi)), 'br-avis-grille'),
  Btns(Btn(CTA_LABEL, CTA), Btn('Lire les 62 avis sur Google', GOOGLE, 'is-style-outline')),
], bg ? { backgroundColor: bg } : {});

const prixBloc = ({ titre, oui, non, bouton, note, img, alt, pastille }) => Section('br-prix-seance', [Cols([
  Col([H(titre, 2), compris(oui, non), Btns(Btn(bouton, CTA)), ...(note ? [Muted(note)] : [])], { width: '54%', verticalAlignment: 'center' }),
  Col([Box('br-lieu-media', [Img(img, '4/5', 'is-style-br-arrondi', alt), ...(pastille ? [P(pastille, 'br-pastille')] : [])])], { width: '46%', verticalAlignment: 'center' }),
], 'br-split', { verticalAlignment: 'center' })]);

const recevez = ({ titre = 'Ce que vous recevez', chapo, nb, photos, items }) => Section('br-recevez', [Cols([
  Col([Box('br-telephone', [
    P('Votre galerie', 'br-telephone-titre'), P(`${nb} photos, gardée un an`, 'br-telephone-sous'),
    cb('core/gallery', { linkTo: 'none', sizeSlug: 'medium', columns: 2, imageCrop: true, className: 'br-telephone-photos' },
      photos.map((n) => cb('core/image', { url: IMG(n), alt: '', sizeSlug: 'medium', linkDestination: 'none' }))),
    P('Tout télécharger', 'br-telephone-bouton'),
  ])], { width: '42%' }),
  Col([H(titre, 2), Lead(chapo), List(items, 'br-liste-oui br-liste-detail')], { width: '58%', verticalAlignment: 'center' }),
], 'br-split', { verticalAlignment: 'center' })]);

const faq = (titre, qs, bg) => Section('br-faq', [Cols([
  Col([H(titre, 2), Muted('Une autre question ? Je vous réponds au téléphone, du lundi au samedi.'), Arrow('Me poser votre question', CTA)], { width: '38%' }),
  Col(qs.map(([q, a]) => Details(q, a)), { width: '62%' }),
], 'br-split')], bg ? { backgroundColor: bg } : {});

const preparer = (texte) => Section('br-preparer', [Cols([
  Col([H('Préparer votre séance', 2), P(texte), Arrow('Lire les conseils pour préparer votre séance', URL('preparer-seance-photo'))], { width: '60%', verticalAlignment: 'center' }),
  Col([Img('lison-portrait', '4/3', 'is-style-br-arrondi', 'Lison Vautrin, appareil photo à la main, dans un champ au coucher du soleil')], { width: '40%', verticalAlignment: 'center' }),
], 'br-split', { verticalAlignment: 'center' })], { backgroundColor: 'surface' });

const fin = (titre, texte, img) => ctaPhoto({ titre, texte, img, alt: '' });

/* ---------- Avis (fictifs, sans prénom d'enfant) ---------- */
const AV = {
  claire: ['Au studio il faisait bon, elle a attendu chaque tétée. On a pleuré en recevant la galerie.', 'Claire et Antoine', 'Naissance au studio'],
  julie: ['Elle est venue chez nous dix jours après la naissance. Notre aîné a même posé avec son petit frère.', 'Julie et Marc', 'Naissance à domicile'],
  amandine: ['Je redoutais les poses compliquées : il n’y en a eu aucune. Bébé a dormi presque tout le temps.', 'Amandine', 'Naissance au studio'],
  ines: ['On ne l’a presque pas vue de la journée, et pourtant tout y est, jusqu’au fou rire des vœux.', 'Inès et Thomas', 'Mariage à Olivet'],
  lea: ['La galerie est arrivée en cinq semaines, avec des photos de nos invités qu’on n’avait jamais vues.', 'Léa et Hugo', 'Mariage à Saint-Jean-le-Blanc'],
  camille: ['Le rendez-vous de préparation nous a enlevé tout le stress du planning photo.', 'Camille et Yanis', 'Mariage à La Ferté-Saint-Aubin'],
  sophie: ['Nos trois enfants ont couru partout, et elle a quand même réussi la photo de famille dont on rêvait.', 'Sophie', 'Famille en bord de Loire'],
  famr: ['Les grands-parents étaient là, huit personnes, et personne n’a eu l’impression de poser.', 'Famille R.', 'Famille au parc floral'],
  elsa: ['Une séance au studio un samedi de novembre, au chaud, avec un bébé de six mois. Parfait.', 'Elsa', 'Famille au studio'],
  pauline: ['Elle m’a fait asseoir dès que j’étais fatiguée. Les photos au coucher du soleil sont magnifiques.', 'Pauline', 'Grossesse en bord de Loire'],
  nora: ['J’ai pris le pack avec la naissance : même ambiance, même photographe, c’était évident.', 'Nora', 'Grossesse et naissance'],
  manon: ['On déteste les photos de nous. Elle nous a fait marcher et rire, et on adore le résultat.', 'Manon et Alex', 'Couple en bord de Loire'],
  isabelle: ['Offerte pour nos dix ans de mariage : le plus beau cadeau qu’on m’ait fait.', 'Isabelle', 'Carte cadeau couple'],
};

const RECEVEZ_ITEMS = (nb, delai) => [
  `<strong>Une galerie en ligne privée</strong> ${nb} photos retouchées, livrées sous ${delai}, gardées un an. Un lien à envoyer à la famille.`,
  '<strong>Le téléchargement en haute définition</strong> Pour imprimer où vous voulez, en grand format si vous le souhaitez.',
  '<strong>Un album, si vous le voulez</strong> 30 × 30 cm, couverture en lin, à partir de 390 € (fictif). Je le mets en page pour vous.',
];
const NON_COMPRIS = ['Les tirages et l’album, sur devis', 'Le déplacement au-delà de 40 km, 0,40 € par km'];

const pages = [];
const TROP = [];
const page = (slug, titre, seo_titre, seo_description, blocs, extra = {}) => {
  if (seo_titre.length > 60) TROP.push(`titre ${seo_titre.length} ${slug}`);
  if (seo_description.length > 155) TROP.push(`description ${seo_description.length} ${slug}`);
  pages.push({ slug, titre, seo_titre, seo_description, markup: serialize(rythme(blocs)), ...extra });
};

/* ================= Accueil ================= */
page('accueil', 'Accueil', 'Photographe à Orléans, naissance et mariage | Lison Vautrin',
  'Lison Vautrin, photographe à Olivet près d’Orléans : naissance, grossesse, famille, couple et mariage. Au studio, chez vous ou dehors, prix affichés.', [
  choixSeance({ lieu: 'Au studio à Olivet, chez vous ou en bord de Loire', titre: 'Photographe à Orléans, de la naissance au mariage', second: ['Voir les tarifs', URL('tarifs')], items: [
    ['Naissance', 'dès <strong>290 €</strong>', S.naissance, 'naissance-lange', 'Nouveau-né endormi, enveloppé dans un lange bleu canard'],
    ['Grossesse', '<strong>190 €</strong>', S.grossesse, 'grossesse-studio', 'Silhouette d’une femme enceinte de profil, au studio, en noir et blanc'],
    ['Famille', '<strong>220 €</strong>', S.famille, 'famille-coquelicots', 'Parents et trois enfants assis dans un champ de fleurs orange'],
    ['Couple', '<strong>180 €</strong>', S.couple, 'couple-plage', 'Couple enlacé qui rit sur une plage de sable au bord de l’eau'],
    ['Mariage', 'dès <strong>1 690 €</strong>', S.mariage, 'mariage-voile', 'Mariés front contre front sous le voile, au coucher du soleil'],
  ] }),
  galerie('Mon style, en quelques photos', 'Des photos en lumière naturelle, sans poses figées. Toutes sont publiées avec l’accord écrit des personnes photographiées, et des deux parents pour un enfant.', ['Voir tout le portfolio', URL('portfolio')], [
    ['naissance-lange', 'Nouveau-né endormi, enveloppé dans un lange bleu canard'],
    ['mariage-voile', 'Mariés front contre front sous le voile, au coucher du soleil'],
    ['grossesse-studio', 'Silhouette d’une femme enceinte de profil, au studio'],
    ['famille-coquelicots', 'Une famille de cinq assise dans un champ de fleurs'],
    ['couple-plage', 'Couple enlacé qui rit au bord de la Loire'],
    ['mariage-petales', 'Sortie de cérémonie sous une pluie de pétales'],
    ['naissance-mains', 'Nouveau-né blotti dans les mains de ses parents, en noir et blanc'],
    ['grossesse-champ', 'Future maman en robe bordeaux dans un champ, au soleil couchant'],
  ]),
  avisNote('Ce qu’en disent les familles', [AV.claire, AV.ines, AV.sophie], 'surface'),
  Section('br-lison', [Cols([
    Col([Img('lison-portrait', '4/5', 'is-style-br-arrondi', 'Lison Vautrin, appareil photo à la main, dans un champ au coucher du soleil')], { width: '42%' }),
    Col([H('Je m’appelle Lison, et c’est moi qui serai là', 2),
      P('J’ai assisté un photographe de mariage pendant six ans à Tours, puis je me suis installée à Olivet en 2018. Je travaille seule : c’est moi qui réponds, qui vous photographie et qui retouche chaque image (fictif).'),
      P(`Je suis formée à la manipulation des nouveau-nés. Bébé ne prend aucune pose à risque, et une main reste toujours près de lui. Les séances naissance se font chez vous ou dans ${A('mon studio photo à Olivet', S.studio)}, chauffé et pensé pour les tout-petits.`),
      Arrow('Mon parcours et ma façon de travailler', URL('a-propos'))], { width: '58%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })]),
  lieux({ titre: 'Au studio, chez vous ou dehors : vous choisissez', chapo: 'Mon studio est installé chez moi, à Olivet. Je viens aussi chez vous, ou on se retrouve dehors. Le prix est le même partout, à 40 km autour d’Olivet.', items: [
    ['studio-jour', 'Le studio de Lison à Olivet : une pièce claire avec une baie vitrée, un pouf et un fauteuil', 'Au studio, chez moi à Olivet', 'Une pièce de 30 m² pensée pour les bébés et les familles, avec la lumière d’une grande baie vitrée.', ['Chauffé à 24 °C pour les nouveau-nés', 'Coin change et fauteuil pour allaiter', 'Tenues et langes prêtés, parking devant la porte'], 'Idéal pour les naissances'],
    ['bebe-panier', 'Bébé souriant assis dans un panier en osier, sur un parquet', 'Chez vous', 'Vos pièces, votre lumière, vos habitudes. Les aînés sont à l’aise et ça se voit sur les photos.', ['Une pièce près d’une fenêtre suffit', 'Sans frais à 40 km autour d’Olivet']],
    ['grossesse-champ', 'Future maman dans un champ au soleil couchant', 'Dehors', 'Bord de Loire, forêt d’Orléans ou parc floral, à l’heure où la lumière est douce.', ['Je vous propose un lieu selon la saison', 'Une date de repli en cas de pluie']],
  ] }),
  etapesImages({ titre: 'Comment ça se passe', chapo: 'Les mêmes quatre étapes pour toutes les séances, de la naissance au mariage.', items: [
    ['lison-portrait', 'Lison Vautrin, appareil photo à la main', 'Quand vous voulez', 'Vous choisissez', 'Une séance, un lieu et une date, en ligne ou par téléphone.'],
    ['studio-jour', 'Le studio photo, prêt à recevoir', 'Sous 24 h', 'On en parle', 'Un appel de 15 minutes pour préparer la séance ensemble.'],
    ['naissance-mains', 'Nouveau-né dans les mains de ses parents', 'Le jour J', 'La séance', 'Au studio, chez vous ou dehors, sans poses figées.'],
    ['famille-coquelicots', 'Une famille dans un champ de fleurs', 'Sous 2 à 6 semaines', 'Votre galerie', 'Les photos retouchées en ligne, à télécharger et à partager.'],
  ] }),
  faq('Ce qu’on me demande avant de réserver', [
    ['Le studio ou chez nous : lequel choisir pour une naissance ?', `Le studio, si vous voulez une lumière douce garantie et rien à préparer. Chez vous, si vous voulez votre décor et éviter un trajet à bébé. Le prix est le même. Tous les détails sont sur la page ${A('séance photo naissance', S.naissance)}.`],
    ['Combien coûte une séance photo ?', `De 180 € pour un couple à 290 € pour une naissance, retouche et galerie en ligne comprises. Un mariage commence à 1 690 €. Le détail est sur la page ${A('tarifs', 'tarifs')}, et chaque séance a sa page dans ${A('toutes les séances photo', 'seances')} (fictifs).`],
    ['Quand faut-il réserver ?', 'Pour une naissance, pendant la grossesse : je garde une date autour du terme. Pour un mariage, 12 à 18 mois avant : je ne fais qu’un mariage par week-end.'],
    ['Venez-vous loin d’Olivet ?', 'Oui. C’est sans frais à 40 km autour d’Olivet : Orléans, Saint-Jean-le-Blanc, Saint-Jean-de-Braye, La Ferté-Saint-Aubin, Meung-sur-Loire. Au-delà, 0,40 € par kilomètre (fictif).'],
  ]),
  fin('Votre date est peut-être encore libre', 'Je vous réponds sous 24 h avec mes disponibilités. Rien n’est payé avant que nous ayons choisi la date ensemble (fictif).', 'naissance-mains'),
]);

/* ================= Séances (page parente) ================= */
page('seances', 'Séances', 'Séances photo à Orléans : prix et lieux | Lison Vautrin',
  'Naissance, grossesse, famille, couple ou mariage : chaque séance photo près d’Orléans avec sa durée, son prix et ses lieux, au studio ou chez vous.', [
  teteTexte('Séances photo à Orléans et Olivet', 'Cinq séances, cinq moments de la vie. Pour chacune : la durée, le nombre de photos, le prix et les lieux possibles. Le prix est le même au studio, chez vous ou dehors, à 40 km autour d’Olivet.'),
  Section('br-tarifs-liste-section', [Box('br-tarifs-liste', [
    ['naissance-lange', 'Nouveau-né endormi dans un lange bleu', 'Naissance', S.naissance, 'Bébé de 5 à 15 jours, 2 h à 2 h 30, 25 photos. Au studio ou chez vous.', 'dès 290 €'],
    ['grossesse-studio', 'Femme enceinte de profil au studio', 'Grossesse', S.grossesse, 'Entre 7 et 8 mois, 1 h, 15 photos. Au studio ou en bord de Loire.', '190 €'],
    ['famille-coquelicots', 'Famille dans un champ de fleurs', 'Famille', S.famille, 'Jusqu’à 8 personnes, 1 h 30, 20 photos. Dehors, chez vous ou au studio.', '220 €'],
    ['couple-plage', 'Couple au bord de la Loire', 'Couple', S.couple, 'Fiançailles ou envie de photos à deux, 1 h, 15 photos.', '180 €'],
    ['mariage-voile', 'Mariés sous le voile', 'Mariage', S.mariage, 'De 8 h à 11 h de présence, 400 à 550 photos, Loiret et Loir-et-Cher.', 'dès 1 690 €'],
  ].map(tarifLigne)), P(`Les prix sont fictifs. Le détail de ce que comprend chaque prix est sur la page ${A('tarifs', 'tarifs')}.`, 'br-muted')]),
  galerie('Toutes les séances se font en lumière naturelle', `Au ${A('studio d’Olivet', S.studio)}, chez vous ou dehors. Les photos sont publiées avec l’accord écrit des personnes photographiées.`, ['Voir le portfolio', URL('portfolio')], [
    ['naissance-mains', 'Nouveau-né dans les mains de ses parents, en noir et blanc'],
    ['grossesse-champ', 'Future maman dans un champ au soleil couchant'],
    ['mariage-petales', 'Sortie de cérémonie sous une pluie de pétales'],
  ], 'surface'),
  fin('Vous hésitez entre deux séances ?', 'Dites-moi ce que vous aimeriez garder en photo : je vous conseille au téléphone, sans engagement.', 'famille-coquelicots'),
], { menu: true, menu_description: '' });

/* ================= Pages de séance ================= */
const seance = (c) => page(c.slug, c.titre, c.seo[0], c.seo[1], [
  teteSeance(c.tete),
  galerie(c.galerie[0], c.galerie[1], [c.histoire[0], `${URL('portfolio')}${c.histoire[1]}/`], c.galerie[2], 'surface'),
  ...(c.apresGalerie || []),
  lieux(c.lieux),
  prixBloc(c.prix),
  recevez(c.recevez),
  etapesImages(c.etapes),
  avisNote('Ce qu’en disent les familles', c.avis, 'surface'),
  preparer(c.preparer),
  faq(c.faq[0], c.faq[1]),
  fin(c.fin[0], c.fin[1], c.fin[2]),
], { parent: 'seances', menu: true, menu_description: c.menu });

seance({
  slug: S.naissance, titre: 'Naissance', histoire: ['Lire l’histoire d’une naissance au studio', 'une-naissance-au-studio-avec-la-grande-soeur'], menu: 'Bébé de 5 à 15 jours, dès 290 €',
  seo: ['Photographe naissance à Orléans, au studio ou chez vous', 'Séance photo naissance près d’Orléans, bébé de 5 à 15 jours : 290 €, 25 photos retouchées, au studio chauffé à Olivet ou chez vous. Aucune pose à risque.'],
  tete: { h1: 'Photographe naissance à Orléans, au studio ou chez vous', lead: 'Une séance de 2 h à 2 h 30 quand bébé a entre 5 et 15 jours. 290 €, 25 photos retouchées et une galerie en ligne sous trois semaines (fictif).',
    btns: [Btn('Réserver ma séance naissance', CTA), Btn('Voir les prix', URL('tarifs'), 'is-style-outline')],
    stats: [['5 à 15 jours', 'l’âge idéal de bébé'], ['2 h 30', 'au rythme des tétées'], ['25 photos', 'retouchées, incluses']],
    img: 'naissance-lange', alt: 'Nouveau-né endormi, enveloppé dans un lange bleu canard, au studio' },
  galerie: ['Des séances naissance récentes', 'Bébé dort, les parents sont là, rien n’est forcé. Cliquez sur une photo pour l’agrandir.', [
    ['naissance-lange', 'Nouveau-né endormi dans un lange bleu, au studio'], ['naissance-mains', 'Nouveau-né blotti dans les mains de ses parents, en noir et blanc'], ['bebe-panier', 'Bébé souriant assis dans un panier en osier'],
  ]],
  apresGalerie: [Section('br-securite', [Cols([
    Col([H('Aucune pose à risque, une main toujours à côté de bébé', 2),
      P('Bébé reste dans vos bras, sur le pouf ou dans son couffin. Je ne fais aucune pose suspendue ni de montage acrobatique : ce que vous voyez sur les photos s’est vraiment passé.'),
      P(`Je suis formée à la manipulation des nouveau-nés, et la séance s’arrête dès que bébé en a besoin : une tétée, un change, un câlin. ${A('Mon parcours et ma formation', 'a-propos')} (fictif).`)], { width: '58%', verticalAlignment: 'center' }),
    Col([Img('naissance-mains', '4/3', 'is-style-br-arrondi', 'Nouveau-né blotti dans les mains de ses parents')], { width: '42%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })])],
  lieux: { titre: 'Au studio ou chez vous : le même prix, à vous de choisir', chapo: 'Les deux se valent pour les photos. Choisissez selon ce qui vous repose le plus dans ces premiers jours.', items: [
    ['studio-jour', 'Le studio d’Olivet : baie vitrée, pouf et fauteuil pour allaiter', 'Au studio, à Olivet', `Rien à préparer chez vous : la pièce est chauffée, la lumière est douce toute la journée. Découvrez ${A('le studio en photos', S.studio)}.`, ['Chauffé à 24 °C, coin change, fauteuil pour allaiter', 'Langes, bonnets et tenues prêtés', 'Parking devant la porte, de plain-pied'], 'Idéal pour les naissances'],
    ['bebe-panier', 'Bébé dans un panier, à la maison', 'Chez vous', 'Pas de trajet pour bébé ni pour la maman. Vos pièces et vos objets racontent aussi ces premiers jours.', ['Une pièce près d’une fenêtre suffit', 'J’apporte le chauffage d’appoint et les langes', 'Sans frais à 40 km autour d’Olivet']],
  ] },
  prix: { titre: '290 €, et tout ce que ça comprend', bouton: 'Réserver ma séance naissance', pastille: 'Galerie livrée sous 3 semaines',
    oui: ['La séance au studio ou chez vous, 2 h à 2 h 30', 'Les parents, frères et sœurs sur les photos', '25 photos retouchées en haute définition', 'Une galerie en ligne à partager, gardée un an'], non: NON_COMPRIS,
    note: `Avec la ${A('séance grossesse', S.grossesse)}, les deux font 440 € au lieu de 480 € (fictif). Pourquoi ce prix ? Une séance naissance représente environ 9 heures de travail : le détail est sur la page ${A('tarifs', 'tarifs')}.`,
    img: 'studio-jour', alt: 'Le studio d’Olivet, où se font la plupart des séances naissance' },
  recevez: { chapo: 'Pas de clé USB ni de photos à trier : une galerie claire, prête à envoyer à vos proches.', nb: 25, photos: ['naissance-lange', 'naissance-mains', 'bebe-panier', 'studio-jour'], items: RECEVEZ_ITEMS(25, 'trois semaines') },
  etapes: { titre: 'Une séance naissance, en quatre temps', chapo: 'De la réservation à la galerie, vous savez à chaque étape ce qui vous attend.', items: [
    ['grossesse-studio', 'Femme enceinte au studio', 'Pendant la grossesse', 'Vous réservez', 'Un appel de 15 minutes, puis une date autour du terme. Acompte de 30 % (fictif).'],
    ['naissance-mains', 'Nouveau-né dans les mains de ses parents', 'Dans les 48 h après la naissance', 'Vous me prévenez', 'Un SMS suffit : nous fixons le jour de la séance ensemble.'],
    ['naissance-lange', 'Nouveau-né endormi dans un lange', 'Entre 5 et 15 jours', 'La séance', 'Au studio ou chez vous, 2 h à 2 h 30, avec des pauses pour les tétées.'],
    ['bebe-panier', 'Bébé souriant', 'Sous 3 semaines', 'Votre galerie', '25 photos retouchées à télécharger et un lien à partager avec la famille.'],
  ] },
  avis: [AV.claire, AV.julie, AV.amandine],
  preparer: 'Des couleurs douces et unies pour les parents ; pour bébé, je prête tout. Le jour J, on s’organise pour qu’il dorme pendant les photos : tétée en arrivant, pièce bien chauffée, et du temps devant nous. Vous recevez aussi ces conseils par e-mail une semaine avant.',
  faq: ['Vos questions sur la séance naissance', [
    ['À quel âge faire les photos de naissance ?', 'Entre 5 et 15 jours : bébé dort beaucoup et se laisse porter facilement. Après, la séance reste possible, avec plus d’éveil sur les photos.'],
    ['Le studio ou chez nous : lequel choisir ?', 'Le studio si vous voulez une pièce chauffée et rien à préparer. Chez vous si vous préférez éviter le trajet et garder votre décor. Le prix est le même.'],
    ['Combien coûte une séance photo naissance ?', `290 €, avec 25 photos retouchées et la galerie en ligne. Pour comparer avec d’autres photographes, lisez ${A('ce que doit comprendre le prix d’un photographe naissance', 'prix-photographe-naissance')}.`],
    ['Et si bébé arrive en avance ?', 'Prévenez-moi dans les 48 h : je garde des créneaux libres chaque semaine pour les naissances.'],
  ]],
  fin: ['Réservez pendant la grossesse', 'Dites-moi la date du terme : je la garde de côté et nous fixons le jour exact après la naissance (fictif).', 'naissance-lange'],
});

seance({
  slug: S.grossesse, titre: 'Grossesse', histoire: ['Lire l’histoire d’une séance au coucher du soleil', 'une-seance-grossesse-au-coucher-du-soleil'], menu: 'Entre 7 et 8 mois, 190 €',
  seo: ['Photographe grossesse à Orléans, studio ou bord de Loire', 'Séance photo grossesse près d’Orléans à 7 ou 8 mois : une heure, 190 €, 15 photos retouchées, au studio à Olivet ou en bord de Loire au coucher du soleil.'],
  tete: { h1: 'Photographe grossesse à Orléans, au studio ou en bord de Loire', lead: 'Une heure de séance entre 7 et 8 mois de grossesse, sans vous fatiguer. 190 €, 15 photos retouchées et une galerie en ligne sous deux semaines (fictif).',
    btns: [Btn('Réserver ma séance grossesse', CTA), Btn('Grossesse et naissance : 440 €', URL('tarifs'), 'is-style-outline')],
    stats: [['7 à 8 mois', 'le meilleur moment'], ['1 h', 'assise quand vous voulez'], ['15 photos', 'retouchées, incluses']],
    img: 'grossesse-champ', alt: 'Future maman en robe bordeaux dans un champ, au soleil couchant' },
  galerie: ['Des séances grossesse récentes', 'Au studio en noir et blanc, ou dehors à l’heure dorée. Cliquez sur une photo pour l’agrandir.', [
    ['grossesse-champ', 'Future maman dans un champ au soleil couchant'], ['grossesse-studio', 'Silhouette d’une femme enceinte de profil, au studio'], ['naissance-mains', 'Le même bébé, quelques semaines plus tard, dans les mains de ses parents'],
  ]],
  lieux: { titre: 'Au studio ou dehors : deux ambiances', chapo: 'Le studio pour une lumière douce en toute saison, la Loire pour le coucher du soleil, de mai à septembre. Chez vous, c’est possible aussi, au même prix.', items: [
    ['grossesse-studio', 'Femme enceinte de profil, au studio', 'Au studio, à Olivet', `Fond clair, lumière de fenêtre, et des robes de grossesse prêtées. ${A('Voir le studio', S.studio)}.`, ['Chauffé, avec un fauteuil pour vous asseoir', 'Robes et voilages prêtés', 'Toute l’année, à l’heure qui vous arrange'], 'Toute l’année'],
    ['grossesse-champ', 'Future maman dans un champ', 'En bord de Loire', 'Une heure avant le coucher du soleil, quand la lumière devient dorée. Je choisis un endroit plat et facile d’accès.', ['De mai à septembre', 'Une date de repli en cas de pluie', 'Sans frais à 40 km autour d’Olivet']],
  ] },
  prix: { titre: '190 €, et tout ce que ça comprend', bouton: 'Réserver ma séance grossesse', pastille: 'Avec la naissance : 440 €',
    oui: ['La séance d’une heure, au studio ou dehors', 'Votre conjoint et vos aînés sur les photos', '15 photos retouchées en haute définition', 'Une galerie en ligne à partager, gardée un an'], non: NON_COMPRIS,
    note: `Avec la ${A('séance naissance', S.naissance)}, les deux font 440 € au lieu de 480 € : même photographe, même ambiance (fictif).`,
    img: 'grossesse-studio', alt: 'Silhouette d’une femme enceinte au studio' },
  recevez: { chapo: 'Pas de clé USB ni de photos à trier : une galerie claire, prête à envoyer à vos proches.', nb: 15, photos: ['grossesse-champ', 'grossesse-studio', 'naissance-mains', 'couple-plage'], items: RECEVEZ_ITEMS(15, 'deux semaines') },
  etapes: { titre: 'Votre séance grossesse, en quatre temps', chapo: 'Réservez vers 6 mois : les plus belles semaines partent vite.', items: [
    ['lison-portrait', 'Lison Vautrin', 'Vers 6 mois', 'Vous réservez', 'Un appel de 15 minutes pour choisir le lieu et la date.'],
    ['studio-jour', 'Le studio', 'Une semaine avant', 'Je vous conseille', 'Une page de conseils pour les tenues, les couleurs et les accessoires.'],
    ['grossesse-champ', 'Future maman dans un champ', 'Entre 7 et 8 mois', 'La séance', 'Une heure, avec des pauses pour vous asseoir.'],
    ['grossesse-studio', 'Femme enceinte au studio', 'Sous 2 semaines', 'Votre galerie', '15 photos retouchées à télécharger et à partager.'],
  ] },
  avis: [AV.pauline, AV.nora, AV.julie],
  preparer: 'Une tenue près du corps, aux couleurs douces ; au studio, je prête des robes et des voilages. Dehors, on se retrouve une heure avant le coucher du soleil, avec de l’eau et des chaussures plates pour marcher jusqu’au lieu.',
  faq: ['Vos questions sur la séance grossesse', [
    ['Quand faire la séance grossesse ?', 'Entre 7 et 8 mois : le ventre est bien rond et vous êtes encore à l’aise pour bouger.'],
    ['Que dois-je porter ?', 'Une tenue près du corps, aux couleurs douces. Au studio, je prête des robes et des voilages.'],
    ['Mon conjoint peut-il venir ?', 'Oui, et vos aînés aussi : ils sont compris dans le prix.'],
    ['Et s’il pleut le jour prévu ?', 'On bascule au studio, ou on choisit une autre date, sans frais.'],
  ]],
  fin: ['Réservez vers 6 mois de grossesse', 'Avec la séance naissance, les deux font 440 €. Je vous réponds sous 24 h avec mes disponibilités (fictif).', 'grossesse-champ'],
});

seance({
  slug: S.famille, titre: 'Famille', histoire: ['Lire l’histoire d’une famille en bord de Loire', 'une-famille-de-cinq-en-bord-de-loire'], menu: 'Jusqu’à 8 personnes, 220 €',
  seo: ['Photographe famille à Orléans : dehors, chez vous ou studio', 'Séance photo famille près d’Orléans : 1 h 30 de jeux sans poses figées, jusqu’à 8 personnes, 220 € et 20 photos retouchées. Dehors, chez vous ou au studio.'],
  tete: { h1: 'Photographe famille à Orléans, dehors, chez vous ou au studio', lead: 'Une heure et demie à jouer, à courir et à se câliner, sans poses figées. 220 €, 20 photos retouchées et une galerie en ligne (fictif).',
    btns: [Btn('Réserver ma séance famille', CTA), Btn('Voir les prix', URL('tarifs'), 'is-style-outline')],
    stats: [['1 h 30', 'au rythme des enfants'], ['20 photos', 'retouchées, incluses'], ['8 personnes', 'au plus, dehors']],
    img: 'famille-coquelicots', alt: 'Parents et trois enfants assis dans un champ de fleurs orange' },
  galerie: ['Des séances famille récentes', 'Des enfants qui jouent, des parents qui rient : je photographie ce qui se passe.', [
    ['famille-coquelicots', 'Famille de cinq dans un champ de fleurs'], ['bebe-panier', 'Bébé souriant dans un panier en osier'], ['couple-plage', 'Les parents, à deux, au bord de la Loire'],
  ]],
  lieux: { titre: 'Dehors, chez vous ou au studio', chapo: 'Le prix est le même partout à 40 km autour d’Olivet. Je vous aide à choisir selon l’âge des enfants et la saison.', items: [
    ['famille-coquelicots', 'Famille dans un champ de fleurs', 'Dehors', 'Bords de Loire, forêt d’Orléans ou parc floral, à l’heure dorée.', ['Les enfants courent et oublient l’appareil', 'D’avril à octobre'], 'Le plus demandé'],
    ['bebe-panier', 'Bébé à la maison', 'Chez vous', 'Dans votre salon ou votre jardin, avec vos habitudes.', ['Idéal avec un bébé ou un tout-petit', 'Toute l’année']],
    ['studio-jour', 'Le studio d’Olivet', 'Au studio', `Une lumière douce toute l’année, à l’abri de la météo. ${A('Voir le studio', S.studio)}.`, ['Jusqu’à 5 personnes', 'Toute l’année']],
  ] },
  prix: { titre: '220 €, et tout ce que ça comprend', bouton: 'Réserver ma séance famille', pastille: 'Galerie livrée sous 3 semaines',
    oui: ['La séance d’une heure et demie, dehors, chez vous ou au studio', 'Toute la famille, grands-parents compris, jusqu’à 8 personnes', '20 photos retouchées en haute définition', 'Une galerie en ligne à partager, gardée un an'], non: NON_COMPRIS,
    img: 'famille-coquelicots', alt: 'Famille dans un champ de fleurs' },
  recevez: { chapo: 'Pas de clé USB ni de photos à trier : une galerie claire, prête à envoyer à vos proches.', nb: 20, photos: ['famille-coquelicots', 'bebe-panier', 'couple-plage', 'naissance-mains'], items: RECEVEZ_ITEMS(20, 'trois semaines') },
  etapes: { titre: 'Votre séance famille, en quatre temps', chapo: 'Pas de poses à tenir : je vous propose des jeux, et je photographie ce qui se passe.', items: [
    ['lison-portrait', 'Lison Vautrin', 'Quand vous voulez', 'Vous réservez', 'Un appel pour choisir la date et l’heure selon les siestes.'],
    ['grossesse-champ', 'Un champ au soleil couchant', 'Une semaine avant', 'On choisit le lieu', 'Je vous propose deux ou trois endroits selon la saison.'],
    ['famille-coquelicots', 'Famille dans un champ', 'Le jour J', 'La séance', 'Une heure et demie de jeux, de câlins et de balades.'],
    ['bebe-panier', 'Bébé souriant', 'Sous 3 semaines', 'Votre galerie', '20 photos retouchées à télécharger et à partager.'],
  ] },
  avis: [AV.sophie, AV.famr, AV.elsa],
  preparer: 'Des couleurs qui s’accordent sans être identiques, et des chaussures pour marcher dans l’herbe. On choisit l’heure selon les siestes, et on prévoit un goûter : un enfant qui a faim ne sourit pas longtemps.',
  faq: ['Vos questions sur la séance famille', [
    ['Et si les enfants ne coopèrent pas ?', 'C’est prévu. On fait des pauses, on joue, et les plus belles photos arrivent souvent quand ils oublient l’appareil.'],
    ['Les grands-parents peuvent-ils venir ?', 'Oui, jusqu’à 8 personnes dehors et 5 au studio, sans supplément.'],
    ['Que devons-nous porter ?', `Des couleurs qui s’accordent sans être identiques. Tous les conseils sont dans ${A('préparer sa séance photo', 'preparer-seance-photo')}.`],
    ['Et s’il pleut ?', 'On reporte sans frais, ou on bascule au studio.'],
  ]],
  fin: ['Votre samedi est peut-être encore libre', 'Au studio toute l’année, dehors d’avril à octobre. Je vous réponds sous 24 h (fictif).', 'famille-coquelicots'],
});

seance({
  slug: S.couple, titre: 'Couple', histoire: ['Lire l’histoire de Manon et Alex', 'manon-et-alex-une-heure-a-deux-en-bord-de-loire'], menu: 'Une heure à deux, 180 €',
  seo: ['Séance photo couple à Orléans, au coucher du soleil', 'Séance photo couple près d’Orléans : une heure en bord de Loire ou au studio, 180 €, 15 photos retouchées. Fiançailles à 150 € avec votre mariage.'],
  tete: { h1: 'Séance photo couple à Orléans, au coucher du soleil', lead: 'Une heure à deux, pour des fiançailles, un anniversaire ou juste l’envie. 180 €, 15 photos retouchées (fictif).',
    btns: [Btn('Réserver notre séance', CTA), Btn('Offrir une séance', URL('tarifs'), 'is-style-outline')],
    stats: [['1 h', 'à deux, sans pression'], ['15 photos', 'retouchées, incluses'], ['150 €', 'avant votre mariage']],
    img: 'couple-plage', alt: 'Couple enlacé qui rit sur une plage de Loire' },
  galerie: ['Des séances couple récentes', 'Je vous fais marcher, parler, rire : vous n’avez pas à poser.', [
    ['couple-plage', 'Couple enlacé au bord de la Loire'], ['mariage-voile', 'Fiancés front contre front sous un voile'], ['mariage-champ', 'Couple dans un champ de blé au coucher du soleil'],
  ]],
  lieux: { titre: 'Dehors ou au studio', chapo: 'Je vous guide tout le long : pas besoin de savoir poser, ni d’aimer être photographiés.', items: [
    ['couple-plage', 'Couple au bord de la Loire', 'Dehors', 'Une plage de Loire, un chemin de forêt ou une rue d’Orléans, au coucher du soleil.', ['Le plus naturel pour bouger', 'D’avril à octobre'], 'Le plus demandé'],
    ['studio-jour', 'Le studio d’Olivet', 'Au studio', `Pour des portraits plus doux, ou si vous préférez rester à l’abri des regards. ${A('Voir le studio', S.studio)}.`, ['Toute l’année', 'Discret et au calme']],
  ] },
  prix: { titre: '180 €, et tout ce que ça comprend', bouton: 'Réserver notre séance', pastille: '150 € avec votre mariage',
    oui: ['La séance d’une heure, dehors ou au studio', 'Mes conseils pour les tenues et le lieu', '15 photos retouchées en haute définition', 'Une galerie en ligne, gardée un an'], non: ['Les tirages, sur devis', 'Le déplacement au-delà de 40 km, 0,40 € par km'],
    note: `Vous vous mariez ? Si vous réservez aussi votre ${A('photographe de mariage', S.mariage)} avec moi, la séance de fiançailles passe à 150 € (fictif).`,
    img: 'mariage-voile', alt: 'Fiancés sous un voile au coucher du soleil' },
  recevez: { chapo: 'Pas de clé USB ni de photos à trier : une galerie claire, à garder et à partager.', nb: 15, photos: ['couple-plage', 'mariage-voile', 'mariage-champ', 'grossesse-champ'], items: RECEVEZ_ITEMS(15, 'deux semaines') },
  etapes: { titre: 'Votre séance couple, en quatre temps', chapo: 'Une heure qui passe vite : la plupart des couples disent avoir oublié l’appareil au bout de dix minutes.', items: [
    ['lison-portrait', 'Lison Vautrin', 'Quand vous voulez', 'Vous réservez', 'Ou vous offrez la séance avec une carte cadeau.'],
    ['grossesse-champ', 'Un champ au soleil couchant', 'Quelques jours avant', 'On choisit le lieu', 'Je vous propose des endroits selon votre style.'],
    ['couple-plage', 'Couple au bord de la Loire', 'Le jour J', 'La séance', 'Une heure de balade, je vous guide sans vous faire poser.'],
    ['mariage-voile', 'Couple sous un voile', 'Sous 2 semaines', 'Votre galerie', '15 photos retouchées à télécharger.'],
  ] },
  avis: [AV.manon, AV.isabelle, AV.camille],
  preparer: 'Des tenues dans lesquelles vous vous sentez bien, aux couleurs qui s’accordent, et des chaussures pour marcher sur le sable. On se retrouve une heure avant le coucher du soleil ; je vous envoie le lieu exact la veille.',
  faq: ['Vos questions sur la séance couple', [
    ['On n’aime pas être photographiés : ça va marcher ?', 'Oui. Je vous fais marcher, parler, rire : vous n’avez pas à poser, et ça se voit sur les photos.'],
    ['Peut-on offrir une séance ?', `Oui, avec une carte cadeau valable un an, envoyée par e-mail ou par courrier. Elle se commande depuis la page ${A('tarifs', 'tarifs')} (fictif).`],
    ['Que devons-nous porter ?', 'Des tenues dans lesquelles vous vous sentez bien, aux couleurs qui s’accordent.'],
    ['La séance de fiançailles est-elle moins chère ?', 'Oui, 150 € au lieu de 180 € si vous réservez aussi votre mariage avec moi.'],
  ]],
  fin: ['Un coucher de soleil à deux', 'D’avril à octobre en bord de Loire, toute l’année au studio. Je vous réponds sous 24 h (fictif).', 'couple-plage'],
});

/* ================= Mariage ================= */
page(S.mariage, 'Mariage', 'Photographe mariage Orléans et Loiret | Lison Vautrin',
  'Photographe de mariage à Orléans et dans le Loiret : un seul mariage par week-end, dès 1 690 €, environ 400 photos. Vérifiez si votre date est libre.', [
  teteSeance({ h1: 'Photographe de mariage à Orléans et dans le Loiret', lead: 'Je photographie votre journée comme elle se passe, sans vous faire poser des heures. À partir de 1 690 €, environ 400 photos et une galerie privée sous six semaines (fictif).',
    btns: [Btn('Vérifier ma date', CTA), Btn('Voir les deux formules', '#formules', 'is-style-outline')],
    stats: [['1 mariage', 'par week-end, jamais deux'], ['8 h', 'de présence, ou plus'], ['400 photos', 'retouchées, environ']],
    img: 'mariage-voile', alt: 'Mariés front contre front sous le voile, au coucher du soleil', dispo: false }),
  etapesImages({ titre: 'Un mariage raconté, de la mairie au coucher du soleil', chapo: 'Inès et Thomas, septembre 2026 à Olivet, avec leur accord. Toute la journée, et pas seulement les plus belles photos : ce que vous recevrez vraiment (fictif).', numeros: false, items: [
    ['mariage-petales', 'Sortie de la mairie sous une pluie de pétales, les invités applaudissent', '15 h', 'La sortie de la mairie', 'Les pétales, les cris, la famille qui pleure de joie.'],
    ['mariage-champ', 'Les mariés enlacés dans un champ de blé, le voile au vent', '18 h', 'Vingt minutes à deux', 'Un moment sans la foule, pour des portraits dans les blés.'],
    ['mariage-voile', 'Les mariés sous le voile, à contre-jour', '20 h 30', 'Le coucher du soleil', 'La lumière dorée, juste avant le dîner.'],
  ], apres: [Arrow('Lire toute l’histoire de ce mariage', `${URL('portfolio')}ines-et-thomas-un-mariage-au-moulin-du-loiret/`)] }),
  Section('br-approche', [Cols([
    Col([Img('mariage-petales', '4/5', 'is-style-br-arrondi', 'Invités qui lancent des pétales sur les mariés')], { width: '42%' }),
    Col([H('Votre journée, telle qu’elle s’est vraiment passée', 2),
      P('Je me fonds parmi vos invités et je photographie ce qui arrive : le rire de votre grand-mère, les pétales qui tombent, la main qui serre la vôtre pendant les discours.'),
      P('On garde un moment à deux, vingt minutes au coucher du soleil, pour des portraits sans la foule. Pour le reste, vous profitez de votre journée, je m’occupe des photos.'),
      List(['Un rendez-vous de préparation trois mois avant', 'Un planning photo partagé avec vos témoins', 'Une photographe remplaçante prévue au contrat si je suis malade'], 'br-liste-oui br-liste-simple')], { width: '58%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })]),
  Section('br-formules', [
    tetes('Deux formules, des prix affichés', 'Le déplacement est compris dans le Loiret et le Loir-et-Cher. Un acompte de 30 % réserve votre date (fictif).'),
    Cols([
      Col([Box('br-formule', [H('La journée', 3), P('1 690 €', 'br-formule-prix'), Muted('Des préparatifs au début de soirée.'), List(['8 h de présence', 'Environ 400 photos retouchées', 'Galerie privée en ligne sous 6 semaines', 'Rendez-vous de préparation'], 'br-liste-oui'), Btns(Btn('Vérifier ma date', CTA, 'is-style-outline'))])]),
      Col([Box('br-formule is-mise-en-avant', [P('Le plus choisi', 'br-pastille'), H('Journée et soirée', 3), P('2 090 €', 'br-formule-prix'), Muted('Jusqu’à la première danse et la pièce montée.'), List(['11 h de présence', 'Environ 550 photos retouchées', 'Séance couple avant le mariage, offerte', 'Tout ce que comprend la journée'], 'br-liste-oui'), Btns(Btn('Vérifier ma date', CTA))])]),
      Col([Box('br-formule', [H('En option', 3), cb('core/table', { className: 'br-table br-options', hasFixedLayout: false,
        body: [[`Séance de ${A('fiançailles', S.couple)}`, '150 €'], ['Album 30 × 30 cm', 'dès 390 €'], ['Heure supplémentaire', '120 €'], ['Hors Loiret et Loir-et-Cher', '0,40 € / km']].map((r) => ({ cells: r.map((x) => ({ content: fr(x), tag: 'td' })) })) }),
        Muted('Tous les prix sont fictifs.')])]),
    ], 'br-formules-grille'),
  ], { backgroundColor: 'surface', anchor: 'formules' }),
  avisNote('Ce qu’en disent les mariés', [AV.ines, AV.lea, AV.camille]),
  Section('br-lieux-reception', [Cols([
    Col([H('Les lieux où j’ai déjà photographié', 2), P('Je connais leurs coins de lumière et leurs horaires. Votre lieu n’y est pas ? Je viens le repérer avant le mariage, sans frais dans le Loiret (lieux fictifs).')], { width: '42%' }),
    Col([cb('core/table', { className: 'br-table', hasFixedLayout: false,
      head: [{ cells: [{ content: 'Lieu de réception', tag: 'th' }, { content: 'Mariages', tag: 'th' }] }],
      body: [['Moulin du Loiret, Olivet', '4'], ['Domaine des Tilleuls, Saint-Hilaire-Saint-Mesmin', '3'], ['Orangerie du Parc, Orléans', '3'], ['Château de la Rive, Meung-sur-Loire', '2'], ['Ferme de la Pinsonnière, Chaingy', '2'], ['Domaine de Beauvoir, Beaugency', '1']].map((r) => ({ cells: r.map((x) => ({ content: fr(x), tag: 'td' })) })) })], { width: '58%' }),
  ], 'br-split')], { backgroundColor: 'surface' }),
  etapesImages({ titre: 'Votre mariage, en quatre temps', chapo: 'Vous savez à chaque étape ce qui vous attend, de la réservation à la galerie.', items: [
    ['couple-plage', 'Couple au bord de la Loire', '12 à 18 mois avant', 'Vous réservez', 'Un appel pour faire connaissance, puis le contrat et l’acompte de 30 %.'],
    ['mariage-champ', 'Mariés dans un champ', '3 mois avant', 'On prépare la journée', 'Un rendez-vous pour le planning, les lieux et la liste des photos de groupe.'],
    ['mariage-petales', 'Sortie de cérémonie', 'Le jour J', 'Je suis là, discrète', 'Des préparatifs à la soirée, selon votre formule.'],
    ['mariage-voile', 'Mariés sous le voile', 'Sous 6 semaines', 'Votre galerie', 'Les photos retouchées en ligne, à télécharger et à partager.'],
  ] }),
  faq('Vos questions sur le mariage', [
    ['Combien de temps à l’avance faut-il réserver ?', 'Comptez 12 à 18 mois pour un samedi de mai à septembre. Je ne fais qu’un mariage par week-end, les dates partent vite.'],
    ['Combien coûte un photographe de mariage dans le Loiret ?', 'Chez moi, 1 690 € pour la journée et 2 090 € jusqu’à la soirée, déplacement compris dans le Loiret et le Loir-et-Cher (fictif). Comparez surtout la durée de présence et le nombre de photos livrées.'],
    ['Et si vous êtes malade le jour du mariage ?', 'Une photographe de confiance, au même style, est prévue au contrat pour me remplacer. Vous la rencontrez avant si vous le souhaitez.'],
    ['Faut-il prévoir un repas pour vous ?', 'Oui, un repas simple à la même heure que vos invités, pour ne rien manquer de la soirée.'],
  ], 'surface'),
  fin('Votre date est peut-être encore libre', 'Mariages 2027 : quatre samedis de juin et de septembre encore libres. Envoyez votre date, je vous réponds sous 24 h (fictif).', 'mariage-champ'),
], { parent: 'seances', menu: true, menu_description: 'Loiret et Loir-et-Cher, dès 1 690 €' });

/* ================= Le studio ================= */
page(S.studio, 'Le studio', 'Studio photo à Olivet, près d’Orléans | Lison Vautrin',
  'Un studio photo de 30 m² à Olivet, chauffé à 24 °C et pensé pour les nouveau-nés : lumière du jour, coin change, parking. Naissance, grossesse, famille.', [
  teteSeance({ h1: 'Un studio photo à Olivet, pensé pour les nouveau-nés', lead: '30 m² dans ma maison, à 10 minutes du centre d’Orléans. On y photographie les naissances, les grossesses, les couples et les petites familles, en lumière du jour. Sur rendez-vous : l’adresse vous est donnée à la réservation (fictif).',
    btns: [Btn('Réserver une séance au studio', CTA), Btn('Voir les séances', URL('seances'), 'is-style-outline')],
    stats: [['30 m²', 'en lumière du jour'], ['24 °C', 'toute l’année'], ['0 €', 'de plus qu’à domicile']],
    img: 'studio-jour', alt: 'Le studio : une pièce claire avec une baie vitrée voilée, un pouf, un fauteuil et des plantes' }),
  faitsIcones({ titre: 'Tout est prêt avant votre arrivée', chapo: 'Vous venez avec bébé et un change de couches. Le reste est déjà sur place.', img: 'naissance-lange', alt: 'Nouveau-né endormi sur le pouf du studio', items: [
    ['soleil', 'Lumière du jour', 'Une grande fenêtre et des voilages : une lumière douce, sans flash qui réveille bébé.'],
    ['thermometre', 'Chauffé à 24 °C', 'La bonne température pour un nouveau-né en lange, toute l’année.'],
    ['maison', 'Coin change', 'Table à langer, couches et lingettes, à deux pas du pouf.'],
    ['fauteuil', 'Fauteuil pour allaiter', 'Un fauteuil profond pour nourrir bébé au calme, entre deux photos.'],
    ['cintre', 'Tenues et langes prêtés', 'Bonnets, langes et robes de grossesse lavés après chaque séance.'],
    ['parking', 'Parking devant la porte', 'De plain-pied, accessible avec une poussette ou un cosy.'],
  ] }),
  Section('br-tarifs-liste-section', [
    tetes('Les séances qu’on fait au studio', 'Les mariages et les grandes familles se photographient dehors. Tout le reste peut se faire ici, au même prix que chez vous.'),
    Box('br-tarifs-liste', [
      ['naissance-lange', 'Nouveau-né endormi', 'Naissance', S.naissance, 'Entre 5 et 15 jours, 2 h à 2 h 30.', 'dès 290 €'],
      ['grossesse-studio', 'Femme enceinte au studio', 'Grossesse', S.grossesse, 'Entre 7 et 8 mois, 1 h.', '190 €'],
      ['famille-coquelicots', 'Famille', 'Famille', S.famille, 'Jusqu’à 5 personnes au studio, 1 h 30.', '220 €'],
      ['couple-plage', 'Couple', 'Couple', S.couple, 'Fiançailles ou envie de photos à deux, 1 h.', '180 €'],
    ].map(tarifLigne)),
  ]),
  Section('br-venir', [Cols([
    Col([H('Venir au studio', 2),
      P(`Le studio est à Olivet, au sud d’Orléans. Vous vous garez devant la porte et vous entrez de plain-pied : pas d’escalier avec le cosy. C’est moi qui vous ouvre : ${A('qui je suis', 'a-propos')}. L’adresse exacte vous est envoyée avec la confirmation de votre séance.`),
      P(`Vous préférez que je vienne ? La ${A('séance naissance à domicile', S.naissance)} est au même prix, à 40 km autour d’Olivet.`)], { width: '50%', verticalAlignment: 'center' }),
    Col([cb('core/table', { className: 'br-table', hasFixedLayout: false,
      head: [{ cells: [{ content: 'Depuis', tag: 'th' }, { content: 'En voiture', tag: 'th' }] }],
      body: [['Orléans La Source', '7 min'], ['Saint-Jean-le-Blanc', '8 min'], ['Centre d’Orléans', '10 min'], ['Saint-Jean-de-la-Ruelle', '15 min']].map((r) => ({ cells: r.map((x) => ({ content: fr(x), tag: 'td' })) })) }),
      Muted('Hors heures de pointe (fictif).')], { width: '50%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })], { backgroundColor: 'surface' }),
  avisNote('Ce qu’en disent les familles', [AV.claire, AV.amandine, AV.elsa]),
  faq('Vos questions sur le studio', [
    ['Peut-on visiter le studio avant de réserver ?', 'Oui. Je propose une visite de 15 minutes le mercredi en fin de journée, sur rendez-vous (fictif).'],
    ['Les frères et sœurs peuvent-ils venir ?', 'Oui, ils sont inclus dans la séance naissance. Il y a un coin avec des livres pour les faire patienter.'],
    ['Faut-il apporter des tenues ?', 'Non pour bébé : langes, bonnets et tenues sont prêtés. Pour vous, des vêtements simples aux couleurs douces.'],
    ['Où se trouve le studio ?', 'À Olivet, au sud d’Orléans, à 10 minutes du centre-ville en voiture. L’adresse exacte est envoyée avec la confirmation de la séance.'],
  ], 'surface'),
  fin('Venez voir le studio, ou réservez directement', 'Visite de 15 minutes le mercredi sur rendez-vous. Je vous réponds sous 24 h (fictif).', 'naissance-lange'),
], { menu: true });

/* ================= Portfolio ================= */
page('portfolio', 'Portfolio', 'Portfolio : naissances, familles et mariages à Orléans',
  'Les photos de Lison Vautrin, photographe près d’Orléans : naissances au studio, grossesses, familles en bord de Loire et mariages dans le Loiret.', [
  teteTexte('Portfolio : naissances, familles et mariages à Orléans', 'Des séances récentes, publiées avec l’accord écrit des personnes photographiées, et des deux parents pour un enfant. Cliquez sur une photo pour l’agrandir.'),
  galerie('Quelques photos', 'Une photo par moment fort de chaque séance. Les histoires plus bas montrent les séances entières.', null, [
    ['naissance-lange', 'Nouveau-né endormi dans un lange bleu, au studio'], ['mariage-voile', 'Mariés sous le voile au coucher du soleil'],
    ['grossesse-studio', 'Silhouette d’une femme enceinte au studio'], ['famille-coquelicots', 'Famille de cinq dans un champ de fleurs'],
    ['couple-plage', 'Couple qui rit au bord de la Loire'], ['mariage-petales', 'Sortie de mairie sous les pétales'],
    ['naissance-mains', 'Nouveau-né dans les mains de ses parents'], ['grossesse-champ', 'Future maman dans un champ au coucher du soleil'],
  ]),
  Section('br-section-realisations', [
    tetes('Une séance racontée du début à la fin', 'Chaque histoire montre une séance entière, pas seulement les meilleures photos : vous voyez ce que vous recevrez vraiment.'),
    Short('[briise_realisations filtres="1"]'),
  ], { backgroundColor: 'surface' }),
  fin('Envie de photos comme celles-ci ?', 'Choisissez la séance, le lieu et la date : je vous réponds sous 24 h (fictif).', 'mariage-petales'),
], { menu: true });

/* ================= Tarifs ================= */
page('tarifs', 'Tarifs', 'Tarifs photographe à Orléans, prix affichés | Lison Vautrin',
  'Les tarifs de Lison Vautrin, photographe près d’Orléans : naissance dès 290 €, grossesse 190 €, famille 220 €, couple 180 €, mariage dès 1 690 €.', [
  teteTexte('Tarifs photographe à Orléans, sans surprise', `Tous les prix sont affichés et comprennent la retouche, la galerie en ligne et le déplacement à 40 km autour d’Olivet. Le déroulé de chaque séance est sur la page ${A('séances photo à Orléans', 'seances')}. Les prix de ce site sont fictifs.`, [Btn(CTA_LABEL, CTA)]),
  Section('br-tarifs-liste-section', [Box('br-tarifs-liste', [
    ['naissance-lange', 'Nouveau-né endormi', 'Naissance', S.naissance, '5 à 15 jours, 2 h à 2 h 30, 25 photos. Studio ou chez vous.', 'dès 290 €'],
    ['grossesse-studio', 'Femme enceinte au studio', 'Grossesse', S.grossesse, '7 à 8 mois, 1 h, 15 photos. Studio ou bord de Loire.', '190 €'],
    ['famille-coquelicots', 'Famille', 'Famille', S.famille, '1 h 30, jusqu’à 8 personnes, 20 photos. Dehors, chez vous ou studio.', '220 €'],
    ['couple-plage', 'Couple', 'Couple', S.couple, '1 h, 15 photos. Dehors ou studio.', '180 €'],
    ['mariage-voile', 'Mariés', 'Mariage', S.mariage, '8 h ou 11 h, 400 à 550 photos. Loiret et Loir-et-Cher.', 'dès 1 690 €'],
  ].map(tarifLigne))]),
  Section('br-temps-section', [Cols([
    Col([H('Pourquoi ce prix ?', 2), Lead('Une séance naissance à 290 €, c’est environ 9 heures de travail. La séance n’en est qu’une petite partie : chaque photo livrée est triée et retouchée à la main (fictif).'),
      Arrow('Combien coûte un photographe naissance, ailleurs ?', URL('prix-photographe-naissance'))], { width: '42%', verticalAlignment: 'center' }),
    Col([cb('core/table', { className: 'br-table br-temps', hasFixedLayout: false,
      head: [{ cells: [{ content: 'Étape', tag: 'th' }, { content: 'Temps', tag: 'th' }] }],
      body: [['Préparation et appel', '30 min'], ['La séance', '2 h 30'], ['Tri des photos', '1 h'], ['Retouche, une par une', '4 h'], ['Galerie et livraison', '1 h']].map((r) => ({ cells: r.map((c) => ({ content: fr(c), tag: 'td' })) })),
      foot: [{ cells: [{ content: 'Au total', tag: 'td' }, { content: fr('environ 9 h'), tag: 'td' }] }] })], { width: '58%' }),
  ], 'br-split')], { backgroundColor: 'surface' }),
  Section('br-compris-section', [Cols([
    Col([H('Compris dans chaque séance', 2), List(['La retouche de chaque photo livrée', 'Une galerie en ligne privée, gardée un an', 'Le téléchargement en haute définition', 'Le déplacement à 40 km autour d’Olivet', 'Les aînés et le conjoint sur les photos', 'Mes conseils de tenue avant la séance'], 'br-liste-oui br-liste-simple')], { width: '50%' }),
    Col([H('Formules et options', 2), cb('core/table', { className: 'br-table br-options', hasFixedLayout: false,
      body: [['Grossesse et naissance', '440 €'], ['Fiançailles, si vous réservez le mariage', '150 €'], ['Album 30 × 30 cm', 'dès 390 €'], ['Photo retouchée supplémentaire', '12 €'], ['Tirage 20 × 30 cm', '25 € pièce'], ['Carte cadeau', 'du montant choisi']].map((r) => ({ cells: r.map((x) => ({ content: fr(x), tag: 'td' })) })) }),
      P(`Le détail des deux formules est sur la page ${A('photographe de mariage', S.mariage)}.`, 'br-muted')], { width: '50%' }),
  ], 'br-split')]),
  Section('br-cadeau', [Cols([
    Col([cb('core/cover', { url: IMG('couple-plage'), alt: '', dimRatio: 50, overlayColor: 'sombre', isUserOverlayColor: true, className: 'br-cadeau-carte', contentPosition: 'bottom left', focalPoint: { x: 0.5, y: 0.3 }, layout: { type: 'constrained' } }, [
      P('Lison Vautrin, carte cadeau valable un an', 'br-cadeau-texte'), P('180 €', 'br-cadeau-montant'),
    ])], { width: '45%', verticalAlignment: 'center' }),
    Col([H('Offrir une séance', 2), Lead('Pour une naissance, un anniversaire de mariage ou Noël : une carte cadeau du montant de votre choix, envoyée par e-mail ou par courrier, valable un an (fictif).'), Btns(Btn('Offrir une carte cadeau', CTA))], { width: '55%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })], { backgroundColor: 'surface' }),
  faq('Vos questions sur les prix', [
    ['Faut-il verser un acompte ?', 'Oui, 30 % à la réservation. Le reste se règle le jour de la séance, ou en trois fois pour un mariage (fictif).'],
    ['Puis-je acheter des photos en plus ?', 'Oui, 12 € la photo retouchée supplémentaire, choisie dans la galerie.'],
    ['Les prix changent-ils le week-end ?', 'Non, le prix est le même tous les jours de la semaine.'],
    ['Le prix change-t-il au studio ou à domicile ?', `Non. Le prix est le même au ${A('studio d’Olivet', S.studio)}, chez vous ou dehors, à 40 km autour d’Olivet.`],
  ]),
  fin('Une séance vous tente ?', 'Dites-moi le type de séance et la date : je vous réponds sous 24 h (fictif).', 'famille-coquelicots'),
], { menu: true });

/* ================= À propos ================= */
page('a-propos', 'À propos', 'Lison Vautrin, photographe à Olivet depuis 2018',
  'Lison Vautrin : six ans d’assistante en mariage à Tours, photographe à Olivet depuis 2018, formée aux nouveau-nés. Ses engagements, écrits au contrat.', [
  teteSeance({ h1: 'Lison Vautrin, photographe à Olivet depuis 2018', lead: 'Je photographie les débuts : les premiers jours d’un bébé, les derniers mois d’une grossesse, le premier jour d’un mariage. Ce qui compte pour moi, c’est que vous vous reconnaissiez sur chaque photo, dans vingt ans encore (fictif).',
    btns: [Btn(CTA_LABEL, CTA), Btn('Voir le portfolio', URL('portfolio'), 'is-style-outline')],
    img: 'lison-portrait', alt: 'Lison Vautrin, appareil photo à la main, dans un champ au coucher du soleil', dispo: false }),

  faitsIcones({ titre: 'Ce à quoi je m’engage', chapo: 'Quatre engagements écrits dans mon contrat, pour chaque séance.', img: 'naissance-mains', alt: 'Nouveau-né dans les mains de ses parents', bg: 'fond', items: [
    ['appareil', 'Une seule photographe', 'C’est moi qui réponds, qui photographie et qui retouche chaque image.'],
    ['bouclier', 'Aucune pose à risque', 'Une main toujours près de bébé, et aucun montage acrobatique.'],
    ['coeur', 'Votre accord avant tout', 'Aucune photo publiée sans votre accord écrit, et jamais le prénom d’un enfant.'],
    ['euro', 'Des prix affichés', `Ce que vous voyez sur la page ${A('tarifs', 'tarifs')} est ce que vous payez.`],
  ] }),
  Section('br-etapes', [Head([H('Mon parcours', 2)]), Box('br-fil br-fil--frise', [
    ['Assistante à Tours', 'Six ans aux côtés d’un photographe de mariage : la discrétion, les imprévus, la lumière.', '2012'],
    ['Installée à Olivet', 'Premières séances naissance chez les parents, puis familles et couples.', '2018'],
    ['Formée aux nouveau-nés', 'Une formation à la manipulation et à la sécurité des bébés.', '2023'],
    ['Le studio ouvre', `Une pièce de ma maison devient ${A('un studio en lumière du jour', S.studio)}.`, '2024'],
  ].map(([t, d, an], i) => Box('br-fil-etape', [P(String(i + 1), 'br-fil-num'), H(t, 3), P(d, 'br-fil-texte'), P(an, 'br-duree')])))], { backgroundColor: 'surface' }),
  Section('br-citation', [
    P('« On avait peur que notre fille pleure tout le long. Au studio il faisait bon, Lison a attendu chaque tétée, et on a pleuré nous aussi en recevant la galerie. »', 'br-statement br-center br-narrow'),
    P('Claire et Antoine, séance naissance au studio, octobre 2026 (avis fictif)', 'br-muted br-center'),
  ], { backgroundColor: 'surface' }),
  fin('On se rencontre ?', 'Un appel de 15 minutes, sans engagement, pour faire connaissance et parler de votre projet (fictif).', 'lison-portrait'),
], { menu: true });

/* ================= Réserver ================= */
page('reserver', 'Réserver', 'Réserver une séance photo à Orléans | Lison Vautrin',
  'Réservez votre séance photo près d’Orléans : la séance, le lieu et la date. Réponse sous 24 h avec mes disponibilités, rien n’est payé à cette étape.', [
  Section('br-reservation', [Cols([
    Col([Short('[briise_fil_ariane]'), H('Réserver une séance photo', 1, null, { fontSize: 'xx-large' }), Lead('Trois questions et vos coordonnées : je vous réponds sous 24 h avec mes disponibilités. Rien n’est payé à cette étape.'),
      Box('br-card br-formulaire', [Short('[briise_formulaire type="reservation"]')])], { width: '60%' }),
    Col([Box('br-reservation-cote', [
      Box('br-lieu-media', [Img('studio-jour', '4/3', 'is-style-br-arrondi', 'Le studio photo d’Olivet, baigné de lumière'), Short('[briise_disponibilite]')]),
      H('Et ensuite ?', 2, 'br-h3'),
      cb('core/list', { ordered: true, className: 'br-ensuite' }, [
        '<strong>Sous 24 h</strong> Je vous réponds avec mes disponibilités pour votre date.',
        '<strong>Ensuite</strong> Un appel de 15 minutes pour préparer la séance ensemble.',
        '<strong>Pour confirmer</strong> L’acompte de 30 % bloque votre date (fictif).',
      ].map((c) => cb('core/list-item', { content: fr(c) }))),
      Short('[briise_appel intro="Vous préférez parler ?"]'),
    ])], { width: '40%' }),
  ], 'br-split')]),
], { template: 'page-sans-titre' });

/* ================= Conseils (deux guides, hors menu) ================= */
page('prix-photographe-naissance', 'Combien coûte un photographe naissance ?', 'Combien coûte un photographe naissance ? Ce qui est inclus',
  'Ce qui fait varier le prix d’une séance photo naissance et ce qu’il doit comprendre : photos, retouche, lieu, déplacement. Avec un exemple chiffré.', [
  teteTexte('Combien coûte un photographe naissance ?', 'Les tarifs varient beaucoup d’un photographe à l’autre. Plutôt qu’un prix moyen, voici ce qui le fait varier et ce qu’il faut vérifier avant de comparer deux devis.'),
  Section('br-article', [Box('br-article-texte', [
    H('Ce qui fait varier le prix', 2),
    P('Quatre choses expliquent presque tous les écarts : le nombre de photos retouchées comprises, la durée de la séance, le lieu (studio ou domicile) et ce qui est livré (galerie en ligne, fichiers en haute définition, album).'),
    H('Ce que le prix doit comprendre', 2),
    List(['Le nombre exact de photos retouchées : 5, 15 ou 25, ce n’est pas la même séance', 'La durée : une séance naissance au rythme de bébé dure souvent 2 h ou plus', 'Les frères et sœurs et les parents sur les photos', 'Le déplacement, et jusqu’à quelle distance', 'Le délai de livraison et la durée de conservation de la galerie'], 'br-liste-oui br-liste-simple'),
    H('Un exemple chiffré', 2),
    P(`Chez Lison Vautrin, à Olivet près d’Orléans, la ${A('séance photo naissance', S.naissance)} coûte 290 €. Elle dure 2 h à 2 h 30, comprend 25 photos retouchées, les parents et les aînés, la galerie en ligne gardée un an et le déplacement à 40 km. Elle représente environ 9 heures de travail, retouche comprise (prix fictifs).`),
    H('Les questions à poser avant de réserver', 2),
    P('Combien de photos retouchées sont comprises, et combien coûte une photo en plus ? Le photographe est-il formé à la sécurité des nouveau-nés ? Que se passe-t-il si bébé arrive en avance ? Une réponse claire à ces trois questions vaut mieux qu’un prix bas.'),
    Muted('Rédigé par Lison Vautrin, photographe naissance à Olivet (contenu fictif).'),
  ])]),
  fin('Une séance naissance près d’Orléans ?', 'Dites-moi la date du terme : je la garde de côté (fictif).', 'naissance-lange'),
], { menu: false });

page('preparer-seance-photo', 'Préparer sa séance photo', 'Que porter pour une séance photo ? Conseils pour se préparer',
  'Tenues, couleurs, horaires et bébé : comment préparer une séance photo naissance, grossesse, famille ou couple, en une page, avec ce qu’il faut apporter.', [
  teteTexte('Préparer sa séance photo : que porter, quoi apporter', 'Une page à lire quelques jours avant, quelle que soit votre séance. Vous la recevez aussi par e-mail une semaine avant.'),
  Section('br-article', [Box('br-article-texte', [
    H('Que porter ?', 2),
    P('Des couleurs douces et unies, qui s’accordent entre vous sans être identiques : crème, beige, vieux rose, bleu gris. Évitez les grands logos et les motifs très serrés, qui attirent l’œil à la place des visages.'),
    H('Pour une séance naissance', 2),
    P(`Pour bébé, je prête tout : langes, bonnets, tenues. Le jour J, une tétée en arrivant l’aide à dormir pendant les photos. Au ${A('studio d’Olivet', S.studio)}, la pièce est chauffée à 24 °C ; chez vous, je viens avec un chauffage d’appoint. Tous les détails sont sur la page ${A('séance naissance', S.naissance)}.`),
    H('Pour une séance grossesse', 2),
    P(`Une tenue près du corps pour dessiner le ventre. Au studio, je prête des robes et des voilages. Dehors, prévoyez des chaussures plates pour marcher jusqu’au lieu. Voir la ${A('séance grossesse', S.grossesse)}.`),
    H('Pour une séance famille ou couple', 2),
    P(`Des chaussures pour marcher dans l’herbe ou le sable, un goûter pour les enfants, et une heure choisie selon les siestes. Je vous propose des jeux : personne n’a à poser. Voir la ${A('séance famille', S.famille)} et la ${A('séance couple', S.couple)}.`),
    H('À apporter', 2),
    List(['Pour bébé : un change de couches et sa tétine s’il en a une', 'Une tenue de rechange pour les enfants', 'De l’eau, surtout dehors en été', 'Pour un mariage : la liste des photos de groupe, préparée ensemble trois mois avant'], 'br-liste-oui br-liste-simple'),
    Muted('Rédigé par Lison Vautrin, photographe à Olivet (contenu fictif).'),
  ])]),
  fin('Prête pour votre séance ?', 'Une question avant le jour J ? Je vous réponds au téléphone ou par e-mail.', 'famille-coquelicots'),
], { menu: false });

/* ================= Histoires du portfolio (fiches de réalisation) ================= */
const histoire = (titre, date, service, cat, ville, resume, blocs, image) => ({ titre, date, service, categories: [cat], ville, resume, image, markup: serialize(blocs) });
const realisations = [
  histoire('Une naissance au studio, avec la grande sœur', '2026-10', S.naissance, 'Naissance', 'Olivet', 'Neuf jours, une grande sœur de trois ans et deux heures et demie au chaud, au rythme des tétées.', [
    H('La séance', 2),
    P('Claire et Antoine sont venus au studio quand leur fille avait neuf jours, avec sa grande sœur de trois ans. Ils avaient choisi le studio pour ne rien préparer chez eux, en pleine fatigue des premiers jours (séance fictive).'),
    P('La séance a duré deux heures et demie. Nous avons commencé par une tétée dans le fauteuil, puis bébé s’est endormie dans son lange sur le pouf. La grande sœur a fait ses photos au début, quand elle était encore patiente, puis elle a lu dans le coin des livres.'),
    H('Ce qu’ils ont reçu', 2),
    P(`Vingt-cinq photos retouchées, livrées en deux semaines et demie dans une galerie en ligne : bébé seule, avec ses parents, avec sa sœur, et quelques détails, les mains, les pieds, le bonnet. Les parents ont commandé un album de 30 × 30 cm. Tout est expliqué sur la page ${A('photographe naissance à Orléans', S.naissance)}.`),
    H('Le conseil de Lison', 2),
    P('Venez avec un change de couches et rien d’autre : le studio est chauffé, les langes et les bonnets sont prêtés. Si les aînés sont petits, prévoyez de les photographier au début, puis qu’une personne les emmène se promener.'),
    Muted('Photos publiées avec l’accord écrit des deux parents. Aucun prénom d’enfant.'),
  ], 'naissance-lange'),
  histoire('Inès et Thomas, un mariage au Moulin du Loiret', '2026-09', S.mariage, 'Mariage', 'Olivet', 'Une journée de septembre, de la mairie d’Olivet à la première danse, en formule journée et soirée.', [
    H('La journée', 2),
    P('Inès et Thomas se sont mariés un samedi de septembre à la mairie d’Olivet, puis au Moulin du Loiret pour la réception. Ils avaient choisi la formule journée et soirée : onze heures de présence, des préparatifs à la première danse (mariage fictif).'),
    P('Trois mois avant, nous avions préparé le planning avec leurs témoins : l’heure de la découverte, la liste des photos de groupe, et vingt minutes réservées au coucher du soleil, dans le champ de blé derrière le moulin.'),
    H('Ce qu’ils ont reçu', 2),
    P(`Environ 550 photos retouchées en cinq semaines : la sortie de la mairie sous les pétales, les photos de groupe faites en vingt minutes, les portraits dans les blés, les discours et la soirée. Les deux formules sont détaillées sur la page ${A('photographe de mariage à Orléans', S.mariage)}.`),
    H('Le conseil de Lison', 2),
    P('Préparez la liste des photos de groupe avec vos témoins, dix groupes au plus, et confiez-la à une personne qui connaît les deux familles : elle les appelle pendant que je photographie. Vingt minutes suffisent alors, et vos invités profitent du cocktail.'),
    Muted('Photos publiées avec l’accord écrit des mariés.'),
  ], 'mariage-petales'),
  histoire('Une famille de cinq en bord de Loire', '2026-06', S.famille, 'Famille', 'Saint-Jean-le-Blanc', 'Trois enfants, un champ de fleurs au bord de la Loire et une heure et demie de jeux à l’heure dorée.', [
    H('La séance', 2),
    P('Sophie voulait une photo de famille avec ses trois enfants, sans les faire tenir en place. Nous nous sommes retrouvés un soir de juin au bord de la Loire, à Saint-Jean-le-Blanc, une heure et demie avant le coucher du soleil (séance fictive).'),
    P('Les enfants ont couru, cueilli des fleurs, porté leur petit frère. La photo de groupe, tout le monde assis dans les fleurs, a pris cinq minutes à la fin, quand ils étaient fatigués et contents.'),
    H('Ce qu’ils ont reçu', 2),
    P(`Vingt photos retouchées en trois semaines, dont la photo de groupe que Sophie a fait tirer en grand format pour son salon. La séance est décrite sur la page ${A('photographe famille à Orléans', S.famille)}.`),
    H('Le conseil de Lison', 2),
    P('Choisissez des couleurs qui vont ensemble sans être identiques, et prévoyez un goûter pour les enfants. Fixez l’heure selon les siestes plutôt que selon la lumière : un enfant reposé se laisse photographier bien plus longtemps.'),
    Muted('Photos publiées avec l’accord écrit des deux parents. Aucun prénom d’enfant.'),
  ], 'famille-coquelicots'),
  histoire('Une séance grossesse au coucher du soleil', '2026-07', S.grossesse, 'Grossesse', 'Saint-Denis-en-Val', 'Une heure en bord de Loire à sept mois et demi, avec des pauses pour s’asseoir.', [
    H('La séance', 2),
    P('Pauline était enceinte de sept mois et demi. Elle voulait des photos dehors, dans la lumière du soir, sans marcher longtemps. Nous avons choisi un champ plat au bord de la Loire, à Saint-Denis-en-Val, accessible en voiture (séance fictive).'),
    P('La séance a duré une heure, avec deux pauses assises. La robe bordeaux venait de sa garde-robe ; elle avait aussi apporté une robe claire, prêtée par le studio, pour une deuxième série.'),
    H('Ce qu’elle a reçu', 2),
    P(`Quinze photos retouchées en deux semaines. Pauline a ensuite réservé la séance naissance : les deux ensemble font 440 €. Voir la ${A('séance photo grossesse', S.grossesse)}.`),
    H('Le conseil de Lison', 2),
    P('Réservez vers six mois de grossesse pour une séance entre sept et huit mois. Dehors, prévoyez des chaussures plates et de l’eau ; au studio, je prête des robes et un fauteuil vous attend entre deux séries de photos.'),
    Muted('Photos publiées avec l’accord écrit de la personne photographiée.'),
  ], 'grossesse-champ'),
  histoire('Manon et Alex, une heure à deux en bord de Loire', '2026-08', S.couple, 'Couple', 'Orléans', 'Un couple qui « déteste les photos », une plage de Loire et une heure de balade au coucher du soleil.', [
    H('La séance', 2),
    P('Manon et Alex n’aimaient pas être photographiés et voulaient pourtant des photos d’eux avant leurs fiançailles. Nous nous sommes retrouvés sur une plage de sable de la Loire, à Orléans, une heure avant le coucher du soleil (séance fictive).'),
    P('Je ne leur ai demandé aucune pose. Ils ont marché, parlé, se sont chamaillés pour savoir qui avait choisi le lieu ; je photographiais pendant ce temps. Au bout de dix minutes, ils avaient oublié l’appareil.'),
    H('Ce qu’ils ont reçu', 2),
    P(`Quinze photos retouchées en deux semaines, dans une galerie en ligne. Ils ont ensuite réservé leur mariage, et la séance est passée au tarif fiançailles. Voir la ${A('séance photo couple', S.couple)}.`),
    H('Le conseil de Lison', 2),
    P('Si vous n’aimez pas être photographiés, ne cherchez pas à poser : marchez, parlez, racontez-vous une histoire. Je vous guide d’un mot quand il faut, et les meilleures photos arrivent souvent au moment où vous m’oubliez.'),
    Muted('Photos publiées avec l’accord écrit des personnes photographiées.'),
  ], 'couple-plage'),
];

const site = {
  entreprise: {
    name: 'Lison Vautrin', slogan: 'Photographe à Olivet, près d’Orléans',
    type: 'LocalBusiness',
    description: 'Photographe naissance, grossesse, famille, couple et mariage à Olivet, près d’Orléans. Au studio, chez vous ou dehors, à 40 km sans frais (entreprise fictive).',
    email: 'contact@briise.fr', telephone: '06 00 00 00 00',
    street: 'Studio sur rendez-vous (adresse fictive)', postal_code: '45160', city: 'Olivet', country: 'FR',
    areas: ['Olivet', 'Orléans', 'Saint-Jean-le-Blanc', 'Saint-Jean-de-Braye', 'Saint-Denis-en-Val', 'Saint-Hilaire-Saint-Mesmin', 'La Ferté-Saint-Aubin', 'Meung-sur-Loire'],
    instagram: '', google: GOOGLE,
    person_name: 'Lison Vautrin', person_job: 'Photographe',
    precision_telephone: 'Lison décroche elle-même, du lundi au samedi', precision_email: 'Réponse sous 24 h (fictif)', precision_adresse: 'Adresse donnée à la réservation',
    zone_rayon: '40',
  },
  legal: {
    raison_sociale: 'Lison Vautrin, entrepreneur individuel (fictif)', forme: 'Entreprise individuelle', siren: '000 000 000 (fictif)',
    siege: 'Olivet, 45160 (adresse fictive)', directeur: 'Lison Vautrin', hebergeur_nom: 'Hébergeur à définir (fictif)', realisation: 'Briise',
  },
  annonces: {
    jours: Object.fromEntries([1, 2, 3, 4, 5, 6, 7].map((n) => [n, n <= 6 ? { ouvert: true, plages: [['09:00', '19:00'], ['', '']] } : { ouvert: false, plages: [['', ''], ['', '']] }])),
    note: 'Séances sur rendez-vous, aussi le dimanche pour les mariages.',
    dispo_texte: 'Prochaine séance libre',
  },
  fonctions: { realisations: true, realisations_nom: 'Portfolio' },
  // Couleurs et polices de Lison (rose poudré, framboise en accent) : contraste AA vérifié par contraste.py.
  couleurs: { fond: '#fffcfa', clair: '#ffffff', surface: '#f6e3e6', nuance: '#eee8e3', texte: '#1d1720', 'texte-doux': '#5a5059', accent: '#b0285f', secondaire: '#5c1f3d', deco: '#f4b6c8', sombre: '#1d1720' },
  polices: { titres: 'Bricolage Grotesque', texte: 'Geist' },
  // Le reste de l'apparence de Lison, telle qu'elle a été présentée (ancienne ambiance Galerie) :
  // arrondis, forme des décors, titres serrés, boutons framboise qui passent au prune au survol.
  styles: {
    settings: { custom: { rayon: { grand: '32px', moyen: '24px', petit: '12px', bouton: '999px', photo: '28px' }, forme: { blob: '28px' } } },
    styles: { elements: {
      heading: { typography: { fontWeight: '600', lineHeight: '0.98', letterSpacing: '-0.035em' } },
      button: { color: { background: 'var:preset|color|accent', text: 'var:preset|color|clair' }, ':hover': { color: { background: 'var:preset|color|secondaire', text: 'var:preset|color|clair' } } },
    } },
  },
  cta: 'reserver', cta_label: 'Réserver une séance', accueil: 'accueil', personne: 'a-propos', blog: '',
  liens: { services: 'seances' },
  reservation_lieux: ['Au studio, à Olivet', 'Chez vous', 'Dehors (bord de Loire, forêt, parc)'],
  statut: 'publish',
  realisations,
  pages,
};
if (TROP.length) { console.error('Trop long :', TROP); process.exit(1); }
require('fs').writeFileSync(require('path').join(__dirname, 'site-lison.json'), JSON.stringify(site, null, 1));
const o = {}; pages.forEach((p) => { o[p.slug] = p.markup; }); realisations.forEach((r, i) => { o['histoire-' + i] = r.markup; });
require('fs').mkdirSync(require('path').join(__dirname, '..', 'build'), { recursive: true });
require('fs').writeFileSync(require('path').join(__dirname, '..', 'build', 'lison_blocs.json'), JSON.stringify({ sections: o, home: '' }));
console.log(pages.length, 'pages ;', pages.map((p) => p.slug).join(', '));
