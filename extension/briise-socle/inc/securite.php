<?php
/**
 * Sécurité : protections de base, actives par défaut (Mon entreprise > Fonctions > Protections de sécurité),
 * et points à vérifier affichés dans l'onglet Contrôle.
 *
 * Ce que fait l'extension : identifiants de connexion cachés, XML-RPC fermé, en-têtes de sécurité,
 * éditeur de fichiers désactivé, message d'erreur de connexion neutre, version de WordPress cachée.
 * Ce qu'elle ne fait pas (hébergeur et réglages du site) : HTTPS, sauvegardes, double authentification.
 *
 * @package Briise_Socle
 */

defined( 'ABSPATH' ) || exit;

if ( briise_fonction( 'securite' ) ) {

	// Éditeur de code des thèmes et extensions : désactivé (une faille de mot de passe ne donne pas l'accès au code).
	if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
		define( 'DISALLOW_FILE_EDIT', true );
	}

	// XML-RPC : ancienne porte d'entrée, utilisée pour tester des mots de passe en masse. Personne n'en a besoin ici.
	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		status_header( 403 );
		exit( 'XML-RPC désactivé.' );
	}
	add_filter( 'xmlrpc_enabled', '__return_false' );
	add_filter( 'xmlrpc_methods', '__return_empty_array' );
	add_filter( 'wp_headers', function ( $h ) {
		unset( $h['X-Pingback'] );
		return $h;
	} );
	remove_action( 'wp_head', 'rsd_link' );

	// Version de WordPress : ne pas l'annoncer.
	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'the_generator', '__return_empty_string' );

	// Identifiants de connexion : ?author=1 et les pages d'auteur ne les révèlent plus aux visiteurs.
	add_action( 'template_redirect', function () {
		if ( is_user_logged_in() ) {
			return;
		}
		if ( isset( $_GET['author'] ) || is_author() ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}, 1 );

	// Liste des utilisateurs dans l'API : réservée aux personnes connectées (l'éditeur en a besoin).
	add_filter( 'rest_endpoints', function ( $routes ) {
		if ( ! is_user_logged_in() ) {
			foreach ( array_keys( $routes ) as $route ) {
				if ( 0 === strpos( $route, '/wp/v2/users' ) ) {
					unset( $routes[ $route ] );
				}
			}
		}
		return $routes;
	} );

	// Intégrations (oEmbed) : pas de nom d'auteur.
	add_filter( 'oembed_response_data', function ( $data ) {
		unset( $data['author_name'], $data['author_url'] );
		return $data;
	} );

	// Connexion : le message ne dit plus si c'est l'identifiant ou le mot de passe qui est faux.
	add_filter( 'login_errors', function ( $msg ) {
		return ( false !== stripos( $msg, 'mot de passe' ) || false !== stripos( $msg, 'password' ) || false !== stripos( $msg, 'identifiant' ) || false !== stripos( $msg, 'username' ) )
			? '<strong>Erreur :</strong> identifiant ou mot de passe incorrect.'
			: $msg;
	} );

	// En-têtes de sécurité sur toutes les pages publiques.
	add_action( 'send_headers', function () {
		if ( headers_sent() ) {
			return;
		}
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
		header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()' );
	} );
}

/**
 * Points de sécurité à corriger avant la mise en ligne. Retourne [ [titre, explication], ... ].
 */
function briise_securite_points() {
	$out = array();

	if ( ! briise_fonction( 'securite' ) ) {
		$out[] = array( 'Protections de sécurité désactivées', 'Les réactiver dans Mon entreprise > Fonctions, sauf raison précise.' );
	}
	if ( 0 !== strpos( home_url(), 'https://' ) ) {
		$out[] = array( 'Le site n’est pas en HTTPS', 'Activer le certificat chez l’hébergeur, puis passer l’adresse en https dans Réglages > Général.' );
	}
	foreach ( array( 'admin', 'administrateur', 'administrator' ) as $login ) {
		if ( get_user_by( 'login', $login ) ) {
			$out[] = array( 'Un compte s’appelle « ' . $login . ' »', 'C’est le premier identifiant que les robots essaient. Créer un autre compte administrateur, puis supprimer celui-ci en attribuant ses contenus au nouveau.' );
		}
	}
	if ( ! get_option( 'blog_public' ) ) {
		$out[] = array( 'Le site demande à Google de ne pas l’indexer', 'Normal pendant la création. À décocher le jour de la mise en ligne : Réglages > Lecture.' );
	}
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG && ( ! defined( 'WP_DEBUG_DISPLAY' ) || WP_DEBUG_DISPLAY ) ) {
		$out[] = array( 'Les erreurs PHP s’affichent aux visiteurs', 'Mettre WP_DEBUG à false dans wp-config.php (ou demander à l’hébergeur).' );
	}
	$maj = 0;
	foreach ( array( 'update_plugins', 'update_themes' ) as $t ) {
		$v    = get_site_transient( $t );
		$maj += ( $v && ! empty( $v->response ) ) ? count( $v->response ) : 0;
	}
	if ( $maj ) {
		$out[] = array( $maj . ' mise' . ( $maj > 1 ? 's' : '' ) . ' à jour en attente', 'Tableau de bord > Mises à jour. Une extension pas à jour est la première cause de piratage.' );
	}
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$inactives = array_diff( array_keys( get_plugins() ), (array) get_option( 'active_plugins', array() ) );
	if ( $inactives ) {
		$out[] = array( count( $inactives ) . ' extension' . ( count( $inactives ) > 1 ? 's' : '' ) . ' désactivée' . ( count( $inactives ) > 1 ? 's' : '' ), 'Une extension désactivée reste sur le serveur et peut contenir une faille. Supprimer celles qui ne servent pas (Extensions > Désactivées).' );
	}
	$deux_facteurs = class_exists( 'Two_Factor_Core' ) || defined( 'WORDFENCE_LS_VERSION' ) || class_exists( 'WP_2FA\\WP2FA' ) || defined( 'ITSEC_PLUGIN_FILE' );
	if ( ! $deux_facteurs ) {
		$out[] = array( 'Pas de double authentification', 'Installer l’extension gratuite Two Factor et l’activer pour chaque administrateur (Utilisateurs > Profil).' );
	}
	return $out;
}
