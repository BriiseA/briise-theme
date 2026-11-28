<?php
/**
 * Title: Contact : Appel à l’action (4 versions)
 * Slug: briise/bandeau-cta
 * Categories: briise-contact
 * Description: Fin de page : une dernière invitation à passer à l’action. Forme au choix dans le panneau « Version » : bandeau, carte posée sur la page, bande fine, titre géant.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"secondaire","textColor":"fond","align":"full","className":"br-section br-cta br-appel br-appel\u002d\u002dbandeau","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-cta br-appel br-appel--bandeau has-fond-color has-secondaire-background-color has-text-color has-background"><!-- wp:group {"className":"br-cta-inner","layout":{"type":"default"}} -->
<div class="wp-block-group br-cta-inner"><!-- wp:heading -->
<h2 class="wp-block-heading">Une question, un projet ?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une phrase qui lève le dernier frein : réponse rapide, premier échange sans engagement, prix annoncé à l’avance.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"fond","textColor":"texte"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-texte-color has-fond-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
