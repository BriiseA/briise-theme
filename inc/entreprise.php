<?php
/**
 * Informations de l'entreprise, lues dans « Mon entreprise » (inc/reglages.php),
 * et leurs affichages : horaires, coordonnées, mentions légales.
 * À tenir identiques à la fiche Google Business Profile, au caractère près.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Toutes les informations utiles au thème, prêtes à l'emploi.
 * Le filtre « briise_entreprise » reste disponible pour un cas particulier.
 */
function briise_entreprise() {
	$e = briise_reglage( 'briise_entreprise' );
	$l = briise_reglage( 'briise_legal' );

	$page_url = function ( $id, $slug ) {
		$page = $id ? get_post( $id ) : get_page_by_path( $slug );
		return ( $page && 'publish' === $page->post_status ) ? $page : null;
	};
	$cta_page = $page_url( $e['cta_page'], 'contact' );
	$cta_url  = $e['cta_url'] ? $e['cta_url'] : ( $cta_page ? get_permalink( $cta_page ) : '' );
	if ( ! $cta_url && $e['email'] ) {
		$cta_url = 'mailto:' . $e['email'];
	}
	$faq    = $page_url( $e['faq_page'], 'faq' );
	$person = $e['person_page'] ? $page_url( $e['person_page'], '' ) : null;

	$data = array(
		'name'        => get_bloginfo( 'name' ),
		'slogan'      => get_bloginfo( 'description' ),
		'legal_name'  => $l['raison_sociale'],
		'description' => $e['description'] ? $e['description'] : get_bloginfo( 'description' ),
		'type'        => $e['type'],
		'email'       => $e['email'],
		'telephone'   => $e['telephone'],
		'street'      => $e['street'],
		'postal_code' => $e['postal_code'],
		'city'        => $e['city'],
		'country'     => $e['country'],
		'latitude'    => $e['latitude'],
		'longitude'   => $e['longitude'],
		'price_range' => $e['price_range'],
		'areas'       => $e['areas'],
		'reseaux'     => array_filter( array(
			'Instagram' => $e['instagram'],
			'Facebook'  => $e['facebook'],
			'LinkedIn'  => $e['linkedin'],
			'Google'    => $e['google'],
		) ),
		'same_as'     => array_values( array_filter( array_merge( array( $e['instagram'], $e['facebook'], $e['linkedin'], $e['google'] ), $e['autres'] ) ) ),
		'cta_label'   => $e['cta_label'],
		'cta_url'     => $cta_url ? $cta_url : home_url( '/' ),
		'person_name' => $e['person_name'],
		'person_job'  => $e['person_job'],
		'person_id'   => $person ? $person->ID : 0,
		'faq_id'      => $faq ? $faq->ID : 0,
	);
	return apply_filters( 'briise_entreprise', $data );
}

/**
 * Téléphone lisible : +33612345678 devient 06 12 34 56 78.
 */
function briise_telephone_lisible( $tel ) {
	$digits = preg_replace( '/[^\d+]/', '', (string) $tel );
	if ( 0 === strpos( $digits, '+33' ) ) {
		$digits = '0' . substr( $digits, 3 );
	}
	if ( preg_match( '/^0\d{9}$/', $digits ) ) {
		return trim( chunk_split( $digits, 2, ' ' ) );
	}
	return (string) $tel;
}

function briise_adresse_ligne() {
	$e = briise_entreprise();
	return trim( implode( ' ', array_filter( array( $e['street'] ? $e['street'] . ',' : '', $e['postal_code'], $e['city'] ) ) ), ' ,' );
}

/**
 * Lien d'itinéraire : coordonnées GPS si elles existent, sinon l'adresse.
 */
function briise_lien_itineraire() {
	$e = briise_entreprise();
	if ( '' !== $e['latitude'] && '' !== $e['longitude'] ) {
		return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $e['latitude'] . ',' . $e['longitude'] );
	}
	$adresse = briise_adresse_ligne();
	return $adresse ? 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $e['name'] . ', ' . $adresse ) : '';
}

/* ----- Dates et heures en français, quelle que soit la langue du site ----- */

function briise_heure( $h ) {
	list( $hh, $mm ) = array_map( 'intval', explode( ':', $h ) );
	return $hh . 'h' . ( $mm ? sprintf( '%02d', $mm ) : '' );
}

function briise_date( $ymd, $avec_annee = false ) {
	$mois = array( '', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre' );
	list( $y, $m, $d ) = array_map( 'intval', explode( '-', $ymd ) );
	return ( 1 === $d ? '1er' : $d ) . ' ' . $mois[ $m ] . ( $avec_annee ? ' ' . $y : '' );
}

function briise_aujourdhui() {
	return wp_date( 'Y-m-d' );
}

/* ----- Horaires ---------------------------------------------------------- */

function briise_horaires_renseignes() {
	$a = briise_reglage( 'briise_annonces' );
	foreach ( $a['jours'] as $j ) {
		if ( $j['ouvert'] ) {
			return true;
		}
	}
	return false;
}

/**
 * Horaires regroupés : les jours consécutifs identiques forment une ligne.
 * Retourne [ [ 'jours' => [1,2,3], 'libelle' => 'Lundi – mercredi', 'texte' => '9h – 12h, 14h – 18h' ], … ]
 */
function briise_horaires_groupes() {
	$a      = briise_reglage( 'briise_annonces' );
	$lignes = array();
	foreach ( BRIISE_JOURS as $n => $nom ) {
		$j     = $a['jours'][ $n ];
		$texte = 'Fermé';
		if ( $j['ouvert'] ) {
			$parts = array();
			foreach ( $j['plages'] as $p ) {
				if ( $p[0] && $p[1] ) {
					$parts[] = briise_heure( $p[0] ) . ' – ' . briise_heure( $p[1] );
				}
			}
			$texte = implode( ', ', $parts );
		}
		$dernier = end( $lignes );
		if ( $dernier && $dernier['texte'] === $texte ) {
			$lignes[ key( $lignes ) ]['jours'][] = $n;
		} else {
			$lignes[] = array( 'jours' => array( $n ), 'texte' => $texte );
		}
	}
	foreach ( $lignes as $i => $l ) {
		$premier = ucfirst( BRIISE_JOURS[ $l['jours'][0] ] );
		$nb      = count( $l['jours'] );
		if ( 1 === $nb ) {
			$lignes[ $i ]['libelle'] = $premier;
		} elseif ( 2 === $nb ) {
			$lignes[ $i ]['libelle'] = $premier . ' et ' . BRIISE_JOURS[ $l['jours'][1] ];
		} else {
			$lignes[ $i ]['libelle'] = $premier . ' – ' . BRIISE_JOURS[ end( $l['jours'] ) ];
		}
	}
	return $lignes;
}

/**
 * Fermetures exceptionnelles en cours ou à venir.
 */
function briise_fermetures_a_venir() {
	$a    = briise_reglage( 'briise_annonces' );
	$auj  = briise_aujourdhui();
	$out  = array();
	foreach ( $a['fermetures'] as $f ) {
		if ( $f['du'] && $f['au'] >= $auj ) {
			$out[] = $f;
		}
	}
	return $out;
}

function briise_fermeture_texte( $f ) {
	$annee = substr( $f['du'], 0, 4 ) !== wp_date( 'Y' );
	if ( $f['du'] === $f['au'] ) {
		$t = 'Fermeture exceptionnelle le ' . briise_date( $f['du'], $annee );
	} else {
		$meme_mois = substr( $f['du'], 0, 7 ) === substr( $f['au'], 0, 7 );
		$debut     = $meme_mois ? preg_replace( '/ .*$/', '', briise_date( $f['du'] ) ) : briise_date( $f['du'] );
		$t         = 'Fermeture exceptionnelle du ' . $debut . ' au ' . briise_date( $f['au'], $annee );
	}
	return $t . ( $f['motif'] ? ' (' . $f['motif'] . ')' : '' );
}

/**
 * HTML des horaires : liste de définitions, une ligne par groupe de jours.
 * La ligne du jour est surlignée par assets/js/ux.js.
 */
function briise_horaires_html( $args = array() ) {
	if ( ! briise_horaires_renseignes() ) {
		return '';
	}
	$a   = briise_reglage( 'briise_annonces' );
	$out = '<dl class="br-horaires">';
	foreach ( briise_horaires_groupes() as $l ) {
		$out .= sprintf(
			'<div class="br-horaires-ligne%s" data-jours="%s"><dt>%s</dt><dd>%s</dd></div>',
			'Fermé' === $l['texte'] ? ' br-ferme' : '',
			esc_attr( implode( ',', $l['jours'] ) ),
			esc_html( $l['libelle'] ),
			esc_html( $l['texte'] )
		);
	}
	$out .= '</dl>';
	if ( $a['note'] ) {
		$out .= '<p class="br-horaires-note">' . esc_html( $a['note'] ) . '</p>';
	}
	foreach ( briise_fermetures_a_venir() as $f ) {
		$out .= '<p class="br-fermeture">' . esc_html( briise_fermeture_texte( $f ) ) . '</p>';
	}
	return $out;
}

/**
 * Coordonnées : adresse avec itinéraire, téléphone, e-mail.
 */
function briise_coordonnees_html() {
	$e       = briise_entreprise();
	$adresse = briise_adresse_ligne();
	$lignes  = array();
	if ( $adresse ) {
		$iti      = briise_lien_itineraire();
		$lignes[] = esc_html( $adresse ) . ( $iti ? ' · <a href="' . esc_url( $iti ) . '">Itinéraire</a>' : '' );
	}
	if ( $e['telephone'] ) {
		$lignes[] = '<a href="tel:' . esc_attr( $e['telephone'] ) . '">' . esc_html( briise_telephone_lisible( $e['telephone'] ) ) . '</a>';
	}
	if ( $e['email'] ) {
		$lignes[] = '<a href="mailto:' . esc_attr( antispambot( $e['email'] ) ) . '">' . esc_html( antispambot( $e['email'] ) ) . '</a>';
	}
	return $lignes ? '<p class="br-coordonnees">' . implode( '<br>', $lignes ) . '</p>' : '';
}

function briise_reseaux_html() {
	$e = briise_entreprise();
	if ( ! $e['reseaux'] ) {
		return '';
	}
	$liens = array();
	foreach ( $e['reseaux'] as $nom => $url ) {
		$liens[] = '<a href="' . esc_url( $url ) . '" rel="me noopener" target="_blank">' . esc_html( $nom ) . '<span class="screen-reader-text"> (nouvel onglet)</span></a>';
	}
	return '<p class="br-reseaux">' . implode( ' · ', $liens ) . '</p>';
}

/**
 * Mentions légales générées depuis l'onglet « Mentions légales ».
 * Un champ obligatoire vide s'affiche « [à compléter] » : la checklist de
 * livraison interdit d'en laisser un.
 */
function briise_mentions_html() {
	$e = briise_entreprise();
	$l = briise_reglage( 'briise_legal' );
	$v = function ( $val ) {
		return '' !== trim( (string) $val ) ? esc_html( $val ) : '<mark>[à compléter]</mark>';
	};
	$siege = $l['siege'] ? $l['siege'] : briise_adresse_ligne();

	$h  = '<h2>Éditeur du site</h2><p>';
	$h .= $v( $l['raison_sociale'] ) . ', ' . $v( $l['forme'] );
	$h .= $l['capital'] ? ' au capital de ' . esc_html( $l['capital'] ) : '';
	$h .= '<br>Siège : ' . nl2br( $v( $siege ) );
	$h .= '<br>SIREN : ' . $v( $l['siren'] );
	$h .= $l['rcs'] ? '<br>' . esc_html( $l['rcs'] ) : '';
	$h .= $l['tva'] ? '<br>TVA intracommunautaire : ' . esc_html( $l['tva'] ) : '';
	$h .= $e['telephone'] ? '<br>Téléphone : ' . esc_html( briise_telephone_lisible( $e['telephone'] ) ) : '';
	$h .= '<br>E-mail : ' . ( $e['email'] ? esc_html( antispambot( $e['email'] ) ) : $v( '' ) ) . '</p>';

	$h .= '<h2>Directeur de la publication</h2><p>' . $v( $l['directeur'] ) . '</p>';

	if ( $l['ordre'] || $l['titre_pro'] ) {
		$h .= '<h2>Profession réglementée</h2><p>';
		$h .= $l['titre_pro'] ? 'Titre professionnel : ' . esc_html( $l['titre_pro'] ) . '<br>' : '';
		$h .= $l['ordre'] ? 'Ordre ou organisme d’inscription : ' . esc_html( $l['ordre'] ) . '<br>' : '';
		$h .= $l['regles_url'] ? 'Règles professionnelles : <a href="' . esc_url( $l['regles_url'] ) . '">consulter</a>' : '';
		$h .= '</p>';
	}

	$h .= '<h2>Hébergement</h2><p>' . $v( $l['hebergeur_nom'] ) . '<br>' . nl2br( $v( $l['hebergeur_adresse'] ) );
	$h .= $l['hebergeur_tel'] ? '<br>' . esc_html( $l['hebergeur_tel'] ) : '';
	$h .= '</p>';

	if ( $l['mediateur_nom'] ) {
		$h .= '<h2>Médiation de la consommation</h2><p>En cas de litige, vous pouvez recourir gratuitement au médiateur : ' . esc_html( $l['mediateur_nom'] );
		$h .= $l['mediateur_url'] ? ', <a href="' . esc_url( $l['mediateur_url'] ) . '">' . esc_html( preg_replace( '#^https?://#', '', untrailingslashit( $l['mediateur_url'] ) ) ) . '</a>' : '';
		$h .= '.</p>';
	}

	if ( $l['realisation'] ) {
		$nom = esc_html( $l['realisation'] );
		$h  .= '<h2>Conception et réalisation</h2><p>' . ( $l['realisation_url'] ? '<a href="' . esc_url( $l['realisation_url'] ) . '">' . $nom . '</a>' : $nom ) . '</p>';
	}
	return '<div class="br-mentions">' . $h . '</div>';
}

/* ----- Codes courts, à placer dans un bloc « Code court » ------------------ */

add_action( 'init', function () {
	add_shortcode( 'briise_horaires', 'briise_horaires_html' );
	add_shortcode( 'briise_coordonnees', 'briise_coordonnees_html' );
	add_shortcode( 'briise_reseaux', 'briise_reseaux_html' );
	add_shortcode( 'briise_mentions_legales', 'briise_mentions_html' );
	add_shortcode( 'briise_fil_ariane', 'briise_fil_ariane_html' );
	add_shortcode( 'briise_zone', 'briise_zone_html' );
	add_shortcode( 'briise_contact_rapide', 'briise_contact_rapide_html' );
	add_shortcode( 'briise_telephone', function () {
		$e = briise_entreprise();
		return $e['telephone'] ? '<a href="tel:' . esc_attr( $e['telephone'] ) . '">' . esc_html( briise_telephone_lisible( $e['telephone'] ) ) . '</a>' : '';
	} );
	add_shortcode( 'briise_info', function ( $atts ) {
		$atts = shortcode_atts( array( 'champ' => 'name' ), $atts );
		$e    = briise_entreprise();
		if ( 'telephone' === $atts['champ'] ) {
			return esc_html( briise_telephone_lisible( $e['telephone'] ) );
		}
		if ( 'adresse' === $atts['champ'] ) {
			return esc_html( briise_adresse_ligne() );
		}
		return isset( $e[ $atts['champ'] ] ) && is_string( $e[ $atts['champ'] ] ) ? esc_html( $e[ $atts['champ'] ] ) : '';
	} );
} );

/**
 * Fil d'Ariane de la page en cours : Accueil › parent › page.
 */
function briise_fil_ariane_html() {
	$post = get_queried_object();
	if ( ! $post instanceof WP_Post || (int) $post->ID === (int) get_option( 'page_on_front' ) ) {
		return '';
	}
	$liens = array( '<a href="' . esc_url( home_url( '/' ) ) . '">Accueil</a>' );
	if ( 'post' === $post->post_type && get_option( 'page_for_posts' ) ) {
		$liens[] = '<a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html( get_the_title( get_option( 'page_for_posts' ) ) ) . '</a>';
	}
	foreach ( array_reverse( get_post_ancestors( $post ) ) as $parent ) {
		$liens[] = '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( get_the_title( $parent ) ) . '</a>';
	}
	$liens[] = '<span aria-current="page">' . esc_html( get_the_title( $post ) ) . '</span>';
	return '<nav class="br-breadcrumb" aria-label="Fil d’Ariane">' . implode( ' <span aria-hidden="true">›</span> ', $liens ) . '</nav>';
}

/**
 * Villes de la zone d'intervention, en pastilles.
 */
function briise_zone_html() {
	$e = briise_entreprise();
	if ( ! $e['areas'] ) {
		return current_user_can( 'edit_pages' ) ? '<p class="br-a-remplacer">Ajoutez vos villes dans Mon entreprise &gt; Entreprise &gt; Zone d’intervention.</p>' : '';
	}
	$out = '<ul class="br-zone">';
	foreach ( $e['areas'] as $ville ) {
		$out .= '<li class="br-chip">' . esc_html( $ville ) . '</li>';
	}
	return $out . '</ul>';
}

/**
 * Appeler ou écrire en un geste : solution de repli quand il n'y a pas de formulaire.
 */
function briise_contact_rapide_html() {
	$e     = briise_entreprise();
	$liens = array();
	if ( $e['telephone'] ) {
		$liens[] = '<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="tel:' . esc_attr( $e['telephone'] ) . '">Appeler le ' . esc_html( briise_telephone_lisible( $e['telephone'] ) ) . '</a></div>';
	}
	if ( $e['email'] ) {
		$liens[] = '<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="mailto:' . esc_attr( antispambot( $e['email'] ) ) . '">Écrire un e-mail</a></div>';
	}
	return $liens ? '<div class="wp-block-buttons br-contact-rapide">' . implode( '', $liens ) . '</div>' : '';
}
