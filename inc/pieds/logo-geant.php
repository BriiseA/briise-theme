<?php
require_once __DIR__ . '/_commun.php';
?>
<!-- wp:html -->
<div class="br-footer br-ft br-ft--logo-geant"><div class="br-ft-inner">
<div class="br-ft-grille">
<div><?php if ( ! empty( $e['slogan'] ) ) : ?><p class="br-ft-texte"><?php echo esc_html( $e['slogan'] ); ?></p><?php endif; ?><?php if ( $zone ) : ?><p class="br-footer-zone"><?php echo esc_html( 'Nous intervenons à ' . implode( ', ', $zone ) . '.' ); ?></p><?php endif; ?></div>
<?php if ( $services ) : ?><div><p class="br-ft-titre"><?php echo esc_html( $services['titre'] ); ?></p><?php echo briise_pied_liens( $services ); // phpcs:ignore ?></div><?php endif; ?>
<?php if ( $horaires ) : ?><div><p class="br-ft-titre">Horaires</p><?php echo $horaires; // phpcs:ignore ?></div><?php endif; ?>
<div><p class="br-ft-titre">Nous joindre</p><?php if ( $tel ) : ?><a class="br-ft-tel" href="tel:<?php echo esc_attr( $tel_url ); ?>"><?php echo esc_html( briise_theme_telephone( $tel ) ); ?></a><?php endif; ?><?php echo briise_pied_cta( $e, $sur_cta ); // phpcs:ignore ?></div>
</div>
<?php echo $qualifs; // phpcs:ignore ?>
<p class="br-ft-geant" aria-hidden="true"><?php echo esc_html( $e['name'] ); ?></p>
<?php echo briise_pied_bas( $e, $legales, $credit, briise_theme_reseaux_html() ); // phpcs:ignore ?>
</div></div>
<!-- /wp:html -->
