<?php
/**
 * Title: Contact : Zone d’intervention sur un plan
 * Slug: briise/zone-plan
 * Categories: briise-contact
 * Description: Les communes sur un vrai plan : le visiteur choisit la sienne et voit la distance et le délai de visite. Le plan est fabriqué une fois, à partir des communes du schéma de zone (Mon entreprise > Entreprise ; nom ; latitude ; longitude ; délai facultatif), et enregistré sur votre site : aucun service extérieur n’est chargé chez le visiteur.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-zone-plan","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-zone-plan has-surface-background-color has-background"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Zone d’intervention</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Nous intervenons autour de [ville]</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Choisissez votre commune : vous voyez la distance et le délai habituel de visite.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[briise_zone_plan]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
