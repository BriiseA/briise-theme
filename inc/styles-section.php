<?php
/**
 * Styles de section en un clic (onglet Styles d'une section dans l'éditeur).
 *
 * Chaque style règle le fond, le texte, les liens et les boutons ensemble, avec les couleurs
 * de l'ambiance : le résultat reste lisible quelle que soit la charte. Le CSS est dans theme.json.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Style => couleur de fond équivalente (utilisée par le contrôle du rythme des couleurs).
 */
function briise_styles_section() {
	return array(
		'br-clair'  => array( 'Fond clair', 'fond' ),
		'br-teinte' => array( 'Fond teinté', 'surface' ),
		'br-nuance' => array( 'Fond nuancé', 'nuance' ),
		'br-fonce'  => array( 'Fond foncé', 'secondaire' ),
	);
}

add_action( 'init', function () {
	foreach ( briise_styles_section() as $nom => $s ) {
		register_block_style( 'core/group', array( 'name' => $nom, 'label' => $s[0] ) );
	}
} );

/**
 * Fond effectif d'un bloc de premier niveau : style de section, sinon couleur choisie, sinon fond.
 */
function briise_fond_effectif( $bloc ) {
	if ( 'core/cover' === $bloc['blockName'] ) {
		return 'photo';
	}
	if ( preg_match( '/is-style-(br-[a-z]+)/', $bloc['attrs']['className'] ?? '', $m ) && isset( briise_styles_section()[ $m[1] ] ) ) {
		return briise_styles_section()[ $m[1] ][1];
	}
	if ( ! empty( $bloc['attrs']['backgroundColor'] ) ) {
		return $bloc['attrs']['backgroundColor'];
	}
	return empty( $bloc['attrs']['style']['color']['background'] ) ? 'fond' : 'perso';
}

/**
 * Rythme des couleurs : deux sections voisines d'une page ne doivent pas avoir le même fond clair
 * (une tête de page peut précéder une section du même fond). Retourne [ [page, titre 1, titre 2, fond] ].
 */
function briise_rythme_analyse() {
	$clairs = array( 'fond', 'surface', 'nuance', 'clair', 'secondaire', 'sombre', 'accent' ); // Deux fonds foncés identiques se confondent aussi.
	$titre  = function ( $b ) {
		if ( preg_match( '/<h[1-3][^>]*>(.*?)<\/h[1-3]>/s', serialize_block( $b ), $m ) ) {
			return wp_trim_words( wp_strip_all_tags( $m[1] ), 8, '…' );
		}
		return 'section sans titre';
	};
	$res = array();
	foreach ( get_posts( array( 'post_type' => 'page', 'post_status' => array( 'publish', 'draft' ), 'posts_per_page' => 500, 'no_found_rows' => true ) ) as $p ) {
		if ( function_exists( 'briise_est_page_legale' ) && briise_est_page_legale( $p ) ) {
			continue;
		}
		$prev = null;
		foreach ( parse_blocks( $p->post_content ) as $b ) {
			if ( ! $b['blockName'] ) {
				continue; // Espaces entre deux blocs.
			}
			// Seules les sections comptent (groupes et bannières), pas un paragraphe posé seul.
			if ( ! in_array( $b['blockName'], array( 'core/group', 'core/cover' ), true ) ) {
				$prev = null;
				continue;
			}
			$fond = briise_fond_effectif( $b );
			if ( $prev && $prev[1] === $fond && in_array( $fond, $clairs, true ) && false === strpos( $prev[0]['attrs']['className'] ?? '', 'br-page-head' ) ) {
				$res[] = array( $p, $titre( $prev[0] ), $titre( $b ), $fond );
			}
			$prev = array( $b, $fond );
		}
	}
	return $res;
}
