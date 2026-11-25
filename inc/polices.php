<?php
/**
 * Polices de la charte d'un client : titres, texte et accent.
 *
 * Réglées dans Mon entreprise > Apparence, ou par la clé « polices » du fichier de site :
 * "polices": { "titres": "Sora", "texte": "Figtree", "accent": "Instrument Serif", "accent_italique": true, "accent_taille": 1.15 }
 *
 * On choisit parmi les polices livrées avec le thème et celles téléversées dans
 * Styles > Typographie > Gérer les polices. Le choix est appliqué à chaque affichage
 * (filtre wp_theme_json_data_user) : il passe devant les polices de l'ambiance sans les effacer,
 * et reste en place si l'on change d'ambiance. Une valeur vide (« Selon l'ambiance ») ne change rien.
 *
 * La police d'accent sert au mot passé au Surlignage dans un titre (balise mark).
 * Sans police d'accent, ce mot garde la police des titres.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Rôles réglables et leur nom à l'écran. */
function briise_polices_roles() {
	return array(
		'titres' => 'Titres',
		'texte'  => 'Texte',
		'accent' => 'Accent (mot surligné dans un titre)',
		'chiffres' => 'Chiffres (prix, durées, compteurs, étiquettes numérotées)',
	);
}

/** Choix enregistrés. Valeur vide : la police de l'ambiance. */
function briise_polices() {
	$v = (array) get_option( 'briise_polices', array() );
	return array(
		'titres'          => (string) ( $v['titres'] ?? '' ),
		'texte'           => (string) ( $v['texte'] ?? '' ),
		'accent'          => (string) ( $v['accent'] ?? '' ),
		'chiffres'        => (string) ( $v['chiffres'] ?? '' ),
		'accent_italique' => ! empty( $v['accent_italique'] ),
		'accent_taille'   => briise_polices_taille( $v['accent_taille'] ?? '' ),
	);
}

/** Tailles proposées pour le mot d'accent (par rapport au reste du titre). */
function briise_polices_tailles() {
	return array(
		''     => 'Comme le titre',
		'1.08' => 'Un peu plus grand',
		'1.15' => 'Plus grand',
		'1.25' => 'Nettement plus grand',
	);
}

/** Taille d'accent valide : un rapport entre 0,8 et 1,4, ou vide (comme le titre). */
function briise_polices_taille( $v ) {
	$v = str_replace( ',', '.', trim( (string) $v ) );
	if ( '' === $v || ! is_numeric( $v ) ) {
		return '';
	}
	$f = round( (float) $v, 2 );
	return ( $f >= 0.8 && $f <= 1.4 && 1.0 !== $f ) ? rtrim( rtrim( number_format( $f, 2, '.', '' ), '0' ), '.' ) : '';
}

/**
 * Polices disponibles, par nom : celles du thème (theme.json et ambiances) et celles
 * de la bibliothèque de polices de WordPress. Les polices système (sans fichier) sont exclues.
 *
 * @return array nom => array( 'nom', 'fontFamily', 'fontFace', 'source' )
 */
function briise_polices_disponibles() {
	static $liste = null;
	if ( null !== $liste ) {
		return $liste;
	}
	$liste = array();

	// 1. Bibliothèque de polices (Styles > Typographie > Gérer les polices).
	if ( post_type_exists( 'wp_font_family' ) ) {
		$familles = get_posts( array( 'post_type' => 'wp_font_family', 'post_status' => 'publish', 'numberposts' => 200, 'orderby' => 'title', 'order' => 'ASC' ) );
		foreach ( $familles as $p ) {
			$reglages = json_decode( (string) $p->post_content, true );
			$faces    = array();
			$enfants  = get_posts( array( 'post_type' => 'wp_font_face', 'post_parent' => $p->ID, 'post_status' => 'publish', 'numberposts' => 100 ) );
			foreach ( $enfants as $fp ) {
				$face = json_decode( (string) $fp->post_content, true );
				if ( is_array( $face ) ) {
					$faces[] = $face;
				}
			}
			briise_polices_ajouter( $liste, array( 'fontFamily' => $reglages['fontFamily'] ?? $p->post_title, 'fontFace' => $faces ), 'bibliotheque' );
		}
	}

	// 2. Polices livrées avec le thème.
	$fichiers = array_merge( array( get_theme_file_path( 'theme.json' ) ), (array) glob( get_theme_file_path( 'styles' ) . '/*.json' ) );
	foreach ( array_filter( $fichiers ) as $f ) {
		$d = json_decode( (string) file_get_contents( $f ), true );
		foreach ( (array) ( $d['settings']['typography']['fontFamilies'] ?? array() ) as $ff ) {
			briise_polices_ajouter( $liste, $ff, 'theme' );
		}
	}

	uksort( $liste, 'strnatcasecmp' );
	return $liste;
}

/** Ajoute une famille à la liste, en réunissant ses fichiers s'il est déclaré plusieurs fois. */
function briise_polices_ajouter( &$liste, $ff, $source ) {
	$pile = (string) ( $ff['fontFamily'] ?? '' );
	$nom  = trim( explode( ',', $pile )[0], " \t'\"" );
	if ( '' === $nom || empty( $ff['fontFace'] ) ) {
		return;
	}
	if ( ! isset( $liste[ $nom ] ) ) {
		$liste[ $nom ] = array( 'nom' => $nom, 'fontFamily' => $pile, 'fontFace' => array(), 'source' => $source );
	}
	$deja = array_map( function ( $f ) {
		return wp_json_encode( $f['src'] ?? '' );
	}, $liste[ $nom ]['fontFace'] );
	foreach ( (array) $ff['fontFace'] as $face ) {
		if ( empty( $face['src'] ) || in_array( wp_json_encode( $face['src'] ), $deja, true ) ) {
			continue;
		}
		$face['fontFamily']          = $nom;
		$liste[ $nom ]['fontFace'][] = $face;
		$deja[]                      = wp_json_encode( $face['src'] );
	}
}

/** Retrouve une police par son nom, sans tenir compte des majuscules. */
function briise_polices_trouver( $nom ) {
	$nom = trim( (string) $nom, " \t'\"" );
	foreach ( array_keys( briise_polices_disponibles() ) as $cle ) {
		if ( 0 === strcasecmp( $cle, $nom ) ) {
			return $cle;
		}
	}
	return '';
}

/**
 * Enregistre les polices choisies. Seules les clés présentes changent.
 *
 * @return string[] Noms demandés mais introuvables (la police de l'ambiance reste en place).
 */
function briise_polices_enregistrer( $valeurs ) {
	$valeurs  = (array) $valeurs;
	$out      = briise_polices();
	$absentes = array();
	foreach ( array_keys( briise_polices_roles() ) as $role ) {
		if ( ! array_key_exists( $role, $valeurs ) ) {
			continue;
		}
		$demande = sanitize_text_field( (string) $valeurs[ $role ] );
		if ( '' === $demande ) {
			$out[ $role ] = '';
			continue;
		}
		$trouve = briise_polices_trouver( $demande );
		if ( $trouve ) {
			$out[ $role ] = $trouve;
		} else {
			$absentes[] = $demande;
		}
	}
	if ( array_key_exists( 'accent_italique', $valeurs ) ) {
		$out['accent_italique'] = ! empty( $valeurs['accent_italique'] );
	}
	if ( array_key_exists( 'accent_taille', $valeurs ) ) {
		$out['accent_taille'] = briise_polices_taille( $valeurs['accent_taille'] );
	}
	update_option( 'briise_polices', $out );
	if ( function_exists( 'wp_clean_theme_json_cache' ) ) {
		wp_clean_theme_json_cache();
	}
	return $absentes;
}

/** Graisse la plus forte d'une police (« 100 900 » pour une police variable). */
function briise_polices_graisse_max( $faces ) {
	$max = 0;
	foreach ( (array) $faces as $f ) {
		foreach ( preg_split( '/\s+/', trim( (string) ( $f['fontWeight'] ?? '400' ) ) ) as $g ) {
			$max = max( $max, (int) $g );
		}
	}
	return $max ? $max : 400;
}

/*
 * Application : les polices choisies remplacent celles de l'ambiance dans les réglages lus
 * par WordPress. Il imprime alors les fichiers de police (@font-face) et les variables
 * --wp--preset--font-family--titres, --texte et --accent, sur le site comme dans l'éditeur.
 */
add_filter( 'wp_theme_json_data_user', function ( $theme_json ) {
	$choix = briise_polices();
	if ( '' === $choix['titres'] && '' === $choix['texte'] && '' === $choix['accent'] && '' === $choix['chiffres'] ) {
		return $theme_json;
	}
	$dispo = briise_polices_disponibles();
	$data  = $theme_json->get_data();

	// Polices actuelles : celles de l'ambiance enregistrée, sinon celles de theme.json.
	$liste = $data['settings']['typography']['fontFamilies']['theme'] ?? null;
	if ( ! is_array( $liste ) ) {
		static $base = null;
		if ( null === $base ) {
			$brut = json_decode( (string) file_get_contents( get_theme_file_path( 'theme.json' ) ), true );
			$base = (array) ( $brut['settings']['typography']['fontFamilies'] ?? array() );
		}
		$liste = $base;
	}

	$custom = array();
	foreach ( briise_polices_roles() as $role => $libelle ) {
		$nom = $choix[ $role ];
		if ( '' === $nom || ! isset( $dispo[ $nom ] ) ) {
			continue;
		}
		$liste   = array_values( array_filter( $liste, function ( $f ) use ( $role ) {
			return ( $f['slug'] ?? '' ) !== $role;
		} ) );
		$liste[] = array(
			'slug'       => $role,
			'name'       => explode( ' (', $libelle )[0] . ' : ' . $nom,
			'fontFamily' => $dispo[ $nom ]['fontFamily'],
			'fontFace'   => $dispo[ $nom ]['fontFace'],
		);
		if ( 'accent' === $role ) {
			// Une police d'accent fine (une seule graisse, souvent 400) ne doit pas être grossie artificiellement.
			$max    = briise_polices_graisse_max( $dispo[ $nom ]['fontFace'] );
			$custom = array(
				'accent' => array(
					'style'  => $choix['accent_italique'] ? 'italic' : 'normal',
					'poids'  => $max < 600 ? (string) $max : 'inherit',
					// Une police d'accent paraît souvent plus petite que celle des titres à taille égale.
					'taille' => '' !== $choix['accent_taille'] ? $choix['accent_taille'] : '1',
					// Dans un titre en capitales, le mot d'accent garde ses minuscules.
					'casse'  => 'none',
				),
			);
		}
	}

	$ajout = array( 'typography' => array( 'fontFamilies' => array( 'theme' => $liste ) ) );
	if ( $custom ) {
		$ajout['custom'] = $custom;
	}
	return $theme_json->update_with( array(
		'version'  => $data['version'] ?? 3,
		'settings' => $ajout,
	) );
} );

// La police des chiffres ne s'applique que si elle est choisie (sinon chaque élément garde la sienne).
add_filter( 'body_class', function ( $classes ) {
	$choix = briise_polices();
	if ( '' !== $choix['chiffres'] && isset( briise_polices_disponibles()[ $choix['chiffres'] ] ) ) {
		$classes[] = 'br-police-chiffres';
	}
	return $classes;
} );

/* ----- Bloc « Polices » de Mon entreprise > Apparence ------------------------- */

function briise_polices_formulaire() {
	$choix = briise_polices();
	$dispo = briise_polices_disponibles();
	echo '<fieldset style="margin:1.5rem 0"><legend style="font-size:1.1em;font-weight:600;margin-bottom:.5rem">Polices</legend>';
	echo '<p class="description" style="margin-bottom:.8rem">Pour la charte d’un client. La liste reprend les polices du thème et celles téléversées dans Apparence &gt; Éditeur &gt; Styles &gt; Typographie &gt; Gérer les polices (fichiers WOFF2, licence web vérifiée). Le choix passe devant les polices de l’ambiance et reste en place si vous changez d’ambiance.</p>';
	foreach ( briise_polices_roles() as $role => $libelle ) {
		printf( '<p><label for="br-police-%1$s" style="display:inline-block;min-width:16rem">%2$s</label> <select id="br-police-%1$s" name="polices[%1$s]">', esc_attr( $role ), esc_html( $libelle ) );
		printf( '<option value="">%s</option>', esc_html( 'accent' === $role ? 'Comme les titres' : 'Selon l’ambiance' ) );
		foreach ( $dispo as $nom => $p ) {
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				esc_attr( $nom ),
				selected( $choix[ $role ], $nom, false ),
				esc_html( $nom . ( 'bibliotheque' === $p['source'] ? ' (téléversée)' : '' ) )
			);
		}
		echo '</select></p>';
	}
	printf(
		'<p><label><input type="checkbox" name="polices[accent_italique]" value="1" %s> Mot d’accent en italique</label></p>',
		checked( $choix['accent_italique'], true, false )
	);
	echo '<p><label for="br-police-accent-taille" style="display:inline-block;min-width:16rem">Taille du mot d’accent</label> <select id="br-police-accent-taille" name="polices[accent_taille]">';
	foreach ( briise_polices_tailles() as $val => $libelle ) {
		printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $val ), selected( $choix['accent_taille'], $val, false ), esc_html( $libelle ) );
	}
	echo '</select> <span class="description">Certaines polices d’accent paraissent plus petites que celle des titres. Sans police d’accent, ce réglage ne change rien.</span></p>';
	echo '</fieldset>';
}
