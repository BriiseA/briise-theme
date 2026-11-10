<?php
/**
 * Title: Pied de page
 * Slug: briise/pied-de-page
 * Categories: footer
 * Inserter: no
 */
$e        = briise_entreprise();
$contact  = home_url( '/' . $e['cta_slug'] . '/' );
$address  = trim( implode( ' ', array_filter( array( $e['street'], $e['postal_code'], $e['city'] ) ) ) );
$maps     = $address ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $address ) : '';
$lines    = array_filter( array(
	$address ? esc_html( $address ) . ( $maps ? ' · <a href="' . esc_url( $maps ) . '">Itinéraire</a>' : '' ) : '',
	$e['telephone'] ? esc_html( briise_telephone_lisible( $e['telephone'] ) ) : '',
	$e['email'] ? '<a href="mailto:' . esc_attr( $e['email'] ) . '">' . esc_html( $e['email'] ) . '</a>' : '',
) );
?>
<!-- wp:group {"align":"full","className":"br-footer","backgroundColor":"nuit","textColor":"lin","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-footer has-lin-color has-nuit-background-color has-text-color has-background"><!-- wp:paragraph {"className":"br-footer-mail"} -->
<p class="br-footer-mail"><a href="<?php echo esc_url( $contact ); ?>"><?php echo esc_html( $e['cta_label'] ); ?> →</a></p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"br-footer-cols"} -->
<div class="wp-block-columns br-footer-cols"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:site-title {"level":0,"className":"br-logo"} /-->

<!-- wp:site-tagline {"className":"br-footer-text"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Contact</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php echo wp_kses_post( implode( '<br>', $lines ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"br-footer-bottom","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group br-footer-bottom"><!-- wp:paragraph -->
<p>© <?php echo esc_html( $e['name'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>">Mentions légales</a> · <a href="<?php echo esc_url( home_url( '/confidentialite/' ) ); ?>">Confidentialité</a> · <a href="<?php echo esc_url( home_url( '/cookies/' ) ); ?>">Cookies</a> · <a href="<?php echo esc_url( home_url( '/accessibilite/' ) ); ?>">Accessibilité</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-sticky","layout":{"type":"default"}} -->
<div class="wp-block-group br-sticky"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $contact ); ?>"><?php echo esc_html( $e['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
