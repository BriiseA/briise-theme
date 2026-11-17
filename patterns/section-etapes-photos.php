<?php
/**
 * Title: Parcours : Déroulé et prix, en photos
 * Slug: briise/etapes-photos
 * Categories: briise-parcours
 * Description: Comment ça se passe, de la visite à la fin du chantier, chaque étape avec sa photo, puis le prix et ce qui le fait varier.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"nuance","align":"full","className":"br-section br-etapes-photos","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-etapes-photos has-nuance-background-color has-background"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Comment ça se passe</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">De la première visite à la fin du chantier</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-steps"} -->
<div class="wp-block-columns br-steps"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : la visite" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">1</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La visite</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce qui se passe au premier rendez-vous, et qui vient.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : le devis" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">2</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Le devis</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Sous quel délai, avec quoi (plan, échantillons).</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : la fabrication ou la préparation" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">3</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La préparation</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Combien de temps, où, par qui.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : la pose ou la livraison" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">4</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La fin du chantier</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Durée, propreté, ce que le client reçoit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":false,"className":"br-table"} -->
<figure class="wp-block-table br-table"><table><thead><tr><th>Prestation</th><th>Prix TTC</th></tr></thead><tbody><tr><td>Prestation la plus courante</td><td>À partir de… €</td></tr><tr><td>Option fréquente</td><td>+ … €</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce qui fait varier le prix, en une phrase. Le prix exact figure sur le devis.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
