<?php
require_once __DIR__ . '/_commun.php';
$reseaux = briise_theme_reseaux_html();
$logo    = briise_pied_logo( $e );
?>
<!-- wp:html -->
<div class="br-footer br-ft br-ft--grand-titre"><div class="br-ft-carte">
<div class="br-ft-haut"><p class="br-ft-nom<?php echo $logo ? ' br-ft-nom--logo' : ''; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $logo ? $logo : esc_html( $e['name'] ); // phpcs:ignore ?></a></p><?php if ( ! empty( $e['slogan'] ) ) : ?><p class="br-ft-slogan"><?php echo esc_html( $e['slogan'] ); ?></p><?php endif; ?></div>
<div class="br-ft-milieu">
<div class="br-ft-action"><?php echo briise_pied_cta( $e, $sur_cta ); // phpcs:ignore ?><?php if ( $tel ) : ?><a class="br-ft-tel" href="tel:<?php echo esc_attr( $tel_url ); ?>"><?php echo esc_html( briise_theme_telephone( $tel ) ); ?></a><?php endif; ?><?php if ( $zone ) : ?><p class="br-footer-zone"><?php echo esc_html( 'Nous intervenons à ' . implode( ', ', $zone ) . '.' ); ?></p><?php endif; ?></div>
<div class="br-ft-colonnes"><?php if ( $services ) : ?><div><p class="br-ft-titre"><?php echo esc_html( $services['titre'] ); ?></p><?php echo briise_pied_liens( $services ); // phpcs:ignore ?></div><?php endif; ?><?php if ( $coord ) : ?><div><p class="br-ft-titre">Contact</p><?php echo briise_theme_coordonnees_html(); // phpcs:ignore ?></div><?php endif; ?><?php if ( $horaires ) : ?><div><p class="br-ft-titre">Horaires</p><?php echo $horaires; // phpcs:ignore ?></div><?php endif; ?></div>
</div>
<?php echo $qualifs; // phpcs:ignore ?>
<?php echo briise_pied_bas( $e, $legales, $credit, $reseaux ); // phpcs:ignore ?>
</div></div>
<!-- /wp:html -->
