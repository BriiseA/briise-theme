<?php
/**
 * Title: Offre : Quel modèle choisir, en cartes
 * Slug: briise/modeles-cartes
 * Categories: briise-offre
 * Description: Une carte par modèle ou par option, avec sa photo, sa place, son prix, pour qui il est fait et ses limites. Lisible sur mobile, plus parlant qu’un tableau.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-modeles","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-modeles has-surface-background-color has-background"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Quel modèle choisir ?</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Quel modèle pour votre projet ?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase qui dit de quoi dépend le bon choix : la place, l’usage, le budget.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-modeles-grille"} -->
<div class="wp-block-columns br-modeles-grille"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-modele","layout":{"type":"default"}} -->
<div class="wp-block-group br-modele"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : le premier modèle" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Premier modèle</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>Idéal pour : </strong>la situation où il convient le mieux.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>Prix : </strong>à partir de… €.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>À savoir : </strong>sa limite, dite franchement.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-modele","layout":{"type":"default"}} -->
<div class="wp-block-group br-modele"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : le deuxième modèle" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Deuxième modèle</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>Idéal pour : </strong>la situation où il convient le mieux.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>Prix : </strong>à partir de… €.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>À savoir : </strong>sa limite, dite franchement.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-modele","layout":{"type":"default"}} -->
<div class="wp-block-group br-modele"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : le troisième modèle" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Troisième modèle</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>Idéal pour : </strong>la situation où il convient le mieux.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>Prix : </strong>à partir de… €.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-modele-fait"} -->
<p class="br-modele-fait"><strong>À savoir : </strong>sa limite, dite franchement.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( $briise['cta_url'] ); ?>">Vous hésitez ? Nous vous conseillons gratuitement</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
