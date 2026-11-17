<?php
/**
 * Title: Ouverture : En-tête de page avec trois photos
 * Slug: briise/en-tete-mosaique
 * Categories: briise-ouverture
 * Description: Variante quand vous avez trois bonnes photos : titre à gauche, mosaïque à droite. La grande photo est l’image mise en avant de la page ; les deux petites se remplacent d’un clic.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-tete br-tete-mosaique","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-tete br-tete-mosaique"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"46%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%"><!-- wp:shortcode -->
[briise_fil_ariane]
<!-- /wp:shortcode -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre de la page</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une ou deux phrases : ce que c’est, pour qui, le prix de départ et le délai.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"54%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:54%"><!-- wp:group {"className":"br-mosaique-tete","layout":{"type":"default"}} -->
<div class="wp-block-group br-mosaique-tete"><!-- wp:post-featured-image {"aspectRatio":"4/5","sizeSlug":"full","className":"br-tete-media"} /-->

<!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-mosaique-img"} -->
<figure class="wp-block-image size-full br-mosaique-img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : un détail de l’ouvrage" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-mosaique-img"} -->
<figure class="wp-block-image size-full br-mosaique-img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : une autre réalisation" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
