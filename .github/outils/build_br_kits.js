// Démarrage Briise : site de base, modèles de page et pages légales.
const L = require('./build_br_sections.js');
const { S, cb, serialize, P, H, Label, Lead, Muted, Section, Box, Head, Short, MainBtns, List, fr } = L;

const sec = (slug) => S[slug].blocks;

/* Rythme : deux sections voisines n'ont jamais le même fond clair. Le fond de la seconde passe
   à une teinte voisine (fond, surface, nuance) différente de ses deux voisines. Les bandes sombres
   et les photos ne bougent pas ; une tête de page peut précéder une section du même fond. */
const { cloneBlock } = require('@wordpress/blocks');
const CLAIRS = ['fond', 'surface', 'nuance'];
// La bande de confiance chevauche la section du dessus : elle ne compte pas dans le rythme.
// Les versions « bande » et « pastilles » sont des sections ordinaires : elles comptent.
const passe = (b) => /br-confiance-zone/.test(b.attributes.className || '') && !/br-engagements--(bande|pastilles)/.test(b.attributes.className || '');
const fondDe = (b) => (b.name === 'core/cover' ? 'photo' : /br-engagements--bande/.test(b.attributes.className || '') ? 'sombre' : (b.attributes.backgroundColor || 'fond'));
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
/* Rythme des titres : deux sections titrées qui se suivent n'ont jamais leur titre au même endroit
   (panneau « Titre », classes br-titre--…). Une section qui a déjà sa position la garde si elle
   diffère de la précédente ; sinon elle prend la suivante d'une rotation. « Côte à côte » ne va
   qu'à un titre suivi d'une phrase d'introduction. La tête de page (titre principal) ne compte pas.
   À utiliser aussi pour les fichiers de site : rythmeTitres(blocs, depart), « depart » change
   l'ordre de la rotation d'un site à l'autre. */
const POSITIONS_TITRE = ['gauche', 'centre', 'cote', 'filet', 'droite', 'marge-gauche'];
const classesDe = (b) => String(b.attributes.className || '').split(' ').filter(Boolean);
const enTeteDe = (b) => (b.innerBlocks || []).find((x) => classesDe(x).some((c) => c === 'br-head' || c === 'br-section-head'));
// Les règles des positions permises (inc/familles.json, « reglesTitres »), les mêmes que dans l'éditeur.
const REGLES_TITRES = require('../../inc/familles.json').reglesTitres || {};
const analyseSection = (b) => {
  const a = { classes: [], textes: [], titre: '', phrase: false };
  (function parcourir(x) {
    classesDe(x).forEach((c) => a.classes.push(c));
    if (x.name === 'core/shortcode') a.textes.push(String(x.attributes.text || ''));
    (x.innerBlocks || []).forEach(parcourir);
  }(b));
  const tete = enTeteDe(b);
  (tete ? tete.innerBlocks : []).forEach((x) => {
    if (x.name === 'core/heading' && !a.titre) a.titre = String(x.attributes.content || '').replace(/<[^>]+>/g, '').trim();
    if (classesDe(x).includes('br-lead')) a.phrase = true;
  });
  return a;
};
const positionPermise = (p, a) => {
  const r = REGLES_TITRES[p];
  if (!r) return true;
  if ((r.phrase === 'requise' && !a.phrase) || (r.phrase === 'interdite' && a.phrase)) return false;
  if (r.titre_max && a.titre.length > r.titre_max) return false;
  const contient = (m) => (m.startsWith('br-') ? a.classes.includes(m) : a.textes.some((t) => t.includes(m)));
  // Liste blanche : sans l'un de ces contenus, la position n'est pas permise.
  if (r.seulement_si && !r.seulement_si.some(contient)) return false;
  return !(r.contenus || []).some(contient);
};
const rythmeTitres = (blocks, depart = 0) => {
  let prec = null;
  let tour = depart;
  return blocks.map((b) => {
    const cl = classesDe(b);
    const enTete = cl.includes('br-section') && !cl.includes('br-page-head') ? enTeteDe(b) : null;
    if (!enTete) {
      prec = null;
      return b;
    }
    const a = analyseSection(b);
    const actuelle = (cl.find((c) => c.startsWith('br-titre--')) || '').slice('br-titre--'.length);
    // Une position déjà choisie reste, si elle convient et diffère de la section précédente.
    if (actuelle && actuelle !== prec && positionPermise(actuelle, a)) {
      prec = actuelle;
      return b;
    }
    let choix = 'gauche';
    for (let k = 0; k < POSITIONS_TITRE.length; k++) {
      const p = POSITIONS_TITRE[(tour + k) % POSITIONS_TITRE.length];
      if (p === prec || !positionPermise(p, a)) continue;
      choix = p;
      tour = (tour + k + 1) % POSITIONS_TITRE.length;
      break;
    }
    prec = choix;
    return cloneBlock(b, { className: cl.filter((c) => !c.startsWith('br-titre--')).concat('br-titre--' + choix).join(' ') });
  });
};
// Les deux rythmes ensemble : les fonds, puis les titres. Sans départ donné, chaque page commence
// ailleurs dans la rotation : deux pages ne s'ouvrent pas sur la même place de titre.
let pageSuivante = 0;
const rythmeTout = (blocks, depart) => rythmeTitres(rythme(blocks), depart === undefined ? (pageSuivante++ * 2) % POSITIONS_TITRE.length : depart);

const tete = (titre, chapo, bouton = true) => [Section('br-page-head', [Head([
  Short('[briise_fil_ariane]'), H(titre, 1, null, { fontSize: 'huge' }), Lead(chapo), ...(bouton ? [MainBtns()] : []),
])])];
// Pages de service et à propos : en-tête avec la photo de la page (image mise en avant) à côté du texte.
const teteP = (titre, chapo, bouton = true) => [L.teteSplit(titre, chapo, bouton ? L.CTA_LABEL : false)];
// Sur la page des services : la liste de chaque page de service (vide tant qu'il n'y en a pas).
const detail = [Section('br-section-liees', [L.cb('core/heading', { content: 'Chaque service en détail', level: 2 }), Short('[briise_pages_liees]')], { backgroundColor: 'surface' })];
const page = (slug, titre, ...parts) => ({ slug, titre, markup: serialize(rythmeTout(parts.flat())) });

/* ----- Pages légales, créées pour tous les sites ----- */

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

/* ----- Démarrage : toute la bibliothèque est ouverte à tous les métiers -----
   Un site client se compose section par section dans le fichier de site préparé par l'agence
   (catalogue : .github/outils/catalogue-sections.md ; grille des questions du visiteur : parcours.json).
   Sans fichier, Démarrage crée un site de base : l'accueil (une ouverture au choix, puis l'appel à
   l'action), la page d'action, la page merci et les pages légales. On le complète ensuite avec les
   sections de l'éditeur. */

const merci = page('merci', 'Merci', sec('merci-suite'));
const OUVERTURES = {};
// L'accueil : l'ouverture choisie, puis la suite, calculée pour chaque fond d'ouverture.
const accueil = (ouvertures, ...reste) => {
  const r = {};
  ouvertures.forEach((o) => {
    if (!OUVERTURES[o]) OUVERTURES[o] = { titre: S[o].title, fond: fondDe(sec(o)[0]), markup: serialize(sec(o)) };
    const f = OUVERTURES[o].fond;
    if (!r[f]) r[f] = serialize(rythmeTout([...sec(o), ...reste.flat()]).slice(sec(o).length));
  });
  return { slug: 'accueil', titre: 'Accueil', ouvertures, reste: r };
};
// Toutes les ouvertures de la bibliothèque, pour tous les métiers.
const TOUTES = Object.keys(S).filter((k) => S[k].cat === 'ouverture' && !/^en-tete/.test(k));

const KITS = {
  base: {
    titre: 'Site de base',
    cta: 'Nous contacter', page_cta: 'contact', page_personne: '', page_faq: '', blog: false, mobile: 'bouton', parent_services: '',
    liens: { services: 'accueil', realisations: 'accueil', 'a-propos': 'accueil', blog: 'accueil', faq: 'contact', tarifs: 'contact', devis: 'contact' },
    pages: [
      accueil(TOUTES, sec('bandeau-cta')),
      page('contact', 'Contact', tete('Nous contacter', 'Écrivez-nous ou appelez-nous : nous vous répondons rapidement.', false), sec('formulaire-contact'), sec('coordonnees-carte')),
      merci,
    ],
  },
};
// Sites installés avec les anciens kits : leurs liens restent valables dans les modèles de page.
const ANCIENS_LIENS = {
  prestataire: { services: 'prestations', realisations: 'prestations', 'a-propos': 'a-propos', blog: 'blog' },
  artisan: { services: 'savoir-faire', realisations: 'realisations', 'a-propos': 'a-propos', blog: 'realisations' },
  liberal: { services: 'domaines-intervention', realisations: 'domaines-intervention', 'a-propos': 'le-cabinet', blog: 'le-cabinet' },
};

/* ----- Modèles de page : catalogue du kit sur mesure et modèles proposés à la création d'une page ----- */

const T = '{{TITRE}}';
const MODELES = {
  service: { titre: 'Page de service', desc: 'Un service raconté dans l’ordre où le visiteur se pose ses questions : ce que c’est, ce que ça change, quel modèle, les réalisations, le déroulé et le prix, les questions, l’action.', markup: serialize(rythmeTout([teteP(T, 'Ce que c’est, pour qui, le prix de départ et le délai, en deux phrases.'), sec('benefices-photos'), sec('modeles-cartes'), sec('realisations-service'), sec('etapes-prix'), sec('faq'), sec('pages-liees'), sec('bandeau-cta')].flat())) },
  simple: { titre: 'Page simple', desc: 'Titre, introduction et un bloc de texte libre.', markup: serialize(rythmeTout([tete(T, 'Une phrase d’introduction qui résume la page.', false), Section('br-section--tight', [Box('br-legal', [P('Votre texte ici. Utilisez des intertitres pour découper le contenu.')])])].flat())) },
  tarifs: { titre: 'Page de tarifs', desc: 'Formules en cartes, tableau des prestations, appel à l’action.', markup: serialize(rythmeTout([tete(T, 'Des prix clairs avant de réserver.'), sec('tarifs-cartes'), sec('tarifs-tableau'), sec('bandeau-cta')].flat())) },
  realisations: { titre: 'Page de réalisations', desc: 'Toutes les réalisations publiées, avec filtres par catégorie, puis un avant / après.', markup: serialize(rythmeTout([tete(T, 'Quelques réalisations récentes, avec la demande du client et la solution apportée.'), sec('realisations-toutes'), sec('avant-apres'), sec('bandeau-cta')].flat())) },
  equipe: { titre: 'Page équipe', desc: 'En-tête avec la photo de la page, présentation du dirigeant, de l’équipe et des valeurs.', markup: serialize(rythmeTout([teteP(T, 'Les personnes qui vous accompagnent.', false), sec('dirigeant'), sec('equipe'), sec('valeurs'), sec('bandeau-cta')].flat())) },
  faq: { titre: 'Page FAQ', desc: 'Questions fréquentes en accordéon.', markup: serialize(rythmeTout([tete(T, 'Les réponses aux questions que l’on nous pose le plus souvent.', false), sec('faq'), sec('bandeau-cta')].flat())) },
  zone: { titre: 'Page zone d’intervention', desc: 'Villes couvertes et coordonnées.', markup: serialize(rythmeTout([tete(T, 'Les villes et le secteur où nous intervenons.'), sec('zone-carte'), sec('bandeau-cta')].flat())) },
  avis: { titre: 'Page avis clients', desc: 'Témoignages et chiffres clés.', markup: serialize(rythmeTout([tete(T, 'Ce que nos clients disent de notre travail.'), sec('avis'), sec('chiffres'), sec('bandeau-cta')].flat())) },
  atterrissage: { titre: 'Page d’atterrissage (publicité)', desc: 'Pour Google Ads : un service, une action, sans menu. Exclue de Google automatiquement.', markup: serialize(rythmeTout([
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
    sec('chiffres'), sec('etapes'), sec('avis'), sec('faq'), sec('formulaire'),
  ].flat())) },
  merci: { titre: 'Page de remerciement', desc: 'Après l’envoi d’un formulaire : la suite et ses délais, le téléphone, de quoi patienter. Exclue de Google automatiquement ; à choisir dans Mon entreprise > Fonctions > Formulaires (réglée seule à l’import).', markup: serialize(rythmeTout([sec('merci-suite')].flat())) },
  contact: { titre: 'Page contact', desc: 'Formulaire de contact, coordonnées et horaires.', markup: serialize(rythmeTout([tete(T, 'Écrivez-nous ou appelez-nous : nous répondons rapidement.', false), sec('formulaire-contact'), sec('coordonnees-carte')].flat())) },
};

// Deux fichiers : kits.json (modèles et pages légales, lu dans l'éditeur) reste léger ;
module.exports = { rythme, rythmeTitres, rythmeTout, POSITIONS_TITRE, positionPermise, analyseSection };
// Pour le catalogue : les positions du titre permises pour chaque section qui a un titre en haut.
const TOUTES_POSITIONS = Object.keys(require('../../inc/familles.json').titres).filter((p) => p !== 'site');
const permises = {};
Object.keys(S).forEach((k) => {
  const b = S[k].blocks[0];
  if (!b || !classesDe(b).includes('br-section') || classesDe(b).includes('br-page-head') || !enTeteDe(b)) return;
  const an = analyseSection(b);
  permises[k] = TOUTES_POSITIONS.filter((p) => positionPermise(p, an));
});
require('fs').writeFileSync(require('path').join(__dirname, 'build', 'titres_permis.json'), JSON.stringify(permises, null, 1));
// demarrage.json (site de base et ouvertures) n'est lu qu'à l'écran Démarrage.
const liens = { ...ANCIENS_LIENS, base: KITS.base.liens };
require('fs').writeFileSync(require('path').join(__dirname, '..', '..', 'inc', 'kits.json'), JSON.stringify({ liens, legales, modeles: MODELES }));
require('fs').writeFileSync(require('path').join(__dirname, '..', '..', 'inc', 'demarrage.json'), JSON.stringify({ kits: KITS, ouvertures: OUVERTURES }));
console.log(Object.keys(KITS).map((k) => k + ':' + KITS[k].pages.length).join(' '), '+', Object.keys(OUVERTURES).length, 'ouvertures +', legales.length, 'légales');
