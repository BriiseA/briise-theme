<?php
/**
 * Cartes « Coordonnées » et « Zone d'intervention ».
 *
 * Construction reprise des cartes du site DEFI No Limit, remplies depuis Mon entreprise
 * (une seule source pour le téléphone, l'adresse, les horaires et la zone) et colorées
 * par les couleurs du client. Icônes : Tabler Icons (licence MIT, © Paweł Kuna), intégrées en SVG.
 *
 * Codes courts : [briise_carte_coordonnees] et [briise_carte_zone].
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_icone( $nom ) {
	static $icones = array(
		'brand-instagram' => '<path d="M3 7a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v10a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4l0 -10" /> <path d="M8.5 12a3.5 3.5 0 1 0 7 0a3.5 3.5 0 0 0 -7 0" /> <path d="M17 7v.01" />',
		'brand-facebook' => '<path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />',
		'brand-linkedin' => '<path d="M8 11v5" /> <path d="M8 8v.01" /> <path d="M12 16v-5" /> <path d="M16 16v-3a2 2 0 1 0 -4 0" /> <path d="M3 7a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v10a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4l0 -10" />',
		'brand-google' => '<path d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945" />',
		'brand-tiktok' => '<path d="M21 7.917v4.034a9.948 9.948 0 0 1 -5 -1.951v4.5a6.5 6.5 0 1 1 -8 -6.326v4.326a2.5 2.5 0 1 0 4 2v-11.5h4.083a6.005 6.005 0 0 0 4.917 4.917" />',
		'brand-youtube' => '<path d="M2 8a4 4 0 0 1 4 -4h12a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-12a4 4 0 0 1 -4 -4v-8" /> <path d="M10 9l5 3l-5 3l0 -6" />',
		'brand-pinterest' => '<path d="M8 20l4 -9" /> <path d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7" /> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />',
		'photo' => '<path d="M15 8h.01" /> <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12" /> <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" /> <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />',
		'map-pin' => '<path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /> <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0" />',
		'calendar' => '<path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" /> <path d="M16 3v4" /> <path d="M8 3v4" /> <path d="M4 11h16" />',
		'tool' => '<path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5" />',
		'address-book' => '<path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2" /> <path d="M10 16h6" /> <path d="M11 11a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /> <path d="M4 8h3" /> <path d="M4 12h3" /> <path d="M4 16h3" />',
		'bell-ringing' => '<path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /> <path d="M9 17v1a3 3 0 0 0 6 0v-1" /> <path d="M21 6.727a11.05 11.05 0 0 0 -2.794 -3.727" /> <path d="M3 6.727a11.05 11.05 0 0 1 2.792 -3.727" />',
		'phone' => '<path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />',
		'mail' => '<path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /> <path d="M3 7l9 6l9 -6" />',
		'map-pin' => '<path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /> <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0" />',
		'clock' => '<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /> <path d="M12 7v5l3 3" />',
		'map-2' => '<path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" /> <path d="M9 4v13" /> <path d="M15 7v5.5" /> <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879" /> <path d="M19 18v.01" />',
		'external-link' => '<path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /> <path d="M11 13l9 -9" /> <path d="M15 4h5v5" />',
		'truck' => '<path d="M5 17a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /> <path d="M15 17a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /> <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />',
		'info-circle' => '<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /> <path d="M12 9h.01" /> <path d="M11 12h1v4h1" />',
	);
	return isset( $icones[ $nom ] )
		? '<svg class="br-ico" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icones[ $nom ] . '</svg>'
		: '';
}

/**
 * Secteurs de la zone, depuis le champ « Secteurs » :
 * « # Secteur | précision », « Commune | précision », « + étiquette ».
 * Sans secteurs : un seul secteur avec la liste des communes de la zone.
 */
function briise_zone_secteurs() {
	$e       = briise_reglage( 'briise_entreprise' );
	$lignes  = preg_split( '/\r\n|\r|\n/', (string) ( $e['zone_secteurs'] ?? '' ) );
	$secteurs = array();
	foreach ( $lignes as $l ) {
		$l = trim( $l );
		if ( '' === $l ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '|', ltrim( $l, '#+ ' ), 2 ) );
		if ( '#' === $l[0] ) {
			$secteurs[] = array( 'titre' => $parts[0], 'sous' => $parts[1] ?? '', 'villes' => array(), 'plus' => array() );
			continue;
		}
		if ( ! $secteurs ) {
			$secteurs[] = array( 'titre' => '', 'sous' => '', 'villes' => array(), 'plus' => array() );
		}
		$i = count( $secteurs ) - 1;
		if ( '+' === $l[0] ) {
			$secteurs[ $i ]['plus'][] = trim( substr( $l, 1 ) );
		} else {
			$secteurs[ $i ]['villes'][] = array( $parts[0], $parts[1] ?? '' );
		}
	}
	if ( ! $secteurs && ! empty( $e['areas'] ) ) {
		$secteurs[] = array( 'titre' => $e['city'] ? 'Autour de ' . $e['city'] : 'Nos communes', 'sous' => '', 'villes' => array_map( function ( $v ) {
			return array( $v, '' );
		}, $e['areas'] ), 'plus' => array() );
	}
	return $secteurs;
}

/**
 * Résumé des horaires pour la carte : le premier groupe ouvert en valeur, le reste en détail.
 */
function briise_horaires_resume() {
	$groupes = briise_horaires_groupes();
	$ouverts = array_values( array_filter( $groupes, function ( $g ) {
		return 'Fermé' !== $g['texte'];
	} ) );
	if ( ! $ouverts ) {
		return array( '', '' );
	}
	$detail = array( $ouverts[0]['texte'] );
	foreach ( $groupes as $g ) {
		if ( $g !== $ouverts[0] ) {
			$detail[] = $g['libelle'] . ' : ' . ( 'Fermé' === $g['texte'] ? 'fermé' : $g['texte'] );
		}
	}
	$note = briise_reglage( 'briise_annonces' )['note'] ?? '';
	if ( $note ) {
		$detail[] = $note;
	}
	return array( $ouverts[0]['libelle'], implode( ' · ', $detail ) );
}

function briise_carte_tete( $icone, $titre, $sous, $badge_titre, $badge_texte, $niveau = 2 ) {
	$h = '<div class="br-carte-tete"><div class="br-carte-tete-g"><span class="br-carte-ico br-carte-ico--tete">' . briise_icone( $icone ) . '</span><div>'
		. sprintf( '<h%1$d class="br-carte-titre">%2$s</h%1$d>', $niveau, esc_html( $titre ) )
		. ( $sous ? '<p class="br-carte-sous">' . esc_html( $sous ) . '</p>' : '' ) . '</div></div>';
	if ( $badge_titre ) {
		$h .= '<div class="br-carte-badge">' . briise_icone( 'coord' === $icone ? 'bell-ringing' : ( 'map-2' === $icone ? 'truck' : 'bell-ringing' ) )
			. '<span><strong>' . esc_html( $badge_titre ) . '</strong>' . ( $badge_texte ? '<small>' . esc_html( $badge_texte ) . '</small>' : '' ) . '</span></div>';
	}
	return $h . '</div>';
}

function briise_carte_coordonnees_html( $atts = array() ) {
	$atts = shortcode_atts( array( 'titre' => 'Coordonnées', 'niveau' => 2 ), $atts, 'briise_carte_coordonnees' );
	$e    = briise_entreprise();
	$r    = briise_reglage( 'briise_entreprise' );
	$col  = function ( $icone, $label, $valeur, $detail, $lien = '' ) {
		$tag = $lien ? 'a' : 'div';
		return '<' . $tag . ' class="br-carte-col"' . ( $lien ? ' href="' . esc_url( $lien ) . '"' : '' ) . '><span class="br-carte-ico">' . briise_icone( $icone ) . '</span><span class="br-carte-textes">'
			. '<span class="br-carte-label">' . esc_html( $label ) . '</span><span class="br-carte-valeur">' . esc_html( $valeur ) . '</span>'
			. ( $detail ? '<span class="br-carte-detail">' . esc_html( $detail ) . '</span>' : '' ) . '</span></' . $tag . '>';
	};
	$cols = array();
	if ( $e['telephone'] ) {
		$cols[] = $col( 'phone', 'Téléphone', briise_telephone_lisible( $e['telephone'] ), $r['precision_telephone'] ? $r['precision_telephone'] : 'Appel direct aux heures d’ouverture', 'tel:' . preg_replace( '/[^0-9+]/', '', $e['telephone'] ) );
	}
	if ( $e['email'] ) {
		$cols[] = $col( 'mail', 'E-mail', $e['email'], $r['precision_email'], 'mailto:' . $e['email'] );
	}
	if ( $e['street'] || $e['city'] ) {
		$ville  = trim( $e['postal_code'] . ' ' . $e['city'] );
		$cols[] = $col( 'map-pin', 'Adresse', $e['street'] ? $e['street'] : $ville, implode( ' · ', array_filter( array( $e['street'] ? $ville : '', $r['precision_adresse'] ) ) ) );
	}
	list( $jours, $heures ) = briise_horaires_resume();
	if ( $jours ) {
		$cols[] = $col( 'clock', 'Horaires', $jours, $heures );
	}
	if ( ! $cols ) {
		return current_user_can( 'edit_pages' ) ? '<p class="br-a-remplacer">Renseignez les coordonnées dans Mon entreprise &gt; Entreprise.</p>' : '';
	}
	$sous = $e['name'] . ( $e['slogan'] ? ' · ' . $e['slogan'] : '' );
	$h    = '<div class="br-carte br-carte-coord">' . briise_carte_tete( 'address-book', $atts['titre'], $sous, $r['badge_coord_titre'], $r['badge_coord_texte'], (int) $atts['niveau'] )
		. '<div class="br-carte-corps br-carte-' . count( $cols ) . '">' . implode( '', $cols ) . '</div>';
	$iti = briise_lien_itineraire();
	if ( $iti ) {
		$h .= '<div class="br-carte-pied"><span class="br-carte-pied-g">' . briise_icone( 'map-2' ) . '<span>' . esc_html( briise_adresse_ligne() ) . '</span></span>'
			. '<a class="br-carte-bouton" href="' . esc_url( $iti ) . '" target="_blank" rel="noopener" aria-label="Itinéraire Google Maps (nouvel onglet)">' . briise_icone( 'external-link' ) . 'Itinéraire Google Maps</a></div>';
	}
	return $h . '</div>';
}

function briise_carte_zone_html( $atts = array() ) {
	$atts     = shortcode_atts( array( 'titre' => 'Notre zone d’intervention', 'niveau' => 2 ), $atts, 'briise_carte_zone' );
	$e        = briise_entreprise();
	$r        = briise_reglage( 'briise_entreprise' );
	$secteurs = briise_zone_secteurs();
	if ( ! $secteurs ) {
		return current_user_can( 'edit_pages' ) ? '<p class="br-a-remplacer">Ajoutez vos communes dans Mon entreprise &gt; Entreprise.</p>' : '';
	}
	$sous = $r['zone_soustitre'] ? $r['zone_soustitre'] : ( $e['city'] ? 'Depuis notre atelier de ' . $e['city'] . ( $e['postal_code'] ? ' (' . $e['postal_code'] . ')' : '' ) : '' );
	$h    = '<div class="br-carte br-carte-zone">' . briise_carte_tete( 'map-2', $atts['titre'], $sous, $r['badge_zone_titre'], $r['badge_zone_texte'], (int) $atts['niveau'] )
		. '<div class="br-carte-corps br-carte-' . min( 4, count( $secteurs ) ) . '">';
	$n = (int) $atts['niveau'] + 1;
	foreach ( $secteurs as $s ) {
		$h .= '<div class="br-carte-col br-secteur">';
		if ( $s['titre'] ) {
			$h .= '<div class="br-secteur-tete"><span class="br-carte-ico">' . briise_icone( 'map-pin' ) . '</span><div>'
				. sprintf( '<h%1$d class="br-secteur-titre">%2$s</h%1$d>', $n, esc_html( $s['titre'] ) )
				. ( $s['sous'] ? '<p class="br-secteur-sous">' . esc_html( $s['sous'] ) . '</p>' : '' ) . '</div></div>';
		}
		$h .= '<ul class="br-secteur-liste">';
		foreach ( $s['villes'] as $v ) {
			$h .= '<li><strong>' . esc_html( $v[0] ) . '</strong>' . ( $v[1] ? ' <span>' . esc_html( $v[1] ) . '</span>' : '' ) . '</li>';
		}
		$h .= '</ul>';
		foreach ( $s['plus'] as $p ) {
			$h .= '<span class="br-secteur-plus">+ ' . esc_html( $p ) . '</span>';
		}
		$h .= '</div>';
	}
	$h .= '</div><div class="br-carte-pied"><span class="br-carte-pied-g">' . briise_icone( 'info-circle' ) . '<span>Vous n’êtes pas dans cette zone ? Nous étudions chaque demande.</span></span><span class="br-carte-boutons">';
	if ( $e['telephone'] ) {
		$h .= '<a class="br-carte-bouton" href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $e['telephone'] ) ) . '">' . briise_icone( 'phone' ) . esc_html( briise_telephone_lisible( $e['telephone'] ) ) . '</a>';
	}
	$h .= '<a class="br-carte-bouton" href="' . esc_url( $e['cta_url'] ) . '">' . briise_icone( 'mail' ) . esc_html( $e['cta_label'] ) . '</a></span></div>';
	return $h . '</div>';
}

add_action( 'init', function () {
	add_shortcode( 'briise_carte_coordonnees', 'briise_carte_coordonnees_html' );
	add_shortcode( 'briise_carte_zone', 'briise_carte_zone_html' );
	add_shortcode( 'briise_zone_schema', 'briise_zone_schema_html' );
	add_shortcode( 'briise_zone_liste', 'briise_zone_liste_html' );
} );

/**
 * Schéma de la zone d'intervention : l'adresse au centre, le rayon et les communes,
 * dessinés en SVG à partir de « Communes du schéma » (nom ; latitude ; longitude).
 * Aucune carte externe : pas de cookie, rien à charger.
 */
function briise_zone_schema_points() {
	$e      = briise_reglage( 'briise_entreprise' );
	$points = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) ( $e['zone_points'] ?? '' ) ) as $ligne ) {
		$p = array_map( 'trim', preg_split( '/[;|]/', $ligne ) );
		if ( count( $p ) >= 3 && '' !== $p[0] && is_numeric( str_replace( ',', '.', $p[1] ) ) && is_numeric( str_replace( ',', '.', $p[2] ) ) ) {
			$points[] = array( $p[0], (float) str_replace( ',', '.', $p[1] ), (float) str_replace( ',', '.', $p[2] ) );
		}
	}
	return $points;
}

function briise_zone_schema_html() {
	$points = briise_zone_schema_points();
	if ( count( $points ) < 2 ) {
		return current_user_can( 'edit_pages' ) ? '<p class="br-muted">Schéma de zone : ajoutez au moins deux communes dans Mon entreprise &gt; Coordonnées &gt; Communes du schéma.</p>' : '';
	}
	$e      = briise_reglage( 'briise_entreprise' );
	$rayon  = (int) ( $e['zone_rayon'] ?? 0 );
	$c      = $points[0];
	$cos    = cos( deg2rad( $c[1] ) );
	$km     = array();
	$max    = 1;
	foreach ( $points as $p ) {
		$x    = ( $p[2] - $c[2] ) * 111.32 * $cos;
		$y    = ( $c[1] - $p[1] ) * 110.57;
		$km[] = array( $x, $y );
		$max  = max( $max, sqrt( $x * $x + $y * $y ) );
	}
	$cx  = 280;
	$cy  = 190;
	$big = 165;
	$ref = $rayon > 0 ? max( $rayon, $max ) : $max;
	$svg = '';
	if ( $rayon > 0 ) {
		$r    = round( $big * sqrt( $rayon / $ref ), 1 );
		$svg .= '<circle class="br-schema-cercle" cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '" style="fill:none;stroke:var(--wp--preset--color--accent);stroke-width:2;stroke-dasharray:6 6"/>';
		$svg .= '<text x="' . $cx . '" y="' . round( $cy + $r + 22 ) . '" text-anchor="middle" style="fill:var(--wp--preset--color--texte-doux);font-size:14px">' . esc_html( $rayon ) . ' km</text>';
	}
	// Échelle en racine carrée : les communes proches du centre s'écartent un peu,
	// les plus lointaines restent au bord du cercle. Le schéma reste indicatif.
	$pos = array();
	foreach ( $points as $i => $p ) {
		$d     = sqrt( $km[ $i ][0] ** 2 + $km[ $i ][1] ** 2 );
		$k     = $d > 0 ? $big * sqrt( $d / $ref ) / $d : 0;
		$x     = round( $cx + $km[ $i ][0] * $k, 1 );
		$y     = round( $cy + $km[ $i ][1] * $k, 1 );
		$cote  = 0 === $i || $x >= $cx ? 'd' : 'g';
		$pos[] = array( 'x' => $x, 'y' => $y, 'ly' => $y + 5, 'cote' => $cote );
	}
	// Étiquettes : de chaque côté, on les écarte verticalement pour qu'elles ne se chevauchent pas.
	foreach ( array( 'd', 'g' ) as $cote ) {
		$ids = array_keys( array_filter( $pos, function ( $q ) use ( $cote ) { return $q['cote'] === $cote; } ) );
		usort( $ids, function ( $a, $b ) use ( $pos ) { return $pos[ $a ]['ly'] <=> $pos[ $b ]['ly']; } );
		for ( $passe = 0; $passe < 2; $passe++ ) {
			for ( $n = 1; $n < count( $ids ); $n++ ) {
				$haut = $pos[ $ids[ $n - 1 ] ]['ly'];
				if ( $pos[ $ids[ $n ] ]['ly'] - $haut < 21 ) {
					$pos[ $ids[ $n ] ]['ly'] = $haut + 21;
				}
			}
			// Trop bas : on remonte le groupe.
			$der = end( $ids );
			if ( false !== $der && $pos[ $der ]['ly'] > 392 ) {
				$dec = $pos[ $der ]['ly'] - 392;
				foreach ( $ids as $id ) {
					$pos[ $id ]['ly'] -= $dec;
				}
				for ( $n = count( $ids ) - 2; $n >= 0; $n-- ) {
					if ( $pos[ $ids[ $n + 1 ] ]['ly'] - $pos[ $ids[ $n ] ]['ly'] < 21 ) {
						$pos[ $ids[ $n ] ]['ly'] = $pos[ $ids[ $n + 1 ] ]['ly'] - 21;
					}
				}
			}
		}
	}
	$noms = array();
	foreach ( $points as $i => $p ) {
		$q      = $pos[ $i ];
		$centre = 0 === $i;
		$droite = 'd' === $q['cote'];
		$tx     = $droite ? $q['x'] + ( $centre ? 16 : 13 ) : $q['x'] - 13;
		$svg   .= '<g class="br-schema-point" style="--br-n:' . $i . '">';
		if ( abs( $q['ly'] - 5 - $q['y'] ) > 4 ) {
			// Étiquette déplacée : un trait fin la relie à son point.
			$svg .= '<line x1="' . $q['x'] . '" y1="' . $q['y'] . '" x2="' . ( $droite ? $tx - 3 : $tx + 3 ) . '" y2="' . round( $q['ly'] - 5, 1 ) . '" style="stroke:var(--wp--preset--color--texte-doux);stroke-width:1;opacity:.6"/>';
		}
		$svg   .= '<circle cx="' . $q['x'] . '" cy="' . $q['y'] . '" r="' . ( $centre ? 10 : 6 ) . '" style="fill:var(--wp--preset--color--' . ( $centre ? 'accent' : 'secondaire' ) . ');stroke:var(--wp--preset--color--surface);stroke-width:2"/>';
		$svg   .= '<text x="' . round( $tx, 1 ) . '" y="' . round( $q['ly'], 1 ) . '"' . ( $droite ? '' : ' text-anchor="end"' ) . ' style="fill:var(--wp--preset--color--texte);font-size:' . ( $centre ? 17 : 15 ) . 'px;font-weight:' . ( $centre ? 700 : 500 ) . ';paint-order:stroke;stroke:var(--wp--preset--color--surface);stroke-width:4px;stroke-linejoin:round">' . esc_html( $p[0] ) . '</text>';
		$svg   .= '</g>';
		$noms[] = $p[0];
	}
	$label = ( $rayon > 0 ? sprintf( 'Zone d’intervention : %d km autour de %s', $rayon, $c[0] ) : sprintf( 'Zone d’intervention autour de %s', $c[0] ) ) . ', avec ' . implode( ', ', array_slice( $noms, 1 ) );
	$html  = '<figure class="br-schema"><svg viewBox="0 0 560 400" role="img" aria-label="' . esc_attr( $label ) . '">' . $svg . '</svg>';
	$html .= '<figcaption class="br-schema-legende">' . ( $rayon > 0 ? 'Zone de ' . esc_html( $rayon ) . ' km autour de ' . esc_html( $c[0] ) . '. ' : '' ) . 'Schéma indicatif, distances non à l’échelle.</figcaption></figure>';
	return $html;
}

/**
 * Zone d'intervention en liste : les communes du schéma, groupées par distance
 * (à vol d'oiseau depuis la première ligne), puis une invitation à appeler.
 * Plus lisible que le schéma sur mobile, et les noms sont du vrai texte pour Google.
 */
function briise_zone_liste_html() {
	$points = briise_zone_schema_points();
	if ( count( $points ) < 2 ) {
		return current_user_can( 'edit_pages' ) ? '<p class="br-muted">Zone en liste : ajoutez au moins deux communes dans Mon entreprise &gt; Entreprise &gt; Communes du schéma de zone (la première est votre adresse). Ce message n’est visible que par vous.</p>' : '';
	}
	$e     = briise_reglage( 'briise_entreprise' );
	$rayon = (int) ( $e['zone_rayon'] ?? 0 );
	$c     = array_shift( $points );
	$dist  = function ( $p ) use ( $c ) {
		$x = deg2rad( $p[2] - $c[2] ) * cos( deg2rad( ( $p[1] + $c[1] ) / 2 ) );
		$y = deg2rad( $p[1] - $c[1] );
		return max( 1, (int) round( 6371 * sqrt( $x * $x + $y * $y ) ) );
	};
	$liste = array();
	foreach ( $points as $p ) {
		$liste[] = array( $p[0], $dist( $p ) );
	}
	usort( $liste, function ( $a, $b ) { return $a[1] <=> $b[1]; } );
	$haut    = max( $rayon, end( $liste )[1] );
	$groupes = array(
		array( 'Moins de 10 km', 0, 9 ),
		array( '10 à 20 km', 10, 20 ),
		array( sprintf( '20 à %d km', max( 21, $haut ) ), 21, PHP_INT_MAX ),
	);
	$h = '<div class="br-zone-liste">';
	foreach ( $groupes as $g ) {
		$items = array_filter( $liste, function ( $l ) use ( $g ) { return $l[1] >= $g[1] && $l[1] <= $g[2]; } );
		if ( ! $items ) {
			continue;
		}
		$h .= '<div class="br-zone-groupe"><p class="br-zone-groupe-titre">' . esc_html( $g[0] ) . '</p><ul>';
		foreach ( $items as $l ) {
			$h .= '<li class="br-zone-commune">' . esc_html( $l[0] ) . ' <span>' . (int) $l[1] . ' km</span></li>';
		}
		$h .= '</ul></div>';
	}
	$h .= '<p class="br-zone-note">Distances à vol d’oiseau depuis ' . esc_html( $c[0] ) . '.</p>';
	$tel = briise_entreprise()['telephone'];
	if ( $tel ) {
		$h .= '<p class="br-zone-appel">Votre commune n’est pas dans la liste ? <a href="tel:' . esc_attr( $tel ) . '">Appelez-nous au ' . esc_html( briise_telephone_lisible( $tel ) ) . '</a>' . ( $rayon ? sprintf( ' : si elle est à moins de %d km, nous venons.', $rayon ) : '.' ) . '</p>';
	}
	return $h . '</div>';
}
