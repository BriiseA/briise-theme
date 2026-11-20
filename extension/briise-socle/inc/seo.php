<?php
/**
 * Référencement intégré : title, meta description, Open Graph, noindex,
 * plan du site et données structurées schema.org, nourris par « Mon entreprise ».
 * Se coupe entièrement si la fonction est désactivée ou si une extension SEO est active.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

function briise_seo_actif() {
	return briise_fonction( 'seo' ) && ! briise_seo_plugin_active();
}

/**
 * Pages légales : jamais dans Google, quel que soit le réglage de la page.
 */
function briise_pages_noindex() {
	return apply_filters( 'briise_pages_noindex', array(
		'mentions-legales', 'legal-notice',
		'confidentialite', 'politique-de-confidentialite', 'privacy-policy',
		'cookies', 'politique-cookies', 'politique-de-cookies',
		'accessibilite', 'declaration-accessibilite',
		'cgv', 'conditions-generales-de-vente',
	) );
}

/**
 * Page légale : adresse de la liste ci-dessus, ou page déclarée comme
 * politique de confidentialité dans Réglages > Confidentialité.
 */
function briise_est_page_legale( $post ) {
	return $post && 'page' === $post->post_type && (
		in_array( $post->post_name, briise_pages_noindex(), true )
		|| (int) $post->ID === (int) get_option( 'wp_page_for_privacy_policy' )
	);
}

/**
 * Page d'atterrissage publicitaire : hors de Google, pour ne pas concurrencer
 * la page de service équivalente (Google Ads la visite quand même).
 */
function briise_est_atterrissage( $post ) {
	return $post && 'page-atterrissage' === get_page_template_slug( $post );
}

function briise_est_noindex( $post ) {
	return $post && ( get_post_meta( $post->ID, '_briise_noindex', true ) || briise_est_page_legale( $post ) || briise_est_atterrissage( $post )
		|| ( function_exists( 'briise_realisation_mince' ) && briise_realisation_mince( $post ) ) );
}

function briise_current_seo_post() {
	if ( is_home() && get_option( 'page_for_posts' ) ) {
		return get_post( get_option( 'page_for_posts' ) );
	}
	return is_singular() ? get_queried_object() : null;
}

function briise_meta_description() {
	$post = briise_current_seo_post();
	if ( ! $post ) {
		return briise_entreprise()['description'];
	}
	$desc = get_post_meta( $post->ID, '_briise_seo_desc', true );
	if ( ! $desc && has_excerpt( $post ) ) {
		$desc = $post->post_excerpt;
	}
	if ( ! $desc && (int) $post->ID === (int) get_option( 'page_on_front' ) ) {
		$desc = briise_entreprise()['description'];
	}
	if ( ! $desc ) {
		$desc = wp_trim_words( wp_strip_all_tags( strip_shortcodes( excerpt_remove_blocks( $post->post_content ) ) ), 26, '…' );
	}
	if ( ! trim( $desc ) ) {
		$desc = briise_entreprise()['description'];
	}
	return trim( preg_replace( '/\s+/', ' ', $desc ) );
}

/**
 * Image de partage : image mise en avant, sinon logo du site, sinon icône du site.
 */
function briise_image_partage( $post ) {
	if ( $post && has_post_thumbnail( $post ) ) {
		return get_the_post_thumbnail_url( $post, 'large' );
	}
	$logo = get_theme_mod( 'custom_logo' );
	if ( $logo ) {
		return wp_get_attachment_image_url( $logo, 'large' );
	}
	return get_site_icon_url( 512 );
}

/* ----- Balises de tête ----------------------------------------------------------- */

add_filter( 'pre_get_document_title', function ( $title ) {
	if ( ! briise_seo_actif() ) {
		return $title;
	}
	$post = briise_current_seo_post();
	if ( $post ) {
		$custom = get_post_meta( $post->ID, '_briise_seo_title', true );
		if ( $custom ) {
			return $custom;
		}
		if ( 'post' === $post->post_type ) {
			return get_the_title( $post ) . ' | ' . get_bloginfo( 'name' );
		}
	}
	return $title;
} );

add_filter( 'wp_robots', function ( $robots ) {
	if ( ! briise_seo_actif() ) {
		return $robots;
	}
	$post = briise_current_seo_post();
	if ( briise_est_noindex( $post ) || is_search() || is_404() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	if ( ! briise_fonction( 'blog' ) && ( is_category() || is_tag() || is_author() || is_date() ) ) {
		$robots['noindex'] = true;
	}
	return $robots;
} );

add_action( 'wp_head', function () {
	if ( ! briise_seo_actif() ) {
		return;
	}
	$desc  = briise_meta_description();
	$post  = briise_current_seo_post();
	$url   = $post ? get_permalink( $post ) : home_url( add_query_arg( array() ) );
	$image = briise_image_partage( $post );
	if ( $desc ) {
		printf( "<meta name=\"description\" content=\"%s\" />\n", esc_attr( $desc ) );
	}
	printf( "<meta property=\"og:locale\" content=\"fr_FR\" />\n<meta property=\"og:type\" content=\"%s\" />\n", ( $post && 'post' === $post->post_type ) ? 'article' : 'website' );
	printf( "<meta property=\"og:site_name\" content=\"%s\" />\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( "<meta property=\"og:title\" content=\"%s\" />\n", esc_attr( wp_get_document_title() ) );
	if ( $desc ) {
		printf( "<meta property=\"og:description\" content=\"%s\" />\n", esc_attr( $desc ) );
	}
	printf( "<meta property=\"og:url\" content=\"%s\" />\n", esc_url( $url ) );
	if ( $image ) {
		printf( "<meta property=\"og:image\" content=\"%s\" />\n<meta name=\"twitter:card\" content=\"summary_large_image\" />\n", esc_url( $image ) );
	}
}, 2 );

/* ----- Plan du site (wp-sitemap.xml) ------------------------------------------------ */

add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
	if ( briise_seo_actif() && ( 'users' === $name || ( 'taxonomies' === $name && ! briise_fonction( 'blog' ) ) ) ) {
		return false;
	}
	return $provider;
}, 10, 2 );

add_filter( 'wp_sitemaps_post_types', function ( $types ) {
	if ( briise_seo_actif() && ! briise_fonction( 'blog' ) ) {
		unset( $types['post'] );
	}
	return $types;
} );

add_filter( 'wp_sitemaps_posts_query_args', function ( $args ) {
	if ( ! briise_seo_actif() ) {
		return $args;
	}
	$exclus = get_posts( array(
		'post_type'      => 'any',
		'posts_per_page' => 200,
		'fields'         => 'ids',
		'meta_key'       => '_briise_noindex', // phpcs:ignore WordPress.DB.SlowDBQuery
		'meta_value'     => '1',              // phpcs:ignore WordPress.DB.SlowDBQuery
	) );
	foreach ( briise_pages_noindex() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			$exclus[] = $page->ID;
		}
	}
	$exclus = array_merge( $exclus, get_posts( array(
		'post_type'      => 'page',
		'posts_per_page' => 200,
		'fields'         => 'ids',
		'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
		'meta_value'     => 'page-atterrissage', // phpcs:ignore WordPress.DB.SlowDBQuery
	) ) );
	if ( get_option( 'wp_page_for_privacy_policy' ) ) {
		$exclus[] = (int) get_option( 'wp_page_for_privacy_policy' );
	}
	if ( function_exists( 'briise_realisations_minces' ) ) {
		$exclus = array_merge( $exclus, briise_realisations_minces() );
	}
	$args['post__not_in'] = array_merge( isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array(), $exclus );
	return $args;
} );

/* ----- Encadré « Référencement » dans l'éditeur ----------------------------------- */

add_action( 'add_meta_boxes', function () {
	if ( ! briise_seo_actif() ) {
		return;
	}
	add_meta_box( 'briise-seo', 'Référencement (Google)', 'briise_encadre_seo', array( 'page', 'post', 'briise_realisation' ), 'normal', 'high' );
} );

function briise_encadre_seo( $post ) {
	wp_nonce_field( 'briise_seo', 'briise_seo_nonce' );
	$titre  = get_post_meta( $post->ID, '_briise_seo_title', true );
	$desc   = get_post_meta( $post->ID, '_briise_seo_desc', true );
	$legal  = briise_est_page_legale( $post );
	$exclu  = $legal || get_post_meta( $post->ID, '_briise_noindex', true );
	$lien   = get_permalink( $post );
	?>
	<style>
		.br-seo label { display: block; font-weight: 600; margin: 12px 0 4px; }
		.br-seo input[type=text], .br-seo textarea { width: 100%; }
		.br-seo .br-compte { font-size: 12px; color: #50575e; margin-top: 3px; }
		.br-seo .br-compte.br-long { color: #b32d2e; font-weight: 600; }
		.br-apercu { border: 1px solid #dcdcde; border-radius: 8px; padding: 12px 14px; margin-top: 14px; max-width: 600px; font-family: arial, sans-serif; background: #fff; }
		.br-apercu-url { font-size: 12px; color: #4d5156; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
		.br-apercu-titre { font-size: 18px; color: #1a0dab; line-height: 1.3; margin: 3px 0; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
		.br-apercu-desc { font-size: 13px; color: #4d5156; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
	</style>
	<div class="br-seo">
		<p style="margin-top:0">Ce que Google affiche dans ses résultats. Laissés vides, le titre de la page et le début du texte sont utilisés.</p>
		<label for="br-seo-titre">Titre pour Google</label>
		<input type="text" id="br-seo-titre" name="briise_seo_title" value="<?php echo esc_attr( $titre ); ?>" data-max="60" placeholder="<?php echo esc_attr( wp_strip_all_tags( get_the_title( $post ) ) . ' | ' . get_bloginfo( 'name' ) ); ?>">
		<div class="br-compte" data-pour="br-seo-titre"></div>
		<label for="br-seo-desc">Description pour Google</label>
		<textarea id="br-seo-desc" name="briise_seo_desc" rows="3" data-max="155" placeholder="Deux phrases qui donnent envie de cliquer : ce que la personne trouvera sur cette page, et pour qui."><?php echo esc_textarea( $desc ); ?></textarea>
		<div class="br-compte" data-pour="br-seo-desc"></div>
		<div class="br-apercu" aria-hidden="true">
			<div class="br-apercu-url"><?php echo esc_html( preg_replace( '#^https?://#', '', $lien ) ); ?></div>
			<div class="br-apercu-titre"></div>
			<div class="br-apercu-desc"></div>
		</div>
		<p style="margin-top:14px">
			<?php if ( $legal ) : ?>
				<em>Page légale : elle est automatiquement exclue de Google.</em>
			<?php elseif ( briise_est_atterrissage( $post ) ) : ?>
				<em>Page d’atterrissage publicitaire : elle est exclue de Google pour ne pas concurrencer la page de service. Google Ads la visite quand même.</em>
			<?php else : ?>
				<label style="font-weight:400;display:inline"><input type="checkbox" name="briise_noindex" value="1" <?php checked( $exclu ); ?>> Ne pas afficher cette page dans Google</label>
			<?php endif; ?>
		</p>
	</div>
	<script>
	( function () {
		var box = document.getElementById( 'briise-seo' );
		if ( ! box ) { return; }
		var t = box.querySelector( '#br-seo-titre' ), d = box.querySelector( '#br-seo-desc' );
		var at = box.querySelector( '.br-apercu-titre' ), ad = box.querySelector( '.br-apercu-desc' );
		var maj = function () {
			[ t, d ].forEach( function ( f ) {
				var c = box.querySelector( '[data-pour="' + f.id + '"]' ), n = f.value.length, max = +f.dataset.max;
				c.textContent = n ? n + ' caractères sur ' + max + ' conseillés' + ( n > max ? ' : trop long, Google coupera.' : '' ) : '';
				c.classList.toggle( 'br-long', n > max );
			} );
			at.textContent = t.value || t.placeholder;
			ad.textContent = d.value || 'Début du texte de la page…';
		};
		t.addEventListener( 'input', maj );
		d.addEventListener( 'input', maj );
		maj();
	}() );
	</script>
	<?php
}

add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['briise_seo_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['briise_seo_nonce'] ), 'briise_seo' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$champs = array(
		'_briise_seo_title' => sanitize_text_field( wp_unslash( $_POST['briise_seo_title'] ?? '' ) ),
		'_briise_seo_desc'  => sanitize_textarea_field( wp_unslash( $_POST['briise_seo_desc'] ?? '' ) ),
		'_briise_noindex'   => empty( $_POST['briise_noindex'] ) ? '' : '1',
	);
	foreach ( $champs as $cle => $val ) {
		if ( '' === $val ) {
			delete_post_meta( $post_id, $cle );
		} else {
			update_post_meta( $post_id, $cle, $val );
		}
	}
} );

/* ----- Données structurées ---------------------------------------------------------- */

function briise_schema_horaires() {
	if ( ! briise_horaires_renseignes() ) {
		return null;
	}
	$a      = briise_reglage( 'briise_annonces' );
	$noms   = array( 1 => 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
	$plages = array();
	foreach ( $a['jours'] as $n => $j ) {
		if ( ! $j['ouvert'] ) {
			continue;
		}
		foreach ( $j['plages'] as $p ) {
			if ( $p[0] && $p[1] ) {
				$plages[ $p[0] . '-' . $p[1] ][] = $noms[ $n ];
			}
		}
	}
	$out = array();
	foreach ( $plages as $heures => $jours ) {
		list( $de, $a2 ) = explode( '-', $heures );
		$out[] = array( '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => $jours, 'opens' => $de, 'closes' => $a2 );
	}
	return $out;
}

function briise_schema_fermetures() {
	$out = array();
	foreach ( briise_fermetures_a_venir() as $f ) {
		// Convention Google : ouverture et fermeture à 00:00 = fermé toute la journée.
		$out[] = array( '@type' => 'OpeningHoursSpecification', 'validFrom' => $f['du'], 'validThrough' => $f['au'], 'opens' => '00:00', 'closes' => '00:00' );
	}
	return $out ? $out : null;
}

function briise_schema_business() {
	$s       = briise_entreprise();
	$home    = home_url( '/' );
	$address = array_filter( array(
		'@type'           => 'PostalAddress',
		'streetAddress'   => $s['street'],
		'postalCode'      => $s['postal_code'],
		'addressLocality' => $s['city'],
		'addressCountry'  => $s['country'],
	) );
	$logo  = get_theme_mod( 'custom_logo' ) ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : '';
	$image = briise_image_partage( get_post( get_option( 'page_on_front' ) ) );
	$data  = array(
		'@type'       => $s['type'] ? $s['type'] : 'LocalBusiness',
		'@id'         => $home . '#entreprise',
		'name'        => $s['name'],
		'legalName'   => $s['legal_name'] && $s['legal_name'] !== $s['name'] ? $s['legal_name'] : null,
		'description' => $s['description'],
		'url'         => $home,
		'logo'        => $logo,
		'image'       => $image,
		'email'       => $s['email'],
		'telephone'   => $s['telephone'],
		'priceRange'  => $s['price_range'],
		'address'     => count( $address ) > 2 ? $address : null,
		'geo'         => ( '' !== $s['latitude'] && '' !== $s['longitude'] ) ? array( '@type' => 'GeoCoordinates', 'latitude' => (float) $s['latitude'], 'longitude' => (float) $s['longitude'] ) : null,
		'hasMap'      => briise_lien_itineraire(),
		'openingHoursSpecification'        => briise_schema_horaires(),
		'specialOpeningHoursSpecification' => briise_schema_fermetures(),
		'areaServed'  => $s['areas'] ? array_map( function ( $a ) { return array( '@type' => 'Place', 'name' => $a ); }, $s['areas'] ) : null,
		'sameAs'      => $s['same_as'] ? $s['same_as'] : null,
		'founder'     => $s['person_name'] ? array( '@id' => briise_person_url() . '#personne' ) : null,
	);
	$data = apply_filters( 'briise_schema_entreprise', $data );
	return array_filter( $data, function ( $v ) { return null !== $v && '' !== $v && array() !== $v; } );
}

function briise_person_url() {
	$s = briise_entreprise();
	return $s['person_id'] ? get_permalink( $s['person_id'] ) : home_url( '/' );
}

function briise_schema_person() {
	$s = briise_entreprise();
	return array_filter( array(
		'@type'    => 'Person',
		'@id'      => briise_person_url() . '#personne',
		'name'     => $s['person_name'],
		'jobTitle' => $s['person_job'],
		'worksFor' => array( '@id' => home_url( '/' ) . '#entreprise' ),
		'url'      => briise_person_url(),
	) );
}

function briise_schema_faq( $post ) {
	$items = array();
	$walk  = function ( $blocks ) use ( &$walk, &$items ) {
		foreach ( $blocks as $block ) {
			if ( 'core/details' === $block['blockName'] && preg_match( '#<summary[^>]*>(.*?)</summary>#s', $block['innerHTML'], $m ) ) {
				$answer = '';
				foreach ( $block['innerBlocks'] as $inner ) {
					$answer .= ' ' . html_entity_decode( wp_strip_all_tags( render_block( $inner ) ), ENT_QUOTES, 'UTF-8' );
				}
				$items[] = array(
					'@type'          => 'Question',
					'name'           => html_entity_decode( wp_strip_all_tags( $m[1] ), ENT_QUOTES, 'UTF-8' ),
					'acceptedAnswer' => array( '@type' => 'Answer', 'text' => trim( preg_replace( '/\s+/', ' ', $answer ) ) ),
				);
			}
			if ( ! empty( $block['innerBlocks'] ) ) {
				$walk( $block['innerBlocks'] );
			}
		}
	};
	$walk( parse_blocks( $post->post_content ) );
	return $items ? array( '@type' => 'FAQPage', 'mainEntity' => $items ) : null;
}

function briise_schema_breadcrumb( $post ) {
	$items = array( array( 'name' => 'Accueil', 'item' => home_url( '/' ) ) );
	if ( 'post' === $post->post_type && get_option( 'page_for_posts' ) ) {
		$items[] = array( 'name' => get_the_title( get_option( 'page_for_posts' ) ), 'item' => get_permalink( get_option( 'page_for_posts' ) ) );
	}
	if ( 'briise_realisation' === $post->post_type && function_exists( 'briise_realisations_page' ) && briise_realisations_page() ) {
		$items[] = array( 'name' => wp_strip_all_tags( get_the_title( briise_realisations_page() ) ), 'item' => get_permalink( briise_realisations_page() ) );
	}
	foreach ( array_reverse( get_post_ancestors( $post ) ) as $parent ) {
		$items[] = array( 'name' => wp_strip_all_tags( get_the_title( $parent ) ), 'item' => get_permalink( $parent ) );
	}
	$items[] = array( 'name' => wp_strip_all_tags( get_the_title( $post ) ), 'item' => get_permalink( $post ) );
	foreach ( $items as $i => $it ) {
		$items[ $i ] = array( '@type' => 'ListItem', 'position' => $i + 1 ) + $it;
	}
	return array( '@type' => 'BreadcrumbList', 'itemListElement' => $items );
}

add_action( 'wp_head', function () {
	if ( ! briise_seo_actif() ) {
		return;
	}
	$graph   = array( briise_schema_business() );
	$post    = briise_current_seo_post();
	$company = briise_entreprise();
	if ( $post && (int) $post->ID !== (int) get_option( 'page_on_front' ) ) {
		$graph[] = briise_schema_breadcrumb( $post );
	}
	if ( $post && $company['person_name'] && (int) $company['person_id'] === (int) $post->ID ) {
		$graph[] = briise_schema_person();
	}
	// Questions-réponses : sur toute page qui contient des accordéons (pages de service comprises).
	if ( $post && 'page' === $post->post_type && has_block( 'core/details', $post ) ) {
		$faq = briise_schema_faq( $post );
		if ( $faq ) {
			$graph[] = $faq;
		}
	}
	if ( $post && 'post' === $post->post_type ) {
		$graph[] = array_filter( array(
			'@type'            => 'Article',
			'headline'         => wp_strip_all_tags( get_the_title( $post ) ),
			'description'      => briise_meta_description(),
			'image'            => has_post_thumbnail( $post ) ? get_the_post_thumbnail_url( $post, 'large' ) : null,
			'datePublished'    => get_the_date( 'c', $post ),
			'dateModified'     => get_the_modified_date( 'c', $post ),
			'author'           => $company['person_name'] ? briise_schema_person() : array( '@id' => home_url( '/' ) . '#entreprise' ),
			'publisher'        => array( '@id' => home_url( '/' ) . '#entreprise' ),
			'mainEntityOfPage' => get_permalink( $post ),
		) );
	}
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n";
}, 5 );
