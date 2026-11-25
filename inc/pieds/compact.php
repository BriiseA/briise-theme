<?php
require_once __DIR__ . '/_commun.php';
?>
<!-- wp:html -->
<div class="br-footer br-ft br-ft--compact"><div class="br-ft-inner">
<div class="br-ft-ligne"><p class="br-ft-nom-petit"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $e['name'] ); ?></a></p><?php if ( $services ) : ?><nav aria-label="<?php echo esc_attr( $services['titre'] ); ?>"><?php echo briise_pied_liens( $services ); // phpcs:ignore ?></nav><?php endif; ?><?php if ( $tel ) : ?><a class="br-ft-tel" href="tel:<?php echo esc_attr( $tel_url ); ?>"><?php echo esc_html( briise_theme_telephone( $tel ) ); ?></a><?php endif; ?></div>
<?php echo briise_pied_bas( $e, $legales, $credit, briise_theme_reseaux_html() ); // phpcs:ignore ?>
</div></div>
<!-- /wp:html -->
