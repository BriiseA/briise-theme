<?php
/**
 * Title: Ouverture : Hero avec image
 * Slug: briise/hero-image
 * Categories: briise-ouverture
 * Description: Ouverture de l’accueil ou d’une page de service : titre, phrase d’accroche, deux boutons, photo.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-hero"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"56%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:56%"><!-- wp:group {"className":"br-chips","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group br-chips"><!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Atout n° 1</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Atout n° 2</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Votre ville</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre qui dit ce que vous faites, et où</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une ou deux phrases pour dire à qui vous vous adressez et ce qui vous distingue. Restez concret : un visiteur décide en quelques secondes s’il est au bon endroit.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Découvrir nos services</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-galet"} -->
<figure class="wp-block-image size-full is-style-br-galet"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : décrivez ce qu’elle montre" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
