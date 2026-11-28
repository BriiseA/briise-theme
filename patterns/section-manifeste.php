<?php
/**
 * Title: Personnes : Manifeste
 * Slug: briise/manifeste
 * Categories: briise-personnes
 * Description: Votre conviction en une grande phrase, avec deux petites photos glissées entre les mots. Les mots se colorent au fil de la lecture (fixes si le visiteur demande moins d’animations). Une phrase que vous pourriez dire à un client, pas un slogan.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-manifeste","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-manifeste"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Ce qui nous guide</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"br-manifeste-texte"} -->
<h2 class="wp-block-heading br-manifeste-texte">Nous croyons qu’un travail bien fait <img class="br-mot-photo" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt=""> se voit tout de suite, se raconte <img class="br-mot-photo" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt=""> facilement et se tient dans le temps.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/a-propos/' ) ); ?>">Notre histoire</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
