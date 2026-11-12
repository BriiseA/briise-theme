<?php
/**
 * Title: Ouverture : Hero bannière plein écran
 * Slug: briise/hero-banniere
 * Categories: briise-ouverture
 * Description: Grande photo pleine largeur, titre et bouton posés dessus. Le voile sombre garantit la lisibilité, quelle que soit la photo.
 * Viewport Width: 1400
 */
$briise = briise_entreprise();
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>","dimRatio":70,"overlayColor":"sombre","isUserOverlayColor":true,"minHeight":82,"minHeightUnit":"vh","contentPosition":"bottom left","align":"full","className":"br-banniere","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-bottom-left br-banniere" style="min-height:82vh"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-sombre-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"br-banniere-inner","layout":{"type":"default"}} -->
<div class="wp-block-group br-banniere-inner"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Votre activité, votre ville</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Un titre court, qui donne envie</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase qui complète le titre. La photo doit montrer votre travail, votre lieu ou votre équipe : pas une image de banque d’images.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Voir nos réalisations</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
