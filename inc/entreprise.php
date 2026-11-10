<?php
/**
 * Informations de l'entreprise, utilisées par le pied de page, le bouton fixe
 * et les données structurées.
 *
 * Phase 1 : valeurs dans ce fichier. Phase 2 : remplacées par une page
 * « Réglages de l'entreprise » dans l'administration.
 * À tenir identiques à la fiche Google Business Profile, au caractère près.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_entreprise() {
	$defaults = array(
		'name'         => get_bloginfo( 'name' ),
		'description'  => get_bloginfo( 'description' ),
		'type'         => 'LocalBusiness', // Ex. : Attorney, Dentist, Restaurant, HomeAndConstructionBusiness, ExerciseGym.
		'person_name'  => '',               // Dirigeant ou praticien, si l'activité repose sur une personne.
		'person_job'   => '',
		'person_page'  => '',               // Slug de la page « À propos » consacrée à cette personne.
		'faq_page'     => 'faq',            // Slug de la page FAQ (données FAQPage).
		'email'        => get_option( 'admin_email' ),
		'telephone'    => '',               // Format international : +33600000000.
		'street'       => '',
		'postal_code'  => '',
		'city'         => '',
		'country'      => 'FR',
		'latitude'     => '',
		'longitude'    => '',
		'price_range'  => '',
		'same_as'      => array(),           // Liens des réseaux sociaux.
		'areas'        => array(),           // Villes ou zones desservies.
		'cta_label'    => 'Nous contacter',
		'cta_slug'     => 'contact',
	);
	return apply_filters( 'briise_entreprise', $defaults );
}

/**
 * Téléphone lisible : +33612345678 devient 06 12 34 56 78.
 */
function briise_telephone_lisible( $tel ) {
	$digits = preg_replace( '/[^\d+]/', '', (string) $tel );
	if ( 0 === strpos( $digits, '+33' ) ) {
		$digits = '0' . substr( $digits, 3 );
	}
	if ( preg_match( '/^0\d{9}$/', $digits ) ) {
		return trim( chunk_split( $digits, 2, ' ' ) );
	}
	return (string) $tel;
}
