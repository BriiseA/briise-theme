# Historique des versions

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
