<?php
/**
 * Title: Contact : Formulaire de demande de devis
 * Slug: briise/formulaire
 * Categories: briise-contact
 * Description: Le formulaire de devis (Fluent Forms, créé dans Mon entreprise > Fonctions), avec ce qui se passe après l’envoi. Sans formulaire : téléphone et e-mail.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Votre demande</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Parlons de votre projet</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ce qui se passe après l’envoi : sous quel délai vous répondez, et par quel moyen.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-br-tirets"} -->
<ul class="wp-block-list is-style-br-tirets"><!-- wp:list-item -->
<li>Réponse sous 24 heures ouvrées</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Devis gratuit et sans engagement</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Vos données ne servent qu’à vous répondre</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:group {"className":"br-card br-formulaire","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-formulaire"><!-- wp:shortcode -->
[briise_formulaire type="devis"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
