<?php
/**
 * SEO intégré au thème : title, meta description, Open Graph,
 * noindex des pages légales et données structurées schema.org.
 * Tout se désactive automatiquement si une extension SEO est active.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'AIOSEO_VERSION' );
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
		return get_bloginfo( 'description' );
	}
	$desc = get_post_meta( $post->ID, '_briise_seo_desc', true );
	if ( ! $desc && has_excerpt( $post ) ) {
		$desc = $post->post_excerpt;
	}
	if ( ! $desc ) {
		$desc = wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 26, '…' );
	}
	return trim( preg_replace( '/\s+/', ' ', $desc ) );
}

add_filter( 'pre_get_document_title', function ( $title ) {
	if ( briise_seo_plugin_active() ) {
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
	$post = briise_current_seo_post();
	if ( $post && get_post_meta( $post->ID, '_briise_noindex', true ) ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
} );

add_action( 'wp_head', function () {
	if ( briise_seo_plugin_active() ) {
		return;
	}
	$desc  = briise_meta_description();
	$post  = briise_current_seo_post();
	$url   = $post ? get_permalink( $post ) : home_url( '/' );
	$image = ( $post && has_post_thumbnail( $post ) ) ? get_the_post_thumbnail_url( $post, 'large' ) : get_theme_file_uri( 'screenshot.png' );
	printf( "<meta name=\"description\" content=\"%s\" />\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:locale\" content=\"fr_FR\" />\n<meta property=\"og:type\" content=\"%s\" />\n", ( $post && 'post' === $post->post_type ) ? 'article' : 'website' );
	printf( "<meta property=\"og:site_name\" content=\"%s\" />\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( "<meta property=\"og:title\" content=\"%s\" />\n", esc_attr( wp_get_document_title() ) );
	printf( "<meta property=\"og:description\" content=\"%s\" />\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:url\" content=\"%s\" />\n", esc_url( $url ) );
	printf( "<meta property=\"og:image\" content=\"%s\" />\n<meta name=\"twitter:card\" content=\"summary_large_image\" />\n", esc_url( $image ) );
}, 2 );

/**
 * Données structurées.
 */
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
	$data = array(
		'@type'       => $s['type'] ? $s['type'] : 'LocalBusiness',
		'@id'         => $home . '#entreprise',
		'name'        => $s['name'],
		'description' => $s['description'],
		'url'         => $home,
		'email'       => $s['email'],
		'telephone'   => $s['telephone'],
		'priceRange'  => $s['price_range'],
		'address'     => count( $address ) > 1 ? $address : null,
		'geo'         => ( '' !== $s['latitude'] && '' !== $s['longitude'] ) ? array( '@type' => 'GeoCoordinates', 'latitude' => $s['latitude'], 'longitude' => $s['longitude'] ) : null,
		'areaServed'  => $s['areas'] ? array_map( function ( $a ) { return array( '@type' => 'Place', 'name' => $a ); }, $s['areas'] ) : null,
		'sameAs'      => $s['same_as'] ? $s['same_as'] : null,
		'founder'     => $s['person_name'] ? array( '@id' => briise_person_url() . '#personne' ) : null,
	);
	return array_filter( $data, function ( $v ) { return null !== $v && '' !== $v; } );
}

function briise_person_url() {
	$s    = briise_entreprise();
	$page = $s['person_page'] ? get_page_by_path( $s['person_page'] ) : null;
	return $page ? get_permalink( $page ) : home_url( '/' );
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
		'sameAs'   => $s['same_as'] ? $s['same_as'] : null,
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
	$items = array( array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => home_url( '/' ) ) );
	if ( 'post' === $post->post_type && get_option( 'page_for_posts' ) ) {
		$items[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => get_the_title( get_option( 'page_for_posts' ) ), 'item' => get_permalink( get_option( 'page_for_posts' ) ) );
	}
	$items[] = array( '@type' => 'ListItem', 'position' => count( $items ) + 1, 'name' => wp_strip_all_tags( get_the_title( $post ) ), 'item' => get_permalink( $post ) );
	return array( '@type' => 'BreadcrumbList', 'itemListElement' => $items );
}

add_action( 'wp_head', function () {
	if ( briise_seo_plugin_active() ) {
		return;
	}
	$graph = array( briise_schema_business() );
	$post  = briise_current_seo_post();
	if ( $post && (int) $post->ID !== (int) get_option( 'page_on_front' ) ) {
		$graph[] = briise_schema_breadcrumb( $post );
	}
	$company = briise_entreprise();
	if ( $post && $company['person_name'] && $company['person_page'] === $post->post_name ) {
		$graph[] = briise_schema_person();
	}
	if ( $post && 'page' === $post->post_type ) {
		$faq = briise_schema_faq( $post );
		if ( $faq && $company['faq_page'] === $post->post_name ) {
			$graph[] = $faq;
		}
	}
	if ( $post && 'post' === $post->post_type ) {
		$graph[] = array(
			'@type'         => 'Article',
			'headline'      => wp_strip_all_tags( get_the_title( $post ) ),
			'description'   => briise_meta_description(),
			'datePublished' => get_the_date( 'c', $post ),
			'dateModified'  => get_the_modified_date( 'c', $post ),
			'author'        => $company['person_name'] ? briise_schema_person() : array( '@id' => home_url( '/' ) . '#entreprise' ),
			'publisher'     => array( '@id' => home_url( '/' ) . '#entreprise' ),
			'mainEntityOfPage' => get_permalink( $post ),
		);
	}
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n";
}, 5 );
