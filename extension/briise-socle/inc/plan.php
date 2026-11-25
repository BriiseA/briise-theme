<?php
/**
 * Plan de la zone d'intervention : un vrai plan (OpenStreetMap), fabriqué une seule fois
 * à partir des « Communes du schéma de zone » et enregistré dans la Médiathèque du site.
 *
 * Le visiteur ne charge rien d'extérieur : pas de cookie, pas d'adresse IP envoyée à un
 * service de cartes, pas de bandeau de consentement. Le plan est refait seulement quand
 * les communes, le rayon ou la source des tuiles changent.
 *
 * Code court : [briise_zone_plan]
 * Commune : « nom ; latitude ; longitude » et, en option, « ; délai de visite » (« 48 h »).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Taille du plan, en pixels : proche de sa taille affichée, pour que les noms de rues et de
// communes du fond de carte restent lisibles (les tuiles sont dessinées pour être vues à 100 %).
const BRIISE_PLAN_L = 760;
const BRIISE_PLAN_H = 600;

/** Adresse des tuiles. Le filtre permet de passer à un autre fournisseur (avec son attribution). */
function briise_plan_source() {
	return (string) apply_filters( 'briise_plan_tuiles', 'https://tile.openstreetmap.org/{z}/{x}/{y}.png' );
}

function briise_plan_attribution() {
	return (string) apply_filters( 'briise_plan_attribution', '© <a href="https://www.openstreetmap.org/copyright">les contributeurs d’OpenStreetMap</a>' );
}

/* Projection Web Mercator, en pixels au niveau de zoom $z. */
function briise_plan_x( $lon, $z ) {
	return ( $lon + 180 ) / 360 * 256 * ( 2 ** $z );
}
function briise_plan_y( $lat, $z ) {
	$r = deg2rad( $lat );
	return ( 1 - log( tan( $r ) + 1 / cos( $r ) ) / M_PI ) / 2 * 256 * ( 2 ** $z );
}

/** Communes du schéma, avec leur délai de visite s'il est donné (4e partie de la ligne). */
function briise_plan_points() {
	$e      = briise_reglage( 'briise_entreprise' );
	$points = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) ( $e['zone_points'] ?? '' ) ) as $ligne ) {
		$p = array_map( 'trim', preg_split( '/[;|]/', $ligne ) );
		if ( count( $p ) >= 3 && '' !== $p[0] && is_numeric( str_replace( ',', '.', $p[1] ) ) && is_numeric( str_replace( ',', '.', $p[2] ) ) ) {
			$points[] = array(
				'nom'   => $p[0],
				'lat'   => (float) str_replace( ',', '.', $p[1] ),
				'lon'   => (float) str_replace( ',', '.', $p[2] ),
				'delai' => $p[3] ?? '',
			);
		}
	}
	return $points;
}

/** Ce dont dépend le plan : s'il change, le plan est refait. */
function briise_plan_empreinte() {
	$e = briise_reglage( 'briise_entreprise' );
	$c = array_map( function ( $p ) { return round( $p['lat'], 4 ) . ',' . round( $p['lon'], 4 ); }, briise_plan_points() );
	return substr( md5( implode( '|', $c ) . '#' . (int) ( $e['zone_rayon'] ?? 0 ) . '#' . briise_plan_source() . '#4' ), 0, 10 );
}

/**
 * Cadrage : le plus grand zoom où toutes les communes (et le rayon) tiennent dans le plan,
 * avec une marge pour les étiquettes.
 */
function briise_plan_cadrage( $points, $rayon ) {
	$c = $points[0];
	for ( $z = 14; $z >= 6; $z-- ) {
		$xs = array();
		$ys = array();
		foreach ( $points as $p ) {
			$xs[] = briise_plan_x( $p['lon'], $z );
			$ys[] = briise_plan_y( $p['lat'], $z );
		}
		if ( $rayon > 0 ) {
			$mpp  = 156543.03392 * cos( deg2rad( $c['lat'] ) ) / ( 2 ** $z );
			$r    = $rayon * 1000 / $mpp;
			$cx   = briise_plan_x( $c['lon'], $z );
			$cy   = briise_plan_y( $c['lat'], $z );
			$xs[] = $cx - $r;
			$xs[] = $cx + $r;
			$ys[] = $cy - $r;
			$ys[] = $cy + $r;
		}
		$l = max( $xs ) - min( $xs );
		$h = max( $ys ) - min( $ys );
		// Les communes gardent une marge pour leur étiquette ; le cercle du rayon peut frôler le bord.
		$pl = max( array_slice( $xs, 0, count( $points ) ) ) - min( array_slice( $xs, 0, count( $points ) ) );
		$ph = max( array_slice( $ys, 0, count( $points ) ) ) - min( array_slice( $ys, 0, count( $points ) ) );
		if ( $l <= BRIISE_PLAN_L && $h <= BRIISE_PLAN_H && $pl <= BRIISE_PLAN_L * 0.82 && $ph <= BRIISE_PLAN_H * 0.8 ) {
			return array(
				'z'  => $z,
				'ox' => (int) round( ( max( $xs ) + min( $xs ) ) / 2 - BRIISE_PLAN_L / 2 ),
				// Un peu plus de marge en haut : les étiquettes sont au-dessus des points.
				'oy' => (int) round( ( max( $ys ) + min( $ys ) ) / 2 - BRIISE_PLAN_H / 2 - BRIISE_PLAN_H * 0.03 ),
			);
		}
	}
	return null;
}

/**
 * Fabrique le plan et l'enregistre. Renvoie true, ou un message d'erreur.
 */
function briise_plan_fabriquer() {
	$points = briise_plan_points();
	$e      = briise_reglage( 'briise_entreprise' );
	$rayon  = (int) ( $e['zone_rayon'] ?? 0 );
	$emp    = briise_plan_empreinte();
	$echec  = function ( $msg ) use ( $emp ) {
		update_option( 'briise_plan_zone', array( 'empreinte' => $emp, 'erreur' => $msg, 'date' => time() ), false );
		return $msg;
	};
	if ( count( $points ) < 2 ) {
		delete_option( 'briise_plan_zone' );
		return 'Au moins deux communes sont nécessaires.';
	}
	if ( ! function_exists( 'imagecreatetruecolor' ) ) {
		return $echec( 'L’extension GD de PHP manque sur l’hébergement : le schéma s’affiche à la place du plan.' );
	}
	$cad = briise_plan_cadrage( $points, $rayon );
	if ( ! $cad ) {
		return $echec( 'Communes trop éloignées les unes des autres pour un plan lisible.' );
	}
	$z   = $cad['z'];
	$img = imagecreatetruecolor( BRIISE_PLAN_L, BRIISE_PLAN_H );
	imagefill( $img, 0, 0, imagecolorallocate( $img, 238, 238, 236 ) );
	$max = 2 ** $z;
	$src = briise_plan_source();
	$ua  = 'BriiseSocle/' . ( defined( 'BRIISE_SOCLE_VERSION' ) ? BRIISE_SOCLE_VERSION : '1' ) . ' (+' . home_url( '/' ) . ')';
	$ok  = 0;
	$nb  = 0;
	$fin = microtime( true ) + 25; // Jamais plus de 25 secondes, même si le serveur de cartes est lent.
	for ( $tx = (int) floor( $cad['ox'] / 256 ); $tx <= (int) floor( ( $cad['ox'] + BRIISE_PLAN_L - 1 ) / 256 ); $tx++ ) {
		for ( $ty = (int) floor( $cad['oy'] / 256 ); $ty <= (int) floor( ( $cad['oy'] + BRIISE_PLAN_H - 1 ) / 256 ); $ty++ ) {
			if ( $ty < 0 || $ty >= $max ) {
				continue;
			}
			if ( microtime( true ) > $fin || ( ++$nb > 3 && ! $ok ) ) {
				break 2; // Serveur injoignable depuis l'hébergement : inutile d'insister.
			}
			$url = str_replace( array( '{z}', '{x}', '{y}' ), array( $z, ( $tx % $max + $max ) % $max, $ty ), $src );
			$rep = wp_remote_get( $url, array( 'timeout' => 10, 'user-agent' => $ua, 'headers' => array( 'Referer' => home_url( '/' ) ) ) );
			if ( is_wp_error( $rep ) || 200 !== (int) wp_remote_retrieve_response_code( $rep ) ) {
				continue;
			}
			$tuile = @imagecreatefromstring( wp_remote_retrieve_body( $rep ) ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
			if ( ! $tuile ) {
				continue;
			}
			imagecopy( $img, $tuile, $tx * 256 - $cad['ox'], $ty * 256 - $cad['oy'], 0, 0, 256, 256 );
			imagedestroy( $tuile );
			++$ok;
		}
	}
	if ( ! $ok ) {
		imagedestroy( $img );
		return $echec( 'Le serveur de cartes n’a pas répondu. Nouvel essai automatique dans l’heure, à l’ouverture de Mon entreprise.' );
	}
	// Plan en gris clair : les couleurs du site (points, rayon) ressortent dessus.
	imagefilter( $img, IMG_FILTER_GRAYSCALE );
	imagefilter( $img, IMG_FILTER_CONTRAST, 8 );
	imagefilter( $img, IMG_FILTER_BRIGHTNESS, 14 );

	$up = wp_upload_dir();
	if ( ! empty( $up['error'] ) ) {
		imagedestroy( $img );
		return $echec( 'Le dossier des fichiers envoyés n’est pas accessible en écriture.' );
	}
	$dossier = trailingslashit( $up['basedir'] ) . 'briise';
	wp_mkdir_p( $dossier );
	foreach ( (array) glob( $dossier . '/plan-zone-*' ) as $ancien ) {
		wp_delete_file( $ancien );
	}
	$webp    = function_exists( 'imagewebp' );
	$fichier = 'plan-zone-' . $emp . ( $webp ? '.webp' : '.jpg' );
	$ecrit   = $webp ? imagewebp( $img, $dossier . '/' . $fichier, 78 ) : imagejpeg( $img, $dossier . '/' . $fichier, 82 );
	imagedestroy( $img );
	if ( ! $ecrit ) {
		return $echec( 'Le plan n’a pas pu être enregistré sur le serveur.' );
	}
	update_option(
		'briise_plan_zone',
		array(
			'empreinte' => $emp,
			'fichier'   => 'briise/' . $fichier,
			'z'         => $z,
			'ox'        => $cad['ox'],
			'oy'        => $cad['oy'],
			'complet'   => $ok,
			'date'      => time(),
		),
		false
	);
	return true;
}

/** Le plan enregistré, s'il correspond aux communes actuelles. */
function briise_plan_actuel() {
	$plan = get_option( 'briise_plan_zone' );
	if ( ! is_array( $plan ) || empty( $plan['fichier'] ) || ( $plan['empreinte'] ?? '' ) !== briise_plan_empreinte() ) {
		return null;
	}
	$up = wp_upload_dir();
	if ( ! file_exists( trailingslashit( $up['basedir'] ) . $plan['fichier'] ) ) {
		return null;
	}
	$plan['url'] = set_url_scheme( trailingslashit( $up['baseurl'] ) . $plan['fichier'] );
	return $plan;
}

/**
 * Le plan se refait quand Mon entreprise est enregistrée (ou importée) et que les communes ont changé.
 * Jamais pendant la visite d'une page.
 */
function briise_plan_a_jour() {
	if ( count( briise_plan_points() ) < 2 ) {
		return;
	}
	$plan = get_option( 'briise_plan_zone' );
	if ( is_array( $plan ) && ( $plan['empreinte'] ?? '' ) === briise_plan_empreinte() && ( ! empty( $plan['fichier'] ) || time() - (int) ( $plan['date'] ?? 0 ) < 600 ) ) {
		return;
	}
	briise_plan_fabriquer();
}
add_action( 'update_option_briise_entreprise', 'briise_plan_a_jour', 20 );
// Après un échec (serveur de cartes injoignable), nouvel essai à l'ouverture de Mon entreprise, au plus une fois par heure.
add_action( 'admin_init', function () {
	if ( 'briise-entreprise' !== ( $_GET['page'] ?? '' ) || ! current_user_can( 'manage_options' ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	$plan = get_option( 'briise_plan_zone' );
	if ( is_array( $plan ) && ! empty( $plan['erreur'] ) && time() - (int) ( $plan['date'] ?? 0 ) > HOUR_IN_SECONDS ) {
		briise_plan_fabriquer();
	}
} );
add_action( 'add_option_briise_entreprise', 'briise_plan_a_jour', 20 );

/* ----- Affichage --------------------------------------------------------- */

function briise_zone_plan_html() {
	$points = briise_plan_points();
	if ( count( $points ) < 2 ) {
		return current_user_can( 'edit_pages' ) ? '<p class="br-a-remplacer">Zone sur un plan : ajoutez au moins deux communes dans Mon entreprise &gt; Entreprise &gt; Communes du schéma de zone (la première est votre adresse). Ce message n’est visible que par vous.</p>' : '';
	}
	$e      = briise_reglage( 'briise_entreprise' );
	$rayon  = (int) ( $e['zone_rayon'] ?? 0 );
	$c      = $points[0];
	$plan   = briise_plan_actuel();
	$dist   = function ( $p ) use ( $c ) {
		$x = deg2rad( $p['lon'] - $c['lon'] ) * cos( deg2rad( ( $p['lat'] + $c['lat'] ) / 2 ) );
		$y = deg2rad( $p['lat'] - $c['lat'] );
		return max( 1, (int) round( 6371 * sqrt( $x * $x + $y * $y ) ) );
	};
	$autres = array_slice( $points, 1 );
	usort( $autres, function ( $a, $b ) use ( $dist ) { return $dist( $a ) <=> $dist( $b ); } );

	// Les communes : de vrais boutons (et du vrai texte pour Google), le plan ne fait qu'illustrer.
	$liste = '';
	foreach ( $autres as $i => $p ) {
		$km     = $dist( $p );
		$info   = sprintf( 'Environ %d km de %s.', $km, $c['nom'] ) . ( '' !== $p['delai'] ? ' Visite sous ' . $p['delai'] . '.' : '' );
		$liste .= '<li><button type="button" aria-pressed="false" data-n="' . ( $i + 1 ) . '" data-info="' . esc_attr( $info ) . '">' . esc_html( $p['nom'] ) . '<span>' . (int) $km . ' km</span></button></li>';
	}
	$h  = '<div class="br-zplan">';
	$h .= '<div class="br-zplan-choix"><ul class="br-zplan-communes" aria-label="Communes desservies">' . $liste . '</ul>';
	$h .= '<p class="br-zplan-info" aria-live="polite"><span class="br-zplan-info-txt">' . esc_html( $rayon > 0 ? sprintf( 'Nous nous déplaçons jusqu’à %d km autour de %s. Votre commune n’est pas dans la liste ? Appelez-nous.', $rayon, $c['nom'] ) : sprintf( 'Votre commune n’est pas dans la liste ? Appelez-nous : nous vous dirons si nous intervenons chez vous.' ) ) . '</span></p>';
	$h .= '</div>';

	if ( $plan ) {
		$z   = (int) $plan['z'];
		$pos = function ( $p ) use ( $plan, $z ) {
			return array(
				round( ( briise_plan_x( $p['lon'], $z ) - $plan['ox'] ) / BRIISE_PLAN_L * 100, 2 ),
				round( ( briise_plan_y( $p['lat'], $z ) - $plan['oy'] ) / BRIISE_PLAN_H * 100, 2 ),
			);
		};
		list( $cx, $cy ) = $pos( $c );
		$noms = implode( ', ', wp_list_pluck( $autres, 'nom' ) );
		$h   .= '<figure class="br-zplan-carte"><div class="br-zplan-fond">';
		$h   .= '<img src="' . esc_url( $plan['url'] ) . '" width="' . BRIISE_PLAN_L . '" height="' . BRIISE_PLAN_H . '" loading="lazy" decoding="async" alt="' . esc_attr( sprintf( 'Plan de la zone d’intervention autour de %s%s, avec %s.', $c['nom'], $rayon > 0 ? ' (' . $rayon . ' km)' : '', $noms ) ) . '">';
		if ( $rayon > 0 ) {
			$mpp = 156543.03392 * cos( deg2rad( $c['lat'] ) ) / ( 2 ** $z );
			$d   = round( 2 * $rayon * 1000 / $mpp / BRIISE_PLAN_L * 100, 2 );
			$h  .= '<span class="br-zplan-rayon" style="left:' . $cx . '%;top:' . $cy . '%;width:' . $d . '%" aria-hidden="true"></span>';
		}
		foreach ( $autres as $i => $p ) {
			list( $x, $y ) = $pos( $p );
			$h .= '<span class="br-zplan-point" data-n="' . ( $i + 1 ) . '" style="left:' . $x . '%;top:' . $y . '%" aria-hidden="true"><span>' . esc_html( $p['nom'] ) . '</span></span>';
		}
		$h .= '<span class="br-zplan-point br-zplan-point--centre" style="left:' . $cx . '%;top:' . $cy . '%" aria-hidden="true"><span>' . esc_html( $c['nom'] ) . '</span></span>';
		$h .= '</div><figcaption class="br-zplan-credit">' . wp_kses( briise_plan_attribution(), array( 'a' => array( 'href' => array() ) ) ) . '</figcaption></figure>';
	} else {
		// Pas de plan (pas encore fabriqué, ou serveur de cartes injoignable) : le schéma dessiné.
		$plan_brut = get_option( 'briise_plan_zone' );
		$note      = ( current_user_can( 'manage_options' ) && is_array( $plan_brut ) && ! empty( $plan_brut['erreur'] ) )
			? '<p class="br-a-remplacer">Plan non disponible : ' . esc_html( $plan_brut['erreur'] ) . ' Ce message n’est visible que par vous.</p>' : '';
		$h        .= '<div class="br-zplan-carte br-zplan-carte--schema">' . briise_zone_schema_html() . $note . '</div>';
	}
	return $h . '</div>';
}

add_action( 'init', function () {
	add_shortcode( 'briise_zone_plan', 'briise_zone_plan_html' );
} );
