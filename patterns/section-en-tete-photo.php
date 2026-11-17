<?php
/**
 * Title: Ouverture : En-tête de page avec photo
 * Slug: briise/en-tete-photo
 * Categories: briise-ouverture
 * Description: Pages de service, à propos : titre et introduction à gauche, photo nette à droite. La photo est l’image mise en avant de la page (1 400 px de large au moins) ; sans elle, le texte prend toute la largeur.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-tete br-tete-split","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-tete br-tete-split"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%"><!-- wp:shortcode -->
[briise_fil_ariane]
<!-- /wp:shortcode -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre de la page</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une ou deux phrases : ce que c’est, pour qui, le prix de départ et le délai.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"48%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%"><!-- wp:post-featured-image {"aspectRatio":"4/3","sizeSlug":"full","className":"br-tete-media"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
