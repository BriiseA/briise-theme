<?php
/**
 * Title: Offre : Estimateur de budget
 * Slug: briise/estimateur
 * Categories: briise-offre
 * Description: Trois questions, une fourchette de prix honnête, puis la demande de devis. Le barème est le tableau : une ligne par choix (question, choix, montant bas, montant haut, ajoutés au total). Une question avec un seul choix devient une case à cocher. Les montants viennent du client, constatés sur ses chantiers.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-estim","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-estim has-surface-background-color has-background"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"56%"} -->
<div class="wp-block-column" style="flex-basis:56%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Estimer votre budget</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Combien coûte votre projet ?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Trois questions, une fourchette honnête. Le prix exact est donné après la visite, gratuite.</p>
<!-- /wp:paragraph -->

<!-- wp:table {"hasFixedLayout":false,"className":"br-table br-estim-bareme"} -->
<figure class="wp-block-table br-table br-estim-bareme"><table><thead><tr><th>Question</th><th>Choix</th><th>De (€)</th><th>À (€)</th></tr></thead><tbody><tr><td>Forme</td><td>Droit</td><td>3 200</td><td>4 500</td></tr><tr><td>Forme</td><td>Quart tournant</td><td>4 200</td><td>6 000</td></tr><tr><td>Forme</td><td>Hélicoïdal</td><td>5 200</td><td>7 800</td></tr><tr><td>Marches</td><td>Acier</td><td>0</td><td>0</td></tr><tr><td>Marches</td><td>Chêne</td><td>600</td><td>900</td></tr><tr><td>Avec garde-corps à l’étage</td><td>Oui</td><td>900</td><td>900</td></tr></tbody></table></figure>
<!-- /wp:table --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"44%"} -->
<div class="wp-block-column" style="flex-basis:44%"><!-- wp:group {"className":"br-estim-resultat","layout":{"type":"default"}} -->
<div class="wp-block-group br-estim-resultat"><!-- wp:paragraph {"className":"br-estim-label"} -->
<p class="br-estim-label">Budget habituel, fourni et posé</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-estim-montant"} -->
<p class="br-estim-montant">Choisissez vos réponses : la fourchette s’affiche ici.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-estim-note"} -->
<p class="br-estim-note">Fourchette indicative, constatée sur nos chantiers de l’an passé. Le prix exact est écrit sur le devis.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
