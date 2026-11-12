<?php
/**
 * Title: Contact : Bloc contact complet
 * Slug: briise/contact
 * Categories: briise-contact
 * Description: Coordonnées, itinéraire, horaires et réseaux, tirés de « Mon entreprise ».
 * Viewport Width: 1400
 */
$briise = briise_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"55%"} -->
<div class="wp-block-column" style="flex-basis:55%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Contact</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Venir nous voir ou nous écrire</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[briise_coordonnees]
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[briise_reseaux]
<!-- /wp:shortcode -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"45%"} -->
<div class="wp-block-column" style="flex-basis:45%"><!-- wp:group {"className":"br-card","layout":{"type":"default"}} -->
<div class="wp-block-group br-card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Horaires</h3>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[briise_horaires]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
