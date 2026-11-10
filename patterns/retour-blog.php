<?php
/**
 * Title: Retour au blog
 * Slug: briise/retour-blog
 * Categories: briise
 * Viewport Width: 1400
 * Inserter: no
 */
?>
<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>">Tous les articles</a></p>
<!-- /wp:paragraph -->
