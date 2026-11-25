<?php
/**
 * Cache des pages vidé automatiquement.
 *
 * Une extension de cache (W3 Total Cache, WP Rocket, LiteSpeed…) garde une copie toute prête
 * de chaque page. Un réglage qui touche tout le site (logo, coordonnées, apparence, polices,
 * menu, styles) ne se voyait donc pas tant que le cache n'était pas vidé à la main : chez
 * Lison Vautrin, l'accueil montrait encore le nom en texte deux jours après l'ajout du logo.
 *
 * Le cache est vidé, une seule fois par chargement de page, quand :
 * - un réglage Briise change (Mon entreprise, Apparence, Polices, horaires et annonces…) ;
 * - le menu, un modèle, une partie de modèle ou les styles globaux sont enregistrés ;
 * - le thème Briise ou l'extension Briise Socle est mis à jour.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vide le cache des pages des extensions de cache courantes, si elles sont actives.
 *
 * @return string[] Extensions dont le cache a été vidé.
 */
function briise_vider_caches() {
	$vides = array();
	if ( function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all();
		$vides[] = 'W3 Total Cache';
	}
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
		$vides[] = 'WP Rocket';
	}
	if ( defined( 'LSCWP_V' ) ) {
		do_action( 'litespeed_purge_all' );
		$vides[] = 'LiteSpeed Cache';
	}
	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
		$vides[] = 'WP Super Cache';
	}
	if ( isset( $GLOBALS['wp_fastest_cache'] ) && method_exists( $GLOBALS['wp_fastest_cache'], 'deleteCache' ) ) {
		$GLOBALS['wp_fastest_cache']->deleteCache( true );
		$vides[] = 'WP Fastest Cache';
	}
	if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
		sg_cachepress_purge_cache();
		$vides[] = 'SiteGround Optimizer';
	}
	if ( has_action( 'cache_enabler_clear_complete_cache' ) ) {
		do_action( 'cache_enabler_clear_complete_cache' );
		$vides[] = 'Cache Enabler';
	}
	if ( has_action( 'breeze_clear_all_cache' ) ) {
		do_action( 'breeze_clear_all_cache' );
		$vides[] = 'Breeze';
	}
	if ( has_action( 'wphb_clear_page_cache' ) ) {
		do_action( 'wphb_clear_page_cache' );
		$vides[] = 'Hummingbird';
	}
	return $vides;
}

/** Demande un vidage, fait une seule fois à la fin du chargement de la page. */
function briise_vider_caches_plus_tard() {
	static $prevu = false;
	if ( $prevu ) {
		return;
	}
	$prevu = true;
	add_action( 'shutdown', 'briise_vider_caches', 1 );
}

// Réglages Briise : toutes les options qui commencent par « briise_ », sauf les mémoires internes
// (les transients ne sont pas concernés : leur nom commence par « _transient_ »).
add_action( 'updated_option', function ( $option, $avant, $apres ) {
	if ( 0 !== strpos( $option, 'briise_' ) || $avant === $apres ) {
		return;
	}
	if ( preg_match( '/^briise_(refaire_adresses|indexnow|logos_noms|kit$)/', $option ) ) {
		return;
	}
	briise_vider_caches_plus_tard();
}, 10, 3 );
add_action( 'added_option', function ( $option ) {
	if ( 0 === strpos( $option, 'briise_' ) && ! preg_match( '/^briise_(refaire_adresses|indexnow|logos_noms|kit$)/', $option ) ) {
		briise_vider_caches_plus_tard();
	}
} );

// Logo (géré par WordPress), nom et slogan du site.
foreach ( array( 'update_option_site_logo', 'update_option_blogname', 'update_option_blogdescription', 'update_option_theme_mods_briise' ) as $briise_crochet ) {
	add_action( $briise_crochet, 'briise_vider_caches_plus_tard' );
}
unset( $briise_crochet );

// Menu, modèles, parties de modèle (en-tête, pied de page) et styles globaux : ils sont sur toutes les pages.
add_action( 'save_post', function ( $post_id, $post ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	if ( in_array( $post->post_type, array( 'wp_navigation', 'wp_template', 'wp_template_part', 'wp_global_styles' ), true ) ) {
		briise_vider_caches_plus_tard();
	}
}, 10, 2 );

// Mise à jour du thème Briise ou de l'extension Briise Socle.
add_action( 'upgrader_process_complete', function ( $upgrader, $infos ) {
	$type = $infos['type'] ?? '';
	if ( 'theme' === $type ) {
		$themes = (array) ( $infos['themes'] ?? array() );
		if ( in_array( 'briise', $themes, true ) || ( isset( $upgrader->result['destination_name'] ) && 'briise' === $upgrader->result['destination_name'] ) ) {
			briise_vider_caches_plus_tard();
		}
	} elseif ( 'plugin' === $type ) {
		foreach ( (array) ( $infos['plugins'] ?? array( $infos['plugin'] ?? '' ) ) as $p ) {
			if ( 0 === strpos( (string) $p, 'briise-socle/' ) ) {
				briise_vider_caches_plus_tard();
			}
		}
	}
}, 10, 2 );
