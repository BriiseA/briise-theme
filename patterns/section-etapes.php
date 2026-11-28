<?php
/**
 * Title: Parcours : Étapes (4 versions)
 * Slug: briise/etapes
 * Categories: briise-parcours
 * Description: Rassurer sur le déroulé : du premier contact au résultat, avec la durée de chaque étape. Forme au choix dans le panneau « Version » : frise qui se remplit au défilement, fil vertical, cartes numérotées, zigzag de part et d’autre d’une ligne, cartes empilées au défilement.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"nuance","align":"full","className":"br-section br-etapes br-deroule br-deroule\u002d\u002dfrise","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-etapes br-deroule br-deroule--frise has-nuance-background-color has-background"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Comment ça se passe</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Trois étapes, sans surprise</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fil br-fil\u002d\u002dfrise","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil br-fil--frise"><!-- wp:group {"className":"br-fil-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil-etape"><!-- wp:paragraph {"className":"br-fil-num"} -->
<p class="br-fil-num">1</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Vous nous contactez</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-fil-texte"} -->
<p class="br-fil-texte">Par téléphone ou par le formulaire. Nous répondons sous 24 heures ouvrées.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-duree"} -->
<p class="br-duree">Réponse sous 24 h</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fil-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil-etape"><!-- wp:paragraph {"className":"br-fil-num"} -->
<p class="br-fil-num">2</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Nous faisons le point</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-fil-texte"} -->
<p class="br-fil-texte">Un échange pour comprendre votre besoin, puis une proposition claire et détaillée.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-duree"} -->
<p class="br-duree">Premier échange offert</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fil-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil-etape"><!-- wp:paragraph {"className":"br-fil-num"} -->
<p class="br-fil-num">3</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Nous réalisons</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-fil-texte"} -->
<p class="br-fil-texte">Aux dates convenues, avec un interlocuteur unique du début à la fin.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-duree"} -->
<p class="br-duree">Délai annoncé à l’avance</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
