<?php
/**
 * Title: Offre : Carte cadeau
 * Slug: briise/carte-cadeau
 * Categories: briise-offre
 * Description: Offrir une prestation : un visuel de carte cadeau (photo, nom, montant) et le mode d’emploi en une phrase.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-cadeau","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-cadeau has-surface-background-color has-background"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>","dimRatio":50,"overlayColor":"sombre","isUserOverlayColor":true,"contentPosition":"bottom left","className":"br-cadeau-carte","layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left br-cadeau-carte"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-sombre-background-color has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"className":"br-cadeau-texte"} -->
<p class="br-cadeau-texte">Carte cadeau, valable un an</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-cadeau-montant"} -->
<p class="br-cadeau-montant">… €</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:heading -->
<h2 class="wp-block-heading">Offrir une prestation</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Pour quelle occasion, de quel montant, envoyée comment, valable combien de temps.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>">Offrir une carte cadeau</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
