<?php
/**
 * Title: Confiance : Avis avec la note Google
 * Slug: briise/avis-note
 * Categories: briise-confiance
 * Description: La note moyenne et le nombre d’avis Google, puis trois avis courts. Uniquement la vraie note et des avis réels, recopiés mot pour mot avec l’accord de leur auteur.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-avis-note","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-avis-note"><!-- wp:group {"className":"br-section-head br-tete-deux","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head br-tete-deux"><!-- wp:heading -->
<h2 class="wp-block-heading">Ce qu’en disent nos clients</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-note"} -->
<p class="br-note"><strong class="br-note-chiffre">4,9</strong> <span class="br-note-detail"><span class="br-etoiles" aria-hidden="true">★★★★★</span><span>sur 5, 62 avis Google</span></span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"br-avis-grille"} -->
<div class="wp-block-columns br-avis-grille"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-avis-court","layout":{"type":"default"}} -->
<div class="wp-block-group br-avis-court"><!-- wp:paragraph {"className":"br-avis-etoiles"} -->
<p class="br-avis-etoiles"><span class="br-etoiles" aria-hidden="true">★★★★★</span></p>
<!-- /wp:paragraph -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>« Un avis réel, court, qui raconte une situation précise. »</p>
<!-- /wp:paragraph --><cite><strong>Prénom N.</strong><br>Prestation, ville</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-avis-court","layout":{"type":"default"}} -->
<div class="wp-block-group br-avis-court"><!-- wp:paragraph {"className":"br-avis-etoiles"} -->
<p class="br-avis-etoiles"><span class="br-etoiles" aria-hidden="true">★★★★★</span></p>
<!-- /wp:paragraph -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>« Un deuxième avis, d’un autre type de client. »</p>
<!-- /wp:paragraph --><cite><strong>Prénom N.</strong><br>Prestation, ville</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"br-avis-court","layout":{"type":"default"}} -->
<div class="wp-block-group br-avis-court"><!-- wp:paragraph {"className":"br-avis-etoiles"} -->
<p class="br-avis-etoiles"><span class="br-etoiles" aria-hidden="true">★★★★★</span></p>
<!-- /wp:paragraph -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>« Un troisième avis, qui lève une crainte fréquente. »</p>
<!-- /wp:paragraph --><cite><strong>Prénom N.</strong><br>Prestation, ville</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#">Lire tous les avis sur Google</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
