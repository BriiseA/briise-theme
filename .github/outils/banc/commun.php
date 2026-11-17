<?php
// Charge le WordPress de test en ligne de commande.
$_SERVER['HTTP_HOST']   = 'localhost:' . getenv( 'BANC_PORT' );
$_SERVER['REQUEST_URI'] = '/';
if ( ! defined( 'WP_USE_THEMES' ) ) {
	define( 'WP_USE_THEMES', false );
}
require getenv( 'BANC_WP' ) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';
