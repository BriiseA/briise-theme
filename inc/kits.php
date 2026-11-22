<?php
/**
 * Démarrage d'un site : kits sur mesure et import d'un fichier de site.
 *
 * Tout passe par un « plan » : la liste des pages (avec parent, contenu, menu,
 * référencement) et les réglages qui les relient. Un kit réglé à l'écran ou un
 * fichier de site préparé par l'agence produisent le même plan, installé par
 * briise_plan_installer(). Une page dont l'adresse existe déjà n'est jamais modifiée.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_kits() {
	static $data = null;
	if ( null === $data ) {
		$data = json_decode( (string) file_get_contents( get_theme_file_path( 'inc/kits.json' ) ), true );
	}
	return $data;
}

/**
 * Remplace les repères ({{CTA}}, {{URL:…}}, {{IMG:…}}, {{TITRE}}) par les vraies valeurs.
 */
function briise_kit_remplir( $markup, $liens = array(), $pages = array(), $titre = '', &$manquants = array() ) {
	$e = briise_theme_entreprise();
	// Sans liens fournis (modèles de l'éditeur), ceux du kit installé.
	if ( ! $liens ) {
		$kits  = briise_kits()['kits'];
		$kit   = get_option( 'briise_kit' );
		$liens = isset( $kits[ $kit ] ) ? $kits[ $kit ]['liens'] : array();
	}
	$url = function ( $slug ) use ( $liens, $pages, &$manquants ) {
		$cible = $liens[ $slug ] ?? $slug;
		if ( isset( $pages[ $cible ] ) ) {
			return get_permalink( $pages[ $cible ] );
		}
		$existe = get_page_by_path( $cible );
		if ( $existe && 'publish' === $existe->post_status ) {
			return get_permalink( $existe );
		}
		if ( ! $pages ) {
			return home_url( '/' . $cible . '/' );
		}
		// Page non retenue : le lien mène à la page des services, sinon à l'accueil.
		$manquants[ $cible ] = true;
		$repli               = $liens['services'] ?? '';
		return isset( $pages[ $repli ] ) ? get_permalink( $pages[ $repli ] ) : home_url( '/' );
	};
	// Photos : celles du fichier de site (« images » : nom => adresse), sinon l'image d'exemple du thème.
	$images = $liens['__images'] ?? array();
	$markup = preg_replace_callback( '/\{\{IMG:([a-z0-9-]+)\}\}/', function ( $m ) use ( $images ) {
		if ( ! empty( $images[ $m[1] ] ) ) {
			$u = $images[ $m[1] ];
			return esc_url( 0 === strpos( $u, '/' ) ? home_url( $u ) : $u );
		}
		$nom = file_exists( get_theme_file_path( 'assets/images/sections/' . $m[1] . '.svg' ) ) ? $m[1] : 'carre';
		return esc_url( get_theme_file_uri( 'assets/images/sections/' . $nom . '.svg' ) );
	}, $markup );
	// Les services du client, dans l'ordre : {{SERVICE:n}} (nom) et {{URL:service-n}} (page).
	$services = $liens['__services'] ?? array();
	$markup   = preg_replace_callback( '/\{\{URL:service-(\d)\}\}/', function ( $m ) use ( $services, $pages, $url ) {
		$s = $services[ $m[1] - 1 ] ?? null;
		return esc_url( $s && isset( $pages[ $s['slug'] ] ) ? get_permalink( $pages[ $s['slug'] ] ) : $url( 'services' ) );
	}, $markup );
	$markup = preg_replace_callback( '/\{\{SERVICE:(\d)\}\}/', function ( $m ) use ( $services ) {
		$ordinaux = array( 'Premier', 'Deuxième', 'Troisième', 'Quatrième', 'Cinquième', 'Sixième', 'Septième', 'Huitième', 'Neuvième' );
		return esc_html( $services[ $m[1] - 1 ]['titre'] ?? ( $ordinaux[ $m[1] - 1 ] . ' service' ) );
	}, $markup );
	$markup = preg_replace_callback( '/\{\{URL:([a-z0-9-]*)\}\}/', function ( $m ) use ( $url ) {
		return esc_url( '' === $m[1] ? home_url( '/' ) : $url( $m[1] ) );
	}, $markup );
	return str_replace(
		array( '{{CTA_LABEL}}', '{{CTA}}', '{{TITRE}}' ),
		array( esc_html( $e['cta_label'] ), esc_url( $e['cta_url'] ), esc_html( '' !== $titre ? $titre : 'Le titre de la page' ) ),
		$markup
	);
}

/* ----- Installation d'un plan ---------------------------------------------------- */

/**
 * Installe un plan. Retourne [ 'crees' => [titres], 'gardes' => [titres] ].
 */
function briise_plan_installer( $plan ) {
	$statut = ( $plan['statut'] ?? 'publish' ) === 'draft' ? 'draft' : 'publish';
	$ids    = array();
	$crees  = array();
	$gardes = array();

	// 1. Réglages fournis par un fichier de site (passent par le nettoyage habituel).
	foreach ( array( 'entreprise' => 'briise_entreprise', 'legal' => 'briise_legal', 'annonces' => 'briise_annonces', 'fonctions' => 'briise_fonctions' ) as $cle => $option ) {
		if ( ! empty( $plan[ $cle ] ) && is_array( $plan[ $cle ] ) ) {
			update_option( $option, array_merge( briise_reglage( $option ), $plan[ $cle ] ) );
		}
	}

	// Lieux du formulaire de réservation (« Au studio », « Chez vous »…).
	if ( ! empty( $plan['reservation_lieux'] ) && is_array( $plan['reservation_lieux'] ) ) {
		update_option( 'briise_reservation_lieux', array_values( array_filter( array_map( 'sanitize_text_field', $plan['reservation_lieux'] ) ) ) );
	}

	// 2. Les pages, vides pour l'instant : il faut leurs adresses pour relier les liens.
	foreach ( $plan['pages'] as $i => $p ) {
		$slug   = sanitize_title( $p['slug'] );
		$parent = ! empty( $p['parent'] ) ? ( $ids[ $p['parent'] ] ?? 0 ) : 0;
		$chemin = $parent ? get_page_uri( $parent ) . '/' . $slug : $slug;
		$existe = get_page_by_path( $chemin, OBJECT, 'page' );
		if ( $existe && 'trash' !== $existe->post_status ) {
			$ids[ $slug ] = $existe->ID;
			$gardes[]     = $p['titre'];
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => $statut,
			'post_title'  => sanitize_text_field( $p['titre'] ),
			'post_name'   => $slug,
			'post_parent' => $parent,
			'menu_order'  => $i,
		), true );
		if ( ! is_wp_error( $id ) ) {
			$ids[ $slug ] = $id;
			$crees[ $id ] = $p;
		}
	}

	// 3. Les liens entre les pages.
	$e = briise_reglage( 'briise_entreprise' );
	if ( ! empty( $plan['cta'] ) && ! empty( $ids[ $plan['cta'] ] ) ) {
		$e['cta_page'] = $ids[ $plan['cta'] ];
		$e['cta_url']  = '';
	}
	if ( ! empty( $plan['cta_label'] ) ) {
		$e['cta_label'] = $plan['cta_label'];
	}
	if ( ! empty( $plan['personne'] ) && ! empty( $ids[ $plan['personne'] ] ) ) {
		$e['person_page'] = $ids[ $plan['personne'] ];
	}
	if ( ! empty( $plan['faq'] ) && ! empty( $ids[ $plan['faq'] ] ) ) {
		$e['faq_page'] = $ids[ $plan['faq'] ];
	}
	update_option( 'briise_entreprise', $e );

	// 4. Le contenu et le référencement des pages créées.
	$manquants = array();
	// Les services : sous-pages de la page des services (à défaut, de la page qui a le plus de sous-pages).
	$liens   = $plan['liens'] ?? array();
	$liens['__images'] = array_map( 'sanitize_text_field', (array) ( $plan['images'] ?? array() ) );
	$parents = array_count_values( array_filter( array_column( $plan['pages'], 'parent' ) ) );
	$p_serv  = $liens['services'] ?? ( $parents ? array_search( max( $parents ), $parents, true ) : '' );
	$liens['__services'] = array();
	foreach ( $plan['pages'] as $p ) {
		if ( $p_serv && ( $p['parent'] ?? '' ) === $p_serv && ( $p['modele'] ?? '' ) !== 'atterrissage' ) {
			$liens['__services'][] = array( 'titre' => $p['titre'], 'slug' => sanitize_title( $p['slug'] ) );
		}
	}
	if ( $p_serv && empty( $liens['services'] ) ) {
		$liens['services'] = $p_serv;
	}
	foreach ( $crees as $id => $p ) {
		if ( ! empty( $p['markup'] ) ) {
			wp_update_post( wp_slash( array(
				'ID'           => $id,
				'post_content' => briise_kit_remplir( $p['markup'], $liens, $ids, $p['titre'], $manquants ),
			) ) );
			if ( ! empty( $p['template'] ) && in_array( $p['template'], array( 'page-sans-titre', 'page-atterrissage' ), true ) ) {
				update_post_meta( $id, '_wp_page_template', $p['template'] );
			} elseif ( preg_match( '/br-page-head|br-banniere|br-hero|br-tete/', $p['markup'] ) ) {
				update_post_meta( $id, '_wp_page_template', 'page-sans-titre' );
			}
		}
		if ( ! empty( $p['seo_titre'] ) ) {
			update_post_meta( $id, '_briise_seo_title', sanitize_text_field( $p['seo_titre'] ) );
		}
		if ( ! empty( $p['seo_description'] ) ) {
			update_post_meta( $id, '_briise_seo_desc', sanitize_textarea_field( $p['seo_description'] ) );
		}
		if ( ! empty( $p['menu_description'] ) ) {
			// Une courte ligne sous le lien, dans le sous-menu (facultatif).
			update_post_meta( $id, '_briise_menu_desc', sanitize_text_field( $p['menu_description'] ) );
		}
	}

	// 5. Accueil, blog, confidentialité.
	if ( ! empty( $plan['accueil'] ) && ! empty( $ids[ $plan['accueil'] ] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids[ $plan['accueil'] ] );
	}
	if ( ! empty( $plan['blog'] ) && ! empty( $ids[ $plan['blog'] ] ) ) {
		update_option( 'page_for_posts', $ids[ $plan['blog'] ] );
		$f         = briise_reglage( 'briise_fonctions' );
		$f['blog'] = true;
		update_option( 'briise_fonctions', $f );
	}
	if ( ! empty( $ids['confidentialite'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $ids['confidentialite'] );
	}

	// 6. Le menu : les pages prévues au menu, dans l'ordre ; les sous-pages en sous-menu.
	// D'abord, retirer le menu automatique de WordPress (liste de toutes les pages), y compris
	// sur un site déjà importé.
	if ( array_filter( array_column( $plan['pages'], 'menu' ) ) ) {
		$menu_id = briise_menu_id( true );
		briise_menu_enregistrer( $menu_id, briise_menu_blocs( $menu_id ) );
	}
	foreach ( $crees as $id => $p ) {
		if ( empty( $p['menu'] ) ) {
			continue;
		}
		if ( 'publish' === $statut ) {
			briise_menu_definir( $id, true );
		} else {
			update_post_meta( $id, '_briise_menu_attente', '1' );
		}
	}

	// 7. Réalisations (extension Briise Socle), après les pages : chacune retrouve son service.
	$realisations = array();
	if ( ! empty( $plan['realisations'] ) && function_exists( 'briise_realisations_importer' ) ) {
		// Les liens et photos écrits dans une fiche ({{URL:…}}, {{IMG:…}}) sont remplis comme ceux des pages.
		$fiches = array_map( function ( $r ) use ( $liens, $ids ) {
			if ( ! empty( $r['markup'] ) ) {
				$r['markup'] = briise_kit_remplir( $r['markup'], $liens, $ids, $r['titre'] ?? '' );
			}
			return $r;
		}, (array) $plan['realisations'] );
		$realisations = briise_realisations_importer( $fiches, $statut );
	}

	// 8. Formulaires (Fluent Forms) : créés d'office si une page les utilise et que l'extension est là.
	if ( function_exists( 'briise_formulaire_creer' ) && briise_fluentforms_actif() ) {
		$tout = implode( ' ', array_column( $plan['pages'], 'markup' ) );
		foreach ( array( 'devis', 'contact', 'reservation' ) as $type ) {
			if ( false !== strpos( $tout, '[briise_formulaire type="' . $type . '"]' ) ) {
				briise_formulaire_creer( $type );
			}
		}
	}

	// 9. L'ambiance et ses couleurs.
	if ( ! empty( $plan['ambiance'] ) ) {
		briise_appliquer_ambiance( sanitize_key( $plan['ambiance'] ), (array) ( $plan['couleurs'] ?? array() ) );
	}

	if ( ! empty( $plan['kit'] ) ) {
		update_option( 'briise_kit', sanitize_key( $plan['kit'] ) );
	}
	return array( 'crees' => array_values( wp_list_pluck( $crees, 'titre' ) ), 'gardes' => $gardes, 'manquants' => array_keys( $manquants ), 'realisations' => $realisations );
}

/**
 * Applique une ambiance (styles/*.json), avec d'éventuelles couleurs du client.
 */
function briise_appliquer_ambiance( $slug, $couleurs = array() ) {
	$fichier = get_theme_file_path( 'styles/' . $slug . '.json' );
	$data    = ( 'galet' === $slug || ! file_exists( $fichier ) ) ? array( 'version' => 3 ) : json_decode( file_get_contents( $fichier ), true );
	unset( $data['$schema'], $data['description'] );
	$theme   = json_decode( file_get_contents( get_theme_file_path( 'theme.json' ) ), true );
	$palette = $data['settings']['color']['palette'] ?? $theme['settings']['color']['palette'];
	foreach ( $palette as $i => $c ) {
		if ( isset( $couleurs[ $c['slug'] ] ) && preg_match( '/^#[0-9a-f]{6}$/i', $couleurs[ $c['slug'] ] ) ) {
			$palette[ $i ]['color'] = strtolower( $couleurs[ $c['slug'] ] );
		}
	}
	$data['settings']['color']['palette'] = array( 'theme' => $palette );
	if ( isset( $data['settings']['typography']['fontFamilies'] ) ) {
		$data['settings']['typography']['fontFamilies'] = array( 'theme' => $data['settings']['typography']['fontFamilies'] );
	}
	$data['isGlobalStylesUserThemeJSON'] = true;
	$post = WP_Theme_JSON_Resolver::get_user_data_from_wp_global_styles( wp_get_theme(), true );
	if ( ! empty( $post['ID'] ) ) {
		wp_update_post( wp_slash( array( 'ID' => $post['ID'], 'post_content' => wp_json_encode( $data ) ) ) );
		if ( function_exists( 'wp_clean_theme_json_cache' ) ) {
			wp_clean_theme_json_cache();
		}
	}
}

/**
 * Plan d'un kit réglé à l'écran.
 */
function briise_plan_depuis_kit( $cle, $choix ) {
	$data   = briise_kits();
	$kit    = $data['kits'][ $cle ];
	$titres = (array) ( $choix['titres'] ?? array() );
	$garder = (array) ( $choix['pages'] ?? array() );
	$plan   = array(
		'kit'       => $cle,
		'statut'    => $choix['statut'] ?? 'publish',
		'cta_label' => sanitize_text_field( $choix['cta_label'] ?? '' ) ?: $kit['cta'],
		'cta'       => $kit['page_cta'],
		'personne'  => $kit['page_personne'],
		'faq'       => $kit['page_faq'],
		'accueil'   => 'accueil',
		'blog'      => ( $kit['blog'] && in_array( 'blog', $garder, true ) ) ? 'blog' : '',
		'liens'     => $kit['liens'],
		'pages'     => array(),
	);
	foreach ( $kit['pages'] as $p ) {
		$fixe = in_array( $p['slug'], array( 'accueil', $kit['page_cta'] ), true );
		if ( ! $fixe && ! in_array( $p['slug'], $garder, true ) ) {
			continue;
		}
		$p['titre']      = sanitize_text_field( $titres[ $p['slug'] ] ?? '' ) ?: $p['titre'];
		$p['menu']       = ! $fixe;
		$plan['pages'][] = $p;
	}
	// Pages en plus, prises dans les modèles.
	$slugs = wp_list_pluck( $plan['pages'], 'slug' );
	foreach ( (array) ( $choix['options'] ?? array() ) as $m ) {
		$m = sanitize_key( $m );
		if ( ! isset( $data['modeles'][ $m ] ) ) {
			continue;
		}
		$titre = sanitize_text_field( $choix['options_titres'][ $m ] ?? '' ) ?: $data['modeles'][ $m ]['titre'];
		$slug  = sanitize_title( $titre );
		if ( ! in_array( $slug, $slugs, true ) ) {
			$plan['pages'][] = array( 'slug' => $slug, 'titre' => $titre, 'markup' => $data['modeles'][ $m ]['markup'], 'menu' => true );
			$slugs[]         = $slug;
		}
	}
	// Une page par service, rangée sous la page des services.
	$parent = $kit['liens']['services'];
	$ville  = briise_theme_entreprise()['city'];
	foreach ( preg_split( '/\r\n|\r|\n/', (string) ( $choix['services'] ?? '' ) ) as $service ) {
		$service = trim( sanitize_text_field( $service ) );
		if ( '' === $service ) {
			continue;
		}
		$plan['pages'][] = array(
			'slug'      => sanitize_title( $service ),
			'titre'     => $service,
			'parent'    => in_array( $parent, $slugs, true ) ? $parent : '',
			'markup'    => $data['modeles']['service']['markup'],
			'menu'      => true,
			'seo_titre' => $ville ? $service . ' à ' . $ville . ' | ' . get_bloginfo( 'name' ) : '',
		);
	}
	foreach ( $data['legales'] as $p ) {
		$p['menu']       = false;
		$plan['pages'][] = $p;
	}
	return $plan;
}

/**
 * Plan lu dans un fichier de site (JSON préparé par l'agence).
 */
function briise_plan_depuis_fichier( $json ) {
	$plan = json_decode( $json, true );
	if ( ! is_array( $plan ) || empty( $plan['pages'] ) || ! is_array( $plan['pages'] ) ) {
		return new WP_Error( 'fichier', 'Ce fichier n’est pas un fichier de site Briise valide : la liste « pages » est absente.' );
	}
	$data = briise_kits();
	foreach ( $plan['pages'] as $i => $p ) {
		if ( empty( $p['slug'] ) || empty( $p['titre'] ) ) {
			return new WP_Error( 'fichier', 'Chaque page doit avoir un « slug » et un « titre » (page n° ' . ( $i + 1 ) . ').' );
		}
		// Une page peut partir d'un modèle du thème au lieu d'un contenu complet.
		if ( empty( $p['markup'] ) && ! empty( $p['modele'] ) && isset( $data['modeles'][ $p['modele'] ] ) ) {
			$plan['pages'][ $i ]['markup'] = $data['modeles'][ $p['modele'] ]['markup'];
		}
		if ( ( $p['modele'] ?? '' ) === 'atterrissage' && empty( $p['template'] ) ) {
			$plan['pages'][ $i ]['template'] = 'page-atterrissage';
			$plan['pages'][ $i ]['menu']     = false;
		}
	}
	if ( ! isset( $plan['legales'] ) || $plan['legales'] ) {
		foreach ( $data['legales'] as $p ) {
			$p['menu']       = false;
			$plan['pages'][] = $p;
		}
	}
	return $plan;
}

/* ----- Modèles proposés à la création d'une nouvelle page ------------------------ */

// Seulement là où l'éditeur les demande (administration et API REST), pas sur le site public.
$briise_modeles = function () {
	if ( WP_Block_Patterns_Registry::get_instance()->is_registered( 'briise/modele-service' ) ) {
		return;
	}
	register_block_pattern_category( 'briise-modeles', array( 'label' => 'Modèles de page' ) );
	foreach ( briise_kits()['modeles'] as $cle => $m ) {
		register_block_pattern( 'briise/modele-' . $cle, array(
			'title'       => $m['titre'],
			'description' => $m['desc'],
			'categories'  => array( 'briise-modeles' ),
			'blockTypes'  => array( 'core/post-content' ),
			'postTypes'   => array( 'page' ),
			// Le titre principal suit le titre de la page : rien à retaper.
			'content'     => briise_kit_remplir( str_replace(
				"<!-- wp:heading {\"level\":1,\"fontSize\":\"huge\"} -->\n<h1 class=\"wp-block-heading has-huge-font-size\">{{TITRE}}</h1>\n<!-- /wp:heading -->",
				'<!-- wp:post-title {"level":1,"fontSize":"huge","className":"br-titre"} /-->',
				$m['markup']
			) ),
		) );
	}
};
add_action( 'admin_init', $briise_modeles );
add_action( 'rest_api_init', $briise_modeles );

/* ----- Onglet « Démarrage » ------------------------------------------------------- */

// L'onglet est fourni par le thème : les kits et l'import montent des pages avec ses sections.
add_filter( 'briise_onglets', function ( $onglets ) {
	$avant = array_slice( $onglets, 0, array_search( 'controle', array_keys( $onglets ), true ), true );
	return $avant + array( 'demarrage' => array( 'Démarrage', 'manage_options', '' ) ) + $onglets;
} );

add_action( 'admin_post_briise_kit', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'briise_kit' ) ) {
		wp_die( 'Accès refusé.' );
	}
	if ( 'fichier' === sanitize_key( $_POST['mode'] ?? '' ) ) {
		$tmp  = $_FILES['fichier']['tmp_name'] ?? '';
		$plan = ( $tmp && is_uploaded_file( $tmp ) ) ? briise_plan_depuis_fichier( file_get_contents( $tmp ) ) : new WP_Error( 'fichier', 'Aucun fichier reçu.' );
	} else {
		$cle  = sanitize_key( $_POST['kit'] ?? '' );
		$plan = isset( briise_kits()['kits'][ $cle ] ) ? briise_plan_depuis_kit( $cle, wp_unslash( $_POST ) ) : new WP_Error( 'kit', 'Kit inconnu.' );
	}
	$r = is_wp_error( $plan ) ? array( 'erreur' => $plan->get_error_message() ) : briise_plan_installer( $plan );
	set_transient( 'briise_kit_resultat_' . get_current_user_id(), $r, 120 );
	wp_safe_redirect( admin_url( 'admin.php?page=briise-entreprise&onglet=demarrage' ) );
	exit;
} );

function briise_onglet_demarrage() {
	$data   = briise_kits();
	$actuel = get_option( 'briise_kit' );
	$choisi = sanitize_key( $_GET['kit'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification
	$r      = get_transient( 'briise_kit_resultat_' . get_current_user_id() );
	if ( $r ) {
		delete_transient( 'briise_kit_resultat_' . get_current_user_id() );
		if ( isset( $r['erreur'] ) ) {
			echo '<div class="notice notice-error"><p>' . esc_html( $r['erreur'] ) . '</p></div>';
		} else {
			echo '<div class="notice notice-success"><p><strong>' . count( $r['crees'] ) . ' pages créées</strong>' . ( $r['crees'] ? ' : ' . esc_html( implode( ', ', $r['crees'] ) ) : '' ) . '.</p>';
			if ( ! empty( $r['realisations'] ) ) {
				echo '<p><strong>' . count( $r['realisations'] ) . ' fiches de réalisation créées</strong> : ' . esc_html( implode( ', ', $r['realisations'] ) ) . '. Ajoutez leurs photos (photo principale et galerie).</p>';
			}
			if ( $r['gardes'] ) {
				echo '<p>Pages existantes laissées telles quelles : ' . esc_html( implode( ', ', $r['gardes'] ) ) . '.</p>';
			}
			if ( ! empty( $r['manquants'] ) ) {
				echo '<p>Certaines sections renvoyaient vers des pages non retenues (' . esc_html( implode( ', ', $r['manquants'] ) ) . ') : leurs liens mènent à la page des services. À revoir lors de la rédaction.</p>';
			}
			echo '<p>Prochaines étapes : compléter les autres onglets de Mon entreprise, puis remplacer les textes et les photos d’exemple de chaque page.</p></div>';
		}
	}
	$base = admin_url( 'admin.php?page=briise-entreprise&onglet=demarrage' );

	if ( ! $choisi || ! isset( $data['kits'][ $choisi ] ) ) :
		?>
		<h2 class="title">Partir d’un kit</h2>
		<p class="description">Le kit propose les pages adaptées à un type d’activité ; l’écran suivant permet de les ajuster à la demande du client.</p>
		<div class="br-kits">
			<?php foreach ( $data['kits'] as $cle => $k ) : ?>
				<a class="br-kit" href="<?php echo esc_url( add_query_arg( 'kit', $cle, $base ) ); ?>">
					<strong><?php echo esc_html( $k['titre'] ); ?></strong>
					<span class="description"><?php echo esc_html( $k['pour'] ); ?></span>
					<span class="br-kit-pages"><?php echo esc_html( implode( ' · ', wp_list_pluck( $k['pages'], 'titre' ) ) ); ?></span>
					<span class="br-kit-cta">Ajuster ce kit →</span>
				</a>
			<?php endforeach; ?>
		</div>
		<?php if ( $actuel ) : ?>
			<p><em>Un kit a déjà été installé sur ce site (<?php echo esc_html( $data['kits'][ $actuel ]['titre'] ?? $actuel ); ?>). Relancer ne crée que les pages manquantes.</em></p>
		<?php endif; ?>

		<h2 class="title">Ou importer un fichier de site</h2>
		<p class="description">Le fichier préparé par l’agence à partir de la fiche client : pages, textes, référencement, menu, informations de l’entreprise, ambiance et couleurs.</p>
		<form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="briise_kit"><input type="hidden" name="mode" value="fichier">
			<?php wp_nonce_field( 'briise_kit' ); ?>
			<p><input type="file" name="fichier" accept=".json,application/json" required aria-label="Fichier de site"></p>
			<?php submit_button( 'Importer et créer le site', 'secondary', 'submit', false ); ?>
		</form>
		<?php
		return;
	endif;

	$k     = $data['kits'][ $choisi ];
	$fixes = array( 'accueil', $k['page_cta'] );
	$slugs = wp_list_pluck( $k['pages'], 'slug' );
	$sp    = array_values( array_filter( $k['pages'], function ( $p ) use ( $k ) {
		return $p['slug'] === $k['liens']['services'];
	} ) );
	?>
	<p><a href="<?php echo esc_url( $base ); ?>">← Changer de kit</a></p>
	<h2 class="title">Ajuster le kit « <?php echo esc_html( $k['titre'] ); ?> »</h2>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="briise_kit"><input type="hidden" name="mode" value="kit">
		<input type="hidden" name="kit" value="<?php echo esc_attr( $choisi ); ?>">
		<?php wp_nonce_field( 'briise_kit' ); ?>

		<h3>Pages prévues</h3>
		<p class="description">Décochez ce dont le client n’a pas besoin, renommez à sa façon. L’accueil et la page d’action sont indispensables.</p>
		<table class="br-jours" role="presentation">
			<?php foreach ( $k['pages'] as $p ) : $fixe = in_array( $p['slug'], $fixes, true ); ?>
				<tr>
					<td><input type="checkbox" name="pages[]" value="<?php echo esc_attr( $p['slug'] ); ?>" checked <?php disabled( $fixe ); ?> aria-label="Créer la page <?php echo esc_attr( $p['titre'] ); ?>"></td>
					<td><input type="text" class="regular-text" name="titres[<?php echo esc_attr( $p['slug'] ); ?>]" value="<?php echo esc_attr( $p['titre'] ); ?>" aria-label="Titre de la page <?php echo esc_attr( $p['titre'] ); ?>"></td>
					<td class="br-ferme-txt"><?php echo $fixe ? 'indispensable' : ''; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h3>Pages en plus</h3>
		<table class="br-jours" role="presentation">
			<?php
			foreach ( $data['modeles'] as $cle => $m ) :
				if ( in_array( $cle, array( 'service', 'atterrissage' ), true ) ) {
					continue;
				}
				?>
				<tr>
					<td><input type="checkbox" name="options[]" value="<?php echo esc_attr( $cle ); ?>" aria-label="Ajouter : <?php echo esc_attr( $m['titre'] ); ?>"></td>
					<td><input type="text" class="regular-text" name="options_titres[<?php echo esc_attr( $cle ); ?>]" value="<?php echo esc_attr( ucfirst( preg_replace( '/^Page (de |d’)?/u', '', $m['titre'] ) ) ); ?>" aria-label="Titre de la page"></td>
					<td class="br-ferme-txt"><?php echo esc_html( $m['desc'] ); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h3>Services du client</h3>
		<p class="description">Un service par ligne. Chacun aura sa propre page<?php echo $sp ? ', rangée sous « ' . esc_html( $sp[0]['titre'] ) . ' » et ajoutée en sous-menu' : ''; ?> : c’est ce qui fonctionne le mieux pour le référencement local.</p>
		<textarea name="services" rows="5" class="large-text" style="max-width:46em" aria-label="Services du client, un par ligne" placeholder="Escaliers sur mesure&#10;Garde-corps&#10;Portails et clôtures"></textarea>

		<h3>Finitions</h3>
		<table class="form-table" role="presentation">
			<tr><th scope="row"><label for="br-cta-label">Libellé du bouton d’action</label></th>
				<td><input type="text" class="regular-text" id="br-cta-label" name="cta_label" value="<?php echo esc_attr( $k['cta'] ); ?>"></td></tr>
			<tr><th scope="row">Pages créées</th>
				<td><label><input type="radio" name="statut" value="publish" checked> publiées : le site est visible tout de suite</label><br>
					<label><input type="radio" name="statut" value="draft"> en brouillon : à publier une à une</label></td></tr>
		</table>
		<?php submit_button( 'Créer les pages' ); ?>
	</form>
	<?php
}

/**
 * Une page créée depuis le modèle « Page d'atterrissage » prend d'elle-même
 * le gabarit sans menu (et donc l'exclusion de Google), tant qu'aucun gabarit n'a été choisi.
 */
add_action( 'save_post_page', function ( $post_id, $post ) {
	if ( wp_is_post_revision( $post_id ) || '' !== (string) get_page_template_slug( $post_id ) ) {
		return;
	}
	if ( false !== strpos( $post->post_content, 'br-atterrissage' ) ) {
		update_post_meta( $post_id, '_wp_page_template', 'page-atterrissage' );
	}
	// Une page qui commence par un en-tête du thème (titre déjà dans l'en-tête) prend le gabarit sans titre.
	elseif ( preg_match( '/^\s*<!-- wp:(group|cover) \{[^\n]*"className":"[^"]*\b(br-page-head|br-banniere|br-hero|br-tete)\b/', $post->post_content ) ) {
		update_post_meta( $post_id, '_wp_page_template', 'page-sans-titre' );
	}
}, 20, 2 );
