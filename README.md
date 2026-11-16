# Briise, thème de base

Thème WordPress à blocs de l'agence Briise pour les sites vitrines d'entreprises locales de services.
Le cahier des charges complet est dans le document « Thème de base agence : cahier des charges ».

## Principe

Un seul thème pour tous les clients. Un site client ne contient jamais de code propre :
seulement des réglages, un kit de pages, une variation de style et ses contenus.
Corriger un défaut dans la base le corrige partout, à la prochaine mise à jour.

## Structure

| Dossier ou fichier | Rôle |
| --- | --- |
| `theme.json` | Couleurs, polices, tailles, espacements et styles globaux |
| `templates/` | Modèles de pages (page, article, blog, 404, page sans titre) |
| `parts/` | En-tête et pied de page |
| `patterns/` | Bibliothèque de 26 sections (`section-*.php`), en-tête, pied de page, blog |
| `assets/images/sections/` | Images de remplacement des sections, à remplacer par les photos du client |
| `inc/reglages.php` | Stockage et nettoyage des réglages de « Mon entreprise » |
| `inc/admin.php` | Page « Mon entreprise » de l'administration |
| `inc/entreprise.php` | Lecture des informations, horaires, coordonnées, mentions légales, codes courts |
| `inc/fonctions.php` | Bandeau d'information, blog activable, Search Console, Matomo |
| `inc/seo.php` | Title, meta description, Open Graph, noindex, plan du site, données structurées, encadré « Référencement » |
| `assets/js/ux.js` | Menu intelligent, page active, téléphones cliquables, bouton fixe mobile |
| `assets/js/motion.js` | Animations d'apparition (coupées si le visiteur le demande) |
| `styles/` | Ambiances (variations de style) |
| `inc/kits.php`, `inc/kits.json` | Démarrage : kits ajustables, import d'un fichier de site, modèles de page |
| `inc/menu.php` | Case « Afficher dans le menu » et tenue du menu principal |
| `inc/contraste.php` | Avertissement si une couleur modifiée rend un texte illisible |
| `.github/outils/` | Scripts de fabrication des sections, kits et ambiances (hors thème) |
| `assets/fonts/` | Polices hébergées et leurs licences (toutes sous licence OFL) |

## Ambiances (variations de style)

Apparence > Éditeur > Styles > Parcourir les styles. Sept ambiances, toutes vérifiées en contraste AA :

| Ambiance | Pour qui | Titres / texte |
| --- | --- | --- |
| Galet (par défaut) | Bien-être, artisans d'art, créatifs | Bricolage Grotesque / Figtree |
| Lumière | Photographes, esthétique, événementiel | Cormorant Garamond / DM Sans |
| Atelier | Bâtiment, garages, artisans du bois | Barlow Condensed / Barlow |
| Acier | Métallerie, serrurerie, chaudronnerie : gris acier, graphite, rouille | Barlow Condensed / Barlow |
| Cabinet | Avocats, experts-comptables, santé | Source Serif 4 / Source Sans 3 |
| Comptoir | Restaurants, commerces, loisirs | Fredoka / Nunito |
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

**Cartes Coordonnées et Zone.** Deux sections de la catégorie Contact, reprises des cartes du site DEFI No Limit et colorées par l'ambiance. Elles lisent Mon entreprise : rien n'est tapé deux fois. Champs facultatifs (Mon entreprise > Entreprise, « Cartes Coordonnées et Zone d'intervention ») : une précision sous le téléphone, l'e-mail et l'adresse, un badge par carte, et les secteurs de la zone :

```
# Alpes-Maritimes | Autour de l'atelier
Carros | siège
Nice | et Côte d'Azur
+ Alpes-de-Haute-Provence
```

Sans secteurs, la carte Zone reprend la liste des villes. Dans le fichier de site, ces champs vont dans `entreprise` : `precision_telephone`, `precision_email`, `precision_adresse`, `badge_coord_titre`, `badge_coord_texte`, `badge_zone_titre`, `badge_zone_texte`, `zone_soustitre`, `zone_secteurs` (lignes séparées par `\n`). Icônes : Tabler Icons (MIT), intégrées en SVG.

**Logo.** Mon entreprise > Entreprise > Logo : il remplace le nom en texte dans l'en-tête (le nom reste lu par Google et les lecteurs d'écran). Le pied de page étant sombre, un « logo pour fond foncé » facultatif l'y remplace aussi ; sans lui, le nom reste en texte. Sans logo, rien ne change.

**Charte du client.** Partir de l'ambiance « Charte du client », remplacer ses couleurs par celles de la charte, puis ajouter ses polices dans Styles > Typographie > Gérer les polices (fichiers WOFF2, licence web vérifiée).

## Démarrer un site client

1. Installer WordPress, téléverser `briise.zip`, activer le thème.
2. Mon entreprise > **Démarrage**, au choix :
   - **ajuster un kit** : choisir le kit le plus proche, décocher ou renommer ses pages, ajouter des pages en plus, saisir les services du client (une page chacun, rangée en sous-menu), régler le bouton d'action ;
   - **importer un fichier de site** préparé par l'agence à partir de la fiche client (pages, textes, référencement, menu, informations, ambiance).
3. Mon entreprise : compléter ce que le kit ou le fichier n'a pas rempli.
4. Remplacer chaque texte et chaque photo d'exemple, puis suivre la checklist de livraison.

| Kit | Pages proposées | Bouton d'action |
| --- | --- | --- |
| Prestataire de services | Accueil, Prestations, Tarifs, À propos, Questions fréquentes, Contact, Blog | Prendre rendez-vous |
| Artisan et entreprise locale | Accueil, Savoir-faire, Réalisations, Zone d'intervention, À propos, Devis | Demander un devis |
| Profession libérale | Accueil, Domaines d'intervention, Honoraires, Le cabinet, Questions fréquentes, Rendez-vous | Prendre rendez-vous |

Pages en plus, et modèles proposés à la création de chaque nouvelle page : service, page simple, tarifs, réalisations, équipe, FAQ, zone d'intervention, avis clients, contact. Les pages légales (mentions, confidentialité, cookies, accessibilité) sont toujours créées. Une page dont l'adresse existe déjà n'est jamais modifiée.

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
  "cta": "devis", "cta_label": "Demander un devis", "accueil": "accueil", "faq": "faq", "personne": "a-propos", "blog": "",
  "statut": "publish",
  "pages": [
    { "slug": "accueil", "titre": "Accueil", "markup": "<!-- wp:… -->", "seo_titre": "…", "seo_description": "…" },
    { "slug": "savoir-faire", "titre": "Savoir-faire", "modele": "service", "menu": true },
    { "slug": "escaliers", "titre": "Escaliers sur mesure", "parent": "savoir-faire", "modele": "service", "menu": true }
  ]
}
```

Dans `markup`, les repères `{{CTA}}`, `{{CTA_LABEL}}`, `{{URL:slug}}`, `{{IMG:nom}}` et `{{TITRE}}` sont remplacés à l'import, ainsi que `{{SERVICE:n}}` (nom du n-ième service) et `{{URL:service-n}}` (sa page). Les services sont les sous-pages de la page des services, dans l'ordre du fichier. `"legales": false` évite la création des pages légales.

## Bibliothèque de sections

Dans l'éditeur : bouton « + » > Compositions > catégories « Sections · … ». Chaque section fonctionne avec les sept ambiances.

| Famille | Sections |
| --- | --- |
| Ouverture | Hero avec image, Hero bannière plein écran, Hero texte seul, En-tête de page avec fil d'Ariane |
| Offre et tarifs | Trois cartes de service, Service détaillé alterné, Tableau comparatif, Grille de tarifs en cartes, Tableau de tarifs simple |
| Confiance et preuves | Chiffres clés, Témoignages, Logos ou labels, Réalisations en grille, Avant / après, Galerie en mosaïque |
| Parcours et FAQ | Étapes numérotées, FAQ en accordéon, Horaires et planning |
| Personnes | Présentation du dirigeant, Équipe, Citation ou valeurs |
| Contenu | Derniers articles, Pages liées (automatique) |
| Contact | Bandeau d'appel à l'action, Bloc contact complet, Coordonnées (carte), Zone d'intervention, Zone d'intervention (carte), Emplacement de formulaire ou de réservation |

Règles :
- Rythme des couleurs : deux sections qui se suivent n'ont jamais le même fond. Alterner le blanc (`fond`) et les teintes de l'ambiance (`surface`, `nuance`) ; garder la bande foncée (`secondaire`) pour l'appel à l'action final. Une tête de page peut précéder une section du même fond. Les kits et les modèles respectent cette règle d'eux-mêmes ; une page modifiée à la main se vérifie dans Mon entreprise > Contrôle. Changer un fond en un clic : sélectionner la section (bouton « Sélectionner le parent » ou vue en liste), puis onglet Styles > « Fond clair », « Fond teinté », « Fond nuancé » ou « Fond foncé ». Ces quatre styles suivent l'ambiance : si l'ambiance change, les sections suivent. En « Fond foncé », les textes, étiquettes, boutons et tableaux passent en clair et les cartes gardent leur fond clair ; le contraste AA est vérifié dans les ambiances Acier, Galet et Cabinet. Le client (compte Éditeur) y a accès comme l'administrateur : c'est la façon simple et sûre de lui laisser la main sur les couleurs, sans sortir de la charte.
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
| Démarrage | Administrateur | Kits et import d'un fichier de site |
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

## Installer le thème sur un site

Ne pas utiliser « Code > Download ZIP » : le dossier obtenu s'appelle `briise-theme-main` et WordPress le traiterait comme un autre thème.
Utiliser le fichier `briise.zip` de la dernière version, dans l'onglet **Releases** du dépôt : il est fabriqué automatiquement à chaque nouvelle version.

## Versions

Numérotation `MAJEUR.MINEUR.CORRECTIF` :
- correctif (0.1.1) : correction sans changement visible ;
- mineur (0.2.0) : nouvelle fonction ou nouvelle section, compatible avec les sites existants ;
- majeur (1.0.0) : changement qui demande une vérification sur chaque site client.

Chaque version est décrite dans `CHANGELOG.md`. Pour publier une version : mettre à jour `Version:` dans `style.css` et le CHANGELOG, puis pousser sur `main` ; la version (`v0.2.0`) et son `briise.zip` se publient tout seuls dans **Releases**.

## Avant chaque livraison client

Suivre la checklist de livraison du cahier des charges.
