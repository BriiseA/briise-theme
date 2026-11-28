<?php
/**
 * Title: Personnes : On recrute
 * Slug: briise/recrutement
 * Categories: briise-personnes
 * Description: Les postes ouverts, avec une photo de l’équipe : le contrat, le lieu et une phrase par poste, et le lien pour postuler. Retirez la section quand aucun poste n’est ouvert.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-recrute","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-recrute"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">On recrute</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Rejoignez l’équipe</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Ce que vous offrez à ceux qui vous rejoignent : l’ambiance, la formation, les horaires.</p>
<!-- /wp:paragraph -->

<!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : l’équipe au travail" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:group {"className":"br-postes","layout":{"type":"default"}} -->
<div class="wp-block-group br-postes"><!-- wp:group {"className":"br-poste","layout":{"type":"default"}} -->
<div class="wp-block-group br-poste"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Intitulé du premier poste</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-poste-infos"} -->
<p class="br-poste-infos">[Contrat] · [Temps plein ou partiel] · [Ville]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que la personne fera, en une phrase.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="#">Voir le poste et postuler</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-poste","layout":{"type":"default"}} -->
<div class="wp-block-group br-poste"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Intitulé du deuxième poste</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-poste-infos"} -->
<p class="br-poste-infos">[Contrat] · [Temps plein ou partiel] · [Ville]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que la personne fera, en une phrase.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="#">Voir le poste et postuler</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Pas de poste pour vous ? Envoyez une candidature spontanée.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
