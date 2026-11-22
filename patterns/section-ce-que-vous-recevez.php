<?php
/**
 * Title: Offre : Ce que vous recevez
 * Slug: briise/ce-que-vous-recevez
 * Categories: briise-offre
 * Description: Montrer concrètement le résultat livré : une galerie en ligne, un dossier, un carnet d’entretien… dessiné sur un téléphone, avec trois éléments compris.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-recevez","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-recevez"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:group {"className":"br-telephone","layout":{"type":"default"}} -->
<div class="wp-block-group br-telephone"><!-- wp:paragraph {"className":"br-telephone-titre"} -->
<p class="br-telephone-titre">Votre galerie</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-telephone-sous"} -->
<p class="br-telephone-sous">25 photos, gardée un an</p>
<!-- /wp:paragraph -->

<!-- wp:gallery {"columns":2,"linkTo":"none","sizeSlug":"medium","className":"br-telephone-photos"} -->
<figure class="wp-block-gallery has-nested-images columns-2 is-cropped br-telephone-photos"><!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt=""/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery -->

<!-- wp:paragraph {"className":"br-telephone-bouton"} -->
<p class="br-telephone-bouton">Tout télécharger</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%"><!-- wp:heading -->
<h2 class="wp-block-heading">Ce que vous recevez</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase : sous quelle forme, sous quel délai, pour combien de temps.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-liste-oui br-liste-detail"} -->
<ul class="wp-block-list br-liste-oui br-liste-detail"><!-- wp:list-item -->
<li><strong>Premier élément compris.</strong> Ce que c’est, concrètement.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><strong>Deuxième élément.</strong> Une phrase.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><strong>En option.</strong> Ce qui se commande en plus, avec son prix.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
