<?php
/**
 * Réalisations (ou Portfolio, Chantiers, Projets) : le client publie une fiche par réalisation
 * (photos, textes, ville, date, service, catégorie). Les grilles du site se mettent à jour seules :
 * page des réalisations (avec filtres), accueil, pages de service ; chaque fiche renvoie à son service.
 *
 * Une fiche dont le texte fait moins de 150 mots reste visible dans les grilles mais sort de Google
 * (contenu trop mince) ; l'onglet Contrôle la signale.
 *
 * Codes courts : [briise_realisations nombre="3" service="auto|slug" categorie="slug" filtres="1" forme="galerie"]
 *                [briise_realisation_infos]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const BRIISE_REALISATION = 'briise_realisation';
const BRIISE_REALISATION_CAT = 'briise_categorie';

function briise_realisations_actif() {
	return briise_fonction( 'realisations' );
}

/**
 * Nom choisi dans Mon entreprise > Fonctions, et ses déclinaisons.
 */
function briise_realisations_nom() {
	$f   = briise_reglage( 'briise_fonctions' );
	$nom = $f['realisations_nom'] ?? 'Réalisations';
	return in_array( $nom, briise_realisations_noms(), true ) ? $nom : 'Réalisations';
}

function briise_realisations_mots() {
	$mots = array(
		'Réalisations' => array( 'réalisation', 'une', 'Toutes' ),
		'Portfolio'    => array( 'projet', 'un', 'Tous' ),
		'Chantiers'    => array( 'chantier', 'un', 'Tous' ),
		'Projets'      => array( 'projet', 'un', 'Tous' ),
	);
	return $mots[ briise_realisations_nom() ];
}

function briise_realisations_slug() {
	return sanitize_title( briise_realisations_nom() );
}

/**
 * Page qui présente toutes les réalisations : celle dont l'adresse est le nom choisi (/realisations/).
 */
function briise_realisations_page() {
	$p = get_page_by_path( briise_realisations_slug() );
	return ( $p && 'publish' === $p->post_status ) ? $p : null;
}

/* ----- Type de contenu ------------------------------------------------------------ */

add_action( 'init', function () {
	if ( ! briise_realisations_actif() ) {
		return;
	}
	$nom = briise_realisations_nom();
	list( $un, $art ) = briise_realisations_mots();
	$Un  = ucfirst( $un );
	$nouv = 'une' === $art ? 'Nouvelle ' . $un : 'Nouveau ' . $un;
	register_post_type( BRIISE_REALISATION, array(
		'labels'        => array(
			'name'               => $nom,
			'singular_name'      => $Un,
			'menu_name'          => $nom,
			'add_new'            => 'Ajouter',
			'add_new_item'       => 'Ajouter ' . $art . ' ' . $un,
			'new_item'           => $nouv,
			'edit_item'          => 'Modifier ' . ( 'une' === $art ? 'la ' : 'le ' ) . $un,
			'view_item'          => 'Voir ' . ( 'une' === $art ? 'la ' : 'le ' ) . $un,
			'all_items'          => ( 'une' === $art ? 'Toutes les ' : 'Tous les ' ) . $un . 's',
			'search_items'       => 'Rechercher',
			'not_found'          => 'Aucun' . ( 'une' === $art ? 'e ' : ' ' ) . $un,
			'not_found_in_trash' => 'Aucun' . ( 'une' === $art ? 'e ' : ' ' ) . $un . ' dans la corbeille',
			'featured_image'     => 'Photo principale',
			'set_featured_image' => 'Choisir la photo principale',
			'remove_featured_image' => 'Retirer la photo principale',
			'use_featured_image' => 'Utiliser comme photo principale',
			'item_published'     => $Un . ' en ligne.',
			'item_updated'       => $Un . ' mis' . ( 'une' === $art ? 'e' : '' ) . ' à jour.',
		),
		'public'        => true,
		'has_archive'   => false, // La liste est une page ordinaire, avec sa section automatique.
		'rewrite'       => array( 'slug' => briise_realisations_slug(), 'with_front' => false ),
		'menu_position' => 4,
		'menu_icon'     => 'dashicons-format-gallery',
		'show_in_rest'  => true,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'template'      => array(
			array( 'core/heading', array( 'level' => 2, 'content' => 'La demande' ) ),
			array( 'core/paragraph', array( 'placeholder' => 'Ce que le client voulait : le lieu, ses contraintes, le style, le délai…' ) ),
			array( 'core/heading', array( 'level' => 2, 'content' => 'Ce que nous avons fait' ) ),
			array( 'core/paragraph', array( 'placeholder' => 'Les étapes, les matériaux, les choix, le résultat. Au moins 150 mots au total pour que cette page apparaisse sur Google.' ) ),
			array( 'core/gallery', array( 'linkTo' => 'none', 'sizeSlug' => 'large' ) ),
		),
	) );
	register_taxonomy( BRIISE_REALISATION_CAT, BRIISE_REALISATION, array(
		'labels'            => array(
			'name'          => 'Catégories',
			'singular_name' => 'Catégorie',
			'add_new_item'  => 'Ajouter une catégorie',
			'menu_name'     => 'Catégories',
		),
		'hierarchical'      => true, // Cases à cocher dans l'éditeur.
		'public'            => false, // Pas de page par catégorie (trop pauvre) : on filtre dans la grille.
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
	) );
	foreach ( array( '_briise_ville', '_briise_date' ) as $cle ) {
		register_post_meta( BRIISE_REALISATION, $cle, array( 'type' => 'string', 'single' => true, 'show_in_rest' => false ) );
	}
	register_post_meta( BRIISE_REALISATION, '_briise_service', array( 'type' => 'integer', 'single' => true, 'show_in_rest' => false ) );
}, 5 );

// Changer de nom change l'adresse des fiches : les règles d'adresse sont refaites une fois.
add_action( 'update_option_briise_fonctions', function ( $avant, $apres ) {
	if ( ( $avant['realisations_nom'] ?? '' ) !== ( $apres['realisations_nom'] ?? '' ) || ! empty( $avant['realisations'] ) !== ! empty( $apres['realisations'] ) ) {
		update_option( 'briise_refaire_adresses', 1 );
	}
}, 10, 2 );
add_action( 'add_option_briise_fonctions', function () {
	update_option( 'briise_refaire_adresses', 1 );
} );
add_action( 'init', function () {
	if ( get_option( 'briise_refaire_adresses' ) ) {
		delete_option( 'briise_refaire_adresses' );
		flush_rewrite_rules( false );
	}
}, 99 );

/* ----- Encadré « Informations » de la fiche --------------------------------------- */

add_action( 'add_meta_boxes_' . BRIISE_REALISATION, function () {
	add_meta_box( 'briise-realisation', 'Informations', 'briise_realisation_encadre', BRIISE_REALISATION, 'side', 'high' );
} );

function briise_realisation_encadre( $post ) {
	wp_nonce_field( 'briise_realisation', 'briise_realisation_nonce' );
	$service = (int) get_post_meta( $post->ID, '_briise_service', true );
	$pages   = wp_dropdown_pages( array(
		'name'              => 'briise_service',
		'id'                => 'briise-service',
		'selected'          => $service,
		'show_option_none'  => '— Aucun —',
		'option_none_value' => '0',
		'echo'              => 0,
	) );
	?>
	<p><label for="briise-ville"><strong>Ville</strong></label><br>
		<input type="text" id="briise-ville" name="briise_ville" value="<?php echo esc_attr( get_post_meta( $post->ID, '_briise_ville', true ) ); ?>" style="width:100%" placeholder="Ex. : Étampes"></p>
	<p><label for="briise-date"><strong>Date</strong></label><br>
		<input type="month" id="briise-date" name="briise_date" value="<?php echo esc_attr( get_post_meta( $post->ID, '_briise_date', true ) ); ?>" style="width:100%"></p>
	<p><label for="briise-service"><strong>Service concerné</strong></label><br><?php echo $pages; // phpcs:ignore WordPress.Security.EscapeOutput -- produit par WordPress. ?></p>
	<p class="description">La fiche renvoie vers ce service, et apparaît sur sa page.</p>
	<?php
	$mots = briise_realisation_nb_mots( $post );
	if ( $mots < briise_realisation_seuil() ) {
		echo '<p class="description" style="color:#8a5a00">Texte : ' . (int) $mots . ' mots sur ' . (int) briise_realisation_seuil() . '. En dessous, la fiche reste visible sur le site mais n’apparaît pas sur Google.</p>';
	}
}

add_action( 'save_post_' . BRIISE_REALISATION, function ( $post_id ) {
	if ( ! isset( $_POST['briise_realisation_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['briise_realisation_nonce'] ), 'briise_realisation' ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, '_briise_ville', sanitize_text_field( wp_unslash( $_POST['briise_ville'] ?? '' ) ) );
	$date = sanitize_text_field( wp_unslash( $_POST['briise_date'] ?? '' ) );
	update_post_meta( $post_id, '_briise_date', preg_match( '/^\d{4}-\d{2}$/', $date ) ? $date : '' );
	update_post_meta( $post_id, '_briise_service', absint( $_POST['briise_service'] ?? 0 ) );
} );

/* ----- Contenu trop mince : hors de Google ---------------------------------------- */

function briise_realisation_seuil() {
	return (int) apply_filters( 'briise_realisation_mots_min', 150 );
}

function briise_realisation_nb_mots( $post ) {
	$texte = wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $post ) ) );
	return count( preg_split( '/[\s\x{00A0}\x{202F}]+/u', trim( $texte ), -1, PREG_SPLIT_NO_EMPTY ) );
}

function briise_realisation_mince( $post ) {
	$post = get_post( $post );
	return $post && BRIISE_REALISATION === $post->post_type && briise_realisation_nb_mots( $post ) < briise_realisation_seuil();
}

/**
 * Fiches publiées trop minces (pour le plan du site et le Contrôle).
 */
function briise_realisations_minces() {
	if ( ! post_type_exists( BRIISE_REALISATION ) ) {
		return array();
	}
	$ids = get_posts( array( 'post_type' => BRIISE_REALISATION, 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true ) );
	return array_values( array_filter( $ids, 'briise_realisation_mince' ) );
}

/* ----- Affichage ------------------------------------------------------------------ */

function briise_realisation_date_texte( $ym ) {
	if ( ! preg_match( '/^(\d{4})-(\d{2})$/', (string) $ym, $m ) || (int) $m[2] < 1 || (int) $m[2] > 12 ) {
		return '';
	}
	// En français quelle que soit la langue de l'administration.
	$mois = array( 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre' );
	return $mois[ (int) $m[2] - 1 ] . ' ' . $m[1];
}

/**
 * Ligne d'informations : ville, date, service (lien), catégories.
 */
function briise_realisation_infos_html( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || BRIISE_REALISATION !== $post->post_type ) {
		return '';
	}
	$items   = array();
	$ville   = get_post_meta( $post->ID, '_briise_ville', true );
	$date    = briise_realisation_date_texte( get_post_meta( $post->ID, '_briise_date', true ) );
	$service = get_post( (int) get_post_meta( $post->ID, '_briise_service', true ) );
	if ( $ville ) {
		$items[] = briise_icone( 'map-pin' ) . '<span>' . esc_html( $ville ) . '</span>';
	}
	if ( $date ) {
		$items[] = briise_icone( 'calendar' ) . '<span>' . esc_html( $date ) . '</span>';
	}
	if ( $service && 'publish' === $service->post_status ) {
		$items[] = briise_icone( 'tool' ) . '<span>Service : <a href="' . esc_url( get_permalink( $service ) ) . '">' . esc_html( get_the_title( $service ) ) . '</a></span>';
	}
	$cats = get_the_terms( $post, BRIISE_REALISATION_CAT );
	$h    = '';
	if ( $cats && ! is_wp_error( $cats ) ) {
		$h .= '<div class="br-chips">' . implode( '', array_map( function ( $t ) {
			return '<p class="br-chip">' . esc_html( $t->name ) . '</p>';
		}, $cats ) ) . '</div>';
	}
	if ( $items ) {
		$h .= '<ul class="br-real-infos"><li>' . implode( '</li><li>', $items ) . '</li></ul>';
	}
	return $h;
}

/**
 * Image d'une carte : photo principale, sinon image d'attente.
 */
function briise_realisation_image( $post ) {
	if ( has_post_thumbnail( $post ) ) {
		$alt = trim( (string) get_post_meta( get_post_thumbnail_id( $post ), '_wp_attachment_image_alt', true ) );
		return get_the_post_thumbnail( $post, 'medium_large', array( 'loading' => 'lazy', 'alt' => $alt ? $alt : get_the_title( $post ), 'style' => 'aspect-ratio:4/3;object-fit:cover' ) );
	}
	if ( function_exists( 'briise_theme_actif' ) && briise_theme_actif() ) {
		return '<img src="' . esc_url( get_theme_file_uri( 'assets/images/sections/carre.svg' ) ) . '" alt="" loading="lazy" style="aspect-ratio:4/3;object-fit:cover">';
	}
	return '<span class="br-project-vide" aria-hidden="true"></span>';
}

function briise_realisation_resume( $post ) {
	if ( has_excerpt( $post ) ) {
		return wp_trim_words( $post->post_excerpt, 22, '…' );
	}
	// Premier paragraphe après « La demande » : il dit de quoi il s'agit.
	if ( preg_match( '/<p[^>]*>(.*?)<\/p>/s', $post->post_content, $m ) ) {
		return wp_trim_words( wp_strip_all_tags( $m[1] ), 22, '…' );
	}
	return '';
}

/**
 * Grille de réalisations.
 */
function briise_realisations_requete( $atts ) {
	$args    = array(
		'post_type'      => BRIISE_REALISATION,
		'post_status'    => 'publish',
		'posts_per_page' => 200,
		'no_found_rows'  => true,
	);
	$service = (string) $atts['service'];
	if ( 'auto' === $service ) {
		$courant = get_queried_object();
		$service = ( $courant instanceof WP_Post && 'page' === $courant->post_type ) ? $courant->ID : -1;
	} elseif ( '' !== $service ) {
		$p       = get_page_by_path( $service );
		$service = $p ? $p->ID : -1;
	}
	if ( '' !== $service ) {
		$args['meta_query'] = array( array( 'key' => '_briise_service', 'value' => (int) $service, 'type' => 'NUMERIC' ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
	}
	if ( '' !== $atts['categorie'] ) {
		$args['tax_query'] = array( array( 'taxonomy' => BRIISE_REALISATION_CAT, 'field' => 'slug', 'terms' => array_map( 'sanitize_title', explode( ',', $atts['categorie'] ) ) ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
	}
	if ( ! empty( $atts['exclure'] ) ) {
		$args['post__not_in'] = array( (int) $atts['exclure'] );
	}
	$posts = get_posts( $args );
	// Les plus récentes d'abord : date de la réalisation (champ Date), sinon date de publication.
	usort( $posts, function ( $a, $b ) {
		$da = get_post_meta( $a->ID, '_briise_date', true ) ?: substr( $a->post_date, 0, 7 );
		$db = get_post_meta( $b->ID, '_briise_date', true ) ?: substr( $b->post_date, 0, 7 );
		return strcmp( $db, $da ) ?: strcmp( $b->post_date, $a->post_date );
	} );
	return (int) $atts['nombre'] > 0 ? array_slice( $posts, 0, (int) $atts['nombre'] ) : $posts;
}

function briise_realisations_html( $atts = array() ) {
	if ( ! post_type_exists( BRIISE_REALISATION ) ) {
		return '';
	}
	$brut  = is_array( $atts ) ? $atts : array();
	$atts  = shortcode_atts( array( 'nombre' => 0, 'service' => '', 'categorie' => '', 'filtres' => '0', 'exclure' => '', 'niveau' => 3, 'autres' => '0', 'forme' => '' ), $atts, 'briise_realisations' );
	$galerie = 'galerie' === $atts['forme'];
	// Grille complète avec filtres : elle suit directement le titre de la page, ses cartes sont donc des H2.
	if ( '1' === (string) $atts['filtres'] && ! isset( $brut['niveau'] ) ) {
		$atts['niveau'] = 2;
	}
	$titre = '';
	if ( '1' === (string) $atts['autres'] ) {
		// Bas d'une fiche : d'autres réalisations, celles du même service d'abord.
		$courante = get_queried_object();
		if ( ! $courante instanceof WP_Post || BRIISE_REALISATION !== $courante->post_type ) {
			return '';
		}
		$service   = get_post( (int) get_post_meta( $courante->ID, '_briise_service', true ) );
		$base      = array( 'exclure' => $courante->ID, 'nombre' => 0, 'categorie' => '' );
		$memes     = $service ? briise_realisations_requete( array( 'service' => get_page_uri( $service ) ) + $base ) : array();
		$posts     = array_slice( array_values( array_unique( array_merge( $memes, briise_realisations_requete( array( 'service' => '' ) + $base ) ), SORT_REGULAR ) ), 0, (int) $atts['nombre'] ?: 3 );
		list( $un, $art ) = briise_realisations_mots();
		$titre     = $posts ? '<h2 class="wp-block-heading">' . esc_html( 'D’autres ' . $un . 's' ) . '</h2>' : '';
		$atts['service'] = 'x'; // Pas de rappel « aucune fiche » ici.
	} else {
		$posts = briise_realisations_requete( $atts );
	}
	if ( ! $posts ) {
		list( $un, $art ) = briise_realisations_mots();
		// Seule l'équipe voit ce rappel ; pour les visiteurs, la section entière disparaît.
		return ( current_user_can( 'edit_posts' ) && '' === $atts['service'] )
			? '<p class="br-a-remplacer">Aucun' . ( 'une' === $art ? 'e ' : ' ' ) . esc_html( $un ) . ' publié' . ( 'une' === $art ? 'e' : '' ) . ' : menu « ' . esc_html( briise_realisations_nom() ) . ' » > Ajouter.</p>'
			: '';
	}
	$niveau = min( 6, max( 2, (int) $atts['niveau'] ) );
	$cats   = array();
	$nombre = array();
	$cartes = '';
	foreach ( $posts as $p ) {
		$termes = get_the_terms( $p, BRIISE_REALISATION_CAT );
		$termes = ( $termes && ! is_wp_error( $termes ) ) ? $termes : array();
		$chips  = '';
		foreach ( $termes as $t ) {
			$cats[ $t->slug ]   = $t->name;
			$nombre[ $t->slug ] = ( $nombre[ $t->slug ] ?? 0 ) + 1;
			$chips             .= '<p class="br-chip">' . esc_html( $t->name ) . '</p>';
		}
		$ville = get_post_meta( $p->ID, '_briise_ville', true );
		if ( $galerie ) {
			// Galerie : la photo seule, le titre et la commune dans une étiquette posée dessus.
			$cartes .= '<li class="br-galerie-tuile" data-cats="' . esc_attr( implode( ' ', wp_list_pluck( $termes, 'slug' ) ) ) . '">'
				// Le titre est juste dessous : une photo sans description propre n'a pas à le répéter.
				. '<figure>' . str_replace( 'alt="' . esc_attr( get_the_title( $p ) ) . '"', 'alt=""', briise_realisation_image( $p ) ) . '</figure>'
				. '<div class="br-galerie-legende">' . sprintf( '<h%1$d class="br-project-titre"><a href="%2$s">%3$s</a></h%1$d>', $niveau, esc_url( get_permalink( $p ) ), esc_html( get_the_title( $p ) ) )
				. ( $ville || $termes ? '<span>' . esc_html( implode( ', ', array_filter( array( $termes ? $termes[0]->name : '', $ville ) ) ) ) . '</span>' : '' )
				. '</div></li>';
			continue;
		}
		if ( $ville ) {
			$chips .= '<p class="br-chip">' . esc_html( $ville ) . '</p>';
		}
		$cartes .= '<li class="br-project" data-cats="' . esc_attr( implode( ' ', wp_list_pluck( $termes, 'slug' ) ) ) . '">'
			. '<figure class="wp-block-image size-full is-style-br-arrondi">' . briise_realisation_image( $p ) . '</figure>'
			. ( $chips ? '<div class="br-chips">' . $chips . '</div>' : '' )
			. sprintf( '<h%1$d class="br-project-titre"><a href="%2$s">%3$s</a></h%1$d>', $niveau, esc_url( get_permalink( $p ) ), esc_html( get_the_title( $p ) ) )
			. ( briise_realisation_resume( $p ) ? '<p class="br-muted">' . esc_html( briise_realisation_resume( $p ) ) . '</p>' : '' )
			. '</li>';
	}
	$filtres = '';
	if ( '1' === (string) $atts['filtres'] && count( $cats ) > 1 ) {
		asort( $cats );
		list( , , $tous ) = briise_realisations_mots();
		$filtres = '<div class="br-filtres" role="group" aria-label="Filtrer par catégorie"><button type="button" class="br-filtre" data-filtre="" aria-pressed="true">' . esc_html( $tous ) . ' <span class="br-filtre-n">' . count( $posts ) . '</span></button>';
		foreach ( $cats as $slug => $nom ) {
			$filtres .= '<button type="button" class="br-filtre" data-filtre="' . esc_attr( $slug ) . '" aria-pressed="false">' . esc_html( $nom ) . ' <span class="br-filtre-n">' . (int) $nombre[ $slug ] . '</span></button>';
		}
		$filtres .= '</div><p class="screen-reader-text br-filtres-etat" aria-live="polite"></p>';
	}
	return $titre . '<div class="br-realisations">' . $filtres . '<ul class="' . ( $galerie ? 'br-galerie-real' : 'br-projects br-projects--auto' ) . '">' . $cartes . '</ul></div>';
}

add_action( 'init', function () {
	add_shortcode( 'briise_realisations', 'briise_realisations_html' );
	add_shortcode( 'briise_realisation_infos', function () {
		return briise_realisation_infos_html( get_queried_object() );
	} );
} );

/**
 * Une section de réalisations sans rien à montrer disparaît (comme « Pages liées »).
 */
add_filter( 'render_block_core/group', function ( $html, $block ) {
	if ( false === strpos( $block['attrs']['className'] ?? '', 'br-section-realisations' ) || is_admin() ) {
		return $html;
	}
	// Les codes courts ne sont exécutés qu'après les blocs : on rend la grille ici pour savoir si elle est vide.
	$html = preg_replace_callback( '/\[briise_realisations[^\]]*\]/', function ( $m ) {
		return do_shortcode( $m[0] );
	}, $html );
	return ( false !== strpos( $html, 'br-project' ) || false !== strpos( $html, 'br-a-remplacer' ) ) ? $html : '';
}, 10, 2 );

/**
 * Photos d'une fiche : agrandies au clic.
 */
add_filter( 'render_block_data', function ( $bloc ) {
	if ( 'core/image' === ( $bloc['blockName'] ?? '' ) && is_singular( BRIISE_REALISATION ) && in_the_loop() ) {
		$bloc['attrs']['lightbox'] = array( 'enabled' => true );
	}
	return $bloc;
} );

/**
 * Avec un autre thème que Briise (qui a son propre gabarit de fiche) : informations en tête
 * de la fiche, autres réalisations à la fin.
 */
add_filter( 'the_content', function ( $contenu ) {
	if ( ( function_exists( 'briise_theme_actif' ) && briise_theme_actif() ) || ! is_singular( BRIISE_REALISATION ) || ! in_the_loop() || ! is_main_query() ) {
		return $contenu;
	}
	return briise_realisation_infos_html() . $contenu . briise_realisations_html( array( 'nombre' => 3, 'autres' => '1' ) );
} );

/* ----- Import d'un fichier de site ------------------------------------------------- */

/**
 * « realisations » : [ { titre, slug?, ville, date (AAAA-MM), service (adresse de la page),
 *   categories: [noms], demande, solution (texte ou liste de paragraphes), resume? } ].
 * Une fiche déjà présente (même adresse) est laissée telle quelle.
 */
function briise_realisations_importer( $liste, $statut = 'draft' ) {
	if ( ! is_array( $liste ) || ! post_type_exists( BRIISE_REALISATION ) ) {
		return array();
	}
	$crees = array();
	$para  = function ( $t ) {
		$out = '';
		foreach ( (array) $t as $p ) {
			$out .= "<!-- wp:paragraph -->\n<p>" . wp_kses_post( $p ) . "</p>\n<!-- /wp:paragraph -->\n\n";
		}
		return $out;
	};
	$titre2 = function ( $t ) {
		return "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">" . esc_html( $t ) . "</h2>\n<!-- /wp:heading -->\n\n";
	};
	foreach ( $liste as $r ) {
		if ( empty( $r['titre'] ) ) {
			continue;
		}
		$slug = sanitize_title( $r['slug'] ?? $r['titre'] );
		if ( get_page_by_path( $slug, OBJECT, BRIISE_REALISATION ) ) {
			continue;
		}
		// Fichier exporté : contenu complet (markup) ; fichier écrit à la main : demande et solution.
		$contenu = ! empty( $r['markup'] ) ? $r['markup'] : $titre2( 'La demande' ) . $para( $r['demande'] ?? '' ) . $titre2( 'Ce que nous avons fait' ) . $para( $r['solution'] ?? '' );
		$id      = wp_insert_post( wp_slash( array(
			'post_type'    => BRIISE_REALISATION,
			'post_status'  => in_array( $statut, array( 'publish', 'draft' ), true ) ? $statut : 'draft',
			'post_title'   => sanitize_text_field( $r['titre'] ),
			'post_name'    => $slug,
			'post_excerpt' => sanitize_text_field( $r['resume'] ?? '' ),
			'post_content' => trim( $contenu ),
		) ), true );
		if ( is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_briise_ville', sanitize_text_field( $r['ville'] ?? '' ) );
		update_post_meta( $id, '_briise_date', preg_match( '/^\d{4}-\d{2}$/', $r['date'] ?? '' ) ? $r['date'] : '' );
		$service = ! empty( $r['service'] ) ? get_page_by_path( $r['service'] ) : null;
		if ( ! $service && ! empty( $r['service'] ) ) {
			// Sous-page : retrouvée par son adresse seule.
			$trouve  = get_posts( array( 'post_type' => 'page', 'name' => sanitize_title( $r['service'] ), 'post_status' => 'any', 'posts_per_page' => 1 ) );
			$service = $trouve ? $trouve[0] : null;
		}
		update_post_meta( $id, '_briise_service', $service ? $service->ID : 0 );
		if ( ! empty( $r['categories'] ) ) {
			wp_set_object_terms( $id, array_map( 'sanitize_text_field', (array) $r['categories'] ), BRIISE_REALISATION_CAT );
		}
		$crees[] = $r['titre'];
	}
	return $crees;
}

/**
 * Pour le fichier de site exporté (Fin de collaboration).
 */
function briise_realisations_exporter() {
	if ( ! post_type_exists( BRIISE_REALISATION ) ) {
		return array();
	}
	$out = array();
	foreach ( get_posts( array( 'post_type' => BRIISE_REALISATION, 'post_status' => array( 'publish', 'draft', 'private' ), 'posts_per_page' => -1 ) ) as $p ) {
		$service = get_post( (int) get_post_meta( $p->ID, '_briise_service', true ) );
		$termes  = get_the_terms( $p, BRIISE_REALISATION_CAT );
		$out[]   = array(
			'titre'      => $p->post_title,
			'slug'       => $p->post_name,
			'ville'      => get_post_meta( $p->ID, '_briise_ville', true ),
			'date'       => get_post_meta( $p->ID, '_briise_date', true ),
			'service'    => $service ? $service->post_name : '',
			'categories' => ( $termes && ! is_wp_error( $termes ) ) ? wp_list_pluck( $termes, 'name' ) : array(),
			'resume'     => $p->post_excerpt,
			'markup'     => $p->post_content,
		);
	}
	return $out;
}
