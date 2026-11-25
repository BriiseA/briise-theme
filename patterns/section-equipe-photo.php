<?php
/**
 * Title: Personnes : L’équipe en une photo et quatre faits
 * Slug: briise/equipe-photo
 * Categories: briise-personnes
 * Description: Quand vous êtes plusieurs : une photo de groupe devant l’atelier ou le camion, et quatre faits qui rassurent (nombre de personnes, sous-traitance, interlocuteur unique, ancienneté), sans fiche par personne. Seul ? Préférez « Présentation du dirigeant ».
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-equipe-photo","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-equipe-photo"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"56%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:56%"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : toute l’équipe devant l’atelier ou le camion" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">L’équipe</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Une équipe, du premier appel à la pose</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"br-equipe-faits","layout":{"type":"default"}} -->
<div class="wp-block-group br-equipe-faits"><!-- wp:group {"className":"br-equipe-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-equipe-fait"><!-- wp:paragraph {"className":"br-equipe-chiffre"} -->
<p class="br-equipe-chiffre">[4]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-equipe-texte"} -->
<p class="br-equipe-texte">personnes, toutes salariées</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-equipe-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-equipe-fait"><!-- wp:paragraph {"className":"br-equipe-chiffre"} -->
<p class="br-equipe-chiffre">0</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-equipe-texte"} -->
<p class="br-equipe-texte">chantier confié à un sous-traitant</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-equipe-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-equipe-fait"><!-- wp:paragraph {"className":"br-equipe-chiffre"} -->
<p class="br-equipe-chiffre">1</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-equipe-texte"} -->
<p class="br-equipe-texte">interlocuteur, de la visite à la pose</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-equipe-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-equipe-fait"><!-- wp:paragraph {"className":"br-equipe-chiffre"} -->
<p class="br-equipe-chiffre">[2011]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-equipe-texte"} -->
<p class="br-equipe-texte">année d’ouverture de l’atelier</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/a-propos/' ) ); ?>">Qui sommes-nous</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
