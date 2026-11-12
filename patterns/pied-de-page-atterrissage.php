<?php
/**
 * Title: Pied de page d'atterrissage
 * Slug: briise/pied-de-page-atterrissage
 * Categories: footer
 * Inserter: no
 *
 * Coordonnées et liens légaux seulement : la page garde un seul objectif.
 */
$e       = briise_entreprise();
$legales = array();
foreach ( array( 'mentions-legales' => 'Mentions légales', 'confidentialite' => 'Confidentialité', 'cookies' => 'Cookies' ) as $slug => $label ) {
	$page = get_page_by_path( $slug );
	if ( $page && 'publish' === $page->post_status ) {
		$legales[] = '<a href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( $label ) . '</a>';
	}
}
?>
<!-- wp:group {"align":"full","className":"br-footer br-footer--atterrissage","backgroundColor":"sombre","textColor":"fond","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-footer br-footer--atterrissage has-fond-color has-sombre-background-color has-text-color has-background"><!-- wp:html -->
<?php echo briise_coordonnees_html(); // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans la fonction. ?>
<!-- /wp:html -->

<!-- wp:group {"className":"br-footer-bottom","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group br-footer-bottom"><!-- wp:paragraph -->
<p>© <?php echo esc_html( wp_date( 'Y' ) . ' ' . $e['name'] ); ?></p>
<!-- /wp:paragraph -->

<?php if ( $legales ) : ?>
<!-- wp:paragraph -->
<p><?php echo wp_kses_post( implode( ' · ', $legales ) ); ?></p>
<!-- /wp:paragraph -->
<?php endif; ?></div>
<!-- /wp:group -->

<?php if ( briise_fonction( 'bouton_mobile' ) ) : ?>
<!-- wp:group {"className":"br-sticky","layout":{"type":"default"}} -->
<div class="wp-block-group br-sticky"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $e['telephone'] ? 'tel:' . $e['telephone'] : $e['cta_url'] ); ?>"><?php echo esc_html( $e['telephone'] ? 'Appeler le ' . briise_telephone_lisible( $e['telephone'] ) : $e['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
<?php endif; ?></div>
<!-- /wp:group -->
