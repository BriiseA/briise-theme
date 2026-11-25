// Parcours de démarrage Briise : chaque parcours = une liste de pages composées de sections.
const L = require('./build_br_sections.js');
const { S, cb, serialize, P, H, Label, Lead, Muted, Section, Box, Head, Short, MainBtns, List, fr } = L;

const sec = (slug) => S[slug].blocks;

/* Rythme : deux sections voisines n'ont jamais le même fond clair. Le fond de la seconde passe
   à une teinte voisine (fond, surface, nuance) différente de ses deux voisines. Les bandes sombres
   et les photos ne bougent pas ; une tête de page peut précéder une section du même fond. */
const { cloneBlock } = require('@wordpress/blocks');
const CLAIRS = ['fond', 'surface', 'nuance'];
const fondDe = (b) => (b.name === 'core/cover' ? 'photo' : (b.attributes.backgroundColor || 'fond'));
// La bande de confiance chevauche la section du dessus : elle ne compte pas dans le rythme.
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
    } else {
      out.push(b);
    }
  });
  return out;
};
const tete = (titre, chapo, bouton = true) => [Section('br-page-head', [Head([
  Short('[briise_fil_ariane]'), H(titre, 1, null, { fontSize: 'huge' }), Lead(chapo), ...(bouton ? [MainBtns()] : []),
])])];
// Pages de service et à propos : en-tête avec la photo de la page (image mise en avant) à côté du texte.
const teteP = (titre, chapo, bouton = true) => [L.teteSplit(titre, chapo, bouton ? L.CTA_LABEL : false)];
// Sur la page des services : la liste de chaque page de service (vide tant qu'il n'y en a pas).
const detail = [Section('br-section-liees', [L.cb('core/heading', { content: 'Chaque service en détail', level: 2 }), Short('[briise_pages_liees]')], { backgroundColor: 'surface' })];
const page = (slug, titre, ...parts) => ({ slug, titre, markup: serialize(rythme(parts.flat())) });

/* ----- Pages légales, communes à tous les parcours ----- */

const texte = (titre, chapo, contenu) => serialize([
  Section('br-page-head', [Head([Short('[briise_fil_ariane]'), H(titre, 1, null, { fontSize: 'huge' }), Lead(chapo)])]),
  Section('br-section--tight', [Box('br-legal', contenu)]),
]);
const NOM = '[briise_info champ="name"]';
const MAIL = '[briise_info champ="email"]';
const legales = [
  { slug: 'mentions-legales', titre: 'Mentions légales', markup: texte('Mentions légales', 'Les informations légales sur l’éditeur et l’hébergeur de ce site.', [Short('[briise_mentions_legales]')]) },
  { slug: 'confidentialite', titre: 'Politique de confidentialité', markup: texte('Politique de confidentialité', 'Quelles données sont collectées sur ce site, pourquoi, et comment exercer vos droits. Dernière mise à jour : [à compléter : date].', [
    H('Responsable du traitement', 2), P(NOM + ', ' + MAIL + '.'),
    H('Données collectées', 2), List([
      'Lorsque vous remplissez un formulaire (contact ou demande de devis) : votre nom, votre téléphone, votre commune, votre adresse e-mail si vous la donnez, et la description de votre demande. Ces informations sont enregistrées sur le site (extension Fluent Forms) et envoyées par e-mail à ' + NOM + ' pour vous répondre.',
      'Lorsque vous prenez rendez-vous en ligne : les informations nécessaires au rendez-vous. [à compléter : outil de réservation, ou supprimer cette ligne]',
      'Lorsque vous visitez le site : des statistiques de fréquentation anonymes (voir la page Cookies).',
    ]),
    H('Pourquoi et sur quelle base', 2), List([
      'Répondre à vos demandes : intérêt légitime.',
      'Établir un devis, exécuter une prestation, facturer : exécution du contrat et obligations légales.',
      'Mesurer la fréquentation du site : intérêt légitime, dans les conditions fixées par la CNIL.',
    ]),
    H('Durées de conservation', 2), List([
      'Demandes de contact : 3 ans après le dernier échange.',
      'Devis non signés : 3 ans. Factures et pièces comptables : 10 ans.',
      'Statistiques de fréquentation : 25 mois au plus.',
    ]),
    H('Destinataires', 2), P('Vos données ne sont ni vendues ni cédées. Seuls y ont accès ' + NOM + ' et les prestataires techniques strictement nécessaires (hébergeur, [à compléter : Fluent Forms, sur le serveur du site]), qui agissent pour son compte.'),
    H('Vos droits', 2), P('Vous disposez d’un droit d’accès, de rectification, d’effacement, de limitation, d’opposition et de portabilité. Pour les exercer, écrivez à ' + MAIL + '. Vous pouvez aussi adresser une réclamation à la CNIL (cnil.fr).'),
  ]) },
  { slug: 'cookies', titre: 'Cookies', markup: texte('Cookies', 'Ce que ce site dépose, ou ne dépose pas, sur votre appareil.', [
    H('Par défaut : aucun cookie de suivi', 2), P('Ce site ne dépose aucun cookie publicitaire ni de réseau social. Les seuls cookies techniques servent à l’administration du site et ne concernent pas les visiteurs.'),
    H('Mesure d’audience', 2), P('La fréquentation est mesurée sans cookie et de façon anonyme, dans les conditions prévues par la CNIL pour être dispensée de consentement. [à compléter : outil utilisé, ou supprimer ce paragraphe]'),
    H('Contenus extérieurs', 2), P('[à compléter : si une carte, une vidéo ou un outil de réservation extérieur est intégré, le nommer ici, ainsi que le bandeau de consentement utilisé. Sinon, supprimer ce paragraphe.]'),
  ]) },
  { slug: 'accessibilite', titre: 'Accessibilité', markup: texte('Accessibilité', 'Notre engagement pour un site utilisable par tous.', [
    P('Ce site a été conçu pour respecter les principales règles d’accessibilité (niveau AA des recommandations internationales WCAG) : contrastes suffisants, navigation complète au clavier, textes alternatifs sur les images, animations désactivables.'),
    H('Un problème ?', 2), P('Si un contenu vous est inaccessible, écrivez-nous à ' + MAIL + ' : nous vous répondrons et vous transmettrons l’information sous une autre forme.'),
  ]) },
];

/* ----- Les cinq parcours : ce que le visiteur vient faire décide de l'accueil et des pages ----- */
// Source : parcours.json (questions, ordre des sections, preuves). Chaque parcours propose plusieurs
// ouvertures : on en choisit une différente d'un site à l'autre (voir registre.py).

const merci = page('merci', 'Merci', sec('merci-suite'));
// La bande de confiance, avec les preuves propres à chaque parcours (parcours.json, « preuves »).
const NOTE = ['avis', 'Note Google', 'À n’afficher que si elle est réelle'];
const confiance = {
  urgence: [L.confiance([['prix', 'Prix annoncé avant de commencer', 'Devis signé dès le premier euro'], ['delai', 'Intervention rapide', '[Délai] dans [votre secteur]'], ['garantie', 'Assurance décennale', 'Attestation sur demande'], NOTE])],
  reservation: [L.confiance([NOTE, ['equipe', '[x] séances par an', 'Depuis [année]'], ['prix', 'Prix affichés', 'Ce qui est compris, écrit'], ['delai', 'Réponse sous 24 h', 'Créneaux proposés rapidement']])],
  commerce: [L.confiance([NOTE, ['delai', 'Ouvert aujourd’hui', 'Horaires à jour dans Mon entreprise'], ['local', 'Produits locaux', '[Fait maison, labels…]'], ['plan', 'Facile d’accès', '[Parking, transports]']])],
};
// L'accueil : l'ouverture choisie, puis le reste. Le reste est calculé pour chaque fond d'ouverture,
// pour que le rythme des couleurs reste juste quelle que soit l'ouverture.
const OUVERTURES = {};
const accueil = (ouvertures, ...reste) => {
  const r = {};
  ouvertures.forEach((o) => {
    if (!OUVERTURES[o]) OUVERTURES[o] = { titre: S[o].title, fond: fondDe(sec(o)[0]), markup: serialize(sec(o)) };
    const f = OUVERTURES[o].fond;
    if (!r[f]) r[f] = serialize(rythme([...sec(o), ...reste.flat()]).slice(sec(o).length));
  });
  return { slug: 'accueil', titre: 'Accueil', ouvertures, reste: r };
};

const KITS = {
  urgence: {
    titre: 'Urgence et dépannage',
    pour: 'Plombier, serrurier, électricien, vitrier, dépannage',
    question: 'Qui peut venir vite, et combien ça coûte ?',
    cta: 'Être rappelé', page_cta: 'contact', page_personne: 'a-propos', page_faq: '', blog: false, mobile: 'barre',
    liens: { services: 'depannage', realisations: 'depannage', 'a-propos': 'a-propos', blog: 'depannage', faq: 'depannage', tarifs: 'tarifs' },
    pages: [
      accueil(['ouverture-deux-portes', 'ouverture-demande', 'hero-banniere'], confiance.urgence, sec('tarifs-liste'), sec('valeurs'), sec('etapes'), sec('avis-note'), sec('zone-liste'), sec('trois-cartes-photos'), sec('faq'), sec('bandeau-cta')),
      page('depannage', 'Dépannage', tete('Dépannage', 'Les pannes que nous réglons le plus souvent, avec le prix annoncé avant de commencer.'), detail, sec('tarifs-liste'), sec('etapes'), sec('bandeau-cta')),
      page('tarifs', 'Tarifs', tete('Nos tarifs', 'Les prix de nos interventions courantes, annoncés avant de commencer, et ce qu’ils comprennent.'), sec('tarifs-tableau'), sec('prix-compris'), sec('bandeau-cta')),
      page('zone-intervention', 'Zone d’intervention', tete('Zone d’intervention', 'Les communes où nous intervenons, et le délai habituel pour chacune.'), sec('zone-plan'), sec('bandeau-cta')),
      page('a-propos', 'Qui sommes-nous', teteP('Qui sommes-nous', 'Qui vient chez vous, depuis quand, et nos engagements.', false), sec('dirigeant'), sec('equipe-photo'), sec('documents-garanties'), sec('bandeau-cta')),
      page('contact', 'Contact', tete('Être rappelé', 'Laissez votre numéro : nous vous rappelons. Pour une urgence, appelez directement.', false), sec('formulaire'), sec('coordonnees-carte')),
      merci,
    ],
  },
  projet: {
    titre: 'Projet sur devis',
    pour: 'Métallier, menuisier, paysagiste, cuisiniste, maçon',
    question: 'Est-ce qu’ils savent faire mon projet, et à quel prix ?',
    cta: 'Demander un devis', page_cta: 'devis', page_personne: 'a-propos', page_faq: '', blog: false, mobile: 'bouton',
    liens: { services: 'savoir-faire', realisations: 'realisations', 'a-propos': 'a-propos', blog: 'realisations', faq: 'devis' },
    pages: [
      accueil(['accueil-photo', 'ouverture-mosaique', 'ouverture-carte', 'ouverture-avant-apres', 'ouverture-decoupe', 'hero-banniere'], sec('bande-confiance'), sec('trois-cartes-photos'), sec('realisations'), sec('qualifications'), sec('etapes'), sec('temoignages'), sec('zone-liste'), sec('bandeau-cta')),
      page('savoir-faire', 'Savoir-faire', tete('Notre savoir-faire', 'Ce que vous fabriquez ou réalisez, et pour qui : particuliers, professionnels, collectivités.'), detail, sec('service-alterne'), sec('etapes'), sec('logos'), sec('bandeau-cta')),
      page('realisations', 'Réalisations', tete('Nos réalisations', 'Quelques chantiers récents, avec la demande du client et la solution apportée.'), sec('realisations-galerie'), sec('realisation-racontee'), sec('bandeau-cta')),
      page('zone-intervention', 'Zone d’intervention', tete('Zone d’intervention', 'Les villes et le secteur où nous intervenons, et nos délais de déplacement.'), sec('zone-plan'), sec('bandeau-cta')),
      page('a-propos', 'L’entreprise', teteP('L’entreprise', 'Votre histoire en une phrase : depuis quand, combien vous êtes, ce qui vous distingue.', false), sec('dirigeant'), sec('equipe-photo'), sec('documents-garanties'), sec('bandeau-cta')),
      page('devis', 'Devis', tete('Demander un devis', 'Décrivez votre projet : nous revenons vers vous sous 48 heures.', false), sec('preparez-demande'), sec('formulaire-etapes'), sec('coordonnees-carte')),
      merci,
    ],
  },
  reservation: {
    titre: 'Réservation d’une prestation',
    pour: 'Photographe, coach, esthéticienne, moniteur, guide',
    question: 'Est-ce que ça me plaît, combien, et quand ?',
    cta: 'Réserver', page_cta: 'reserver', page_personne: 'a-propos', page_faq: 'faq', blog: true, mobile: 'bouton',
    liens: { services: 'prestations', realisations: 'portfolio', 'a-propos': 'a-propos', blog: 'blog', tarifs: 'tarifs' },
    pages: [
      accueil(['choix-prestation', 'ouverture-eventail', 'hero-banniere', 'accueil-photo'], confiance.reservation, sec('galerie'), sec('avis-note'), sec('dirigeant'), sec('lieux'), sec('etapes-images'), sec('tarifs-cartes'), sec('faq'), sec('bandeau-cta')),
      page('prestations', 'Prestations', tete('Nos prestations', 'Une phrase qui résume l’ensemble de votre offre et à qui elle s’adresse.'), detail, sec('service-alterne'), sec('ce-que-vous-recevez'), sec('bandeau-cta')),
      page('portfolio', 'Portfolio', tete('Portfolio', 'Le travail en images : choisissez une photo pour l’agrandir.'), sec('galerie-agrandir'), sec('bandeau-cta')),
      page('tarifs', 'Tarifs', tete('Tarifs', 'Des prix clairs avant de réserver : choisissez la formule qui vous convient.'), sec('tarifs-cartes'), sec('prix-compris'), sec('carte-cadeau'), sec('bandeau-cta')),
      page('a-propos', 'À propos', teteP('À propos', 'Qui vous êtes, en une phrase : ce qui rassure avant de réserver.', false), sec('dirigeant'), sec('valeurs'), sec('bandeau-cta')),
      page('faq', 'Questions fréquentes', tete('Questions fréquentes', 'Les réponses aux questions que l’on nous pose avant de réserver.', false), sec('faq-recherche'), sec('bandeau-cta')),
      page('reserver', 'Réserver', tete('Réserver', 'Choisissez votre prestation et une date : nous vous confirmons le créneau rapidement.', false), sec('formulaire-reservation'), sec('coordonnees-carte')),
      merci,
      { slug: 'blog', titre: 'Blog', markup: '' },
    ],
  },
  conseil: {
    titre: 'Conseil et profession libérale',
    pour: 'Avocat, expert-comptable, ostéopathe, architecte, notaire',
    question: 'Est-ce le bon professionnel pour ma situation, et combien ?',
    cta: 'Prendre rendez-vous', page_cta: 'rendez-vous', page_personne: 'le-cabinet', page_faq: 'faq', blog: false, mobile: 'bouton',
    liens: { services: 'domaines-intervention', realisations: 'domaines-intervention', 'a-propos': 'le-cabinet', blog: 'le-cabinet', tarifs: 'honoraires' },
    // Pas de témoignages ni de note Google : règles de communication des professions réglementées.
    pages: [
      accueil(['hero-image', 'accueil-photo', 'hero-banniere'], sec('faits-icones'), sec('trois-cartes'), sec('equipe'), sec('etapes'), sec('etapes-prix'), sec('faq'), sec('coordonnees-carte'), sec('bandeau-cta')),
      page('domaines-intervention', 'Domaines d’intervention', tete('Domaines d’intervention', 'Les situations dans lesquelles vous accompagnez vos clients ou patients, décrites simplement.'), detail, sec('service-alterne'), sec('bandeau-cta')),
      page('honoraires', 'Honoraires', tete('Honoraires', 'Des honoraires transparents, communiqués avant tout engagement.'), sec('tarifs-tableau'), sec('prix-compris'), sec('bandeau-cta')),
      page('le-cabinet', 'Le cabinet', teteP('Le cabinet', 'Le cabinet, son équipe et sa façon de travailler.', false), sec('dirigeant'), sec('equipe'), sec('valeurs'), sec('contact')),
      page('faq', 'Questions fréquentes', tete('Questions fréquentes', 'Les réponses aux questions que l’on nous pose avant un premier rendez-vous.', false), sec('faq-recherche'), sec('bandeau-cta')),
      page('rendez-vous', 'Rendez-vous', tete('Prendre rendez-vous', 'En ligne, par téléphone ou par e-mail : choisissez ce qui vous convient.', false), sec('formulaire-contact'), sec('coordonnees-carte')),
      merci,
    ],
  },
  commerce: {
    titre: 'Commerce et lieu à visiter',
    pour: 'Restaurant, boulangerie, boutique, bar, fleuriste',
    question: 'Est-ce ouvert, qu’est-ce qu’on y trouve, et comment venir ?',
    cta: 'Réserver', page_cta: 'reserver', page_personne: 'le-lieu', page_faq: '', blog: false, mobile: 'barre',
    liens: { services: 'carte', realisations: 'le-lieu', 'a-propos': 'le-lieu', blog: 'le-lieu', tarifs: 'carte', contact: 'venir', faq: 'venir' },
    pages: [
      accueil(['hero-banniere', 'ouverture-eventail', 'accueil-photo'], confiance.commerce, sec('tarifs-liste'), sec('dirigeant'), sec('galerie'), sec('avis-note'), sec('coordonnees-carte'), sec('bandeau-cta')),
      page('carte', 'La carte', tete('La carte', 'Ce que l’on trouve chez nous, avec les prix. Produits de saison selon les arrivages.'), sec('tarifs-liste'), sec('tarifs-tableau'), sec('bandeau-cta')),
      page('le-lieu', 'Le lieu', teteP('Le lieu', 'L’histoire du lieu et des personnes qui le font vivre.', false), sec('dirigeant'), sec('galerie-agrandir'), sec('valeurs'), sec('bandeau-cta')),
      page('venir', 'Venir', tete('Venir', 'L’adresse, les horaires, le stationnement et l’accès.', false), sec('coordonnees-carte'), sec('horaires')),
      page('reserver', 'Réserver', tete('Réserver', 'Indiquez le jour, l’heure et le nombre de personnes : nous vous confirmons rapidement.', false), sec('formulaire-reservation'), sec('coordonnees-carte')),
      merci,
    ],
  },
};
// Sites installés avant les parcours : leur ancien kit garde ses liens.
const ANCIENS = { prestataire: 'reservation', artisan: 'projet', liberal: 'conseil' };

/* ----- Modèles de page : catalogue du kit sur mesure et modèles proposés à la création d'une page ----- */

const T = '{{TITRE}}';
const MODELES = {
  service: { titre: 'Page de service', desc: 'Un service raconté dans l’ordre où le visiteur se pose ses questions : ce que c’est, ce que ça change, quel modèle, les réalisations, le déroulé et le prix, les questions, l’action.', markup: serialize(rythme([teteP(T, 'Ce que c’est, pour qui, le prix de départ et le délai, en deux phrases.'), sec('benefices-photos'), sec('modeles-cartes'), sec('realisations-service'), sec('etapes-prix'), sec('faq'), sec('pages-liees'), sec('bandeau-cta')].flat())) },
  simple: { titre: 'Page simple', desc: 'Titre, introduction et un bloc de texte libre.', markup: serialize(rythme([tete(T, 'Une phrase d’introduction qui résume la page.', false), Section('br-section--tight', [Box('br-legal', [P('Votre texte ici. Utilisez des intertitres pour découper le contenu.')])])].flat())) },
  tarifs: { titre: 'Page de tarifs', desc: 'Formules en cartes, tableau des prestations, appel à l’action.', markup: serialize(rythme([tete(T, 'Des prix clairs avant de réserver.'), sec('tarifs-cartes'), sec('tarifs-tableau'), sec('bandeau-cta')].flat())) },
  realisations: { titre: 'Page de réalisations', desc: 'Toutes les réalisations publiées, avec filtres par catégorie, puis un avant / après.', markup: serialize(rythme([tete(T, 'Quelques réalisations récentes, avec la demande du client et la solution apportée.'), sec('realisations-toutes'), sec('avant-apres'), sec('bandeau-cta')].flat())) },
  equipe: { titre: 'Page équipe', desc: 'En-tête avec la photo de la page, présentation du dirigeant, de l’équipe et des valeurs.', markup: serialize(rythme([teteP(T, 'Les personnes qui vous accompagnent.', false), sec('dirigeant'), sec('equipe'), sec('valeurs'), sec('bandeau-cta')].flat())) },
  faq: { titre: 'Page FAQ', desc: 'Questions fréquentes en accordéon.', markup: serialize(rythme([tete(T, 'Les réponses aux questions que l’on nous pose le plus souvent.', false), sec('faq'), sec('bandeau-cta')].flat())) },
  zone: { titre: 'Page zone d’intervention', desc: 'Villes couvertes et coordonnées.', markup: serialize(rythme([tete(T, 'Les villes et le secteur où nous intervenons.'), sec('zone-carte'), sec('bandeau-cta')].flat())) },
  avis: { titre: 'Page avis clients', desc: 'Témoignages et chiffres clés.', markup: serialize(rythme([tete(T, 'Ce que nos clients disent de notre travail.'), sec('temoignages'), sec('chiffres-cles'), sec('bandeau-cta')].flat())) },
  atterrissage: { titre: 'Page d’atterrissage (publicité)', desc: 'Pour Google Ads : un service, une action, sans menu. Exclue de Google automatiquement.', markup: serialize(rythme([
    Section('br-hero br-atterrissage', [L.cb('core/columns', { verticalAlignment: 'center', className: 'br-split' }, [
      L.cb('core/column', { verticalAlignment: 'center', width: '56%' }, [
        Label('Votre ville et alentours'),
        H(T, 1, null, { fontSize: 'huge' }),
        Lead('Reprenez la promesse de l’annonce mot pour mot : le visiteur doit retrouver tout de suite ce qu’il a cliqué.'),
        MainBtns(),
        P('Ou appelez directement le [briise_telephone].', 'br-muted'),
      ]),
      L.cb('core/column', { verticalAlignment: 'center', width: '44%' }, [L.cb('core/image', { url: '{{IMG:portrait}}', alt: 'Photo à remplacer : le service en situation', aspectRatio: '4/5', scale: 'cover', sizeSlug: 'full', linkDestination: 'none', className: 'is-style-br-arrondi' })]),
    ])]),
    sec('chiffres-cles'), sec('etapes'), sec('temoignages'), sec('faq'), sec('formulaire'),
  ].flat())) },
  merci: { titre: 'Page de remerciement', desc: 'Après l’envoi d’un formulaire : la suite et ses délais, le téléphone, de quoi patienter. Exclue de Google automatiquement ; à choisir dans Mon entreprise > Fonctions > Formulaires (réglée seule à l’import).', markup: serialize(rythme([sec('merci-suite')].flat())) },
  contact: { titre: 'Page contact', desc: 'Formulaire de contact, coordonnées et horaires.', markup: serialize(rythme([tete(T, 'Écrivez-nous ou appelez-nous : nous répondons rapidement.', false), sec('formulaire-contact'), sec('coordonnees-carte')].flat())) },
};

// Deux fichiers : kits.json (modèles et pages légales, lu dans l'éditeur) reste léger ;
// parcours.json (pages complètes des parcours) n'est lu qu'à l'écran Démarrage.
const liens = Object.fromEntries(Object.entries(KITS).map(([k, v]) => [k, v.liens]));
require('fs').writeFileSync(require('path').join(__dirname, '..', '..', 'inc', 'kits.json'), JSON.stringify({ liens, anciens: ANCIENS, legales, modeles: MODELES }));
require('fs').writeFileSync(require('path').join(__dirname, '..', '..', 'inc', 'parcours.json'), JSON.stringify({ kits: KITS, ouvertures: OUVERTURES }));
console.log(Object.keys(KITS).map((k) => k + ':' + KITS[k].pages.length).join(' '), '+', Object.keys(OUVERTURES).length, 'ouvertures +', legales.length, 'légales');
