<?php
/**
 * Familles de sections : un même contenu, plusieurs versions.
 *
 * Une famille est reconnue à une classe de la section (br-services). Sa version est une
 * seconde classe (br-services--bento), choisie dans l'éditeur (panneau « Version » de la
 * section, assets/js/familles-editeur.js) ou écrite dans le fichier de site.
 * Liste des familles, des versions et des positions de titre : inc/familles.json.
 * CSS : assets/css/familles.css. Comportements (onglets, flèches) : assets/js/familles.js.
 *
 * Toute section qui a un en-tête (titre) a aussi un panneau « Titre » : la position de son titre
 * (br-titre--centre…), qui passe devant le réglage général du site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Données des familles et des positions de titre (inc/familles.json), lues une fois. */
function briise_familles_donnees() {
	static $d = null;
	if ( null === $d ) {
		$d = json_decode( (string) file_get_contents( get_theme_file_path( 'inc/familles.json' ) ), true );
		$d = is_array( $d ) ? $d : array();
	}
	return $d;
}

/**
 * Les familles et leurs versions : clé => nom, classe, section, version par défaut,
 * versions (clé => libellé, aide).
 */
function briise_familles() {
	return (array) ( briise_familles_donnees()['familles'] ?? array() );
}

/**
 * Positions du titre d'une section (panneau « Titre » de l'éditeur) : clé => libellé, aide.
 * La classe posée sur la section est br-titre--<clé> ; « site » n'en pose aucune.
 */
function briise_titres_section() {
	return (array) ( briise_familles_donnees()['titres'] ?? array() );
}

// Sur le site : la feuille des familles et leurs comportements.
add_action( 'wp_enqueue_scripts', function () {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'briise-familles', get_theme_file_uri( 'assets/css/familles.css' ), array( 'briise-sections' ), $version );
	wp_style_add_data( 'briise-familles', 'path', get_theme_file_path( 'assets/css/familles.css' ) );
	wp_enqueue_script( 'briise-familles', get_theme_file_uri( 'assets/js/familles.js' ), array(), $version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}, 15 );

// Dans l'éditeur : le même rendu, et le panneau « Version ».
add_action( 'after_setup_theme', function () {
	add_editor_style( 'assets/css/familles.css' );
} );
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_script(
		'briise-familles-editeur',
		get_theme_file_uri( 'assets/js/familles-editeur.js' ),
		array( 'wp-hooks', 'wp-compose', 'wp-element', 'wp-data', 'wp-block-editor', 'wp-components' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_add_inline_script( 'briise-familles-editeur', 'window.briiseFamilles = ' . wp_json_encode( briise_familles() ) . '; window.briiseTitres = ' . wp_json_encode( briise_titres_section() ) . ';', 'before' );
} );

/**
 * Carte d'infos d'une ouverture : uniquement des données réelles de Mon entreprise.
 * « Ouvert aujourd'hui » est calculé dans le navigateur (ux.js), pour ne pas être figé par le
 * cache de page ; la prochaine date libre disparaît seule quand elle n'est plus à jour.
 * Sans aucune donnée, rien ne s'affiche.
 */
add_shortcode( 'briise_infos_ouverture', function () {
	$lignes = array();
	$json   = function_exists( 'briise_horaires_json' ) ? briise_horaires_json() : '';
	if ( $json ) {
		$lignes[] = '<li><span class="br-infos-jour" data-horaires="' . esc_attr( $json ) . '" hidden></span></li>';
	}
	$dispo = function_exists( 'briise_disponibilite_parties' ) ? briise_disponibilite_parties() : array();
	if ( $dispo ) {
		$lignes[] = '<li><span>' . esc_html( $dispo[0] ) . ' : <strong>' . esc_html( $dispo[1] ) . '</strong></span></li>';
	}
	$e     = function_exists( 'briise_theme_entreprise' ) ? briise_theme_entreprise() : array();
	$ville = trim( (string) ( $e['city'] ?? '' ) );
	if ( '' !== $ville ) {
		$lignes[] = '<li><span>Basé à <strong>' . esc_html( $ville ) . '</strong></span></li>';
	}
	return $lignes ? '<ul class="br-ouv-infos">' . implode( '', $lignes ) . '</ul>' : '';
} );
