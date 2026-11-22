<?php
/**
 * Title: Offre : Où se passe la prestation
 * Slug: briise/lieux
 * Categories: briise-offre
 * Description: Deux ou trois lieux possibles (chez vous, dans nos locaux, en extérieur), chacun avec sa photo et ses faits. Le premier peut porter une pastille (« Idéal pour… »).
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-lieux","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-lieux has-surface-background-color has-background"><!-- wp:group {"className":"br-section-head br-tete-deux","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head br-tete-deux"><!-- wp:heading -->
<h2 class="wp-block-heading">Chez vous, dans nos locaux ou dehors : vous choisissez</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase qui dit si le prix change selon le lieu, et jusqu’où vous vous déplacez.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-lieux-grille"} -->
<div class="wp-block-columns br-lieux-grille"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:group {"className":"br-lieu","layout":{"type":"default"}} -->
<div class="wp-block-group br-lieu"><!-- wp:group {"className":"br-lieu-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-lieu-media"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : vos locaux" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-pastille"} -->
<p class="br-pastille">Idéal pour…</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Dans nos locaux</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que le client y trouve, en une phrase.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-liste-oui"} -->
<ul class="wp-block-list br-liste-oui"><!-- wp:list-item -->
<li>Un premier fait concret</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un deuxième fait</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un troisième fait</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-lieu","layout":{"type":"default"}} -->
<div class="wp-block-group br-lieu"><!-- wp:group {"className":"br-lieu-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-lieu-media"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : chez un client" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Chez vous</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que ça change pour le client.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-liste-oui"} -->
<ul class="wp-block-list br-liste-oui"><!-- wp:list-item -->
<li>Un fait concret</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>La zone couverte sans frais</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-lieu","layout":{"type":"default"}} -->
<div class="wp-block-group br-lieu"><!-- wp:group {"className":"br-lieu-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-lieu-media"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : en extérieur" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">En extérieur</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Les lieux, la saison, l’heure.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-liste-oui"} -->
<ul class="wp-block-list br-liste-oui"><!-- wp:list-item -->
<li>Un fait concret</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Une solution de repli</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
