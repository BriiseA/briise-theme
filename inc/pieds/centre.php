<?php
/**
 * Pied « Centré » : tout au centre, sur fond sombre. Le nom (ou le logo pour fond foncé), les pages
 * de service sur une ligne, le téléphone et le bouton d'action, puis les mentions.
 */
require_once __DIR__ . '/_commun.php';
$logo = briise_pied_logo( $e );
?>
<!-- wp:html -->
<div class="br-footer br-ft br-ft--centre"><div class="br-ft-inner">
<p class="br-ft-nom"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $logo ? $logo : esc_html( $e['name'] ); // phpcs:ignore ?></a></p>
<?php if ( $zone ) : ?><p class="br-ft-zone"><?php echo esc_html( implode( ' · ', $zone ) ); ?></p><?php endif; ?>
<?php if ( $services ) : ?><nav aria-label="<?php echo esc_attr( $services['titre'] ); ?>"><?php echo briise_pied_liens( $services ); // phpcs:ignore ?></nav><?php endif; ?>
<div class="br-ft-actions"><?php if ( $tel ) : ?><a class="br-ft-tel" href="tel:<?php echo esc_attr( $tel_url ); ?>"><?php echo esc_html( briise_theme_telephone( $tel ) ); ?></a><?php endif; ?><?php echo briise_pied_cta( $e, $sur_cta ); // phpcs:ignore ?></div>
<?php echo briise_pied_bas( $e, $legales, $credit, briise_theme_reseaux_html() ); // phpcs:ignore ?>
</div></div>
<!-- /wp:html -->
