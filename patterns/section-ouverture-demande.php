<?php
/**
 * Title: Ouverture : Grande photo et demande express
 * Slug: briise/ouverture-demande
 * Categories: briise-ouverture
 * Description: La demande dès l’arrivée : une grande photo, le titre, et à droite un formulaire de quatre champs (projet, commune, nom, téléphone) pour être rappelé. Le formulaire « Demande de rappel » se crée dans Mon entreprise > Fonctions. Idéale aussi pour une page de publicité.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>","dimRatio":70,"overlayColor":"sombre","isUserOverlayColor":true,"minHeight":80,"minHeightUnit":"vh","contentPosition":"center center","align":"full","className":"br-banniere br-ouv-plein br-ouv-demande","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull br-banniere br-ouv-plein br-ouv-demande" style="min-height:80vh"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-sombre-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Votre métier, votre ville</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre qui dit ce que vous faites, et où</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Laissez votre numéro : nous vous rappelons dans la journée ouvrée pour fixer un rendez-vous.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-coches"} -->
<ul class="wp-block-list br-coches"><!-- wp:list-item -->
<li>Premier échange gratuit</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Réponse sous [délai]</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Votre engagement</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%"><!-- wp:group {"className":"br-card br-ouv-form","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-ouv-form"><!-- wp:paragraph {"className":"br-ouv-form-titre"} -->
<p class="br-ouv-form-titre">Votre projet en 30 secondes</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[briise_formulaire type="rappel"]
<!-- /wp:shortcode -->

<!-- wp:paragraph {"className":"br-muted br-ouv-form-lien"} -->
<p class="br-muted br-ouv-form-lien">Vous préférez écrire ? <a href="<?php echo esc_url( $briise['cta_url'] ); ?>">Le formulaire complet</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->
