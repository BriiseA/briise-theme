<?php
/**
 * Title: Contact : Formulaire de devis en trois étapes
 * Slug: briise/formulaire-etapes
 * Categories: briise-contact
 * Description: Le formulaire de devis découpé en trois étapes courtes : le projet, les détails, les coordonnées. Une demande commencée par le projet va plus souvent au bout. À côté : ce qui se passe ensuite, et le téléphone. Sans script, le formulaire s’affiche en entier.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-form-etapes-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-form-etapes-section"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Demande de devis</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Votre projet en trois étapes</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une minute suffit. Nous vous rappelons pour préciser, puis nous venons mesurer.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[briise_formulaire type="devis" etapes="1"]
<!-- /wp:shortcode --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:group {"className":"br-card br-suite","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-suite"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Ce qui se passe ensuite</h3>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true,"className":"br-suite-liste"} -->
<ol class="wp-block-list br-suite-liste"><!-- wp:list-item -->
<li>Nous vous appelons sous [48 h ouvrées].</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Visite gratuite pour prendre les mesures.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Devis détaillé sous [5 jours].</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:shortcode -->
[briise_appel intro="Plus simple au téléphone ?"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
