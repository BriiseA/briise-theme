<?php
/**
 * Fonctions activables (onglet « Fonctions ») : bandeau d'information,
 * blog, mesure d'audience. Les autres sont branchées dans functions.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ----- Bandeau d'information ------------------------------------------------ */

/**
 * Messages à afficher aujourd'hui : le bandeau saisi, puis les fermetures
 * exceptionnelles qui commencent dans 7 jours ou moins.
 */
function briise_bandeau_messages() {
	if ( ! briise_fonction( 'bandeau' ) ) {
		return array();
	}
	$a    = briise_reglage( 'briise_annonces' );
	$auj  = briise_aujourdhui();
	$msgs = array();
	if ( $a['bandeau_actif'] && $a['bandeau_texte'] && ( ! $a['bandeau_fin'] || $a['bandeau_fin'] >= $auj ) ) {
		$msgs[] = array( 'texte' => $a['bandeau_texte'], 'lien' => $a['bandeau_lien'], 'url' => $a['bandeau_url'] );
	}
	if ( $a['annoncer'] ) {
		$dans7 = wp_date( 'Y-m-d', time() + 7 * DAY_IN_SECONDS );
		foreach ( briise_fermetures_a_venir() as $f ) {
			if ( $f['du'] <= $dans7 ) {
				$msgs[] = array( 'texte' => briise_fermeture_texte( $f ) . '.', 'lien' => '', 'url' => '' );
			}
		}
	}
	return $msgs;
}

add_action( 'wp_body_open', function () {
	$msgs = briise_bandeau_messages();
	if ( ! $msgs ) {
		return;
	}
	$id = substr( md5( wp_json_encode( $msgs ) ), 0, 10 );
	echo '<div class="br-bandeau" id="br-bandeau" data-id="' . esc_attr( $id ) . '" role="region" aria-label="Information"><div class="br-bandeau-inner">';
	foreach ( $msgs as $m ) {
		echo '<p>' . esc_html( $m['texte'] );
		if ( $m['url'] ) {
			echo ' <a href="' . esc_url( $m['url'] ) . '">' . esc_html( $m['lien'] ? $m['lien'] : 'En savoir plus' ) . '</a>';
		}
		echo '</p>';
	}
	echo '</div><button type="button" class="br-bandeau-fermer" aria-label="Fermer l’information">×</button></div>';
	// Masqué avant affichage s'il a déjà été fermé, sans clignotement.
	wp_print_inline_script_tag( "try{if(localStorage.getItem('br-bandeau')===document.getElementById('br-bandeau').dataset.id){document.getElementById('br-bandeau').hidden=true;}}catch(e){}" );
} );

/* ----- Blog désactivé : rien qui y mène dans l'administration ---------------- */

add_action( 'admin_menu', function () {
	if ( ! briise_fonction( 'blog' ) ) {
		remove_menu_page( 'edit.php' );
		remove_menu_page( 'edit-comments.php' );
	}
}, 99 );

add_action( 'admin_bar_menu', function ( $bar ) {
	if ( ! briise_fonction( 'blog' ) ) {
		$bar->remove_node( 'new-post' );
		$bar->remove_node( 'comments' );
	}
}, 99 );

add_action( 'wp_dashboard_setup', function () {
	if ( ! briise_fonction( 'blog' ) ) {
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	}
} );

/* ----- Search Console et Matomo ----------------------------------------------- */

add_action( 'wp_head', function () {
	$f = briise_reglage( 'briise_fonctions' );
	if ( $f['gsc'] && is_front_page() ) {
		printf( "<meta name=\"google-site-verification\" content=\"%s\" />\n", esc_attr( $f['gsc'] ) );
	}
	// Pas de mesure des visites de l'équipe connectée.
	if ( ! $f['matomo_url'] || ! $f['matomo_id'] || current_user_can( 'edit_posts' ) ) {
		return;
	}
	wp_print_inline_script_tag(
		'var _paq=window._paq=window._paq||[];_paq.push(["disableCookies"]);_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);'
		. '(function(){var u=' . wp_json_encode( $f['matomo_url'] ) . ';_paq.push(["setTrackerUrl",u+"matomo.php"]);_paq.push(["setSiteId",' . wp_json_encode( (string) $f['matomo_id'] ) . ']);'
		. 'var d=document,g=d.createElement("script"),s=d.getElementsByTagName("script")[0];g.async=true;g.src=u+"matomo.js";s.parentNode.insertBefore(g,s);})();'
	);
}, 3 );

/* ----- Retour en haut ------------------------------------------------------ */

add_action( 'wp_footer', function () {
	if ( ! briise_fonction( 'retour_haut' ) ) {
		return;
	}
	echo '<a href="#" id="br-haut" class="br-haut" aria-label="Revenir en haut de la page"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 19V5M5 12l7-7 7 7"/></svg></a>';
}, 5 );
