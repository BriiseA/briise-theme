<?php
/**
 * Title: Confiance : Galerie de réalisations filtrable (automatique)
 * Slug: briise/realisations-galerie
 * Categories: briise-confiance
 * Description: Toutes les réalisations publiées en grande galerie de photos, avec un bouton par catégorie et le nombre de réalisations. Chaque photo mène à sa fiche. Se met à jour seule.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-section-realisations","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-section-realisations"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Nos réalisations</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[briise_realisations filtres="1" forme="galerie" niveau="3"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
