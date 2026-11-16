<?php
/**
 * Mises à jour depuis les versions publiées sur GitHub (onglet « Releases » du dépôt).
 *
 * Une version publiée contient deux fichiers : briise.zip (le thème) et briise-socle.zip
 * (cette extension). WordPress les propose ensuite dans Tableau de bord > Mises à jour,
 * comme n'importe quelle extension, et chaque site se met à jour en un clic.
 *
 * Dépôt privé : définir dans wp-config.php une clé GitHub en lecture seule,
 *   define( 'BRIISE_GITHUB_TOKEN', '...' );
 * Dépôt public : rien à faire.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'BRIISE_DEPOT' ) ) {
	define( 'BRIISE_DEPOT', 'BriiseA/briise-theme' );
}

/**
 * Dernière version publiée, gardée 6 heures en cache.
 * Retourne array( version, page, notes, fichiers => [ nom => adresse ] ) ou null.
 */
function briise_derniere_version( $forcer = false ) {
	$cache = get_site_transient( 'briise_derniere_version' );
	if ( ! $forcer && is_array( $cache ) ) {
		return $cache['version'] ? $cache : null;
	}
	$args = array(
		'timeout' => 10,
		'headers' => array( 'Accept' => 'application/vnd.github+json' ),
	);
	if ( defined( 'BRIISE_GITHUB_TOKEN' ) && BRIISE_GITHUB_TOKEN ) {
		$args['headers']['Authorization'] = 'Bearer ' . BRIISE_GITHUB_TOKEN;
	}
	$rep  = wp_remote_get( 'https://api.github.com/repos/' . BRIISE_DEPOT . '/releases/latest', $args );
	$data = is_wp_error( $rep ) ? null : json_decode( wp_remote_retrieve_body( $rep ), true );
	$info = array( 'version' => '', 'page' => '', 'notes' => '', 'fichiers' => array() );
	if ( 200 === (int) wp_remote_retrieve_response_code( $rep ) && ! empty( $data['tag_name'] ) ) {
		$info['version'] = ltrim( $data['tag_name'], 'vV' );
		$info['page']    = $data['html_url'] ?? '';
		$info['notes']   = $data['body'] ?? '';
		foreach ( (array) ( $data['assets'] ?? array() ) as $a ) {
			// Dépôt privé : le fichier se télécharge par l'API, avec la clé (voir plus bas).
			$info['fichiers'][ $a['name'] ] = ( defined( 'BRIISE_GITHUB_TOKEN' ) && BRIISE_GITHUB_TOKEN ) ? $a['url'] : $a['browser_download_url'];
		}
	}
	// Un échec est aussi gardé en cache (1 heure) pour ne pas ralentir l'administration.
	set_site_transient( 'briise_derniere_version', $info, $info['version'] ? 6 * HOUR_IN_SECONDS : HOUR_IN_SECONDS );
	return $info['version'] ? $info : null;
}

/* ----- Extension ----------------------------------------------------------------- */

add_filter( 'pre_set_site_transient_update_plugins', function ( $transient ) {
	if ( ! is_object( $transient ) ) {
		return $transient;
	}
	$base = plugin_basename( BRIISE_SOCLE_DIR . 'briise-socle.php' );
	$v    = briise_derniere_version();
	$item = (object) array(
		'id'          => 'briise-socle',
		'slug'        => 'briise-socle',
		'plugin'      => $base,
		'new_version' => BRIISE_SOCLE_VERSION,
		'url'         => 'https://github.com/' . BRIISE_DEPOT,
		'package'     => '',
	);
	if ( $v && ! empty( $v['fichiers']['briise-socle.zip'] ) && version_compare( $v['version'], BRIISE_SOCLE_VERSION, '>' ) ) {
		$item->new_version         = $v['version'];
		$item->package             = $v['fichiers']['briise-socle.zip'];
		$transient->response[ $base ] = $item;
		unset( $transient->no_update[ $base ] );
	} else {
		$transient->no_update[ $base ] = $item;
	}
	return $transient;
} );

// Fenêtre « Voir les détails de la version ».
add_filter( 'plugins_api', function ( $res, $action, $args ) {
	if ( 'plugin_information' !== $action || 'briise-socle' !== ( $args->slug ?? '' ) ) {
		return $res;
	}
	$v = briise_derniere_version();
	return (object) array(
		'name'          => 'Briise Socle',
		'slug'          => 'briise-socle',
		'version'       => $v ? $v['version'] : BRIISE_SOCLE_VERSION,
		'author'        => 'Briise',
		'homepage'      => 'https://github.com/' . BRIISE_DEPOT,
		'download_link' => $v['fichiers']['briise-socle.zip'] ?? '',
		'sections'      => array(
			'changelog' => $v && $v['notes'] ? wpautop( esc_html( $v['notes'] ) ) : 'Détail des changements : fichier CHANGELOG.md du dépôt.',
		),
	);
}, 10, 3 );

/* ----- Thème ---------------------------------------------------------------------- */

add_filter( 'pre_set_site_transient_update_themes', function ( $transient ) {
	if ( ! is_object( $transient ) ) {
		return $transient;
	}
	$theme = wp_get_theme( 'briise' );
	if ( ! $theme->exists() ) {
		return $transient;
	}
	$v = briise_derniere_version();
	if ( $v && ! empty( $v['fichiers']['briise.zip'] ) && version_compare( $v['version'], $theme->get( 'Version' ), '>' ) ) {
		$transient->response['briise'] = array(
			'theme'       => 'briise',
			'new_version' => $v['version'],
			'url'         => $v['page'] ? $v['page'] : 'https://github.com/' . BRIISE_DEPOT,
			'package'     => $v['fichiers']['briise.zip'],
		);
		unset( $transient->no_update['briise'] );
	}
	return $transient;
} );

/* ----- Dépôt privé : téléchargement avec la clé ------------------------------------ */

add_filter( 'http_request_args', function ( $args, $url ) {
	if ( defined( 'BRIISE_GITHUB_TOKEN' ) && BRIISE_GITHUB_TOKEN && 0 === strpos( $url, 'https://api.github.com/repos/' . BRIISE_DEPOT . '/releases/assets/' ) ) {
		$args['headers']['Authorization'] = 'Bearer ' . BRIISE_GITHUB_TOKEN;
		$args['headers']['Accept']        = 'application/octet-stream';
	}
	return $args;
}, 10, 2 );

// Après une mise à jour, la prochaine vérification repart de zéro.
add_action( 'upgrader_process_complete', function () {
	delete_site_transient( 'briise_derniere_version' );
} );
