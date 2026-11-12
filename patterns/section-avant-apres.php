<?php
/**
 * Title: Confiance : Avant / après
 * Slug: briise/avant-apres
 * Categories: briise-confiance
 * Description: Deux photos côte à côte pour montrer une transformation.
 * Viewport Width: 1400
 */
$briise = briise_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Avant / après</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Le titre de la transformation</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Le contexte en une phrase : la demande, la contrainte, le délai.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-avant-apres"} -->
<div class="wp-block-columns br-avant-apres"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-avap","layout":{"type":"default"}} -->
<div class="wp-block-group br-avap"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/avant.svg' ) ); ?>" alt="Avant : décrivez l’état de départ" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-chip br-avap-tag"} -->
<p class="br-chip br-avap-tag">Avant</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-avap","layout":{"type":"default"}} -->
<div class="wp-block-group br-avap"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/apres.svg' ) ); ?>" alt="Après : décrivez le résultat" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-chip br-avap-tag"} -->
<p class="br-chip br-avap-tag">Après</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
