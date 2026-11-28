<?php
/**
 * Title: Offre : Formules et tarifs (4 versions)
 * Slug: briise/tarifs-cartes
 * Categories: briise-offre
 * Description: Deux à quatre formules avec leur prix. Forme au choix dans le panneau « Version » : cartes (celle du milieu en avant), vedette sombre, menu (nom, pointillés, prix), bandes horizontales, cartes sobres sans mise en avant. Seulement des prix réels.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"nuance","align":"full","className":"br-section br-formules br-formules\u002d\u002dcartes","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-formules br-formules--cartes has-nuance-background-color has-background"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Tarifs</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Des prix clairs, sans surprise</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-prices"} -->
<div class="wp-block-columns br-prices"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-card br-price","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-price"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Première formule</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-stat"} -->
<p class="br-stat">[prix] €</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase sur ce que comprend cette formule.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-br-tirets"} -->
<ul class="wp-block-list is-style-br-tirets"><!-- wp:list-item -->
<li>Ce qui est inclus</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un deuxième élément</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un troisième élément</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>">Choisir cette formule</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-card br-price br-price\u002d\u002dvedette","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-price br-price--vedette"><!-- wp:paragraph {"className":"br-chip"} -->
<p class="br-chip">Le plus choisi</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Formule la plus choisie</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-stat"} -->
<p class="br-stat">[prix] €</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase sur ce que comprend cette formule.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-br-tirets"} -->
<ul class="wp-block-list is-style-br-tirets"><!-- wp:list-item -->
<li>Ce qui est inclus</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un deuxième élément</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un troisième élément</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>">Choisir cette formule</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-card br-price","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-price"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Formule complète</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-stat"} -->
<p class="br-stat">[prix] €</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Une phrase sur ce que comprend cette formule.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-br-tirets"} -->
<ul class="wp-block-list is-style-br-tirets"><!-- wp:list-item -->
<li>Ce qui est inclus</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un deuxième élément</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Un troisième élément</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>">Choisir cette formule</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
