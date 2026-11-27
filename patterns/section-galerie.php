<?php
/**
 * Title: Confiance : Galerie (5 versions)
 * Slug: briise/galerie
 * Categories: briise-confiance
 * Description: Six photos de votre travail, de votre lieu ou de votre équipe ; chacune s’agrandit en plein écran au clic ou au clavier. Choisissez la forme dans le panneau « Version » : mosaïque, grille régulière, bande qui défile, photos posées en vrac ou une en grand. Le texte alternatif de chaque photo décrit vraiment ce qu’elle montre.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-galeries br-galeries\u002d\u002dmosaique br-titre\u002d\u002dcentre","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-galeries br-galeries--mosaique br-titre--centre"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">En images</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Un aperçu de notre travail</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:gallery {"columns":3,"linkTo":"none","className":"br-mosaique br-galeries-photos"} -->
<figure class="wp-block-gallery has-nested-images columns-3 is-cropped br-mosaique br-galeries-photos"><!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo 1 à remplacer : décrivez ce qu’elle montre"/></figure>
<!-- /wp:image -->

<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/portrait.svg' ) ); ?>" alt="Photo 2 à remplacer : décrivez ce qu’elle montre"/></figure>
<!-- /wp:image -->

<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo 3 à remplacer : décrivez ce qu’elle montre"/></figure>
<!-- /wp:image -->

<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-2.svg' ) ); ?>" alt="Photo 4 à remplacer : décrivez ce qu’elle montre"/></figure>
<!-- /wp:image -->

<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage-2.svg' ) ); ?>" alt="Photo 5 à remplacer : décrivez ce qu’elle montre"/></figure>
<!-- /wp:image -->

<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre-3.svg' ) ); ?>" alt="Photo 6 à remplacer : décrivez ce qu’elle montre"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery --></div>
<!-- /wp:group -->
