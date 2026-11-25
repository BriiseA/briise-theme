<?php
/**
 * Title: Ouverture : Grande photo et carte de garanties
 * Slug: briise/ouverture-carte
 * Categories: briise-ouverture
 * Description: Une grande photo pleine largeur avec le titre, puis une carte posée à cheval sur la section suivante : trois faits vérifiables (délai, ancienneté, garantie) et le bouton d’action.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>","dimRatio":70,"overlayColor":"sombre","isUserOverlayColor":true,"minHeight":72,"minHeightUnit":"vh","contentPosition":"center left","align":"full","className":"br-banniere br-ouv-plein br-ouv-carte","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-center-left br-banniere br-ouv-plein br-ouv-carte" style="min-height:72vh"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-sombre-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"br-banniere-inner","layout":{"type":"default"}} -->
<div class="wp-block-group br-banniere-inner"><!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre qui dit ce que vous faites, et où</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase qui complète le titre : pour qui, et ce que le visiteur gagne à vous appeler.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:group {"align":"full","className":"br-ouv-faits-zone","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-ouv-faits-zone"><!-- wp:group {"className":"br-ouv-faits","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-faits"><!-- wp:group {"className":"br-ouv-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-fait"><!-- wp:paragraph {"className":"br-ouv-fait-chiffre"} -->
<p class="br-ouv-fait-chiffre">5 jours</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-ouv-fait-texte"} -->
<p class="br-ouv-fait-texte">pour recevoir le devis</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-ouv-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-fait"><!-- wp:paragraph {"className":"br-ouv-fait-chiffre"} -->
<p class="br-ouv-fait-chiffre">Depuis 2010</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-ouv-fait-texte"} -->
<p class="br-ouv-fait-texte">une entreprise locale</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-ouv-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-fait"><!-- wp:paragraph {"className":"br-ouv-fait-chiffre"} -->
<p class="br-ouv-fait-chiffre">Décennale</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-ouv-fait-texte"} -->
<p class="br-ouv-fait-texte">sur chaque chantier</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
