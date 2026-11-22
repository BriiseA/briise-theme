<?php
/**
 * Title: Offre : Faits concrets avec icônes
 * Slug: briise/faits-icones
 * Categories: briise-offre
 * Description: Un lieu, un atelier, un service : six faits courts qui rassurent, chacun avec son icône. Icônes au choix par la classe du bloc : br-ic-soleil, thermometre, fauteuil, cintre, parking, horloge, bouclier, euro, maison, appareil, coeur, accessible.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-faits-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-faits-section has-surface-background-color has-background"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:group {"className":"br-faits-cote","layout":{"type":"default"}} -->
<div class="wp-block-group br-faits-cote"><!-- wp:heading -->
<h2 class="wp-block-heading">Tout est prêt avant votre arrivée</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Ce que le client n’a pas à prévoir, en une phrase.</p>
<!-- /wp:paragraph -->

<!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : un détail du lieu" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:group {"className":"br-faits","layout":{"type":"default"}} -->
<div class="wp-block-group br-faits"><!-- wp:group {"className":"br-fait br-ic-soleil","layout":{"type":"default"}} -->
<div class="wp-block-group br-fait br-ic-soleil"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Premier fait</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase concrète, avec un chiffre si possible.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fait br-ic-thermometre","layout":{"type":"default"}} -->
<div class="wp-block-group br-fait br-ic-thermometre"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Deuxième fait</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase concrète.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fait br-ic-fauteuil","layout":{"type":"default"}} -->
<div class="wp-block-group br-fait br-ic-fauteuil"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Troisième fait</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase concrète.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fait br-ic-cintre","layout":{"type":"default"}} -->
<div class="wp-block-group br-fait br-ic-cintre"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Quatrième fait</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase concrète.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fait br-ic-horloge","layout":{"type":"default"}} -->
<div class="wp-block-group br-fait br-ic-horloge"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Cinquième fait</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase concrète.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fait br-ic-parking","layout":{"type":"default"}} -->
<div class="wp-block-group br-fait br-ic-parking"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Sixième fait</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase concrète.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
