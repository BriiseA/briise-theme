<?php
/**
 * Vérification automatique des contrastes de la palette active.
 * Les couleurs de chaque variation sont validées AA ; mais l'administrateur
 * peut changer une couleur dans l'éditeur de site (couleur du logo du client).
 * Ce contrôle prévient alors, sur le tableau de bord, si un texte devient illisible.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_luminance( $hex ) {
	$hex = ltrim( (string) $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( ! preg_match( '/^[0-9a-f]{6}$/i', $hex ) ) {
		return null;
	}
	$l = array();
	foreach ( array( 0, 2, 4 ) as $i ) {
		$c   = hexdec( substr( $hex, $i, 2 ) ) / 255;
		$l[] = $c <= 0.03928 ? $c / 12.92 : pow( ( $c + 0.055 ) / 1.055, 2.4 );
	}
	return 0.2126 * $l[0] + 0.7152 * $l[1] + 0.0722 * $l[2];
}

function briise_contraste( $a, $b ) {
	$la = briise_luminance( $a );
	$lb = briise_luminance( $b );
	if ( null === $la || null === $lb ) {
		return null;
	}
	return ( max( $la, $lb ) + 0.05 ) / ( min( $la, $lb ) + 0.05 );
}

/**
 * Couples texte / fond réellement utilisés par le thème.
 * Retourne la liste des couples sous 4,5:1 (AA, texte courant).
 */
function briise_contrastes_insuffisants() {
	$palette = array();
	$global  = wp_get_global_settings( array( 'color', 'palette' ) );
	foreach ( array( 'theme', 'custom' ) as $origine ) {
		foreach ( (array) ( $global[ $origine ] ?? array() ) as $c ) {
			$palette[ $c['slug'] ] = $c['color'];
		}
	}
	$noms   = array();
	foreach ( (array) ( $global['theme'] ?? array() ) as $c ) {
		$noms[ $c['slug'] ] = $c['name'];
	}
	$couples = array(
		array( 'texte', 'fond' ), array( 'texte', 'clair' ), array( 'texte', 'surface' ), array( 'texte', 'nuance' ),
		array( 'texte-doux', 'fond' ), array( 'texte-doux', 'clair' ),
		array( 'accent', 'fond' ), array( 'accent', 'clair' ), array( 'fond', 'accent' ),
		array( 'fond', 'texte' ), array( 'fond', 'sombre' ), array( 'surface', 'sombre' ),
		array( 'fond', 'secondaire' ), array( 'secondaire', 'fond' ),
	);
	$echecs = array();
	foreach ( $couples as $c ) {
		if ( ! isset( $palette[ $c[0] ], $palette[ $c[1] ] ) ) {
			continue;
		}
		$r = briise_contraste( $palette[ $c[0] ], $palette[ $c[1] ] );
		if ( null !== $r && $r < 4.5 ) {
			$echecs[] = sprintf( '« %s » sur « %s » : %s:1', $noms[ $c[0] ] ?? $c[0], $noms[ $c[1] ] ?? $c[1], number_format_i18n( $r, 2 ) );
		}
	}
	return $echecs;
}

add_action( 'admin_notices', function () {
	$ecran = get_current_screen();
	if ( ! current_user_can( 'edit_theme_options' ) || ! $ecran || ! in_array( $ecran->id, array( 'dashboard', 'toplevel_page_briise-entreprise', 'themes' ), true ) ) {
		return;
	}
	$echecs = briise_contrastes_insuffisants();
	if ( ! $echecs ) {
		return;
	}
	echo '<div class="notice notice-warning"><p><strong>Couleurs du site : texte difficile à lire.</strong> Ces associations n’atteignent pas le contraste minimal de 4,5:1 (accessibilité AA). Foncez la couleur de texte ou éclaircissez le fond dans Apparence &gt; Éditeur &gt; Styles &gt; Couleurs.</p><ul style="list-style:disc;margin-left:1.5em">';
	foreach ( $echecs as $e ) {
		echo '<li>' . esc_html( $e ) . '</li>';
	}
	echo '</ul></div>';
} );
