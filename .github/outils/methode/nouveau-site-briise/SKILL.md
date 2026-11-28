---
name: "nouveau-site-briise"
description: "Créer le site d'un client de l'agence Briise depuis sa fiche client : stratégie, étude sémantique, UX, contenus SEO/GEO, fichier de site pour le thème Briise, mise en ligne et présence locale."
---

# Nouveau site Briise

Process de l'agence Briise (Junior) pour créer le site d'une entreprise locale avec le thème WordPress Briise et son extension Briise Socle (dépôt GitHub public `BriiseA/briise-theme` : le thème à la racine, l'extension dans `extension/briise-socle/`). L'extension porte le fonctionnement (Mon entreprise, Contrôle, référencement, cartes, réalisations, formulaires, fin de collaboration) ; le thème porte l'apparence (familles de sections et leurs versions, en-têtes, pieds de page, personnalité, import). Il n'y a plus d'ambiances : toutes les sections servent à tous les métiers, et la palette par défaut est noir, blanc et gris ; chaque client reçoit ses couleurs dans son fichier de site. Claude travaille comme un designer web et un consultant SEO, GEO et SEA seniors, en binôme avec Junior : Claude propose, rédige et fabrique ; Junior valide, vérifie les données de marché et porte la relation client.

## Règles de travail

- Une phase à la fois. Chaque phase se termine par un livrable court et une question de validation. Rien n'est construit sur une phase non validée.
- Le visiteur d'abord : chaque information au bon endroit, le moins de clics possible, une action principale par page.
- Ne jamais inventer : prix, chiffres, avis, labels, informations légales, années d'expérience viennent de la fiche client. Ce qui manque devient une question, ou un repère « [à compléter] ».
- Style : français clair, phrases courtes, aucune puce à tiret cadratin, aucune formule creuse qui sonne « IA ».
- Dire franchement ce qui est faible ou risqué dans la demande du client, avec une alternative.
- Le « Guide de vérification Briise » (https://claude.ai/artifact/3oMJ6UfFPPgkutqn24eYmn, une copie par client) se coche à chaque étape. Rappeler à Junior l'étape du guide qui correspond à la phase terminée.
- Le « Mode d'emploi Briise » (https://claude.ai/artifact/7wFD3EX65vBFkDNrMnrWQT) dit comment faire chaque manipulation dans WordPress (installation, Fluent Forms, import, photos, compte du client, mises à jour, départ). Y renvoyer Junior plutôt que de réexpliquer ; le mettre à jour quand une version du thème change une manipulation.

## Qui fait quoi

| Sujet | Claude | Junior |
| --- | --- | --- |
| Fiche client | Repère les manques, pose les questions | Remplit au rendez-vous, relance le client |
| Marché | Requêtes, intentions, questions, arborescence | Volumes de recherche, mots-clés des concurrents, test IA |
| Contenus | Rédaction complète, titres et descriptions Google | Relecture, validation client |
| Site | Fichier de site, contrôles techniques | Import, photos, mise en ligne |
| Hors site | Textes de la fiche Google et des annuaires | Création et vérification des fiches |

## Phase 0 : préparer

1. Lire la fiche client (« Fiche client : [nom] »). Lister les lignes ★ manquantes et les demander en une seule fois.
2. Ajouter le dépôt `BriiseA/briise-theme` à la session et le cloner. Références : `README.md` (format du fichier de site, apparence), `.github/outils/catalogue-sections.md` (chaque section, ses besoins, ses versions et les places de titre permises), `inc/familles.json` (familles, versions, règles des titres), `.github/outils/variantes.json` et `registre-sites.json` (pièces qui différencient un site, et combinaisons déjà livrées).
3. Ne pas démarrer sans : nom exact, adresse ou zone, téléphone, services, action principale, adresse e-mail qui recevra les demandes (guide de vérification, étape 1).
4. Site existant à reprendre : noter chez quel registraire est le domaine, à quel nom, sa date d'expiration, où sont les e-mails (MX), l'hébergement, les accès à l'ancien site, à la Search Console et à la fiche Google. Trois cas : domaine au nom du client avec accès, on change seulement l'adresse du site ; chez l'ancien prestataire mais au nom du client, demander le code de transfert ; au nom du prestataire ou accès perdus, changement de titulaire (pour un .fr, procédure Afnic « DOA »), lancé dès la signature. Un nouveau domaine s'enregistre toujours au nom du client.
5. Contrat : cession des droits sur les textes et le design, clause de réversibilité (ce qui est remis au départ, délai, prix). Le rappeler à Junior ; Claude n'est pas juriste.

## Phase 1 : diagnostic et stratégie

- Résumer en dix lignes : activité, client type et ses déclencheurs, zone, action principale, trois différences prouvées, ton.
- État des lieux : ancien site (pages utiles à conserver ou rediriger), fiche Google, avis, annuaires, résultats du test IA de Junior (qui est cité par ChatGPT, Gemini, Perplexity).
- Concurrents : ce qu'ils font mieux, les angles qu'ils laissent libres.
- Sites de référence du client (fiche, partie 7) : pour chacun, relever comment il est construit. C'est-à-dire les sections de l'accueil et leur ordre, la présentation des services, le nombre de clics jusqu'au contact, le rythme des couleurs, ce qui fonctionne et ce qui gêne. Croiser avec ce que le client dit aimer ou non. On s'inspire de la construction ; on ne reprend jamais les textes, les visuels ni une mise en page à l'identique. Beaucoup de sites ne peuvent pas être lus depuis la session : partir alors de ce que Junior a noté au rendez-vous, ou de ses captures d'écran.
- Proposer les couleurs du client (clé `couleurs` : `fond`, `clair`, `surface`, `nuance`, `texte`, `texte-doux`, `accent`, `secondaire`, `deco`, `sombre`), à partir de son logo ou de sa charte. Sans couleurs, le site reste en noir, blanc et gris : c'est un choix possible, pas un oubli. Vérifier le contraste AA (4,5:1) avec `.github/outils/contraste.py` ; le rapport de l'import le signale aussi. Proposer les polices (clé `polices` : titres, texte, accent, chiffres) parmi celles livrées (`inc/polices-livrees.json`). Demander le logo dès le rendez-vous, avec une version pour fond foncé si le pied de page est sombre.
- Proposer la personnalité du site, client par client : angles (`standard`, `doux`, `droits`, `feuille`, `biseau`), forme des photos (`standard`, `arche`, `galet`), relief des cartes (`ombre`, `bordure`, `plat`), étiquettes de section (`texte`, `numerotees`), mot surligné (`couleur`, `aplat`), titres en capitales (`oui`, `non`).
- Profession réglementée (santé, droit, chiffre) : pas de témoignages ni de note, pas de promesse de résultat, vocabulaire sobre.

Livrable : synthèse et positionnement. Validation.

## Phase 2 : étude sémantique

- Requêtes de service × lieu (« escalier sur mesure Milly-la-Forêt »), de besoin, de prix, de comparaison, et les questions telles qu'on les pose à Google ou à une IA.
- Une requête principale par page ; jamais deux pages sur la même requête.
- Pages par ville : seulement si l'entreprise a une vraie présence ou un vrai contenu pour cette ville (chantiers, adresse, spécificités). Des pages villes à la chaîne sont des pages satellites sanctionnées par Google.
- Dire que les volumes ne sont pas connus : Junior les vérifie et peut reclasser. Outils gratuits : générateur de mots-clés Ahrefs (illimité, pays France), planificateur de mots-clés Google ciblé sur le département (compte sans campagne), Semrush gratuit (10 analyses par jour, pour les concurrents), Google Trends (comparer deux formulations).
- Requêtes d'information, à chercher pour chaque service : « [produit] avantages inconvénients », « prix [produit] », « [type A] ou [type B] », « norme [produit] », « entretien [produit] ». Elles alimentent les sections « Quel modèle choisir ? » des pages de service et les guides (articles). Un type de produit qui a son propre volume et que le client fabrique vraiment mérite sa page de service, pas un simple guide.
- Les outils ne mesurent presque jamais une requête avec un nom de ville (« escalier métallique Essonne » donne 0) : faire tester les termes sans lieu. La requête principale d'une page est le terme seul ; le lieu va dans le titre, la description et le texte. Le classement local repose surtout sur la fiche Google.

Livrable : tableau requête, intention, page cible. Validation.

## Phase 3 : architecture et parcours

- Arborescence : accueil, une page par service important (sous-pages de la page des services), preuves (réalisations, avis), à propos, FAQ si utile, page d'action, pages légales.
- Quand le client a des sites de référence, l'arborescence et l'ordre des sections partent de leur construction, puis sont confrontés à la recherche (phase 2) et à l'offre réelle du client. Chaque écart avec la référence est expliqué au client en une phrase (« votre référence regroupe tous les services sur une page ; nous en faisons une par service, pour être trouvé sur chacun »).
- Menu de 5 à 6 entrées au plus, services en sous-menu, page d'action en bouton (en-tête, pied de page, bouton fixe mobile). Toute page à 3 clics au plus de l'accueil.
- Pour chaque page : objectif, requête, sections du thème dans l'ordre avec, pour chacune, sa version, la place de son titre et sa couleur de fond, et l'action principale.

Revue UI/UX, avant de composer : le site doit être le plus attrayant possible pour les visiteurs de ce métier, pas seulement correct.
- Se mettre à la place du visiteur de ce métier : ce qu'il veut voir d'abord, ce qui le fait rester, ce qui le fait réserver ou appeler. Un salon de coiffure, une photographe, un restaurant se choisissent sur l'image et l'ambiance : les photos du travail et du lieu passent avant le texte, les prix sont visibles, la réservation est à un clic. Un artisan du bâtiment se choisit sur la preuve et la confiance : réalisations, avis, garanties, déroulé. Un cabinet (comptable, avocat, thérapeute) se choisit sur la personne et la clarté : qui, pour qui, comment, combien.
- Ne retenir que les sections qui servent ce visiteur. Une section utile ailleurs peut être hors sujet ici : « Est-ce pour vous ? » ou des étapes détaillées n'apportent rien à un salon de coiffure ; une liste de services en texte ne fait pas envie là où l'on attend des photos.
- Rythme visuel : jamais deux sections de texte à la suite ; une photo forte au moins tous les deux écrans ; les dispositions changent d'une section à l'autre (grille, pleine largeur, côte à côte, défilement) ; une bande foncée au plus avant l'appel final.
- Premier écran sur téléphone : qui, quoi, où et le bouton d'action, avec une photo qui donne envie.
- Écrire l'ordre des sections avec, pour chacune, la question du visiteur à laquelle elle répond. Une section qui ne répond à aucune question de ce visiteur sort de la page.
- En-tête et pied de page se choisissent avec la même question, parmi ceux du thème (`variantes.json`), jamais par défaut. Le pied de page répond à ce que le visiteur cherche en bas de page : un commerce ou un salon où l'on vient sur place, « Plan et horaires » (`carte`) ; un dépannage, « Grand appel » (téléphone en très grand) ; un site court, « Compact » ; une marque au nom court, « Nom géant » ; beaucoup de services, « Colonnes » ; une ambiance claire sans bloc sombre, « Clair » ; tout centré et sobre, « Centré ». Remplir ce qu'il affiche (horaires, plan, services), sinon il paraît vide.
- S'appuyer sur la compétence `ui-ux-pro-max` pour la direction visuelle d'un métier (`--design-system` : structure de page, style, couleurs, typographie, pièges à éviter), en gardant les sections et versions du thème. Dire quand elle ne trouve rien et que la recommandation vient de notre jugement.

Composer chaque page avec la bibliothèque :
- Accueil, dans cet ordre : l'en-tête, l'ouverture avec l'action principale (famille Ouverture, ou une ouverture à part comme « une question pour commencer »), les services, puis les preuves et la réassurance (avis, chiffres, réalisations, engagements, avant / après, logos), puis le parcours (étapes, « Où en êtes-vous ? », questions fréquentes) et l'appel à l'action final.
- Choisir chaque section dans `catalogue-sections.md` d'après ce que le client peut vraiment fournir (colonne « Besoins ») : une section sans son contenu réel ne se publie pas.
- Choisir la version de chaque section d'une famille (tableau « Versions des sections ») : la classe `br-<famille>--<version>` de la section, ou le paramètre `version` des fonctions de `build_br_sections.js` (`services({ version: 'apercu' })`, `ouverture({ version: 'banniere' })`…). Varier les versions d'une page à l'autre, et d'un site à l'autre.
- Place du titre : laisser `rythmeTout()` la choisir, ou l'imposer par la classe `br-titre--<position>` (`gauche`, `centre`, `droite`, `cote`, `geant`, `filet`, `marge-gauche`, `marge-droite`) ; seulement une position permise pour cette section (tableau « Positions permises » du catalogue, règles `reglesTitres` de `inc/familles.json`). Deux sections voisines n'ont jamais leur titre au même endroit.
- Habillage du site, une fois pour tout le site : `entete`, `pied`, `mobile`, `cartes`, `titres`, `cartes_mobile`, et la personnalité ci-dessus. Avant de fixer la combinaison, la contrôler avec `python3 registre.py --essai entete=… ouverture=… cartes=… …` (au moins trois pièces différentes des sites déjà livrés, une ouverture différente des deux derniers), puis l'ajouter à `registre-sites.json`.
- Sites de référence du client : rapprocher chaque section qu'il aime d'une section ou d'une version de la bibliothèque. Ce qui n'existe pas encore devient une proposition à Junior (nouvelle section ou version, construite pour tous les métiers), jamais une copie.
- Rythme des couleurs : deux sections voisines n'ont jamais le même fond, sinon elles se lisent comme un seul bloc. Alterner `fond`, `surface` et `nuance` ; garder la bande foncée (`secondaire`) pour l'appel à l'action final, et une seule autre au plus par page. Une tête de page peut précéder une section du même fond. Après l'import, le client change un fond en un clic : section sélectionnée, onglet Styles, « Fond clair », « Fond teinté », « Fond nuancé » ou « Fond foncé ».
- En-tête avec photo (section « En-tête de page avec photo » : texte à gauche, photo nette à droite, sans voile ; la photo est l'image mise en avant de la page, 1 400 px de large au moins) : à prévoir d'office, sans attendre qu'on le demande, selon ce tableau. Variante « En-tête de page avec trois photos » (mosaïque) quand le client a trois bonnes photos de ce sujet. Le bandeau pleine largeur (« En-tête bandeau photo pleine largeur ») seulement avec une photo de 2 400 px au moins : sinon elle est floue.

| Page | En-tête |
| --- | --- |
| Chaque page de service | Photo |
| À propos, L'atelier, Le cabinet, Équipe | Photo |
| Zone d'intervention, page des réalisations | Photo seulement si le client en a une forte (atelier, chantier, vue de la zone) |
| Devis, Contact | Simple : le formulaire doit rester visible sans défiler |
| FAQ, pages légales, articles | Simple |
| Toute page sans vraie photo du client | Simple, jamais une image de banque |

- Jamais une section pour une seule phrase : une phrase isolée entre deux sections se lit comme une erreur. La fondre dans le paragraphe de la section voisine, ou l'étoffer en vraie section (titre et deux ou trois phrases).
- Réalisations : une fiche par réalisation (menu Réalisations, nom réglable : Portfolio, Chantiers, Projets), avec des grilles automatiques sur l'accueil, la page des réalisations (filtres par catégorie) et chaque page de service. La page qui les liste porte l'adresse du nom choisi (`/realisations/`, `/portfolio/`).

Maillage interne : les liens écrits dans le texte disent à Google quelles pages comptent et de quoi elles parlent. Le menu et le pied de page ne suffisent pas.
- Ce que le thème fait seul : cartes de service de l'accueil vers chaque service (`{{SERVICE:n}}`, `{{URL:service-n}}`), section « Pages liées » (la page des services liste chaque service, chaque service liste les autres), fil d'Ariane vers la page parente, grilles de réalisations (chaque fiche renvoie à son service, chaque service montre ses fiches).
- Ce que la stratégie prévoit : un **tableau des liens**, page par page, avec les liens reçus, les liens envoyés et le texte de chaque lien.
- Règles du tableau :
  - chaque page indexée reçoit au moins deux liens depuis le texte d'autres pages ;
  - l'accueil mène à chaque service important ;
  - chaque service mène à ses réalisations, à sa FAQ et à la zone ; les réalisations et la FAQ renvoient au service concerné ;
  - chaque article de blog renvoie au service qui lui correspond ;
  - aucun lien vers une page d'atterrissage, une page en noindex ou une page supprimée.
- Parcours mobile d'abord : l'essentiel visible sans défiler (qui, quoi, où, comment contacter).
- Formulaire : seulement les champs utiles pour répondre ; téléphone cliquable partout, et sur les pages Devis et Contact un vrai bouton d'appel `[briise_appel texte="Appeler [prénom]"]`, jamais une simple ligne de texte : beaucoup de prospects préfèrent appeler.
- Avant / après : la version « À faire glisser » seulement si les deux photos sont prises du même endroit avec le même cadrage ; sinon, « Côte à côte » ou « Avant en médaillon ». Variante utile pour un artisan qui fait des plans 3D : « plan 3D / ouvrage posé ».
- Proportions : un héros d'accueil tient en 3 lignes de titre au plus (raccourcir le titre ou garder la taille par défaut) ; une section ne doit jamais paraître vide, et une grille ne laisse jamais une carte seule sur sa ligne.
- Formulaire de devis du thème (Fluent Forms gratuit) : nom, téléphone, e-mail facultatif, commune, projet (liste des services), description obligatoire ; pas de case RGPD, une phrase d'information. Pas d'envoi de photos (payant dans Fluent Forms) : l'e-mail de confirmation invite le visiteur à répondre avec ses photos. Plusieurs personnes doivent recevoir les demandes : Mon entreprise > Entreprise > « Autres adresses qui reçoivent les demandes », une par ligne (demander les adresses au rendez-vous).

Livrable : arbre des pages, maquette en sections de chaque page (avec ses couleurs de fond) et tableau des liens. Validation.

## Phase 4 : contenus

Rédiger chaque page avec les sections du thème (`patterns/section-*.php`). Les textes d'exemple des sections sont des consignes, écrites pour tous les métiers : chacun est remplacé par un texte du client, et chaque marque « [prix] », « [00] ans », « [note] » par un fait vérifié. Aucun texte d'exemple ni aucune marque ne reste à la mise en ligne.

Contenu utile et unique, celui que Google et les IA mettent en avant :
- partir des faits de la fiche : chiffres, délais, méthode, matériaux, villes, histoires de clients, mots du client ;
- aucun paragraphe générique qu'un concurrent pourrait signer ; produire peu de pages mais riches (la production de pages en masse sans valeur est sanctionnée par Google, quelle que soit la façon dont elles sont écrites) ;
- montrer l'expérience : qui fait le travail, depuis quand, comment.

Le regard du prospect, à appliquer d'office à chaque page, sans attendre qu'on le demande. Le visiteur n'est pas du métier, il est pressé et il ne cherche pas : ce qu'il ne trouve pas tout de suite n'existe pas pour lui, et ce qu'il ne comprend pas le frustre. Avant d'écrire une page de service, lister ses questions dans l'ordre où il se les pose. Cet ordre est le fil conducteur de la page : les sections se suivent comme un récit, chacune répond à la question que la précédente fait naître, jamais dans l'ordre des rubriques du métier.

| Étape du récit | Question du prospect | Section, avec ses images |
| --- | --- | --- |
| 1. La promesse | C'est quoi, et est-ce pour moi ? | En-tête : ce que c'est, prix de départ, délai, une photo réelle |
| 2. Le bénéfice | Qu'est-ce que ça m'apporte ? | Trois bénéfices concrets, chacun avec sa photo, jamais une liste de caractéristiques |
| 3. Le choix | Quel modèle choisir ? | Une carte par modèle avec sa photo, sa place, son prix, pour qui, et ses limites dites franchement ; tableau seulement pour comparer beaucoup de critères |
| 4. La preuve | Ils l'ont déjà fait ? Qui viendra chez moi ? | Réalisations près de chez moi (photos), avis réels ; sous la grille, une seule ligne avec une petite photo : qui fabrique, depuis quand, où, et un lien vers la page à propos (pas de section dédiée, l'histoire est sur la page à propos) |
| 5. Le déroulé et le prix | Comment ça se passe, combien ça coûte ? | Étapes illustrées (visite, plan, atelier, pose), démarches, prix et ce qui le fait varier, dans une même section |
| 6. Les doutes | Ce qui me fait hésiter | FAQ des objections réelles (entretien, rouille, norme, délai, impévu) |
| 7. L'action | Et maintenant ? | Bouton de devis, avec ce qu'il faut préparer et le délai de réponse |

Images : jamais plus d'un écran de texte sans une photo ; une page de service entièrement en texte fatigue et ne convainc pas. Uniquement de vraies photos du client (chantiers, atelier, équipe) ; s'il n'en a pas assez, prévoir une séance photo avant la rédaction, et lister les photos à prendre page par page.

L'entreprise : son histoire se raconte par ce qu'elle garantit au prospect (encore là pour la garantie, déjà fait ce qu'il veut, proche de chez lui). Sur chaque page de service, une ligne et une petite photo sous les réalisations (étape 4) ; sur la page à propos, l'histoire complète : création et grandes étapes, équipe, chiffres vérifiables, et ce que ça garantit au client. Uniquement les faits de la fiche client.

Règles d'écriture qui en découlent :
- chaque mot technique est expliqué par sa conséquence pour le client (« limon central : une seule poutre sous les marches, l'escalier paraît plus léger et laisse passer la lumière ») ;
- un visiteur qui survole comprend l'essentiel en 30 secondes (en-tête, trois bénéfices, prix) ; le détail vient plus bas ou dans un guide, pour ne jamais noyer le bouton de devis ;
- tableaux, intertitres-questions, faits en gras, photos légendées ; un bouton après chaque grand bloc ;
- les inconvénients se disent : c'est ce qui rend le reste crédible, pour le prospect comme pour Google et les IA ;
- les faits (prix, délais, garanties, objections fréquentes) viennent de la fiche client ; sinon, une question au client.

Guides : un article par question d'information importante (phase 2), écrit depuis la pratique du client et non comme une définition générale, qui renvoie à la page de service ; la page de service renvoie au guide.

Référencement de chaque page :
- un seul H1, avec la requête principale ; intertitres H2 et H3 logiques ;
- titre Google de 60 caractères au plus et description de 155 au plus, uniques ;
- adresse courte et lisible ;
- liens internes placés dans le texte, là où ils aident le lecteur, selon le tableau des liens ; texte du lien qui dit où il mène, avec des mots variés (« nos escaliers en acier sur mesure », jamais « en savoir plus » ou « cliquez ici ») ; pas la même formule exacte répétée sur tout le site ;
- images : texte alternatif qui décrit vraiment la photo.

Lisibilité pour les IA :
- chaque section commence par sa réponse ou son fait principal, en phrases autonomes et précises (prix, délai, zone, nom de l'entreprise) ;
- FAQ : la question telle qu'un prospect la pose, une réponse qui commence par oui, non, un prix ou un délai, en deux à quatre phrases ; quelques questions sur chaque page de service plutôt qu'une seule grande FAQ ;
- nom, adresse et téléphone identiques partout, au caractère près.

Avis : uniquement des avis réels, cités mot pour mot avec l'accord de l'auteur ; jamais de sélection trompeuse. Les avis publiés sur le site ne donnent pas d'étoiles dans Google ; afficher la source et la date de chaque avis, et dire comment ils sont collectés (obligation légale).

Réalisations : pour chacune, « La demande » et « Ce que nous avons fait », la ville, la date, le service et la catégorie. Au moins 150 mots : en dessous, la fiche reste sur le site mais sort de Google (signalée dans Contrôle). Deux ou trois paragraphes, jamais une légende de photo.

Livrable : textes page par page. Relecture par Junior, puis validation du client.

## Phase 5 : design, accessibilité, performance

- Couleurs, polices et personnalité validées ; contraste AA de chaque couleur de texte.
- Rythme des couleurs respecté sur chaque page : Mon entreprise > Contrôle, rubrique « Couleurs des sections », sans alerte.
- Accessibilité WCAG 2.2 niveau AA : zones cliquables d'au moins 24 × 24 px, focus clavier visible et jamais masqué par l'en-tête ou le bouton fixe, champs de formulaire avec étiquette liée, navigation complète au clavier, animations coupées si le visiteur le demande. Ces mêmes règles rendent le site utilisable par les agents IA.
- Images : l'extension enregistre chaque photo JPEG ou PNG envoyée en WebP (Fonctions > Photos en WebP) ; 200 Ko au plus pour la photo d'ouverture, dimensions réelles, point focal réglé pour le mobile.
- Objectifs mesurés sur mobile : LCP 2,5 s au plus, INP 200 ms au plus, CLS 0,1 au plus ; Lighthouse 90 au moins. Mesurer sur le vrai serveur : un serveur de test sans compression ni cache allonge le LCP.

## Phase 6 : fichier de site

Produire le JSON importé dans Mon entreprise > Démarrage > « Importer un fichier de site » (format complet dans le README) :
- `entreprise`, `legal`, `annonces` (horaires), `couleurs`, `polices`, `styles`, l'habillage (`entete`, `pied`, `mobile`, `cartes`, `titres`, `capitales`, `cartes_mobile`, `angles`, `photos`, `relief`, `etiquettes`, `surlignage`), `cta`, `cta_label`, `accueil`, `faq`, `personne`, `blog`, `statut` (`draft` pour la première installation) ; plus de clé `ambiance` (ignorée et signalée) ;
- dans `entreprise`, toujours `name` et `slogan` (nom du site, logo, pied de page) et le `type` d'activité exact : un métallier, un menuisier ou un maçon est « HomeAndConstructionBusiness », jamais « Locksmith » (serrurier) ;
- `couleurs` donne les dix couleurs du site ; une couleur absente garde sa valeur neutre (noir, blanc ou gris). Vérifier que la bande `secondaire` se distingue du pied de page foncé ;
- `entreprise` porte aussi la note Google réelle (`avis_note`, par exemple « 4,8 », et `avis_nombre`) : remplie, elle s'affiche dans la carte d'infos de l'ouverture ; jamais une note inventée ou arrondie à la hausse ;
- `entreprise` peut aussi porter les champs des cartes Coordonnées et Zone (`precision_telephone`, `precision_email`, `precision_adresse`, `badge_coord_titre`, `badge_coord_texte`, `badge_zone_titre`, `badge_zone_texte`, `zone_soustitre`, `zone_secteurs`) et les réseaux (`instagram`, `facebook`, `linkedin`, `google`, `tiktok`, `youtube`, `pinterest`), affichés en icônes dans le pied de page ;
- `pages` : `slug`, `titre`, `parent`, `menu`, `seo_titre`, `seo_description`, et `markup` ou `modele` ;
- `realisations` : `titre`, `ville`, `date` (AAAA-MM), `service` (adresse de la page), `categories`, `resume`, `demande` et `solution` (listes de paragraphes) ; créées après les pages, photos ajoutées ensuite dans chaque fiche ;
- sections automatiques : `[briise_realisations nombre="3"]` (accueil), `[briise_realisations filtres="1"]` (page des réalisations), `[briise_realisations service="auto" nombre="3"]` (pages de service), `[briise_formulaire type="devis"]` ou `type="contact"` (créé d'office à l'import si Fluent Forms est actif) ; en-tête des pages de service : `teteSplit()` ou `teteMosaique()` de `build_br_sections.js` (classe `br-tete`), et sections du récit (familles et sections du catalogue, avec leur version) ; une page qui commence par un en-tête du thème prend seule le gabarit sans titre ;
- le `markup` se fabrique avec `.github/outils/build_br_sections.js` (blocs créés par `@wordpress/blocks`, donc valides), jamais à la main ; repères : `{{CTA}}`, `{{CTA_LABEL}}`, `{{URL:slug}}`, `{{IMG:nom}}`, `{{TITRE}}`, `{{SERVICE:n}}` et `{{URL:service-n}}` (n-ième sous-page de la page des services, dans l'ordre du fichier) ;
- passer chaque page par `rythmeTout()` de `.github/outils/build_br_kits.js` : elle change le fond d'une section qui a la même couleur que sa voisine, et la place d'un titre qui serait au même endroit que celui de la section précédente, parmi les places permises ;
- chaque page de service contient la section « Pages liées » (`[briise_pages_liees]`), la page des services aussi ; les liens du tableau des liens sont écrits dans le `markup` avec `{{URL:slug}}` ;
- page d'atterrissage publicitaire : `"modele": "atterrissage"` (gabarit sans menu, noindex et hors plan du site automatiquement) ;
- contrôler avec `.github/outils/validate.js` : zéro bloc invalide ;
- modèle complet de fichier de site : `.github/outils/exemples/build_lison.js` (cliente fictive Lison Vautrin, photographe), à copier pour un nouveau client ; outils lancés depuis `.github/outils` après `npm ci` ;
- aperçu avant livraison : `node apercu.js site-[client].json` écrit `build/apercu-site-[client].html` ; ouvert dans un navigateur, il monte le site dans WordPress Playground (thème et extension de `main`, ou `--branche nom`). Avec `--photos photos.json` (nom de l'image dans le fichier de site, adresse de la photo), l'aperçu place de vraies photos, celles du client ou des photos d'essai libres de droits : sans elles, on ne juge pas l'attrait d'une page. Avant de montrer l'aperçu, le parcourir comme un visiteur, sur ordinateur et sur téléphone, page par page : capture, critique de designer (envie, lisibilité, rythme, place de l'action, sections hors sujet), corrections, nouvel aperçu. Ensuite seulement le montrer à Junior, puis au client : c'est la maquette réelle. `node apercu.js --catalogue` montre toutes les sections et leurs versions, avec le choix de l'en-tête, du pied de page et des fonds, pour choisir ensemble ;
- tester l'import sur un site WordPress de test avant de livrer le fichier : onglet Contrôle, captures sur ordinateur et mobile, Lighthouse. Sur un site neuf, supprimer d'abord la « Page d'exemple » et l'article « Bonjour tout le monde ! ». La session ne peut pas télécharger d'extension depuis WordPress.org : pour tester avec Fluent Forms, demander à Junior les fichiers zip.
- toute modification du thème ou de l'extension passe par le banc d'essai avant d'être envoyée : `bash .github/outils/banc/lancer.sh` (WordPress neuf, import de Lison, Contrôle, pages, sécurité, WebP, accessibilité ; `BANC_COPIE_DE` pour partir d'un WordPress déjà présent quand la session ne peut pas le télécharger). GitHub le relance à chaque envoi et bloque la publication s'il échoue ; une nouveauté du thème ajoute sa propre vérification au banc.

Livrable : `site-[client].json` envoyé en fichier. Validation (guide de vérification, étape 2).

Après l'import, Junior ouvre Mon entreprise > Contrôle. Il y voit les pages qui reçoivent moins de deux liens, les pages à plus de trois clics, les liens cassés, les liens vers une page exclue, les textes vagues et les sections voisines de même couleur. On corrige jusqu'à « Aucun problème détecté » (guide, étape 3).

## Phase 7 : mise en ligne

Liste à suivre avec Junior ; le détail de chaque contrôle est dans le guide de vérification, étapes 3 et 4 :
- Installation : extension Briise Socle puis thème Briise (fichiers de la dernière version GitHub) ; ensuite, les mises à jour arrivent dans Tableau de bord > Mises à jour. Fluent Forms et FluentSMTP s'installent en un clic depuis Mon entreprise > Fonctions > Formulaires, sur chaque site client ; crédit « Site réalisé par Briise » (Fonctions) activé seulement si le contrat le prévoit ; FluentSMTP relié à la boîte e-mail du domaine (SPF, DKIM, DMARC réglés), e-mail de test reçu. Pas à pas : Mode d'emploi Briise, étapes 1 à 3.
- Image mise en avant de chaque page de service et photos des réalisations en place.
- HTTPS ; une seule adresse de référence (avec ou sans www), l'autre redirigée.
- Refonte : redirections 301 de chaque ancienne page utile vers la nouvelle page équivalente ; jamais vers l'accueil par défaut. Liste des anciennes adresses relevée avant la refonte (plan du site, Search Console), redirections faites avec l'extension gratuite Redirection, 404 surveillées un mois (Mode d'emploi, étape 12).
- Domaine : ne modifier que les enregistrements du site ; les réglages des e-mails (MX) restent intacts, à vérifier après bascule.
- robots.txt : le thème autorise les moteurs et les robots de recherche des IA ; l'entraînement des IA se décide avec le client (Mon entreprise > Fonctions). Vérifier domaine.fr/robots.txt : un vrai fichier robots.txt à la racine du serveur remplace celui du thème. Attention aux pare-feu et CDN qui bloquent les robots IA par défaut.
- Search Console : propriété vérifiée, plan du site envoyé, client propriétaire. Bing Webmaster Tools : même chose (import depuis Search Console, ou code dans Mon entreprise > Fonctions) ; l'index de Bing alimente une partie des réponses de ChatGPT. IndexNow ne fonctionne qu'en environnement de production : le vérifier dans Bing Webmaster Tools > IndexNow.
- Données structurées testées (test des résultats enrichis), une seule balise H1 par page, pages légales hors de Google.
- Cookies : un site Briise n'en dépose aucun, donc pas de bandeau. Matomo configuré selon l'exemption CNIL reste sans bandeau. Dès que le client ajoute Google Analytics, Google Ads, un pixel, une carte Google Maps, une vidéo YouTube ou un reCAPTCHA : Complianz, testé (refus = aucun cookie). La version gratuite suffit pour Google Analytics seul : elle bloque le script tant que le visiteur n'a pas accepté. Avec Google Ads (conversions, remarketing), le mode consentement v2 est obligatoire : Complianz Premium, ou une autre extension certifiée par Google qui l'inclut gratuitement, à vérifier au moment de l'installer, lien « Gérer mes cookies » en pied de page (Mode d'emploi, étape 10).
- Sécurité : protections de l'extension actives (Fonctions > Protections de sécurité ; elles bloquent aussi la connexion 15 minutes après 5 échecs) ; pas de compte « admin » ; le client a un compte Éditeur, jamais Administrateur ; double authentification sur le compte GitHub de l'agence (les mises à jour de tous les sites en viennent) ; double authentification (Two Factor) pour chaque administrateur ; sauvegardes automatiques hors serveur ; mises à jour automatiques ; extensions inutiles supprimées ; Mon entreprise > Contrôle, rubrique Sécurité, vide le jour de la mise en ligne (Mode d'emploi, étape 11).
- Guide de vérification, étapes 3 et 4 cochées : plus aucun « [à compléter] », onglet Contrôle sans alerte, compte Éditeur remis au client.

## Fin de collaboration

Le site appartient au client. S'il part : Mon entreprise > Fin de collaboration (exporter le fichier de site, figer les contenus pour qu'ils restent lisibles sans l'extension, les fiches de réalisation devenant des pages à la même adresse), sauvegarde complète de l'hébergement, comptes remis (domaine ou code de transfert, hébergement, administrateur WordPress, Search Console, fiche Google, mesure d'audience), demandes du formulaire exportées. Guide de vérification, étape 6.

## Phase 8 : présence locale hors site

Socle à prévoir dans chaque projet ; la gestion dans la durée est une option.
- Fiche Google Business Profile complète : catégorie principale exacte (le premier facteur du classement local), catégories secondaires, services, zone, horaires, description, photos réelles, lien vers le site.
- Bing Places (import depuis Google), Apple Plans (Apple Business Connect), PagesJaunes, annuaires du métier et de l'ordre professionnel.
- Nom, adresse, téléphone identiques partout, au caractère près, comme sur le site.
- Avis : demander à tous les clients, sans trier les satisfaits (interdit), répondre à chacun ; un flux régulier d'avis récents compte pour Google comme pour les IA.

Livrable : textes prêts à coller pour chaque fiche (description, services, catégories proposées) et modèle de demande d'avis.

## Phase 9 : suivi à 30, 60 et 90 jours

- Search Console : pages indexées, requêtes, positions, Core Web Vitals.
- Fiche Google : appels, itinéraires, avis gagnés.
- Test IA : les mêmes questions qu'au départ, sur ChatGPT, Gemini et Perplexity.
- Proposer les contenus suivants : nouvelle réalisation, question fréquente, page de service qui manque.

## Option Google Ads

Quand le client lance des campagnes :
- une page d'atterrissage par service promu (modèle « Page d'atterrissage (publicité) »), avec le même message que l'annonce, l'action principale visible sans défiler et le téléphone cliquable ; le gabarit l'exclut de Google et retire le menu ;
- conversions suivies : le thème envoie l'événement `briise_contact` (téléphone, e-mail, formulaire) dans `dataLayer` ; il reste à créer dans Tag Manager le déclencheur et la balise de conversion, derrière un bandeau de consentement certifié et le mode consentement v2 (obligatoire en Europe) ; conversions améliorées pour les demandes de contact ;
- un numéro de suivi d'appels ne remplace jamais le numéro principal sur le site ni sur la fiche Google (cohérence des coordonnées) ;
- budget et coût par contact fixés à partir de la valeur d'un client (fiche, partie 11).

## Limites à rappeler

- Pas d'accès aux volumes de recherche réels : Junior les vérifie.
- Pas de photos inventées : le client les fournit, ou une séance est prévue.
- Les demandes reçues par le formulaire restent enregistrées dans Fluent Forms : les supprimer au-delà de la durée annoncée dans la politique de confidentialité (3 ans).
- Informations légales et avis : uniquement ce que le client fournit, vérifié par Junior.
- Le client relit et valide tous les textes avant la mise en ligne.
- Les réponses des IA varient d'une fois sur l'autre : on mesure une tendance, jamais une position garantie.