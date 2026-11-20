<?php
/**
 * Qualifications et assurances (Qualibat, RGE, décennale…) : une ligne de logos
 * sous forme de section, une colonne dans le pied de page, et les données
 * transmises à Google. Une qualification dont la date de fin est passée
 * disparaît toute seule.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const BRIISE_QUALIFS_MAX = 6;

/**
 * Qualifications à afficher aujourd'hui (fonction active, nom renseigné, date valide).
 */
function briise_qualifications() {
	if ( ! briise_fonction( 'qualifications' ) ) {
		return array();
	}
	$e   = briise_reglage( 'briise_entreprise' );
	$auj = briise_aujourdhui();
	return array_values( array_filter( (array) ( $e['qualifications'] ?? array() ), function ( $q ) use ( $auj ) {
		return ! empty( $q['nom'] ) && ( empty( $q['fin'] ) || $q['fin'] >= $auj );
	} ) );
}

/**
 * Nettoyage des lignes saisies dans Mon entreprise ou importées.
 */
function briise_nettoie_qualifications( $in ) {
	$out = array();
	foreach ( array_slice( (array) $in, 0, BRIISE_QUALIFS_MAX ) as $q ) {
		if ( ! is_array( $q ) || '' === trim( (string) ( $q['nom'] ?? '' ) ) ) {
			continue;
		}
		$out[] = array(
			'nom'    => mb_substr( sanitize_text_field( $q['nom'] ), 0, 60 ),
			'detail' => mb_substr( sanitize_text_field( $q['detail'] ?? '' ), 0, 80 ),
			'numero' => mb_substr( sanitize_text_field( $q['numero'] ?? '' ), 0, 40 ),
			'fin'    => briise_nettoie_date( $q['fin'] ?? '' ),
			'lien'   => esc_url_raw( $q['lien'] ?? '' ),
			'logo'   => absint( $q['logo'] ?? 0 ),
		);
	}
	return $out;
}

function briise_qualif_logo( $q, $taille = 'medium' ) {
	if ( ! empty( $q['logo'] ) && wp_attachment_is_image( $q['logo'] ) ) {
		return wp_get_attachment_image( $q['logo'], $taille, false, array( 'class' => 'br-qualif-logo', 'alt' => '', 'loading' => 'lazy' ) );
	}
	// Sans logo : un écusson aux couleurs du site.
	return '<span class="br-qualif-logo br-qualif-logo--icone" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 8.2-7 10-4-1.8-7-5.5-7-10V6z"/><path d="M8.8 12.2l2.2 2.2 4.2-4.4"/></svg></span>';
}

function briise_qualif_verifier( $q, $texte = 'Vérifier' ) {
	if ( empty( $q['lien'] ) ) {
		return '';
	}
	return '<a class="br-qualif-verifier" href="' . esc_url( $q['lien'] ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( sprintf( 'Vérifier %s sur le site officiel (nouvelle fenêtre)', $q['nom'] ) ) . '">' . esc_html( $texte ) . '</a>';
}

/**
 * Ligne de qualifications (section « Qualifications »).
 */
function briise_qualifications_html( $atts = array() ) {
	$atts = shortcode_atts( array( 'titre' => 'Qualifié et assuré' ), $atts );
	$qs   = briise_qualifications();
	if ( ! $qs ) {
		if ( current_user_can( 'edit_pages' ) && ! is_admin() ) {
			return '<p class="br-muted">Qualifications : ajoutez-les dans Mon entreprise &gt; Entreprise &gt; Qualifications et assurances (fonction « Qualifications » active). Ce message n’est visible que par vous.</p>';
		}
		return '';
	}
	$h = '<div class="br-qualifs"><p class="br-qualifs-titre">' . esc_html( $atts['titre'] ) . '</p><ul class="br-qualifs-liste">';
	foreach ( $qs as $q ) {
		$detail = trim( $q['detail'] . ( $q['numero'] ? ( $q['detail'] ? ' · ' : '' ) . 'n° ' . $q['numero'] : '' ) );
		$h     .= '<li class="br-qualif">' . briise_qualif_logo( $q ) . '<span class="br-qualif-texte"><strong>' . esc_html( $q['nom'] ) . '</strong>';
		$h     .= $detail ? '<span>' . esc_html( $detail ) . '</span>' : '';
		$h     .= briise_qualif_verifier( $q ) . '</span></li>';
	}
	return $h . '</ul></div>';
}

/**
 * Colonne du pied de page (si cochée dans Mon entreprise).
 */
function briise_qualifications_pied_html() {
	$e  = briise_reglage( 'briise_entreprise' );
	$qs = briise_qualifications();
	if ( ! $qs || empty( $e['qualifs_pied'] ) ) {
		return '';
	}
	$h = '<div class="br-footer-qualifs"><p class="br-label">Qualifications</p><ul>';
	foreach ( $qs as $q ) {
		$nom = esc_html( $q['nom'] );
		$h  .= '<li>' . briise_qualif_logo( $q, 'thumbnail' ) . '<span>' . ( $q['lien'] ? '<a href="' . esc_url( $q['lien'] ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( sprintf( 'Vérifier %s sur le site officiel (nouvelle fenêtre)', $q['nom'] ) ) . '">' . $nom . '</a>' : $nom ) . '</span></li>';
	}
	return $h . '</ul></div>';
}

add_action( 'init', function () {
	add_shortcode( 'briise_qualifications', 'briise_qualifications_html' );
} );

/**
 * Données structurées : les qualifications en cours, sur la fiche de l'entreprise.
 */
add_filter( 'briise_schema_entreprise', function ( $data ) {
	$qs = briise_qualifications();
	if ( $qs ) {
		$data['hasCredential'] = array_map( function ( $q ) {
			return array_filter( array(
				'@type'              => 'EducationalOccupationalCredential',
				'name'               => $q['nom'],
				'credentialCategory' => 'Qualification professionnelle',
				'identifier'         => $q['numero'],
				'url'                => $q['lien'],
				'expires'            => $q['fin'],
			) );
		}, $qs );
	}
	return $data;
} );
