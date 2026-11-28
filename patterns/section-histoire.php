<?php
/**
 * Title: Personnes : Notre histoire
 * Slug: briise/histoire
 * Categories: briise-personnes
 * Description: Les étapes de l’entreprise, avec leurs dates, à côté d’une photo. Seulement des faits vrais : une ouverture, une formation, un nouveau lieu, une équipe qui grandit.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-notre-histoire","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-notre-histoire"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Notre histoire</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">D’où nous venons</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Les étapes qui comptent, en quelques lignes.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"38%"} -->
<div class="wp-block-column" style="flex-basis:38%"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : vous ou votre lieu, à vos débuts ou aujourd’hui" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"62%"} -->
<div class="wp-block-column" style="flex-basis:62%"><!-- wp:group {"className":"br-jalons","layout":{"type":"default"}} -->
<div class="wp-block-group br-jalons"><!-- wp:group {"className":"br-jalon","layout":{"type":"default"}} -->
<div class="wp-block-group br-jalon"><!-- wp:paragraph {"className":"br-jalon-annee"} -->
<p class="br-jalon-annee">[année]</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Le début</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Où, comment et pourquoi vous avez commencé.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-jalon","layout":{"type":"default"}} -->
<div class="wp-block-group br-jalon"><!-- wp:paragraph {"className":"br-jalon-annee"} -->
<p class="br-jalon-annee">[année]</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Une étape</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une ouverture, une formation, un nouveau service.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-jalon","layout":{"type":"default"}} -->
<div class="wp-block-group br-jalon"><!-- wp:paragraph {"className":"br-jalon-annee"} -->
<p class="br-jalon-annee">[année]</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Une autre étape</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce qui a changé pour vos clients.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-jalon","layout":{"type":"default"}} -->
<div class="wp-block-group br-jalon"><!-- wp:paragraph {"className":"br-jalon-annee"} -->
<p class="br-jalon-annee">Aujourd’hui</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Où vous en êtes</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">L’équipe, le lieu, ce que vous proposez.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
