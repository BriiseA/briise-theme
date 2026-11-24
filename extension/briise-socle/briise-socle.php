<?php
/**
 * Plugin Name: Briise Socle
 * Plugin URI: https://briise.fr
 * Description: Le fonctionnement des sites Briise, indépendant du thème : Mon entreprise (coordonnées, horaires, annonces, mentions légales), contrôle du maillage, référencement et données structurées, robots.txt, cartes Coordonnées et Zone, mesure des contacts, mises à jour et fin de collaboration.
 * Version: 1.13.7
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author: Briise
 * Author URI: https://briise.fr
 * License: GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: briise
 * Update URI: https://github.com/BriiseA/briise-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BRIISE_SOCLE_VERSION', '1.13.7' );
define( 'BRIISE_SOCLE_DIR', plugin_dir_path( __FILE__ ) );
define( 'BRIISE_SOCLE_URL', plugin_dir_url( __FILE__ ) );

require_once BRIISE_SOCLE_DIR . 'inc/reglages.php';
require_once BRIISE_SOCLE_DIR . 'inc/entreprise.php';
require_once BRIISE_SOCLE_DIR . 'inc/fonctions.php';
require_once BRIISE_SOCLE_DIR . 'inc/seo.php';
require_once BRIISE_SOCLE_DIR . 'inc/menu.php';
require_once BRIISE_SOCLE_DIR . 'inc/robots.php';
require_once BRIISE_SOCLE_DIR . 'inc/maillage.php';
require_once BRIISE_SOCLE_DIR . 'inc/cartes.php';
require_once BRIISE_SOCLE_DIR . 'inc/qualifications.php';
require_once BRIISE_SOCLE_DIR . 'inc/realisations.php';
require_once BRIISE_SOCLE_DIR . 'inc/formulaire.php';
require_once BRIISE_SOCLE_DIR . 'inc/mises-a-jour.php';
require_once BRIISE_SOCLE_DIR . 'inc/securite.php';
require_once BRIISE_SOCLE_DIR . 'inc/photos.php';
if ( is_admin() ) {
	require_once BRIISE_SOCLE_DIR . 'inc/admin.php';
	require_once BRIISE_SOCLE_DIR . 'inc/depart.php';
}

// À l'activation : refaire les adresses (fiches de réalisations).
register_activation_hook( __FILE__, function () {
	update_option( 'briise_refaire_adresses', 1 );
} );

// À la désactivation : les adresses des fiches disparaissent avec l'extension.
register_deactivation_hook( __FILE__, function () {
	if ( post_type_exists( 'briise_realisation' ) ) {
		unregister_post_type( 'briise_realisation' );
	}
	flush_rewrite_rules( false );
} );

/**
 * Le thème Briise est-il actif (directement ou comme parent d'un thème enfant) ?
 */
function briise_theme_actif() {
	return 'briise' === get_template();
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_script( 'briise-socle', BRIISE_SOCLE_URL . 'assets/socle.js', array(), BRIISE_SOCLE_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	// Avec un autre thème : une apparence simple pour le bandeau, les horaires et les cartes.
	if ( ! briise_theme_actif() ) {
		wp_enqueue_style( 'briise-socle', BRIISE_SOCLE_URL . 'assets/socle.css', array(), BRIISE_SOCLE_VERSION );
	}
} );

/**
 * Éditeur : les codes [briise_…] s'affichent sous forme d'étiquette lisible.
 */
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_script( 'briise-editeur', BRIISE_SOCLE_URL . 'assets/editeur.js', array( 'wp-hooks', 'wp-compose', 'wp-element', 'wp-block-editor' ), BRIISE_SOCLE_VERSION, true );
	wp_add_inline_script(
		'briise-editeur',
		'window.briiseEditeur = ' . wp_json_encode(
			array(
				'admin'        => current_user_can( 'manage_options' ),
				'realisations' => function_exists( 'briise_realisations_nom' ) ? briise_realisations_nom() : 'Réalisations',
			)
		) . ';',
		'before'
	);
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
