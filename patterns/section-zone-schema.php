<?php
/**
 * Title: Contact : Zone d’intervention en schéma
 * Slug: briise/zone-schema
 * Categories: briise-contact
 * Description: Un schéma de la zone : votre adresse au centre, le rayon d’intervention et les communes où vous travaillez. Il se dessine à partir de Mon entreprise > Coordonnées > Communes du schéma (nom ; latitude ; longitude).
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-zone-schema","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-zone-schema"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Zone d’intervention</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Nous intervenons à 30 km autour de votre ville</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Les communes principales de votre zone, et ce qui se passe au-delà.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/zone-intervention/' ) ); ?>">Toutes les communes où nous intervenons</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"56%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:56%"><!-- wp:shortcode -->
[briise_zone_schema]
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
