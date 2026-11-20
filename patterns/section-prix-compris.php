<?php
/**
 * Title: Offre : Prix et ce qu’il comprend
 * Slug: briise/prix-compris
 * Categories: briise-offre
 * Description: Les prix, puis deux listes courtes : ce qui est compris, ce qui ne l’est pas. Elles répondent à la peur numéro un du prospect, les mauvaises surprises sur le devis.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"fond","align":"full","className":"br-section br-prix-compris","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-prix-compris has-fond-background-color has-background"><!-- wp:columns {"className":"br-etapes-cols"} -->
<div class="wp-block-columns br-etapes-cols"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Le prix</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Ce que comprend le prix</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"br-prix-carte","layout":{"type":"default"}} -->
<div class="wp-block-group br-prix-carte"><!-- wp:table {"hasFixedLayout":false,"className":"br-table"} -->
<figure class="wp-block-table br-table"><table><thead><tr><th>Prestation</th><th>Prix TTC</th></tr></thead><tbody><tr><td>Prestation la plus courante</td><td>À partir de… €</td></tr><tr><td>Option fréquente</td><td>+ … €</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Le prix exact figure sur le devis, après la visite.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:group {"className":"br-compris br-compris-cols","layout":{"type":"default"}} -->
<div class="wp-block-group br-compris br-compris-cols"><!-- wp:group {"className":"","layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"br-compris-titre"} -->
<p class="br-compris-titre">Compris dans le prix</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-liste-oui"} -->
<ul class="wp-block-list br-liste-oui"><!-- wp:list-item -->
<li>La visite et le devis</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Le matériel et la main-d’œuvre</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>La pose et le nettoyage du chantier</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"","layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"br-compris-titre is-non"} -->
<p class="br-compris-titre is-non">Non compris</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-liste-non"} -->
<ul class="wp-block-list br-liste-non"><!-- wp:list-item -->
<li>Ce que le client doit prévoir de son côté</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Les travaux d’un autre corps de métier</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
