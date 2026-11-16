<?php
/**
 * Title: Contenu : Derniers articles
 * Slug: briise/derniers-articles
 * Categories: briise-contenu
 * Description: Les trois derniers articles du blog, mis à jour automatiquement.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Nos derniers conseils</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Tous les articles</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"br-posts"} -->
<div class="wp-block-query br-posts"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"br-post-card","layout":{"type":"default"}} -->
<div class="wp-block-group br-post-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:group {"className":"br-post-body","layout":{"type":"default"}} -->
<div class="wp-block-group br-post-body"><!-- wp:post-date {"format":"F Y","className":"br-label"} /-->

<!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-excerpt {"excerptLength":18,"className":"br-muted"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
