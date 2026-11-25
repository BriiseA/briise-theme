<?php
/**
 * Title: Parcours : FAQ avec recherche et thèmes
 * Slug: briise/faq-recherche
 * Categories: briise-parcours
 * Description: Page FAQ ou longue liste de questions : un champ « Chercher une question » et un bouton par thème (vos intertitres) s’ajoutent seuls au-dessus. Rangez les questions sous des intertitres de niveau 3. Sur la page choisie comme FAQ, les questions sont transmises à Google.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-faq-cherche","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-faq-cherche"><!-- wp:columns {"className":"br-split"} -->
<div class="wp-block-columns br-split"><!-- wp:column {"width":"34%"} -->
<div class="wp-block-column" style="flex-basis:34%"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Questions fréquentes</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Vos questions avant de nous appeler</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[briise_appel intro="Pas de réponse ? Nous répondons en direct."]
<!-- /wp:shortcode --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"66%"} -->
<div class="wp-block-column" style="flex-basis:66%"><!-- wp:heading {"level":3,"className":"br-faq-theme"} -->
<h3 class="wp-block-heading br-faq-theme">Le devis</h3>
<!-- /wp:heading -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Le devis est-il gratuit ?</summary><!-- wp:paragraph -->
<p>Oui. La visite et le devis sont gratuits et sans engagement. Vous le recevez par e-mail sous [x] jours.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Combien de temps faut-il pour recevoir le devis ?</summary><!-- wp:paragraph -->
<p>Comptez [x] jours après la visite. Le délai réel est écrit sur le devis.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:heading {"level":3,"className":"br-faq-theme"} -->
<h3 class="wp-block-heading br-faq-theme">Les travaux</h3>
<!-- /wp:heading -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Combien de temps durent les travaux ?</summary><!-- wp:paragraph -->
<p>Donnez un délai concret, même approximatif : c’est l’une des premières choses que l’on cherche.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Faut-il être présent pendant le chantier ?</summary><!-- wp:paragraph -->
<p>Une réponse directe en deux ou trois phrases. Commencez par oui ou par non quand c’est possible.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:heading {"level":3,"className":"br-faq-theme"} -->
<h3 class="wp-block-heading br-faq-theme">Le prix et le paiement</h3>
<!-- /wp:heading -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Quels sont vos tarifs ?</summary><!-- wp:paragraph -->
<p>Une fourchette honnête vaut mieux que « sur devis » seul. Renvoyez vers la page des tarifs si elle existe.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Comment se passe le paiement ?</summary><!-- wp:paragraph -->
<p>Moyens acceptés, acompte éventuel, échéances.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:paragraph {"className":"br-faq-vide"} -->
<p class="br-faq-vide">Aucune question ne correspond. Appelez-nous : nous répondons en direct.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
