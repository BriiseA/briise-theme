<?php
/**
 * Apparence : variantes d'en-tête, de pied de page et de barre mobile.
 *
 * Réglées dans Mon entreprise > Apparence, ou par le fichier de site
 * (clés « entete », « pied », « mobile », « cartes » et « titres »). Rien ne change
 * pour un site qui ne les règle pas : en-tête classique, pied en colonnes,
 * bouton fixe, cartes à photo en fond, titre et lien.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_apparence_choix() {
	return array(
		'entete' => array(
			'classique'   => array( 'Classique', 'Logo à gauche, menu, téléphone et bouton à droite.' ),
			'capsule'     => array( 'Capsule flottante', 'Le menu dans une capsule sombre au centre. Sur une page qui s’ouvre sur une grande photo, il flotte au-dessus.' ),
			'ilots'       => array( 'Îlots', 'Logo, menu et actions séparés en îlots semi-transparents. Idéal sur de belles photos.' ),
			'logo-centre' => array( 'Logo au centre', 'Liens en pastilles à gauche, logo au centre, disponibilité et bouton à droite.' ),
			'medaillon'   => array( 'Médaillon', 'Barre sombre arrondie et logo rond au centre, qui déborde. Pour un logo rond ou carré.' ),
			'encadre'     => array( 'Encadré', 'Toute la page dans un cadre arrondi, menu classique.' ),
			'bandeau'     => array( 'Bandeau', 'Bande teintée pleine largeur, liens en petites capitales espacées.' ),
			'barre-infos' => array( 'Barre d’infos', 'Au-dessus du menu : ouvert ou fermé aujourd’hui, disponibilité, zone et téléphone. Pour le dépannage et les commerces.' ),
		),
		'pied'   => array(
			'colonnes'    => array( 'Colonnes', 'Services, contact, horaires en colonnes (pied d’origine).' ),
			'grand-titre' => array( 'Grand titre', 'Carte sombre arrondie, nom et slogan en grand, liens séparés par des filets.' ),
			'logo-geant'  => array( 'Nom géant', 'Colonnes en haut, le nom de l’entreprise en très grand en bas. Pour un nom court.' ),
			'grand-appel' => array( 'Grand appel', 'Le téléphone en très grand, le bouton et l’itinéraire.' ),
			'carte'       => array( 'Plan et horaires', 'Une image du plan (photo « plan » dans la Médiathèque), les horaires et les coordonnées.' ),
			'compact'     => array( 'Compact', 'Une seule bande : nom, liens, téléphone.' ),
		),
		'mobile' => array(
			'bouton' => array( 'Bouton fixe', 'Appeler et l’action principale, en bas de l’écran du téléphone.' ),
			'barre'  => array( 'Barre d’actions', 'Trois actions en bas de l’écran : Appeler, l’action principale et Itinéraire.' ),
		),
		'cartes' => array(
			'photo-fond'  => array( 'Photo en fond', 'La photo remplit la carte, le texte est posé dessus (cartes d’origine).' ),
			'photo-haut'  => array( 'Photo en haut', 'La photo en haut, le texte dessous sur fond clair. Plus sobre, plus lisible.' ),
			'liste-filet' => array( 'Liste à filets', 'Une ligne par service, séparée par un filet, avec une vignette. Pour une offre large ou un style éditorial.' ),
		),
		'titres' => array(
			'tete-lien'          => array( 'Titre et lien', 'Le titre à gauche, le lien « Tous nos… » à droite (titres d’origine).' ),
			'tete-deux-colonnes' => array( 'Titre et texte côte à côte', 'Le titre à gauche, la phrase d’introduction à droite.' ),
			'grand-numero'       => array( 'Grand numéro', 'Chaque section numérotée en grand au-dessus de son titre (01, 02…). Pour une page qui se lit comme un récit.' ),
			'marge'              => array( 'Titre en marge', 'Sur ordinateur, le titre de la section dans une colonne à gauche, le contenu à droite. Sur téléphone, tout s’empile. Pour un site précis, presque éditorial.' ),
		),
		'cartes_mobile' => array(
			'empilees'   => array( 'Empilées', 'Les cartes les unes sous les autres, toutes les photos des galeries (d’origine).' ),
			'defilement' => array( 'En défilement', 'Les rangées de trois cartes ou plus se font glisser de gauche à droite, et les galeries montrent quatre photos puis un bouton pour voir les autres. La page est plus courte ; rien n’est retiré.' ),
		),
		'angles'        => array(
			'ambiance' => array( 'Selon l’ambiance', 'Les arrondis prévus par l’ambiance.' ),
			'doux'     => array( 'Doux', 'Des arrondis plus discrets sur les cartes, les photos et les boutons.' ),
			'droits'   => array( 'Droits', 'Angles droits partout : cartes, photos, boutons, pastilles. Seuls les ronds voulus (numéros d’étapes, points) le restent.' ),
		),
		'relief'        => array(
			'ombre'   => array( 'Ombre', 'Les cartes portent une ombre douce (d’origine).' ),
			'bordure' => array( 'Bordure', 'Ni ombre ni flou : un trait net de la couleur du texte autour des cartes.' ),
			'plat'    => array( 'À plat', 'Ni ombre ni bordure : les cartes se détachent seulement par leur fond.' ),
		),
		'etiquettes'    => array(
			'texte'      => array( 'Texte', 'Les petites étiquettes au-dessus des titres, telles quelles (d’origine).' ),
			'numerotees' => array( 'Numérotées', '« 01 / Interventions », « 02 / Votre appel »… numérotées dans l’ordre de la page, dans la police des chiffres si elle est choisie.' ),
		),
		'surlignage'    => array(
			'couleur' => array( 'Couleur', 'Le mot surligné d’un titre prend la couleur d’accent (d’origine).' ),
			'aplat'   => array( 'Aplat', 'Le mot surligné d’un titre est posé sur un fond plein, de la couleur de décor (comme un marqueur).' ),
		),
		'capitales' => array(
			'ambiance' => array( 'Selon l’ambiance', 'Capitales avec l’ambiance Acier, minuscules avec les autres.' ),
			'oui'      => array( 'Oui', 'Les grands titres (H1 et H2) en capitales, un peu plus petits pour que les mots longs tiennent sur téléphone. Les petits titres restent en minuscules.' ),
			'non'      => array( 'Non', 'Pas de capitales, même avec l’ambiance Acier.' ),
		),
	);
}

function briise_apparence( $cle ) {
	$choix  = briise_apparence_choix();
	$defaut = array( 'entete' => 'classique', 'pied' => 'colonnes', 'mobile' => 'bouton', 'cartes' => 'photo-fond', 'titres' => 'tete-lien', 'capitales' => 'ambiance', 'cartes_mobile' => 'empilees', 'angles' => 'ambiance', 'relief' => 'ombre', 'etiquettes' => 'texte', 'surlignage' => 'couleur' );
	$v      = (array) get_option( 'briise_apparence', array() );
	$val    = $v[ $cle ] ?? $defaut[ $cle ];
	return isset( $choix[ $cle ][ $val ] ) ? $val : $defaut[ $cle ];
}

function briise_apparence_enregistrer( $valeurs ) {
	$choix = briise_apparence_choix();
	$out   = (array) get_option( 'briise_apparence', array() );
	foreach ( array_keys( $choix ) as $cle ) {
		if ( isset( $valeurs[ $cle ] ) && isset( $choix[ $cle ][ $valeurs[ $cle ] ] ) ) {
			$out[ $cle ] = $valeurs[ $cle ];
		}
	}
	update_option( 'briise_apparence', $out );
}

/**
 * La page s'ouvre-t-elle sur une grande photo (bannière pleine largeur) ?
 * Les en-têtes capsule, îlots et bandeau flottent alors au-dessus.
 */
function briise_page_sur_photo() {
	static $r = null;
	if ( null !== $r ) {
		return $r;
	}
	$r = false;
	if ( ! is_singular( 'page' ) && ! is_front_page() ) {
		return $r;
	}
	$id = get_queried_object_id();
	if ( ! $id ) {
		return $r;
	}
	foreach ( parse_blocks( (string) get_post_field( 'post_content', $id ) ) as $b ) {
		if ( empty( $b['blockName'] ) ) {
			continue;
		}
		$r = (bool) preg_match( '/\bbr-(banniere|ouv-plein)\b/', $b['attrs']['className'] ?? '' );
		break;
	}
	return $r;
}

add_filter( 'body_class', function ( $classes ) {
	$e = briise_apparence( 'entete' );
	$classes[] = 'br-entete--' . $e;
	$classes[] = 'br-pied--' . briise_apparence( 'pied' );
	$classes[] = 'br-mobile--' . briise_apparence( 'mobile' );
	$classes[] = 'br-cartes--' . briise_apparence( 'cartes' );
	$classes[] = 'br-titres--' . briise_apparence( 'titres' );
	$classes[] = 'br-capitales--' . briise_apparence( 'capitales' );
	$classes[] = 'br-cartes-mobile--' . briise_apparence( 'cartes_mobile' );
	foreach ( array( 'angles', 'relief', 'etiquettes', 'surlignage' ) as $cle ) {
		$classes[] = 'br-' . $cle . '--' . briise_apparence( $cle );
	}
	if ( in_array( $e, array( 'capsule', 'ilots', 'bandeau' ), true ) && briise_page_sur_photo() ) {
		$classes[] = 'br-sur-photo';
	}
	return $classes;
} );

add_action( 'wp_enqueue_scripts', function () {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'briise-variantes', get_theme_file_uri( 'assets/css/variantes.css' ), array( 'briise-ux' ), $version );
	wp_style_add_data( 'briise-variantes', 'path', get_theme_file_path( 'assets/css/variantes.css' ) );
	wp_enqueue_style( 'briise-sections', get_theme_file_uri( 'assets/css/sections.css' ), array( 'briise-ux' ), $version );
	wp_enqueue_script( 'briise-sections', get_theme_file_uri( 'assets/js/sections.js' ), array(), $version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
} );

/** Classes de personnalité actives (celles qui ne sont pas la valeur par défaut). */
function briise_personnalite_classes() {
	$defaut  = array( 'angles' => 'ambiance', 'relief' => 'ombre', 'etiquettes' => 'texte', 'surlignage' => 'couleur' );
	$classes = array();
	foreach ( $defaut as $cle => $valeur ) {
		if ( briise_apparence( $cle ) !== $valeur ) {
			$classes[] = 'br-' . $cle . '--' . briise_apparence( $cle );
		}
	}
	if ( 'marge' === briise_apparence( 'titres' ) ) {
		$classes[] = 'br-titres--marge';
	}
	if ( function_exists( 'briise_polices' ) && '' !== briise_polices()['chiffres'] ) {
		$classes[] = 'br-police-chiffres';
	}
	return $classes;
}

// Personnalité : sur le site, la feuille entière (ses règles dépendent des classes de <body>).
add_action( 'wp_enqueue_scripts', function () {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'briise-personnalite', get_theme_file_uri( 'assets/css/personnalite.css' ), array( 'briise-sections', 'briise-variantes' ), $version );
	wp_style_add_data( 'briise-personnalite', 'path', get_theme_file_path( 'assets/css/personnalite.css' ) );
}, 20 );

// Dans l'éditeur, les réglages actifs s'appliquent aussi : leurs classes deviennent .editor-styles-wrapper.
add_action( 'enqueue_block_assets', function () {
	if ( ! is_admin() ) {
		return;
	}
	$actives = briise_personnalite_classes();
	if ( ! $actives ) {
		return;
	}
	$css = (string) file_get_contents( get_theme_file_path( 'assets/css/personnalite.css' ) );
	foreach ( $actives as $classe ) {
		$css = preg_replace( '/\.' . preg_quote( $classe, '/' ) . '(?![\w-])/', '.editor-styles-wrapper', $css );
	}
	wp_register_style( 'briise-personnalite-editeur', false, array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'briise-personnalite-editeur' );
	wp_add_inline_style( 'briise-personnalite-editeur', $css );
} );

// Les nouvelles sections s'affichent aussi correctement dans l'éditeur.
add_action( 'after_setup_theme', function () {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/sections.css' );
} );

/* ----- Petites briques communes aux en-têtes et pieds ------------------------ */

function briise_tel_url( $tel ) {
	$url = preg_replace( '/[^\d+]/', '', (string) $tel );
	return 0 === strpos( $url, '0' ) ? '+33' . substr( $url, 1 ) : $url;
}

/** Lien d'itinéraire vers l'adresse de l'entreprise (vide sans adresse). */
function briise_itineraire_url() {
	if ( function_exists( 'briise_lien_itineraire' ) ) {
		return (string) briise_lien_itineraire();
	}
	$e   = briise_theme_entreprise();
	$adr = trim( implode( ' ', array_filter( array( $e['street'] ?? '', $e['postal_code'] ?? '', $e['city'] ?? '' ) ) ) );
	if ( ! $adr ) {
		return '';
	}
	return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( ( $e['name'] ?? '' ) . ' ' . $adr );
}

/** Horaires de la semaine pour le « ouvert aujourd'hui » calculé dans le navigateur (le cache de page ne le fige pas). */
function briise_horaires_json() {
	if ( ! function_exists( 'briise_reglage' ) ) {
		return '';
	}
	$a   = briise_reglage( 'briise_annonces' );
	$out = array();
	foreach ( (array) ( $a['jours'] ?? array() ) as $n => $j ) {
		$plages = array();
		if ( ! empty( $j['ouvert'] ) ) {
			foreach ( (array) $j['plages'] as $p ) {
				if ( ! empty( $p[0] ) && ! empty( $p[1] ) ) {
					$plages[] = array( $p[0], $p[1] );
				}
			}
		}
		$out[ (int) $n % 7 ] = $plages;
	}
	return $out ? wp_json_encode( $out ) : '';
}

function briise_theme_icone( $nom ) {
	$i = array(
		'tel'   => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/>',
		'devis' => '<path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><path d="M14 3v6h6M8 13h8M8 17h5"/>',
		'lieu'  => '<path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
	);
	return '<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' . ( $i[ $nom ] ?? '' ) . '</svg>';
}

/* ----- Onglet « Apparence » de Mon entreprise -------------------------------- */

add_filter( 'briise_onglets', function ( $onglets ) {
	$avant = array_slice( $onglets, 0, array_search( 'controle', array_keys( $onglets ), true ), true );
	return $avant + array( 'apparence' => array( 'Apparence', 'manage_options', '', 'briise_onglet_apparence' ) ) + $onglets;
} );

add_action( 'admin_post_briise_apparence', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'briise_apparence' ) ) {
		wp_die( 'Accès refusé.' );
	}
	briise_apparence_enregistrer( array_map( 'sanitize_key', wp_unslash( (array) ( $_POST['apparence'] ?? array() ) ) ) );
	if ( function_exists( 'briise_polices_enregistrer' ) ) {
		$polices                    = array_map( 'sanitize_text_field', wp_unslash( (array) ( $_POST['polices'] ?? array() ) ) );
		$polices['accent_italique'] = ! empty( $polices['accent_italique'] );
		briise_polices_enregistrer( $polices );
	}
	wp_safe_redirect( admin_url( 'admin.php?page=briise-entreprise&onglet=apparence&ok=1' ) );
	exit;
} );

function briise_onglet_apparence() {
	if ( isset( $_GET['ok'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		echo '<div class="notice notice-success"><p>Apparence enregistrée.</p></div>';
	}
	$titres = array( 'entete' => 'En-tête', 'pied' => 'Pied de page', 'mobile' => 'Sur téléphone', 'cartes' => 'Cartes de service', 'titres' => 'Titres de section', 'capitales' => 'Titres en capitales', 'cartes_mobile' => 'Sur téléphone, cartes et galeries', 'angles' => 'Personnalité : angles', 'relief' => 'Personnalité : relief des cartes', 'etiquettes' => 'Personnalité : étiquettes de section', 'surlignage' => 'Personnalité : mot surligné dans un titre' );
	echo '<p>Ces choix changent la forme de l’en-tête, du pied de page, du bas d’écran sur téléphone, des cartes de service, des titres de section et les polices, sur tout le site. Les textes, le téléphone et le bouton viennent toujours de Mon entreprise ; le contenu des pages ne change pas.</p>';
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	wp_nonce_field( 'briise_apparence' );
	echo '<input type="hidden" name="action" value="briise_apparence">';
	foreach ( briise_apparence_choix() as $cle => $options ) {
		echo '<fieldset style="margin:1.5rem 0"><legend style="font-size:1.1em;font-weight:600;margin-bottom:.5rem">' . esc_html( $titres[ $cle ] ) . '</legend>';
		foreach ( $options as $val => $o ) {
			printf(
				'<label style="display:block;margin:.4rem 0"><input type="radio" name="apparence[%1$s]" value="%2$s" %3$s> <strong>%4$s</strong> : %5$s</label>',
				esc_attr( $cle ),
				esc_attr( $val ),
				checked( briise_apparence( $cle ), $val, false ),
				esc_html( $o[0] ),
				esc_html( $o[1] )
			);
		}
		echo '</fieldset>';
	}
	if ( function_exists( 'briise_polices_formulaire' ) ) {
		briise_polices_formulaire();
	}
	submit_button( 'Enregistrer' );
	echo '</form>';
}
