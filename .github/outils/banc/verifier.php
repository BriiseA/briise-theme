<?php
// Vérifications côté WordPress. Affiche les résultats, écrit la liste des adresses à tester
// dans sortie/adresses.txt, et sort en erreur si quelque chose ne va pas.
require __DIR__ . '/commun.php';
$sortie = getenv( 'BANC_SORTIE' );
$echecs = array();
$ok     = function ( $cond, $msg ) use ( &$echecs ) {
	fwrite( STDERR, '  ' . ( $cond ? 'ok    ' : 'ÉCHEC ' ) . $msg . "\n" );
	if ( ! $cond ) {
		$echecs[] = $msg;
	}
};

// Maillage et couleurs (onglet Contrôle).
$a = briise_maillage_analyse();
$faibles = array();
foreach ( $a['pages'] as $l ) {
	if ( ! $l['accueil'] && ( $l['recus'] < 2 || null === $l['prof'] || $l['prof'] > 3 ) ) {
		$faibles[] = get_the_title( $l['post'] );
	}
}
$ok( ! $faibles, 'maillage : chaque page reçoit 2 liens et reste à 3 clics' . ( $faibles ? ' (' . implode( ', ', $faibles ) . ')' : '' ) );
$ok( ! $a['casses'], 'aucun lien cassé' );
$ok( ! $a['exclues'], 'aucun lien vers une page exclue de Google' );
$ok( ! $a['flous'], 'aucun texte de lien vague' );
$ok( function_exists( 'briise_rythme_analyse' ) && ! briise_rythme_analyse(), 'couleurs : jamais deux sections voisines du même fond' );

// Fiches de réalisation : celles du site sont assez longues ; une fiche volontairement courte, ajoutée
// pour l'essai, doit être repérée par le Contrôle, et elle seule.
$minces = function_exists( 'briise_realisations_minces' ) ? briise_realisations_minces() : array();
$ok( ! $minces, 'fiches du site assez longues (' . count( $minces ) . ' trop courte(s))' );
if ( function_exists( 'briise_realisations_minces' ) && defined( 'BRIISE_REALISATION' ) ) {
	$courte = wp_insert_post( array( 'post_type' => BRIISE_REALISATION, 'post_status' => 'publish', 'post_title' => 'Fiche d’essai trop courte', 'post_content' => '<!-- wp:paragraph --><p>Trois mots seulement.</p><!-- /wp:paragraph -->' ) );
	$ok( array( $courte ) === briise_realisations_minces(), 'fiche trop courte repérée par le Contrôle, et elle seule' );
	wp_delete_post( $courte, true );
}

// Formulaires.
$ok( briise_fluentforms_actif() && briise_formulaire_id( 'reservation' ) > 0, 'formulaire de réservation créé à l’import' );

// Couleurs du client appliquées depuis le fichier de site, contraste AA.
$palette = array();
foreach ( (array) ( wp_get_global_settings( array( 'color', 'palette' ) )['theme'] ?? array() ) as $c ) {
	$palette[ $c['slug'] ] = $c['color'];
}
// Réglages de style du fichier de site (clé « styles »), lus dans les styles globaux enregistrés.
$globaux = WP_Theme_JSON_Resolver::get_user_data_from_wp_global_styles( wp_get_theme() );
$globaux = json_decode( (string) ( $globaux['post_content'] ?? '' ), true );
$ok( 'var:preset|color|accent' === ( $globaux['styles']['elements']['button']['color']['background'] ?? '' ) && '12px' === ( $globaux['settings']['custom']['rayon']['petit'] ?? '' ), 'réglages de style du fichier de site appliqués (boutons, arrondis)' );
$ok( '#b0285f' === ( $palette['accent'] ?? '' ), 'couleurs du fichier de site appliquées (accent ' . ( $palette['accent'] ?? 'absent' ) . ')' );
require_once get_theme_file_path( 'inc/contraste.php' );
$ok( ! briise_contrastes_insuffisants(), 'couleurs du site : contraste AA' );

// Gabarits : une page qui commence par un en-tête du thème n'affiche pas un second titre.
$mauvais = array();
foreach ( get_posts( array( 'post_type' => 'page', 'numberposts' => -1 ) ) as $p ) {
	if ( preg_match( '/^\s*<!-- wp:(group|cover) \{[^\n]*"className":"[^"]*\b(br-page-head|br-banniere|br-hero|br-tete)\b/', $p->post_content ) && 'page-sans-titre' !== get_page_template_slug( $p ) ) {
		$mauvais[] = $p->post_name;
	}
}
$ok( ! $mauvais, 'gabarit sans titre sur les pages à en-tête' . ( $mauvais ? ' (' . implode( ', ', $mauvais ) . ')' : '' ) );

// Sécurité.
$ok( briise_fonction( 'securite' ) && defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT, 'protections de sécurité actives' );

// Photos : une photo JPEG envoyée est enregistrée en WebP (si le serveur sait écrire le WebP).
if ( function_exists( 'imagewebp' ) ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_set_current_user( 1 );
	$img = imagecreatetruecolor( 1600, 900 );
	for ( $x = 0; $x < 1600; $x += 40 ) {
		imagefilledrectangle( $img, $x, 0, $x + 20, 900, imagecolorallocate( $img, $x % 255, 120, 200 - $x % 200 ) );
	}
	$tmp = wp_tempnam( 'banc.jpg' );
	imagejpeg( $img, $tmp, 90 );
	$id = media_handle_sideload( array( 'name' => 'banc-photo.jpg', 'tmp_name' => $tmp ), 0 );
	$ok( ! is_wp_error( $id ) && 'image/webp' === get_post_mime_type( $id ), 'photo JPEG envoyée enregistrée en WebP' );
	if ( ! is_wp_error( $id ) ) {
		wp_delete_attachment( $id, true );
	}
}

// Adresses à tester.
$urls = array();
foreach ( get_posts( array( 'post_type' => array( 'page', 'briise_realisation' ), 'numberposts' => -1 ) ) as $p ) {
	$urls[] = get_permalink( $p );
}
file_put_contents( $sortie . '/adresses.txt', implode( "\n", $urls ) . "\n" );
fwrite( STDERR, '  ' . count( $urls ) . " adresses à tester\n" );

echo wp_json_encode( array( 'echecs' => $echecs ) );
exit( $echecs ? 1 : 0 );
