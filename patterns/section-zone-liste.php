<?php
/**
 * Title: Contact : Zone d’intervention en liste
 * Slug: briise/zone-liste
 * Categories: briise-contact
 * Description: Les communes où vous intervenez, groupées par distance (moins de 10 km, 10 à 20 km…), puis une invitation à appeler. Les distances se calculent seules à partir de Mon entreprise > Entreprise > Communes du schéma de zone (nom ; latitude ; longitude, votre adresse en premier).
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-zone-liste-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-zone-liste-section"><!-- wp:columns {"className":"br-etapes-cols"} -->
<div class="wp-block-columns br-etapes-cols"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Zone d’intervention</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Nous intervenons à 30 km autour de votre ville</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Les secteurs où vous travaillez, en une phrase. La visite ou le devis sont-ils gratuits partout ?</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/zone-intervention/' ) ); ?>">Toutes les communes où nous intervenons</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:shortcode -->
[briise_zone_liste]
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
