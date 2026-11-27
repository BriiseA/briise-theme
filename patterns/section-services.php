<?php
/**
 * Title: Offre : Services (7 versions)
 * Slug: briise/services
 * Categories: briise-offre
 * Description: Vos services, chacun avec sa photo, son nom, deux phrases et le lien vers sa page. Choisissez la forme dans le panneau « Version » de la section : grille, grille asymétrique, liste en deux colonnes, service phare, défilement, onglets ou volets ; et la place du titre dans le panneau « Titre ». Le texte et les photos restent en place quand vous changez de version. Retirez ou dupliquez un service : chaque version s’adapte de 3 à 6 services.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-services br-services\u002d\u002dgrille","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-services br-services--grille has-surface-background-color has-background"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Ce que nous faisons</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase qui présente vos services : pour qui ils sont faits, et où vous intervenez.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Tous nos services</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-services-liste","layout":{"type":"default"}} -->
<div class="wp-block-group br-services-liste"><!-- wp:group {"className":"br-service","layout":{"type":"default"}} -->
<div class="wp-block-group br-service"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-service-photo"} -->
<figure class="wp-block-image size-large br-service-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : une réalisation de ce service"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-service-texte","layout":{"type":"default"}} -->
<div class="wp-block-group br-service-texte"><!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">01</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"br-service-nom"} -->
<h3 class="wp-block-heading br-service-nom">Premier service</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Deux phrases : pour qui est ce service, et ce qu’il change pour le client.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Premier service en détail</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-service","layout":{"type":"default"}} -->
<div class="wp-block-group br-service"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-service-photo"} -->
<figure class="wp-block-image size-large br-service-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : une réalisation de ce service"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-service-texte","layout":{"type":"default"}} -->
<div class="wp-block-group br-service-texte"><!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">02</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"br-service-nom"} -->
<h3 class="wp-block-heading br-service-nom">Deuxième service</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Deux phrases : pour qui est ce service, et ce qu’il change pour le client.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Deuxième service en détail</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-service","layout":{"type":"default"}} -->
<div class="wp-block-group br-service"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-service-photo"} -->
<figure class="wp-block-image size-large br-service-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : une réalisation de ce service"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-service-texte","layout":{"type":"default"}} -->
<div class="wp-block-group br-service-texte"><!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">03</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"br-service-nom"} -->
<h3 class="wp-block-heading br-service-nom">Troisième service</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Deux phrases : pour qui est ce service, et ce qu’il change pour le client.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Troisième service en détail</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-service","layout":{"type":"default"}} -->
<div class="wp-block-group br-service"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-service-photo"} -->
<figure class="wp-block-image size-large br-service-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage-2.svg' ) ); ?>" alt="Photo à remplacer : une réalisation de ce service"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-service-texte","layout":{"type":"default"}} -->
<div class="wp-block-group br-service-texte"><!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">04</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"br-service-nom"} -->
<h3 class="wp-block-heading br-service-nom">Quatrième service</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Deux phrases : pour qui est ce service, et ce qu’il change pour le client.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Quatrième service en détail</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
