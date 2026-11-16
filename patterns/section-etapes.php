<?php
/**
 * Title: Parcours : Étapes numérotées
 * Slug: briise/etapes
 * Categories: briise-parcours
 * Description: Rassurer sur le déroulé : du premier contact au résultat.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"nuance","align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section has-nuance-background-color has-background"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Comment ça se passe</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Trois étapes, sans surprise</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-steps"} -->
<div class="wp-block-columns br-steps"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">1</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Vous nous contactez</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Par téléphone ou par le formulaire. Nous répondons sous 24 heures ouvrées.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">2</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Nous faisons le point</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Un échange pour comprendre votre besoin, puis un devis clair et détaillé.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"br-num"} -->
<p class="br-num">3</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Nous réalisons</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Aux dates convenues, avec un interlocuteur unique du début à la fin.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
