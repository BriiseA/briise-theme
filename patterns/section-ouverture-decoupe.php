<?php
/**
 * Title: Ouverture : Accueil sombre, photo coupée en biais
 * Slug: briise/ouverture-decoupe
 * Categories: briise-ouverture
 * Description: Une ouverture plus industrielle : fond sombre, titre en grand, la photo coupée en biais avec un trait de la couleur d’accent. Sur mobile, la photo passe sous le texte.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"sombre","textColor":"fond","align":"full","className":"br-section br-ouv-decoupe","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-ouv-decoupe has-fond-color has-sombre-background-color has-text-color has-background"><!-- wp:columns {"className":"br-ouv-decoupe-cols"} -->
<div class="wp-block-columns br-ouv-decoupe-cols"><!-- wp:column {"verticalAlignment":"center","width":"46%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Votre métier, votre ville</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre qui dit ce que vous fabriquez</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase : ce que vous faites, où, et ce qui vous distingue.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/a-propos/' ) ); ?>">Voir l’atelier</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"54%"} -->
<div class="wp-block-column" style="flex-basis:54%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-ouv-decoupe-img"} -->
<figure class="wp-block-image size-large br-ouv-decoupe-img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : votre atelier ou votre travail en cours"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
