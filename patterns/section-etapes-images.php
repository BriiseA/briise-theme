<?php
/**
 * Title: Parcours : Étapes en photos, numérotées
 * Slug: briise/etapes-images
 * Categories: briise-parcours
 * Description: Comment ça se passe, en trois à cinq photos : le numéro de l’étape est posé sur la photo, le moment (« Le jour J », « Sous 3 semaines ») dans une pastille. Pour les métiers où l’on vend des images.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-etapes-images","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-etapes-images has-surface-background-color has-background"><!-- wp:group {"className":"br-section-head br-tete-deux","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head br-tete-deux"><!-- wp:heading -->
<h2 class="wp-block-heading">Comment ça se passe, en quatre temps</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase qui dit que le client sait à chaque étape ce qui l’attend.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-etapes-images-grille","layout":{"type":"default"}} -->
<div class="wp-block-group br-etapes-images-grille"><!-- wp:group {"className":"br-etape-image","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape-image"><!-- wp:group {"className":"br-etape-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape-media"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : le premier échange" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-etape-quand"} -->
<p class="br-etape-quand">Quand vous voulez</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-etape-numero"} -->
<p class="br-etape-numero">1</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Vous réservez</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Comment, et ce qui se passe ensuite.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-etape-image","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape-image"><!-- wp:group {"className":"br-etape-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape-media"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : la préparation" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-etape-quand"} -->
<p class="br-etape-quand">Une semaine avant</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-etape-numero"} -->
<p class="br-etape-numero">2</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">On prépare</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que vous envoyez ou proposez.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-etape-image","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape-image"><!-- wp:group {"className":"br-etape-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape-media"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : le jour J" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-etape-quand"} -->
<p class="br-etape-quand">Le jour J</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-etape-numero"} -->
<p class="br-etape-numero">3</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La prestation</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Durée, lieu, déroulé.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-etape-image","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape-image"><!-- wp:group {"className":"br-etape-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-etape-media"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : le résultat" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-etape-quand"} -->
<p class="br-etape-quand">Sous … semaines</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-etape-numero"} -->
<p class="br-etape-numero">4</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Le résultat</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que le client reçoit, et sous quel délai.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
