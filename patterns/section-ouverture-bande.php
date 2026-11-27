<?php
/**
 * Title: Ouverture : Ouverture avec bande de services
 * Slug: briise/ouverture-bande
 * Categories: briise-ouverture
 * Description: La même ouverture, avec en bas vos services en grand sur une bande qui défile doucement (pause au survol, au clavier ou avec le bouton). Les noms viennent de vos pages de service : vérifiez qu’il y en a au moins quatre, ou retirez les noms en trop.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-hero br-ouverture br-ouverture\u002d\u002dbanniere","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-hero br-ouverture br-ouverture--banniere"><!-- wp:group {"className":"br-ouv-grille","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-grille"><!-- wp:group {"className":"br-ouv-texte","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-texte"><!-- wp:paragraph {"className":"br-pastille"} -->
<p class="br-pastille">Votre métier · Votre ville</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Le titre qui <img class="br-mot-photo" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt=""> dit ce que vous faites, <img class="br-mot-photo" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage-2.svg' ) ); ?>" alt=""> <mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-accent-color">et où</mark></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"br-lead"} -->
<p class="br-lead">Une ou deux phrases : pour qui, ce qui vous distingue, et ce que le visiteur gagne à vous appeler.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $briise['cta_url'] ); ?>"><?php echo esc_html( $briise['cta_label'] ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/realisations/' ) ); ?>">Voir nos réalisations</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:list {"className":"br-coches"} -->
<ul class="wp-block-list br-coches"><!-- wp:list-item -->
<li>Devis gratuit</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Votre délai de réponse</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Votre garantie</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-ouv-media","layout":{"type":"default"}} -->
<div class="wp-block-group br-ouv-media"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"br-ouv-photo"} -->
<figure class="wp-block-image size-full br-ouv-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/banniere.svg' ) ); ?>" alt="Photo à remplacer : votre meilleure réalisation, ou vous au travail"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"br-ouv-photo"} -->
<figure class="wp-block-image size-full br-ouv-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage.svg' ) ); ?>" alt="Photo à remplacer : votre meilleure réalisation, ou vous au travail"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"br-ouv-photo"} -->
<figure class="wp-block-image size-full br-ouv-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/paysage-2.svg' ) ); ?>" alt="Photo à remplacer : votre meilleure réalisation, ou vous au travail"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"br-ouv-photo"} -->
<figure class="wp-block-image size-full br-ouv-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ); ?>" alt="Photo à remplacer : votre meilleure réalisation, ou vous au travail"/></figure>
<!-- /wp:image -->

<!-- wp:shortcode -->
[briise_infos_ouverture]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"br-defile br-defile\u002d\u002dservices","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull br-defile br-defile--services"><!-- wp:group {"className":"br-defile-piste","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group br-defile-piste"><!-- wp:paragraph {"className":"br-defile-item"} -->
<p class="br-defile-item">Premier service</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-defile-item"} -->
<p class="br-defile-item">Deuxième service</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-defile-item"} -->
<p class="br-defile-item">Troisième service</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"br-defile-item"} -->
<p class="br-defile-item">Quatrième service</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
