<?php
/**
 * Title: Confiance : Dernières réalisations (automatique)
 * Slug: briise/realisations
 * Categories: briise-confiance
 * Description: Accueil : les trois dernières réalisations publiées (menu Réalisations), avec un lien vers toutes. Se met à jour seule ; disparaît s’il n’y en a aucune.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-section-realisations","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-section-realisations"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Nos dernières réalisations</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Toutes les réalisations</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[briise_realisations nombre="3"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
