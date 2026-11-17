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

<!-- wp:site-tagline {"className":"br-footer-text"} /--></div>
<!-- /wp:column -->

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
<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Horaires</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<?php echo $horaires; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans briise_theme_horaires_html(). ?>
<!-- /wp:html --></div>
<!-- /wp:column -->
<?php endif; ?></div>
<!-- /wp:columns -->

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
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $e['cta_url'] ); ?>"><?php echo esc_html( $e['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
<?php endif; ?></div>
<!-- /wp:group -->
