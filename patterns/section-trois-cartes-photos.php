<?php
/**
 * Title: Offre : Trois cartes de service avec photos
 * Slug: briise/trois-cartes-photos
 * Categories: briise-offre
 * Description: Chaque carte est une photo pleine hauteur, avec le titre et le texte sur un dégradé sombre ; toute la carte mène à la page du service. Retirez la photo d’une carte : elle reprend l’aspect simple.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section has-surface-background-color has-background"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Ce que nous faisons</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Tous nos services</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-card","layout":{"type":"default"}} -->
<div class="wp-block-group br-card"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-card-fond"} -->
<figure class="wp-block-image size-large br-card-fond"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : une réalisation de ce service"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">01</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Premier service</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Deux phrases pour décrire ce service, pour qui il est fait et ce qu’il apporte.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Premier service en détail</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-card","layout":{"type":"default"}} -->
<div class="wp-block-group br-card"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-card-fond"} -->
<figure class="wp-block-image size-large br-card-fond"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : une réalisation de ce service"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">02</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Deuxième service</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Deux phrases pour décrire ce service, pour qui il est fait et ce qu’il apporte.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Deuxième service en détail</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-card","layout":{"type":"default"}} -->
<div class="wp-block-group br-card"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-card-fond"} -->
<figure class="wp-block-image size-large br-card-fond"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : une réalisation de ce service"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">03</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Troisième service</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Deux phrases pour décrire ce service, pour qui il est fait et ce qu’il apporte.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Troisième service en détail</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
