<?php
/**
 * Title: Parcours : Déroulé et prix, côte à côte
 * Slug: briise/etapes-prix
 * Categories: briise-parcours
 * Description: Pages de service : les étapes sur un fil qui se remplit au défilement, et le prix dans la colonne qui reste à l’écran. Le visiteur lit le déroulé et voit le prix en même temps.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"backgroundColor":"fond","align":"full","className":"br-section br-etapes br-etapes-fil","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-etapes br-etapes-fil has-fond-background-color has-background"><!-- wp:columns {"className":"br-etapes-cols"} -->
<div class="wp-block-columns br-etapes-cols"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:group {"className":"br-etapes-cote","layout":{"type":"default"}} -->
<div class="wp-block-group br-etapes-cote"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Comment ça se passe</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">De la première visite à la fin du chantier</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"br-prix-carte","layout":{"type":"default"}} -->
<div class="wp-block-group br-prix-carte"><!-- wp:table {"hasFixedLayout":false,"className":"br-table"} -->
<figure class="wp-block-table br-table"><table><thead><tr><th>Prestation</th><th>Prix TTC</th></tr></thead><tbody><tr><td>Prestation la plus courante</td><td>À partir de… €</td></tr><tr><td>Option fréquente</td><td>+ … €</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph {"className":"br-muted"} -->
<p class="br-muted">Ce qui fait varier le prix, en une phrase. Le prix exact figure sur le devis.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-compris","layout":{"type":"default"}} -->
<div class="wp-block-group br-compris"><!-- wp:paragraph {"className":"br-compris-titre"} -->
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
<li>Le nettoyage du chantier</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"br-compris-titre is-non"} -->
<p class="br-compris-titre is-non">Non compris</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"br-liste-non"} -->
<ul class="wp-block-list br-liste-non"><!-- wp:list-item -->
<li>Ce que le client doit prévoir de son côté</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:group {"className":"br-fil br-fil\u002d\u002dvertical","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil br-fil--vertical"><!-- wp:group {"className":"br-fil-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil-etape"><!-- wp:paragraph {"className":"br-fil-num"} -->
<p class="br-fil-num">1</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La visite</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-fil-texte"} -->
<p class="br-fil-texte">Ce qui se passe au premier rendez-vous, et qui vient.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-duree"} -->
<p class="br-duree">Gratuite</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fil-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil-etape"><!-- wp:paragraph {"className":"br-fil-num"} -->
<p class="br-fil-num">2</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Le devis</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-fil-texte"} -->
<p class="br-fil-texte">Avec quoi : plan, échantillons, prix détaillé.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-duree"} -->
<p class="br-duree">Sous … jours</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fil-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil-etape"><!-- wp:paragraph {"className":"br-fil-num"} -->
<p class="br-fil-num">3</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La préparation</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-fil-texte"} -->
<p class="br-fil-texte">Où, par qui, ce que le client a à faire.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-duree"} -->
<p class="br-duree">… semaines</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-fil-etape","layout":{"type":"default"}} -->
<div class="wp-block-group br-fil-etape"><!-- wp:paragraph {"className":"br-fil-num"} -->
<p class="br-fil-num">4</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">La fin du chantier</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-fil-texte"} -->
<p class="br-fil-texte">Propreté, ce que le client reçoit, la garantie.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-duree"} -->
<p class="br-duree">… jours</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
