<?php
/**
 * Title: Confiance : Toutes les réalisations, avec filtres (automatique)
 * Slug: briise/realisations-toutes
 * Categories: briise-confiance
 * Description: Page des réalisations : toutes les fiches publiées, avec des boutons pour filtrer par catégorie. Se met à jour seule.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-section-realisations","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-section-realisations"><!-- wp:shortcode -->
[briise_realisations filtres="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
