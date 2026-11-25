<?php
/**
 * Maillage interne.
 *
 * 1. [briise_pages_liees] : sur une page qui a des sous-pages, la liste de ses sous-pages ;
 *    sur une sous-page, la liste des pages sœurs (les autres services). Le texte du lien est
 *    le titre de la page, la description Google sert de résumé.
 * 2. Onglet « Contrôle » de Mon entreprise : pages sans lien dans le texte, profondeur,
 *    liens cassés, liens vers une page exclue de Google, textes de lien trop vagues ;
 *    sections voisines de même couleur de fond.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Une page peut-elle recevoir des liens du maillage ? (publiée, indexée, sans mot de passe)
 */
function briise_maillage_eligible( $post ) {
	$post = get_post( $post );
	return $post && 'publish' === $post->post_status && '' === $post->post_password
		&& ! ( function_exists( 'briise_est_noindex' ) && briise_est_noindex( $post ) );
}

/**
 * Pages listées par [briise_pages_liees] pour une page donnée.
 * Retourne [ 'mode' => 'enfants'|'soeurs'|'', 'pages' => WP_Post[], 'parent' => WP_Post|null ].
 */
function briise_liees_cibles( $post, $parent_force = 0 ) {
	$post = get_post( $post );
	$vide = array( 'mode' => '', 'pages' => array(), 'parent' => null );
	if ( ! $post || 'page' !== $post->post_type ) {
		return $vide;
	}
	$args = array( 'post_type' => 'page', 'post_status' => 'publish', 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ), 'posts_per_page' => 50, 'no_found_rows' => true );
	if ( $parent_force ) {
		$mode   = 'enfants';
		$parent = get_post( $parent_force );
		$liste  = get_posts( $args + array( 'post_parent' => $parent_force ) );
	} else {
		$liste = get_posts( $args + array( 'post_parent' => $post->ID ) );
		$mode  = 'enfants';
		$parent = null;
		if ( ! $liste && $post->post_parent ) {
			$mode   = 'soeurs';
			$parent = get_post( $post->post_parent );
			$liste  = get_posts( $args + array( 'post_parent' => $post->post_parent, 'post__not_in' => array( $post->ID ) ) );
		}
	}
	$liste = array_values( array_filter( $liste, 'briise_maillage_eligible' ) );
	return $liste ? array( 'mode' => $mode, 'pages' => $liste, 'parent' => $parent ) : $vide;
}

/**
 * Résumé d'une page : sa description Google, sinon sa phrase d'introduction.
 */
function briise_liees_resume( $post ) {
	$desc = trim( (string) get_post_meta( $post->ID, '_briise_seo_desc', true ) );
	if ( '' === $desc && preg_match( '/<p class="br-lead">(.*?)<\/p>/s', $post->post_content, $m ) ) {
		$desc = wp_strip_all_tags( $m[1] );
	}
	return wp_trim_words( $desc, 24, '…' );
}

add_shortcode( 'briise_pages_liees', function ( $atts ) {
	$atts  = shortcode_atts( array( 'parent' => '' ), $atts, 'briise_pages_liees' );
	$force = 0;
	if ( '' !== $atts['parent'] ) {
		$p     = get_page_by_path( sanitize_text_field( $atts['parent'] ) );
		$force = $p ? $p->ID : 0;
		if ( ! $force ) {
			return '';
		}
	}
	$c = briise_liees_cibles( get_the_ID(), $force );
	if ( ! $c['pages'] ) {
		return '';
	}
	$n = count( $c['pages'] );
	// Colonnes choisies pour ne jamais laisser une carte seule sur sa ligne.
	$cols = array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 3, 7 => 4, 8 => 4, 9 => 3 );
	$h    = '<ul class="br-liees" data-colonnes="' . (int) ( $cols[ $n ] ?? 4 ) . '">';
	foreach ( $c['pages'] as $p ) {
		$resume = briise_liees_resume( $p );
		$h     .= '<li class="br-liee"><a href="' . esc_url( get_permalink( $p ) ) . '">' . esc_html( get_the_title( $p ) ) . '</a>'
			. ( $resume ? '<p class="br-muted">' . esc_html( $resume ) . '</p>' : '' ) . '</li>';
	}
	return $h . '</ul>';
} );

/**
 * Une section « pages liées » sans aucune page à montrer disparaît (pas de bandeau vide).
 */
add_filter( 'render_block_core/group', function ( $html, $block ) {
	$cls = $block['attrs']['className'] ?? '';
	if ( false === strpos( $cls, 'br-section-liees' ) || is_admin() ) {
		return $html;
	}
	$force = 0;
	if ( preg_match( '/\[briise_pages_liees[^\]]*parent="([^"]+)"/', $html, $m ) ) {
		$p     = get_page_by_path( $m[1] );
		$force = $p ? $p->ID : -1;
	}
	if ( -1 === $force ) {
		return '';
	}
	return briise_liees_cibles( get_the_ID(), $force )['pages'] ? $html : '';
}, 10, 2 );

/* ----- Contrôle du maillage ----------------------------------------------------- */

/**
 * Analyse le maillage de tout le site à partir des contenus enregistrés.
 */
function briise_maillage_analyse() {
	$accueil = (int) get_option( 'page_on_front' );
	$blog    = (int) get_option( 'page_for_posts' );
	$types   = post_type_exists( 'briise_realisation' ) ? array( 'page', 'post', 'briise_realisation' ) : array( 'page', 'post' );
	$toutes  = get_posts( array( 'post_type' => $types, 'post_status' => 'publish', 'posts_per_page' => 500, 'no_found_rows' => true ) );
	$home    = untrailingslashit( home_url() );
	$vagues  = array( 'en savoir plus', 'cliquez ici', 'ici', 'lire la suite', 'voir plus', 'plus', 'découvrir', 'lien', 'voir' );

	$aretes  = array(); // source => [ cible => true ] (texte, sections, listes)
	$recus   = array(); // cible => [ source => true ] (liens écrits dans le texte, hors fil d'Ariane)
	$casses  = array();
	$exclues = array();
	$flous   = array();

	foreach ( $toutes as $src ) {
		$aretes[ $src->ID ] = array();
		// Liens écrits dans le contenu.
		if ( preg_match_all( '/<a\s[^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/is', $src->post_content, $mm, PREG_SET_ORDER ) ) {
			foreach ( $mm as $m ) {
				$href  = html_entity_decode( $m[1] );
				$texte = trim( wp_strip_all_tags( $m[2] ) );
				if ( 0 === strpos( $href, '/' ) && 0 !== strpos( $href, '//' ) ) {
					$href = $home . $href;
				}
				if ( 0 !== strpos( $href, $home ) || preg_match( '#/wp-(content|admin|includes)/|\.(pdf|jpe?g|png|webp|svg|zip|docx?)$#i', $href ) || false !== strpos( $href, '{{' ) ) {
					continue;
				}
				$chemin = trim( substr( strtok( $href, '?#' ), strlen( $home ) ), '/' );
				$cible  = '' === $chemin ? $accueil : url_to_postid( $href );
				if ( '' === $chemin && ! $accueil ) {
					continue; // Accueil = liste des articles.
				}
				if ( ! $cible || 'publish' !== get_post_status( $cible ) ) {
					$casses[] = array( $src, $href, $texte );
					continue;
				}
				if ( (int) $cible === $src->ID ) {
					continue;
				}
				if ( ! briise_maillage_eligible( $cible ) && ! ( function_exists( 'briise_est_page_legale' ) && briise_est_page_legale( get_post( $cible ) ) ) ) {
					$exclues[] = array( $src, get_post( $cible ), $texte );
				}
				if ( in_array( mb_strtolower( trim( $texte, " \t\n\r\0\x0B→›»." ) ), $vagues, true ) ) {
					$flous[] = array( $src, $texte );
				}
				$aretes[ $src->ID ][ $cible ] = true;
				$recus[ $cible ][ $src->ID ]  = true;
			}
		}
		// Listes automatiques [briise_pages_liees].
		if ( preg_match_all( '/\[briise_pages_liees([^\]]*)\]/', $src->post_content, $sc ) ) {
			foreach ( $sc[1] as $a ) {
				$force = 0;
				if ( preg_match( '/parent="([^"]+)"/', $a, $pm ) ) {
					$pp    = get_page_by_path( $pm[1] );
					$force = $pp ? $pp->ID : 0;
				}
				foreach ( briise_liees_cibles( $src, $force )['pages'] as $c ) {
					$aretes[ $src->ID ][ $c->ID ] = true;
					$recus[ $c->ID ][ $src->ID ]  = true;
				}
			}
		}
		// Grilles automatiques [briise_realisations] : elles mènent à chaque fiche affichée.
		if ( function_exists( 'briise_realisations_requete' ) && preg_match_all( '/\[briise_realisations([^\]]*)\]/', $src->post_content, $sc ) ) {
			foreach ( $sc[1] as $a ) {
				$atts = shortcode_parse_atts( $a );
				$atts = shortcode_atts( array( 'nombre' => 0, 'service' => '', 'categorie' => '', 'exclure' => '' ), is_array( $atts ) ? $atts : array() );
				if ( 'auto' === $atts['service'] ) {
					$atts['service'] = $src->post_name; // Page de service : ses propres réalisations.
					$liste = get_posts( array( 'post_type' => 'briise_realisation', 'post_status' => 'publish', 'posts_per_page' => (int) $atts['nombre'] ?: 200, 'fields' => 'ids', 'meta_key' => '_briise_service', 'meta_value' => $src->ID ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
				} else {
					$liste = wp_list_pluck( briise_realisations_requete( $atts ), 'ID' );
				}
				foreach ( $liste as $rid ) {
					$aretes[ $src->ID ][ $rid ] = true;
					$recus[ $rid ][ $src->ID ]  = true;
				}
			}
		}
		// Fiche de réalisation : son lien automatique vers le service compte comme un lien reçu par le service.
		if ( 'briise_realisation' === $src->post_type ) {
			$service = (int) get_post_meta( $src->ID, '_briise_service', true );
			if ( $service && 'publish' === get_post_status( $service ) ) {
				$aretes[ $src->ID ][ $service ] = true;
				$recus[ $service ][ $src->ID ]  = true;
			}
			if ( function_exists( 'briise_realisations_page' ) && briise_realisations_page() ) {
				$aretes[ $src->ID ][ briise_realisations_page()->ID ] = true; // Fil d'Ariane.
			}
		}
		// Fil d'Ariane : compte pour la profondeur, pas comme lien dans le texte.
		if ( false !== strpos( $src->post_content, '[briise_fil_ariane]' ) ) {
			foreach ( get_post_ancestors( $src ) as $anc ) {
				$aretes[ $src->ID ][ $anc ] = true;
			}
		}
		// Page des articles : elle mène à chaque article.
		if ( $blog && $src->ID === $blog ) {
			foreach ( $toutes as $art ) {
				if ( 'post' === $art->post_type ) {
					$aretes[ $blog ][ $art->ID ] = true;
					$recus[ $art->ID ][ $blog ]  = true;
				}
			}
		}
	}

	// Le menu : présent sur toutes les pages, il compte pour la profondeur.
	$menu = array();
	foreach ( get_posts( array( 'post_type' => 'wp_navigation', 'post_status' => 'publish', 'posts_per_page' => 5 ) ) as $nav ) {
		if ( preg_match_all( '/"id":(\d+)/', $nav->post_content, $ids ) ) {
			foreach ( $ids[1] as $id ) {
				$menu[ (int) $id ] = true;
			}
		}
	}

	// Profondeur : nombre de clics depuis l'accueil (menu compris).
	$prof = array();
	if ( $accueil ) {
		$prof[ $accueil ] = 0;
		$file             = array( $accueil );
		foreach ( array_keys( $menu ) as $id ) {
			if ( ! isset( $prof[ $id ] ) ) {
				$prof[ $id ] = 1;
				$file[]      = $id;
			}
		}
		while ( $file ) {
			$id = array_shift( $file );
			foreach ( array_keys( $aretes[ $id ] ?? array() ) as $c ) {
				if ( ! isset( $prof[ $c ] ) ) {
					$prof[ $c ] = $prof[ $id ] + 1;
					$file[]     = $c;
				}
			}
		}
	}

	$pages = array();
	foreach ( $toutes as $p ) {
		if ( ! briise_maillage_eligible( $p ) ) {
			continue;
		}
		$pages[] = array(
			'post'   => $p,
			'recus'  => count( $recus[ $p->ID ] ?? array() ),
			'menu'   => isset( $menu[ $p->ID ] ),
			'prof'   => $prof[ $p->ID ] ?? null,
			'accueil' => $p->ID === $accueil,
		);
	}
	usort( $pages, function ( $a, $b ) {
		return array( $a['accueil'] ? 0 : 1, $a['recus'] ) <=> array( $b['accueil'] ? 0 : 1, $b['recus'] );
	} );
	return compact( 'pages', 'casses', 'exclues', 'flous', 'accueil' );
}

/**
 * Photos d'en-tête : chaque page dont l'en-tête montre l'image mise en avant doit en avoir une,
 * assez grande pour rester nette (1 400 px à côté du texte, 2 400 px en bandeau pleine largeur).
 * Retourne [ [WP_Post, message], ... ].
 */
function briise_photos_entete() {
	$out = array();
	foreach ( get_posts( array( 'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => -1 ) ) as $p ) {
		$c = $p->post_content;
		if ( false !== strpos( $c, 'br-tete-photo' ) ) {
			$mini = 2400;
		} elseif ( false !== strpos( $c, 'br-tete-split' ) || false !== strpos( $c, 'br-tete-mosaique' ) ) {
			$mini = 1400;
		} else {
			continue;
		}
		$id = get_post_thumbnail_id( $p );
		if ( ! $id ) {
			$out[] = array( $p, 'aucune photo : ajouter une image mise en avant (panneau de droite > Page)' );
			continue;
		}
		$meta    = wp_get_attachment_metadata( $id );
		$largeur = (int) ( $meta['width'] ?? 0 );
		if ( $largeur && $largeur < $mini ) {
			$out[] = array( $p, 'photo de ' . $largeur . ' px de large, floue à l’écran : en choisir une d’au moins ' . number_format( $mini, 0, ',', ' ' ) . ' px' );
		}
	}
	return $out;
}

function briise_onglet_controle() {
	$r        = briise_maillage_analyse();
	// Le contrôle des couleurs vient du thème Briise (styles de section) ; absent avec un autre thème.
	$rythme   = function_exists( 'briise_rythme_analyse' ) ? briise_rythme_analyse() : null;
	$lien     = function ( $p ) {
		return '<a href="' . esc_url( get_edit_post_link( $p->ID ) ) . '">' . esc_html( get_the_title( $p ) ) . '</a>';
	};
	$alertes  = 0;
	$lignes   = '';
	foreach ( $r['pages'] as $l ) {
		$etat = 'OK';
		$cls  = 'br-ok';
		if ( $l['accueil'] ) {
			$etat = 'Accueil';
		} elseif ( 0 === $l['recus'] ) {
			$etat = $l['menu'] ? 'Aucun lien dans le texte : seul le menu y mène' : 'Page orpheline : aucun lien ne mène à cette page';
			$cls  = 'br-ko';
		} elseif ( 1 === $l['recus'] ) {
			$etat = 'Un seul lien : en ajouter un ou deux';
			$cls  = 'br-moyen';
		}
		if ( ! $l['accueil'] && ( null === $l['prof'] || $l['prof'] > 3 ) ) {
			$etat .= null === $l['prof'] ? ' ; inaccessible depuis l’accueil' : ' ; à ' . $l['prof'] . ' clics de l’accueil (3 au plus)';
			$cls   = 'br-ko';
		}
		$alertes += 'br-ok' === $cls || $l['accueil'] ? 0 : 1;
		$lignes  .= '<tr class="' . $cls . '"><td>' . $lien( $l['post'] ) . ( 'post' === $l['post']->post_type ? ' <span class="br-muted">(article)</span>' : '' ) . ( 'briise_realisation' === $l['post']->post_type ? ' <span class="br-muted">(' . esc_html( briise_realisations_mots()[0] ) . ')</span>' : '' ) . '</td><td>' . ( $l['accueil'] ? '–' : (int) $l['recus'] ) . '</td><td>' . ( null === $l['prof'] ? '–' : (int) $l['prof'] ) . '</td><td>' . esc_html( $etat ) . '</td></tr>';
	}
	?>
	<style>
		.br-controle td,.br-controle th{padding:.55rem .75rem}
		.br-controle tr.br-ko td:last-child{color:#b32d2e;font-weight:600}
		.br-controle tr.br-moyen td:last-child{color:#8a5a00;font-weight:600}
		.br-controle tr.br-ok td:last-child{color:#1e7e34}
		.br-bilan{font-size:1.05em;padding:.75rem 1rem;background:#fff;border-left:4px solid #1e7e34;max-width:60em}
		.br-bilan.br-a-voir{border-color:#b32d2e}
	</style>
	<h2>Contrôle du maillage interne</h2>
	<p style="max-width:60em">Les liens écrits dans le texte des pages disent à Google quelles pages comptent et de quoi elles parlent. Chaque page devrait recevoir au moins deux liens depuis d’autres pages (le menu et le pied de page ne comptent pas), et se trouver à trois clics au plus de l’accueil. L’analyse lit les contenus publiés ; elle est refaite à chaque ouverture de cet onglet.</p>
	<?php
	$photos = briise_photos_entete();
	$secu   = function_exists( 'briise_securite_points' ) ? briise_securite_points() : array();
	$orphelins = function_exists( 'briise_menu_orphelins' ) ? briise_menu_orphelins() : array();
	$total = $alertes + count( $r['casses'] ) + count( $r['exclues'] ) + count( $r['flous'] ) + count( (array) $rythme ) + ( function_exists( 'briise_realisations_minces' ) ? count( briise_realisations_minces() ) : 0 ) + count( $photos ) + count( $secu ) + count( $orphelins );
	echo '<p class="br-bilan' . ( $total ? ' br-a-voir' : '' ) . '">' . ( $total ? esc_html( $total . ' point' . ( $total > 1 ? 's' : '' ) . ' à corriger avant la mise en ligne.' ) : 'Aucun problème détecté : maillage et couleurs des sections en ordre.' ) . '</p>';
	if ( ! $r['accueil'] ) {
		echo '<p><strong>Aucune page d’accueil n’est définie</strong> (Réglages > Lecture) : la profondeur ne peut pas être calculée.</p>';
	}
	?>
	<table class="widefat striped br-controle" style="max-width:72em">
		<thead><tr><th>Page</th><th>Liens reçus dans le texte</th><th>Clics depuis l’accueil</th><th>État</th></tr></thead>
		<tbody><?php echo $lignes; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé ligne par ligne. ?></tbody>
	</table>
	<?php
	$listes = array(
		array( 'Liens cassés', 'Le lien mène à une page supprimée, en brouillon ou introuvable.', $r['casses'], function ( $c ) use ( $lien ) {
			return $lien( $c[0] ) . ' : « ' . esc_html( $c[2] ) . ' » vers <code>' . esc_html( $c[1] ) . '</code>';
		} ),
		array( 'Liens vers une page exclue de Google', 'Une page en noindex ou une page d’atterrissage ne doit pas recevoir de liens du site.', $r['exclues'], function ( $c ) use ( $lien ) {
			return $lien( $c[0] ) . ' : « ' . esc_html( $c[2] ) . ' » vers ' . $lien( $c[1] );
		} ),
		array( 'Textes de lien trop vagues', 'Le texte du lien doit dire où il mène (« nos escaliers en acier sur mesure » plutôt que « en savoir plus ») : c’est utile à Google et aux lecteurs d’écran.', $r['flous'], function ( $c ) use ( $lien ) {
			return $lien( $c[0] ) . ' : « ' . esc_html( $c[1] ) . ' »';
		} ),
	);
	foreach ( $listes as $l ) {
		if ( ! $l[2] ) {
			continue;
		}
		echo '<h3>' . esc_html( $l[0] ) . ' (' . count( $l[2] ) . ')</h3><p>' . esc_html( $l[1] ) . '</p><ul style="list-style:disc;padding-left:1.5em">';
		foreach ( $l[2] as $c ) {
			echo '<li>' . $l[3]( $c ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans la fonction.
		}
		echo '</ul>';
	}
	if ( $orphelins ) {
		echo '<h3>Sous-pages au menu sans leur page parente (' . count( $orphelins ) . ')</h3><p style="max-width:60em">Ces pages sont au premier niveau du menu parce que leur page parente n’y est pas : le menu s’allonge et devient difficile à lire. Cochez « Afficher dans le menu » sur la page parente : ses sous-pages passeront dans son sous-menu.</p><ul style="list-style:disc;padding-left:1.5em">';
		foreach ( $orphelins as $o ) {
			echo '<li>' . $lien( $o ) . ' : page parente « ' . esc_html( get_the_title( $o->post_parent ) ) . ' »</li>'; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans la fonction.
		}
		echo '</ul>';
	}
	if ( $secu ) {
		echo '<h3>Sécurité (' . count( $secu ) . ')</h3><p style="max-width:60em">À régler avant la mise en ligne. Certains points ne se règlent que sur le site en ligne (HTTPS, indexation).</p><ul style="list-style:disc;padding-left:1.5em">';
		foreach ( $secu as $pt ) {
			echo '<li><strong>' . esc_html( $pt[0] ) . '</strong> : ' . esc_html( $pt[1] ) . '</li>';
		}
		echo '</ul>';
	}
	if ( $photos ) {
		echo '<h3>Photos d’en-tête à revoir (' . count( $photos ) . ')</h3><p style="max-width:60em">L’en-tête de ces pages affiche leur image mise en avant. Trop petite, le navigateur l’agrandit et elle devient floue.</p><ul style="list-style:disc;padding-left:1.5em">';
		foreach ( $photos as $ph ) {
			echo '<li>' . $lien( $ph[0] ) . ' : ' . esc_html( $ph[1] ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans la fonction.
		}
		echo '</ul>';
	}
	if ( function_exists( 'briise_realisations_minces' ) && briise_realisations_minces() ) {
		$minces = briise_realisations_minces();
		echo '<h3>' . esc_html( briise_realisations_nom() ) . ' hors de Google (' . count( $minces ) . ')</h3><p style="max-width:60em">Moins de ' . (int) briise_realisation_seuil() . ' mots de texte : la fiche reste visible sur le site mais Google ne la montre pas (contenu trop mince). Raconter la demande et ce qui a été fait suffit à la faire entrer dans Google.</p><ul style="list-style:disc;padding-left:1.5em">';
		foreach ( $minces as $id ) {
			echo '<li>' . $lien( get_post( $id ) ) . ' : ' . (int) briise_realisation_nb_mots( $id ) . ' mots</li>'; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans la fonction.
		}
		echo '</ul>';
	}
	if ( null === $rythme ) {
		return;
	}
	?>
	<h2 style="margin-top:2.5em">Couleurs des sections</h2>
	<p style="max-width:60em">Deux sections qui se suivent avec le même fond se lisent comme un seul bloc : le visiteur ne voit plus où commence le sujet suivant. Alterner le blanc et les teintes de l’ambiance (fond, surface, nuance) ; garder la bande foncée pour l’appel à l’action. Pour changer un fond : sélectionner la section dans l’éditeur, puis onglet Styles > « Fond clair », « Fond teinté », « Fond nuancé » ou « Fond foncé ».</p>
	<?php
	if ( ! $rythme ) {
		echo '<p>Aucune section voisine de même couleur.</p>';
		return;
	}
	echo '<h3>Sections voisines de même couleur (' . count( $rythme ) . ')</h3><ul style="list-style:disc;padding-left:1.5em">';
	foreach ( $rythme as $x ) {
		echo '<li>' . $lien( $x[0] ) . ' : « ' . esc_html( $x[1] ) . ' » puis « ' . esc_html( $x[2] ) . ' » (fond ' . esc_html( $x[3] ) . ')</li>'; // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans la fonction.
	}
	echo '</ul>';
}
