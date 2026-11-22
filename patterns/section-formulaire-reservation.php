<?php
/**
 * Title: Contact : Formulaire de réservation
 * Slug: briise/formulaire-reservation
 * Categories: briise-contact
 * Description: Page « Réserver » : le formulaire de réservation (prestation, lieu, date souhaitée, coordonnées ; créé dans Mon entreprise > Fonctions), avec à côté la prochaine date libre et ce qui se passe après l’envoi.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-reservation","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-reservation"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:shortcode -->
[briise_fil_ariane]
<!-- /wp:shortcode -->

<!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
<h1 class="wp-block-heading has-xx-large-font-size">Réserver</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Trois questions et vos coordonnées : réponse sous 24 h avec nos disponibilités. Rien n’est payé à cette étape.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"br-card br-formulaire","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-formulaire"><!-- wp:shortcode -->
[briise_formulaire type="reservation"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:group {"className":"br-reservation-cote","layout":{"type":"default"}} -->
<div class="wp-block-group br-reservation-cote"><!-- wp:group {"className":"br-lieu-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-lieu-media"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-br-arrondi"} -->
<figure class="wp-block-image size-full is-style-br-arrondi"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : votre lieu ou votre travail" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:shortcode -->
[briise_disponibilite]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:heading {"className":"br-h3"} -->
<h2 class="wp-block-heading br-h3">Et ensuite ?</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true,"className":"br-ensuite"} -->
<ol class="wp-block-list br-ensuite"><!-- wp:list-item -->
<li><strong>Sous 24 h</strong> Nous vous répondons avec nos disponibilités.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><strong>Ensuite</strong> Un appel de 15 minutes pour préparer ensemble.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><strong>Pour confirmer</strong> L’acompte réserve votre date.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:shortcode -->
[briise_appel]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
