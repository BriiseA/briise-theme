<?php
/**
 * Onglet « Fin de collaboration » (administrateurs) : tout ce qu'il faut pour que
 * le client parte avec son site, sans rien perdre et sans dépendre de Briise.
 *
 * 1. Figer les contenus : chaque code Briise ([briise_…]) écrit dans une page est remplacé
 *    par son contenu du moment, en blocs WordPress ordinaires. Le site reste lisible même
 *    si l'extension est retirée. Une révision de chaque page est gardée.
 * 2. Exporter le fichier de site : réglages de Mon entreprise et pages, au format d'import.
 * 3. Liste des comptes et accès à remettre.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contenus qui contiennent au moins un code Briise : array( WP_Post, nombre de codes ).
 */
function briise_depart_contenus() {
	$res = array();
	$ids = get_posts( array(
		'post_type'      => array( 'page', 'post' ),
		'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
	) );
	foreach ( $ids as $id ) {
		$p = get_post( $id );
		$n = preg_match_all( '/\[briise_[a-z_]+/', $p->post_content );
		if ( $n ) {
			$res[] = array( $p, $n );
		}
	}
	return $res;
}

/**
 * Remplace les codes Briise d'un texte par leur rendu, dans le contexte de la page.
 */
function briise_depart_rendre( $texte ) {
	return preg_replace_callback( '/\[(briise_[a-z_]+)[^\]]*\]/', function ( $m ) {
		return shortcode_exists( $m[1] ) ? do_shortcode( $m[0] ) : $m[0];
	}, $texte );
}

/**
 * Parcourt les blocs : un bloc « Code court » Briise devient un bloc « HTML personnalisé »
 * avec son rendu ; un code écrit dans un paragraphe est remplacé sur place.
 */
function briise_depart_blocs( $blocs ) {
	foreach ( $blocs as $i => $b ) {
		if ( 'core/shortcode' === $b['blockName'] && false !== strpos( $b['innerHTML'], '[briise_' ) ) {
			$html        = trim( briise_depart_rendre( trim( $b['innerHTML'] ) ) );
			$blocs[ $i ] = array(
				'blockName'    => 'core/html',
				'attrs'        => array(),
				'innerBlocks'  => array(),
				'innerHTML'    => $html,
				'innerContent' => array( $html ),
			);
			continue;
		}
		if ( $b['innerBlocks'] ) {
			$blocs[ $i ]['innerBlocks'] = briise_depart_blocs( $b['innerBlocks'] );
		}
		if ( false !== strpos( (string) $b['innerHTML'], '[briise_' ) ) {
			$blocs[ $i ]['innerHTML'] = briise_depart_rendre( $b['innerHTML'] );
			foreach ( $b['innerContent'] as $k => $morceau ) {
				if ( is_string( $morceau ) ) {
					$blocs[ $i ]['innerContent'][ $k ] = briise_depart_rendre( $morceau );
				}
			}
		}
	}
	return $blocs;
}

/**
 * Fige une page : rendu calculé comme si le visiteur était sur cette page.
 */
function briise_depart_figer( WP_Post $p ) {
	global $post, $wp_query;
	$garde_post  = $post;
	$garde_objet = $wp_query->queried_object;
	$garde_id    = $wp_query->queried_object_id;
	$post                        = $p; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	$wp_query->queried_object    = $p;
	$wp_query->queried_object_id = $p->ID;
	setup_postdata( $p );

	$contenu = serialize_blocks( briise_depart_blocs( parse_blocks( $p->post_content ) ) );

	$post                        = $garde_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	$wp_query->queried_object    = $garde_objet;
	$wp_query->queried_object_id = $garde_id;
	wp_reset_postdata();

	if ( $contenu === $p->post_content ) {
		return false;
	}
	wp_save_post_revision( $p->ID ); // Retour possible depuis l'historique de la page.
	return ! is_wp_error( wp_update_post( wp_slash( array( 'ID' => $p->ID, 'post_content' => $contenu ) ), true ) );
}

/**
 * Fiches de réalisation : deviennent des pages ordinaires, sous la page des réalisations
 * (même adresse quand cette page existe), avec leurs informations écrites en tête.
 * Retourne le nombre de fiches converties.
 */
function briise_depart_realisations() {
	if ( ! post_type_exists( 'briise_realisation' ) ) {
		return 0;
	}
	$parent = function_exists( 'briise_realisations_page' ) ? briise_realisations_page() : null;
	$fiches = get_posts( array( 'post_type' => 'briise_realisation', 'post_status' => array( 'publish', 'draft', 'private', 'pending', 'future' ), 'posts_per_page' => -1 ) );
	$avant  = array();
	foreach ( $fiches as $f ) {
		$avant[ $f->ID ] = get_permalink( $f );
		$tete            = '';
		if ( has_post_thumbnail( $f ) ) {
			$img   = get_post_thumbnail_id( $f );
			$tete .= '<!-- wp:image {"id":' . (int) $img . ',"sizeSlug":"large","linkDestination":"none","className":"is-style-br-arrondi"} -->' . "\n"
				. '<figure class="wp-block-image size-large is-style-br-arrondi">' . wp_get_attachment_image( $img, 'large', false, array( 'class' => 'wp-image-' . (int) $img ) ) . '</figure>' . "\n<!-- /wp:image -->\n\n";
		}
		$infos = briise_realisation_infos_html( $f );
		if ( $infos ) {
			$tete .= "<!-- wp:html -->\n" . $infos . "\n<!-- /wp:html -->\n\n";
		}
		wp_save_post_revision( $f->ID );
		wp_update_post( wp_slash( array(
			'ID'           => $f->ID,
			'post_type'    => 'page',
			'post_parent'  => $parent ? $parent->ID : 0,
			'post_content' => $tete . $f->post_content,
		) ) );
	}
	// Une adresse qui change (pas de page des réalisations) : les liens du site suivent.
	$remplacer = array();
	foreach ( $avant as $id => $url ) {
		clean_post_cache( $id );
		$nouvelle = get_permalink( $id );
		if ( $nouvelle && $nouvelle !== $url ) {
			$remplacer[ $url ] = $nouvelle;
		}
	}
	if ( $remplacer ) {
		foreach ( get_posts( array( 'post_type' => array( 'page', 'post' ), 'post_status' => 'any', 'posts_per_page' => -1 ) ) as $p ) {
			$c = strtr( $p->post_content, $remplacer );
			if ( $c !== $p->post_content ) {
				wp_update_post( wp_slash( array( 'ID' => $p->ID, 'post_content' => $c ) ) );
			}
		}
	}
	// Les fiches sont devenues des pages : la fonction Réalisations est coupée, et les adresses
	// /realisations/… mènent désormais à ces pages.
	$f                 = get_option( 'briise_fonctions', array() );
	$f['realisations'] = false;
	update_option( 'briise_fonctions', $f );
	unregister_post_type( 'briise_realisation' );
	flush_rewrite_rules( false );
	return count( $fiches );
}

/**
 * Fichier de site au format d'import (Démarrage > Importer un fichier de site).
 */
function briise_depart_fichier() {
	$slug = function ( $id ) {
		$p = $id ? get_post( $id ) : null;
		return $p ? get_page_uri( $p ) : '';
	};
	$e           = get_option( 'briise_entreprise', array() );
	$e['name']   = get_bloginfo( 'name' );
	$e['slogan'] = get_bloginfo( 'description' );
	$pages_e     = array( 'cta_page' => $e['cta_page'] ?? 0, 'faq_page' => $e['faq_page'] ?? 0, 'person_page' => $e['person_page'] ?? 0 );
	// Numéros propres à ce site : les pages sont retrouvées par leur adresse (cta, faq, personne),
	// les images ne voyagent pas dans le fichier (elles sont dans la sauvegarde de l'hébergement).
	foreach ( array( 'cta_page', 'faq_page', 'person_page', 'logo', 'logo_clair' ) as $cle ) {
		unset( $e[ $cle ] );
	}

	$couleurs = array();
	foreach ( (array) wp_get_global_settings( array( 'color', 'palette', 'theme' ) ) as $c ) {
		if ( ! empty( $c['slug'] ) && ! empty( $c['color'] ) ) {
			$couleurs[ $c['slug'] ] = $c['color'];
		}
	}

	$menu  = function_exists( 'briise_menu_id' ) ? briise_menu_id() : 0;
	$blocs = $menu && function_exists( 'briise_menu_blocs' ) ? briise_menu_blocs( $menu ) : array();
	$pages = array();
	foreach ( get_pages( array( 'post_status' => 'publish,draft,private', 'sort_column' => 'menu_order,post_title' ) ) as $p ) {
		$page = array(
			'slug'   => $p->post_name,
			'titre'  => $p->post_title,
			'parent' => $p->post_parent ? get_post_field( 'post_name', $p->post_parent ) : '',
			'menu'   => $blocs ? (bool) briise_menu_contient( $blocs, $p->ID ) : false,
			'markup' => $p->post_content,
		);
		foreach ( array( 'seo_titre' => '_briise_seo_title', 'seo_description' => '_briise_seo_desc', 'template' => '_wp_page_template' ) as $cle => $meta ) {
			$v = get_post_meta( $p->ID, $meta, true );
			if ( $v && 'default' !== $v ) {
				$page[ $cle ] = $v;
			}
		}
		$pages[] = $page;
	}
	return array(
		'export'    => array(
			'site'    => home_url( '/' ),
			'date'    => wp_date( 'c' ),
			'theme'   => get_template(),
			'version' => BRIISE_SOCLE_VERSION,
		),
		'entreprise' => $e,
		'legal'      => get_option( 'briise_legal', array() ),
		'annonces'   => get_option( 'briise_annonces', array() ),
		'fonctions'  => get_option( 'briise_fonctions', array() ),
		'couleurs'   => $couleurs,
		'cta'        => $slug( $pages_e['cta_page'] ),
		'cta_label'  => $e['cta_label'] ?? '',
		'accueil'    => $slug( get_option( 'page_on_front' ) ),
		'blog'       => $slug( get_option( 'page_for_posts' ) ),
		'faq'        => $slug( $pages_e['faq_page'] ),
		'personne'   => $slug( $pages_e['person_page'] ),
		'realisations' => function_exists( 'briise_realisations_exporter' ) ? briise_realisations_exporter() : array(),
		'legales'    => false, // Les pages légales sont déjà dans la liste.
		'statut'     => 'draft',
		'pages'      => $pages,
	);
}

/* ----- Actions ------------------------------------------------------------------- */

add_action( 'admin_post_briise_depart_export', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'briise_depart_export' ) ) {
		wp_die( 'Accès refusé.' );
	}
	$nom = sanitize_title( get_bloginfo( 'name' ) ) . '-site-' . wp_date( 'Y-m-d' ) . '.json';
	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="' . $nom . '"' );
	echo wp_json_encode( briise_depart_fichier(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	exit;
} );

add_action( 'admin_post_briise_depart_figer', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'briise_depart_figer' ) ) {
		wp_die( 'Accès refusé.' );
	}
	$faites = array();
	if ( ! empty( $_POST['confirme'] ) ) {
		foreach ( briise_depart_contenus() as $c ) {
			if ( briise_depart_figer( $c[0] ) ) {
				$faites[] = $c[0]->post_title;
			}
		}
		$n = briise_depart_realisations();
		if ( $n ) {
			$faites[] = $n . ' fiche' . ( $n > 1 ? 's' : '' ) . ' de réalisation devenue' . ( $n > 1 ? 's' : '' ) . ' des pages';
		}
	}
	set_transient( 'briise_depart_' . get_current_user_id(), empty( $_POST['confirme'] ) ? 'non' : $faites, 120 );
	wp_safe_redirect( admin_url( 'admin.php?page=briise-entreprise&onglet=depart' ) );
	exit;
} );

/* ----- Écran ------------------------------------------------------------------------ */

function briise_onglet_depart() {
	$r = get_transient( 'briise_depart_' . get_current_user_id() );
	if ( false !== $r ) {
		delete_transient( 'briise_depart_' . get_current_user_id() );
		if ( 'non' === $r ) {
			echo '<div class="notice notice-warning"><p>Rien n’a été modifié : cochez la case de confirmation.</p></div>';
		} else {
			echo '<div class="notice notice-success"><p><strong>' . count( $r ) . ' contenu' . ( count( $r ) > 1 ? 's figés' : ' figé' ) . '.</strong>' . ( $r ? ' ' . esc_html( implode( ', ', $r ) ) . '.' : '' ) . ' L’ancienne version de chaque page reste dans son historique (Révisions).</p></div>';
		}
	}
	$contenus = briise_depart_contenus();
	$total    = array_sum( array_column( $contenus, 1 ) );
	$fiches   = post_type_exists( 'briise_realisation' ) ? count( get_posts( array( 'post_type' => 'briise_realisation', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids' ) ) ) : 0;
	?>
	<h2>Fin de collaboration</h2>
	<p style="max-width:60em">Le site appartient au client. Cet onglet prépare son départ, vers un autre prestataire ou en autonomie : il garde tout son site, ses contenus et ses réglages, sans dépendre de Briise. Suivre les trois étapes dans l’ordre.</p>

	<h3>1. Exporter le fichier de site</h3>
	<p style="max-width:60em">Un fichier qui contient les réglages de Mon entreprise (coordonnées, horaires, mentions légales, fonctions), les couleurs et toutes les pages. Il se réimporte sur un autre site Briise (Démarrage > Importer un fichier de site) et reste lisible par un autre prestataire. Les images (logo, photos) n’y sont pas : elles sont dans la sauvegarde complète de l’hébergement (fichiers et base de données), à remettre aussi.</p>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php wp_nonce_field( 'briise_depart_export' ); ?>
		<input type="hidden" name="action" value="briise_depart_export">
		<?php submit_button( 'Télécharger le fichier de site', 'secondary', 'submit', false ); ?>
	</form>

	<h3>2. Figer les contenus</h3>
	<?php if ( ! $contenus && ! $fiches ) : ?>
		<p class="br-a-faire br-ok">Aucun code Briise dans les pages : le site s’affichera correctement même sans l’extension Briise Socle.</p>
	<?php else : ?>
		<p style="max-width:60em">Les pages contiennent <strong><?php echo (int) $total; ?> code<?php echo $total > 1 ? 's' : ''; ?> Briise</strong> (fil d’Ariane, coordonnées, horaires, cartes, pages liées…). Ils se mettent à jour seuls tant que l’extension est active ; si elle est retirée, ils s’afficheraient en texte brut entre crochets. Figer les remplace par leur contenu du moment, en blocs WordPress ordinaires. À faire juste avant le départ : ensuite, un changement d’horaires ou de téléphone se corrige à la main dans chaque page.</p>
		<?php if ( $fiches ) : ?>
			<p style="max-width:60em"><strong><?php echo (int) $fiches; ?> fiche<?php echo $fiches > 1 ? 's' : ''; ?> de réalisation</strong> deviendront des pages ordinaires, sous la page des réalisations (même adresse), avec leur photo principale, leur ville, leur date et leur service écrits en tête.</p>
		<?php endif; ?>
		<ul style="list-style:disc;padding-left:1.5em">
			<?php foreach ( $contenus as $c ) : ?>
				<li><a href="<?php echo esc_url( get_edit_post_link( $c[0]->ID ) ); ?>"><?php echo esc_html( get_the_title( $c[0] ) ); ?></a> : <?php echo (int) $c[1]; ?></li>
			<?php endforeach; ?>
		</ul>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'briise_depart_figer' ); ?>
			<input type="hidden" name="action" value="briise_depart_figer">
			<p><label><input type="checkbox" name="confirme" value="1"> J’ai exporté le fichier de site et je veux figer les contenus.</label></p>
			<?php submit_button( 'Figer les contenus', 'primary', 'submit', false ); ?>
		</form>
	<?php endif; ?>

	<h3>3. Remettre les comptes et les accès</h3>
	<ul style="list-style:disc;padding-left:1.5em;max-width:60em">
		<li><strong>Nom de domaine</strong> : à son nom chez son registraire ; sinon, lui remettre le code de transfert.</li>
		<li><strong>Hébergement</strong> : accès à son compte, ou déménagement avec une sauvegarde complète (fichiers et base de données).</li>
		<li><strong>WordPress</strong> : un compte Administrateur à son nom ; retirer ensuite le compte Briise (Utilisateurs).</li>
		<li><strong>Google</strong> : propriétaire de la Search Console et de la fiche Google Business Profile ; Bing Webmaster Tools.</li>
		<li><strong>Mesure d’audience</strong> : accès Matomo ou Google Analytics, Tag Manager et Google Ads s’ils existent.</li>
		<li><strong>Formulaire</strong> : export des demandes reçues, depuis l’extension de formulaire.</li>
		<li><strong>Fichiers sources</strong> : logo, photos, textes livrés.</li>
	</ul>
	<p style="max-width:60em">Le thème Briise et l’extension Briise Socle sont sous licence libre (GPL) : le client peut les garder et les faire modifier par qui il veut.</p>
	<?php
}
