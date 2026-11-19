<?php
/**
 * Title: Ouverture : Accueil texte et photo avec étiquettes
 * Slug: briise/accueil-photo
 * Categories: briise-ouverture
 * Description: Ouverture de l’accueil : titre, phrase et boutons à gauche, une vraie photo à droite avec deux étiquettes posées dessus (prix de départ, délai, garantie). Sur mobile, le titre et le bouton restent visibles sans défiler.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-hero br-hero-photo","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-hero br-hero-photo has-surface-background-color has-background"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%"><!-- wp:paragraph {"className":"br-pastille"} -->
<p class="br-pastille">Votre métier · Votre ville</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre qui dit ce que vous faites, <mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-accent-color">et où</mark></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une ou deux phrases : pour qui, ce qui vous distingue, et ce que le visiteur gagne à vous appeler.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Voir nos réalisations</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:list {"className":"br-coches"} -->
<ul class="wp-block-list br-coches"><!-- wp:list-item -->
<li>Devis gratuit</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Votre délai de réponse</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Votre garantie</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"48%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%"><!-- wp:group {"className":"br-hero-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-hero-media"><!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-hero-img"} -->
<figure class="wp-block-image size-full br-hero-img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : votre travail, votre atelier ou votre équipe" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"br-etiquette-photo br-etiquette-photo\u002d\u002d1","layout":{"type":"default"}} -->
<div class="wp-block-group br-etiquette-photo br-etiquette-photo--1"><!-- wp:paragraph {"className":"br-etiquette-petit"} -->
<p class="br-etiquette-petit">À partir de</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-etiquette-grand"} -->
<p class="br-etiquette-grand">000 € posé</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-etiquette-photo br-etiquette-photo\u002d\u002d2","layout":{"type":"default"}} -->
<div class="wp-block-group br-etiquette-photo br-etiquette-photo--2"><!-- wp:paragraph {"className":"br-etiquette-petit"} -->
<p class="br-etiquette-petit">Délai</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-etiquette-grand"} -->
<p class="br-etiquette-grand">2 semaines</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
