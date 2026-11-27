# Catalogue des sections Briise

Fichier produit par `catalogue.py` : ne pas le modifier à la main.

Toutes les sections servent à tous les métiers. Pour composer un site : partir des questions que se posent ses visiteurs (`parcours.json`, une grille de réflexion, pas un kit), choisir ici les sections qui y répondent avec ce que le client peut réellement fournir, varier les ouvertures et les habillages d’un site à l’autre (`variantes.json`, `registre.py`), puis assembler le fichier de site (`build_br_sections.js`, `rythme()` de `build_br_kits.js`, `validate.js`).

Colonne « Besoins » : ce qu’il faut avoir avant de choisir la section. Une section sans son contenu réel ne doit pas être publiée.

## Ouverture (haut de l’accueil ou d’une page) (13)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `choix-prestation` | Ouverture : liste des prestations qui change la photo | Accueil : le titre, puis la liste des prestations avec leur prix. Au survol d’une ligne, la grande photo change. Chaque ligne mène à sa page. Sur mobile, une vignette par ligne. De 2 à 6 lignes. | 4 photos, prix réels, prochaine date libre (Horaires et annonces) | — |
| `en-tete-bandeau` | En-tête bandeau photo pleine largeur | Photo de la page en bandeau sur toute la largeur, texte posé dessus. Réservé aux très grandes photos (2 400 px de large au moins) : sinon, préférer l’en-tête avec photo à côté. | — | — |
| `en-tete-mosaique` | En-tête de page avec trois photos | Variante quand vous avez trois bonnes photos : titre à gauche, mosaïque à droite. La grande photo est l’image mise en avant de la page ; les deux petites se remplacent d’un clic. | 2 photos | — |
| `en-tete-page` | En-tête de page avec fil d’Ariane | Pour toutes les pages intérieures : fil d’Ariane automatique, titre, introduction et bouton d’action. | — | — |
| `en-tete-photo` | En-tête de page avec photo | Pages de service, à propos : titre et introduction à gauche, photo nette à droite. La photo est l’image mise en avant de la page (1 400 px de large au moins) ; sans elle, le texte prend toute la largeur. | — | — |
| `ouverture` | Ouverture (10 versions) | Le haut de l’accueil : pastille, grand titre, phrase, bouton d’action et second bouton, trois atouts, et vos photos. Choisissez la forme dans le panneau « Version » : photo à côté, bannière plein écran, photo coupée en biais, moitié-moitié, arche, titre géant, diaporama, mosaïque en tuiles, titre avec photos ou photo qui s’agrandit. Le diaporama fait défiler en fondu les quatre photos ; la mosaïque en montre trois ; les autres versions, la première. Une carte d’infos se pose sur la photo : ouvert aujourd’hui, prochaine date libre (Horaires et annonces) et votre ville ; sans ces données, elle ne s’affiche pas. Une vidéo courte (bloc Vidéo, sans son) peut remplacer la photo : elle joue en boucle, avec un bouton pause. | 4 photos | — |
| `ouverture-avant-apres` | Accueil avec avant / après | Rénovation, nettoyage, aménagement : le titre à gauche, une photo avant / après à faire glisser à droite. Les deux photos doivent être prises du même endroit, avec le même cadrage. | 2 photos | curseur avant / après ; sans script : deux photos |
| `ouverture-bande` | Ouverture avec bande de services | La même ouverture, avec en bas vos services en grand sur une bande qui défile doucement (pause au survol, au clavier ou avec le bouton). Les noms viennent de vos pages de service : vérifiez qu’il y en a au moins quatre, ou retirez les noms en trop. | 4 photos, pages de service | défile (pause, immobile si moins d’animations) ; sans script : bande fixe |
| `ouverture-carte` | Grande photo et carte de garanties | Une grande photo pleine largeur avec le titre, puis une carte posée à cheval sur la section suivante : trois faits vérifiables (délai, ancienneté, garantie) et le bouton d’action. | 1 photo | — |
| `ouverture-demande` | Grande photo et demande express | La demande dès l’arrivée : une grande photo, le titre, et à droite un formulaire de quatre champs (projet, commune, nom, téléphone) pour être rappelé. Le formulaire « Demande de rappel » se crée dans Mon entreprise > Fonctions. Idéale aussi pour une page de publicité. | 1 photo, formulaire de rappel (Fluent Forms) | — |
| `ouverture-deux-portes` | Deux portes : urgent ou projet | Quand les visiteurs arrivent avec deux besoins très différents, une urgence ou un projet : dès l’arrivée, deux chemins. « C’est urgent » : l’appel en grand, les pannes courantes qui mènent à leur page, le geste à faire en attendant. « J’ai un projet » : une photo et la demande de devis. Le téléphone vient de Mon entreprise. | 1 photo, pages de service | — |
| `ouverture-eventail` | Ouverture : titre centré et photos en éventail | Quand les photos sont le meilleur argument : un grand titre centré, puis cinq photos disposées en arc. Élégante sur ordinateur ; sur mobile, trois photos restent visibles. | 5 photos | — |
| `ouverture-mosaique` | Accueil en mosaïque de réalisations | La preuve dès l’arrivée : le titre et les boutons à gauche, trois réalisations récentes à droite, chacune avec son ouvrage et sa commune. Chaque photo mène aux réalisations. | 3 photos | — |

## Offre et tarifs (15)

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
| `services` | Services (7 versions) | Vos services, chacun avec sa photo, son nom, deux phrases et le lien vers sa page. Choisissez la forme dans le panneau « Version » de la section : grille, grille asymétrique, liste en deux colonnes, service phare, défilement, onglets ou volets ; et la place du titre dans le panneau « Titre ». Le texte et les photos restent en place quand vous changez de version. Retirez ou dupliquez un service : chaque version s’adapte de 3 à 6 services. | 4 photos, pages de service | — |
| `tableau-comparatif` | Tableau comparatif | Aider à choisir entre deux ou trois formules. | prix réels | — |
| `tarifs-cartes` | Grille de tarifs en cartes | Deux à quatre formules avec leur prix ; celle du milieu est mise en avant. | prix réels, chiffres vérifiables | — |
| `tarifs-liste` | Tarifs en liste, avec photos | Toutes les prestations sur une liste : vignette, nom, ce qui est compris en quelques mots, prix. Chaque ligne mène à la page de la prestation. | 3 photos, prix réels | — |
| `tarifs-tableau` | Tableau de tarifs simple | Pour une liste de prestations nombreuses : une ligne par prestation. | prix réels | — |
| `temps-prix` | Pourquoi ce prix : le temps passé | Justifier un prix par le travail qu’il représente : chaque étape et sa durée (« 30 min », « 2 h 30 »). Une barre colorée est dessinée à partir des durées. | — | — |

## Confiance et preuves (20)

| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |
| --- | --- | --- | --- | --- |
| `avant-apres` | Avant / après | Deux photos côte à côte pour montrer une transformation. | 2 photos | — |
| `avant-apres-glisse` | Avant / après à faire glisser | Une seule photo coupée par un curseur : on glisse pour passer de l’avant à l’après. Les deux photos doivent être prises du même endroit, avec le même cadrage ; sinon, préférer « Avant / après » côte à côte. | 2 photos | curseur avant / après ; sans script : deux photos |
| `avis` | Avis (5 versions) | La note Google et quatre avis de clients, chacun avec la photo de la réalisation dont il parle. Choisissez la forme dans le panneau « Version » : grille, note en avant, un avis en grand, mur d’avis ou défilement. Uniquement la vraie note et des avis réels, recopiés mot pour mot avec l’accord de leur auteur (jamais pour une profession réglementée). Retirez la note si vous n’avez pas de fiche Google. | 4 photos, avis réels, avec l’accord de leur auteur (jamais pour une profession réglementée) | — |
| `bande-confiance` | Bande de confiance | Juste sous l’ouverture, une carte qui chevauche la section du dessus : quatre garanties réelles avec leur icône. L’icône se change dans Avancé > Classes CSS : is-icone-garantie, is-icone-plan, is-icone-atelier, is-icone-avis, is-icone-delai, is-icone-prix, is-icone-local, is-icone-devis, is-icone-equipe. | — | — |
| `bande-preuves` | Bande de preuves qui défile | Juste sous l’ouverture : vos garanties et vos faits courts, sur une bande qui défile doucement. De 5 à 8 faits vrais, de deux à cinq mots chacun. Le défilement s’arrête au survol, au clavier ou avec le bouton pause. | — | défile (pause, immobile si moins d’animations) ; sans script : bande fixe |
| `chiffres` | Chiffres (5 versions) | Trois ou quatre preuves chiffrées et une photo. Choisissez la forme dans le panneau « Version » : en ligne, en cartes, en tuiles avec la photo, sur une bande foncée, ou posés sur la photo. Les chiffres comptent jusqu’à leur valeur quand la section apparaît (une valeur purement numérique, avec au plus une unité courte). Uniquement des chiffres vrais et vérifiables. | 1 photo, chiffres vérifiables | — |
| `clients-defilants` | Clients ou partenaires qui défilent | Les entreprises, collectivités ou architectes qui vous ont confié un chantier, en logos sur une bande qui défile. Un logo par client, avec son nom en texte alternatif. Seulement avec leur accord. | 5 photos, logos de clients, avec leur accord | défile (pause, immobile si moins d’animations) ; sans script : bande fixe |
| `comparaison` | Ce que vous évitez avec nous (2 versions) | Ce qui agace le plus les clients dans votre métier, et ce que vous faites autrement, ligne par ligne, avec une photo. Choisissez la forme dans le panneau « Version » : deux colonnes ou lignes face à face. Des pratiques que vous tenez vraiment ; ne nommez ni ne visez jamais un concurrent. | 1 photo | — |
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

## Parcours et questions (9)

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
| `ou-en-etes-vous` | Où en êtes-vous ? | Quand les visiteurs arrivent dans des situations différentes : quatre cartes qui partent de leur situation, dite comme ils la diraient, avec la réponse, le prix et la page qui y répond. Tout est visible sans clic. Icône au choix par la classe du bloc : br-ic-maison, fleches, loupe, horloge, euro, bouclier, coeur, appareil. Seulement un prix réel, ou « Sur devis ». | — | — |

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

## Versions des sections (familles)

Une même section, plusieurs formes pour le même contenu. Dans le fichier de site : la classe `br-<famille>--<version>` de la section (dans l’éditeur : panneau « Version »). Dans les outils : `services({ version, position })` de `build_br_sections.js`.

### Ouverture (section `ouverture`, par défaut : `cote`)

| Version | Classe | Forme |
| --- | --- | --- |
| Photo à côté | `br-ouverture--cote` | Le texte à gauche, la photo à droite. La forme sûre, qui va partout. |
| Bannière plein écran | `br-ouverture--banniere` | La photo sur toute la largeur, le texte posé dessus sur un voile sombre. Pour une très belle photo, large (2 400 px). |
| Photo coupée en biais | `br-ouverture--biais` | Fond foncé, la photo coupée en biais avec un trait de la couleur d’accent. Un style plus industriel. |
| Moitié-moitié | `br-ouverture--moitie` | L’écran coupé en deux : le texte sur un aplat de couleur, la photo collée au bord sur toute la hauteur. |
| Arche | `br-ouverture--arche` | La photo en arche, un cercle de la couleur de décor derrière. Élégant, pour l’image, le bien-être, l’événementiel. |
| Titre géant | `br-ouverture--geant` | Le titre en très grand sur toute la largeur, la photo plus petite et décalée. Style magazine, pour un titre court. |
| Diaporama | `br-ouverture--diaporama` | La photo sur toute la largeur, et les quatre photos de la section qui changent en fondu toutes les 6 secondes (bouton pause). Le titre et le bouton restent fixes. |
| Mosaïque en tuiles | `br-ouverture--tuiles` | Le texte dans une grande tuile, trois photos autour (ou deux photos et la carte d’infos). Le style « bento », très actuel. |
| Titre avec photos | `br-ouverture--mots` | De petites photos arrondies glissées entre les mots du titre, tout au centre. Style magazine, pour un titre court. |
| Photo qui s’agrandit | `br-ouverture--agrandi` | Le titre au centre, la photo dessous en carte arrondie, qui s’étend à toute la largeur quand on fait défiler. |

Place du texte (panneau « Titre ») :

- **Selon la version** (aucune classe) : À gauche, ou centré pour « titre avec photos » et « photo qui s’agrandit ».
- **Texte à gauche** (`br-titre--gauche`) : Le texte à gauche, la photo à droite.
- **Texte centré** (`br-titre--centre`) : Le texte au centre ; dans les versions côte à côte, la photo passe dessous.
- **Texte à droite** (`br-titre--droite`) : Le texte à droite, la photo passe à gauche. Sur téléphone, le texte revient en haut à gauche.

Options, combinables avec toutes les versions :

- **Carte d’infos** : Posée sur la photo : ouvert aujourd’hui, prochaine date libre et ville, depuis Mon entreprise. Sans données, rien ne s’affiche. Dans la section : le code court [briise_infos_ouverture] ; dans les outils : ouverture({ infos: true }).
- **Bande de services** : Les noms des services en grand, sur une bande qui défile en bas de l’ouverture (pause au survol, au clavier ou avec le bouton). Composition « Ouverture avec bande de services » ; dans les outils : ouverture({ bande: true }).

### Services (section `services`, par défaut : `grille`)

| Version | Classe | Forme |
| --- | --- | --- |
| Grille | `br-services--grille` | Une carte par service : photo en haut, texte dessous. |
| Grille asymétrique | `br-services--bento` | Le premier service en grand, les autres autour, chacun sur sa photo. |
| Liste en deux colonnes | `br-services--liste` | Une ligne par service : vignette, numéro, nom, deux phrases et un bouton fléché. Pour une offre large (6 services et plus). |
| Service phare | `br-services--phare` | Le premier service en grand, photo et texte côte à côte ; les autres en liste courte dessous. |
| Défilement | `br-services--defile` | Grandes cartes photo qui glissent de gauche à droite, avec des flèches. |
| Onglets | `br-services--onglets` | Un service à la fois : le visiteur choisit le service dans une rangée d’onglets. Dans l’éditeur, les services restent en grille. |
| Volets | `br-services--volets` | Bandes photo côte à côte : celle que l’on survole s’ouvre et montre son texte. Sur téléphone, les volets s’empilent. |

### Avis (section `avis`, par défaut : `grille`)

| Version | Classe | Forme |
| --- | --- | --- |
| Grille | `br-temoignages--grille` | Les avis côte à côte, la note Google au-dessus. |
| Note en avant | `br-temoignages--note` | La note Google dans une grande carte foncée, les avis deux par deux à côté. |
| Un avis en grand | `br-temoignages--grand` | Le premier avis en grand avec la photo de la réalisation, les autres en petit dessous. |
| Mur d’avis | `br-temoignages--mur` | Les avis en colonnes de hauteurs différentes, certains avec la photo de la réalisation. |
| Défilement | `br-temoignages--defile` | Les avis glissent de gauche à droite, avec des flèches. |

### Chiffres (section `chiffres`, par défaut : `ligne`)

| Version | Classe | Forme |
| --- | --- | --- |
| En ligne | `br-chiffres--ligne` | Les chiffres côte à côte, séparés par un filet. Sobre. |
| En cartes | `br-chiffres--cartes` | Chaque chiffre dans sa carte, dans la couleur d’accent. |
| En tuiles | `br-chiffres--tuiles` | La photo en grand, les chiffres en tuiles à côté (le premier en couleur foncée). |
| Bande foncée | `br-chiffres--bande` | Les chiffres en clair sur une bande de couleur foncée. |
| Sur la photo | `br-chiffres--photo` | La photo en fond de la section sous un voile sombre, les chiffres posés dessus. |

### Comparaison (section `comparaison`, par défaut : `colonnes`)

| Version | Classe | Forme |
| --- | --- | --- |
| Deux colonnes | `br-comparaison--colonnes` | La photo en bandeau, puis deux colonnes : ce qu’on voit souvent, et vous (mis en avant). |
| Lignes face à face | `br-comparaison--lignes` | La photo à gauche, une ligne par sujet : ce qu’on voit souvent, puis ce que vous faites. |

## Place du titre (toute section dont le titre est en haut)

Dans le fichier de site : la classe `br-titre--<position>` de la section (dans l’éditeur : panneau « Titre »). Sans classe, la section suit le réglage général `titres` du site. Sur téléphone, le titre revient en haut ; seul le titre centré reste centré.

| Position | Classe | Rendu |
| --- | --- | --- |
| Selon le site | aucune | Le réglage général : Mon entreprise > Apparence > Titres. |
| À gauche | `br-titre--gauche` | Le titre à gauche, le lien à droite. |
| Centré | `br-titre--centre` | Titre, phrase et lien au centre, les uns sous les autres. |
| À droite | `br-titre--droite` | Le titre au bord droit, le lien à gauche. |
| Titre et phrase côte à côte | `br-titre--cote` | Le titre à gauche, la phrase d’introduction et le lien à droite. |
| Titre géant | `br-titre--geant` | Le titre en très grand sur toute la largeur, la phrase et le lien dessous. |
| Titre et filet | `br-titre--filet` | Un trait fin prolonge le titre jusqu’au lien. |
| En marge à gauche | `br-titre--marge-gauche` | Sur ordinateur, l’en-tête dans une colonne à gauche, qui reste visible pendant la lecture. |
| En marge à droite | `br-titre--marge-droite` | Sur ordinateur, l’en-tête dans une colonne à droite. |

### Positions permises, section par section

Toutes les positions ne vont pas à toutes les sections : la marge écrase un tableau ou une galerie, un titre à droite dérange au-dessus d’un contenu lu de gauche à droite ou d’une phrase d’introduction, le titre géant ne va qu’à un titre court, « côte à côte » demande une phrase. Le panneau « Titre » et le rythme des titres ne proposent que ces positions (règles : `reglesTitres` de `inc/familles.json`).

| Section | Positions permises |
| --- | --- |
| `avant-apres` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `avant-apres-glisse` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet |
| `avis` | À gauche, Centré, À droite, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `benefices-photos` | À gauche, Centré, À droite, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `chiffres` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `comparaison` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet |
| `derniers-articles` | À gauche, Centré, À droite, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `documents-garanties` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `equipe` | À gauche, Centré, À droite, Titre et filet, En marge à gauche, En marge à droite |
| `etapes` | À gauche, Centré, Titre géant, Titre et filet |
| `etapes-images` | À gauche, Centré, Titre et phrase côte à côte, Titre et filet |
| `etapes-photos` | À gauche, Centré, Titre et filet |
| `galerie` | À gauche, Centré, À droite, Titre géant, Titre et filet |
| `galerie-agrandir` | À gauche, Centré, À droite, Titre géant, Titre et filet |
| `journee-racontee` | À gauche, Centré, Titre et phrase côte à côte, Titre et filet |
| `lieux` | À gauche, Centré, Titre et phrase côte à côte, Titre et filet, En marge à gauche, En marge à droite |
| `modeles-cartes` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `ou-en-etes-vous` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `pages-liees` | À gauche, Centré, À droite, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `realisations` | À gauche, Centré, À droite, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `realisations-galerie` | À gauche, Centré, À droite, Titre géant, Titre et filet |
| `realisations-manuelle` | À gauche, Centré, À droite, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `realisations-service` | À gauche, Centré, À droite, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `services` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `tableau-comparatif` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet |
| `tarifs-cartes` | À gauche, Centré, À droite, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `tarifs-liste` | À gauche, Centré, Titre et phrase côte à côte, Titre géant, Titre et filet, En marge à gauche, En marge à droite |
| `tarifs-tableau` | À gauche, Centré, Titre géant, Titre et filet |
| `zone` | À gauche, Centré, Titre et phrase côte à côte, Titre et filet, En marge à gauche, En marge à droite |
| `zone-plan` | À gauche, Centré, Titre et phrase côte à côte, Titre et filet |

## Habillage du site (une fois pour tout le site)

Clés du fichier de site (`"entete": "capsule"`…) ou Mon entreprise > Apparence. Ce que fait chaque valeur : `README.md`, « Apparence ». L’ouverture n’est pas une clé : c’est la première section de l’accueil. Couleurs et polices : clés `couleurs` et `polices` ; réglage fin : clé `styles`.

| Pièce | Valeurs |
| --- | --- |
| `entete` | `classique`, `capsule`, `ilots`, `logo-centre`, `medaillon`, `encadre`, `bandeau`, `barre-infos` |
| `ouverture` | `cote`, `banniere`, `biais`, `moitie`, `arche`, `geant`, `diaporama`, `tuiles`, `mots`, `agrandi`, `choix-prestation`, `eventail`, `deux-portes`, `mosaique`, `carte`, `avant-apres`, `demande` |
| `cartes` | `photo-fond`, `photo-haut`, `liste-filet` |
| `titres` | `tete-lien`, `tete-deux-colonnes`, `grand-numero`, `marge` |
| `pied` | `colonnes`, `grand-titre`, `logo-geant`, `grand-appel`, `carte`, `compact` |
| `mobile` | `bouton`, `barre` |
| `angles` | `standard`, `doux`, `droits`, `feuille`, `biseau` |
| `photos` | `standard`, `arche`, `galet` |
| `relief` | `ombre`, `bordure`, `plat` |
| `etiquettes` | `texte`, `numerotees` |
| `surlignage` | `couleur`, `aplat` |
