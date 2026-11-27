<?php
/**
 * Title: Ouverture : Ouverture (10 versions)
 * Slug: briise/ouverture
 * Categories: briise-ouverture
 * Description: Le haut de l’accueil : pastille, grand titre, phrase, bouton d’action et second bouton, trois atouts, et vos photos. Choisissez la forme dans le panneau « Version » : photo à côté, bannière plein écran, photo coupée en biais, moitié-moitié, arche, titre géant, diaporama, mosaïque en tuiles, titre avec photos ou photo qui s’agrandit. Le diaporama fait défiler en fondu les quatre photos ; la mosaïque en montre trois ; les autres versions, la première. Une carte d’infos se pose sur la photo : ouvert aujourd’hui, prochaine date libre (Horaires et annonces) et votre ville ; sans ces données, elle ne s’affiche pas. Une vidéo courte (bloc Vidéo, sans son) peut remplacer la photo : elle joue en boucle, avec un bouton pause.
 * Viewport Width: 1400
 */
$briise = briise_theme_entreprise();
?>
<!-- wp:group {"align":"full","className":"br-section br-hero br-ouverture br-ouverture\u002d\u002dcote","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-section br-hero br-ouverture br-ouverture--cote"><!-- wp:group {"className":"br-ouv-grille","layout":{"type":"default"}} -->
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
<!-- /wp:group --></div>
<!-- /wp:group -->
