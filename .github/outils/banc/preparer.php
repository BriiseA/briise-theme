<?php
// Installe WordPress, active le thème et les extensions, crée un compte Éditeur.
define( 'WP_INSTALLING', true );
require __DIR__ . '/commun.php';
require_once ABSPATH . 'wp-admin/includes/upgrade.php';

$url = getenv( 'BANC_URL' );
if ( ! is_blog_installed() ) {
	wp_install( 'Banc Briise', 'briise', 'banc@briise.test', true, '', 'banc-briise' );
}
update_option( 'siteurl', $url );
update_option( 'home', $url );
update_option( 'permalink_structure', '/%postname%/' );
update_option( 'WPLANG', '' );
switch_theme( 'briise' );

wp_set_current_user( 1 );
foreach ( array( 'briise-socle/briise-socle.php', 'fluentform/fluentform.php', 'fluent-smtp/fluent-smtp.php' ) as $ext ) {
	$r = activate_plugin( $ext );
	echo '  ' . $ext . ' : ' . ( is_wp_error( $r ) ? 'ÉCHEC ' . $r->get_error_message() : 'activée' ) . "\n";
	if ( is_wp_error( $r ) ) {
		exit( 1 );
	}
}
if ( ! get_user_by( 'login', 'editeur' ) ) {
	wp_insert_user( array( 'user_login' => 'editeur', 'user_pass' => 'banc-editeur', 'role' => 'editor', 'user_email' => 'editeur@briise.test' ) );
}
foreach ( get_posts( array( 'post_type' => array( 'post', 'page' ), 'post_status' => 'any', 'numberposts' => -1 ) ) as $p ) {
	wp_delete_post( $p->ID, true ); // Contenu d'exemple de WordPress.
}
echo '  thème : ' . get_stylesheet() . "\n";
