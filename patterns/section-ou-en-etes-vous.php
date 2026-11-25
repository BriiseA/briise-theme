<?php
/**
 * Title: Parcours : Où en êtes-vous ?
 * Slug: briise/ou-en-etes-vous
 * Categories: briise-parcours
 * Description: Quand les visiteurs arrivent dans des situations différentes : quatre cartes qui partent de leur situation, dite comme ils la diraient, avec la réponse, le prix et la page qui y répond. Tout est visible sans clic. Icône au choix par la classe du bloc : br-ic-maison, fleches, loupe, horloge, euro, bouclier, coeur, appareil. Seulement un prix réel, ou « Sur devis ».
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-situations-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-situations-section"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Par où commencer</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Où en êtes-vous ?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Choisissez la phrase qui vous ressemble : vous voyez ce qui vous servira, et ce que ça coûte.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-situations","layout":{"type":"grid","minimumColumnWidth":"14rem"}} -->
<div class="wp-block-group br-situations"><!-- wp:group {"className":"br-situation br-ic-maison","layout":{"type":"default"}} -->
<div class="wp-block-group br-situation br-ic-maison"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Je découvre, je ne sais pas par où commencer.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que vous proposez pour démarrer, en une phrase.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-situation-prix"} -->
<p class="br-situation-prix"><strong>Votre prix réel, ou « Sur devis »</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Voir ce service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-situation br-ic-fleches","layout":{"type":"default"}} -->
<div class="wp-block-group br-situation br-ic-fleches"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">J’ai déjà essayé, sans le résultat espéré.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce que vous faites autrement, concrètement.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-situation-prix"} -->
<p class="br-situation-prix"><strong>Votre prix réel, ou « Sur devis »</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Voir ce service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-situation br-ic-loupe","layout":{"type":"default"}} -->
<div class="wp-block-group br-situation br-ic-loupe"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Je sais ce que je veux, je compare.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce qui vous distingue, chiffre à l’appui.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-situation-prix"} -->
<p class="br-situation-prix"><strong>Votre prix réel, ou « Sur devis »</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Voir ce service</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-situation br-ic-horloge","layout":{"type":"default"}} -->
<div class="wp-block-group br-situation br-ic-horloge"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">C’est pressé.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Votre délai réel pour intervenir ou répondre.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-situation-prix"} -->
<p class="br-situation-prix"><strong>Votre prix réel, ou « Sur devis »</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
