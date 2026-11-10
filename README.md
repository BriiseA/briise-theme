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
| `inc/entreprise.php` | Informations de l'entreprise (remplacé par une page de réglages en phase 2) |
| `inc/seo.php` | Title, meta description, Open Graph, noindex, données structurées |
| `assets/js/ux.js` | Menu intelligent, page active, téléphones cliquables, bouton fixe mobile |
| `assets/js/motion.js` | Animations d'apparition (coupées si le visiteur le demande) |
| `assets/fonts/` | Polices hébergées et leurs licences |

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
