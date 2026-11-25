<?php
/**
 * Title: Ouverture : Accueil en mosaïque de réalisations
 * Slug: briise/ouverture-mosaique
 * Categories: briise-ouverture
 * Description: La preuve dès l’arrivée : le titre et les boutons à gauche, trois réalisations récentes à droite, chacune avec son ouvrage et sa commune. Chaque photo mène aux réalisations.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-ouv-mosaique","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-ouv-mosaique"><!-- wp:group {"className":"br-ouv-mosaique-grille","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-mosaique-grille"><!-- wp:group {"className":"br-ouv-mosaique-texte","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-mosaique-texte"><!-- wp:paragraph {"className":"br-pastille"} -->
<p class="br-pastille">Votre métier · Votre ville</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
<h1 class="wp-block-heading has-xx-large-font-size">Nos derniers ouvrages, posés près de chez vous</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Chaque projet est dessiné pour sa pièce. Voici les trois derniers, avec leur commune.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Toutes nos réalisations</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-ouv-tuile br-ouv-tuile\u002d\u002dhaute","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-tuile br-ouv-tuile--haute"><!-- wp:image {"sizeSlug":"large","linkDestination":"custom"} -->
<figure class="wp-block-image size-large"><a href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo à remplacer : une réalisation récente"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-ouv-legende"} -->
<p class="br-ouv-legende">Type d’ouvrage, commune</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-ouv-tuile","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-tuile"><!-- wp:image {"sizeSlug":"large","linkDestination":"custom"} -->
<figure class="wp-block-image size-large"><a href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : une autre réalisation"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-ouv-legende"} -->
<p class="br-ouv-legende">Type d’ouvrage, commune</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-ouv-tuile","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-tuile"><!-- wp:image {"sizeSlug":"large","linkDestination":"custom"} -->
<figure class="wp-block-image size-large"><a href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo à remplacer : une troisième réalisation"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"br-ouv-legende"} -->
<p class="br-ouv-legende">Type d’ouvrage, commune</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
