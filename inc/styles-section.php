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
