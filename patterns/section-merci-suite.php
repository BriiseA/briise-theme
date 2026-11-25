<?php
/**
 * Title: Contact : Page merci : la suite
 * Slug: briise/merci-suite
 * Categories: briise-contact
 * Description: Pour la page qui s’affiche après l’envoi d’un formulaire (Mon entreprise > Fonctions > Formulaires) : la confirmation, les étapes datées, le téléphone, et de quoi patienter. La page est retirée de Google automatiquement.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-merci","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-merci"><!-- wp:group {"className":"br-merci-tete","layout":{"type":"default"}} -->
<div class="wp-block-group br-merci-tete"><!-- wp:heading {"level":1,"fontSize":"xx-large","className":"br-merci-titre"} -->
<h1 class="wp-block-heading br-merci-titre has-xx-large-font-size">Merci, votre demande est bien partie</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Un e-mail de confirmation vient de vous être envoyé. Voici la suite.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-merci-etapes","layout":{"type":"default"}} -->
<div class="wp-block-group br-merci-etapes"><!-- wp:group {"className":"br-merci-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-merci-etape"><!-- wp:paragraph {"className":"br-merci-quand"} -->
<p class="br-merci-quand">Sous 48 h ouvrées</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Nous vous appelons pour comprendre le projet.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-merci-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-merci-etape"><!-- wp:paragraph {"className":"br-merci-quand"} -->
<p class="br-merci-quand">Sous 1 semaine</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Visite gratuite chez vous pour les mesures.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-merci-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-merci-etape"><!-- wp:paragraph {"className":"br-merci-quand"} -->
<p class="br-merci-quand">5 jours après</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Vous recevez le devis détaillé.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-merci-bas"} -->
<div class="wp-block-columns br-merci-bas"><!-- wp:column {"width":"45%"} -->
<div class="wp-block-column" style="flex-basis:45%"><!-- wp:group {"className":"br-card br-merci-appel","layout":{"type":"default"}} -->
<div class="wp-block-group br-card br-merci-appel"><!-- wp:heading {"className":"br-merci-sous"} -->
<h2 class="wp-block-heading br-merci-sous">Une question d’ici là ?</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[briise_appel intro="Appelez-nous, c’est la même personne qui suit votre demande."]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"55%"} -->
<div class="wp-block-column" style="flex-basis:55%"><!-- wp:group {"className":"br-merci-attente","layout":{"type":"default"}} -->
<div class="wp-block-group br-merci-attente"><!-- wp:heading {"className":"br-merci-sous"} -->
<h2 class="wp-block-heading br-merci-sous">En attendant</h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"br-merci-liens"} -->
<ul class="wp-block-list br-merci-liens"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Voir nos dernières réalisations</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Tout savoir sur Premier service</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">Les questions qu’on nous pose avant la visite</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
