<?php
/**
 * Title: Confiance : Une réalisation racontée
 * Slug: briise/realisation-racontee
 * Categories: briise-confiance
 * Description: Une réalisation qui raconte votre façon de travailler : la commune et la date, trois faits (délai, durée, matériaux), le besoin, la solution, l’avis du client et le résultat. Une vraie réalisation, des photos du chantier, l’avis avec l’accord du client.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-recit","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-recit"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"46%"} -->
<div class="wp-block-column" style="flex-basis:46%"><!-- wp:group {"className":"br-recit-photos","layout":{"type":"default"}} -->
<div class="wp-block-group br-recit-photos"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-recit-photo"} -->
<figure class="wp-block-image size-full br-recit-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : l’ouvrage terminé, en entier" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"1/1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"br-recit-detail"} -->
<figure class="wp-block-image size-full br-recit-detail"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : un détail de fabrication" style="aspect-ratio:1/1;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"54%"} -->
<div class="wp-block-column" style="flex-basis:54%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Réalisation, [commune], [mois année]</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Le titre de la réalisation, avec ce qu’elle a de particulier</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"br-recit-faits","layout":{"type":"default"}} -->
<div class="wp-block-group br-recit-faits"><!-- wp:group {"className":"br-recit-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-recit-fait"><!-- wp:paragraph {"className":"br-recit-fait-nom"} -->
<p class="br-recit-fait-nom">Fabrication</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-recit-fait-val"} -->
<p class="br-recit-fait-val">[x] semaines</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-recit-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-recit-fait"><!-- wp:paragraph {"className":"br-recit-fait-nom"} -->
<p class="br-recit-fait-nom">Pose</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-recit-fait-val"} -->
<p class="br-recit-fait-val">[x] jour</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-recit-fait","layout":{"type":"default"}} -->
<div class="wp-block-group br-recit-fait"><!-- wp:paragraph {"className":"br-recit-fait-nom"} -->
<p class="br-recit-fait-nom">Matériaux</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-recit-fait-val"} -->
<p class="br-recit-fait-val">[matériaux]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"br-recit-etape"} -->
<h3 class="wp-block-heading br-recit-etape">Le besoin</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ce que le client voulait, et ce qui le gênait avant. Deux phrases, avec ses mots.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"br-recit-etape"} -->
<h3 class="wp-block-heading br-recit-etape">Notre solution</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ce que vous avez proposé et pourquoi : le choix technique, ce qui a été dessiné ou ajusté avec lui.</p>
<!-- /wp:paragraph -->

<!-- wp:quote {"className":"br-recit-avis"} -->
<blockquote class="wp-block-quote br-recit-avis"><!-- wp:paragraph -->
<p>« L’avis réel du client, une ou deux phrases, avec son accord. »</p>
<!-- /wp:paragraph --><cite>Prénom N., [commune]</cite></blockquote>
<!-- /wp:quote -->

<!-- wp:heading {"level":3,"className":"br-recit-etape"} -->
<h3 class="wp-block-heading br-recit-etape">Le résultat</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ce qui a changé pour le client, concrètement.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Voir nos réalisations du même type</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
