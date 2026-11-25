<?php
/**
 * Title: Ouverture : Accueil avec avant / après
 * Slug: briise/ouverture-avant-apres
 * Categories: briise-ouverture
 * Description: Rénovation, nettoyage, aménagement : le titre à gauche, une photo avant / après à faire glisser à droite. Les deux photos doivent être prises du même endroit, avec le même cadrage.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-ouv-avap","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-ouv-avap"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%"><!-- wp:paragraph {"className":"br-pastille"} -->
<p class="br-pastille">Votre métier · Votre ville</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
<h1 class="wp-block-heading has-xx-large-font-size">Le titre de la transformation</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Faites glisser pour comparer : même endroit, avant et après notre passage.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Voir nos réalisations</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"60%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:60%"><!-- wp:columns {"className":"br-avant-apres br-glisse"} -->
<div class="wp-block-columns br-avant-apres br-glisse"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-avap","layout":{"type":"default"}} -->
<div class="wp-block-group br-avap"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/avant.svg' ) ); ?>" alt="Avant : décrivez l’état de départ" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-chip br-avap-tag"} -->
<p class="br-chip br-avap-tag">Avant</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-avap","layout":{"type":"default"}} -->
<div class="wp-block-group br-avap"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/apres.svg' ) ); ?>" alt="Après : décrivez le résultat" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-chip br-avap-tag"} -->
<p class="br-chip br-avap-tag">Après</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"br-muted br-glisse-aide"} -->
<p class="br-muted br-glisse-aide">Faites glisser le curseur, ou passez la souris sur la photo.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
