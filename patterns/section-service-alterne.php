<?php
/**
 * Title: Offre : Service détaillé, image et texte alternés
 * Slug: briise/service-alterne
 * Categories: briise-offre
 * Description: Pages de service : chaque service avec sa photo, en alternance gauche et droite.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : décrivez ce qu’elle montre" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Service</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Premier service</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Décrivez le service concrètement : comment il se déroule, combien de temps il prend, ce que le client obtient à la fin.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-br-tirets"} -->
<ul class="wp-block-list is-style-br-tirets"><!-- wp:list-item -->
<li>Un bénéfice précis</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un deuxième bénéfice</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Une garantie ou un engagement</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( $briise['cta_url'] ); ?>">Demander un devis pour ce service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"verticalAlignment":"center","className":"br-split br-alterne"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split br-alterne"><!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Service</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Deuxième service</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Décrivez le service concrètement : comment il se déroule, combien de temps il prend, ce que le client obtient à la fin.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-br-tirets"} -->
<ul class="wp-block-list is-style-br-tirets"><!-- wp:list-item -->
<li>Un bénéfice précis</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un deuxième bénéfice</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Une garantie ou un engagement</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( $briise['cta_url'] ); ?>">Demander un devis pour ce service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage-2.svg' ) ); ?>" alt="Photo à remplacer : décrivez ce qu’elle montre" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
