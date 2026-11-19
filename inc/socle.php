<?php
/**
 * Lien avec l'extension Briise Socle.
 *
 * Les gabarits du thème lisent les informations de l'entreprise par ces fonctions :
 * avec l'extension, elles renvoient ses données ; sans elle, des valeurs vides,
 * pour que le site s'affiche sans erreur. L'administrateur est alors prévenu.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_socle_actif() {
	return defined( 'BRIISE_SOCLE_VERSION' );
}

function briise_theme_entreprise() {
	if ( function_exists( 'briise_entreprise' ) ) {
		return briise_entreprise();
	}
	return array_merge(
		array_fill_keys( array( 'legal_name', 'description', 'type', 'email', 'telephone', 'street', 'postal_code', 'city', 'country', 'latitude', 'longitude', 'price_range', 'areas', 'person_name', 'person_job' ), '' ),
		array(
			'name'      => get_bloginfo( 'name' ),
			'slogan'    => get_bloginfo( 'description' ),
			'reseaux'   => array(),
			'same_as'   => array(),
			'cta_label' => 'Nous contacter',
			'cta_url'   => home_url( '/' ),
			'person_id' => 0,
			'faq_id'    => 0,
		)
	);
}

function briise_theme_fonction( $cle ) {
	return function_exists( 'briise_fonction' ) ? briise_fonction( $cle ) : false;
}

function briise_theme_telephone( $tel ) {
	return function_exists( 'briise_telephone_lisible' ) ? briise_telephone_lisible( $tel ) : (string) $tel;
}

function briise_theme_coordonnees_html() {
	return function_exists( 'briise_coordonnees_html' ) ? briise_coordonnees_html() : '';
}

function briise_theme_horaires_html( $args = array() ) {
	return function_exists( 'briise_horaires_html' ) ? briise_horaires_html( $args ) : '';
}

function briise_theme_reseaux_html() {
	return function_exists( 'briise_reseaux_html' ) ? briise_reseaux_html() : '';
}

function briise_theme_credit_html() {
	return function_exists( 'briise_credit_html' ) ? briise_credit_html() : '';
}

add_action( 'admin_notices', function () {
	if ( briise_socle_actif() || ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-error"><p><strong>Thème Briise :</strong> l’extension <strong>Briise Socle</strong> n’est pas active. Sans elle, « Mon entreprise », les coordonnées, les horaires et le référencement ne fonctionnent pas. Installez <code>briise-socle.zip</code> (Extensions > Ajouter > Téléverser), puis activez-la.</p></div>';
} );

/**
 * Pages de service pour le pied de page : les sous-pages de la page qui en a le plus
 * (page des services, des ouvrages…), 6 au plus. Les pages hors de Google sont exclues.
 */
function briise_theme_pages_services() {
	static $res = null;
	if ( null !== $res ) {
		return $res;
	}
	$res     = array();
	$enfants = get_pages( array( 'post_status' => 'publish', 'sort_column' => 'menu_order,post_title', 'hierarchical' => 0 ) );
	$parents = array();
	foreach ( $enfants as $p ) {
		if ( $p->post_parent && ! get_post_meta( $p->ID, '_briise_noindex', true ) ) {
			$parents[ $p->post_parent ][] = $p->ID;
		}
	}
	if ( ! $parents ) {
		return $res;
	}
	uasort( $parents, function ( $a, $b ) {
		return count( $b ) - count( $a );
	} );
	$parent = (int) array_key_first( $parents );
	if ( count( $parents[ $parent ] ) < 2 ) {
		return $res;
	}
	$res = array(
		'titre' => get_the_title( $parent ),
		'pages' => array_slice( $parents[ $parent ], 0, 6 ),
	);
	return $res;
}

