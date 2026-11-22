<?php
/**
 * Title: Ouverture : Ouverture : liste des prestations qui change la photo
 * Slug: briise/choix-prestation
 * Categories: briise-ouverture
 * Description: Accueil : le titre, puis la liste des prestations avec leur prix. Au survol d’une ligne, la grande photo change. Chaque ligne mène à sa page. Sur mobile, une vignette par ligne. De 2 à 6 lignes.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-hero br-choix","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-hero br-choix"><!-- wp:columns {"className":"br-split br-choix-cols"} -->
<div class="wp-block-columns br-split br-choix-cols"><!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%"><!-- wp:paragraph {"className":"br-choix-lieu"} -->
<p class="br-choix-lieu">Où vous recevez, ou jusqu’où vous vous déplacez</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Votre métier à Votre ville, en une phrase</h1>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Voir les tarifs</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:group {"className":"br-choix-liste","layout":{"type":"default"}} -->
<div class="wp-block-group br-choix-liste"><!-- wp:group {"className":"br-choix-ligne","layout":{"type":"default"}} -->
<div class="wp-block-group br-choix-ligne"><!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-choix-vignette"} -->
<figure class="wp-block-image size-full br-choix-vignette"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : la première prestation" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-choix-nom"} -->
<p class="br-choix-nom"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Première prestation</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-choix-prix"} -->
<p class="br-choix-prix">dès … €</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-choix-ligne","layout":{"type":"default"}} -->
<div class="wp-block-group br-choix-ligne"><!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-choix-vignette"} -->
<figure class="wp-block-image size-full br-choix-vignette"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : la deuxième prestation" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-choix-nom"} -->
<p class="br-choix-nom"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Deuxième prestation</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-choix-prix"} -->
<p class="br-choix-prix">… €</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-choix-ligne","layout":{"type":"default"}} -->
<div class="wp-block-group br-choix-ligne"><!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-choix-vignette"} -->
<figure class="wp-block-image size-full br-choix-vignette"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : la troisième prestation" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-choix-nom"} -->
<p class="br-choix-nom"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Troisième prestation</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-choix-prix"} -->
<p class="br-choix-prix">… €</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-choix-ligne","layout":{"type":"default"}} -->
<div class="wp-block-group br-choix-ligne"><!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-choix-vignette"} -->
<figure class="wp-block-image size-full br-choix-vignette"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : la quatrième prestation" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-choix-nom"} -->
<p class="br-choix-nom"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Quatrième prestation</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-choix-prix"} -->
<p class="br-choix-prix">dès … €</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"48%"} -->
<div class="wp-block-column" style="flex-basis:48%"><!-- wp:group {"className":"br-choix-scene","layout":{"type":"default"}} -->
<div class="wp-block-group br-choix-scene"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-choix-photo"} -->
<figure class="wp-block-image size-large br-choix-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : la première prestation"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-choix-photo"} -->
<figure class="wp-block-image size-large br-choix-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : la deuxième prestation"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-choix-photo"} -->
<figure class="wp-block-image size-large br-choix-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : la troisième prestation"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-choix-photo"} -->
<figure class="wp-block-image size-large br-choix-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : la quatrième prestation"/></figure>
<!-- /wp:image -->

<!-- wp:shortcode -->
[briise_disponibilite]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
