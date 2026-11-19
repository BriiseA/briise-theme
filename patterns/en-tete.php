<?php
/**
 * Title: En-tête
 * Slug: briise/en-tete
 * Categories: header
 * Inserter: no
 */
$e = briise_theme_entreprise();
$tel     = trim( (string) ( $e['telephone'] ?? '' ) );
$tel_url = preg_replace( '/[^\d+]/', '', $tel );
if ( 0 === strpos( $tel_url, '0' ) ) {
	$tel_url = '+33' . substr( $tel_url, 1 );
}
?>
<!-- wp:group {"align":"full","className":"br-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-header"><!-- wp:group {"className":"br-header-inner","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-inner"><!-- wp:site-logo {"width":220,"shouldSyncIcon":false,"className":"br-logo-img"} /-->

<!-- wp:site-title {"level":0,"className":"br-logo"} /-->

<!-- wp:group {"className":"br-header-right","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-right"><!-- wp:navigation {"overlayMenu":"mobile","className":"br-nav","layout":{"type":"flex","justifyContent":"right"}} /-->

<?php if ( $tel ) : ?><!-- wp:html -->
<a class="br-header-tel" href="tel:<?php echo esc_attr( $tel_url ); ?>" aria-label="<?php echo esc_attr( 'Appeler ' . $e['name'] . ' au ' . briise_theme_telephone( $tel ) ); ?>"><span class="br-header-tel-icone" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg></span><span class="br-header-tel-num" aria-hidden="true"><?php echo esc_html( briise_theme_telephone( $tel ) ); ?></span></a>
<!-- /wp:html -->

<?php endif; ?><!-- wp:buttons {"className":"br-header-cta"} -->
<div class="wp-block-buttons br-header-cta"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $e['cta_url'] ); ?>"><?php echo esc_html( $e['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
