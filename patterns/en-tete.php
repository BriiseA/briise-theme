<?php
/**
 * Title: En-tête
 * Slug: briise/en-tete
 * Categories: header
 * Inserter: no
 */
$e = briise_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-header"><!-- wp:group {"className":"br-header-inner","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-inner"><!-- wp:site-title {"level":0,"className":"br-logo"} /-->

<!-- wp:group {"className":"br-header-right","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-right"><!-- wp:navigation {"overlayMenu":"mobile","className":"br-nav","layout":{"type":"flex","justifyContent":"right"}} /-->

<!-- wp:buttons {"className":"br-header-cta"} -->
<div class="wp-block-buttons br-header-cta"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $e['cta_url'] ); ?>"><?php echo esc_html( $e['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
