<?php
/**
 * Title: Contact : Préparez votre demande
 * Slug: briise/preparez-demande
 * Categories: briise-contact
 * Description: Juste avant le formulaire ou sur la page de devis : les trois choses à avoir sous la main pour une réponse rapide et juste. Icônes au choix par la classe du bloc (br-ic-appareil, metre, calendrier, maison, euro, horloge…).
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-prepa","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-prepa"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Avant de demander</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Préparez votre demande en 2 minutes</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Avec ces trois éléments, nous vous répondons plus vite et plus juste.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>">J’ai tout, je fais ma demande</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:group {"className":"br-prepa-liste","layout":{"type":"default"}} -->
<div class="wp-block-group br-prepa-liste"><!-- wp:group {"className":"br-prepa-item br-ic-appareil","layout":{"type":"default"}} -->
<div class="wp-block-group br-prepa-item br-ic-appareil"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Deux ou trois photos</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">L’endroit vu de loin, puis de près. Le téléphone suffit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-prepa-item br-ic-metre","layout":{"type":"default"}} -->
<div class="wp-block-group br-prepa-item br-ic-metre"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Une mesure</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">La hauteur sous plafond, une longueur, une surface. Une estimation suffit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-prepa-item br-ic-calendrier","layout":{"type":"default"}} -->
<div class="wp-block-group br-prepa-item br-ic-calendrier"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La commune et vos dates</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Où se trouve le chantier, et pour quand vous aimeriez que ce soit fait.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
