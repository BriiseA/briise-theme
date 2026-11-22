<?php
/**
 * Title: Offre : Pourquoi ce prix : le temps passé
 * Slug: briise/temps-prix
 * Categories: briise-offre
 * Description: Justifier un prix par le travail qu’il représente : chaque étape et sa durée (« 30 min », « 2 h 30 »). Une barre colorée est dessinée à partir des durées.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-temps-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-temps-section has-surface-background-color has-background"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%"><!-- wp:heading -->
<h2 class="wp-block-heading">Pourquoi ce prix ?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase : le prix d’une prestation, et le temps total qu’elle représente.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:table {"hasFixedLayout":false,"className":"br-table br-temps"} -->
<figure class="wp-block-table br-table br-temps"><table><thead><tr><th>Étape</th><th>Temps</th></tr></thead><tbody><tr><td>Préparation</td><td>30 min</td></tr><tr><td>La prestation</td><td>2 h 30</td></tr><tr><td>Tri</td><td>1 h</td></tr><tr><td>Finitions</td><td>4 h</td></tr><tr><td>Livraison</td><td>1 h</td></tr></tbody><tfoot><tr><td>Au total</td><td>environ 9 h</td></tr></tfoot></table></figure>
<!-- /wp:table --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
