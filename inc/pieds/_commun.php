<?php
/**
 * Briques communes aux pieds de page (incluses par patterns/pied-de-page.php).
 * Variables disponibles : $e, $sur_cta, $horaires, $coord, $credit, $qualifs, $services, $zone, $tel, $tel_url, $legales.
 */
if ( ! function_exists( 'briise_pied_bas' ) ) {
	function briise_pied_bas( $e, $legales, $credit, $reseaux = '' ) {
		$droite = implode( ' · ', array_filter( array_merge( $legales, array( $credit ) ) ) );
		return '<div class="br-ft-bas"><p>© ' . esc_html( wp_date( 'Y' ) . ' ' . $e['name'] ) . '</p>' . ( $reseaux ? '<div class="br-ft-reseaux">' . $reseaux . '</div>' : '' ) . ( $droite ? '<p>' . wp_kses_post( $droite ) . '</p>' : '' ) . '</div>';
	}
	function briise_pied_liens( $services ) {
		if ( ! $services ) {
			return '';
		}
		$h = '<ul class="br-footer-liens">';
		foreach ( $services['pages'] as $sp ) {
			$h .= '<li><a href="' . esc_url( get_permalink( $sp ) ) . '">' . esc_html( get_the_title( $sp ) ) . '</a></li>';
		}
		return $h . '</ul>';
	}
	function briise_pied_cta( $e, $sur_cta, $classe = '' ) {
		if ( $sur_cta ) {
			return '';
		}
		return '<a class="wp-element-button br-ft-bouton ' . esc_attr( $classe ) . '" href="' . esc_url( $e['cta_url'] ) . '">' . esc_html( $e['cta_label'] ) . '</a>';
	}
}
