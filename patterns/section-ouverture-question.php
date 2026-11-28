<?php
/**
 * Title: Ouverture : Ouverture : une question pour commencer
 * Slug: briise/ouverture-question
 * Categories: briise-ouverture
 * Description: Le haut de l’accueil avec, à la place de la photo, une carte qui pose une seule question et propose deux ou trois gros choix. Chaque choix mène à la bonne page ou au formulaire. Le mot qui change dans le titre se règle avec le bouton « Mots qui changent » de la barre d’outils (mots séparés par « / »).
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-hero br-ouv-question","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-hero br-ouv-question has-surface-background-color has-background"><!-- wp:columns {"verticalAlignment":"center","className":"br-split"} -->
<div class="wp-block-columns are-vertically-aligned-center br-split"><!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%"><!-- wp:paragraph {"className":"br-pastille"} -->
<p class="br-pastille">Votre métier · Votre ville</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre qui dit ce que vous faites, <span class="br-mots">pour les particuliers / pour les entreprises / pour les associations</span></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une ou deux phrases : ce qui vous distingue, et ce que le visiteur gagne à vous appeler.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-coches"} -->
<ul class="wp-block-list br-coches"><!-- wp:list-item -->
<li>Votre premier atout</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Votre délai de réponse</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Votre engagement</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"48%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%"><!-- wp:group {"className":"br-question-carte","layout":{"type":"default"}} -->
<div class="wp-block-group br-question-carte"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Pour commencer</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"br-question-titre"} -->
<h2 class="wp-block-heading br-question-titre">Où en êtes-vous ?</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"br-question-choix","layout":{"type":"default"}} -->
<div class="wp-block-group br-question-choix"><!-- wp:paragraph {"className":"br-question-option br-ic-maison"} -->
<p class="br-question-option br-ic-maison"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><strong>Je découvre</strong><span>Je veux comprendre et être conseillé</span></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-question-option br-ic-horloge"} -->
<p class="br-question-option br-ic-horloge"><a href="<?php echo esc_url( $briise['cta_url'] ); ?>"><strong>C’est pressé</strong><span>Je veux un rendez-vous rapidement</span></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-question-option br-ic-loupe"} -->
<p class="br-question-option br-ic-loupe"><a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>"><strong>Je compare</strong><span>Je veux voir les prix et les formules</span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Vous préférez parler à quelqu’un ? Appelez-nous.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
