<?php
/**
 * Title: Contact : Appel à l’action sur photo
 * Slug: briise/cta-photo
 * Categories: briise-contact
 * Description: Fin de page : le dernier appel posé sur une grande photo, assombrie du côté du texte. Le pied de page, uni, s’en détache nettement.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>","dimRatio":90,"overlayColor":"sombre","isUserOverlayColor":true,"align":"full","className":"br-cta-photo","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull br-cta-photo"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-sombre-background-color has-background-dim-90 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"verticalAlignment":"bottom","className":"br-cta-photo-cols"} -->
<div class="wp-block-columns are-vertically-aligned-bottom br-cta-photo-cols"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:heading -->
<h2 class="wp-block-heading">Une dernière invitation, courte</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase qui lève le dernier frein : prochaine date libre, réponse sous 24 h, premier échange sans engagement.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:40%"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:shortcode -->
[briise_appel]
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->
