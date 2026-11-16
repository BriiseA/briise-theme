<?php
/**
 * Robots et moteurs : robots.txt explicite pour les moteurs de recherche IA,
 * validation Bing Webmaster Tools, signalement IndexNow des pages publiées.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ----- robots.txt ------------------------------------------------------------ */

/**
 * Robots des moteurs de recherche et des assistants IA : toujours autorisés,
 * sinon le site n'est plus cité dans leurs réponses.
 */
function briise_robots_recherche() {
	return apply_filters( 'briise_robots_recherche', array(
		'Googlebot', 'Bingbot', 'Applebot', 'DuckDuckBot',
		'OAI-SearchBot', 'ChatGPT-User',
		'PerplexityBot', 'Perplexity-User',
		'Claude-SearchBot', 'Claude-User',
	) );
}

/**
 * Robots qui collectent des textes pour entraîner des modèles d'IA :
 * refusés seulement si la fonction « Autoriser l'entraînement des IA » est décochée.
 */
function briise_robots_entrainement() {
	return apply_filters( 'briise_robots_entrainement', array(
		'GPTBot', 'ClaudeBot', 'Google-Extended', 'Applebot-Extended', 'CCBot', 'meta-externalagent', 'Bytespider',
	) );
}

add_filter( 'robots_txt', function ( $sortie, $public ) {
	if ( ! $public ) {
		return $sortie; // Site masqué aux moteurs (Réglages > Lecture) : on ne touche à rien.
	}
	$lignes = array( '', '# Briise : moteurs de recherche et assistants IA autorisés' );
	foreach ( briise_robots_recherche() as $robot ) {
		$lignes[] = 'User-agent: ' . $robot;
	}
	$lignes[] = 'Allow: /';
	$lignes[] = 'Disallow: /wp-admin/';
	$lignes[] = 'Allow: /wp-admin/admin-ajax.php';
	if ( ! briise_fonction( 'ia_entrainement' ) ) {
		$lignes[] = '';
		$lignes[] = '# Briise : entraînement des IA refusé (Mon entreprise > Fonctions)';
		foreach ( briise_robots_entrainement() as $robot ) {
			$lignes[] = 'User-agent: ' . $robot;
		}
		$lignes[] = 'Disallow: /';
	}
	return $sortie . implode( "\n", $lignes ) . "\n";
}, 20, 2 );

/* ----- Validation Bing ---------------------------------------------------------- */

add_action( 'wp_head', function () {
	$f = briise_reglage( 'briise_fonctions' );
	if ( $f['bing'] && is_front_page() ) {
		printf( "<meta name=\"msvalidate.01\" content=\"%s\" />\n", esc_attr( $f['bing'] ) );
	}
}, 3 );

/* ----- IndexNow ------------------------------------------------------------------- */

function briise_indexnow_cle() {
	$cle = get_option( 'briise_indexnow_cle' );
	if ( ! $cle ) {
		$cle = wp_generate_password( 32, false, false );
		$cle = strtolower( preg_replace( '/[^a-zA-Z0-9]/', '', $cle ) );
		update_option( 'briise_indexnow_cle', $cle, false );
	}
	return $cle;
}

function briise_indexnow_actif() {
	$hote = wp_parse_url( home_url(), PHP_URL_HOST );
	$local = in_array( $hote, array( 'localhost', '127.0.0.1' ), true ) || preg_match( '/\.(local|test|localhost)$/', (string) $hote );
	return briise_fonction( 'indexnow' ) && get_option( 'blog_public' ) && ! $local && 'production' === wp_get_environment_type();
}

// Le fichier de clé, à la racine du site : https://exemple.fr/<clé>.txt
add_action( 'parse_request', function () {
	if ( ! briise_fonction( 'indexnow' ) ) {
		return;
	}
	$chemin = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$cle    = get_option( 'briise_indexnow_cle' );
	if ( $cle && $chemin === $cle . '.txt' ) {
		header( 'Content-Type: text/plain; charset=utf-8' );
		echo esc_html( $cle );
		exit;
	}
}, 0 );

/**
 * Signale une adresse publiée ou modifiée. Envoi non bloquant : l'éditeur n'attend pas.
 */
function briise_indexnow_signaler( $url ) {
	if ( ! briise_indexnow_actif() ) {
		return;
	}
	$cle = briise_indexnow_cle();
	wp_remote_get(
		add_query_arg( array( 'url' => rawurlencode( $url ), 'key' => $cle, 'keyLocation' => rawurlencode( home_url( '/' . $cle . '.txt' ) ) ), 'https://api.indexnow.org/indexnow' ),
		array( 'blocking' => false, 'timeout' => 2 )
	);
}

add_action( 'transition_post_status', function ( $nouveau, $ancien, $post ) {
	if ( 'publish' !== $nouveau || ! in_array( $post->post_type, array( 'page', 'post' ), true ) || wp_is_post_revision( $post ) ) {
		return;
	}
	if ( function_exists( 'briise_est_noindex' ) && briise_est_noindex( $post ) ) {
		return;
	}
	// Une seule fois par requête et par page (l'éditeur enregistre parfois deux fois).
	static $faits = array();
	if ( isset( $faits[ $post->ID ] ) ) {
		return;
	}
	$faits[ $post->ID ] = true;
	briise_indexnow_signaler( get_permalink( $post ) );
}, 20, 3 );
