<?php
/**
 * Title: Offre : Tableau comparatif
 * Slug: briise/tableau-comparatif
 * Categories: briise-offre
 * Description: Aider à choisir entre deux ou trois formules.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Comparer</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Quelle formule vous convient ?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Les différences essentielles, en un coup d’œil.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:table {"hasFixedLayout":false,"className":"br-table"} -->
<figure class="wp-block-table br-table"><table><thead><tr><th>Critère</th><th>Formule essentielle</th><th>Formule complète</th></tr></thead><tbody><tr><td>Pour qui</td><td>Un besoin ponctuel</td><td>Un accompagnement suivi</td></tr><tr><td>Durée</td><td>1 heure</td><td>3 mois</td></tr><tr><td>Suivi</td><td>—</td><td>Un point par mois</td></tr><tr><td>Tarif</td><td>60 €</td><td>450 €</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
