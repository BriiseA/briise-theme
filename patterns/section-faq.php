<?php
/**
 * Title: Parcours : FAQ en accordéon
 * Slug: briise/faq
 * Categories: briise-parcours
 * Description: Lever les freins avant le contact. Sur la page choisie comme FAQ, les questions sont transmises à Google.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"38%"} -->
<div class="wp-block-column" style="flex-basis:38%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Questions fréquentes</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Vos questions, nos réponses</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Vous ne trouvez pas votre réponse ?</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( $briise['cta_url'] ); ?>">Posez-nous la question</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"62%"} -->
<div class="wp-block-column" style="flex-basis:62%"><!-- wp:details -->
<details class="wp-block-details"><summary>Une question que vos clients posent souvent ?</summary><!-- wp:paragraph -->
<p>Une réponse directe en deux ou trois phrases. Commencez par oui ou par non quand c’est possible.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Combien de temps faut-il compter ?</summary><!-- wp:paragraph -->
<p>Donnez un délai concret, même approximatif : c’est l’une des premières choses que l’on cherche.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Quels sont vos tarifs ?</summary><!-- wp:paragraph -->
<p>Une fourchette honnête vaut mieux que « sur devis » seul. Renvoyez vers la page des tarifs si elle existe.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Intervenez-vous dans ma ville ?</summary><!-- wp:paragraph -->
<p>Citez les villes ou le rayon couvert. C’est aussi utile pour le référencement local.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Comment se passe le paiement ?</summary><!-- wp:paragraph -->
<p>Moyens acceptés, acompte éventuel, échéances.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
