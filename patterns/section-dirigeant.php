<?php
/**
 * Title: Personnes : Présentation du dirigeant
 * Slug: briise/dirigeant
 * Categories: briise-personnes
 * Description: Professions libérales et artisans : la personne derrière l’entreprise.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-galet"} -->
<figure class="wp-block-image size-full is-style-br-galet"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Portrait de [prénom nom]" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Qui suis-je</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Prénom Nom, votre métier</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-statement"} -->
<p class="br-statement">Une phrase forte sur votre approche, celle que vous diriez à un client au premier rendez-vous.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Votre parcours en quelques lignes : formation, années d’expérience, ce qui vous a amené à ce métier. Parlez au client : ce qui compte pour lui, c’est ce que votre parcours lui apporte.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/a-propos/' ) ); ?>">En savoir plus sur mon parcours</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
