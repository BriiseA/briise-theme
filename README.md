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
| `patterns/` | Sections réutilisables (bibliothèque en construction, phase 3) |
| `inc/reglages.php` | Stockage et nettoyage des réglages de « Mon entreprise » |
| `inc/admin.php` | Page « Mon entreprise » de l'administration |
| `inc/entreprise.php` | Lecture des informations, horaires, coordonnées, mentions légales, codes courts |
| `inc/fonctions.php` | Bandeau d'information, blog activable, Search Console, Matomo |
| `inc/seo.php` | Title, meta description, Open Graph, noindex, plan du site, données structurées, encadré « Référencement » |
| `assets/js/ux.js` | Menu intelligent, page active, téléphones cliquables, bouton fixe mobile |
| `assets/js/motion.js` | Animations d'apparition (coupées si le visiteur le demande) |
| `styles/` | Ambiances (variations de style) |
| `inc/contraste.php` | Avertissement si une couleur modifiée rend un texte illisible |
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
