<?php
/**
 * Title: Ouverture : Ouverture : titre centré et photos en éventail
 * Slug: briise/ouverture-eventail
 * Categories: briise-ouverture
 * Description: Quand les photos sont le meilleur argument : un grand titre centré, puis cinq photos disposées en arc. Élégante sur ordinateur ; sur mobile, trois photos restent visibles.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-hero br-eventail","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-hero br-eventail"><!-- wp:group {"className":"br-eventail-texte","layout":{"type":"default"}} -->
<div class="wp-block-group br-eventail-texte"><!-- wp:paragraph {"className":"br-choix-lieu"} -->
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
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-eventail-photos","layout":{"type":"default"}} -->
<div class="wp-block-group br-eventail-photos"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-eventail-photo"} -->
<figure class="wp-block-image size-full br-eventail-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-eventail-photo"} -->
<figure class="wp-block-image size-full br-eventail-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-eventail-photo"} -->
<figure class="wp-block-image size-full br-eventail-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : la plus belle, au centre" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-eventail-photo"} -->
<figure class="wp-block-image size-full br-eventail-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-eventail-photo"} -->
<figure class="wp-block-image size-full br-eventail-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
