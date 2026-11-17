<?php
/**
 * Photos légères : chaque photo JPEG ou PNG envoyée dans la médiathèque est enregistrée en WebP
 * (2 à 3 fois plus légère, même qualité à l'œil), avant que WordPress ne crée ses tailles.
 * WordPress réduit déjà toute photo de plus de 2 560 px de large ; on garde ce réglage.
 *
 * Désactivable dans Mon entreprise > Fonctions > Photos en WebP. Sans effet si le serveur
 * ne sait pas écrire le WebP (la photo est alors gardée telle quelle).
 *
 * @package Briise_Socle
 */

defined( 'ABSPATH' ) || exit;

/**
 * Convertit un fichier envoyé en WebP. Retourne le tableau d'envoi mis à jour, ou tel quel.
 */
function briise_photo_en_webp( $envoi ) {
	if ( ! briise_fonction( 'photos_webp' ) || ! empty( $envoi['error'] ) ) {
		return $envoi;
	}
	if ( ! in_array( $envoi['type'] ?? '', array( 'image/jpeg', 'image/png' ), true ) ) {
		return $envoi;
	}
	$editeur = wp_get_image_editor( $envoi['file'] );
	if ( is_wp_error( $editeur ) || ! $editeur->supports_mime_type( 'image/webp' ) ) {
		return $envoi;
	}
	$editeur->set_quality( 82 );
	$cible = preg_replace( '/\.(jpe?g|png)$/i', '', $envoi['file'] ) . '.webp';
	$cible = wp_unique_filename( dirname( $cible ), basename( $cible ) );
	$cible = dirname( $envoi['file'] ) . '/' . $cible;
	$fait  = $editeur->save( $cible, 'image/webp' );
	if ( is_wp_error( $fait ) || empty( $fait['path'] ) || ! file_exists( $fait['path'] ) ) {
		return $envoi;
	}
	// Garder l'original seulement si le WebP n'est pas plus léger (rare : petits PNG très simples).
	if ( filesize( $fait['path'] ) >= filesize( $envoi['file'] ) ) {
		wp_delete_file( $fait['path'] );
		return $envoi;
	}
	wp_delete_file( $envoi['file'] );
	$envoi['file'] = $fait['path'];
	$envoi['url']  = trailingslashit( dirname( $envoi['url'] ) ) . basename( $fait['path'] );
	$envoi['type'] = 'image/webp';
	return $envoi;
}
add_filter( 'wp_handle_upload', 'briise_photo_en_webp', 5 );
