<?php
/**
 * Pied « Clair » : sur la couleur de surface, pas de bloc sombre en bas de page. Le nom et la zone à
 * gauche, l'action à droite ; dessous, les pages de service, les coordonnées et les horaires.
 */
require_once __DIR__ . '/_commun.php';
$logo_id = (int) get_theme_mod( 'custom_logo' );
$logo    = $logo_id ? wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => $e['name'], 'loading' => 'lazy', 'class' => 'br-ft-logo' ) ) : '';
?>
<!-- wp:html -->
<div class="br-footer br-ft br-ft--clair"><div class="br-ft-inner">
<div class="br-ft-haut"><div><p class="br-ft-nom-petit"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $logo ? $logo : esc_html( $e['name'] ); // phpcs:ignore ?></a></p><?php if ( $zone ) : ?><p class="br-ft-zone"><?php echo esc_html( implode( ' · ', $zone ) ); ?></p><?php endif; ?></div><?php echo briise_pied_cta( $e, $sur_cta ); // phpcs:ignore ?></div>
<div class="br-ft-grille"><?php if ( $services ) : ?><nav aria-label="<?php echo esc_attr( $services['titre'] ); ?>"><p class="br-label"><?php echo esc_html( $services['titre'] ); ?></p><?php echo briise_pied_liens( $services ); // phpcs:ignore ?></nav><?php endif; ?><div><p class="br-label">Contact</p><?php echo $coord; // phpcs:ignore ?></div><?php if ( $horaires ) : ?><div><p class="br-label">Horaires</p><?php echo $horaires; // phpcs:ignore ?></div><?php endif; ?></div>
<?php echo briise_pied_bas( $e, $legales, $credit ); // phpcs:ignore ?>
</div></div>
<!-- /wp:html -->
