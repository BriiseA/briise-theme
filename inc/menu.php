<?php
/**
 * Menu principal piloté depuis chaque page : une case « Afficher dans le menu ».
 * Une sous-page se range en sous-menu sous sa page parente si celle-ci est au menu.
 * Le menu reste un menu WordPress normal, modifiable dans Apparence > Éditeur > Navigation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Le menu affiché par l'en-tête : le plus récent publié (comportement du bloc Navigation).
 */
function briise_menu_id( $creer = false ) {
	$menus = get_posts( array( 'post_type' => 'wp_navigation', 'post_status' => 'publish', 'numberposts' => 1, 'orderby' => 'date', 'order' => 'DESC' ) );
	if ( $menus ) {
		return $menus[0]->ID;
	}
	if ( ! $creer ) {
		return 0;
	}
	return (int) wp_insert_post( array( 'post_type' => 'wp_navigation', 'post_status' => 'publish', 'post_title' => 'Menu principal', 'post_content' => '' ) );
}

function briise_menu_lien( $page_id, $enfants = array() ) {
	$attrs = array(
		'label' => wp_strip_all_tags( get_the_title( $page_id ) ),
		'type'  => 'page',
		'id'    => (int) $page_id,
		'url'   => get_permalink( $page_id ),
		'kind'  => 'post-type',
	);
	if ( $enfants ) {
		return array( 'blockName' => 'core/navigation-submenu', 'attrs' => $attrs, 'innerBlocks' => $enfants, 'innerHTML' => '', 'innerContent' => array_fill( 0, count( $enfants ), null ) );
	}
	return array( 'blockName' => 'core/navigation-link', 'attrs' => $attrs, 'innerBlocks' => array(), 'innerHTML' => '', 'innerContent' => array() );
}

function briise_menu_blocs( $menu_id ) {
	return array_values( array_filter( parse_blocks( get_post_field( 'post_content', $menu_id ) ), function ( $b ) {
		return ! empty( $b['blockName'] );
	} ) );
}

function briise_menu_enregistrer( $menu_id, $blocs ) {
	wp_update_post( wp_slash( array( 'ID' => $menu_id, 'post_content' => serialize_blocks( $blocs ) ) ) );
}

/**
 * La page est-elle au menu ? (à n'importe quel niveau)
 */
function briise_menu_contient( $blocs, $page_id ) {
	foreach ( $blocs as $b ) {
		if ( (int) ( $b['attrs']['id'] ?? 0 ) === (int) $page_id ) {
			return true;
		}
		if ( ! empty( $b['innerBlocks'] ) && briise_menu_contient( $b['innerBlocks'], $page_id ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Retire la page (et la remonte d'un niveau si le sous-menu se vide).
 */
function briise_menu_retirer( $blocs, $page_id ) {
	$out = array();
	foreach ( $blocs as $b ) {
		if ( (int) ( $b['attrs']['id'] ?? 0 ) === (int) $page_id ) {
			continue;
		}
		if ( ! empty( $b['innerBlocks'] ) ) {
			$b['innerBlocks'] = briise_menu_retirer( $b['innerBlocks'], $page_id );
			if ( ! $b['innerBlocks'] && 'core/navigation-submenu' === $b['blockName'] ) {
				$b = briise_menu_lien( $b['attrs']['id'] ?? 0 ) + array();
				if ( empty( $b['attrs']['id'] ) ) {
					continue;
				}
			} else {
				$b['innerContent'] = array_fill( 0, count( $b['innerBlocks'] ), null );
			}
		}
		$out[] = $b;
	}
	return $out;
}

/**
 * Ajoute la page : sous sa page parente si celle-ci est au menu, sinon à la fin.
 */
function briise_menu_ajouter( $blocs, $page_id ) {
	$parent = (int) wp_get_post_parent_id( $page_id );
	if ( $parent ) {
		foreach ( $blocs as $i => $b ) {
			if ( (int) ( $b['attrs']['id'] ?? 0 ) === $parent ) {
				$enfants             = $b['innerBlocks'] ?? array();
				$enfants[]           = briise_menu_lien( $page_id );
				$blocs[ $i ]         = briise_menu_lien( $parent, $enfants );
				$blocs[ $i ]['attrs'] = array_merge( $b['attrs'], $blocs[ $i ]['attrs'] );
				return $blocs;
			}
			if ( ! empty( $b['innerBlocks'] ) ) {
				$sous = briise_menu_ajouter( $b['innerBlocks'], $page_id );
				if ( $sous !== $b['innerBlocks'] ) {
					$blocs[ $i ]['innerBlocks']  = $sous;
					$blocs[ $i ]['innerContent'] = array_fill( 0, count( $sous ), null );
					return $blocs;
				}
			}
		}
	}
	$blocs[] = briise_menu_lien( $page_id );
	return $blocs;
}

/**
 * Met le libellé et l'adresse d'une page à jour partout où elle apparaît dans le menu.
 */
function briise_menu_actualiser( $blocs, $page_id ) {
	foreach ( $blocs as $i => $b ) {
		if ( (int) ( $b['attrs']['id'] ?? 0 ) === (int) $page_id ) {
			$blocs[ $i ]['attrs']['label'] = wp_strip_all_tags( get_the_title( $page_id ) );
			$blocs[ $i ]['attrs']['url']   = get_permalink( $page_id );
		}
		if ( ! empty( $b['innerBlocks'] ) ) {
			$blocs[ $i ]['innerBlocks'] = briise_menu_actualiser( $b['innerBlocks'], $page_id );
		}
	}
	return $blocs;
}

/**
 * Ajoute ou retire une page du menu. Utilisé par la case et par les kits.
 */
function briise_menu_definir( $page_id, $afficher ) {
	$menu_id = briise_menu_id( $afficher );
	if ( ! $menu_id ) {
		return;
	}
	$blocs = briise_menu_blocs( $menu_id );
	$dans  = briise_menu_contient( $blocs, $page_id );
	if ( $afficher && ! $dans ) {
		$blocs = briise_menu_ajouter( $blocs, $page_id );
	} elseif ( ! $afficher && $dans ) {
		$blocs = briise_menu_retirer( $blocs, $page_id );
	} elseif ( $dans ) {
		$blocs = briise_menu_actualiser( $blocs, $page_id );
	} else {
		return;
	}
	briise_menu_enregistrer( $menu_id, $blocs );
}

/* ----- La case dans l'éditeur de page ------------------------------------------ */

add_action( 'add_meta_boxes_page', function ( $post ) {
	add_meta_box( 'briise-menu', 'Menu du site', function ( $post ) {
		$menu_id = briise_menu_id();
		$dans    = $menu_id && briise_menu_contient( briise_menu_blocs( $menu_id ), $post->ID );
		$accueil = (int) $post->ID === (int) get_option( 'page_on_front' );
		wp_nonce_field( 'briise_menu', 'briise_menu_nonce' );
		if ( $accueil ) {
			echo '<p style="margin:0">L’accueil est accessible par le logo : inutile de l’ajouter au menu.</p>';
			return;
		}
		echo '<label><input type="checkbox" name="briise_menu" value="1" ' . checked( $dans, true, false ) . '> Afficher dans le menu</label>';
		echo '<p class="description" style="margin-top:6px">Une sous-page apparaît en sous-menu sous sa page parente. Ordre et regroupements : Apparence &gt; Éditeur &gt; Navigation.</p>';
	}, 'page', 'side', 'high' );
} );

add_action( 'save_post_page', function ( $post_id, $post ) {
	if ( ! isset( $_POST['briise_menu_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['briise_menu_nonce'] ), 'briise_menu' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	// Une page en brouillon n'apparaît pas encore : elle sera ajoutée à sa publication.
	$afficher = ! empty( $_POST['briise_menu'] );
	if ( 'publish' !== $post->post_status ) {
		update_post_meta( $post_id, '_briise_menu_attente', $afficher ? '1' : '' );
		if ( ! $afficher ) {
			briise_menu_definir( $post_id, false );
		}
		return;
	}
	briise_menu_definir( $post_id, $afficher );
}, 10, 2 );

// Brouillon coché, puis publié : il rejoint le menu.
add_action( 'transition_post_status', function ( $nouveau, $ancien, $post ) {
	if ( 'page' === $post->post_type && 'publish' === $nouveau && 'publish' !== $ancien && get_post_meta( $post->ID, '_briise_menu_attente', true ) ) {
		delete_post_meta( $post->ID, '_briise_menu_attente' );
		briise_menu_definir( $post->ID, true );
	}
}, 10, 3 );

// Une page mise à la corbeille quitte le menu.
add_action( 'wp_trash_post', function ( $post_id ) {
	if ( 'page' === get_post_type( $post_id ) ) {
		briise_menu_definir( $post_id, false );
	}
} );
