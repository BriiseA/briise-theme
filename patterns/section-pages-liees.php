<?php
/**
 * Title: Contenu : Pages liées (automatique)
 * Slug: briise/pages-liees
 * Categories: briise-contenu
 * Description: Pages de service : les autres services, avec un lien vers chacun. Sur une page qui a des sous-pages : la liste de ses sous-pages. Se met à jour seule.
 * Viewport Width: 1400
 */
$briise = briise_entreprise();
?>
<!-- wp:group {"backgroundColor":"surface","align":"full","className":"br-section br-section-liees","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-section-liees has-surface-background-color has-background"><!-- wp:group {"className":"br-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group br-section-head"><!-- wp:heading -->
<h2 class="wp-block-heading">Nos autres services</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-arrow"} -->
<p class="br-arrow"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Tous nos services</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[briise_pages_liees]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
