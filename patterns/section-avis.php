<?php
/**
 * Title: Confiance : Avis (5 versions)
 * Slug: briise/avis
 * Categories: briise-confiance
 * Description: La note Google et quatre avis de clients, chacun avec la photo de la réalisation dont il parle. Choisissez la forme dans le panneau « Version » : grille, note en avant, un avis en grand, mur d’avis ou défilement. Uniquement la vraie note et des avis réels, recopiés mot pour mot avec l’accord de leur auteur (jamais pour une profession réglementée). Retirez la note si vous n’avez pas de fiche Google.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-temoignages br-temoignages\u002d\u002dgrille br-titre\u002d\u002dcentre","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-temoignages br-temoignages--grille br-titre--centre has-surface-background-color has-background"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Ce qu’en disent nos clients</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="#">Tous les avis sur Google</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-temoignages-corps","layout":{"type":"default"}} -->
<div class="wp-block-group br-temoignages-corps"><!-- wp:group {"className":"br-temoignages-note","layout":{"type":"default"}} -->
<div class="wp-block-group br-temoignages-note"><!-- wp:paragraph {"className":"br-note"} -->
<p class="br-note"><strong class="br-note-chiffre">4,9</strong> <span class="br-note-detail"><span class="br-etoiles" aria-hidden="true">★★★★★</span><span>sur 5, 62 avis Google</span></span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-temoin-liste","layout":{"type":"default"}} -->
<div class="wp-block-group br-temoin-liste"><!-- wp:group {"className":"br-temoin","layout":{"type":"default"}} -->
<div class="wp-block-group br-temoin"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-temoin-photo"} -->
<figure class="wp-block-image size-large br-temoin-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : la réalisation dont parle ce client"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-avis-etoiles"} -->
<p class="br-avis-etoiles"><span class="br-etoiles" aria-hidden="true">★★★★★</span></p>
<!-- /wp:paragraph -->

<!-- wp:quote {"className":"br-temoin-citation"} -->
<blockquote class="wp-block-quote br-temoin-citation"><!-- wp:paragraph -->
<p>Recopiez ici un avis réel, mot pour mot. Les plus convaincants racontent une situation précise et son résultat.</p>
<!-- /wp:paragraph --><cite><strong>Prénom N.</strong><br>Prestation, ville</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-temoin","layout":{"type":"default"}} -->
<div class="wp-block-group br-temoin"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-temoin-photo"} -->
<figure class="wp-block-image size-large br-temoin-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : la réalisation dont parle ce client"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-avis-etoiles"} -->
<p class="br-avis-etoiles"><span class="br-etoiles" aria-hidden="true">★★★★★</span></p>
<!-- /wp:paragraph -->

<!-- wp:quote {"className":"br-temoin-citation"} -->
<blockquote class="wp-block-quote br-temoin-citation"><!-- wp:paragraph -->
<p>Un deuxième avis, d’un autre type de client, pour que chacun s’y retrouve.</p>
<!-- /wp:paragraph --><cite><strong>Prénom N.</strong><br>Prestation, ville</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-temoin","layout":{"type":"default"}} -->
<div class="wp-block-group br-temoin"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-temoin-photo"} -->
<figure class="wp-block-image size-large br-temoin-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage-2.svg' ) ); ?>" alt="Photo à remplacer : la réalisation dont parle ce client"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-avis-etoiles"} -->
<p class="br-avis-etoiles"><span class="br-etoiles" aria-hidden="true">★★★★★</span></p>
<!-- /wp:paragraph -->

<!-- wp:quote {"className":"br-temoin-citation"} -->
<blockquote class="wp-block-quote br-temoin-citation"><!-- wp:paragraph -->
<p>Un avis qui parle du prix ou du devis : c’est la crainte numéro un.</p>
<!-- /wp:paragraph --><cite><strong>Prénom N.</strong><br>Prestation, ville</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-temoin","layout":{"type":"default"}} -->
<div class="wp-block-group br-temoin"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-temoin-photo"} -->
<figure class="wp-block-image size-large br-temoin-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : la réalisation dont parle ce client"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-avis-etoiles"} -->
<p class="br-avis-etoiles"><span class="br-etoiles" aria-hidden="true">★★★★★</span></p>
<!-- /wp:paragraph -->

<!-- wp:quote {"className":"br-temoin-citation"} -->
<blockquote class="wp-block-quote br-temoin-citation"><!-- wp:paragraph -->
<p>Un quatrième avis, court. Au-delà, renvoyez vers votre fiche Google.</p>
<!-- /wp:paragraph --><cite><strong>Prénom N.</strong><br>Prestation, ville</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
