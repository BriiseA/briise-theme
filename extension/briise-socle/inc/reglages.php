<?php
/**
 * Réglages de l'entreprise : stockage, valeurs par défaut et nettoyage.
 *
 * Cinq options, une par onglet, pour qu'enregistrer un onglet n'efface
 * jamais les autres :
 * - briise_annonces : horaires, fermetures exceptionnelles, bandeau (éditeurs) ;
 * - briise_entreprise : identité, activité, coordonnées, réseaux, action principale ;
 * - briise_legal : mentions légales ;
 * - briise_fonctions : fonctions activables et mesure d'audience.
 *
 * Les fonctions de nettoyage acceptent la forme du formulaire comme la forme
 * stockée : WordPress les rappelle à chaque update_option().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const BRIISE_JOURS = array(
	1 => 'lundi',
	2 => 'mardi',
	3 => 'mercredi',
	4 => 'jeudi',
	5 => 'vendredi',
	6 => 'samedi',
	7 => 'dimanche',
);

/**
 * Fonctions activables : clé => [libellé, explication, valeur par défaut].
 */
function briise_fonctions_liste() {
	return array(
		'menu_remonte'  => array( 'Menu qui réapparaît en remontant', 'Le menu se cache quand on descend dans la page et revient dès qu’on remonte.', true ),
		'entete_flottant' => array( 'En-tête flottant', 'Le menu devient une barre arrondie, légèrement transparente, posée au-dessus de la page. Plus moderne ; à réserver aux sites avec de belles photos en haut de page.', false ),
		'bouton_mobile' => array( 'Bouton d’action fixe sur mobile', 'Rappelle l’action principale en bas de l’écran du téléphone ; il s’efface quand un autre bouton est déjà visible.', true ),
		'animations'    => array( 'Animations d’apparition', 'Apparitions douces au défilement. Toujours coupées si le visiteur a demandé à réduire les animations.', true ),
		'verrou'        => array( 'Verrouillage de l’accueil pour l’éditeur', 'L’éditeur modifie les textes et les images de l’accueil sans pouvoir casser sa structure. À désactiver pour un client autonome.', true ),
		'seo'           => array( 'Référencement intégré', 'Title, meta description, Open Graph, données structurées et plan du site. Se coupe seul si Yoast, Rank Math, SEOPress ou All in One SEO est installé.', true ),
		'blog'          => array( 'Blog', 'À activer seulement si le client publiera vraiment. Désactivé, le menu « Articles » disparaît et les articles sortent du plan du site.', false ),
		'horaires_jour' => array( 'Mise en avant du jour', 'Dans les horaires et les plannings, la ligne du jour est surlignée.', true ),
		'sommaire_faq'  => array( 'Sommaire des longues FAQ', 'À partir de 8 questions réparties en rubriques, un sommaire cliquable apparaît en haut de la page.', true ),
		'retour_haut'   => array( 'Bouton « retour en haut »', 'Apparaît sur les longues pages après deux écrans de défilement, au-dessus du bouton fixe mobile.', true ),
		'indexnow'      => array( 'Signaler les nouvelles pages à Bing (IndexNow)', 'Chaque page publiée ou modifiée est signalée aussitôt à Bing et aux moteurs qui partagent IndexNow. Bing alimente une partie des réponses de ChatGPT.', true ),
		'ia_entrainement' => array( 'Autoriser l’entraînement des IA', 'Décoché : les robots qui collectent des textes pour entraîner les IA (GPTBot, ClaudeBot, Google-Extended…) sont refusés. Les robots des moteurs de recherche IA restent toujours autorisés, sinon le site ne serait plus cité.', true ),
		'realisations'  => array( 'Réalisations', 'Le client publie ses réalisations (photos, ville, service) depuis le menu du même nom : la page des réalisations, l’accueil et les pages de service se mettent à jour seules. Le nom affiché se règle plus bas.', true ),
		'reseaux_icones' => array( 'Réseaux sociaux en icônes', 'Dans le pied de page, les réseaux s’affichent en icônes (nom lu par les lecteurs d’écran). Décoché : en texte.', true ),
		'photos_webp'   => array( 'Photos en WebP', 'Chaque photo JPEG ou PNG envoyée dans la médiathèque est enregistrée en WebP : 2 à 3 fois plus légère, même qualité à l’œil, pages plus rapides. Les photos de plus de 2 560 px sont réduites par WordPress.', true ),
		'securite'      => array( 'Protections de sécurité', 'Cache les identifiants de connexion, ferme XML-RPC, ajoute les en-têtes de sécurité, désactive l’éditeur de code et rend neutre le message d’erreur de connexion. À laisser activé, sauf si une application externe a besoin de XML-RPC.', true ),
		'credit'        => array( 'Crédit de l’agence en pied de page', 'Un petit lien « Site réalisé par Briise » en bas du pied de page, en nofollow (aucun risque pour le référencement du client). À activer seulement avec l’accord du client, prévu au contrat. Coupé automatiquement en fin de collaboration.', false ),
		'qualifications' => array( 'Qualifications et assurances', 'Les qualifications saisies dans l’onglet Entreprise (logo, numéro, lien « Vérifier ») s’affichent dans la section « Qualifications » et, si c’est coché, dans le pied de page. Décoché : elles disparaissent partout, sans être effacées.', true ),
		'bandeau'       => array( 'Bandeau d’information', 'Un message en haut du site (fermeture, nouveauté), avec date de fin. L’éditeur le gère dans l’onglet « Horaires et annonces ».', false ),
	);
}

/**
 * Noms proposés pour les réalisations (menu, page, adresse des fiches).
 */
function briise_realisations_noms() {
	return array( 'Réalisations', 'Portfolio', 'Chantiers', 'Projets' );
}

function briise_defauts( $option ) {
	switch ( $option ) {
		case 'briise_annonces':
			$jours = array();
			foreach ( BRIISE_JOURS as $n => $nom ) {
				$jours[ $n ] = array( 'ouvert' => false, 'plages' => array( array( '', '' ), array( '', '' ) ) );
			}
			return array(
				'jours'           => $jours,
				'note'            => '',
				'fermetures'      => array_fill( 0, 6, array( 'du' => '', 'au' => '', 'motif' => '' ) ),
				'annoncer'        => true,
				'bandeau_actif'   => false,
				'bandeau_texte'   => '',
				'bandeau_lien'    => '',
				'bandeau_url'     => '',
				'bandeau_fin'     => '',
				'dispo_date'      => '',
				'dispo_texte'     => 'Prochaines visites possibles',
				'dispo_maj'       => '',
			);
		case 'briise_entreprise':
			return array(
				'type'        => 'LocalBusiness',
				'description' => '',
				'email'       => get_option( 'admin_email' ),
				'destinataires' => array(),
				'telephone'   => '',
				'street'      => '',
				'postal_code' => '',
				'city'        => '',
				'country'     => 'FR',
				'latitude'    => '',
				'longitude'   => '',
				'price_range' => '',
				'areas'       => array(),
				'instagram'   => '',
				'facebook'    => '',
				'linkedin'    => '',
				'google'      => '',
				'tiktok'      => '',
				'youtube'     => '',
				'pinterest'   => '',
				'autres'      => array(),
				'cta_label'   => 'Nous contacter',
				'cta_page'    => 0,
				'cta_url'     => '',
				'person_name' => '',
				'person_job'  => '',
				'person_page' => 0,
				'faq_page'    => 0,
				'logo_clair'  => 0,
				'precision_telephone' => '',
				'precision_email'     => '',
				'precision_adresse'   => '',
				'badge_coord_titre'   => '',
				'badge_coord_texte'   => '',
				'badge_zone_titre'    => '',
				'badge_zone_texte'    => '',
				'zone_soustitre'      => '',
				'zone_secteurs'       => '',
				'zone_points'         => '',
				'zone_rayon'          => '',
				'qualifications'      => array(),
				'qualifs_pied'        => true,
			);
		case 'briise_legal':
			return array(
				'raison_sociale'   => '',
				'forme'            => '',
				'capital'          => '',
				'siren'            => '',
				'rcs'              => '',
				'tva'              => '',
				'siege'            => '',
				'directeur'        => '',
				'hebergeur_nom'    => '',
				'hebergeur_adresse' => '',
				'hebergeur_tel'    => '',
				'ordre'            => '',
				'titre_pro'        => '',
				'regles_url'       => '',
				'mediateur_nom'    => '',
				'mediateur_url'    => '',
				'realisation'      => 'Briise',
				'realisation_url'  => '',
			);
		case 'briise_fonctions':
			$out = array();
			foreach ( briise_fonctions_liste() as $cle => $f ) {
				$out[ $cle ] = $f[2];
			}
			return $out + array(
				'realisations_nom' => 'Réalisations',
				'credit_texte' => 'Site réalisé par',
				'matomo_url' => '',
				'matomo_id'  => '',
				'gsc'        => '',
				'bing'       => '',
			);
	}
	return array();
}

/**
 * Lecture d'une option complétée par ses valeurs par défaut.
 */
function briise_reglage( $option ) {
	$stocke = get_option( $option, array() );
	$defaut = briise_defauts( $option );
	if ( ! is_array( $stocke ) ) {
		return $defaut;
	}
	$out = array_merge( $defaut, array_intersect_key( $stocke, $defaut ) );
	if ( 'briise_annonces' === $option ) {
		foreach ( BRIISE_JOURS as $n => $nom ) {
			$out['jours'][ $n ] = isset( $stocke['jours'][ $n ] ) && is_array( $stocke['jours'][ $n ] ) ? $stocke['jours'][ $n ] + $defaut['jours'][ $n ] : $defaut['jours'][ $n ];
		}
	}
	return $out;
}

/**
 * Une fonction activable est-elle allumée ?
 */
function briise_fonction( $cle ) {
	$f = briise_reglage( 'briise_fonctions' );
	return (bool) apply_filters( 'briise_fonction', ! empty( $f[ $cle ] ), $cle );
}

/* ----- Nettoyage ------------------------------------------------------- */

function briise_nettoie_heure( $h ) {
	$h = trim( (string) $h );
	return preg_match( '/^([01]\d|2[0-3]):[0-5]\d$/', $h ) ? $h : '';
}

function briise_nettoie_date( $d ) {
	$d = trim( (string) $d );
	return preg_match( '/^\d{4}-\d{2}-\d{2}$/', $d ) && checkdate( (int) substr( $d, 5, 2 ), (int) substr( $d, 8, 2 ), (int) substr( $d, 0, 4 ) ) ? $d : '';
}

function briise_nettoie_lignes( $v ) {
	if ( is_string( $v ) ) {
		$v = preg_split( '/\r\n|\r|\n/', $v );
	}
	return array_values( array_filter( array_map( 'sanitize_text_field', (array) $v ) ) );
}

function briise_nettoie_annonces( $in ) {
	if ( ! is_array( $in ) ) {
		return get_option( 'briise_annonces', briise_defauts( 'briise_annonces' ) );
	}
	$out = briise_defauts( 'briise_annonces' );
	foreach ( BRIISE_JOURS as $n => $nom ) {
		$j = isset( $in['jours'][ $n ] ) ? (array) $in['jours'][ $n ] : array();
		$plages = array();
		for ( $i = 0; $i < 2; $i++ ) {
			$de = briise_nettoie_heure( $j['plages'][ $i ][0] ?? '' );
			$a  = briise_nettoie_heure( $j['plages'][ $i ][1] ?? '' );
			$plages[] = ( $de && $a && $a > $de ) ? array( $de, $a ) : array( '', '' );
		}
		$out['jours'][ $n ] = array(
			'ouvert' => ! empty( $j['ouvert'] ) && '' !== $plages[0][0] . $plages[1][0],
			'plages' => $plages,
		);
	}
	$out['note'] = sanitize_text_field( $in['note'] ?? '' );

	$fermetures = array();
	foreach ( (array) ( $in['fermetures'] ?? array() ) as $f ) {
		$du = briise_nettoie_date( $f['du'] ?? '' );
		$au = briise_nettoie_date( $f['au'] ?? '' );
		if ( $du && ( ! $au || $au < $du ) ) {
			$au = $du;
		}
		// Une fermeture passée libère sa ligne.
		if ( $du && $au >= wp_date( 'Y-m-d' ) ) {
			$fermetures[] = array( 'du' => $du, 'au' => $au, 'motif' => sanitize_text_field( $f['motif'] ?? '' ) );
		}
	}
	usort( $fermetures, function ( $a, $b ) {
		return strcmp( $a['du'], $b['du'] );
	} );
	$fermetures        = array_slice( $fermetures, 0, 6 );
	$out['fermetures'] = array_pad( $fermetures, 6, array( 'du' => '', 'au' => '', 'motif' => '' ) );
	$out['annoncer']   = ! empty( $in['annoncer'] );

	// Bandeau absent du formulaire (fonction désactivée) : on garde l'existant.
	if ( ! array_key_exists( 'bandeau_texte', $in ) ) {
		$avant = briise_reglage( 'briise_annonces' );
		foreach ( array( 'bandeau_actif', 'bandeau_texte', 'bandeau_lien', 'bandeau_url', 'bandeau_fin', 'dispo_date', 'dispo_texte', 'dispo_maj' ) as $cle ) {
			$out[ $cle ] = $avant[ $cle ];
		}
		return $out;
	}
	$out['bandeau_actif'] = ! empty( $in['bandeau_actif'] );
	$out['bandeau_texte'] = mb_substr( sanitize_text_field( $in['bandeau_texte'] ?? '' ), 0, 160 );
	$out['bandeau_lien']  = sanitize_text_field( $in['bandeau_lien'] ?? '' );
	$out['bandeau_url']   = esc_url_raw( $in['bandeau_url'] ?? '' );
	$out['bandeau_fin']   = briise_nettoie_date( $in['bandeau_fin'] ?? '' );

	// Disponibilités : la date de mise à jour sert à les retirer après 30 jours sans nouvelle.
	$avant              = briise_reglage( 'briise_annonces' );
	$out['dispo_date']  = briise_nettoie_date( $in['dispo_date'] ?? '' );
	$out['dispo_texte'] = mb_substr( sanitize_text_field( $in['dispo_texte'] ?? '' ), 0, 80 );
	if ( '' === $out['dispo_texte'] ) {
		$out['dispo_texte'] = 'Prochaines visites possibles';
	}
	$change            = $out['dispo_date'] !== $avant['dispo_date'] || $out['dispo_texte'] !== $avant['dispo_texte'] || ! empty( $in['dispo_confirmer'] );
	$out['dispo_maj']  = $out['dispo_date'] ? ( $change || ! $avant['dispo_maj'] ? briise_aujourdhui() : $avant['dispo_maj'] ) : '';
	return $out;
}

function briise_nettoie_entreprise( $in ) {
	if ( ! is_array( $in ) ) {
		return get_option( 'briise_entreprise', briise_defauts( 'briise_entreprise' ) );
	}
	// Le nom et le slogan sont ceux de WordPress (Réglages > Général) : une seule source.
	if ( isset( $in['name'] ) && '' !== trim( $in['name'] ) ) {
		update_option( 'blogname', sanitize_text_field( $in['name'] ) );
	}
	if ( isset( $in['logo'] ) ) {
		$logo = absint( $in['logo'] );
		if ( $logo && wp_attachment_is_image( $logo ) ) {
			set_theme_mod( 'custom_logo', $logo );
			update_option( 'site_logo', $logo );
		} else {
			remove_theme_mod( 'custom_logo' );
			delete_option( 'site_logo' );
		}
	}
	if ( isset( $in['slogan'] ) ) {
		update_option( 'blogdescription', sanitize_text_field( $in['slogan'] ) );
	}
	$types = briise_types_activite();
	$tel   = preg_replace( '/[^\d+]/', '', (string) ( $in['telephone'] ?? '' ) );
	if ( preg_match( '/^0[1-9]\d{8}$/', $tel ) ) {
		$tel = '+33' . substr( $tel, 1 );
	}
	$coord = function ( $v, $max ) {
		$v = str_replace( ',', '.', trim( (string) $v ) );
		return ( is_numeric( $v ) && abs( (float) $v ) <= $max ) ? (string) round( (float) $v, 6 ) : '';
	};
	return array(
		'type'        => isset( $types[ $in['type'] ?? '' ] ) ? $in['type'] : 'LocalBusiness',
		'description' => sanitize_textarea_field( $in['description'] ?? '' ),
		'email'       => sanitize_email( $in['email'] ?? '' ),
		'destinataires' => array_values( array_filter( array_map( 'sanitize_email', briise_nettoie_lignes( $in['destinataires'] ?? array() ) ), 'is_email' ) ),
		'telephone'   => $tel,
		'street'      => sanitize_text_field( $in['street'] ?? '' ),
		'postal_code' => sanitize_text_field( $in['postal_code'] ?? '' ),
		'city'        => sanitize_text_field( $in['city'] ?? '' ),
		'country'     => preg_match( '/^[A-Z]{2}$/', strtoupper( $in['country'] ?? '' ) ) ? strtoupper( $in['country'] ) : 'FR',
		'latitude'    => $coord( $in['latitude'] ?? '', 90 ),
		'longitude'   => $coord( $in['longitude'] ?? '', 180 ),
		'price_range' => sanitize_text_field( $in['price_range'] ?? '' ),
		'areas'       => briise_nettoie_lignes( $in['areas'] ?? array() ),
		'instagram'   => esc_url_raw( $in['instagram'] ?? '' ),
		'facebook'    => esc_url_raw( $in['facebook'] ?? '' ),
		'linkedin'    => esc_url_raw( $in['linkedin'] ?? '' ),
		'google'      => esc_url_raw( $in['google'] ?? '' ),
		'tiktok'      => esc_url_raw( $in['tiktok'] ?? '' ),
		'youtube'     => esc_url_raw( $in['youtube'] ?? '' ),
		'pinterest'   => esc_url_raw( $in['pinterest'] ?? '' ),
		'autres'      => array_values( array_filter( array_map( 'esc_url_raw', briise_nettoie_lignes( $in['autres'] ?? array() ) ) ) ),
		'cta_label'   => sanitize_text_field( $in['cta_label'] ?? '' ) ?: 'Nous contacter',
		'cta_page'    => absint( $in['cta_page'] ?? 0 ),
		'cta_url'     => esc_url_raw( $in['cta_url'] ?? '' ),
		'person_name' => sanitize_text_field( $in['person_name'] ?? '' ),
		'person_job'  => sanitize_text_field( $in['person_job'] ?? '' ),
		'person_page' => absint( $in['person_page'] ?? 0 ),
		'faq_page'    => absint( $in['faq_page'] ?? 0 ),
		'logo_clair'  => absint( $in['logo_clair'] ?? 0 ),
		'precision_telephone' => sanitize_text_field( $in['precision_telephone'] ?? '' ),
		'precision_email'     => sanitize_text_field( $in['precision_email'] ?? '' ),
		'precision_adresse'   => sanitize_text_field( $in['precision_adresse'] ?? '' ),
		'badge_coord_titre'   => sanitize_text_field( $in['badge_coord_titre'] ?? '' ),
		'badge_coord_texte'   => sanitize_text_field( $in['badge_coord_texte'] ?? '' ),
		'badge_zone_titre'    => sanitize_text_field( $in['badge_zone_titre'] ?? '' ),
		'badge_zone_texte'    => sanitize_text_field( $in['badge_zone_texte'] ?? '' ),
		'zone_soustitre'      => sanitize_text_field( $in['zone_soustitre'] ?? '' ),
		'zone_secteurs'       => sanitize_textarea_field( $in['zone_secteurs'] ?? '' ),
		'zone_points'         => sanitize_textarea_field( $in['zone_points'] ?? '' ),
		'zone_rayon'          => (string) absint( $in['zone_rayon'] ?? 0 ),
		'qualifications'      => briise_nettoie_qualifications( $in['qualifications'] ?? array() ),
		'qualifs_pied'        => array_key_exists( 'qualifs_pied', $in ) ? ! empty( $in['qualifs_pied'] ) : true,
	);
}

function briise_nettoie_legal( $in ) {
	if ( ! is_array( $in ) ) {
		return get_option( 'briise_legal', briise_defauts( 'briise_legal' ) );
	}
	$out = array();
	foreach ( briise_defauts( 'briise_legal' ) as $cle => $defaut ) {
		$v = $in[ $cle ] ?? '';
		if ( in_array( $cle, array( 'regles_url', 'mediateur_url', 'realisation_url' ), true ) ) {
			$out[ $cle ] = esc_url_raw( $v );
		} elseif ( in_array( $cle, array( 'siege', 'hebergeur_adresse' ), true ) ) {
			$out[ $cle ] = sanitize_textarea_field( $v );
		} else {
			$out[ $cle ] = sanitize_text_field( $v );
		}
	}
	return $out;
}

function briise_nettoie_fonctions( $in ) {
	if ( ! is_array( $in ) ) {
		return get_option( 'briise_fonctions', briise_defauts( 'briise_fonctions' ) );
	}
	$out = array();
	foreach ( briise_fonctions_liste() as $cle => $f ) {
		$out[ $cle ] = ! empty( $in[ $cle ] );
	}
	$out['realisations_nom'] = in_array( $in['realisations_nom'] ?? '', briise_realisations_noms(), true ) ? $in['realisations_nom'] : 'Réalisations';
	$out['credit_texte']     = sanitize_text_field( (string) ( $in['credit_texte'] ?? '' ) ) ?: 'Site réalisé par';
	$url = esc_url_raw( trim( (string) ( $in['matomo_url'] ?? '' ) ) );
	$out['matomo_url'] = $url ? trailingslashit( preg_replace( '#/(matomo|piwik)\.(php|js)$#', '', $url ) ) : '';
	$out['matomo_id']  = absint( $in['matomo_id'] ?? 0 ) ?: '';
	$gsc = (string) ( $in['gsc'] ?? '' );
	if ( preg_match( '/content=["\']([^"\']+)["\']/', $gsc, $m ) ) {
		$gsc = $m[1];
	}
	$out['gsc'] = preg_replace( '/[^A-Za-z0-9_\-]/', '', $gsc );
	$bing = (string) ( $in['bing'] ?? '' );
	if ( preg_match( '/content=["\']([^"\']+)["\']/', $bing, $m ) ) {
		$bing = $m[1];
	}
	$out['bing'] = preg_replace( '/[^A-Za-z0-9]/', '', $bing );
	return $out;
}

/* ----- Enregistrement --------------------------------------------------- */

add_action( 'init', function () {
	$groupes = array(
		'briise_annonces'   => 'briise_nettoie_annonces',
		'briise_entreprise' => 'briise_nettoie_entreprise',
		'briise_legal'      => 'briise_nettoie_legal',
		'briise_fonctions'  => 'briise_nettoie_fonctions',
	);
	foreach ( $groupes as $option => $nettoie ) {
		register_setting( $option, $option, array(
			'type'              => 'array',
			'sanitize_callback' => $nettoie,
			'default'           => briise_defauts( $option ),
			'show_in_rest'      => false,
		) );
	}
} );

// Horaires et annonces : modifiables par l'éditeur. Le reste : administrateurs.
add_filter( 'option_page_capability_briise_annonces', function () {
	return 'edit_others_pages';
} );

/**
 * Types d'activité proposés (schema.org), avec un libellé lisible.
 */
function briise_types_activite() {
	return apply_filters( 'briise_types_activite', array(
		'LocalBusiness'               => 'Entreprise locale (générique)',
		'ProfessionalService'         => 'Service aux professionnels ou aux particuliers',
		'HomeAndConstructionBusiness' => 'Bâtiment et habitat : métallier, menuisier, maçon…',
		'GeneralContractor'           => 'Entreprise générale du bâtiment',
		'Electrician'                 => 'Électricien',
		'Plumber'                     => 'Plombier, chauffagiste',
		'HVACBusiness'                => 'Climatisation, ventilation',
		'HousePainter'                => 'Peintre en bâtiment',
		'RoofingContractor'           => 'Couvreur',
		'Locksmith'                   => 'Serrurier (dépannage, serrures)',
		'MovingCompany'               => 'Déménageur',
		'AutoRepair'                  => 'Garage, réparation automobile',
		'Attorney'                    => 'Avocat',
		'Notary'                      => 'Notaire',
		'AccountingService'           => 'Expert-comptable',
		'InsuranceAgency'             => 'Agence d’assurance',
		'RealEstateAgent'             => 'Agence immobilière',
		'Physician'                   => 'Médecin',
		'Dentist'                     => 'Dentiste',
		'Physiotherapy'               => 'Kinésithérapeute, ostéopathe',
		'Optician'                    => 'Opticien',
		'MedicalClinic'               => 'Cabinet ou centre médical',
		'HealthAndBeautyBusiness'     => 'Bien-être, soins (générique)',
		'BeautySalon'                 => 'Institut de beauté',
		'HairSalon'                   => 'Coiffeur',
		'NailSalon'                   => 'Prothésiste ongulaire',
		'DaySpa'                      => 'Spa',
		'ExerciseGym'                 => 'Salle de sport, studio de yoga ou de pilates',
		'SportsActivityLocation'      => 'Lieu d’activité sportive',
		'Restaurant'                  => 'Restaurant',
		'CafeOrCoffeeShop'            => 'Café, salon de thé',
		'Bakery'                      => 'Boulangerie, pâtisserie',
		'BarOrPub'                    => 'Bar',
		'Store'                       => 'Commerce (générique)',
		'Florist'                     => 'Fleuriste',
		'ClothingStore'               => 'Boutique de vêtements',
		'BedAndBreakfast'             => 'Chambres d’hôtes',
		'Hotel'                       => 'Hôtel',
		'ChildCare'                   => 'Garde d’enfants, crèche',
		'TravelAgency'                => 'Agence de voyages',
		'EntertainmentBusiness'       => 'Loisirs, divertissement',
	) );
}

/**
 * Crédit de l'agence : « Site réalisé par Briise », lien de marque en nofollow.
 * Vide si la fonction est désactivée (par défaut, et après la fin de collaboration).
 */
function briise_credit_html() {
	if ( ! briise_fonction( 'credit' ) ) {
		return '';
	}
	$f     = get_option( 'briise_fonctions', array() );
	$texte = trim( (string) ( $f['credit_texte'] ?? '' ) ) ?: 'Site réalisé par';
	return '<span class="br-credit">' . esc_html( $texte ) . ' <a href="https://briise.fr" rel="nofollow">Briise</a></span>';
}
