# Catalogue des sections Briise

Fichier produit par `catalogue.py` : ne pas le modifier à la main.

Toutes les sections servent à tous les métiers. Pour composer un site : partir des questions que se posent ses visiteurs (`parcours.json`, une grille de réflexion, pas un kit), choisir ici les sections qui y répondent avec ce que le client peut réellement fournir, varier les ouvertures et les habillages d’un site à l’autre (`variantes.json`, `registre.py`), puis assembler le fichier de site (`build_br_sections.js`, `rythme()` de `build_br_kits.js`, `validate.js`).

Colonne « Besoins » : ce qu’il faut avoir avant de choisir la section. Une section sans son contenu réel ne doit pas être publiée.

## Ouverture (haut de l’accueil ou d’une page) (16)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `accueil-photo` | Accueil texte et photo avec étiquettes | Ouverture de l’accueil : titre, phrase et boutons à gauche, une vraie photo à droite avec deux étiquettes posées dessus (prix de départ, délai, garantie). Sur mobile, le titre et le bouton restent visibles sans défiler. | 1 photo, prix réels | — |
| `choix-prestation` | Ouverture : liste des prestations qui change la photo | Accueil : le titre, puis la liste des prestations avec leur prix. Au survol d’une ligne, la grande photo change. Chaque ligne mène à sa page. Sur mobile, une vignette par ligne. De 2 à 6 lignes. | 4 photos, prix réels, prochaine date libre (Horaires et annonces) | — |
| `en-tete-bandeau` | En-tête bandeau photo pleine largeur | Photo de la page en bandeau sur toute la largeur, texte posé dessus. Réservé aux très grandes photos (2 400 px de large au moins) : sinon, préférer l’en-tête avec photo à côté. | — | — |
| `en-tete-mosaique` | En-tête de page avec trois photos | Variante quand vous avez trois bonnes photos : titre à gauche, mosaïque à droite. La grande photo est l’image mise en avant de la page ; les deux petites se remplacent d’un clic. | 2 photos | — |
| `en-tete-page` | En-tête de page avec fil d’Ariane | Pour toutes les pages intérieures : fil d’Ariane automatique, titre, introduction et bouton d’action. | — | — |
| `en-tete-photo` | En-tête de page avec photo | Pages de service, à propos : titre et introduction à gauche, photo nette à droite. La photo est l’image mise en avant de la page (1 400 px de large au moins) ; sans elle, le texte prend toute la largeur. | — | — |
| `hero-banniere` | Hero bannière plein écran | Grande photo pleine largeur, titre et bouton posés dessus. Le voile sombre garantit la lisibilité, quelle que soit la photo. | 1 photo | — |
| `hero-image` | Hero avec image | Ouverture de l’accueil ou d’une page de service : titre, phrase d’accroche, deux boutons, photo. | 1 photo | — |
| `hero-texte` | Hero texte seul | Ouverture sobre, sans image : pages intérieures, pages légales, pages de contenu. | — | — |
| `ouverture-avant-apres` | Accueil avec avant / après | Rénovation, nettoyage, aménagement : le titre à gauche, une photo avant / après à faire glisser à droite. Les deux photos doivent être prises du même endroit, avec le même cadrage. | 2 photos | curseur avant / après ; sans script : deux photos |
| `ouverture-carte` | Grande photo et carte de garanties | Une grande photo pleine largeur avec le titre, puis une carte posée à cheval sur la section suivante : trois faits vérifiables (délai, ancienneté, garantie) et le bouton d’action. | 1 photo | — |
| `ouverture-decoupe` | Accueil sombre, photo coupée en biais | Une ouverture plus industrielle : fond sombre, titre en grand, la photo coupée en biais avec un trait de la couleur d’accent. Sur mobile, la photo passe sous le texte. | 1 photo | — |
| `ouverture-demande` | Grande photo et demande express | La demande dès l’arrivée : une grande photo, le titre, et à droite un formulaire de quatre champs (projet, commune, nom, téléphone) pour être rappelé. Le formulaire « Demande de rappel » se crée dans Mon entreprise > Fonctions. Idéale aussi pour une page de publicité. | 1 photo, formulaire de rappel (Fluent Forms) | — |
| `ouverture-deux-portes` | Deux portes : urgent ou projet | Quand les visiteurs arrivent avec deux besoins très différents, une urgence ou un projet : dès l’arrivée, deux chemins. « C’est urgent » : l’appel en grand, les pannes courantes qui mènent à leur page, le geste à faire en attendant. « J’ai un projet » : une photo et la demande de devis. Le téléphone vient de Mon entreprise. | 1 photo, pages de service | — |
| `ouverture-eventail` | Ouverture : titre centré et photos en éventail | Quand les photos sont le meilleur argument : un grand titre centré, puis cinq photos disposées en arc. Élégante sur ordinateur ; sur mobile, trois photos restent visibles. | 5 photos | — |
| `ouverture-mosaique` | Accueil en mosaïque de réalisations | La preuve dès l’arrivée : le titre et les boutons à gauche, trois réalisations récentes à droite, chacune avec son ouvrage et sa commune. Chaque photo mène aux réalisations. | 3 photos | — |

## Offre et tarifs (16)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `benefices-photos` | Ce que ça change, en photos | Pages de service : trois bénéfices concrets pour le client, chacun avec sa photo. Ce qu’il y gagne, pas une liste de caractéristiques. | 3 photos | — |
| `carte-cadeau` | Carte cadeau | Offrir une prestation : un visuel de carte cadeau (photo, nom, montant) et le mode d’emploi en une phrase. | 1 photo, prix réels | — |
| `ce-que-vous-recevez` | Ce que vous recevez | Montrer concrètement le résultat livré : une galerie en ligne, un dossier, un carnet d’entretien… dessiné sur un téléphone, avec trois éléments compris. | 4 photos | — |
| `estimateur` | Estimateur de budget | Trois questions, une fourchette de prix honnête, puis la demande de devis. Le barème est le tableau : une ligne par choix (question, choix, montant bas, montant haut, ajoutés au total). Une question avec un seul choix devient une case à cocher. Les montants viennent du client, constatés sur ses chantiers. | prix réels | calcul de la fourchette ; sans script : barème en tableau |
| `faits-icones` | Faits concrets avec icônes | Un lieu, un atelier, un service : six faits courts qui rassurent, chacun avec son icône. Icônes au choix par la classe du bloc : br-ic-soleil, thermometre, fauteuil, cintre, parking, horloge, bouclier, euro, maison, appareil, coeur, accessible. | 1 photo | — |
| `lieux` | Où se passe la prestation | Deux ou trois lieux possibles (chez vous, dans nos locaux, en extérieur), chacun avec sa photo et ses faits. Le premier peut porter une pastille (« Idéal pour… »). | 3 photos | — |
| `modeles-cartes` | Quel modèle choisir, en cartes | Une carte par modèle ou par option, avec sa photo, sa place, son prix, pour qui il est fait et ses limites. Lisible sur mobile, plus parlant qu’un tableau. | 3 photos, prix réels | — |
| `prix-compris` | Prix et ce qu’il comprend | Les prix, puis deux listes courtes : ce qui est compris, ce qui ne l’est pas. Elles répondent à la peur numéro un du prospect, les mauvaises surprises sur le devis. | prix réels | — |
| `service-alterne` | Service détaillé, image et texte alternés | Pages de service : chaque service avec sa photo, en alternance gauche et droite. | 2 photos | — |
| `tableau-comparatif` | Tableau comparatif | Aider à choisir entre deux ou trois formules. | prix réels | — |
| `tarifs-cartes` | Grille de tarifs en cartes | Deux à quatre formules avec leur prix ; celle du milieu est mise en avant. | prix réels, chiffres vérifiables | — |
| `tarifs-liste` | Tarifs en liste, avec photos | Toutes les prestations sur une liste : vignette, nom, ce qui est compris en quelques mots, prix. Chaque ligne mène à la page de la prestation. | 3 photos, prix réels | — |
| `tarifs-tableau` | Tableau de tarifs simple | Pour une liste de prestations nombreuses : une ligne par prestation. | prix réels | — |
| `temps-prix` | Pourquoi ce prix : le temps passé | Justifier un prix par le travail qu’il représente : chaque étape et sa durée (« 30 min », « 2 h 30 »). Une barre colorée est dessinée à partir des durées. | — | — |
| `trois-cartes` | Trois cartes de service | Présenter l’offre en trois blocs, chacun menant à sa page. | pages de service | — |
| `trois-cartes-photos` | Trois cartes de service avec photos | Chaque carte est une photo pleine hauteur, avec le titre et le texte sur un dégradé sombre ; toute la carte mène à la page du service. Retirez la photo d’une carte : elle reprend l’aspect simple. | 3 photos, pages de service | — |

## Confiance et preuves (22)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `avant-apres` | Avant / après | Deux photos côte à côte pour montrer une transformation. | 2 photos | — |
| `avant-apres-glisse` | Avant / après à faire glisser | Une seule photo coupée par un curseur : on glisse pour passer de l’avant à l’après. Les deux photos doivent être prises du même endroit, avec le même cadrage ; sinon, préférer « Avant / après » côte à côte. | 2 photos | curseur avant / après ; sans script : deux photos |
| `avis-defilants` | Avis qui défilent | Plus de trois avis à montrer : une rangée qui défile, avec la note Google au-dessus. Uniquement des avis réels, recopiés mot pour mot avec l’accord de leur auteur. Le défilement s’arrête au survol, au clavier ou avec le bouton pause. | avis réels, avec l’accord de leur auteur (jamais pour une profession réglementée) | défile (pause, immobile si moins d’animations) ; sans script : bande fixe |
| `avis-note` | Avis avec la note Google | La note moyenne et le nombre d’avis Google, puis trois avis courts. Uniquement la vraie note et des avis réels, recopiés mot pour mot avec l’accord de leur auteur. | avis réels, avec l’accord de leur auteur (jamais pour une profession réglementée) | — |
| `bande-confiance` | Bande de confiance | Juste sous l’ouverture, une carte qui chevauche la section du dessus : quatre garanties réelles avec leur icône. L’icône se change dans Avancé > Classes CSS : is-icone-garantie, is-icone-plan, is-icone-atelier, is-icone-avis, is-icone-delai, is-icone-prix, is-icone-local, is-icone-devis, is-icone-equipe. | — | — |
| `bande-preuves` | Bande de preuves qui défile | Juste sous l’ouverture : vos garanties et vos faits courts, sur une bande qui défile doucement. De 5 à 8 faits vrais, de deux à cinq mots chacun. Le défilement s’arrête au survol, au clavier ou avec le bouton pause. | — | défile (pause, immobile si moins d’animations) ; sans script : bande fixe |
| `chiffres-cles` | Chiffres clés | Quatre preuves rapides. Uniquement des chiffres vrais et vérifiables. | chiffres vérifiables | — |
| `clients-defilants` | Clients ou partenaires qui défilent | Les entreprises, collectivités ou architectes qui vous ont confié un chantier, en logos sur une bande qui défile. Un logo par client, avec son nom en texte alternatif. Seulement avec leur accord. | 5 photos, logos de clients, avec leur accord | défile (pause, immobile si moins d’animations) ; sans script : bande fixe |
| `documents-garanties` | Garanties et documents à télécharger | Vos attestations en PDF : assurance décennale, qualification, Kbis. Remplacez chaque fichier (bouton « Remplacer » du bloc) et mettez la date à jour chaque année. Une attestation périmée fait plus de tort que pas d’attestation. | documents PDF à jour | — |
| `galerie` | Galerie en mosaïque | Six photos en mosaïque : lieu, ambiance, détails du travail. | 6 photos | — |
| `galerie-agrandir` | Galerie : photos agrandies au clic | Portfolio, réalisations : une mosaïque dont chaque photo s’agrandit en plein écran au clic ou au clavier. Le texte alternatif de chaque photo décrit vraiment ce qu’elle montre. | 6 photos | — |
| `journee-racontee` | Une journée racontée en photos | Mariage, événement, chantier d’une journée : six moments dans l’ordre, chacun avec son heure et une phrase. Montre tout ce que le client reçoit, pas seulement les plus belles photos. | 6 photos | — |
| `logos` | Logos de clients ou labels | Certifications, labels, partenaires ou clients connus, en une ligne. | 5 photos, logos de clients, avec leur accord | — |
| `qualifications` | Qualifications et assurances | Une ligne discrète : le logo de chaque qualification (Qualibat, RGE, décennale…), une précision et le lien « Vérifier » vers l’annuaire officiel. Se remplit dans Mon entreprise > Entreprise ; une qualification périmée disparaît seule. Rien ne s’affiche si la fonction est coupée. | qualifications et assurances (Mon entreprise > Entreprise) | — |
| `realisation-racontee` | Une réalisation racontée | Une réalisation qui raconte votre façon de travailler : la commune et la date, trois faits (délai, durée, matériaux), le besoin, la solution, l’avis du client et le résultat. Une vraie réalisation, des photos du chantier, l’avis avec l’accord du client. | 2 photos, avis réels, avec l’accord de leur auteur (jamais pour une profession réglementée) | — |
| `realisations` | Dernières réalisations (automatique) | Accueil : les trois dernières réalisations publiées (menu Réalisations), avec un lien vers toutes. Se met à jour seule ; disparaît s’il n’y en a aucune. | fiches Réalisations publiées | — |
| `realisations-galerie` | Galerie de réalisations filtrable (automatique) | Toutes les réalisations publiées en grande galerie de photos, avec un bouton par catégorie et le nombre de réalisations. Chaque photo mène à sa fiche. Se met à jour seule. | fiches Réalisations publiées | — |
| `realisations-manuelle` | Réalisations en grille (à la main) | Trois réalisations écrites dans la page, sans fiche. Pour un site sans la fonction Réalisations. | 3 photos | — |
| `realisations-service` | Réalisations de ce service (automatique) | Page de service : les réalisations rattachées à ce service. Disparaît tant qu’il n’y en a aucune. | fiches Réalisations publiées | — |
| `realisations-toutes` | Toutes les réalisations, avec filtres (automatique) | Page des réalisations : toutes les fiches publiées, avec des boutons pour filtrer par catégorie. Se met à jour seule. | fiches Réalisations publiées | — |
| `temoignages` | Témoignages | Trois avis de clients. Uniquement des avis réels, avec l’accord de leur auteur. | avis réels, avec l’accord de leur auteur (jamais pour une profession réglementée) | — |
| `tuiles-chiffres` | Chiffres en tuiles | Vos preuves en chiffres, en tuiles de tailles différentes : une grande pour le chiffre le plus fort, les autres autour. Les chiffres comptent jusqu’à leur valeur quand la section apparaît. | 1 photo, chiffres vérifiables | — |

## Parcours et questions (8)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `etapes` | Étapes en frise | Rassurer sur le déroulé : du premier contact au résultat. Une frise numérotée qui se remplit au défilement, avec la durée de chaque étape. Idéale sur l’accueil. | — | — |
| `etapes-images` | Étapes en photos, numérotées | Comment ça se passe, en trois à cinq photos : le numéro de l’étape est posé sur la photo, le moment (« Le jour J », « Sous 3 semaines ») dans une pastille. Quand chaque étape se montre mieux qu’elle ne se raconte. | 4 photos | — |
| `etapes-photos` | Déroulé et prix, en photos | Comment ça se passe, de la visite à la fin du chantier, chaque étape avec sa photo, puis le prix et ce qui le fait varier. | 3 photos, prix réels | — |
| `etapes-prix` | Déroulé et prix, côte à côte | Pages de service : les étapes sur un fil qui se remplit au défilement, et le prix dans la colonne qui reste à l’écran. Le visiteur lit le déroulé et voit le prix en même temps. | prix réels | — |
| `faq` | FAQ en accordéon | Lever les freins avant le contact. Sur la page choisie comme FAQ, les questions sont transmises à Google. | — | — |
| `faq-recherche` | FAQ avec recherche et thèmes | Page FAQ ou longue liste de questions : un champ « Chercher une question » et un bouton par thème (vos intertitres) s’ajoutent seuls au-dessus. Rangez les questions sous des intertitres de niveau 3. Sur la page choisie comme FAQ, les questions sont transmises à Google. | — | recherche et thèmes ; sans script : FAQ complète |
| `horaires` | Horaires et planning | Horaires d’ouverture tirés de « Mon entreprise », et un planning de rendez-vous ou de cours. Le jour en cours est surligné. | horaires (Mon entreprise) | — |
| `orientation` | Orientation : la bonne page en une phrase | Accueil d’une offre large : « Je cherche [choix] pour [choix] », et le bouton mène à la page qui répond. Chaque ligne de la liste est une réponse possible, écrite « premier choix | second choix », avec le lien vers sa page. Une seule partie par ligne donne un seul menu. Ajoutez une troisième partie pour nommer la page sur le bouton. | pages de service | menus « Je cherche … pour … » ; sans script : liste de liens |

## Personnes (4)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `dirigeant` | Présentation du dirigeant | Quand le client choisit une personne autant qu’une entreprise : la personne derrière l’entreprise, sa photo et son parcours. | 1 photo, chiffres vérifiables | — |
| `equipe` | Équipe | PME et cabinets : présenter les personnes que le client rencontrera. | 3 photos | — |
| `equipe-photo` | L’équipe en une photo et quatre faits | Quand vous êtes plusieurs : une photo de groupe devant l’atelier ou le camion, et quatre faits qui rassurent (nombre de personnes, sous-traitance, interlocuteur unique, ancienneté), sans fiche par personne. Seul ? Préférez « Présentation du dirigeant ». | 1 photo, chiffres vérifiables | — |
| `valeurs` | Citation ou valeurs | Positionnement : une phrase forte et trois engagements. | chiffres vérifiables | — |

## Contenu (2)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `derniers-articles` | Derniers articles | Les trois derniers articles du blog, mis à jour automatiquement. | — | — |
| `pages-liees` | Pages liées (automatique) | Pages de service : les autres services, avec un lien vers chacun. Sur une page qui a des sous-pages : la liste de ses sous-pages. Se met à jour seule. | pages enfants (services) | — |

## Contact et conversion (14)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `bandeau-cta` | Bandeau d’appel à l’action | Fin de page : une dernière invitation à passer à l’action. | — | — |
| `contact` | Bloc contact complet | Coordonnées, itinéraire, horaires et réseaux, tirés de « Mon entreprise ». | adresse, téléphone, e-mail (Mon entreprise), horaires (Mon entreprise) | — |
| `coordonnees-carte` | Coordonnées (carte) | Téléphone, e-mail, adresse et horaires en une carte, avec le lien d’itinéraire. Se remplit depuis Mon entreprise. | adresse, téléphone, e-mail (Mon entreprise) | — |
| `cta-photo` | Appel à l’action sur photo | Fin de page : le dernier appel posé sur une grande photo, assombrie du côté du texte. Le pied de page, uni, s’en détache nettement. | 1 photo | — |
| `formulaire` | Formulaire de demande de devis | Le formulaire de devis (Fluent Forms, créé dans Mon entreprise > Fonctions), avec ce qui se passe après l’envoi. Sans formulaire : téléphone et e-mail. | formulaire de devis (Fluent Forms) | — |
| `formulaire-contact` | Formulaire de contact | Le formulaire de contact (Fluent Forms, créé dans Mon entreprise > Fonctions). Sans formulaire : téléphone et e-mail. | formulaire de contact (Fluent Forms) | — |
| `formulaire-etapes` | Formulaire de devis en trois étapes | Le formulaire de devis découpé en trois étapes courtes : le projet, les détails, les coordonnées. Une demande commencée par le projet va plus souvent au bout. À côté : ce qui se passe ensuite, et le téléphone. Sans script, le formulaire s’affiche en entier. | formulaire de devis (Fluent Forms) | formulaire en trois étapes ; sans script : formulaire complet |
| `formulaire-reservation` | Formulaire de réservation | Page « Réserver » : le formulaire de réservation (prestation, lieu, date souhaitée, coordonnées ; créé dans Mon entreprise > Fonctions), avec à côté la prochaine date libre et ce qui se passe après l’envoi. | 1 photo, formulaire de réservation (Fluent Forms), prochaine date libre (Horaires et annonces) | — |
| `merci-suite` | Page merci : la suite | Pour la page qui s’affiche après l’envoi d’un formulaire (Mon entreprise > Fonctions > Formulaires) : la confirmation, les étapes datées, le téléphone, et de quoi patienter. La page est retirée de Google automatiquement. | pages de service | — |
| `preparez-demande` | Préparez votre demande | Juste avant le formulaire ou sur la page de devis : les trois choses à avoir sous la main pour une réponse rapide et juste. Icônes au choix par la classe du bloc (br-ic-appareil, metre, calendrier, maison, euro, horloge…). | — | — |
| `zone` | Zone d’intervention | Quand vous vous déplacez chez vos clients : les villes couvertes, tirées de « Mon entreprise ». | communes avec coordonnées (Mon entreprise > Entreprise) | — |
| `zone-carte` | Zone d’intervention (carte) | Les communes regroupées par secteur, avec téléphone et contact en bas. Se remplit depuis Mon entreprise (Secteurs de la zone). | communes et rayon (Mon entreprise) | — |
| `zone-liste` | Zone d’intervention en liste | Les communes où vous intervenez, groupées par distance (moins de 10 km, 10 à 20 km…), puis une invitation à appeler. Les distances se calculent seules à partir de Mon entreprise > Entreprise > Communes du schéma de zone (nom ; latitude ; longitude, votre adresse en premier). | communes avec coordonnées (Mon entreprise > Entreprise) | — |
| `zone-plan` | Zone d’intervention sur un plan | Les communes sur un vrai plan : le visiteur choisit la sienne et voit la distance et le délai de visite. Le plan est fabriqué une fois, à partir des communes du schéma de zone (Mon entreprise > Entreprise ; nom ; latitude ; longitude ; délai facultatif), et enregistré sur votre site : aucun service extérieur n’est chargé chez le visiteur. | communes avec coordonnées (Mon entreprise > Entreprise) ; plan fabriqué à l’enregistrement | — |
