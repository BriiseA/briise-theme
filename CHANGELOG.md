# Historique des versions

## 1.6.0

- **Nouvel en-tête de page avec photo** : texte à gauche, photo nette à droite (l'image mise en avant), sans voile. La photo s'affiche presque à sa taille réelle : nette dès 1 400 px de large, quelle que soit sa forme. Variante **avec trois photos** (mosaïque). L'ancien bandeau pleine largeur devient « En-tête bandeau photo pleine largeur », réservé aux photos de 2 400 px et plus.
- **Pages de service racontées et illustrées** : trois nouvelles sections avec photos, « Ce que ça change », « Quel modèle choisir » (une carte par modèle) et « Déroulé et prix ». Le modèle « Page de service » suit l'ordre des questions du visiteur : ce que c'est, ce que ça change, lequel choisir, la preuve, le déroulé et le prix, les questions, l'action.
- **Contrôle** : signale une photo d'en-tête manquante ou trop petite (floue à l'écran).
- **Crédit de l'agence** en pied de page (« Site réalisé par Briise », lien de marque en nofollow), désactivé par défaut, coupé automatiquement en fin de collaboration.
- Une page qui commence par un en-tête du thème prend d'elle-même le gabarit sans titre.
- 39 sections. Vérifié sur Delaunay : 0 bloc invalide, Contrôle sans alerte (hors photo trop petite testée exprès), accessibilité 100.

## 1.5.2

- **Tableaux comparatifs lisibles sur mobile** : un tableau de 4 colonnes ou plus devient, sur téléphone, une fiche par ligne, chaque valeur précédée du titre de sa colonne. Automatique, sans JavaScript, pour tous les tableaux du thème (« Quel modèle choisir ? », comparatifs de prix).
- Vérifié sur Delaunay : accessibilité 100 sur les pages escaliers, escalier hélicoïdal, portails et le guide quart tournant.

## 1.5.1

- **En-tête avec photo plus clair** : voile à 68 % derrière le texte seulement (au lieu de 84 %), qui s'efface en douceur pour laisser la photo nette et lumineuse sur la droite ; 68 % aussi sur tablette et mobile (au lieu de 78 %). C'est le minimum qui garde le texte lisible (contraste AA) même sur une zone blanche de la photo, dans toutes les ambiances. Légère ombre sous le texte pour les photos très claires.

## 1.5.0

- Formulaires : **autres adresses qui reçoivent les demandes**, dans Mon entreprise > Entreprise (une par ligne, adresses invalides ignorées), ajoutées à l'e-mail de l'entreprise pour tous les formulaires Briise.
- **Fluent Forms et FluentSMTP installés et activés en un clic** depuis Mon entreprise > Fonctions > Formulaires.
- En-tête avec photo aussi pour les pages À propos, Le cabinet et le modèle « Page équipe ».
- Vérifié : installation en un clic, demande envoyée à trois adresses, accessibilité 100.

## 1.4.0

- **En-tête de page avec photo** (nouvelle section) : bandeau avec la photo de la page (son image mise en avant), dégradé sous le texte, ouvrage visible à droite ; voile uniforme sur tablette et mobile. Contraste vérifié dans le pire cas (photo blanche). Utilisé par défaut pour les pages de service des kits.
- **Formulaires de devis et de contact** (extension, avec Fluent Forms gratuit) : création en un clic dans Mon entreprise > Fonctions, ou automatique à l'import ; champs réduits à l'utile, messages en français, e-mail à l'entreprise avec réponse directe au visiteur, confirmation au visiteur (photos en réponse), champ piège contre les robots, styles de l'ambiance. Sans Fluent Forms, la section propose d'appeler ou d'écrire.
- Mesure des contacts : un formulaire Fluent Forms n'est compté qu'une fois envoyé avec succès.
- Vitesse : styles de Fluent Forms chargés sans bloquer l'affichage, jQuery en bas de page et sans jQuery Migrate.
- Fin de collaboration : le formulaire figé reste un vrai formulaire Fluent Forms.
- Politique de confidentialité (kits) : données des formulaires et outil utilisé.
- 34 sections. Vérifié sur Delaunay : 0 bloc invalide, demande réelle envoyée (enregistrée, e-mail à l'entreprise avec « Répondre » au visiteur, confirmation au visiteur), accessibilité, bonnes pratiques et SEO à 100 sur la page Devis.

## 1.3.0

- **Réalisations dynamiques** (extension) : menu « Réalisations » pour publier une fiche par réalisation (photo principale, galerie agrandie au clic, demande, solution, ville, date, service, catégorie). Grilles automatiques sur l'accueil, la page des réalisations (filtres par catégorie, sans rechargement) et chaque page de service ; chaque fiche a sa page, renvoie vers son service et propose d'autres réalisations du même service. Nom réglable : Réalisations, Portfolio, Chantiers ou Projets.
- Fiche de moins de 150 mots : visible sur le site, mais hors de Google et du plan du site ; signalée dans Contrôle (et dans la fiche, avec le nombre de mots).
- Contrôle : les fiches comptent dans le maillage (grilles et lien vers le service).
- Fichier de site : liste `realisations` à l'import ; export complet et conversion des fiches en pages ordinaires (même adresse) dans Fin de collaboration.
- Thème : gabarit de fiche, trois sections automatiques (Dernières réalisations, Toutes les réalisations avec filtres, Réalisations de ce service), l'ancienne grille reste disponible « à la main » ; kits mis à jour (32 sections).
- **Réseaux sociaux en icônes** dans le pied de page, avec TikTok, YouTube et Pinterest en plus ; nom lu par les lecteurs d'écran, zone cliquable de 44 px.
- Vérifié sur Delaunay (9 fiches) : 0 bloc invalide, Lighthouse accessibilité, bonnes pratiques et SEO à 100 sur l'accueil, la page des réalisations, une fiche et une page de service ; export puis réimport sans écart ; site figé lisible sans l'extension, adresses des fiches conservées ; extension seule avec Twenty Twenty-Five.

## 1.2.0

Briise devient un thème et une extension. **À l'installation ou à la mise à jour : installer et activer `briise-socle.zip`, puis mettre à jour le thème.** Les réglages existants sont conservés tels quels.

- Nouvelle extension **Briise Socle** : tout le fonctionnement sort du thème (Mon entreprise, Contrôle, référencement, données structurées, robots.txt, cartes, codes courts, bandeau d'information, mesure des contacts). Un client qui change de thème garde ses réglages et ses fonctions ; un site fait avec un autre thème peut utiliser l'extension seule (apparence simple pour les cartes, les horaires et le bandeau).
- Le thème garde l'apparence : ambiances, sections, styles de section, kits et import (onglet Démarrage), animations, retour en haut. Sans l'extension, il s'affiche sans erreur et prévient l'administrateur.
- Mises à jour automatiques : l'extension propose les nouvelles versions du thème et de l'extension publiées sur GitHub, dans Tableau de bord > Mises à jour. Dépôt privé possible avec une clé en lecture seule.
- Nouvel onglet **Fin de collaboration** : export du fichier de site (réimportable), figer les contenus (les codes Briise deviennent des blocs ordinaires, texte et liens identiques, une révision gardée), liste des comptes et accès à remettre.
- Chaque version publie deux fichiers, `briise.zip` et `briise-socle.zip`, avec le même numéro.
- Vérifié : import Delaunay identique (0 bloc invalide, Contrôle inchangé, Lighthouse accessibilité, bonnes pratiques et SEO à 100), mise à jour réelle depuis une version publiée, export puis réimport sur un site vierge sans écart, site figé lisible sans l'extension, extension seule avec le thème Twenty Twenty-Five.

## 1.1.0

- Styles de section en un clic : sur n'importe quelle section, onglet Styles > « Fond clair », « Fond teinté », « Fond nuancé » ou « Fond foncé ». Les couleurs viennent de l'ambiance active ; en fond foncé, textes, étiquettes, boutons, tableaux et horaires s'inversent, les cartes restent claires. Contraste AA vérifié sur les 29 sections dans trois ambiances (accessibilité Lighthouse 100).
- Même filet de sécurité quand un fond foncé (secondaire, sombre, accent) est choisi dans le nuancier sans couleur de texte.
- Mon entreprise > Contrôle reconnaît ces styles pour signaler deux sections voisines de même fond, foncé compris.
- Étiquettes un peu plus sombres sur fond nuancé (contraste AA dans l'ambiance Acier).
- Tableau de planning : plus de mots coupés en deux dans une colonne étroite.

## 1.0.0

Première version stable : le thème a servi à monter de bout en bout un site client test (Métallerie Delaunay) avec le process Briise, sans code ajouté. Contenu identique à la 0.11.0 :
- 7 ambiances vérifiées en contraste AA, dont Acier pour les métiers du métal ;
- 29 sections, dont les cartes Coordonnées et Zone d'intervention ;
- kits artisan, prestataire et libéral, import d'un fichier de site ;
- Mon entreprise : coordonnées, logo, horaires, mentions légales, fonctions, démarrage, contrôle du maillage et des couleurs ;
- référencement : titres et descriptions, données structurées, plan du site, robots.txt pour les moteurs et les IA, Bing et IndexNow ;
- page d'atterrissage pour la publicité, mesure des contacts ;
- accessibilité WCAG 2.2 AA, polices préchargées.

## 0.11.0

- Deux nouvelles sections : « Coordonnées (carte) » et « Zone d'intervention (carte) ». Elles se remplissent depuis Mon entreprise (téléphone, e-mail, adresse, horaires résumés automatiquement, itinéraire, zone) et prennent les couleurs de l'ambiance. Icônes Tabler intégrées en SVG, sans police externe.
- Nouveaux champs facultatifs dans Mon entreprise : précisions sous le téléphone, l'e-mail et l'adresse, badge de chaque carte, sous-titre et secteurs de la zone. Aussi acceptés dans le fichier de site.
- Kits : les pages Contact, Devis et Rendez-vous utilisent la carte Coordonnées ; la page Zone d'intervention, la carte Zone.
- Mobile : 4 colonnes, puis 2, puis 1 ; boutons du bandeau en pleine largeur. Contraste vérifié (accessibilité Lighthouse 100).

## 0.10.0

Retours sur le site test Métallerie Delaunay.

- Logo : nouveau champ dans Mon entreprise > Entreprise (médiathèque). Il remplace le nom en texte dans l'en-tête, page d'atterrissage comprise ; un logo pour fond foncé facultatif remplace le nom dans le pied de page. Le logo sert aussi d'image de partage et dans les données structurées.
- Bande d'appel à l'action plus compacte : marges divisées par deux, titre une taille en dessous, texte à gauche et bouton à droite sur ordinateur (hauteur divisée par 2,5). Le lien « Demander un devis » du pied de page s'efface quand la page a déjà sa bande.
- Nouvelle ambiance « Acier » pour les métiers du métal : gris acier froids, graphite, rouille en accent. « Atelier » reste l'ambiance du bâtiment et des artisans du bois.

## 0.9.2

- Menu : sur un WordPress neuf (Playground, nouvel hébergement), WordPress crée un menu automatique qui liste toutes les pages, légales comprises. L'import et la case « Afficher dans le menu » le remplacent désormais par les seules pages prévues, y compris lors d'une réimportation sur un site déjà importé.
- En-tête : le bouton d'action ne se coupe plus sur plusieurs lignes quand le menu est long.

## 0.9.1

Corrections trouvées pendant le test complet du process sur un client fictif (Métallerie Delaunay).

- Bannière plein écran : sur mobile, le texte touchait le bord de l'écran ; il s'aligne désormais sur les autres sections.
- Vitesse : les polices des titres et du texte de l'ambiance active sont préchargées. Le grand titre ne change plus de hauteur au chargement (décalage de mise en page ramené de 0,16 à 0 sur une page de service).
- Vitesse : le grand titre de l'accueil n'est plus masqué puis animé au chargement. C'est l'élément que Google mesure pour la vitesse d'affichage ; seuls les titres plus bas dans la page s'animent encore.
- Type d'activité : « Locksmith » est présenté comme « Serrurier (dépannage, serrures) » ; un métallier choisit « Bâtiment et habitat ».
- README : `name` et `slogan` du fichier de site documentés (nom du site, logo, pied de page).

## 0.9.0

Le rythme des couleurs.

- Kits et modèles de page : deux sections voisines n'ont plus jamais le même fond clair. Le fond passe à une teinte voisine de l'ambiance (blanc, surface, nuance) ; les bandes foncées et les photos ne bougent pas. Avant : 32 sections collées à une voisine de même couleur, dont trois sections blanches d'affilée sur la page Réalisations.
- Mon entreprise > Contrôle signale les sections voisines de même couleur, page par page, avec leur titre, pour les pages modifiées à la main.
- Testé sur WordPress 7.1 : kit artisan sans aucun doublon, détection d'un doublon ajouté à la main, aucun bloc invalide.

## 0.8.0

Le maillage interne.

- Cartes de service de l'accueil : le nom de chaque service et un lien vers sa page (« Garde-corps en détail »), remplis à l'installation du kit ou du fichier de site (`{{SERVICE:n}}`, `{{URL:service-n}}`).
- Nouvelle section « Pages liées (automatique) » et code court `[briise_pages_liees]` : la page des services liste chaque service, chaque page de service liste les autres. Texte du lien : le nom de la page ; résumé : sa description Google. Section masquée s'il n'y a rien à montrer ; pages exclues de Google jamais listées.
- Nouvel onglet Mon entreprise > Contrôle : liens reçus par page, clics depuis l'accueil, pages orphelines, liens cassés, liens vers une page exclue de Google, textes de lien vagues.
- Plus aucun « En savoir plus » seul dans les sections.
- Les modèles de page proposés dans l'éditeur relient la page des services du kit installé.
- Testé sur WordPress 7.1 (kit artisan, quatre services) : pages de service reliées depuis 4 à 5 pages au lieu de 0, aucun bloc invalide, contrôle conforme à une mesure faite depuis le site public.

## 0.7.0

Mieux lu par les moteurs et les IA, plus accessible, prêt pour la publicité.

- `robots.txt` : moteurs et robots de recherche des IA (OAI-SearchBot, PerplexityBot, Claude-SearchBot…) explicitement autorisés ; nouvelle fonction pour bloquer les seuls robots d'entraînement.
- Champ de validation Bing Webmaster Tools.
- IndexNow : chaque page publiée ou modifiée est signalée à Bing et aux moteurs partenaires (site en ligne uniquement).
- Nouveau gabarit « Page d'atterrissage (publicité) » : en-tête sans menu avec téléphone et bouton, pied de page réduit, bouton d'appel fixe sur mobile, noindex et hors plan du site. Disponible comme modèle dans le fichier de site (`"modele": "atterrissage"`).
- Code court `[briise_telephone]`.
- Événement `briise_contact` (téléphone, e-mail, formulaire) pour Tag Manager et Matomo.
- WCAG 2.2 : flèches de sous-menu à 24 × 24 px minimum, élément ciblé au clavier jamais masqué par l'en-tête fixe ou le bouton fixe mobile.
- Testé sur WordPress 7.1 : page d'atterrissage valide dans l'éditeur (93 blocs), aucun lien cassé, aucun élément masqué au clavier.

## 0.6.0

Des sites sur mesure, et un menu que le client gère seul.

- Démarrage en deux temps : choisir un kit, puis l'ajuster (pages décochées ou renommées, pages en plus, services du client, libellé du bouton, pages publiées ou en brouillon).
- Une page par service, rangée sous la page des services et ajoutée en sous-menu, avec un titre Google « Service à Ville | Nom » quand la ville est renseignée.
- Import d'un fichier de site (JSON) : pages, sous-pages, contenus, référencement, menu, informations de l'entreprise, horaires, mentions légales, ambiance et couleurs, en une fois.
- Si une section renvoie vers une page non retenue, son lien mène à la page des services et l'écran le signale.
- Case « Afficher dans le menu » sur chaque page, utilisable par l'éditeur ; sous-pages en sous-menu ; libellé tenu à jour ; page mise à la corbeille retirée du menu ; brouillon coché ajouté à sa publication.
- Modèles proposés à la création d'une nouvelle page (service, simple, tarifs, réalisations, équipe, FAQ, zone, avis, contact) ; leur titre principal suit le titre de la page.
- Un seul titre principal par page : le titre du modèle « Pages » se masque quand la page a sa propre ouverture.
- Bouton « retour en haut » (fonction activable) : longues pages seulement, après deux écrans, au-dessus du bouton fixe mobile, utilisable au clavier.
- Sous-menus aux couleurs de l'ambiance.
- Données structurées questions-réponses sur toute page qui contient des accordéons, pages de service comprises.
- Testé sur WordPress 7.1 : kit ajusté avec trois services, création d'une page par un compte Éditeur depuis un modèle avec la case menu cochée, aucun lien cassé, aucun bloc invalide.

## 0.5.0

Phase 4 : les kits de démarrage.

- Nouvel onglet « Démarrage » dans Mon entreprise (administrateurs) : trois kits qui créent toutes les pages d'un site en un clic.
- Prestataire de services (7 pages), Artisan et entreprise locale (6 pages), Profession libérale (6 pages), plus quatre pages légales prêtes à compléter (confidentialité et cookies rédigées, marquées « [à compléter] » là où il faut une information du client).
- Le kit choisit la page d'accueil, crée le menu principal, relie le bouton d'action, la page FAQ et la page de présentation, active le blog pour le kit prestataire et déclare la page de confidentialité.
- Une page existante n'est jamais écrasée ; relancer un kit ne crée que les pages manquantes.
- Sur la page d'action elle-même, le pied de page et le bouton fixe mobile ne renvoient plus vers elle.
- Le bloc contact complet ne contient plus de bouton vers la page de contact (il y figurait parfois sur cette même page).
- Pages légales : texte aligné sur le titre, intertitres à taille de lecture.
- Testé sur WordPress 7.1 : les trois kits installés sur un site vierge, chaque lien interne vérifié (aucune page introuvable), aucun bloc invalide.
- Les scripts de fabrication de l'agence sont versionnés dans `.github/outils/`.

## 0.4.0

Phase 3b : la bibliothèque de sections.

- 26 sections réparties en sept familles dans l'éditeur (« Sections · Ouverture », « Sections · Offre et tarifs »…), testées avec les six ambiances, sur ordinateur et sur mobile.
- Nouvelles sections : hero bannière plein écran, logos ou labels, avant / après, bloc contact complet, zone d'intervention, emplacement de formulaire ou de réservation, galerie en mosaïque.
- Hero bannière : voile sombre jamais sous 70 % (texte lisible sur toute photo), photo chargée en priorité, hauteur adaptée au mobile.
- Nouveaux codes courts : `[briise_fil_ariane]`, `[briise_zone]`, `[briise_contact_rapide]`.
- Images de remplacement neutres et légères (SVG), à remplacer par les photos du client.
- Vérifié dans l'éditeur de WordPress 7.1 : 368 blocs, aucun bloc invalide. Lighthouse sur la page des 26 sections : accessibilité, bonnes pratiques et SEO à 100, performance à 93.

## 0.3.0

Phase 3a : les ambiances.

- Cinq nouvelles ambiances dans Styles : Lumière, Atelier, Cabinet, Comptoir, et « Charte du client » à remplir avec la charte graphique d'un client. Galet reste l'ambiance par défaut.
- Toutes vérifiées en contraste AA (vérifiées automatiquement à chaque envoi sur GitHub) ; polices hébergées dans le thème, sous licence libre OFL.
- Noms de couleurs génériques, communs à toutes les ambiances (`fond`, `texte`, `accent`, `sombre`…) à la place des noms propres à Galet (`lin`, `nuit`, `ocre`…). Changement incompatible avec un contenu qui utiliserait les anciens noms : aucun site client n'existe encore.
- Polices nommées `titres` et `texte` au lieu de `bricolage` et `figtree`.
- Arrondis et formes décoratives réglés par ambiance (anguleux pour Atelier, arches pour Lumière, rondeurs pour Comptoir).
- Couleurs du code CSS reliées à la palette : rien n'est plus codé en dur.
- Avertissement sur le tableau de bord si une couleur modifiée rend un texte illisible.
- Fond sombre distinct du texte, pour le pied de page et le bandeau.

## 0.2.1

- Correctif : la page de politique de confidentialité créée par WordPress (`privacy-policy`) n'était pas exclue de Google. Le thème reconnaît désormais la page déclarée dans Réglages > Confidentialité, ainsi que les adresses anglaises et les CGV.
- Testé sur WordPress 7.1.4 : l'encadré « Référencement (Google) » enregistre bien titre, description et exclusion.

## 0.2.0

Phase 2 : tout se règle depuis l'administration, sans toucher au code.

- Page « Mon entreprise » en quatre onglets. L'éditeur ne voit que « Horaires et annonces » ; le reste est réservé aux administrateurs.
- Horaires par jour (deux plages), précision libre et jusqu'à six fermetures exceptionnelles, qui disparaissent d'elles-mêmes une fois passées.
- Bandeau d'information avec date de fin, refermable par le visiteur ; annonce automatique des fermetures 7 jours avant.
- Pied de page : colonne Horaires avec le jour en cours mis en avant, liens vers les réseaux, liens légaux affichés seulement si la page existe.
- Mentions légales générées par le code court `[briise_mentions_legales]`.
- Neuf fonctions activables ; une fonction désactivée ne charge rien.
- Référencement : encadré « Référencement (Google) » dans l'éditeur de page avec compteur et aperçu du résultat Google ; pages légales automatiquement hors de Google et du plan du site ; plan du site sans pages auteurs ; horaires, fermetures, carte et raison sociale dans les données structurées.
- Image de partage : logo ou icône du site au lieu de la capture du thème.
- Search Console (balise) et Matomo sans cookie, sans extension.
- Correctif : le bouton de l'en-tête restait visible sur mobile.
- Le fichier `inc/entreprise.php` ne contient plus de réglages à modifier : le filtre `briise_entreprise` reste disponible.

## 0.1.0

Première version de la base, issue de Galet Yoga 1.1.0.

- Renommage complet en Briise (fonctions, classes CSS, scripts, catégories).
- Retrait de tout le contenu propre à Galet Yoga : pages, articles, visuels, création automatique de contenu.
- En-tête générique : titre du site et menu WordPress.
- Pied de page générique, alimenté par les informations de l'entreprise.
- Données structurées génériques : type d'activité, personne et page FAQ configurables.
- Bouton fixe mobile et appel principal configurables (libellé et page).
