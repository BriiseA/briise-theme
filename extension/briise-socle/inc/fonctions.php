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
 * Messages à afficher aujourd'hui : le bandeau saisi, les fermetures
 * exceptionnelles qui commencent dans 7 jours ou moins, puis la prochaine
 * disponibilité (retirée une fois sa date passée ou après 30 jours sans mise à jour).
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
	$dispo = briise_disponibilite();
	if ( $dispo ) {
		$e      = briise_entreprise();
		$msgs[] = array( 'texte' => $dispo, 'lien' => $e['cta_label'], 'url' => $e['cta_url'], 'classe' => 'is-dispo' );
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

/**
 * Texte de la prochaine disponibilité, ou chaîne vide si elle est passée,
 * trop ancienne (30 jours sans mise à jour) ou non renseignée.
 */
function briise_disponibilite() {
	$a = briise_reglage( 'briise_annonces' );
	if ( empty( $a['dispo_date'] ) || empty( $a['dispo_maj'] ) ) {
		return '';
	}
	$auj = briise_aujourdhui();
	if ( $a['dispo_date'] < $auj || $a['dispo_maj'] < wp_date( 'Y-m-d', time() - 30 * DAY_IN_SECONDS ) ) {
		return '';
	}
	$jours = array( 'dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi' );
	$jour  = $jours[ (int) gmdate( 'w', strtotime( $a['dispo_date'] . ' 12:00:00 UTC' ) ) ];
	$annee = substr( $a['dispo_date'], 0, 4 ) !== wp_date( 'Y' );
	return $a['dispo_texte'] . ' à partir du ' . $jour . ' ' . briise_date( $a['dispo_date'], $annee );
}

add_action( 'wp_body_open', function () {
	$msgs = briise_bandeau_messages();
	if ( ! $msgs ) {
		return;
	}
	$id = substr( md5( wp_json_encode( $msgs ) ), 0, 10 );
	echo '<div class="br-bandeau" id="br-bandeau" data-id="' . esc_attr( $id ) . '" role="region" aria-label="Information"><div class="br-bandeau-inner">';
	foreach ( $msgs as $m ) {
		echo '<p' . ( empty( $m['classe'] ) ? '' : ' class="' . esc_attr( $m['classe'] ) . '"' ) . '>' . esc_html( $m['texte'] );
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
