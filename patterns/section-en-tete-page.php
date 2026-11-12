<?php
/**
 * Title: Ouverture : En-tête de page avec fil d’Ariane
 * Slug: briise/en-tete-page
 * Categories: briise-ouverture
 * Description: Pour toutes les pages intérieures : fil d’Ariane automatique, titre, introduction et bouton d’action.
 * Viewport Width: 1400
 */
$briise = briise_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-page-head","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-page-head"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:shortcode -->
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
<!-- /wp:group --></div>
<!-- /wp:group -->
