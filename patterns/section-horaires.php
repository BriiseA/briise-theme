<?php
/**
 * Title: Parcours : Horaires et planning
 * Slug: briise/horaires
 * Categories: briise-parcours
 * Description: Horaires d’ouverture tirés de « Mon entreprise », et un planning de rendez-vous ou de cours. Le jour en cours est surligné.
 * Viewport Width: 1400
 */
$briise = briise_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Horaires</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Quand nous trouver</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[briise_horaires]
<!-- /wp:shortcode --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Planning de la semaine</h3>
<!-- /wp:heading -->

<!-- wp:table {"hasFixedLayout":false,"className":"br-table br-planning"} -->
<figure class="wp-block-table br-table br-planning"><table><thead><tr><th>Jour</th><th>Horaire</th><th>Activité</th><th>Réserver</th></tr></thead><tbody><tr><td>Lundi</td><td>18 h – 19 h</td><td>Première activité</td><td><a href="<?php echo esc_url( $briise['cta_url'] ); ?>">Réserver</a></td></tr><tr><td>Mercredi</td><td>12 h 30 – 13 h 30</td><td>Deuxième activité</td><td><a href="<?php echo esc_url( $briise['cta_url'] ); ?>">Réserver</a></td></tr><tr><td>Samedi</td><td>10 h – 11 h</td><td>Troisième activité</td><td><a href="<?php echo esc_url( $briise['cta_url'] ); ?>">Réserver</a></td></tr></tbody></table></figure>
<!-- /wp:table --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
