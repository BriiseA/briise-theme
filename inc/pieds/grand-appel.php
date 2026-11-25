<?php
require_once __DIR__ . '/_commun.php';
$iti = function_exists( 'briise_itineraire_url' ) ? briise_itineraire_url() : '';
?>
<!-- wp:html -->
<div class="br-footer br-ft br-ft--grand-appel"><div class="br-ft-inner">
<div class="br-ft-appel">
<div class="br-ft-appel-gauche"><p class="br-ft-amorce"><?php echo esc_html( $tel ? 'Une question, un projet ? Appelez-nous.' : 'Une question, un projet ?' ); ?></p><?php if ( $tel ) : ?><a class="br-ft-tel-geant" href="tel:<?php echo esc_attr( $tel_url ); ?>"><?php echo esc_html( briise_theme_telephone( $tel ) ); ?></a><?php else : ?><?php echo briise_pied_cta( $e, $sur_cta, 'br-ft-bouton--grand' ); // phpcs:ignore ?><?php endif; ?><?php if ( $horaires ) : ?><div class="br-ft-horaires"><?php echo $horaires; // phpcs:ignore ?></div><?php endif; ?></div>
<div class="br-ft-appel-droite"><?php if ( $tel ) : ?><?php echo briise_pied_cta( $e, $sur_cta, 'br-ft-bouton--grand' ); // phpcs:ignore ?><?php endif; ?><?php if ( $iti ) : ?><a class="br-ft-bouton-contour" href="<?php echo esc_url( $iti ); ?>" target="_blank" rel="noopener">Itinéraire<span class="screen-reader-text"> (nouvel onglet)</span></a><?php endif; ?><?php if ( $zone ) : ?><p class="br-footer-zone"><?php echo esc_html( 'Nous intervenons à ' . implode( ', ', $zone ) . '.' ); ?></p><?php endif; ?></div>
</div>
<?php echo $qualifs; // phpcs:ignore ?>
<div class="br-ft-ligne"><p class="br-ft-nom-petit"><?php echo esc_html( $e['name'] ); ?></p><?php if ( $services ) : ?><nav aria-label="<?php echo esc_attr( $services['titre'] ); ?>"><?php echo briise_pied_liens( $services ); // phpcs:ignore ?></nav><?php endif; ?></div>
<?php echo briise_pied_bas( $e, $legales, $credit, briise_theme_reseaux_html() ); // phpcs:ignore ?>
</div></div>
<!-- /wp:html -->
