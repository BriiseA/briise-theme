<?php
/**
 * Title: Offre : Abonnements (mensuel ou annuel)
 * Slug: briise/abonnements
 * Categories: briise-offre
 * Description: Pour les abonnements (cours, coaching, entretien, adhésion) : chaque formule a un prix au mois et un prix à l’année, et un sélecteur « Au mois / À l’année » en haut. Sans script, les deux prix restent affichés. Mêmes versions que « Formules et tarifs ». Seulement des prix réels.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"nuance","align":"full","className":"br-section br-formules br-formules\u002d\u002dcartes br-abonnement","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-formules br-formules--cartes br-abonnement has-nuance-background-color has-background"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Abonnements</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Choisissez votre rythme</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase sur ce que l’on gagne à l’année, si c’est vrai.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-prices"} -->
<div class="wp-block-columns br-prices"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-card br-price","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-price"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Première formule</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-stat br-prix-mois"} -->
<p class="br-stat br-prix-mois">[prix] € <small>/ mois</small></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-stat br-prix-an"} -->
<p class="br-stat br-prix-an">[prix] € <small>/ an</small></p>
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

<!-- wp:paragraph {"className":"br-stat br-prix-mois"} -->
<p class="br-stat br-prix-mois">[prix] € <small>/ mois</small></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-stat br-prix-an"} -->
<p class="br-stat br-prix-an">[prix] € <small>/ an</small></p>
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

<!-- wp:paragraph {"className":"br-stat br-prix-mois"} -->
<p class="br-stat br-prix-mois">[prix] € <small>/ mois</small></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-stat br-prix-an"} -->
<p class="br-stat br-prix-an">[prix] € <small>/ an</small></p>
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
