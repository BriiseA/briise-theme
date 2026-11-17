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

// La fiche d'Angerville est volontairement trop courte : le Contrôle doit la repérer, et elle seule.
$minces = function_exists( 'briise_realisations_minces' ) ? briise_realisations_minces() : array();
$ok( 1 === count( $minces ), 'fiches trop courtes repérées : 1 attendue (Angerville), ' . count( $minces ) . ' trouvée(s)' );

// Formulaires.
$ok( briise_fluentforms_actif() && briise_formulaire_id( 'devis' ) > 0, 'formulaire de devis créé à l’import' );

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

// Adresses à tester.
$urls = array();
foreach ( get_posts( array( 'post_type' => array( 'page', 'briise_realisation' ), 'numberposts' => -1 ) ) as $p ) {
	$urls[] = get_permalink( $p );
}
file_put_contents( $sortie . '/adresses.txt', implode( "\n", $urls ) . "\n" );
fwrite( STDERR, '  ' . count( $urls ) . " adresses à tester\n" );

echo wp_json_encode( array( 'echecs' => $echecs ) );
exit( $echecs ? 1 : 0 );
