// Fichier de site : Briise, agence web à Orléans (test du thème sur le site de l'agence).
// Téléphone et horaires fictifs, comme pour les cas concept. Aucune donnée inventée sur des clients.
const B = require('../build_br_sections.js');
const { cb, serialize, P, H, Label, Lead, Muted, Section, Box, Head, Short, List, fr, CTA, CTA_LABEL, URL, Img, Btn, Btns, Cols, Col, Arrow, Table, Num,
  heroPhoto, confiance, tuiles, etapesFrise, etapesFil, prixCarte, compris, faitsIcones, teteSplit, Row } = B;
const Details = (q, a) => cb('core/details', { summary: fr(q) }, [P(a)]);
const Chips = (items) => cb('core/group', { className: 'br-chips', layout: { type: 'flex', flexWrap: 'wrap' } }, items.map((i) => P(i, 'br-chip')));
const sectionHead = (title, link) => Row('br-section-head', [H(title, 2), ...(link ? [Arrow(link[0], link[1])] : [])]);
const bg = (c) => (c && c !== 'fond' ? { backgroundColor: c } : {});

const tete = (h1, lead, btns) => Section('br-page-head', [Head([Short('[briise_fil_ariane]'), H(h1, 1, null, { fontSize: 'huge' }), Lead(lead), Btns(...(btns || [Btn(CTA_LABEL, CTA)]))])]);
const bandeau = (titre, texte) => Section('br-cta', [Box('br-cta-inner', [H(titre, 2), Lead(texte),
  Btns(Btn(CTA_LABEL, CTA, null, { backgroundColor: 'fond', textColor: 'texte' }))])], { backgroundColor: 'secondaire', textColor: 'fond' });
const faq = (titre, qs, c) => Section('', [Cols([
  Col([Label('Questions fréquentes'), H(titre, 2), Muted('Une autre question ? Je vous réponds sous un jour ouvré.'), Arrow('Poser votre question', CTA)], { width: '38%' }),
  Col(qs.map(([q, a]) => Details(q, a)), { width: '62%' }),
], 'br-split')], bg(c));
const carte = (n, phrase, reponse, prix, offre, slug) => Col([Box('br-card', [Num(n), H(phrase, 3), Muted(reponse), P(`<strong>${prix}</strong>`), Arrow(offre, URL(slug))])]);
const tarif = (nom, prix, pour, items, vedette) => Col([Box('br-card br-price' + (vedette ? ' br-price--vedette' : ''), [
  ...(vedette ? [P('Recommandé', 'br-chip')] : []), H(nom, 3), P(prix, 'br-stat'), Muted(pour), List(items),
  Btns(Btn('Demander un devis', CTA, vedette ? null : 'is-style-outline'))])]);
const projet = (img, chips, titre, phrase, alt, slug) => Col([Box('br-project', [Img(img, '4/3', 'is-style-br-arrondi', alt), Chips(chips), H(titre, 3), Muted(phrase), ...(slug ? [Arrow('Lire l’étude', URL(slug))] : [])])]);

const FORMULES = () => Cols([
  tarif('Présence express', '690 € HT', 'Une seule page, en ligne en 2 semaines environ.', ['1 page longue : services, réalisations, questions, contact', 'Fiche Google mise à jour', 'Déduite si vous passez à une autre formule sous 12 mois']),
  tarif('Site Essentiel', '1 690 € HT', '1 à 3 services, en 4 semaines environ.', ['Jusqu’à 6 pages', 'Étude de ce que vos clients cherchent', '3 fiches réalisations', 'Prise en main 1 h, suivi 30 jours']),
  tarif('Site Visibilité', '2 890 € HT', 'Être trouvé sur chaque service, en 6 à 8 semaines.', ['Jusqu’à 12 pages, une par service', '6 fiches réalisations, FAQ et 2 guides', 'Fiche Google et annuaires', 'Prise en main 1 h 30, suivi à 30, 60 et 90 jours'], true),
], 'br-prices');

/* ---------------- Accueil ---------------- */
const accueil = [
  heroPhoto({ pastille: 'Agence web · Orléans', titre: 'Des sites qui font appeler', accent: 'vos clients',
    chapo: 'Un site clair pour les artisans et les entreprises de la métropole d’Orléans, pensé pour Google et pour les IA, que vous pouvez faire vivre vous-même.',
    second: ['Voir les tarifs', URL('tarifs')], coches: ['Prix affichés', 'Votre site vous appartient', 'Sans engagement'],
    img: 'briise-site-construit', alt: 'Dessin d’un site internet terminé, avec la pastille « En ligne »',
    etiquettes: [['Site vitrine', 'dès 690 € HT'], ['Mini-audit', 'offert']] }),
  confiance([['prix', 'Prix affichés', 'Avant même de nous appeler'], ['garantie', 'Votre site vous appartient', 'Nom de domaine à votre nom'], ['local', 'À Saint-Jean-de-la-Ruelle', 'Métropole d’Orléans et Loiret'], ['devis', 'Mini-audit offert', 'Rendu sous 3 jours ouvrés']]),
  Section('', [Head([Label('Nos offres'), H('Où en êtes-vous avec votre site ?', 2), Lead('Choisissez la phrase qui vous ressemble : on vous montre ce qui vous servira, et ce que ça coûte.')]),
    Cols([
      carte('+', 'Je n’ai pas encore de site.', 'On crée un site clair, que vos clients trouvent et que vous modifiez vous-même.', 'Dès 690 € HT', 'Création de site', 'creation-site-vitrine'),
      carte('↻', 'J’ai un site, mais il ne m’apporte rien.', 'On le remet à neuf, sans perdre ce que Google connaît déjà de vous.', 'Dès 1 980 € HT', 'Refonte de site', 'creation-site-vitrine'),
      carte('⌖', 'On ne me trouve pas sur Google.', 'Votre fiche Google, vos pages et vos réponses, travaillées pour votre ville.', '390 € HT une fois', 'Référencement local', 'tarifs'),
      carte('✓', 'Je veux qu’on s’en occupe pour moi.', 'Mises à jour, sauvegardes et retouches, même pour un site WordPress existant.', '59 € HT par mois', 'Abonnement', 'tarifs'),
    ], 'br-cards-4'),
  ]),
  Section('', [sectionHead('Voyez à quoi ça ressemble', ['Nos réalisations expliquées', URL('realisations')]),
    Muted('Des sites d’exemple faits avec notre méthode, pour des entreprises imaginaires. Nos premiers projets clients prendront leur place.'),
    Cols([
      projet('ferlune-accueil', ['Exemple', 'Saran'], 'Atelier Ferlune, métallier', 'Une page par ouvrage, avec son prix indicatif et ce qui est compris.', 'Accueil du site d’exemple Atelier Ferlune'),
      projet('lison-accueil', ['Exemple', 'Olivet'], 'Lison Vautrin, photographe', 'Les photos d’abord, une page par séance et une demande de date en trois étapes.', 'Accueil du site d’exemple Lison Vautrin'),
      projet('ferlune-service', ['Exemple', 'Page de service'], 'Une page de service', 'Ce que le client cherche, le prix, les étapes et les questions fréquentes.', 'Page de service du site d’exemple Atelier Ferlune'),
    ], 'br-projects'),
  ], { backgroundColor: 'surface' }),
  tuiles('Nos engagements', 'Pas besoin de nous croire, tout est écrit et vérifiable', [
    ['grande', '100', 'sur 100 en accessibilité sur nos sites d’exemple (mesure Google Lighthouse).'],
    ['large', '3 jours', 'ouvrés pour recevoir votre mini-audit.'], ['', '0 €', 'pour savoir où vous en êtes avant de décider.'],
    ['accent', '1', 'seul interlocuteur, de la maquette à la mise en ligne'],
  ], 'Le prix est écrit avant de commencer, le site vous appartient, l’abonnement s’arrête quand vous voulez.'),
  etapesFrise('De votre premier appel à votre site en ligne', [
    ['On se parle', 'Un appel découverte ou votre mini-audit offert : votre métier, vos clients, vos attentes.', '20 minutes'],
    ['Vous choisissez un style', 'Plusieurs maquettes de votre accueil, avec de vraies images. Rien n’est construit avant votre choix.', 'Plusieurs styles'],
    ['Les textes et le site', 'Écrits pour vos clients et pour Google, relus avec vous avant la mise en ligne.', 'Relu avec vous'],
    ['La mise en ligne', 'Le site, votre fiche Google, une prise en main, puis un suivi pour ajuster.', 'Prise en main'],
  ], [Muted('Vous validez chaque étape avant que la suivante commence.')], 'Comment ça se passe', 'secondaire'),
  faitsIcones({ titre: 'Un site prêt à travailler, et les clés pour le faire vivre', chapo: 'Ce que vous recevez à la mise en ligne.', img: 'telephone-ferlune', alt: 'Le site d’exemple Atelier Ferlune sur téléphone', bg: 'surface', items: [
    ['maison', 'Le site en ligne', 'Testé sur téléphone, lisible par tous, rapide à charger.'],
    ['euro', 'Un prix écrit', 'Celui du devis, sans supplément découvert en route.'],
    ['bouclier', 'Votre fiche Google à jour', 'Catégorie, horaires, photos : ce qui décide de votre place sur Google Maps.'],
    ['appareil', 'Une prise en main', 'Pour changer vos textes, vos photos et vos horaires vous-même.'],
    ['horloge', 'Un suivi', 'Après la mise en ligne, on corrige et on ajuste avec vous.'],
    ['accessible', 'Accessible à tous', 'Au clavier, au lecteur d’écran, sur petit écran.'],
  ] }),
  Section('', [Head([Label('Tarifs'), H('Des prix clairs, affichés, sans surprise', 2), Lead('TVA non applicable, article 293 B du CGI : le prix affiché est celui que vous payez.')]), FORMULES(),
    Muted('Vous avez déjà un site ? La refonte coûte le prix de la formule, plus 290 € HT de reprise. Vous gardez votre site ? La mise à niveau locale, 390 € HT. L’abonnement Briise : 59 € HT par mois, sans engagement.'),
    Arrow('Tous les prix et ce qui est compris', URL('tarifs'))]),
  Section('', [Cols([
    Col([Img('briise-monogramme', '4/5', 'is-style-br-galet', 'Monogramme PJM, Patrick Junior Malamba')], { width: '42%' }),
    Col([Label('Qui est derrière Briise'), H('Une personne, de la maquette à la mise en ligne', 2),
      P('« Je réponds moi-même, je vous parle simplement et je mesure ce que le site vous rapporte. »', 'br-statement'),
      P('Patrick Junior Malamba, fondateur de Briise. Je travaille dans le marketing digital d’un groupe industriel et je me forme au MBA Expert Marketing Digital. J’ai créé Briise pour donner aux artisans des sites aussi soignés que ceux des grandes entreprises, à un prix connu d’avance.'),
      Arrow('Mon parcours et ma méthode', URL('a-propos'))], { width: '58%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })], { backgroundColor: 'surface' }),
  faq('Ce qu’on nous demande avant de se lancer', [
    ['Combien coûte un site internet ?', 'De 690 € HT pour une page à 2 890 € HT pour un site de 12 pages, prix écrit sur le devis. Pour refaire un site existant, comptez le prix de la formule plus 290 € HT.'],
    ['Serai-je premier sur Google ?', 'Non, et personne ne peut le garantir honnêtement. Nous mettons en place tout ce qui donne à votre site les meilleures chances d’être trouvé et cité.'],
    ['Mon site m’appartient-il ?', 'Oui, entièrement. Si vous partez, nous vous remettons tout ce qu’il faut pour le déplacer.'],
    ['Vous occupez-vous d’un site WordPress existant ?', 'Oui, avec l’abonnement Briise à 59 € HT par mois, après un premier regard pendant le mini-audit offert.'],
  ]),
  bandeau('Parlons de votre site, sans engagement', 'Une seule personne vous répond, sous un jour ouvré.'),
];

/* ---------------- Création de site vitrine ---------------- */
const vitrine = [
  teteSplit('Création de site vitrine à Orléans et dans le Loiret', 'Un site de 1 à 12 pages, pensé pour le téléphone et pour Google, de 690 à 2 890 € HT. Vous le modifiez vous-même, et il vous appartient.', CTA_LABEL),
  faitsIcones({ titre: 'Un site qui travaille pendant que vous êtes sur le chantier', chapo: 'Ce que vous y gagnez, concrètement.', img: 'telephone-lison', alt: 'Le site d’exemple Lison Vautrin sur téléphone', bg: 'surface', items: [
    ['maison', 'On vous trouve', 'Une page pour chaque service que vos clients recherchent.'], ['appareil', 'On vous appelle', 'Le téléphone en haut de chaque page, un bouton d’appel sur mobile.'],
    ['coeur', 'Vous le modifiez', 'Textes, photos, horaires, sans risque de casser la mise en page.'], ['bouclier', 'Il vous appartient', 'Le nom de domaine à votre nom, tous les accès remis.'],
    ['euro', 'Un prix fixe', 'Écrit sur le devis, avec ce qui est compris et ce qui ne l’est pas.'], ['accessible', 'Lisible par tous', 'Testé au clavier et sur téléphone.'],
  ] }),
  Section('', [Cols([
    Col([Label('Vous avez déjà un site ?'), H('On le refait, sans perdre ce que Google connaît', 2),
      P('Une refonte, c’est un site neuf qui garde ce que l’ancien avait gagné. Chaque ancienne page est redirigée vers la nouvelle : vos clients et Google ne tombent jamais sur une page vide.'),
      List(['On garde ce qui marche', 'On refait le reste', 'On redirige vos anciennes pages']),
      P('<strong>Prix de la formule + 290 € HT</strong> pour reprendre l’existant, jusqu’à 30 pages.'),
      Arrow('Pas sûr qu’il faille tout refaire ? Le mini-audit est offert', URL('audit-site-offert'))], { width: '52%', verticalAlignment: 'center' }),
    Col([Img('ferlune-accueil', '4/3', 'is-style-br-arrondi', 'Accueil du site d’exemple Atelier Ferlune')], { width: '48%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })]),
  etapesFil('Huit étapes, un seul interlocuteur', [
    ['Premier contact', 'Réponse sous un jour ouvré.', '1 jour'], ['Appel découverte et mini-audit', 'Votre métier et votre visibilité actuelle.', '20 min'],
    ['Rendez-vous de cadrage', 'Vos services, vos clients, votre zone.', '1 h'], ['Le devis', 'Le prix écrit, ce qui est compris et ce qui ne l’est pas.', 'Sous 48 h'],
    ['Signature', 'Un acompte de 40 %, le solde à la livraison.', '40 %'], ['La fabrication', 'Vous validez la stratégie, le plan, les textes, puis le site.', '4 validations'],
    ['La mise en ligne', 'Le site, la fiche Google, la prise en main et tous les accès.', 'Accès remis'], ['Le suivi', 'On corrige et on ajuste avec vous.', '30 jours et plus'],
  ], [prixCarte([['Présence express', '690 €'], ['Site Essentiel', '1 690 €'], ['Site Visibilité', '2 890 €']], 'Prix HT. TVA non applicable, article 293 B du CGI.', ['Formule', 'Prix']),
    compris(['Étude, textes, mise en page', 'Fiche Google mise à jour', 'Prise en main et suivi'], ['Les photos : vous les fournissez', 'Hébergement et domaine : abonnement Briise ou chez vous'])], 'Comment ça se passe, et le prix', 'nuance'),
  faq('Ce qu’on nous demande sur le site vitrine', [
    ['En combien de temps mon site est-il en ligne ?', 'Environ 2 semaines pour la Présence express, 4 semaines pour le Site Essentiel, 6 à 8 semaines pour le Site Visibilité, dès que nous avons vos photos et vos informations.'],
    ['Puis-je modifier mon site moi-même ?', 'Oui. Une prise en main est comprise, et l’écran d’administration est pensé pour ne rien casser.'],
    ['Vais-je perdre mon référencement en refaisant mon site ?', 'Non, si les anciennes pages sont redirigées vers les nouvelles. C’est compris dans la reprise de l’existant, à 290 € HT.'],
    ['Faut-il tout refaire ?', 'Pas forcément. Le mini-audit offert dit ce qui marche et ce qui bloque. Si votre site tient la route, la mise à niveau locale à 390 € HT peut suffire.'],
  ]),
  bandeau('Parlons de votre site, sans engagement', 'Une seule personne vous répond, sous un jour ouvré.'),
];

/* ---------------- Tarifs ---------------- */
const tarifs = [
  tete('Tarifs de création de site internet', 'Un site coûte de 690 à 2 890 € HT, une fois. L’abonnement, 59 € HT par mois, sans engagement. Tout est écrit ici, avant même de nous appeler.'),
  Section('', [Head([Label('Créer votre site'), H('Trois formules, un prix fixe et écrit', 2)]), FORMULES(),
    Muted('TVA non applicable, article 293 B du CGI. Acompte de 40 % à la signature, solde à la livraison. Une page en plus : 190 € HT. Une heure de modifications : 60 € HT. L’audit complet : 290 € HT, déduit si vous signez dans les 3 mois.')], { backgroundColor: 'surface' }),
  Section('', [Head([Label('Le détail'), H('Ce qui change d’une formule à l’autre', 2)]),
    Table(['', 'Présence express', 'Site Essentiel', 'Site Visibilité'], [
      ['Prix', '690 €', '1 690 €', '2 890 €'], ['Pages', '1', 'Jusqu’à 6', 'Jusqu’à 12'], ['Délai de mise en ligne', '2 semaines', '4 semaines', '6 à 8 semaines'],
      ['Étude de ce que vos clients cherchent', '—', 'Oui', 'Oui'], ['Fiches réalisations', '—', '3', '6'], ['Questions fréquentes et guides', '—', '—', 'Oui, 2 guides'],
      ['Fiche Google', 'Mise à jour', 'Optimisée', 'Optimisée et annuaires'], ['Prise en main', '—', '1 h', '1 h 30'], ['Suivi', '—', '30 jours', '30, 60 et 90 jours'],
    ])]),
  Section('', [Head([Label('Vous avez déjà un site'), H('Le refaire, ou le garder et le faire trouver', 2)]), Cols([
    Col([Box('br-card', [H('La refonte', 3), P('<strong>Prix de la formule + 290 € HT</strong>'), Muted('Un site neuf et la reprise de l’existant : état des lieux, contenus utiles, redirections de vos anciennes pages, jusqu’à 30 pages. Soit dès 1 980 € HT avec le Site Essentiel.')])]),
    Col([Box('br-card', [H('La mise à niveau locale', 3), P('390 € HT', 'br-stat'), Muted('Vous gardez votre site. Fiche Google complète, coordonnées identiques partout, corrections essentielles de votre site si nous y avons accès.')])]),
  ])], { backgroundColor: 'secondaire' }),
  Section('', [Cols([
    Col([Label('L’abonnement Briise'), H('On s’occupe de tout, vous gardez la main', 2), List(['Hébergement et nom de domaine .fr', 'Mises à jour, sauvegardes, surveillance', '30 minutes de modifications par mois', 'Un rapport tous les trois mois', 'Aussi pour un site WordPress existant']),
      Muted('En option : votre fiche Google tenue à jour, 59 € HT par mois.')], { width: '50%' }),
    Col([prixCarte([['Au mois', '59 € HT'], ['À l’année (2 mois offerts)', '590 € HT']], 'Sans engagement. À l’année, 118 € d’économie.', ['Paiement', 'Prix'])], { width: '50%', verticalAlignment: 'center' }),
  ], 'br-split')]),
  faq('Prix, engagement et propriété', [
    ['Faut-il ajouter la TVA ?', 'Non. Briise est une micro-entreprise en franchise de TVA : le prix affiché est le prix que vous payez.'],
    ['Comment se passe le paiement ?', 'Un acompte de 40 % à la signature, le solde à la livraison du site.'],
    ['L’abonnement est-il obligatoire ?', 'Non. Il comprend l’hébergement et le nom de domaine ; vous pouvez aussi héberger le site chez vous.'],
    ['Pouvez-vous garantir la première place sur Google ?', 'Non, et personne ne peut le promettre honnêtement. Nous mesurons les progrès avec vous.'],
  ], 'surface'),
  bandeau('Un doute sur la formule ?', 'On en parle 20 minutes au téléphone, sans engagement.'),
];

/* ---------------- Réalisations ---------------- */
const etude = (img, alt, chips, titre, depart, fait, change, inverse, c) => Section('', [Cols([
  Col([Img(img, '16/10', 'is-style-br-arrondi', alt)], { width: '52%', verticalAlignment: 'center' }),
  Col([Chips(chips), H(titre, 2), P('<strong>Le point de départ.</strong> ' + depart), P('<strong>Ce que nous avons fait.</strong> ' + fait), P('<strong>Ce que ça change.</strong> ' + change)], { width: '48%', verticalAlignment: 'center' }),
], 'br-split' + (inverse ? ' br-alterne' : ''), { verticalAlignment: 'center' })], bg(c));
const realisations = [
  tete('Nos réalisations, ce que nous avons fait et pourquoi', 'Pour chaque site : le point de départ, ce que nous avons construit, et ce que ça change. Les projets marqués « Exemple » sont des entreprises imaginaires, construites avec la même méthode que pour un client.'),
  etude('ferlune-accueil', 'Accueil du site d’exemple Atelier Ferlune', ['Exemple', 'Métallier', 'Saran'], 'Atelier Ferlune',
    'Un artisan qui fabrique escaliers, garde-corps et portails sur mesure, connu par le bouche-à-oreille et jamais trouvé sur Google.',
    'Une page par ouvrage, avec des prix indicatifs et ce qui est compris. La zone d’intervention en liste, avec les distances. La garantie décennale affichée.',
    'Chaque ouvrage peut être trouvé sur sa propre recherche, et le client sait à quoi s’attendre avant d’appeler.', false, 'surface'),
  etude('lison-accueil', 'Accueil du site d’exemple Lison Vautrin', ['Exemple', 'Photographe', 'Olivet'], 'Lison Vautrin',
    'Une photographe dont le travail se voyait surtout sur Instagram, sans tarifs clairs ni moyen simple de réserver.',
    'Une ouverture qui laisse parler les photos, une page par type de séance avec son prix, et une demande de date en trois étapes.',
    'Les visiteurs voient le style, le prix et les disponibilités au même endroit, et la demande arrive complète.', true),
  bandeau('Le prochain projet, c’est peut-être le vôtre', 'Demandez votre mini-audit : il est offert et rendu sous 3 jours ouvrés.'),
];

/* ---------------- Audit offert ---------------- */
const audit = [
  tete('Audit de site internet offert, sous 3 jours ouvrés', 'Cinq points vérifiés sur votre site et votre fiche Google, et vos trois priorités. Gratuit, sans engagement, sans rien installer. Pas de site ? On regarde vos concurrents.', [Btn('Demander mon mini-audit', CTA)]),
  faitsIcones({ titre: 'Cinq points, ceux qui font sonner le téléphone', chapo: 'Ce que nous vérifions, avec ce que tout le monde peut voir.', img: 'briise-site-construit', alt: 'Dessin d’un site internet', bg: 'surface', items: [
    ['maison', 'Votre visibilité sur Google', 'Sur quelles recherches vous apparaissez, et où vos concurrents passent devant.'],
    ['bouclier', 'Votre fiche Google', 'Ce qui manque pour remonter sur la carte.'], ['appareil', 'Votre site sur téléphone', 'Ce que voit un client, et la vitesse.'],
    ['horloge', 'Le chemin vers le contact', 'Combien de clics jusqu’à votre numéro.'], ['euro', 'Vos coordonnées partout', 'Identiques sur Google, votre site et les annuaires.'],
    ['coeur', 'Vos trois priorités', 'Ce qu’il faut faire en premier, que vous travailliez avec nous ou non.'],
  ] }),
  Section('', [Cols([
    Col([Box('br-card', [H('Le mini-audit', 3), P('0 €', 'br-stat'), List(['Cinq points vérifiés', 'Vos trois priorités', 'Rendu sous 3 jours ouvrés'])])]),
    Col([Box('br-card', [H('L’audit complet, pour aller plus loin', 3), P('290 € HT', 'br-stat'), List(['Tout le site passé en revue', 'Vos concurrents analysés', 'Un plan d’action détaillé', 'Déduit si vous signez dans les 3 mois'])])]),
  ])], { backgroundColor: 'secondaire' }),
  Section('', [Cols([
    Col([Label('Votre demande'), H('Deux minutes pour remplir', 2), List(['Vous envoyez ce formulaire', 'Sous 3 jours ouvrés, votre mini-audit arrive par e-mail', 'Si vous le souhaitez, on en parle 20 minutes au téléphone'])], { width: '42%' }),
    Col([Box('br-card br-formulaire', [Short('[briise_formulaire type="contact"]')])], { width: '58%' }),
  ], 'br-split')]),
];

/* ---------------- À propos ---------------- */
const apropos = [
  Section('', [Cols([
    Col([Short('[briise_fil_ariane]'), H('Une agence web, une personne qui vous répond', 1, null, { fontSize: 'huge' }),
      Lead('Je suis Patrick Junior Malamba, fondateur de Briise, à Saint-Jean-de-la-Ruelle. Je crée et je fais vivre des sites qui font venir des clients. Le site et le nom de domaine restent à vous.'), Chips(['Créatif', 'Accessible', 'Humain'])], { width: '56%', verticalAlignment: 'center' }),
    Col([Img('briise-monogramme', '4/5', 'is-style-br-galet', 'Monogramme PJM')], { width: '44%', verticalAlignment: 'center' }),
  ], 'br-split', { verticalAlignment: 'center' })], { backgroundColor: 'surface' }),
  Section('', [
    P('« Je réponds moi-même, je vous parle simplement et je mesure ce que le site vous rapporte. »', 'br-statement br-center br-narrow'),
    Cols([Col([H('Je réponds moi-même', 3), Muted('Pas de standard, pas de chef de projet entre nous.')]), Col([H('Je parle simplement', 3), Muted('Chaque mot technique est expliqué, ou remplacé.')]), Col([H('Je mesure', 3), Muted('Des chiffres réels, jamais des promesses.')])], 'br-steps'),
  ]),
  etapesFrise('Huit étapes, vous validez chacune', [
    ['Premier contact', 'Réponse sous un jour ouvré.'], ['Appel et mini-audit', '20 minutes.'], ['Cadrage', '1 heure.'], ['Devis', 'Sous 48 h.'],
    ['Signature', 'Acompte de 40 %.'], ['Fabrication', '4 validations.'], ['Mise en ligne', 'Prise en main, accès remis.'], ['Suivi', '30 jours et plus.'],
  ], [], 'La méthode', 'surface'),
  Section('', [Head([Label('Ce que Briise ne fait pas'), H('Et ne fera jamais, même si on le demande', 2)]),
    List(['De faux avis', 'Des pages ville copiées-collées', 'Une location de site sur 48 mois', 'Une promesse de première place sur Google'])]),
  bandeau('Faisons connaissance', '20 minutes au téléphone, sans engagement.'),
];

/* ---------------- Contact ---------------- */
const contact = [
  tete('Parlons de votre site', 'Une seule personne vous répond, sous un jour ouvré. Basé à Saint-Jean-de-la-Ruelle, Briise travaille dans la métropole d’Orléans et le Loiret, et partout ailleurs à distance.', [Btn('Appeler le 06 00 00 00 00', 'tel:+33600000000')]),
  Section('', [Short('[briise_carte_coordonnees]')], { backgroundColor: 'surface' }),
  Section('', [Cols([
    Col([Label('Écrire'), H('Dites-nous ce que vous cherchez', 2), P('Pas besoin de cahier des charges. Nous revenons vers vous avec les bonnes questions.'), Arrow('Vous préférez un avis sur votre site ? Le mini-audit est offert', URL('audit-site-offert'))], { width: '42%' }),
    Col([Box('br-card br-formulaire', [Short('[briise_formulaire type="contact"]')])], { width: '58%' }),
  ], 'br-split')]),
];

const mk = (slug, titre, blocks, extra = {}) => ({ slug, titre, markup: serialize(blocks), ...extra });
const site = {
  entreprise: { name: 'Briise', slogan: 'Agence web à Orléans', type: 'ProfessionalService',
    description: 'Agence web à Saint-Jean-de-la-Ruelle : création de sites vitrines, référencement local et maintenance pour les artisans et entreprises de la métropole d’Orléans.',
    email: 'contact@briise.fr', telephone: '06 00 00 00 00', street: '', postal_code: '45140', city: 'Saint-Jean-de-la-Ruelle', country: 'FR',
    areas: ['Orléans', 'Saint-Jean-de-la-Ruelle', 'Olivet', 'Saran', 'Fleury-les-Aubrais', 'Saint-Jean-de-Braye', 'Ingré'],
    person_name: 'Patrick Junior Malamba', person_job: 'Fondateur de Briise',
    precision_telephone: 'Je décroche moi-même, du lundi au vendredi (numéro fictif)', precision_email: 'Réponse sous un jour ouvré', precision_adresse: 'Rendez-vous chez vous ou à distance' },
  annonces: { jours: { 1: { ouvert: true, plages: [['09:00', '12:30'], ['14:00', '18:00']] }, 2: { ouvert: true, plages: [['09:00', '12:30'], ['14:00', '18:00']] }, 3: { ouvert: true, plages: [['09:00', '12:30'], ['14:00', '18:00']] }, 4: { ouvert: true, plages: [['09:00', '12:30'], ['14:00', '18:00']] }, 5: { ouvert: true, plages: [['09:00', '12:30'], ['14:00', '18:00']] }, 6: { ouvert: false }, 0: { ouvert: false } } },
  ambiance: 'charte-client',
  couleurs: { fond: '#ffffff', clair: '#ffffff', surface: '#f7f4ff', nuance: '#eaf7ff', texte: '#24124a', 'texte-doux': '#4e4466', accent: '#2f5bff', secondaire: '#24124a', deco: '#c9bcff', sombre: '#24124a' },
  // Logos, par leur nom dans la Médiathèque (briise-logo-sombre.png, briise-logo-clair.png).
  logo: 'briise-logo-sombre', logo_clair: 'briise-logo-clair',
  // Polices de la charte, à téléverser avant l'import (Styles > Typographie > Gérer les polices).
  polices: { titres: 'Sora', texte: 'Figtree', accent: 'Instrument Serif', accent_italique: true, accent_taille: 1.15 },
  capitales: 'oui',
  entete: 'capsule', pied: 'grand-titre', mobile: 'barre', cartes: 'photo-haut', titres: 'tete-lien',
  cta: 'contact', cta_label: 'Nous contacter', accueil: 'accueil', faq: '', personne: 'a-propos', blog: '',
  statut: 'publish',
  images: { 'briise-site-construit': '/wp-content/briise-img/briise-site-construit.jpg', 'briise-monogramme': '/wp-content/briise-img/briise-monogramme.jpg',
    'ferlune-accueil': '/wp-content/briise-img/ferlune-accueil.webp', 'ferlune-service': '/wp-content/briise-img/ferlune-service.webp', 'ferlune-mobile': '/wp-content/briise-img/ferlune-mobile.webp',
    'lison-accueil': '/wp-content/briise-img/lison-accueil.webp', 'lison-mobile': '/wp-content/briise-img/lison-mobile.webp', 'telephone-ferlune': '/wp-content/briise-img/telephone-ferlune.jpg', 'telephone-lison': '/wp-content/briise-img/telephone-lison.jpg' },
  pages: [
    mk('accueil', 'Accueil', accueil, { seo_titre: 'Agence web à Orléans : création de site internet | Briise', seo_description: 'Sites vitrines pour artisans et entreprises de la métropole d’Orléans, de 690 à 2 890 € HT. Prix affichés, site à vous, sans engagement. Mini-audit offert.' }),
    mk('creation-site-vitrine', 'Création de site vitrine', vitrine, { menu: true, image: 'ferlune-service', seo_titre: 'Création de site vitrine à Orléans | Briise', seo_description: 'Un site vitrine de 1 à 12 pages, pensé pour le téléphone et pour Google, de 690 à 2 890 € HT. Refonte possible sans perdre votre référencement.' }),
    mk('tarifs', 'Tarifs', tarifs, { menu: true, seo_titre: 'Tarif création site internet : nos prix | Briise', seo_description: 'Site de 690 à 2 890 € HT, refonte, mise à niveau locale à 390 € HT, abonnement à 59 € HT par mois sans engagement. Tout est écrit.' }),
    mk('realisations', 'Réalisations', realisations, { menu: true, seo_titre: 'Nos réalisations expliquées | Briise', seo_description: 'Pour chaque site : le point de départ, ce que nous avons construit et ce que ça change. Sites d’exemple faits avec notre méthode.' }),
    mk('audit-site-offert', 'Audit offert', audit, { menu: true, seo_titre: 'Audit de site internet gratuit | Briise', seo_description: 'Cinq points vérifiés sur votre site et votre fiche Google, et vos trois priorités, sous 3 jours ouvrés. Gratuit, sans engagement.' }),
    mk('a-propos', 'À propos', apropos, { menu: true, seo_titre: 'À propos : Patrick Junior Malamba | Briise', seo_description: 'Une agence web, une personne qui vous répond. La méthode en huit étapes et ce que Briise ne fera jamais.' }),
    mk('contact', 'Contact', contact, { seo_titre: 'Contact : parlons de votre site | Briise', seo_description: 'Appeler, écrire ou réserver un appel de 20 minutes. Réponse sous un jour ouvré. Saint-Jean-de-la-Ruelle et métropole d’Orléans.' }),
  ],
};
// Les photos se déposent dans la Médiathèque avant l'import, nommées comme les repères {{IMG:…}}.
delete site.images;
require('fs').writeFileSync(require('path').join(__dirname, 'site-briise.json'), JSON.stringify(site, null, 1));
require('fs').mkdirSync(require('path').join(__dirname, '..', 'build'), { recursive: true });
require('fs').writeFileSync(require('path').join(__dirname, '..', 'build', 'briise_blocs.json'), JSON.stringify({ sections: Object.fromEntries(site.pages.map((p) => [p.slug, p.markup])), home: '' }));
console.log('ok', site.pages.length, 'pages');
