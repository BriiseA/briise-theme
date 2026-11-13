<?php
/**
 * Vitesse d'affichage.
 *
 * Précharge les deux polices de l'ambiance active (titres et texte) : le navigateur les
 * télécharge dès le début de la page au lieu de les découvrir dans la feuille de style.
 * Le grand titre s'affiche donc d'emblée dans sa police, sans changer de hauteur ni
 * pousser le texte qui suit (décalage de mise en page, CLS).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fichiers de police à précharger : un pour les titres (graisse des titres), un pour le texte.
 */
function briise_polices_a_precharger() {
	$familles = wp_get_global_settings( array( 'typography', 'fontFamilies' ) );
	$liste    = array();
	foreach ( array( 'custom', 'theme' ) as $origine ) {
		foreach ( (array) ( $familles[ $origine ] ?? array() ) as $f ) {
			if ( ! empty( $f['slug'] ) && ! isset( $liste[ $f['slug'] ] ) ) {
				$liste[ $f['slug'] ] = $f;
			}
		}
	}
	$graisse = (int) ( wp_get_global_styles( array( 'elements', 'heading', 'typography', 'fontWeight' ) ) ?: 600 );
	$voulu   = array( 'titres' => $graisse, 'texte' => 400 );
	$urls    = array();
	foreach ( $voulu as $slug => $poids ) {
		$choix = null;
		foreach ( (array) ( $liste[ $slug ]['fontFace'] ?? array() ) as $face ) {
			if ( 'normal' !== ( $face['fontStyle'] ?? 'normal' ) ) {
				continue;
			}
			$w = array_map( 'intval', preg_split( '/\s+/', trim( (string) ( $face['fontWeight'] ?? '400' ) ) ) );
			$ok = count( $w ) > 1 ? ( $poids >= $w[0] && $poids <= $w[1] ) : ( $poids === $w[0] );
			if ( $ok || ! $choix ) {
				$choix = $face;
				if ( $ok ) {
					break;
				}
			}
		}
		$src = $choix ? ( is_array( $choix['src'] ) ? $choix['src'][0] : $choix['src'] ) : '';
		if ( $src && str_ends_with( $src, '.woff2' ) ) {
			$urls[] = 0 === strpos( $src, 'file:./' ) ? get_theme_file_uri( substr( $src, 7 ) ) : $src;
		}
	}
	return array_unique( $urls );
}

add_action( 'wp_head', function () {
	foreach ( briise_polices_a_precharger() as $url ) {
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( $url ) );
	}
}, 1 );
