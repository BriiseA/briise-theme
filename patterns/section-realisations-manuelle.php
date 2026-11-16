<?php
/**
 * Title: Confiance : Réalisations en grille (à la main)
 * Slug: briise/realisations-manuelle
 * Categories: briise-confiance
 * Description: Trois réalisations écrites dans la page, sans fiche. Pour un site sans la fonction Réalisations.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Nos dernières réalisations</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Toutes les réalisations</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-projects"} -->
<div class="wp-block-columns br-projects"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-project","layout":{"type":"default"}} -->
<div class="wp-block-group br-project"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : décrivez ce qu’elle montre" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-chips","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group br-chips"><!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Type de projet</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Ville</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Première réalisation</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase : la demande du client et ce qui a été fait.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-project","layout":{"type":"default"}} -->
<div class="wp-block-group br-project"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : décrivez ce qu’elle montre" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-chips","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group br-chips"><!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Type de projet</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Ville</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Deuxième réalisation</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase : la demande du client et ce qui a été fait.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-project","layout":{"type":"default"}} -->
<div class="wp-block-group br-project"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : décrivez ce qu’elle montre" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-chips","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group br-chips"><!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Type de projet</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Ville</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Troisième réalisation</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase : la demande du client et ce qui a été fait.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
