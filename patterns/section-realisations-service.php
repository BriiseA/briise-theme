<?php
/**
 * Title: Confiance : Réalisations de ce service (automatique, 4 versions)
 * Slug: briise/realisations-service
 * Categories: briise-confiance
 * Description: Page de service : les réalisations rattachées à ce service. Forme au choix dans le panneau « Version » : grille, liste, une en grand, défilement. Disparaît tant qu’il n’y en a aucune.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-section-realisations br-projets br-projets\u002d\u002dgrille","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-section-realisations br-projets br-projets--grille"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Nos réalisations pour ce service</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Toutes les réalisations</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[briise_realisations service="auto" nombre="3"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
