<?php
/**
 * Title: Parcours : Orientation : la bonne page en une phrase
 * Slug: briise/orientation
 * Categories: briise-parcours
 * Description: Accueil d’une offre large : « Je cherche [choix] pour [choix] », et le bouton mène à la page qui répond. Chaque ligne de la liste est une réponse possible, écrite « premier choix | second choix », avec le lien vers sa page. Une seule partie par ligne donne un seul menu. Ajoutez une troisième partie pour nommer la page sur le bouton.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-oriente br-section\u002d\u002dtight","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-oriente br-section--tight has-surface-background-color has-background"><!-- wp:group {"className":"br-oriente-boite","layout":{"type":"default"}} -->
<div class="wp-block-group br-oriente-boite"><!-- wp:heading {"className":"br-oriente-titre"} -->
<h2 class="wp-block-heading br-oriente-titre">Trouvez la page faite pour vous</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-oriente-phrase"} -->
<p class="br-oriente-phrase">Je cherche … pour …</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-oriente-choix"} -->
<ul class="wp-block-list br-oriente-choix"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Premier service | un particulier</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Premier service | une entreprise</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Deuxième service | un particulier</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Deuxième service | une entreprise</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Troisième service | un particulier</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
