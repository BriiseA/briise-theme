<?php
/**
 * Title: Parcours : Où en êtes-vous ? (6 versions)
 * Slug: briise/ou-en-etes-vous
 * Categories: briise-parcours
 * Description: Forme au choix dans le panneau « Version » : cartes, lignes, conversation, avec photo, frise (quand les situations se suivent dans le temps), profils avec photo. Quand les visiteurs arrivent dans des situations différentes : quatre cartes qui partent de leur situation, dite comme ils la diraient, avec la réponse, le prix et la page qui y répond. Tout est visible sans clic. Icône au choix par la classe du bloc : br-ic-maison, fleches, loupe, horloge, euro, bouclier, coeur, appareil. Seulement un prix réel, ou « Sur devis ».
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-situations-section br-ouenetes br-ouenetes\u002d\u002dcartes","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-situations-section br-ouenetes br-ouenetes--cartes"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Par où commencer</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Où en êtes-vous ?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Choisissez la phrase qui vous ressemble : vous voyez ce qui vous servira, et ce que ça coûte.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-ouenetes-corps","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouenetes-corps"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-ouenetes-photo"} -->
<figure class="wp-block-image size-full br-ouenetes-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : votre lieu, votre travail ou vous" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-situations","layout":{"type":"grid","minimumColumnWidth":"14rem"}} -->
<div class="wp-block-group br-situations"><!-- wp:group {"className":"br-situation br-ic-maison","layout":{"type":"default"}} -->
<div class="wp-block-group br-situation br-ic-maison"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-situation-photo"} -->
<figure class="wp-block-image size-large br-situation-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : la personne ou le moment que décrit cette situation"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Je découvre, je ne sais pas par où commencer.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que vous proposez pour démarrer, en une phrase.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-situation-prix"} -->
<p class="br-situation-prix"><strong>Votre prix réel, ou « Sur demande »</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Voir ce service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-situation br-ic-fleches","layout":{"type":"default"}} -->
<div class="wp-block-group br-situation br-ic-fleches"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-situation-photo"} -->
<figure class="wp-block-image size-large br-situation-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : la personne ou le moment que décrit cette situation"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">J’ai déjà essayé, sans le résultat espéré.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que vous faites autrement, concrètement.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-situation-prix"} -->
<p class="br-situation-prix"><strong>Votre prix réel, ou « Sur demande »</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Voir ce service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-situation br-ic-loupe","layout":{"type":"default"}} -->
<div class="wp-block-group br-situation br-ic-loupe"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-situation-photo"} -->
<figure class="wp-block-image size-large br-situation-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo à remplacer : la personne ou le moment que décrit cette situation"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Je sais ce que je veux, je compare.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce qui vous distingue, chiffre à l’appui.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-situation-prix"} -->
<p class="br-situation-prix"><strong>Votre prix réel, ou « Sur demande »</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Voir ce service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-situation br-ic-horloge","layout":{"type":"default"}} -->
<div class="wp-block-group br-situation br-ic-horloge"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"br-situation-photo"} -->
<figure class="wp-block-image size-large br-situation-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : la personne ou le moment que décrit cette situation"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">C’est pressé.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Votre délai réel pour intervenir ou répondre.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-situation-prix"} -->
<p class="br-situation-prix"><strong>Votre prix réel, ou « Sur demande »</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
