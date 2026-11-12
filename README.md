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

Apparence > Éditeur > Styles > Parcourir les styles. Six ambiances, toutes vérifiées en contraste AA :

| Ambiance | Pour qui | Titres / texte |
| --- | --- | --- |
| Galet (par défaut) | Bien-être, artisans d'art, créatifs | Bricolage Grotesque / Figtree |
| Lumière | Photographes, esthétique, événementiel | Cormorant Garamond / DM Sans |
| Atelier | Bâtiment, métallerie, garages | Barlow Condensed / Barlow |
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

**Menu.** Chaque page a une case « Afficher dans le menu » (colonne de droite de l'éditeur), accessible au client. Une sous-page se range en sous-menu sous sa page parente. Le menu reste modifiable dans Apparence > Éditeur > Navigation.

### Fichier de site

Fichier JSON importé dans Démarrage. Seule la liste `pages` est obligatoire.

```json
{
  "entreprise": { "name": "Atelier Ferrum", "type": "Locksmith", "telephone": "06 12 34 56 78", "city": "Milly-la-Forêt" },
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

Dans `markup`, les repères `{{CTA}}`, `{{CTA_LABEL}}`, `{{URL:slug}}`, `{{IMG:nom}}` et `{{TITRE}}` sont remplacés à l'import. `"legales": false` évite la création des pages légales.

## Bibliothèque de sections

Dans l'éditeur : bouton « + » > Compositions > catégories « Sections · … ». Chaque section fonctionne avec les six ambiances.

| Famille | Sections |
| --- | --- |
| Ouverture | Hero avec image, Hero bannière plein écran, Hero texte seul, En-tête de page avec fil d'Ariane |
| Offre et tarifs | Trois cartes de service, Service détaillé alterné, Tableau comparatif, Grille de tarifs en cartes, Tableau de tarifs simple |
| Confiance et preuves | Chiffres clés, Témoignages, Logos ou labels, Réalisations en grille, Avant / après, Galerie en mosaïque |
| Parcours et FAQ | Étapes numérotées, FAQ en accordéon, Horaires et planning |
| Personnes | Présentation du dirigeant, Équipe, Citation ou valeurs |
| Contenu | Derniers articles |
| Contact | Bandeau d'appel à l'action, Bloc contact complet, Zone d'intervention, Emplacement de formulaire ou de réservation |

Règles :
- Les boutons d'action reprennent le libellé et le lien de « Mon entreprise » au moment de l'insertion.
- Les textes d'exemple expliquent quoi écrire : chacun doit être remplacé avant la livraison.
- Hero bannière : le voile sombre ne descend jamais sous 70 %, ce qui garantit un texte lisible sur n'importe quelle photo. Photo en WebP de 200 Ko au plus ; régler le point focal pour le recadrage mobile.
- Témoignages : uniquement des avis réels, avec l'accord de leur auteur.

## Mon entreprise

Menu « Mon entreprise » de l'administration, juste sous le tableau de bord.

| Onglet | Qui | Contenu |
| --- | --- | --- |
| Horaires et annonces | Éditeur et administrateur | Horaires par jour, fermetures exceptionnelles, bandeau d'information |
| Entreprise | Administrateur | Nom, slogan, type d'activité, coordonnées, GPS, zone, action principale, personne, réseaux |
| Mentions légales | Administrateur | Éditeur, hébergeur, profession réglementée, médiateur, réalisation |
| Fonctions | Administrateur | Fonctions activables, Search Console, Matomo |

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
| `[briise_contact_rapide]` | Boutons « Appeler » et « Écrire un e-mail » |
| `[briise_info champ="telephone"]` | Une information seule : `name`, `telephone`, `email`, `adresse`, `city`… |

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
