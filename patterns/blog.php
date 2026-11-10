<?php
/**
 * Title: Liste des articles
 * Slug: briise/blog
 * Categories: briise
 * Viewport Width: 1400
 * Inserter: no
 */
?>
<!-- wp:group {"align":"full","className":"br-section br-page-head","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-page-head"><!-- wp:group {"className":"br-head","layout":{"type":"default"}} -->
<div class="wp-block-group br-head"><!-- wp:paragraph {"className":"br-label"} -->
<p class="br-label">Blog</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Actualités et conseils</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Nos derniers articles.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"br-section br-section\u002d\u002dtight","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-section--tight"><!-- wp:query {"queryId":0,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"className":"br-posts"} -->
<div class="wp-block-query br-posts"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"br-post-card","layout":{"type":"default"}} -->
<div class="wp-block-group br-post-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:group {"className":"br-post-body","layout":{"type":"default"}} -->
<div class="wp-block-group br-post-body"><!-- wp:post-date {"format":"F Y","className":"br-label"} /-->

<!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-excerpt {"excerptLength":18,"className":"br-muted"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
