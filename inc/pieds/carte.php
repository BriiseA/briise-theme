<?php
require_once __DIR__ . '/_commun.php';
$iti  = function_exists( 'briise_itineraire_url' ) ? briise_itineraire_url() : '';
$plan = function_exists( 'briise_photo_media' ) ? ( briise_photo_media( 'plan' ) ?: briise_photo_media( 'carte' ) ) : 0;
?>
<!-- wp:html -->
<div class="br-footer br-ft br-ft--carte"><div class="br-ft-inner">
<div class="br-ft-grille">
<div class="br-ft-plan"><?php if ( $plan ) : ?><?php echo wp_get_attachment_image( $plan, 'large', false, array( 'alt' => 'Plan d’accès à ' . $e['name'], 'loading' => 'lazy' ) ); ?><?php else : ?><div class="br-ft-plan-vide"><?php echo briise_theme_icone( 'lieu' ); // phpcs:ignore ?><p><?php echo esc_html( function_exists( 'briise_adresse_ligne' ) ? briise_adresse_ligne() : '' ); ?></p></div><?php endif; ?><?php if ( $iti ) : ?><a class="br-ft-iti" href="<?php echo esc_url( $iti ); ?>" target="_blank" rel="noopener">Itinéraire vers <?php echo esc_html( $e['name'] ); ?><span class="screen-reader-text"> (nouvel onglet)</span></a><?php endif; ?></div>
<?php if ( $horaires ) : ?><div><p class="br-ft-titre">Horaires</p><?php echo $horaires; // phpcs:ignore ?></div><?php endif; ?>
<div><p class="br-ft-titre"><?php echo esc_html( $e['name'] ); ?></p><?php echo $coord; // phpcs:ignore ?><?php echo briise_pied_cta( $e, $sur_cta ); // phpcs:ignore ?></div>
</div>
<?php echo $qualifs; // phpcs:ignore ?>
<?php if ( $services ) : ?><nav class="br-ft-ligne" aria-label="<?php echo esc_attr( $services['titre'] ); ?>"><?php echo briise_pied_liens( $services ); // phpcs:ignore ?></nav><?php endif; ?>
<?php echo briise_pied_bas( $e, $legales, $credit ); // phpcs:ignore ?>
</div></div>
<!-- /wp:html -->
