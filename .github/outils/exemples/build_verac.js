// Fichier de site : Vérac Plomberie Chauffage (client fictif, test du thème sur un plombier chauffagiste).
// Parcours « urgence » et « projet ». Nom, téléphone, prix, avis et qualifications sont inventés et le site le dit.
const B = require('../build_br_sections.js');
const { cb, serialize, P, H, Label, Lead, Muted, Section, Box, Head, Short, List, fr, CTA, CTA_LABEL, URL, Img, Btn, Btns, Cols, Col, Arrow, Table, Num, Row,
  ImgFond, teteSplit, benefices, modeles, etapesFrise, etapesFil, prixCarte, compris, confiance, zoneListe, qualifs, situations, tarifLigne, avisCourt, ETOILES } = B;
const { cloneBlock } = require('@wordpress/blocks');

const IMG = (n) => `{{IMG:${n}}}`;
const A = (t, slug) => `<a href="${URL(slug)}">${t}</a>`;
const Details = (q, a) => cb('core/details', { summary: fr(q) }, [P(a)]);
const sectionHead = (title, link) => Row('br-section-head', [H(title, 2), ...(link ? [Arrow(link[0], link[1])] : [])]);

/* Photos libres de droits (Unsplash, Pexels), réservées à ce site d'exemple. Fichiers verac-*.jpg dans la Médiathèque. */
const V = (n) => 'verac-' + n;
const PLOMBIER = V('plombier'), FUITE = V('fuite'), ROBINET = V('robinet'), CHAUFFE = V('chauffe-eau'), CHAUDIERE = V('chaudiere'), PAC = V('pompe-a-chaleur');
const SDB = V('salle-de-bains'), DOUCHE = V('douche'), RADIATEUR = V('radiateur'), OUTILS = V('outils'), CAMION = V('camionnette'), THOMAS = V('thomas');

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
// Ouverture « Deux portes » (fonction du thème).
const deuxPortes = () => B.deuxPortes({
  titre: 'Plombier chauffagiste à Saint-Jean-de-Braye, en urgence ou sur rendez-vous',
  chapo: 'Prix annoncé avant de commencer, devis signé avant les travaux, intervention en moins de 2 h dans la métropole d’Orléans (exemple fictif).',
  statut: 'Dépannage 7 j/7, de 7 h à 22 h', appel: 'Appeler Thomas',
  liens: [['Une fuite d’eau', URL('depannage-plomberie')], ['WC ou évier bouché', URL('depannage-plomberie')], ['Plus d’eau chaude', URL('chauffe-eau')], ['Chaudière en panne', URL('chaudiere-gaz')]],
  attente: `En attendant : coupez l’eau au compteur et l’électricité du chauffe-eau. ${A('Les bons gestes', 'depannage-plomberie')}`,
  img: PLOMBIER, projetTexte: 'Chauffe-eau, chaudière, pompe à chaleur ou salle de bains : visite et devis gratuits.',
});
const CONF = [['prix', 'Prix annoncé avant', 'Rien ne commence sans votre accord'], ['delai', 'Moins de 2 h', 'Pour un dépannage dans la zone'],
  ['garantie', 'Garantie décennale', 'Attestation jointe au devis'], ['local', 'À Saint-Jean-de-Braye', 'Depuis 2014 (exemple fictif)']];
const bandeau = (titre, texte) => Section('br-cta', [Box('br-cta-inner', [
  H(titre, 2), Lead(texte), Btns(Btn(CTA_LABEL, CTA, null, { backgroundColor: 'fond', textColor: 'texte' })),
])], { backgroundColor: 'secondaire', textColor: 'fond' });
const faq = (titre, qs, bg) => Section('', [Cols([
  Col([Label('Questions fréquentes'), H(titre, 2), Muted('Une autre question ? Thomas vous répond au téléphone.'), Arrow('Poser votre question', CTA)], { width: '38%' }),
  Col(qs.map(([q, a]) => Details(q, a)), { width: '62%' }),
], 'br-split')], bg ? { backgroundColor: bg } : {});
const liees = () => Section('br-section-liees', [sectionHead('Nos autres services', ['Tous nos services', URL('services')]), Short('[briise_pages_liees]')], { backgroundColor: 'surface' });
const preuve = (titre) => Section('br-section-realisations', [
  sectionHead(titre, ['Toutes nos réalisations', URL('realisations')]),
  Short('[briise_realisations service="auto" nombre="3"]'),
  Box('br-qui', [Img(THOMAS, '1/1', 'br-qui-photo', 'Thomas Vérac, plombier chauffagiste, devant sa camionnette'), P(`Thomas Vérac intervient lui-même, à Saint-Jean-de-Braye et autour, depuis 2014 (exemple fictif). ${A('Qui nous sommes', 'a-propos')}.`)]),
]);
const teteSimple = (h1, chapo) => Section('br-page-head', [Head([Short('[briise_fil_ariane]'), H(h1, 1, null, { fontSize: 'huge' }), Lead(chapo), Btns(Btn(CTA_LABEL, CTA))])]);
const carteService = (img, alt, titre, texte, slug) => Col([Box('br-card', [ImgFond(img, 'br-card-fond', alt), H(titre, 3), Muted(texte), Arrow(titre + ' en détail', URL(slug))])]);
const AVIS = Section('br-avis-note', [
  Row('br-section-head br-tete-deux', [H('Ce qu’en disent nos clients', 2), P(`<strong class="br-note-chiffre">4,8</strong> <span class="br-note-detail">${ETOILES}<span>sur 5, avis d’exemple</span></span>`, 'br-note')]),
  Cols([
    avisCourt('Fuite sous l’évier un dimanche soir : Thomas était là en une heure, le prix annoncé au téléphone était le bon.', 'Nadia B.', 'Dépannage, Chécy (avis fictif)'),
    avisCourt('Chauffe-eau changé le lendemain de l’appel, l’ancien emporté, tout laissé propre.', 'Marc L.', 'Chauffe-eau, Saint-Jean-de-Braye (avis fictif)'),
    avisCourt('Il nous a expliqué les aides pour la pompe à chaleur et monté le dossier avec nous.', 'Céline et Paul R.', 'Pompe à chaleur, Semoy (avis fictif)'),
  ], 'br-avis-grille'),
], { backgroundColor: 'surface' });

/* ---------- Pages ---------- */
const pages = [];
const page = (slug, titre, seo_titre, seo_description, blocs, extra = {}) =>
  pages.push({ slug, titre, seo_titre, seo_description, markup: serialize(rythme(blocs)), ...extra });

// Accueil : deux portes, confiance, situations, services, forfaits, déroulé, preuves, zone, action.
page('accueil', 'Accueil', 'Plombier chauffagiste à Saint-Jean-de-Braye, dépannage 7 j/7',
  'Fuite, panne de chauffe-eau ou de chaudière, pompe à chaleur, salle de bains : Vérac Plomberie Chauffage intervient dans la métropole d’Orléans (exemple fictif).', [
  deuxPortes(),
  confiance(CONF),
  situations({ label: 'Par où commencer', titre: 'Où en êtes-vous ?', chapo: 'Choisissez la phrase qui vous ressemble : vous voyez tout de suite ce que nous faisons et ce que ça coûte.', items: [
    ['horloge', 'Je n’ai plus d’eau chaude.', 'Diagnostic sur place, réparation ou chauffe-eau neuf posé sous 48 h.', 'Déplacement et diagnostic 59 €', 'Chauffe-eau', URL('chauffe-eau')],
    ['fleches', 'Ma chaudière a plus de 15 ans.', 'Entretien, réparation ou remplacement : nous vous disons franchement ce qui vaut le coup.', 'Entretien 129 €', 'Chaudière gaz', URL('chaudiere-gaz')],
    ['euro', 'Je veux réduire ma facture de chauffage.', 'Pompe à chaleur air/eau, avec MaPrimeRénov’ et la prime CEE montées avec vous.', 'Dès 11 900 € avant aides', 'Pompe à chaleur', URL('pompe-a-chaleur')],
    ['maison', 'Je refais ma salle de bains.', 'Douche à l’italienne, baignoire, meuble double vasque : un seul artisan du début à la fin.', 'Sur devis, visite gratuite', 'Salle de bains', URL('salle-de-bains')],
  ] }),
  Section('', [sectionHead('Ce que nous faisons', ['Tous nos services', URL('services')]), Cols([
    carteService(FUITE, 'Réparation d’une fuite sous un évier', 'Dépannage plomberie', 'Fuite, WC ou canalisation bouchés, robinet qui goutte : sur place en moins de 2 h.', 'depannage-plomberie'),
    carteService(CHAUFFE, 'Tuyaux et vannes d’une installation d’eau chaude', 'Chauffe-eau', 'Remplacement en 48 h, électrique ou thermodynamique, ancien appareil emporté.', 'chauffe-eau'),
    carteService(PAC, 'Unité extérieure de pompe à chaleur contre un mur', 'Pompe à chaleur', 'Installateur RGE : les aides de l’État déduites, le dossier monté avec vous.', 'pompe-a-chaleur'),
  ])]),
  Section('br-tarifs-liste-section', [
    Head([H('Nos forfaits, sans surprise', 2), Lead(`Prix TTC, pièces courantes comprises, dans notre zone. Le prix est confirmé au téléphone avant de venir (prix d’exemple). ${A('Tous nos tarifs', 'tarifs')}.`)]),
    Box('br-tarifs-liste', [
      [FUITE, 'Réparation d’une fuite', 'Déplacement et diagnostic', 'depannage-plomberie', 'Déduit si vous acceptez la réparation', '59 €'],
      [ROBINET, 'Débouchage d’un évier', 'Débouchage WC ou évier', 'depannage-plomberie', 'Au furet ou à la pompe, en moins d’une heure', 'dès 120 €'],
      [CHAUDIERE, 'Thermostat de chauffage réglé à la main', 'Entretien de chaudière gaz', 'chaudiere-gaz', 'Attestation remise le jour même', '129 €'],
      [CHAUFFE, 'Tuyaux et vannes d’une installation d’eau chaude', 'Chauffe-eau 200 L posé', 'chauffe-eau', 'Pose, mise en service, ancien emporté', 'dès 1 150 €'],
    ].map(tarifLigne)),
  ]),
  etapesFrise('De votre appel à la facture', [
    ['Vous appelez', 'Thomas décroche, pose trois questions et vous donne le prix avant de venir.', '5 minutes'],
    ['Nous venons', 'Dans la zone, en moins de 2 h pour un dépannage, sur rendez-vous pour un projet.', 'Moins de 2 h'],
    ['Vous validez', 'Le prix est écrit et signé avant de commencer. Rien de plus sans votre accord.'],
    ['Nous réparons', 'Pièces courantes dans la camionnette, chantier protégé et laissé propre.'],
  ]),
  Section('br-section-realisations', [sectionHead('Nos derniers chantiers', ['Toutes nos réalisations', URL('realisations')]), Short('[briise_realisations nombre="3"]')]),
  AVIS,
  zoneListe('Zone d’intervention', 'Nous venons chez vous', 'Saint-Jean-de-Braye et toute la métropole d’Orléans : déplacement compris dans le forfait.', ['Toutes les communes', URL('zone-intervention')]),
  qualifs(),
  bandeau('Une fuite, un projet ?', 'Appelez Thomas ou demandez votre devis : réponse le jour même.'),
]);

// Page des services : liste des services (pages liées).
page('services', 'Nos services', 'Plombier chauffagiste : nos services autour d’Orléans',
  'Dépannage, chauffe-eau, chaudière gaz, pompe à chaleur et salle de bains : tous les services de Vérac Plomberie Chauffage (exemple fictif).', [
  teteSplit('Nos services de plomberie et de chauffage', 'Du dépannage dans l’heure à la pompe à chaleur : un seul artisan, des prix annoncés avant de commencer.'),
  Section('br-section-liees', [Short('[briise_pages_liees]')], { backgroundColor: 'surface' }),
  bandeau('Un doute sur le bon service ?', 'Décrivez votre problème à Thomas : il vous oriente gratuitement.'),
], { menu: true, image: CAMION });

/* Pages de service : le récit du prospect (promesse, bénéfices, choix, preuve, déroulé et prix, doutes, action). */
const service = ({ slug, titre, seo, desc, h1, chapo, image, benef, choix, etapes, prix, note, oui, non, qs, menuDesc }) =>
  page(slug, titre, seo, desc, [
    teteSplit(h1, chapo),
    benefices(benef.titre, benef.items),
    ...(choix ? [modeles(choix.titre, choix.intro, choix.items)] : []),
    preuve(choix ? 'Nos chantiers ' + choix.preuve : 'Nos derniers chantiers'),
    etapesFil('Comment ça se passe', etapes, [prixCarte(prix, note, ['Prestation', 'Prix TTC']), compris(oui, non)]),
    faq('Vos questions', qs),
    liees(),
    bandeau('On en parle ?', 'Thomas vous répond et vous donne un prix avant de venir.'),
  ], { parent: 'services', modele: 'service', menu: true, image, menu_description: menuDesc });

service({
  slug: 'depannage-plomberie', titre: 'Dépannage plomberie', menuDesc: 'Fuite, WC bouché, 7 j/7',
  seo: 'Dépannage plomberie à Saint-Jean-de-Braye, en moins de 2 h',
  desc: 'Fuite d’eau, WC ou évier bouché, robinet qui goutte : plombier sur place en moins de 2 h, 7 j/7, prix annoncé avant (exemple fictif).',
  h1: 'Dépannage plomberie en moins de 2 h', image: FUITE,
  chapo: 'Fuite, WC bouché, canalisation, robinet : Thomas vient 7 j/7 de 7 h à 22 h. Déplacement et diagnostic 59 €, déduits si vous acceptez la réparation.',
  benef: { titre: 'Un dépannage sans mauvaise surprise', items: [
    [FUITE, 'Plombier réparant un raccord sous un évier', 'La fuite arrêtée tout de suite', 'Pièces courantes dans la camionnette : dans 8 cas sur 10, c’est réparé à la première visite (exemple fictif).'],
    [OUTILS, 'Caisse à outils de plombier ouverte', 'Le prix avant de commencer', 'Vous savez ce que vous payez avant le premier coup de clé. Rien de plus sans votre accord.'],
    [CAMION, 'Camionnette d’artisan garée devant une maison', 'Un artisan du coin', 'Basé à Saint-Jean-de-Braye : pas de plateforme, pas d’intermédiaire, pas de frais cachés.'],
  ] },
  choix: null,
  etapes: [['Vous appelez', 'Vous décrivez le problème, Thomas vous donne le prix du déplacement et une fourchette.', '5 minutes'], ['Thomas arrive', `Dans ${A('notre zone d’intervention', 'zone-intervention')}, en moins de 2 h, de 7 h à 22 h, 7 j/7.`, 'Moins de 2 h'], ['Diagnostic et prix', 'Il trouve la cause et vous donne le prix de la réparation par écrit.'], ['Réparation', 'La fuite est arrêtée, la zone essuyée, la facture remise sur place.']],
  prix: [['Déplacement et diagnostic', '59 €'], ['Débouchage WC ou évier', 'dès 120 €'], ['Remplacement d’un robinet', 'dès 140 €, robinet fourni'], ['Recherche de fuite simple', 'dès 150 €']],
  note: 'Prix d’exemple, TTC, dans notre zone. Majoration de 30 % le dimanche et les jours fériés, annoncée au téléphone.',
  oui: ['Le déplacement dans la zone', 'Les joints et raccords courants', 'Le nettoyage après intervention'], non: ['Les travaux de maçonnerie', 'Le remplacement d’un appareil complet'],
  qs: [['Venez-vous le dimanche ?', 'Oui, de 7 h à 22 h, 7 j/7. Le dimanche et les jours fériés, une majoration de 30 % s’applique : elle vous est annoncée au téléphone avant de venir.'],
    ['Que faire en attendant ?', 'Coupez l’eau au compteur, souvent dans un regard dehors ou sous l’évier. Coupez aussi l’électricité du chauffe-eau s’il fuit. Épongez et prenez une photo pour votre assurance.'],
    ['Les 59 € sont-ils perdus si je fais réparer ?', 'Non. Si vous acceptez la réparation, le déplacement est déduit de la facture.']],
});
service({
  slug: 'chauffe-eau', titre: 'Chauffe-eau', menuDesc: 'Remplacement en 48 h',
  seo: 'Remplacement de chauffe-eau à Saint-Jean-de-Braye en 48 h',
  desc: 'Plus d’eau chaude ? Chauffe-eau électrique ou thermodynamique posé en 48 h, ancien emporté, prix annoncé avant (exemple fictif).',
  h1: 'Chauffe-eau remplacé en 48 h', image: CHAUFFE,
  chapo: 'Plus d’eau chaude, ou un chauffe-eau qui fuit : diagnostic le jour même, appareil neuf posé sous 48 h. Chauffe-eau 200 L posé dès 1 150 €.',
  benef: { titre: 'De l’eau chaude dès demain', items: [
    [CHAUFFE, 'Tuyaux et vannes d’une installation d’eau chaude', 'Posé sous 48 h', 'Les modèles courants sont en stock chez notre grossiste : pas d’attente de commande.'],
    [RADIATEUR, 'Pièce de vie chauffée', 'Moins d’électricité', 'Un modèle thermodynamique consomme jusqu’à trois fois moins qu’un électrique classique.'],
    [CAMION, 'Camionnette d’artisan', 'L’ancien emporté', 'Nous démontons et emportons l’ancien appareil au recyclage, sans supplément.'],
  ] },
  choix: { titre: 'Électrique ou thermodynamique ?', intro: 'Les deux font de l’eau chaude. La différence se voit sur la facture et dans le prix d’achat.', preuve: 'de chauffe-eau', items: [
    [CHAUFFE, 'Tuyaux et vannes d’une installation d’eau chaude', 'Électrique', [['Pour qui', ' : petit budget, logement loué, peu de place'], ['Prix posé', ' : dès 1 150 € (200 L)'], ['Limite', ' : consomme plus d’électricité']]],
    [PAC, 'Chauffe-eau thermodynamique', 'Thermodynamique', [['Pour qui', ' : propriétaire, famille de 3 personnes ou plus'], ['Prix posé', ' : dès 2 900 € avant aides'], ['Limite', ' : demande un local de 20 m³ ou une gaine']]],
  ] },
  etapes: [['Diagnostic', 'Thermostat, résistance ou cuve : on regarde si une réparation suffit.', 'Le jour même'], ['Choix et prix', 'Vous choisissez le modèle, le prix est écrit et signé.'], ['Pose', 'Démontage, pose, raccords neufs, mise en service.', 'Une demi-journée'], ['Contrôle', 'Groupe de sécurité testé, ancien appareil emporté.']],
  prix: [['Chauffe-eau électrique 200 L posé', 'dès 1 150 €'], ['Chauffe-eau thermodynamique posé', 'dès 2 900 €'], ['Remplacement d’une résistance', 'dès 180 €']],
  note: 'Prix d’exemple, TTC, pose et mise en service comprises.',
  oui: ['La pose et les raccords neufs', 'Le groupe de sécurité neuf', 'L’ancien appareil emporté'], non: ['Le déplacement du chauffe-eau dans une autre pièce'],
  qs: [['Faut-il toujours changer le chauffe-eau ?', 'Non. Si la cuve ne fuit pas, une résistance ou un thermostat se remplacent souvent pour moins de 250 €. Thomas vous le dit avant de proposer un appareil neuf.'],
    ['Combien de temps dure un chauffe-eau ?', 'Dix à quinze ans en moyenne, moins si l’eau est très calcaire comme dans une partie du Loiret.']],
});
service({
  slug: 'chaudiere-gaz', titre: 'Chaudière gaz', menuDesc: 'Entretien, panne, remplacement',
  seo: 'Entretien et dépannage de chaudière gaz près d’Orléans',
  desc: 'Entretien annuel de chaudière gaz 129 €, dépannage, remplacement par une chaudière à condensation. Attestation remise le jour même (exemple fictif).',
  h1: 'Chaudière gaz : entretien, panne et remplacement', image: CHAUDIERE,
  chapo: 'L’entretien annuel est obligatoire : 129 €, attestation remise le jour même. En panne, Thomas vient dans la journée.',
  benef: { titre: 'Une chaudière qui dure', items: [
    [CHAUDIERE, 'Thermostat de chauffage réglé à la main', 'Moins de pannes', 'Un entretien chaque année évite la plupart des pannes de l’hiver.'],
    [RADIATEUR, 'Radiateur dans un salon', 'Moins de gaz brûlé', 'Une chaudière réglée consomme moins : jusqu’à 8 % d’économie (ordre de grandeur, exemple fictif).'],
    [OUTILS, 'Outils et analyseur de combustion', 'L’attestation pour l’assurance', 'Remise le jour même : votre assureur peut la demander après un sinistre.'],
  ] },
  choix: { titre: 'Réparer ou remplacer ?', intro: 'Thomas vous le dit franchement, chiffres à l’appui.', preuve: 'de chauffage', items: [
    [CHAUDIERE, 'Thermostat de chauffage réglé à la main', 'Réparer', [['Quand', ' : chaudière de moins de 12 ans, panne d’une pièce'], ['Prix', ' : dès 150 € hors pièce'], ['Limite', ' : les pièces se font rares après 15 ans']]],
    [RADIATEUR, 'Radiateur et thermostat', 'Remplacer', [['Quand', ' : plus de 15 ans, pannes répétées'], ['Prix', ' : sur devis, visite gratuite'], ['À savoir', ' : une pompe à chaleur peut être aidée, une chaudière gaz ne l’est plus']]],
  ] },
  etapes: [['Rendez-vous', 'Un créneau de deux heures, rappel la veille.'], ['Entretien', 'Nettoyage, réglages, contrôle du monoxyde de carbone.', '1 heure'], ['Attestation', 'Remise sur place, à garder deux ans.']],
  prix: [['Entretien annuel chaudière gaz', '129 €'], ['Dépannage chaudière (hors pièce)', 'dès 150 €'], ['Remplacement', 'sur devis']],
  note: 'Prix d’exemple, TTC.',
  oui: ['Le nettoyage et les réglages', 'Le contrôle du monoxyde de carbone', 'L’attestation d’entretien'], non: ['Les pièces à remplacer'],
  qs: [['L’entretien est-il obligatoire ?', 'Oui, chaque année, pour une chaudière gaz de 4 à 400 kW. L’attestation est à garder deux ans.'],
    ['Faut-il encore installer une chaudière gaz ?', 'Elle reste possible en remplacement, mais elle n’ouvre plus droit aux aides de l’État. Une pompe à chaleur peut coûter moins cher après aides : Thomas compare les deux.']],
});
service({
  slug: 'pompe-a-chaleur', titre: 'Pompe à chaleur', menuDesc: 'Air/eau, installateur RGE',
  seo: 'Pompe à chaleur air/eau près d’Orléans, installateur RGE',
  desc: 'Pompe à chaleur air/eau posée par un installateur RGE QualiPAC : MaPrimeRénov’ et prime CEE déduites, dossier monté avec vous (exemple fictif).',
  h1: 'Pompe à chaleur air/eau, posée par un installateur RGE', image: PAC,
  chapo: 'Dès 11 900 € avant aides. Notre qualification RGE QualiPAC vous ouvre MaPrimeRénov’ et la prime CEE : nous montons le dossier avec vous (exemple fictif).',
  benef: { titre: 'Ce que ça change sur votre facture', items: [
    [PAC, 'Unité extérieure de pompe à chaleur', 'Jusqu’à 60 % de chauffage en moins', 'Par rapport à une vieille chaudière fioul ou gaz (ordre de grandeur, exemple fictif).'],
    [RADIATEUR, 'Radiateur dans une pièce de vie', 'Vos radiateurs gardés', 'La pompe à chaleur air/eau se branche sur votre circuit d’eau chaude existant.'],
    [THOMAS, 'Artisan devant une maison', 'Des aides déduites', 'L’installateur doit être RGE pour que vous touchiez les aides : nous le sommes (exemple fictif).'],
  ] },
  choix: null,
  etapes: [['Visite gratuite', 'Surface, isolation, radiateurs : on calcule la puissance utile.', '1 heure'], ['Devis et aides', 'Le devis montre le prix, les aides et le reste à payer.'], ['Pose', 'Unité extérieure, raccordement, mise en service.', '2 à 3 jours'], ['Suivi', 'Réglages après le premier mois de chauffe.']],
  prix: [['Pompe à chaleur air/eau posée', 'dès 11 900 € avant aides'], ['Entretien annuel', '190 €']],
  note: 'Prix d’exemple, TTC. Le montant des aides dépend de vos revenus : il figure sur le devis.',
  oui: ['L’étude de puissance', 'Le dossier MaPrimeRénov’ et CEE', 'La mise en service'], non: ['L’isolation de la maison', 'Le remplacement des radiateurs'],
  qs: [['Combien vais-je toucher d’aides ?', 'Cela dépend de vos revenus et de votre logement. Le devis indique le montant estimé de MaPrimeRénov’ et de la prime CEE, et le reste à payer.'],
    ['Est-ce bruyant ?', 'Une unité récente fait autant de bruit qu’un réfrigérateur à quelques mètres. Nous choisissons son emplacement avec vous, loin des chambres des voisins.']],
});
service({
  slug: 'salle-de-bains', titre: 'Salle de bains', menuDesc: 'Rénovation, douche à l’italienne',
  seo: 'Rénovation de salle de bains à Saint-Jean-de-Braye',
  desc: 'Douche à l’italienne, baignoire, meuble double vasque : rénovation complète par un seul artisan, visite et devis gratuits (exemple fictif).',
  h1: 'Rénovation de salle de bains', image: SDB,
  chapo: 'Douche à l’italienne, baignoire, meuble vasque : un seul artisan du démontage à la finition. Visite et devis gratuits.',
  benef: { titre: 'Une salle de bains pensée pour vous', items: [
    [DOUCHE, 'Douche à l’italienne carrelée', 'Plus de place', 'Une douche à l’italienne libère souvent un mètre carré par rapport à une baignoire.'],
    [SDB, 'Salle de bains rénovée et lumineuse', 'Un seul interlocuteur', 'Plomberie, carrelage et finitions : Thomas coordonne tout, vous n’avez qu’un numéro.'],
    [ROBINET, 'Robinet mitigeur thermostatique', 'Plus de sécurité', 'Mitigeur thermostatique et receveur antidérapant : pratique pour les enfants comme pour les aînés.'],
  ] },
  choix: { titre: 'Douche ou baignoire ?', intro: 'Tout dépend de qui utilise la pièce.', preuve: 'de salles de bains', items: [
    [DOUCHE, 'Douche à l’italienne', 'Douche à l’italienne', [['Pour qui', ' : petite pièce, personnes âgées'], ['Délai', ' : 1 à 2 semaines'], ['Limite', ' : demande une évacuation au sol']]],
    [SDB, 'Baignoire encastrée', 'Baignoire', [['Pour qui', ' : famille avec de jeunes enfants'], ['Délai', ' : 1 semaine'], ['Limite', ' : prend plus de place']]],
  ] },
  etapes: [['Visite', 'Mesures, choix des matériaux, plan simple.', 'Gratuite'], ['Devis', 'Détaillé poste par poste, sous 5 jours.'], ['Travaux', 'Démontage, plomberie, carrelage, pose.', '1 à 2 semaines'], ['Réception', 'Vous vérifiez avec Thomas avant de régler le solde.']],
  prix: [['Salle de bains complète', 'sur devis'], ['Remplacement baignoire par douche', 'dès 4 900 €']],
  note: 'Prix d’exemple, TTC, carrelage standard compris.',
  oui: ['Le démontage et l’évacuation', 'La plomberie et le carrelage', 'Le nettoyage de fin de chantier'], non: ['Les travaux d’électricité hors luminaires'],
  qs: [['Combien de temps sans salle de bains ?', 'Une à deux semaines selon le chantier. Nous gardons un WC en service pendant les travaux.'],
    ['Peut-on garder la baignoire et changer le reste ?', 'Oui. Le devis se fait poste par poste : vous choisissez ce que vous changez.']],
});

page('tarifs', 'Tarifs', 'Tarifs plombier chauffagiste autour d’Orléans, prix affichés',
  'Dépannage 59 €, débouchage dès 120 €, entretien chaudière 129 €, chauffe-eau posé dès 1 150 € : tous nos prix d’exemple (fictifs).', [
  teteSimple('Nos tarifs, affichés avant de venir', 'Prix TTC dans notre zone, pièces courantes comprises. Le prix est confirmé au téléphone avant chaque intervention.'),
  Section('br-tarifs-liste-section', [Box('br-tarifs-liste', [
    [FUITE, 'Réparation d’une fuite', 'Déplacement et diagnostic', 'depannage-plomberie', 'Déduit si vous acceptez la réparation', '59 €'],
    [ROBINET, 'Débouchage', 'Débouchage WC ou évier', 'depannage-plomberie', 'Au furet ou à la pompe', 'dès 120 €'],
    [CHAUDIERE, 'Thermostat de chauffage réglé à la main', 'Entretien de chaudière gaz', 'chaudiere-gaz', 'Attestation le jour même', '129 €'],
    [CHAUFFE, 'Tuyaux et vannes d’une installation d’eau chaude', 'Chauffe-eau 200 L posé', 'chauffe-eau', 'Ancien emporté', 'dès 1 150 €'],
    [PAC, 'Pompe à chaleur', 'Pompe à chaleur air/eau', 'pompe-a-chaleur', 'Avant aides de l’État', 'dès 11 900 €'],
    [DOUCHE, 'Douche', 'Baignoire remplacée par une douche', 'salle-de-bains', 'Carrelage standard compris', 'dès 4 900 €'],
  ].map(tarifLigne))]),
  faq('Questions sur les prix', [['Le prix peut-il changer sur place ?', 'Seulement si le problème est différent de celui décrit au téléphone. Dans ce cas, Thomas vous donne le nouveau prix par écrit avant de continuer.'], ['Faites-vous des devis gratuits ?', 'Oui, pour les projets : chauffe-eau, chaudière, pompe à chaleur et salle de bains.']]),
  bandeau('Besoin d’un prix précis ?', 'Décrivez votre problème : Thomas vous répond le jour même.'),
], { menu: true });

page('realisations', 'Réalisations', 'Nos chantiers de plomberie et de chauffage',
  'Chauffe-eau, pompes à chaleur, salles de bains : nos chantiers près d’Orléans, avec la demande et ce que nous avons fait (exemples fictifs).', [
  teteSimple('Nos chantiers', 'Chaque fiche raconte la demande du client et ce que nous avons fait. Chantiers d’exemple, fictifs.'),
  Section('br-section-realisations', [Short('[briise_realisations filtres="1"]')]),
  bandeau('Un projet comparable ?', 'Visite et devis gratuits.'),
], { menu: true });

page('zone-intervention', 'Zone d’intervention', 'Plombier à Saint-Jean-de-Braye, Orléans, Chécy et alentours',
  'Saint-Jean-de-Braye, Orléans, Chécy, Semoy, Boigny, Mardié, Fleury, Saint-Jean-de-la-Ruelle, Olivet : délais et communes desservies (exemple fictif).', [
  teteSimple('Où nous intervenons', 'Saint-Jean-de-Braye et la métropole d’Orléans : déplacement compris, dépannage en moins de 2 h.'),
  zoneListe('Communes desservies', 'Votre commune et le délai', 'Les distances sont calculées depuis notre dépôt de Saint-Jean-de-Braye.'),
  bandeau('Vous êtes juste à côté ?', 'Appelez : nous vous disons tout de suite si nous venons.'),
]);

page('a-propos', 'Qui sommes-nous', 'Thomas Vérac, plombier chauffagiste à Saint-Jean-de-Braye',
  'Thomas Vérac intervient lui-même depuis 2014 autour d’Orléans : dépannage, chauffe-eau, chaudière, pompe à chaleur (exemple fictif).', [
  teteSplit('Thomas Vérac, plombier chauffagiste', 'Installé à Saint-Jean-de-Braye depuis 2014, Thomas décroche lui-même et vient lui-même (exemple fictif).'),
  Section('', [Cols([
    Col([Img(THOMAS, '4/5', 'is-style-br-arrondi', 'Thomas Vérac devant sa camionnette')], { width: '40%' }),
    Col([Label('Notre histoire'), H('Un artisan qui répond au téléphone', 2),
      P('Thomas a appris le métier chez un chauffagiste d’Orléans pendant huit ans avant de s’installer à son compte en 2014 (histoire fictive).'),
      P(`Il a choisi de rester seul avec un apprenti : c’est lui qui décroche, lui qui vient, lui qui signe le devis. Pour les pompes à chaleur, il est qualifié RGE QualiPAC, ce qui ouvre droit aux aides de l’État. ${A('Nos tarifs', 'tarifs')} sont affichés en ligne.`),
    ], { width: '60%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })]),
  qualifs(),
  bandeau('Parlons de votre besoin', 'Thomas vous répond le jour même.'),
], { menu: true, image: THOMAS });

page('devis', 'Devis', 'Demander un devis de plomberie ou de chauffage',
  'Décrivez votre besoin : Thomas vous rappelle le jour même. Urgence : appelez directement (exemple fictif).', [
  Section('br-page-head', [Head([Short('[briise_fil_ariane]'), H('Demander un devis', 1, null, { fontSize: 'huge' }), Lead('Quelques lignes suffisent : Thomas vous rappelle le jour même. C’est urgent ? Appelez directement.'), Short('[briise_appel texte="Appeler Thomas"]')])]),
  Section('', [Box('br-card br-formulaire', [Short('[briise_formulaire type="devis"]')])]),
]);

page('merci', 'Merci', 'Demande envoyée', 'Votre demande est bien envoyée.', [
  Section('br-page-head', [Head([H('Merci, votre demande est envoyée', 1), Lead('Thomas vous rappelle le jour même. En cas d’urgence, appelez-le directement.'), Short('[briise_appel texte="Appeler Thomas"]')])]),
], { modele: 'merci' });

/* ---------- Réalisations (fictives) ---------- */
const realisations = [
  { titre: 'Chauffe-eau thermodynamique à Semoy', ville: 'Semoy', date: '2026-09', service: 'chauffe-eau', categories: ['Chauffe-eau'],
    image: CHAUFFE, resume: 'Un chauffe-eau électrique de 15 ans remplacé par un thermodynamique de 270 litres (chantier d’exemple, fictif).',
    demande: ['Une famille de quatre personnes nous a appelés un lundi : plus d’eau chaude depuis la veille. Le chauffe-eau électrique de 200 litres avait quinze ans et la cuve commençait à fuir. Les parents voulaient surtout baisser leur facture d’électricité, qui avait beaucoup augmenté.'],
    solution: ['Thomas est passé le jour même pour le diagnostic. La cuve étant percée, la réparation ne valait pas le coup. Il a proposé deux solutions par écrit : un électrique de 200 litres à 1 150 € ou un thermodynamique de 270 litres à 3 200 €, avec la consommation estimée de chacun.',
      'La famille a choisi le thermodynamique, posé dans le garage le mercredi. L’ancien appareil a été emporté au recyclage. Après un mois, la consommation liée à l’eau chaude avait baissé de près des deux tiers, selon le compteur des clients (chiffres d’exemple).',
      'Le nouvel appareil a été réglé en mode heures creuses. Thomas a montré aux clients comment lire l’écran et vider le condensat, puis il est repassé un mois plus tard pour vérifier la température et le bruit dans le garage.'] },
  { titre: 'Pompe à chaleur air/eau à Chécy', ville: 'Chécy', date: '2026-06', service: 'pompe-a-chaleur', categories: ['Pompe à chaleur'],
    image: PAC, resume: 'Une chaudière fioul remplacée par une pompe à chaleur air/eau, avec les aides déduites (chantier d’exemple, fictif).',
    demande: ['Un couple de retraités chauffait sa maison de 120 m² avec une chaudière fioul de 1998. Le prix du fioul et la peur d’une panne en plein hiver les ont décidés. Ils ne savaient pas à quelles aides ils avaient droit.'],
    solution: ['Après une visite d’une heure, Thomas a calculé la puissance nécessaire et vérifié que les radiateurs en fonte pouvaient être gardés. Le devis montrait le prix, les aides estimées et le reste à payer.',
      'La pompe à chaleur a été posée en trois jours, la cuve à fioul neutralisée par une entreprise partenaire. Le dossier MaPrimeRénov’ et la prime CEE ont été montés ensemble. Les réglages ont été affinés après le premier mois de chauffe.',
      'L’unité extérieure a été posée sur des plots antivibratiles, à l’opposé de la chambre des voisins. Le premier hiver, la maison est restée à 20 degrés, et les clients ont reçu le versement de MaPrimeRénov’ trois mois après la fin du chantier (exemple fictif).'] },
  { titre: 'Douche à l’italienne à Saint-Jean-de-Braye', ville: 'Saint-Jean-de-Braye', date: '2026-03', service: 'salle-de-bains', categories: ['Salle de bains'],
    image: DOUCHE, resume: 'Une baignoire remplacée par une douche à l’italienne pour une personne âgée (chantier d’exemple, fictif).',
    demande: ['Une dame de 78 ans avait de plus en plus de mal à enjamber sa baignoire. Sa fille voulait une solution rapide, sans transformer toute la salle de bains, et un sol qui ne glisse pas.'],
    solution: ['Thomas a proposé une douche à l’italienne à la place de la baignoire, avec un receveur extra-plat antidérapant, une barre de maintien et un mitigeur thermostatique pour éviter les brûlures.',
      'Le chantier a duré six jours. Le WC est resté en service tout du long. La fille de la cliente a validé chaque étape à distance, grâce aux photos envoyées chaque soir.',
      'Le carrelage clair et antidérapant a été choisi avec la cliente, ainsi qu’un siège de douche rabattable fixé au mur. La salle de bains a gardé ses meubles et son lavabo : seul l’espace de la baignoire a été transformé, ce qui a limité le prix et la durée des travaux. La cliente se lave aujourd’hui seule, sans aide (exemple fictif).'] },
];

const site = {
  entreprise: {
    name: 'Vérac Plomberie Chauffage', slogan: 'Plombier chauffagiste à Saint-Jean-de-Braye',
    type: 'Plumber',
    description: 'Plombier chauffagiste à Saint-Jean-de-Braye : dépannage 7 j/7, chauffe-eau, chaudière gaz, pompe à chaleur et salle de bains dans la métropole d’Orléans (client fictif, site d’exemple).',
    email: 'contact@briise.fr', telephone: '06 00 00 00 00',
    street: 'Rue d’exemple (adresse fictive)', postal_code: '45800', city: 'Saint-Jean-de-Braye', country: 'FR',
    areas: ['Saint-Jean-de-Braye', 'Orléans', 'Chécy', 'Semoy', 'Boigny-sur-Bionne', 'Mardié', 'Fleury-les-Aubrais', 'Saint-Jean-de-la-Ruelle', 'Olivet'],
    person_name: 'Thomas Vérac', person_job: 'Plombier chauffagiste, fondateur',
    precision_telephone: 'Thomas décroche lui-même, 7 j/7 de 7 h à 22 h (numéro fictif)', precision_email: 'Réponse le jour même (fictif)', precision_adresse: 'Dépôt, pas d’accueil du public',
    badge_coord_titre: 'Prix annoncé avant', badge_coord_texte: 'Confirmé au téléphone',
    badge_zone_titre: 'Moins de 2 h', badge_zone_texte: 'Pour un dépannage dans la zone',
    zone_rayon: '15',
    zone_points: ['Saint-Jean-de-Braye ; 47.913 ; 1.972', 'Orléans ; 47.902 ; 1.909', 'Chécy ; 47.894 ; 2.024', 'Semoy ; 47.935 ; 1.957', 'Boigny-sur-Bionne ; 47.933 ; 2.017', 'Mardié ; 47.887 ; 2.055', 'Fleury-les-Aubrais ; 47.933 ; 1.917', 'Saint-Jean-de-la-Ruelle ; 47.912 ; 1.865', 'Olivet ; 47.863 ; 1.900'].join('\n'),
    qualifications: [
      { nom: 'RGE QualiPAC', detail: 'Pompes à chaleur (exemple fictif)', numero: 'QPAC-000000', fin: '2028-06-30', lien: 'https://france-renov.gouv.fr/annuaires-professionnels/artisan-rge-architecte' },
      { nom: 'Garantie décennale', detail: 'Exemple Assurances (fictif)', numero: '000000' },
    ],
  },
  legal: {
    raison_sociale: 'Vérac Plomberie Chauffage EURL (fictive)', forme: 'EURL', capital: '5 000 € (fictif)', siren: '000 000 000 (fictif)', rcs: 'Orléans',
    siege: 'Rue d’exemple, 45800 Saint-Jean-de-Braye (adresse fictive)', directeur: 'Thomas Vérac',
    hebergeur_nom: 'Hébergeur à définir (fictif)', realisation: 'Briise',
  },
  annonces: {
    jours: Object.fromEntries([1, 2, 3, 4, 5, 6, 7].map((n) => [n, n <= 5 ? { ouvert: true, plages: [['08:00', '12:00'], ['13:30', '18:30']] } : n === 6 ? { ouvert: true, plages: [['09:00', '12:00'], ['', '']] } : { ouvert: false, plages: [['', ''], ['', '']] }])),
    note: 'Dépannage 7 j/7 de 7 h à 22 h, majoration de 30 % le dimanche et les jours fériés (exemple fictif).',
  },
  ambiance: 'atelier',
  entete: 'barre-infos', pied: 'grand-appel', mobile: 'barre', cartes: 'photo-haut', titres: 'grand-numero',
  capitales: 'oui', cartes_mobile: 'defilement',
  cta: 'devis', cta_label: 'Demander un devis', accueil: 'accueil', personne: 'a-propos', blog: '',
  statut: 'publish',
  realisations,
  pages,
};
require('fs').writeFileSync(require('path').join(__dirname, 'site-verac.json'), JSON.stringify(site, null, 1));
const o = {}; pages.forEach((p) => { o[p.slug] = p.markup; });
require('fs').mkdirSync(require('path').join(__dirname, '..', 'build'), { recursive: true });
require('fs').writeFileSync(require('path').join(__dirname, '..', 'build', 'verac_blocs.json'), JSON.stringify({ sections: o, home: '' }));
console.log(pages.length, 'pages ;', pages.map((p) => p.slug).join(', '));
