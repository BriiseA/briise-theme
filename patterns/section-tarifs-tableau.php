<?php
/**
 * Title: Offre : Tableau de tarifs simple
 * Slug: briise/tarifs-tableau
 * Categories: briise-offre
 * Description: Pour une liste de prestations nombreuses : une ligne par prestation.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Tarifs</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Nos prestations et leurs prix</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:table {"hasFixedLayout":false,"className":"br-table"} -->
<figure class="wp-block-table br-table"><table><thead><tr><th>Prestation</th><th>Durée</th><th>Prix</th></tr></thead><tbody><tr><td>Première prestation</td><td>30 min</td><td>25 €</td></tr><tr><td>Deuxième prestation</td><td>1 h</td><td>45 €</td></tr><tr><td>Troisième prestation</td><td>1 h 30</td><td>65 €</td></tr><tr><td>Forfait de quatre séances</td><td>4 × 1 h</td><td>160 €</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Prix TTC. Une précision utile : moyens de paiement acceptés, conditions d’annulation.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
