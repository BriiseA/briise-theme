# Briise, thème de base et extension Briise Socle

Thème WordPress à blocs de l'agence Briise pour les sites vitrines d'entreprises locales de services, et son extension **Briise Socle**.

- **Briise Socle** (`extension/briise-socle/`) : le fonctionnement, indépendant du thème. Mon entreprise (coordonnées, horaires, annonces, mentions légales, fonctions), onglet Contrôle, référencement et données structurées, robots.txt et IndexNow, cartes Coordonnées et Zone, codes courts, bandeau d'information, mesure des contacts, mises à jour depuis GitHub, fin de collaboration.
- **Thème Briise** (racine du dépôt) : l'apparence. Ambiances, sections, gabarits, styles de section, import d'un fichier de site et site de base (onglet Démarrage), animations.

Un site Briise utilise les deux. Un site fait avec un autre thème peut n'utiliser que l'extension : il garde Mon entreprise, le contrôle du maillage, le référencement et les cartes (avec une apparence simple), mais pas les sections ni les ambiances. Sans l'extension, le thème s'affiche sans erreur mais sans coordonnées ni référencement, et prévient l'administrateur.
Le cahier des charges complet est dans le document « Thème de base agence : cahier des charges ».

## Principe

Un seul thème pour tous les clients. Un site client ne contient jamais de code propre :
seulement des réglages, des pages composées de sections, une variation de style et ses contenus.
Corriger un défaut dans la base le corrige partout, à la prochaine mise à jour.

## Structure

| Dossier ou fichier | Rôle |
| --- | --- |
| `theme.json` | Couleurs, polices, tailles, espacements et styles globaux |
| `templates/` | Modèles de pages (page, article, blog, 404, page sans titre, fiche de réalisation) |
| `parts/` | En-tête et pied de page |
| `patterns/` | Bibliothèque de 62 sections (`section-*.php`), en-tête, pied de page, blog |
| `assets/images/sections/` | Images de remplacement des sections, à remplacer par les photos du client |
| `assets/js/ux.js` | Menu intelligent, page active, téléphones cliquables, bouton fixe mobile, retour en haut |
| `assets/js/motion.js` | Animations d'apparition (coupées si le visiteur le demande) |
| `styles/` | Ambiances (variations de style) |
| `inc/kits.php`, `inc/kits.json`, `inc/demarrage.json` | Démarrage : import d'un fichier de site, site de base, modèles de page |
| `inc/contraste.php` | Avertissement si une couleur modifiée rend un texte illisible |
| `inc/styles-section.php` | Styles de section en un clic et contrôle du rythme des couleurs |
| `inc/socle.php` | Lien avec l'extension : le thème lit ses données, ou des valeurs vides si elle manque |
| `extension/briise-socle/briise-socle.php` | Fichier principal de l'extension |
| `extension/briise-socle/inc/reglages.php`, `admin.php` | Réglages et page « Mon entreprise » |
| `extension/briise-socle/inc/entreprise.php` | Informations, horaires, coordonnées, mentions légales, codes courts |
| `extension/briise-socle/inc/fonctions.php` | Bandeau d'information, blog activable, Search Console, Matomo |
| `extension/briise-socle/inc/seo.php`, `robots.php` | Title, description, Open Graph, noindex, plan du site, données structurées ; robots.txt, IndexNow |
| `extension/briise-socle/inc/menu.php` | Case « Afficher dans le menu » et tenue du menu principal |
| `extension/briise-socle/inc/maillage.php` | Pages liées et onglet Contrôle |
| `extension/briise-socle/inc/cartes.php` | Cartes Coordonnées et Zone, icônes |
| `extension/briise-socle/inc/formulaire.php` | Formulaires de devis et de contact (Fluent Forms) |
| `extension/briise-socle/inc/realisations.php` | Réalisations : fiches, grilles automatiques, filtres, import et export |
| `extension/briise-socle/inc/mises-a-jour.php` | Mises à jour du thème et de l'extension depuis les versions GitHub |
| `extension/briise-socle/inc/depart.php` | Onglet « Fin de collaboration » |
| `.github/outils/` | Scripts de fabrication des sections et des ambiances, catalogue des sections, grille des questions du visiteur, registre des sites (hors thème) |
| `assets/fonts/` | Polices hébergées et leurs licences (toutes sous licence OFL) |

## Ambiances (variations de style)

Apparence > Éditeur > Styles > Parcourir les styles. Huit ambiances, toutes vérifiées en contraste AA :

| Ambiance | Pour qui | Titres / texte |
| --- | --- | --- |
| Galet (par défaut) | Bien-être, artisans d'art, créatifs | Bricolage Grotesque / Figtree |
| Lumière | Photographes, esthétique, événementiel | Cormorant Garamond / DM Sans |
| Atelier | Bâtiment, garages, artisans du bois | Barlow Condensed / Barlow |
| Acier | Métallerie, serrurerie, chaudronnerie : gris acier, graphite, rouille | Barlow Condensed / Barlow |
| Cabinet | Avocats, experts-comptables, santé | Source Serif 4 / Source Sans 3 |
| Comptoir | Restaurants, commerces, loisirs | Fredoka / Nunito |
| Galerie | Métiers de l'image et de l'événement (photographes, vidéastes, fleuristes) : fond très clair, rose poudré, framboise | Bricolage Grotesque / Geist |
| Charte du client | Client qui a déjà sa charte graphique | Polices système, à remplacer |

Toutes les ambiances partagent les mêmes noms de couleurs, ce qui permet à chaque section de fonctionner avec chacune :

| Couleur | Rôle |
| --- | --- |
| `fond`, `clair` | Fond de page, fond des cartes |
| `surface`, `nuance` | Fonds de sections |
| `texte`, `texte-doux` | Texte principal, texte secondaire |
| `accent` | Liens au survol, boutons de certaines ambiances |
| `secondaire` | Chiffres, badges |
| `deco` | Formes décoratives, jamais du texte |
| `sombre` | Pied de page et bandeau |

Arrondis et formes : `--wp--custom--rayon--grand|moyen|petit|bouton` et `--wp--custom--forme--blob`, propres à chaque ambiance.

**Couleur du logo du client.** Styles > Couleurs > Palette > Modifier, puis changer `accent`. Si une couleur rend un texte illisible (contraste inférieur à 4,5:1), un avertissement apparaît sur le tableau de bord.

**Réalisations.** Menu « Réalisations » de l'administration (Éditeur compris) : une fiche par réalisation, avec photo principale, galerie (agrandie au clic), « La demande », « Ce que nous avons fait », ville, date, service concerné et catégorie. Les grilles se mettent à jour seules : accueil (trois dernières), page des réalisations (toutes, avec boutons de filtre par catégorie), pages de service (les réalisations du service, section masquée s'il n'y en a pas). Chaque fiche a sa page (`/realisations/escalier-droit-a-saran/`), renvoie vers son service et propose d'autres réalisations du même service. Une fiche de moins de 150 mots reste dans les grilles mais sort de Google et du plan du site ; l'onglet Contrôle la signale. Le nom se règle dans Mon entreprise > Fonctions : Réalisations, Portfolio, Chantiers ou Projets (l'adresse des fiches suit ; la page qui les liste doit porter la même adresse, `/portfolio/` par exemple). Codes courts : `[briise_realisations nombre="3" service="auto" categorie="escalier" filtres="1"]`.

**En-tête de page avec photo.** Titre, fil d'Ariane, introduction et bouton à gauche, photo à droite : c'est l'**image mise en avant** de la page, que le client change sans toucher à la mise en page. La photo s'affiche à peu près à sa taille réelle, sans voile : elle reste nette dès 1 400 px de large, et ses couleurs sont respectées. Sans image, le texte prend toute la largeur. Variante **En-tête de page avec trois photos** (mosaïque : l'image mise en avant et deux photos) quand le client en a trois bonnes. L'ancien bandeau pleine largeur reste disponible (« En-tête bandeau photo pleine largeur ») pour les très grandes photos, 2 400 px au moins. Mon entreprise > Contrôle signale une photo d'en-tête manquante ou trop petite. En-tête avec photo par défaut pour les pages de service et les pages À propos, Équipe ou L'atelier ; en-tête sans photo pour Devis, Contact, FAQ, pages légales et articles.

**Pages de service racontées.** Le modèle « Page de service » suit l'ordre des questions du visiteur : ce que c'est (en-tête), ce que ça change (« Ce que ça change, en photos »), lequel choisir (« Quel modèle choisir, en cartes »), la preuve (réalisations du service), le déroulé et le prix (« Déroulé et prix, en photos »), les questions, l'action. Chaque section porte des photos : jamais plus d'un écran de texte sans image.

**Cache des pages.** Avec une extension de cache (W3 Total Cache, WP Rocket, LiteSpeed Cache, WP Super Cache, WP Fastest Cache, SiteGround Optimizer, Cache Enabler, Breeze, Hummingbird), l'extension Briise Socle vide le cache des pages, une fois par enregistrement, quand un réglage Briise change (Mon entreprise, Apparence, Polices, horaires…), quand le logo, le nom ou le slogan changent, quand le menu, un modèle, l'en-tête, le pied de page ou les styles globaux sont enregistrés, et après la mise à jour du thème Briise ou de l'extension (`extension/briise-socle/inc/cache.php`). Le cache des navigateurs ne se vide pas à distance : dans l'extension de cache, régler la durée de cache des pages HTML à quelques heures, pas à 30 jours.

**Sécurité.** Mon entreprise > Fonctions > « Protections de sécurité », activé par défaut : identifiants de connexion cachés, XML-RPC fermé, en-têtes de sécurité, éditeur de code désactivé, message d'erreur de connexion neutre. L'onglet Contrôle liste ce qui reste à régler avant la mise en ligne (compte « admin », HTTPS, double authentification, mises à jour, extensions désactivées). Cookies : un site Briise n'en dépose aucun ; dès qu'un client ajoute Analytics, Ads, une carte ou une vidéo, installer Complianz (mode d'emploi, étape 10).

**Photos.** Chaque photo JPEG ou PNG envoyée est enregistrée en WebP (Fonctions > Photos en WebP) ; WordPress réduit celles de plus de 2 560 px.

**Banc d'essai.** `.github/outils/banc/lancer.sh` installe un WordPress neuf, importe le site d'exemple Atelier Ferlune (métallerie fictive à Saran) et vérifie tout (blocs, pages, Contrôle, sécurité, accessibilité). Il vérifie aussi les blocs du second site d'exemple, Lison Vautrin (photographe fictive à Olivet, ambiance Galerie, `exemples/build_lison.js`). GitHub le lance à chaque envoi ; une version n'est publiée que s'il est au vert.

**Crédit de l'agence.** Mon entreprise > Fonctions > « Crédit de l'agence en pied de page » : « Site réalisé par Briise » (texte du début modifiable), en petit à côté des mentions légales, lien en nofollow vers briise.fr. Désactivé par défaut, à activer avec l'accord du client ; coupé automatiquement quand on fige les contenus en fin de collaboration.

**Formulaires.** Avec l'extension gratuite Fluent Forms : Mon entreprise > Fonctions > Formulaires > « Créer le formulaire » (devis, contact), ou automatiquement à l'import d'un fichier de site qui utilise la section. Réservation (métiers sur rendez-vous) : la prestation (boutons à choix parmi les services du site, plus « Je ne sais pas encore »), le lieu si des lieux sont indiqués (champ à côté du bouton de création, ou `"reservation_lieux": ["Au studio", "Chez vous"]` dans le fichier de site), la date souhaitée, puis nom, téléphone, e-mail facultatif et un mot facultatif ; `[briise_formulaire type="reservation"]`. Devis : nom, téléphone, e-mail facultatif, commune, projet (liste des services du site, plus « Autre »), description obligatoire ; contact : nom, téléphone, e-mail facultatif, message. Pas de case à cocher : une phrase d'information avec le lien vers la politique de confidentialité. Champ piège contre les robots. E-mail à l'adresse de Mon entreprise (« Répondre » écrit au visiteur), confirmation au visiteur qui l'invite à répondre avec ses photos (l'envoi de fichiers est payant dans Fluent Forms). Les pages utilisent `[briise_formulaire type="devis"]` : sans Fluent Forms, le visiteur voit les boutons Appeler et Écrire. Mesure `briise_contact` à l'envoi réussi seulement. Les feuilles de style du formulaire ne bloquent pas l'affichage, et jQuery passe en bas de page. Autres destinataires des demandes : Mon entreprise > Entreprise, une adresse par ligne (s'ajoutent à l'e-mail de contact pour tous les formulaires Briise). Fluent Forms et FluentSMTP s'installent et s'activent en un clic depuis Mon entreprise > Fonctions > Formulaires. Pour la remise des e-mails : FluentSMTP relié à la boîte du domaine (SPF, DKIM, DMARC). Les demandes restent enregistrées dans Fluent Forms : les supprimer au-delà de la durée annoncée dans la politique de confidentialité (3 ans).

**Réseaux sociaux.** Instagram, Facebook, LinkedIn, fiche Google, TikTok, YouTube et Pinterest (Mon entreprise > Entreprise) s'affichent en icônes dans le pied de page, avec leur nom pour les lecteurs d'écran (Fonctions : « Réseaux sociaux en icônes », décocher pour du texte).

**Cartes Coordonnées et Zone.** Deux sections de la catégorie Contact, colorées par l'ambiance. Elles lisent Mon entreprise : rien n'est tapé deux fois. Champs facultatifs (Mon entreprise > Entreprise, « Cartes Coordonnées et Zone d'intervention ») : une précision sous le téléphone, l'e-mail et l'adresse, un badge par carte, et les secteurs de la zone :

```
# Alpes-Maritimes | Autour de l'atelier
Carros | siège
Nice | et Côte d'Azur
+ Alpes-de-Haute-Provence
```

Sans secteurs, la carte Zone reprend la liste des villes. Dans le fichier de site, ces champs vont dans `entreprise` : `precision_telephone`, `precision_email`, `precision_adresse`, `badge_coord_titre`, `badge_coord_texte`, `badge_zone_titre`, `badge_zone_texte`, `zone_soustitre`, `zone_secteurs` (lignes séparées par `\n`). Icônes : Tabler Icons (MIT), intégrées en SVG.

**Logo.** Mon entreprise > Entreprise > Logo : il remplace le nom en texte dans l'en-tête (le nom reste lu par Google et les lecteurs d'écran). Le pied de page étant sombre, un « logo pour fond foncé » facultatif l'y remplace aussi, dans les pieds Colonnes, Grand titre, Compact et Grand appel (Nom géant garde le nom, c'est son principe) ; sans lui, le nom reste en texte. Sans logo, rien ne change. Dans le fichier de site : `"logo": "briise-logo-sombre", "logo_clair": "briise-logo-clair"`, par le nom du fichier dans la Médiathèque (ou dans la liste `images`). Un logo absent est signalé à l'import ; « Placer les photos de la Médiathèque » le règle une fois déposé, sans remplacer un logo déjà choisi.

**Charte du client.** Partir de l'ambiance « Charte du client » et remplacer ses couleurs par celles de la charte. Pour les polices : les téléverser dans Styles > Typographie > Gérer les polices (fichiers WOFF2, licence web vérifiée), puis les choisir dans Mon entreprise > Apparence > **Polices** : titres, texte et accent. La liste reprend aussi les onze polices livrées avec le thème. Le choix passe devant les polices de l'ambiance et reste en place si l'on change d'ambiance ; « Selon l'ambiance » revient aux polices d'origine. La **police d'accent** s'applique au mot passé au Surlignage dans un titre (case « Mot d'accent en italique ») ; sans elle, ce mot garde la police des titres. Une police d'accent qui n'a qu'une graisse fine n'est pas grossie artificiellement. « Taille du mot d'accent » l'agrandit un peu quand elle paraît plus petite que celle des titres (comme le titre, 108 %, 115 % ou 125 %). Dans le fichier de site : `"polices": { "titres": "Sora", "texte": "Figtree", "accent": "Instrument Serif", "accent_italique": true, "accent_taille": 1.15 }` (taille entre 0.8 et 1.4), par le nom de la police ; une police introuvable est signalée à l'import et celle de l'ambiance reste en place. Les titres en capitales se règlent dans Mon entreprise > Apparence (voir plus bas). Un détail que les réglages ne couvrent pas se règle dans Styles > CSS additionnel : le CSS du thème reste en place, celui du client passe après.

## Démarrer un site client

1. Installer WordPress, téléverser `briise.zip`, activer le thème.
2. Mon entreprise > **Démarrage**, au choix :
   - **importer un fichier de site** : la façon normale. L'agence compose le site du client section par section, dans toute la bibliothèque, et prépare le fichier (pages, textes, référencement, menu, informations, ambiance, apparence) ;
   - **créer un site de base** : l'accueil (une ouverture au choix parmi toutes, puis l'appel à l'action), la page de contact, la page merci et les pages légales, à compléter ensuite avec les sections de l'éditeur. On peut y ajouter des pages faites avec les modèles et une page par service (rangée en sous-menu).
3. Mon entreprise : compléter ce que le fichier n'a pas rempli ; choisir l'en-tête, le pied de page, les cartes et les titres dans Apparence.
4. Remplacer chaque texte et chaque photo d'exemple, puis suivre la checklist de livraison.

**Toutes les sections servent à tous les métiers.** Il n'y a pas de sections « pour artisans » ou « pour photographes » : il y a des sections qui répondent à une question du visiteur, avec un contenu que le client doit pouvoir fournir. Pour composer un site, l'agence part de trois outils (dossier `.github/outils/`) :

| Outil | Rôle |
| --- | --- |
| `parcours.json` | Grille de réflexion : les questions qu'un visiteur se pose selon ce qu'il vient faire (appeler en urgence, demander un devis, réserver, consulter, venir sur place), dans l'ordre, et les preuves qui y répondent. Un client peut relever de plusieurs. |
| `catalogue-sections.md` | Les 83 sections, avec ce que fait chacune et ce dont elle a besoin pour être vraie (photos, prix réels, avis réels, fiches Réalisations, communes…). Produit par `catalogue.py`. |
| `variantes.json`, `registre-sites.json`, `registre.py` | Les pièces qui différencient un site (ambiance, en-tête, ouverture, cartes, titres, pied de page) et les sections qui jouent le même rôle sous une autre forme ; le registre vérifie qu'un nouveau site diffère des précédents. |

Les sites installés avec les anciens kits (prestataire, artisan, profession libérale) gardent leurs liens dans les modèles de page.

Pages en plus, et modèles proposés à la création de chaque nouvelle page : service, page simple, tarifs, réalisations, équipe, FAQ, zone d'intervention, avis clients, page de remerciement, contact. Les pages légales (mentions, confidentialité, cookies, accessibilité) sont toujours créées. Une page dont l'adresse existe déjà n'est jamais modifiée.

**Page d'atterrissage pour la publicité.** Modèle de page « Page d'atterrissage (publicité) », ou `"modele": "atterrissage"` dans le fichier de site. En-tête réduit (nom, téléphone, bouton d'action, sans menu), pied de page réduit (coordonnées et pages légales), bouton d'appel fixe sur mobile. La page est exclue de Google (noindex) et du plan du site : elle sert aux annonces, pas au référencement naturel. Une page dont le contenu reprend le modèle passe d'elle-même sur ce gabarit.

**Menu.** Chaque page a une case « Afficher dans le menu » (colonne de droite de l'éditeur), accessible au client. Une sous-page se range en sous-menu sous sa page parente. Le menu reste modifiable dans Apparence > Éditeur > Navigation.

### Fichier de site

Fichier JSON importé dans Démarrage. Seule la liste `pages` est obligatoire. Dans `entreprise`, `name` et `slogan` deviennent le nom et le slogan du site (logo, onglet du navigateur, pied de page) : ne pas les oublier.

```json
{
  "entreprise": { "name": "Atelier Ferrum", "slogan": "Métallier à Milly-la-Forêt", "type": "HomeAndConstructionBusiness", "telephone": "06 12 34 56 78", "city": "Milly-la-Forêt" },
  "legal": { "raison_sociale": "Atelier Ferrum SARL", "siren": "123 456 789" },
  "annonces": { "jours": { "1": { "ouvert": true, "plages": [["08:00", "12:00"], ["13:30", "18:00"]] } } },
  "ambiance": "atelier",
  "couleurs": { "accent": "#a83d0c" },
  "entete": "capsule", "pied": "grand-titre", "mobile": "barre", "cartes": "photo-haut", "titres": "tete-lien",
  "cta": "devis", "cta_label": "Demander un devis", "accueil": "accueil", "faq": "faq", "personne": "a-propos", "blog": "",
  "statut": "publish",
  "pages": [
    { "slug": "accueil", "titre": "Accueil", "markup": "<!-- wp:… -->", "seo_titre": "…", "seo_description": "…" },
    { "slug": "savoir-faire", "titre": "Savoir-faire", "modele": "service", "menu": true },
    { "slug": "escaliers", "titre": "Escaliers sur mesure", "parent": "savoir-faire", "modele": "service", "menu": true,
      "menu_description": "Droits, quart tournants, hélicoïdaux" }
  ]
}
```

`entete`, `pied` et `mobile` (facultatifs) règlent la forme de l'en-tête, du pied de page et du bas d'écran sur téléphone, comme Mon entreprise > Apparence (voir ci-dessous).

Dans `markup`, les repères `{{CTA}}`, `{{CTA_LABEL}}`, `{{URL:slug}}`, `{{IMG:nom}}` et `{{TITRE}}` sont remplacés à l'import, ainsi que `{{SERVICE:n}}` (nom du n-ième service) et `{{URL:service-n}}` (sa page). Les services sont les sous-pages de la page des services, dans l'ordre du fichier. `"legales": false` évite la création des pages légales. `reservation_lieux` (facultatif) : les lieux proposés dans le formulaire de réservation. Photos : déposer les photos du client dans Médias avant l'import, nommées comme les repères (`naissance-lange.jpg` pour `{{IMG:naissance-lange}}`) ; chaque repère prend la photo du même nom, reliée à la Médiathèque. Déposées après l'import : Mon entreprise > Démarrage > « Placer les photos de la Médiathèque ». Dans `realisations` comme dans `pages`, la clé `image` donne la photo principale (image mise en avant) : celle de l'en-tête avec photo d'une page de service, ou de la vignette d'une fiche. `images` (facultatif) : des adresses de photos hors Médiathèque, `{ "naissance-lange": "https://…/naissance.jpg" }` (une adresse qui commence par `/` est complétée avec celle du site).

Fiches de réalisation : liste `realisations`, créées après les pages (chacune retrouve son service par son adresse) ; les photos s'ajoutent ensuite dans chaque fiche.

```json
"realisations": [
  { "titre": "Escalier droit à limon central à Étampes", "ville": "Étampes", "date": "2024-11",
    "service": "escaliers-metalliques", "categories": ["Escalier"], "resume": "Un limon central en acier anthracite pour un loft.",
    "demande": ["Ce que voulait le client…"], "solution": ["Ce qui a été fait…", "Deuxième paragraphe…"] }
]
```

### Apparence : en-têtes, pieds de page, téléphone, cartes et titres

Mon entreprise > Apparence (administrateur), ou les clés `entete`, `pied`, `mobile`, `cartes`, `titres`, `capitales` et `cartes_mobile` du fichier de site. Les textes, le téléphone, le bouton et les horaires viennent toujours de Mon entreprise ; seule la forme change.

| Clé | Valeurs |
| --- | --- |
| `entete` | `classique` (par défaut), `capsule` (menu dans une capsule sombre au centre), `ilots` (logo, menu et actions en îlots semi-transparents), `logo-centre` (liens en pastilles, logo au centre, prochaine disponibilité), `medaillon` (barre sombre, logo rond au centre : pour un logo rond ou carré), `encadre` (la page dans un cadre arrondi), `bandeau` (bande teintée pleine largeur, liens en petites capitales), `barre-infos` (au-dessus du menu : ouvert ou fermé aujourd'hui, disponibilité, zone, téléphone) |
| `pied` | `colonnes` (par défaut), `grand-titre` (carte sombre, nom et slogan en grand), `logo-geant` (nom en très grand : pour un nom court), `grand-appel` (téléphone en très grand, bouton, itinéraire), `carte` (image du plan nommée `plan` dans la Médiathèque, horaires, coordonnées), `compact` |
| `mobile` | `bouton` (par défaut : Appeler et l'action principale), `barre` (Appeler, l'action principale et Itinéraire) |
| `cartes` | `photo-fond` (par défaut : la photo remplit la carte), `photo-haut` (photo en haut, texte dessous sur fond clair), `liste-filet` (une ligne par service, vignette et filet) ; s'applique aux sections « Trois cartes de service », avec ou sans photos |
| `cartes_mobile` | `empilees` (par défaut), `defilement` : sur téléphone, les rangées de trois cartes ou plus (services, bénéfices des pages de service, lieux, étapes, tarifs, avis, réalisations, équipe, « Où en êtes-vous ? ») se font glisser de gauche à droite, le bord de la suivante dépasse ; les galeries de six photos ou plus montrent les quatre premières et un bouton « Voir les N photos ». Rien n'est retiré de la page (Google voit tout) ; sans script, la galerie reste entière. Sur l’accueil d’exemple de Lison Vautrin : 11,6 écrans de téléphone au lieu de 14,6 |
| `capitales` | `ambiance` (par défaut : capitales avec Acier, minuscules ailleurs), `oui` (H1 et H2 en capitales, en plus petit ; un titre dont un mot dépasse la largeur est réduit, jusqu'à 70 %, au lieu d'être coupé ; les H3 restent en minuscules ; le mot d'accent garde ses minuscules quand une police d'accent est choisie), `non` (jamais, même avec Acier) |
| `titres` | `tete-lien` (par défaut), `tete-deux-colonnes` (le titre à gauche, la phrase d'introduction à droite), `grand-numero` (chaque section numérotée en grand au-dessus de son titre) |

Sur une page qui s'ouvre sur une grande photo (bannière), les en-têtes `capsule`, `ilots` et `bandeau` flottent au-dessus de la photo ; ailleurs ils restent en haut de page. Les en-têtes sombres (`capsule`, `medaillon`, `bandeau`) affichent le « Logo pour fond foncé » de Mon entreprise, sinon le nom en texte. L'état « ouvert aujourd'hui » de la barre d'infos est calculé dans le navigateur, d'après les horaires : il reste juste même avec un cache de page. Pour éviter que deux sites se ressemblent, le registre de l'agence (`.github/outils/registre.py`) vérifie la combinaison choisie.

## Bibliothèque de sections

**Nouveautés 1.9.0.** Chaque ambiance règle ses arrondis (cartes, boutons, photos) et son ombre ; les titres sont en minuscules, sauf dans l'ambiance Acier. Un morceau de titre peut passer dans la couleur d'accent (outil « Surlignage » de l'éditeur, couleur Accent). « Accueil texte et photo avec étiquettes » : titre et bouton visibles sans défiler sur mobile, deux étiquettes posées sur la photo. « Bande de confiance » : une carte de quatre garanties qui chevauche la section du dessus, icône réglée par une classe (`is-icone-garantie`, `plan`, `atelier`, `avis`, `delai`, `prix`, `local`, `devis`, `equipe`). « Chiffres en tuiles » : une grande tuile et trois petites, les chiffres comptent jusqu'à leur valeur. « Zone d'intervention en schéma » (`[briise_zone_schema]`) : dessin SVG de la zone à partir de Mon entreprise > Coordonnées > Communes du schéma (`nom ; latitude ; longitude`, la première au centre) et du rayon, sans carte externe ni cookie. En-tête : téléphone cliquable (numéro en clair sur grand écran, icône sur mobile), option « En-tête flottant » dans Fonctions. Barre mobile à deux boutons, Appeler et l'action principale. Pied de page : pages de service et communes desservies. Cartes entièrement cliquables avec léger soulèvement au survol, numéros des étapes qui s'allument l'un après l'autre, transitions douces entre les pages (navigateurs compatibles), tout coupé si le visiteur a demandé à réduire les animations. En-tête de page sans photo : le texte prend toute la largeur pour les visiteurs ; les personnes qui peuvent modifier la page voient où ira la photo.

**Nouveautés 1.10 à 1.12.** « Étapes en frise » (accueil) et « Déroulé et prix, côte à côte » (pages de service) : plus de photos, une ligne ou un fil qui se remplit au défilement, une étiquette de durée par étape (`br-duree`), le prix dans la colonne qui reste à l'écran et les listes « Compris dans le prix » et « Non compris » (aussi en section seule, « Prix et ce qu'il comprend »). Sous-menu en liste simple, avec une description facultative par lien (`menu_description` dans le fichier de site) et la page en cours marquée d'un point. Bandeau d'information : « Prochaines disponibilités » (Horaires et annonces), retirées seules une fois la date passée ou après 30 jours sans mise à jour. Qualifications et assurances (fonction activable) : saisies dans Mon entreprise > Entreprise, affichées dans la section « Qualifications et assurances » (`[briise_qualifications]`) et dans le pied de page, retirées seules à leur date de fin, transmises à Google (`hasCredential`). « Chiffres en tuiles » : photo de fond facultative dans la grande tuile, trame de plan (`br-tuile--plan`). « Trois cartes de service avec photos ». « Zone d'intervention en liste » (`[briise_zone_liste]`) : communes groupées par distance, calculée depuis les coordonnées déjà saisies.

**Nouveautés 1.13.** Ambiance Galerie et quatorze sections pensées pour les métiers sur rendez-vous qui vendent des images (photographes d'abord), utiles aussi ailleurs. « Liste des prestations qui change la photo » : l'accueil présente les prestations avec leur prix, la grande photo change au survol de chaque ligne (sans script), une vignette par ligne sur mobile. « Titre centré et photos en éventail ». « Où se passe la prestation » (deux ou trois lieux, pastille facultative). « Faits concrets avec icônes » (icône choisie par la classe `br-ic-soleil`, `thermometre`, `fauteuil`, `cintre`, `parking`, `horloge`, `bouclier`, `euro`, `maison`, `appareil`, `coeur`, `accessible`). « Étapes en photos, numérotées » et « Une journée racontée en photos » (heures dans des pastilles). « Ce que vous recevez » (la livraison dessinée sur un téléphone). « Pourquoi ce prix : le temps passé » (barre dessinée à partir des durées du tableau). « Carte cadeau ». « Tarifs en liste, avec photos ». « Avis avec la note Google ». « Galerie : photos agrandies au clic » (plein écran, clavier compris). « Formulaire de réservation » et « Appel à l'action sur photo » (le grand lien du pied de page s'efface quand la page finit par cet appel). Carte « Prochaine date libre » (`[briise_disponibilite]`) posée sur une photo : elle reprend la date de Horaires et annonces et disparaît seule quand la date n'est plus à jour.

**Nouveautés 1.15.** Six ouvertures d'accueil. « Deux portes : urgent ou projet » (dépannage : l'appel en grand, les pannes courantes qui mènent à leur page, le geste à faire en attendant ; à côté, la demande de devis). « Accueil en mosaïque de réalisations » (trois réalisations avec leur commune). « Grande photo et carte de garanties » (trois faits vérifiables sur une carte à cheval sur la section suivante). « Accueil avec avant / après » (à faire glisser). « Accueil sombre, photo coupée en biais ». « Grande photo et demande express » : un formulaire de quatre champs (projet, commune, nom, téléphone) pour être rappelé ; le formulaire « Demande de rappel » se crée dans Mon entreprise > Fonctions, ou seul à l'import si une page l'utilise (`[briise_formulaire type="rappel"]`). Les ouvertures à grande photo laissent flotter les en-têtes capsule, îlots et bandeau.

**Nouveautés 1.16.** « Bande de preuves qui défile », « Avis qui défilent » et « Clients ou partenaires qui défilent » : le contenu reste du vrai texte éditable ; le défilement s'arrête au survol, au clavier et avec un bouton pause, et reste immobile pour qui a demandé moins d'animations. « FAQ avec recherche et thèmes » : un champ de recherche (insensible aux accents) et un bouton par intertitre s'ajoutent seuls au-dessus des questions. « Orientation : la bonne page en une phrase » (« Je cherche [choix] pour [choix] ») : une ligne de liste par réponse, `premier choix | second choix`, liée à sa page. « Une réalisation racontée » (besoin, solution, avis, résultat). « L'équipe en une photo et quatre faits ». « Galerie de réalisations filtrable » (`[briise_realisations filtres="1" forme="galerie"]`) ; les filtres affichent désormais le nombre de réalisations. « Zone d'intervention sur un plan » (`[briise_zone_plan]`) : un vrai plan OpenStreetMap, fabriqué une fois à l'enregistrement de Mon entreprise à partir des communes du schéma, gardé sur le site (aucun service extérieur chez le visiteur), avec la distance et le délai de visite de chaque commune (quatrième partie facultative de la ligne : `Olivet ; 47.863 ; 1.900 ; 48 h`). Sans plan (hébergement sans GD ou serveur de cartes injoignable), le schéma dessiné s'affiche à la place. Deux nouveaux réglages d'Apparence : cartes et titres de section. Avec un autre thème, l'extension apporte une apparence de secours pour les qualifications, la zone en liste, le plan et la galerie.

**Nouveautés 1.17.** Conversion. « Estimateur de budget » : le barème est un tableau modifiable (question, choix, montant bas, montant haut, ajoutés au total ; une question à un seul choix devient une case à cocher) ; le visiteur répond et voit sa fourchette ; sans script, le tableau reste lisible. « Formulaire de devis en trois étapes » (`[briise_formulaire type="devis" etapes="1"]`) : le projet en grandes cases, puis les détails, puis les coordonnées, chaque étape vérifiée avant la suivante ; mêmes champs et mêmes e-mails que le formulaire d'origine. « Préparez votre demande » (icônes `br-ic-metre` et `br-ic-calendrier` en plus). « Garanties et documents à télécharger » : un bloc Fichier par attestation, à remplacer chaque année. « Page merci : la suite » et le modèle « Page de remerciement » : après l'envoi, chaque formulaire Briise mène à cette page (Mon entreprise > Fonctions > Formulaires, ou seul à l'import d'une page faite avec `"modele": "merci"`) ; elle sort de Google d'elle-même et permet de compter les demandes dans Google Ads ou Analytics à partir de son adresse.

**Section « Où en êtes-vous ? »** (famille Parcours et questions). Quatre cartes qui partent de la situation du visiteur, dite comme il la dirait (« Je n'ai pas encore de site. »), chacune avec la réponse en une phrase, le prix (réel, ou « Sur devis ») et le lien vers la page qui y répond. Tout est visible sans clic ; les cartes se rangent seules par quatre, trois ou deux selon la largeur, et suivent le réglage « Sur téléphone, cartes et galeries ». Icône par la classe du bloc, dont deux nouvelles : `br-ic-loupe` et `br-ic-fleches`. Équivalente, pour varier d'un site à l'autre, à « Orientation » et aux cartes de service. Fonction `situations()` exportée par `build_br_sections.js` pour les fichiers de site.

**Nouveautés 1.13.3.** Dans l'éditeur, les blocs automatiques (prochaine date libre, fil d'Ariane, formulaire, fiches de réalisation, coordonnées, zone…) s'affichent sous forme d'étiquette : ce que c'est, où ça se règle, et « ne le supprimez pas ». Un administrateur peut afficher le code ; un compte Éditeur ne voit jamais de crochets.

Dans l'éditeur : bouton « + » > Compositions > catégories « Sections · … ». Chaque section fonctionne avec les huit ambiances.

| Famille | Sections |
| --- | --- |
| Ouverture | Liste des prestations qui change la photo, Titre centré et photos en éventail, Accueil texte et photo avec étiquettes, Hero avec image, Hero bannière plein écran, Hero texte seul, En-tête de page avec photo, En-tête de page avec trois photos, En-tête bandeau photo pleine largeur, En-tête de page avec fil d'Ariane |
| Offre et tarifs | Où se passe la prestation, Faits concrets avec icônes, Ce que vous recevez, Pourquoi ce prix : le temps passé, Carte cadeau, Tarifs en liste avec photos, Ce que ça change, en photos ; Quel modèle choisir, en cartes ; Trois cartes de service, Service détaillé alterné, Tableau comparatif, Grille de tarifs en cartes, Tableau de tarifs simple |
| Confiance et preuves | Avis avec la note Google, Une journée racontée en photos, Galerie : photos agrandies au clic, Bande de confiance, Chiffres en tuiles, Chiffres clés, Témoignages, Logos ou labels, Dernières réalisations, Toutes les réalisations avec filtres, Réalisations de ce service (les trois automatiques), Réalisations en grille (à la main), Avant / après, Avant / après à faire glisser, Galerie en mosaïque |
| Parcours et FAQ | Étapes en photos, numérotées ; Déroulé et prix, en photos ; Étapes numérotées, FAQ en accordéon, Horaires et planning |
| Personnes | Présentation du dirigeant, Équipe, Citation ou valeurs |
| Contenu | Derniers articles, Pages liées (automatique) |
| Contact | Bandeau d'appel à l'action, Bloc contact complet, Coordonnées (carte), Zone d'intervention, Zone d'intervention (carte), Zone d'intervention en liste, Formulaire de demande de devis, Formulaire de contact, Formulaire de réservation, Appel à l'action sur photo |

Règles :
- Rythme des couleurs : deux sections qui se suivent n'ont jamais le même fond. Alterner le blanc (`fond`) et les teintes de l'ambiance (`surface`, `nuance`) ; garder la bande foncée (`secondaire`) pour l'appel à l'action final. Une tête de page peut précéder une section du même fond. Le site de base, les modèles et la fonction `rythme()` des outils respectent cette règle d'eux-mêmes ; une page modifiée à la main se vérifie dans Mon entreprise > Contrôle. Changer un fond en un clic : sélectionner la section (bouton « Sélectionner le parent » ou vue en liste), puis onglet Styles > « Fond clair », « Fond teinté », « Fond nuancé » ou « Fond foncé ». Ces quatre styles suivent l'ambiance : si l'ambiance change, les sections suivent. En « Fond foncé », les textes, étiquettes, boutons et tableaux passent en clair et les cartes gardent leur fond clair ; le contraste AA est vérifié dans les ambiances Acier, Galet et Cabinet. Le client (compte Éditeur) y a accès comme l'administrateur : c'est la façon simple et sûre de lui laisser la main sur les couleurs, sans sortir de la charte.
- Les boutons d'action reprennent le libellé et le lien de « Mon entreprise » au moment de l'insertion.
- Les textes d'exemple expliquent quoi écrire : chacun doit être remplacé avant la livraison.
- Hero bannière : le voile sombre ne descend jamais sous 70 %, ce qui garantit un texte lisible sur n'importe quelle photo. Photo en WebP de 200 Ko au plus ; régler le point focal pour le recadrage mobile.
- Témoignages : uniquement des avis réels, avec l'accord de leur auteur.

## Mon entreprise

Menu « Mon entreprise » de l'administration, juste sous le tableau de bord.

| Onglet | Qui | Contenu |
| --- | --- | --- |
| Horaires et annonces | Éditeur et administrateur | Horaires par jour, fermetures exceptionnelles, bandeau d'information |
| Entreprise | Administrateur | Nom, slogan, logo (et logo pour fond foncé), type d'activité, coordonnées, GPS, zone, action principale, personne, réseaux |
| Mentions légales | Administrateur | Éditeur, hébergeur, profession réglementée, médiateur, réalisation |
| Fonctions | Administrateur | Fonctions activables, Bing Webmaster Tools, Search Console, Matomo |
| Démarrage | Administrateur | Import d'un fichier de site, site de base |
| Contrôle | Administrateur | Contrôle du maillage interne (voir plus bas) |

Tout alimente automatiquement l'en-tête, le pied de page, le bouton fixe mobile et les données structurées.

Codes courts, à placer dans un bloc « Code court » :

| Code | Affiche |
| --- | --- |
| `[briise_horaires]` | Horaires, précision et fermetures à venir, jour en cours surligné |
| `[briise_coordonnees]` | Adresse avec lien d'itinéraire, téléphone, e-mail |
| `[briise_reseaux]` | Liens vers les réseaux et la fiche Google |
| `[briise_mentions_legales]` | Mentions légales complètes ; un champ obligatoire vide apparaît en « [à compléter] » |
| `[briise_fil_ariane]` | Fil d'Ariane de la page en cours |
| `[briise_zone]` | Villes de la zone d'intervention, en pastilles |
| `[briise_carte_coordonnees]` | Carte Coordonnées : téléphone, e-mail, adresse, horaires résumés, itinéraire. `titre="…"` pour changer le titre |
| `[briise_carte_zone]` | Carte Zone d'intervention : communes par secteur, téléphone et contact. `titre="…"` |
| `[briise_contact_rapide]` | Boutons « Appeler » et « Écrire un e-mail » |
| `[briise_telephone]` | Le numéro de téléphone, cliquable |
| `[briise_pages_liees]` | Sur une page qui a des sous-pages : ses sous-pages. Sur une sous-page : les pages sœurs (les autres services). `parent="slug"` : les sous-pages d'une page donnée |
| `[briise_info champ="telephone"]` | Une information seule : `name`, `telephone`, `email`, `adresse`, `city`… |

## Maillage interne

Les liens écrits dans le texte des pages disent à Google quelles pages comptent et de quoi elles parlent. Le thème en pose une partie tout seul :
- les cartes de service de l'accueil portent le nom de chaque service et mènent à sa page (« Garde-corps en détail ») ;
- la page des services liste chacune de ses sous-pages, et chaque page de service liste les autres services (section « Pages liées », mise à jour automatiquement, masquée s'il n'y a rien à montrer) ;
- le fil d'Ariane relie chaque sous-page à sa page parente.

Le reste (liens dans les textes, vers les réalisations, la zone, la FAQ…) se prévoit dans le tableau des liens de la stratégie, puis se vérifie dans **Mon entreprise > Contrôle**. L'écran signale :
- les pages qui reçoivent moins de deux liens depuis le texte d'autres pages (le menu ne compte pas) ;
- les pages à plus de trois clics de l'accueil ;
- les liens cassés, les liens vers une page exclue de Google (noindex, page d'atterrissage) ;
- les textes de lien vagues (« en savoir plus », « cliquez ici ») ;
- les sections voisines qui ont la même couleur de fond (voir ci-dessous).

L'analyse lit les contenus publiés : un lien ajouté par une extension ou un widget n'est pas vu.

## Robots, moteurs et IA

Le thème complète le fichier `robots.txt` virtuel de WordPress (un fichier `robots.txt` réel à la racine du site le remplace et rend ces réglages sans effet).

- Moteurs et robots de recherche des IA toujours autorisés : Googlebot, Bingbot, Applebot, DuckDuckBot, OAI-SearchBot, ChatGPT-User, PerplexityBot, Perplexity-User, Claude-SearchBot, Claude-User. Ce sont eux qui permettent d'apparaître dans les réponses de ChatGPT, Perplexity ou Claude.
- Robots d'entraînement des IA (GPTBot, ClaudeBot, Google-Extended, Applebot-Extended, CCBot, Meta, Bytespider) : autorisés par défaut ; la fonction « Autoriser l'entraînement des IA » permet de les bloquer sans toucher à la visibilité dans les réponses.
- **Bing Webmaster Tools** : coller la balise ou le code de validation dans Fonctions. ChatGPT s'appuie en partie sur l'index de Bing.
- **IndexNow** (fonction activée par défaut) : chaque page publiée ou modifiée est signalée immédiatement à Bing, Yandex, Seznam et Naver. Actif seulement sur le site en ligne (site public, hors adresse locale, environnement de production). Les pages en noindex ne sont pas signalées.

**Mesure des contacts.** Un clic sur un téléphone ou une adresse e-mail, et l'envoi d'un formulaire, envoient l'événement `briise_contact` (champ `briise_type` : `telephone`, `email` ou `formulaire`) dans `dataLayer` pour Google Tag Manager, et dans Matomo s'il est installé. Pour Google Ads, il reste à créer la conversion dans Tag Manager, derrière le consentement (Consent Mode v2).

## Installer sur un site

Ne pas utiliser « Code > Download ZIP ». Dans l'onglet **Releases** du dépôt, chaque version contient deux fichiers :
1. `briise-socle.zip` : Extensions > Ajouter > Téléverser, puis Activer ;
2. `briise.zip` : Apparence > Thèmes > Ajouter > Téléverser, puis Activer.

**Mises à jour.** L'extension interroge GitHub (au plus toutes les 6 heures) et propose les nouvelles versions du thème et de l'extension dans Tableau de bord > Mises à jour, comme pour n'importe quelle extension. Dépôt public : rien à régler. Dépôt privé : ajouter dans `wp-config.php` une clé GitHub en lecture seule, limitée à ce dépôt (`define( 'BRIISE_GITHUB_TOKEN', '…' );`). Une clé placée sur un site client peut être lue par quiconque a accès à ses fichiers : un dépôt public est plus simple et plus sûr.

**Fin de collaboration.** Mon entreprise > Fin de collaboration (administrateurs) : exporter le fichier de site (réglages, pages et fiches de réalisation, au format d'import), figer les contenus (chaque code `[briise_…]` devient des blocs ordinaires et chaque fiche de réalisation devient une page, à la même adresse, pour que le site reste complet sans l'extension ; une révision de chaque page est gardée), liste des comptes et accès à remettre.

## Versions

Numérotation `MAJEUR.MINEUR.CORRECTIF` :
- correctif (0.1.1) : correction sans changement visible ;
- mineur (0.2.0) : nouvelle fonction ou nouvelle section, compatible avec les sites existants ;
- majeur (1.0.0) : changement qui demande une vérification sur chaque site client.

Chaque version est décrite dans `CHANGELOG.md`. Le thème et l'extension portent toujours le même numéro. Pour publier une version : mettre le même numéro dans `style.css` (`Version:`) et dans `extension/briise-socle/briise-socle.php` (en-tête `Version:` et constante `BRIISE_SOCLE_VERSION`), compléter le CHANGELOG, puis pousser sur `main` ; la version (`v1.2.0`) et ses deux fichiers se publient tout seuls dans **Releases**. La publication s'arrête si les numéros diffèrent.

## Avant chaque livraison client

Suivre la checklist de livraison du cahier des charges.
