<?php
/**
 * Title: Ouverture : Deux portes : urgent ou projet
 * Slug: briise/ouverture-deux-portes
 * Categories: briise-ouverture
 * Description: Dépannage et métiers d’urgence : dès l’arrivée, deux chemins. « C’est urgent » : l’appel en grand, les pannes courantes qui mènent à leur page, le geste à faire en attendant. « J’ai un projet » : une photo et la demande de devis. Le téléphone vient de Mon entreprise.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-ouv-portes","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-ouv-portes"><!-- wp:group {"className":"br-ouv-portes-tete","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-portes-tete"><!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
<h1 class="wp-block-heading has-xx-large-font-size">Votre métier à votre ville, en urgence ou sur rendez-vous</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase de preuve : prix annoncé avant de commencer, devis signé avant les travaux, note Google réelle.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-ouv-portes-cols"} -->
<div class="wp-block-columns br-ouv-portes-cols"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-porte br-porte\u002d\u002durgence","layout":{"type":"default"}} -->
<div class="wp-block-group br-porte br-porte--urgence"><!-- wp:paragraph {"className":"br-porte-statut"} -->
<p class="br-porte-statut">Intervention possible aujourd’hui</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"br-porte-titre"} -->
<h2 class="wp-block-heading br-porte-titre">C’est urgent</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[briise_appel texte="Appeler" intro=""]
<!-- /wp:shortcode -->

<!-- wp:paragraph {"className":"br-porte-sous"} -->
<p class="br-porte-sous">Votre problème</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"br-porte-liens","layout":{"type":"default"}} -->
<div class="wp-block-group br-porte-liens"><!-- wp:paragraph {"className":"br-porte-lien"} -->
<p class="br-porte-lien"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Premier service</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-porte-lien"} -->
<p class="br-porte-lien"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Deuxième service</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-porte-lien"} -->
<p class="br-porte-lien"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Troisième service</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-porte-lien"} -->
<p class="br-porte-lien"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Quatrième service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"br-porte-attente"} -->
<p class="br-porte-attente">En attendant : le geste qui limite les dégâts. <a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">Les bons gestes</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>","dimRatio":60,"overlayColor":"sombre","isUserOverlayColor":true,"minHeight":100,"minHeightUnit":"%","contentPosition":"bottom left","className":"br-porte br-porte\u002d\u002dprojet","layout":{"type":"default"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left br-porte br-porte--projet" style="min-height:100%"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-sombre-background-color has-background-dim-60 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"className":"br-porte-titre"} -->
<h2 class="wp-block-heading br-porte-titre">J’ai un projet</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Installation, rénovation ou entretien : visite et devis gratuits.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
