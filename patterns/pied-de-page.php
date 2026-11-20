<?php
/**
 * Title: Pied de page
 * Slug: briise/pied-de-page
 * Categories: footer
 * Inserter: no
 *
 * Tout vient de « Mon entreprise » : rien à modifier ici pour un client.
 */
$e          = briise_theme_entreprise();
// Sur la page d'action elle-même, pas de lien qui y renvoie.
$sur_cta    = is_singular() && untrailingslashit( get_permalink() ) === untrailingslashit( $e['cta_url'] );
$horaires   = briise_theme_horaires_html();
$coord      = briise_theme_coordonnees_html() . briise_theme_reseaux_html();
$largeur    = $horaires ? '40%' : '50%';
$largeur_co = $horaires ? '30%' : '50%';
$credit     = briise_theme_credit_html();
$qualifs    = function_exists( 'briise_qualifications_pied_html' ) ? briise_qualifications_pied_html() : '';
$services   = briise_theme_pages_services();
$zone       = $e['areas'] ?? array();
$zone       = array_slice( array_filter( array_map( 'trim', is_array( $zone ) ? $zone : preg_split( '/\r\n|\r|\n/', (string) $zone ) ) ), 0, 6 );
$tel        = trim( (string) ( $e['telephone'] ?? '' ) );
$tel_url    = preg_replace( '/[^\d+]/', '', $tel );
if ( 0 === strpos( $tel_url, '0' ) ) {
	$tel_url = '+33' . substr( $tel_url, 1 );
}
$largeur    = $services ? ( $horaires ? '28%' : '34%' ) : $largeur;
$largeur_co = $services ? ( $horaires ? '24%' : '33%' ) : $largeur_co;
$legales    = array();
foreach ( array( 'mentions-legales' => 'Mentions légales', 'confidentialite' => 'Confidentialité', 'cookies' => 'Cookies', 'accessibilite' => 'Accessibilité' ) as $slug => $label ) {
	$page = get_page_by_path( $slug );
	if ( $page && 'publish' === $page->post_status ) {
		$legales[] = '<a href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( $label ) . '</a>';
	}
}
?>
<!-- wp:group {"align":"full","className":"br-footer","backgroundColor":"sombre","textColor":"fond","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-footer has-fond-color has-sombre-background-color has-text-color has-background"><?php if ( ! $sur_cta ) : ?><!-- wp:paragraph {"className":"br-footer-mail"} -->
<p class="br-footer-mail"><a href="<?php echo esc_url( $e['cta_url'] ); ?>"><?php echo esc_html( $e['cta_label'] ); ?> →</a></p>
<!-- /wp:paragraph --><?php endif; ?>

<!-- wp:columns {"className":"br-footer-cols"} -->
<div class="wp-block-columns br-footer-cols"><!-- wp:column {"width":"<?php echo esc_attr( $largeur ); ?>"} -->
<div class="wp-block-column" style="flex-basis:<?php echo esc_attr( $largeur ); ?>"><!-- wp:site-title {"level":0,"className":"br-logo br-logo--pied"} /-->

<!-- wp:site-tagline {"className":"br-footer-text"} /-->
<?php if ( $zone ) : ?>
<!-- wp:paragraph {"className":"br-footer-zone"} -->
<p class="br-footer-zone"><?php echo esc_html( 'Nous intervenons à ' . implode( ', ', $zone ) . '.' ); ?></p>
<!-- /wp:paragraph -->
<?php endif; ?></div>
<!-- /wp:column -->

<?php if ( $services ) : ?>
<!-- wp:column {"width":"24%"} -->
<div class="wp-block-column" style="flex-basis:24%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label"><?php echo esc_html( $services['titre'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<ul class="br-footer-liens"><?php foreach ( $services['pages'] as $sp ) : ?><li><a href="<?php echo esc_url( get_permalink( $sp ) ); ?>"><?php echo esc_html( get_the_title( $sp ) ); ?></a></li><?php endforeach; ?></ul>
<!-- /wp:html --></div>
<!-- /wp:column -->
<?php endif; ?>

<?php if ( $coord ) : ?>
<!-- wp:column {"width":"<?php echo esc_attr( $largeur_co ); ?>"} -->
<div class="wp-block-column" style="flex-basis:<?php echo esc_attr( $largeur_co ); ?>"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Contact</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<?php echo $coord; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans briise_theme_coordonnees_html(). ?>
<!-- /wp:html --></div>
<!-- /wp:column -->
<?php endif; ?>

<?php if ( $horaires ) : ?>
<!-- wp:column {"width":"<?php echo esc_attr( $services ? '24%' : '30%' ); ?>"} -->
<div class="wp-block-column" style="flex-basis:<?php echo esc_attr( $services ? '24%' : '30%' ); ?>"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Horaires</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<?php echo $horaires; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans briise_theme_horaires_html(). ?>
<!-- /wp:html --></div>
<!-- /wp:column -->
<?php endif; ?></div>
<!-- /wp:columns -->
<?php if ( $qualifs ) : ?>

<!-- wp:html -->
<?php echo $qualifs; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans briise_qualifications_pied_html(). ?>
<!-- /wp:html -->
<?php endif; ?>

<!-- wp:group {"className":"br-footer-bottom","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group br-footer-bottom"><!-- wp:paragraph -->
<p>© <?php echo esc_html( wp_date( 'Y' ) . ' ' . $e['name'] ); ?></p>
<!-- /wp:paragraph -->

<?php if ( $legales || $credit ) : ?>
<!-- wp:paragraph -->
<p><?php echo wp_kses_post( implode( ' · ', array_filter( array_merge( $legales, array( $credit ) ) ) ) ); ?></p>
<!-- /wp:paragraph -->
<?php endif; ?></div>
<!-- /wp:group -->

<?php if ( briise_theme_fonction( 'bouton_mobile' ) && ! $sur_cta ) : ?>
<!-- wp:group {"className":"br-sticky","layout":{"type":"default"}} -->
<div class="wp-block-group br-sticky"><!-- wp:buttons -->
<div class="wp-block-buttons"><?php if ( $tel ) : ?><!-- wp:button {"className":"is-style-outline br-sticky-tel"} -->
<div class="wp-block-button is-style-outline br-sticky-tel"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( $tel_url ); ?>"><svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>Appeler</a></div>
<!-- /wp:button -->

<?php endif; ?><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $e['cta_url'] ); ?>"><?php echo esc_html( $e['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
<?php endif; ?></div>
<!-- /wp:group -->
