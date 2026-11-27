# Briise : thème WordPress de l'agence

Thème de bloc (Full Site Editing) de l'agence web Briise, et son extension Briise Socle. Junior (Patrick Junior Malamba) s'en sert pour monter les sites de ses clients : artisans et entreprises locales de la métropole d'Orléans. Lis `README.md` pour le détail des fonctions ; ce fichier dit comment travailler dans le dépôt.

## Façon de travailler avec Junior

- En français. Une étape à la fois : propose, montre, attends sa validation avant d'enchaîner.
- Dis franchement ce qui est faible ou risqué, avec une alternative.
- Textes visibles (sections, écrans d'administration, README, CHANGELOG) : phrases courtes, vouvoiement du visiteur, aucun tiret cadratin (—), aucune formule creuse (« solutions innovantes », « n'hésitez pas »).
- Ne jamais inventer de données client (prix, avis, chiffres, labels). Les sites d'exemple sont fictifs et le disent.

## Structure

| Dossier | Rôle |
| --- | --- |
| racine (`style.css`, `theme.json`, `functions.php`, `templates/`, `parts/`, `styles/`, `assets/`) | Le thème : l'apparence |
| `inc/` | Code du thème : import d'un fichier de site, couleurs comprises (`kits.php`), polices (`polices.php`, `polices-livrees.json`), apparence (`apparence.php`), styles de section, performance |
| `patterns/section-*.php` | Les sections (compositions). **Générées : ne pas les modifier à la main.** |
| `extension/briise-socle/` | L'extension : Mon entreprise, référencement, formulaires, contrôle du maillage, cartes. Livrée à part (`briise-socle.zip`) |
| `.github/outils/` | Outils de fabrication (Node et Python), hors thème. Voir `.github/outils/LISEZMOI.md` |
| `.github/outils/exemples/` | Site d'exemple fictif Lison Vautrin (photographe, Olivet), et le site de l'agence (`site-briise.json`) |
| `.github/outils/banc/` | Banc d'essai : WordPress neuf (SQLite), import de Lison, vérifications, captures |

## Modifier une section

1. Changer la section dans `.github/outils/build_br_sections.js` (blocs créés avec `@wordpress/blocks`, donc toujours valides).
2. Régénérer, depuis `.github/outils` (après `npm ci`) :
   `node build_br_sections.js && python3 write_sections.py && node build_br_kits.js && python3 catalogue.py && node exemples/build_lison.js`
3. Le CSS des sections est dans `theme.json` (`styles.css`) et dans `assets/css/` (`sections.css`, `variantes.css`, `ux.css`, `motion.css`, `familles.css`).
   Familles (une section, plusieurs versions) : la version est la classe `br-<famille>--<version>` ; liste et panneau « Version » de l'éditeur dans `inc/familles.php`, CSS dans `familles.css`, comportements dans `assets/js/familles.js`. Une version doit rester lisible sans script.
4. Il n'y a plus d'ambiances : chaque section doit fonctionner avec n'importe quelles couleurs de client qui passent le contrôle AA (`python3 contraste.py`, et le rapport de l'import). Arrondis, ombres et capitales se règlent par site (Mon entreprise > Apparence).

Règles des sections : jamais de texte seul (une image ou un dessin à côté), deux sections voisines n'ont jamais le même fond ni leur titre au même endroit (fonctions `rythme()` et `rythmeTitres()` de `build_br_kits.js`, `rythmeTout()` pour les deux ; les positions de titre permises suivent `reglesTitres` de `inc/familles.json`, partagé avec l'éditeur et le catalogue), animations coupées si le visiteur demande à réduire les animations, cibles tactiles de 44 px, focus visible.

## Vérifier

- Blocs : `node validate.js build/banc_sections.json` doit finir par `invalid blocks: 0`.
- Banc complet (Linux ou WSL, avec PHP 8, unzip, Chrome) : `bash .github/outils/banc/lancer.sh`. `BANC_SANS_LIGHTHOUSE=1` saute la mesure d'accessibilité.
- GitHub lance le banc et les vérifications à chaque envoi (`.github/workflows/`). Sous Windows sans WSL, c'est la façon simple de tout vérifier : pousser une branche et lire le résultat des actions.

## Publier une version

1. Même numéro à trois endroits : `style.css` (Version), `extension/briise-socle/briise-socle.php` (Version et `BRIISE_SOCLE_VERSION`).
2. Une entrée en tête de `CHANGELOG.md`, écrite pour Junior : ce qui change pour lui ou ses clients, pas le détail technique.
3. Banc au vert, puis envoi sur `main`. Le workflow « Version installable » publie `briise.zip` et `briise-socle.zip` dès que le numéro change.

## Pièges connus

- `theme.json` porte l'essentiel du CSS (environ 110 Ko dans `styles.css`). WordPress remplace ce CSS par le CSS additionnel de l'utilisateur au lieu de l'y ajouter : le filtre `wp_theme_json_data_user` de `functions.php` remet le CSS du thème devant (1.19.2). Ne pas le retirer.
- Une page dont l'adresse existe déjà n'est jamais modifiée par l'import d'un fichier de site : pour réimporter, supprimer d'abord les pages.
- Les compteurs animés (`.br-stat`, tuiles) ne comptent qu'une valeur purement numérique : symbole facultatif devant (`+`, `~`), nombre, au plus une unité courte (`%`, `/5`, `ans`, `h`). Un prix (`€`) ou un texte avec un mot devant reste fixe. Essai : `.github/outils/essais/compteurs.html` (servir le dépôt en local, la page charge `assets/js/motion.js`).
- Titres en capitales (`br-capitales--oui`) : les colonnes de WordPress coupent les mots trop longs (`word-break: break-word`). Les grands titres en capitales l'annulent et portent `contain: inline-size` pour qu'un mot ne puisse pas élargir la colonne ; `ux.js` réduit alors le titre (jusqu'à 70 %, avec `!important` car certaines ouvertures fixent leur taille).
- Cache des pages : `extension/briise-socle/inc/cache.php` vide les extensions de cache à la fin de la requête dès qu'une option `briise_…` change (sauf mémoires internes listées dans le fichier). Une nouvelle option interne qui change souvent doit y être ajoutée à la liste d'exclusion, sinon chaque changement vide le cache.
- Personnalité (`assets/css/personnalite.css`) : chaque règle dépend d'une classe de `<body>` (`br-angles--droits`, `br-relief--bordure`, `br-etiquettes--numerotees`, `br-surlignage--aplat`, `br-titres--marge`, `br-police-chiffres`). Dans l'éditeur, `inc/apparence.php` remplace les classes actives par `.editor-styles-wrapper` : ne jamais écrire `main` dans ces sélecteurs (l'éditeur n'en a pas), utiliser `:is(.wp-site-blocks, .is-root-container)`.
- Polices d'une charte (`inc/polices.php`) : appliquées à chaque affichage par le filtre `wp_theme_json_data_user`, jamais écrites dans les styles globaux. Les polices proposées viennent de `theme.json` et de `inc/polices-livrees.json` (fichiers dans `assets/fonts`). Les variables `--wp--preset--font-family--titres`, `--texte` et `--accent` restent les seules à utiliser dans le CSS ; le mot surligné d'un titre lit `--accent` avec repli sur la police des titres.
