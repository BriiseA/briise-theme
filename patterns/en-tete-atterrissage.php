<?php
/**
 * Title: En-tête de page d'atterrissage
 * Slug: briise/en-tete-atterrissage
 * Categories: header
 * Inserter: no
 *
 * Pour les pages de publicité : pas de menu qui disperse le visiteur,
 * seulement le nom, le téléphone et l'action principale.
 */
$e = briise_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-header br-header--atterrissage","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-header br-header--atterrissage"><!-- wp:group {"className":"br-header-inner","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-inner"><!-- wp:site-logo {"width":220,"isLink":false,"shouldSyncIcon":false,"className":"br-logo-img"} /-->

<!-- wp:site-title {"level":0,"isLink":false,"className":"br-logo"} /-->

<!-- wp:buttons {"className":"br-header-actions"} -->
<div class="wp-block-buttons br-header-actions"><?php if ( $e['telephone'] ) : ?><!-- wp:button {"className":"is-style-outline br-header-tel"} -->
<div class="wp-block-button is-style-outline br-header-tel"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( $e['telephone'] ); ?>"><?php echo esc_html( briise_telephone_lisible( $e['telephone'] ) ); ?></a></div>
<!-- /wp:button --><?php endif; ?>

<!-- wp:button {"className":"br-header-cta-btn"} -->
<div class="wp-block-button br-header-cta-btn"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $e['cta_url'] ); ?>"><?php echo esc_html( $e['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
