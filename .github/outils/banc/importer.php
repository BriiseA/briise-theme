<?php
// Importe un fichier de site comme le fait Mon entreprise > Démarrage.
require __DIR__ . '/commun.php';
wp_set_current_user( 1 );
wp_get_theme()->delete_pattern_cache();
flush_rewrite_rules();
$plan = briise_plan_depuis_fichier( file_get_contents( $argv[1] ) );
if ( is_wp_error( $plan ) ) {
	echo '  ÉCHEC : ' . $plan->get_error_message() . "\n";
	exit( 1 );
}
$r = briise_plan_installer( $plan );
flush_rewrite_rules();
$pages = get_posts( array( 'post_type' => 'page', 'post_status' => array( 'publish', 'draft' ), 'numberposts' => -1 ) );
$fiches = get_posts( array( 'post_type' => 'briise_realisation', 'post_status' => array( 'publish', 'draft' ), 'numberposts' => -1 ) );
echo '  ' . count( $pages ) . ' pages, ' . count( $fiches ) . " fiches de réalisation\n";
// Le site de test est publié pour que les pages soient visibles.
foreach ( array_merge( $pages, $fiches ) as $p ) {
	if ( 'publish' !== $p->post_status ) {
		wp_update_post( array( 'ID' => $p->ID, 'post_status' => 'publish' ) );
	}
}
