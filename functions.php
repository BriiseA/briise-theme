<?php
/**
 * Briise : thème de base de l'agence.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Le fonctionnement (Mon entreprise, référencement, contrôle…) est dans l'extension Briise Socle.
// Sans elle, le thème s'affiche quand même, avec des valeurs vides, et prévient l'administrateur.
require_once get_theme_file_path( 'inc/socle.php' );
require_once get_theme_file_path( 'inc/kits.php' );
require_once get_theme_file_path( 'inc/performance.php' );
require_once get_theme_file_path( 'inc/styles-section.php' );
require_once get_theme_file_path( 'inc/tableaux.php' );
if ( is_admin() ) {
	require_once get_theme_file_path( 'inc/contraste.php' );
}

add_action( 'after_setup_theme', function () {
	add_post_type_support( 'page', 'excerpt' );
} );

add_action( 'init', function () {
	register_block_pattern_category( 'briise', array( 'label' => __( 'Briise', 'briise' ) ) );
	$familles = array(
		'ouverture' => 'Ouverture',
		'offre'     => 'Offre et tarifs',
		'confiance' => 'Confiance et preuves',
		'parcours'  => 'Parcours et FAQ',
		'personnes' => 'Personnes',
		'contenu'   => 'Contenu',
		'contact'   => 'Contact',
	);
	foreach ( $familles as $slug => $label ) {
		register_block_pattern_category( 'briise-' . $slug, array( 'label' => 'Sections · ' . $label ) );
	}
	register_block_style( 'core/image', array( 'name' => 'br-arrondi', 'label' => __( 'Arrondi', 'briise' ) ) );
	register_block_style( 'core/image', array( 'name' => 'br-galet', 'label' => __( 'Galet', 'briise' ) ) );
	register_block_style( 'core/list', array( 'name' => 'br-tirets', 'label' => __( 'Galets', 'briise' ) ) );
} );

/**
 * Animations légères, site public uniquement, coupées si le visiteur
 * a demandé à réduire les animations.
 */
add_action( 'wp_head', function () {
	if ( ! briise_theme_fonction( 'animations' ) ) {
		return;
	}
	wp_print_inline_script_tag( "if(!window.matchMedia('(prefers-reduced-motion: reduce)').matches){var d=document.documentElement;d.classList.add('br-motion');setTimeout(function(){if(!window.briiseMotionLoaded){d.classList.remove('br-motion');}},3000);}" );
}, 1 );
add_action( 'wp_enqueue_scripts', function () {
	$version = wp_get_theme()->get( 'Version' );
	if ( briise_theme_fonction( 'animations' ) ) {
		wp_enqueue_style( 'briise-motion', get_theme_file_uri( 'assets/css/motion.css' ), array(), $version );
		wp_enqueue_script( 'briise-motion', get_theme_file_uri( 'assets/js/motion.js' ), array(), $version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}
	wp_enqueue_style( 'briise-ux', get_theme_file_uri( 'assets/css/ux.css' ), array(), $version );
	wp_enqueue_script( 'briise-ux', get_theme_file_uri( 'assets/js/ux.js' ), array(), $version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	wp_add_inline_script( 'briise-ux', 'window.briiseUx=' . wp_json_encode( array(
		'menu'     => briise_theme_fonction( 'menu_remonte' ),
		'jour'     => briise_theme_fonction( 'horaires_jour' ),
		'sommaire' => briise_theme_fonction( 'sommaire_faq' ),
	) ) . ';', 'before' );
} );


/**
 * Hero bannière : sa photo est l'élément le plus visible de la page,
 * elle est donc chargée en priorité (meilleur temps d'affichage).
 */
add_filter( 'render_block_core/cover', function ( $html, $block ) {
	static $fait = false;
	if ( $fait || false === strpos( $block['attrs']['className'] ?? '', 'br-banniere' ) ) {
		return $html;
	}
	$fait = true;
	$html = str_replace( ' loading="lazy"', '', $html );
	return preg_replace( '/<img (?![^>]*fetchpriority)/', '<img fetchpriority="high" ', $html, 1 );
}, 10, 2 );

/**
 * Une page qui a sa propre ouverture (en-tête de page, hero) n'affiche pas
 * en plus le titre du modèle « Pages » : un seul titre principal par page.
 */
add_filter( 'render_block_core/post-title', function ( $html, $block ) {
	if ( is_page() && 1 === (int) ( $block['attrs']['level'] ?? 2 ) && false === strpos( $block['attrs']['className'] ?? '', 'br-titre' ) ) {
		$contenu = get_post_field( 'post_content', get_queried_object_id() );
		if ( preg_match( '/br-page-head|br-banniere|br-hero/', $contenu ) ) {
			return '';
		}
	}
	return $html;
}, 10, 2 );

/* ----- Retour en haut ------------------------------------------------------ */

add_action( 'wp_footer', function () {
	if ( ! briise_theme_fonction( 'retour_haut' ) ) {
		return;
	}
	echo '<a href="#" id="br-haut" class="br-haut" aria-label="Revenir en haut de la page"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 19V5M5 12l7-7 7 7"/></svg></a>';
}, 5 );

/**
 * En-tête flottant (Mon entreprise > Fonctions).
 */
add_filter( 'body_class', function ( $classes ) {
	if ( briise_theme_fonction( 'entete_flottant' ) ) {
		$classes[] = 'br-entete-flottant';
	}
	return $classes;
} );

/**
 * En-tête de page sans photo : pour les visiteurs, le texte prend toute la largeur ;
 * pour les personnes qui peuvent modifier la page, un fond aux couleurs du site montre
 * où ira la photo (l'onglet Contrôle signale aussi la photo manquante).
 */
add_filter( 'render_block_core/post-featured-image', function ( $html, $block ) {
	if ( '' !== trim( $html ) || false === strpos( $block['attrs']['className'] ?? '', 'br-tete-media' ) ) {
		return $html;
	}
	if ( ! current_user_can( 'edit_pages' ) ) {
		return $html;
	}
	return '<div class="br-photo-secours br-tete-media" aria-hidden="true"><span>Ajoutez l’image mise en avant de la page</span></div>';
}, 10, 2 );

