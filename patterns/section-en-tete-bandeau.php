<?php
/**
 * Title: Ouverture : En-tête bandeau photo pleine largeur
 * Slug: briise/en-tete-bandeau
 * Categories: briise-ouverture
 * Description: Photo de la page en bandeau sur toute la largeur, texte posé dessus. Réservé aux très grandes photos (2 400 px de large au moins) : sinon, préférer l’en-tête avec photo à côté.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:cover {"useFeaturedImage":true,"overlayColor":"sombre","isUserOverlayColor":true,"minHeight":420,"minHeightUnit":"px","contentPosition":"center left","align":"full","className":"br-banniere br-tete-photo","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-center-left br-banniere br-tete-photo" style="min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-sombre-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"br-banniere-inner","layout":{"type":"default"}} -->
<div class="wp-block-group br-banniere-inner"><!-- wp:shortcode -->
[briise_fil_ariane]
<!-- /wp:shortcode -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre de la page</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une ou deux phrases qui posent le sujet de la page et la réponse que le visiteur y trouvera.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
