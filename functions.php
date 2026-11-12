<?php
/**
 * Briise : thème de base de l'agence.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_theme_file_path( 'inc/reglages.php' );
require_once get_theme_file_path( 'inc/entreprise.php' );
require_once get_theme_file_path( 'inc/fonctions.php' );
require_once get_theme_file_path( 'inc/seo.php' );
if ( is_admin() ) {
	require_once get_theme_file_path( 'inc/admin.php' );
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
	if ( ! briise_fonction( 'animations' ) ) {
		return;
	}
	wp_print_inline_script_tag( "if(!window.matchMedia('(prefers-reduced-motion: reduce)').matches){var d=document.documentElement;d.classList.add('br-motion');setTimeout(function(){if(!window.briiseMotionLoaded){d.classList.remove('br-motion');}},3000);}" );
}, 1 );
add_action( 'wp_enqueue_scripts', function () {
	$version = wp_get_theme()->get( 'Version' );
	if ( briise_fonction( 'animations' ) ) {
		wp_enqueue_style( 'briise-motion', get_theme_file_uri( 'assets/css/motion.css' ), array(), $version );
		wp_enqueue_script( 'briise-motion', get_theme_file_uri( 'assets/js/motion.js' ), array(), $version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}
	wp_enqueue_style( 'briise-ux', get_theme_file_uri( 'assets/css/ux.css' ), array(), $version );
	wp_enqueue_script( 'briise-ux', get_theme_file_uri( 'assets/js/ux.js' ), array(), $version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	wp_add_inline_script( 'briise-ux', 'window.briiseUx=' . wp_json_encode( array(
		'menu'     => briise_fonction( 'menu_remonte' ),
		'jour'     => briise_fonction( 'horaires_jour' ),
		'sommaire' => briise_fonction( 'sommaire_faq' ),
	) ) . ';', 'before' );
} );


/**
 * Page d'accueil : les comptes sans droit d'administration
 * ne modifient que les textes et les images.
 */
add_filter( 'block_editor_settings_all', function ( $settings, $context ) {
	if ( empty( $context->post ) || current_user_can( 'edit_theme_options' ) || ! briise_fonction( 'verrou' ) ) {
		return $settings;
	}
	if ( (int) $context->post->ID === (int) get_option( 'page_on_front' ) ) {
		$settings['templateLock'] = 'contentOnly';
	}
	return $settings;
}, 10, 2 );

/**
 * Sécurité : seuls les administrateurs insèrent du HTML non filtré.
 */
add_filter( 'map_meta_cap', function ( $caps, $cap, $user_id ) {
	if ( 'unfiltered_html' === $cap && ! user_can( $user_id, 'manage_options' ) ) {
		return array( 'do_not_allow' );
	}
	return $caps;
}, 10, 3 );

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
