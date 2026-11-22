<?php
/**
 * Title: Offre : Tarifs en liste, avec photos
 * Slug: briise/tarifs-liste
 * Categories: briise-offre
 * Description: Toutes les prestations sur une liste : vignette, nom, ce qui est compris en quelques mots, prix. Chaque ligne mène à la page de la prestation.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-tarifs-liste-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-tarifs-liste-section"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Nos tarifs, sans surprise</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Ce que comprennent tous les prix, en une phrase (déplacement, livraison, garantie).</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-tarifs-liste","layout":{"type":"default"}} -->
<div class="wp-block-group br-tarifs-liste"><!-- wp:group {"className":"br-tarif-ligne","layout":{"type":"default"}} -->
<div class="wp-block-group br-tarif-ligne"><!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-tarif-vignette"} -->
<figure class="wp-block-image size-full br-tarif-vignette"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : la première prestation" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-tarif-nom"} -->
<p class="br-tarif-nom"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Première prestation</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-tarif-details"} -->
<p class="br-tarif-details">Durée, ce qui est compris, où</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-tarif-prix"} -->
<p class="br-tarif-prix">dès … €</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-tarif-ligne","layout":{"type":"default"}} -->
<div class="wp-block-group br-tarif-ligne"><!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-tarif-vignette"} -->
<figure class="wp-block-image size-full br-tarif-vignette"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : la deuxième prestation" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-tarif-nom"} -->
<p class="br-tarif-nom"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Deuxième prestation</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-tarif-details"} -->
<p class="br-tarif-details">Durée, ce qui est compris, où</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-tarif-prix"} -->
<p class="br-tarif-prix">… €</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-tarif-ligne","layout":{"type":"default"}} -->
<div class="wp-block-group br-tarif-ligne"><!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-tarif-vignette"} -->
<figure class="wp-block-image size-full br-tarif-vignette"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : la troisième prestation" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-tarif-nom"} -->
<p class="br-tarif-nom"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Troisième prestation</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-tarif-details"} -->
<p class="br-tarif-details">Durée, ce qui est compris, où</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-tarif-prix"} -->
<p class="br-tarif-prix">… €</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
