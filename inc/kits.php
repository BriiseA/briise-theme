<?php
/**
 * Kits de démarrage : créent en un clic les pages d'un site selon le type
 * d'activité, les pages légales, le menu et les réglages qui les relient.
 * Contenu des kits : inc/kits.json (généré par l'outil de l'agence, blocs validés).
 * Une page dont l'adresse existe déjà n'est jamais modifiée.
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
 * Remplace les repères du kit ({{CTA}}, {{URL:…}}, {{IMG:…}}) par les vraies adresses.
 */
function briise_kit_remplir( $markup, $liens, $pages ) {
	$e   = briise_entreprise();
	$url = function ( $slug ) use ( $liens, $pages ) {
		$cible = $liens[ $slug ] ?? $slug;
		return isset( $pages[ $cible ] ) ? get_permalink( $pages[ $cible ] ) : home_url( '/' . ( $cible ? $cible . '/' : '' ) );
	};
	$markup = preg_replace_callback( '/\{\{IMG:([a-z0-9-]+)\}\}/', function ( $m ) {
		return esc_url( get_theme_file_uri( 'assets/images/sections/' . $m[1] . '.svg' ) );
	}, $markup );
	$markup = preg_replace_callback( '/\{\{URL:([a-z0-9-]*)\}\}/', function ( $m ) use ( $url ) {
		return esc_url( '' === $m[1] ? home_url( '/' ) : $url( $m[1] ) );
	}, $markup );
	return str_replace(
		array( '{{CTA_LABEL}}', '{{CTA}}' ),
		array( esc_html( $e['cta_label'] ), esc_url( $e['cta_url'] ) ),
		$markup
	);
}

/**
 * Installe un kit. Retourne [ 'crees' => [titres], 'gardes' => [titres] ].
 */
function briise_kit_installer( $cle ) {
	$data = briise_kits();
	if ( empty( $data['kits'][ $cle ] ) ) {
		return new WP_Error( 'kit', 'Kit inconnu.' );
	}
	$kit    = $data['kits'][ $cle ];
	$toutes = array_merge( $kit['pages'], $data['legales'] );
	$ids    = array();
	$crees  = array();
	$gardes = array();

	// 1. Les pages, vides pour l'instant : il faut leurs adresses pour relier les liens.
	foreach ( $toutes as $p ) {
		$existe = get_page_by_path( $p['slug'], OBJECT, 'page' );
		if ( $existe && 'trash' !== $existe->post_status ) {
			$ids[ $p['slug'] ] = $existe->ID;
			$gardes[]          = $p['titre'];
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => $p['titre'],
			'post_name'   => $p['slug'],
			'menu_order'  => count( $ids ),
		), true );
		if ( ! is_wp_error( $id ) ) {
			$ids[ $p['slug'] ] = $id;
			$crees[ $id ]      = $p;
		}
	}

	// 2. Les réglages qui relient les pages entre elles.
	$e = briise_reglage( 'briise_entreprise' );
	if ( ! empty( $ids[ $kit['page_cta'] ] ) ) {
		$e['cta_page'] = $ids[ $kit['page_cta'] ];
		$e['cta_url']  = '';
	}
	if ( 'Nous contacter' === $e['cta_label'] || '' === $e['cta_label'] ) {
		$e['cta_label'] = $kit['cta'];
	}
	if ( $kit['page_personne'] && ! empty( $ids[ $kit['page_personne'] ] ) ) {
		$e['person_page'] = $ids[ $kit['page_personne'] ];
	}
	if ( $kit['page_faq'] && ! empty( $ids[ $kit['page_faq'] ] ) ) {
		$e['faq_page'] = $ids[ $kit['page_faq'] ];
	}
	update_option( 'briise_entreprise', $e );

	// 3. Le contenu des pages créées, avec les vrais liens.
	foreach ( $crees as $id => $p ) {
		if ( '' === $p['markup'] ) {
			continue;
		}
		wp_update_post( wp_slash( array(
			'ID'           => $id,
			'post_content' => briise_kit_remplir( $p['markup'], $kit['liens'], $ids ),
		) ) );
		update_post_meta( $id, '_wp_page_template', 'page-sans-titre' );
	}

	// 4. Accueil, blog, confidentialité.
	if ( ! empty( $ids['accueil'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['accueil'] );
	}
	if ( $kit['blog'] && ! empty( $ids['blog'] ) ) {
		update_option( 'page_for_posts', $ids['blog'] );
		$f         = briise_reglage( 'briise_fonctions' );
		$f['blog'] = true;
		update_option( 'briise_fonctions', $f );
	}
	if ( ! empty( $ids['confidentialite'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $ids['confidentialite'] );
	}

	// 5. Le menu : toutes les pages du kit sauf l'accueil (le logo y mène) et la page
	//    d'action (déjà en bouton dans l'en-tête).
	if ( ! get_posts( array( 'post_type' => 'wp_navigation', 'title' => 'Menu principal', 'post_status' => 'publish', 'numberposts' => 1 ) ) ) {
		$liens = '';
		foreach ( $kit['pages'] as $p ) {
			if ( in_array( $p['slug'], array( 'accueil', $kit['page_cta'] ), true ) || empty( $ids[ $p['slug'] ] ) ) {
				continue;
			}
			$liens .= '<!-- wp:navigation-link ' . wp_json_encode( array(
				'label' => $p['titre'],
				'type'  => 'page',
				'id'    => $ids[ $p['slug'] ],
				'url'   => get_permalink( $ids[ $p['slug'] ] ),
				'kind'  => 'post-type',
			), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . " /-->\n";
		}
		wp_insert_post( wp_slash( array(
			'post_type'    => 'wp_navigation',
			'post_status'  => 'publish',
			'post_title'   => 'Menu principal',
			'post_content' => $liens,
		) ) );
	}

	update_option( 'briise_kit', $cle );
	return array( 'crees' => wp_list_pluck( $crees, 'titre' ), 'gardes' => $gardes );
}

/* ----- Onglet « Démarrage » de Mon entreprise ------------------------------- */

add_action( 'admin_post_briise_kit', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'briise_kit' ) ) {
		wp_die( 'Accès refusé.' );
	}
	$cle = sanitize_key( $_POST['kit'] ?? '' );
	$r   = briise_kit_installer( $cle );
	set_transient( 'briise_kit_resultat_' . get_current_user_id(), is_wp_error( $r ) ? array( 'erreur' => $r->get_error_message() ) : $r, 120 );
	wp_safe_redirect( admin_url( 'admin.php?page=briise-entreprise&onglet=demarrage' ) );
	exit;
} );

function briise_onglet_demarrage() {
	$data   = briise_kits();
	$actuel = get_option( 'briise_kit' );
	$r      = get_transient( 'briise_kit_resultat_' . get_current_user_id() );
	if ( $r ) {
		delete_transient( 'briise_kit_resultat_' . get_current_user_id() );
		if ( isset( $r['erreur'] ) ) {
			echo '<div class="notice notice-error"><p>' . esc_html( $r['erreur'] ) . '</p></div>';
		} else {
			echo '<div class="notice notice-success"><p><strong>' . count( $r['crees'] ) . ' pages créées</strong>' . ( $r['crees'] ? ' : ' . esc_html( implode( ', ', $r['crees'] ) ) : '' ) . '.</p>';
			if ( $r['gardes'] ) {
				echo '<p>Pages existantes laissées telles quelles : ' . esc_html( implode( ', ', $r['gardes'] ) ) . '.</p>';
			}
			echo '<p>Prochaines étapes : remplir les onglets « Entreprise » et « Mentions légales », puis remplacer les textes et les photos d’exemple de chaque page.</p></div>';
		}
	}
	?>
	<h2 class="title">Créer les pages du site</h2>
	<p class="description">Choisissez le kit qui correspond à l’activité du client. Il crée les pages, les pages légales, le menu, et relie le bouton d’action, la page FAQ et la page de présentation. Une page dont l’adresse existe déjà n’est jamais modifiée.</p>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="briise_kit">
		<?php wp_nonce_field( 'briise_kit' ); ?>
		<div class="br-kits">
			<?php foreach ( $data['kits'] as $cle => $k ) : ?>
				<label class="br-kit">
					<input type="radio" name="kit" value="<?php echo esc_attr( $cle ); ?>" <?php checked( $actuel ? $actuel === $cle : 'prestataire' === $cle ); ?>>
					<strong><?php echo esc_html( $k['titre'] ); ?></strong>
					<span class="description"><?php echo esc_html( $k['pour'] ); ?></span>
					<span class="br-kit-pages"><?php echo esc_html( implode( ' · ', wp_list_pluck( $k['pages'], 'titre' ) ) ); ?></span>
					<span class="br-kit-cta">Bouton d’action : « <?php echo esc_html( $k['cta'] ); ?> »</span>
				</label>
			<?php endforeach; ?>
		</div>
		<p class="description">Dans les trois cas : Mentions légales, Politique de confidentialité, Cookies et Accessibilité.</p>
		<?php if ( $actuel ) : ?>
			<p><em>Kit déjà installé : <?php echo esc_html( $data['kits'][ $actuel ]['titre'] ?? $actuel ); ?>. Relancer ne crée que les pages manquantes. Choisir un autre kit ajoute ses pages sans supprimer les autres ni modifier le menu : à réserver à un site encore vide.</em></p>
		<?php endif; ?>
		<?php submit_button( 'Créer les pages', 'primary', 'submit', true ); ?>
	</form>
	<?php
}
