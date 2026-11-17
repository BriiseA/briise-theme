<?php
/**
 * Tableaux comparatifs lisibles sur mobile.
 *
 * Un tableau du thème (classe br-table) de 4 colonnes ou plus devient, sur mobile,
 * une pile de fiches : chaque ligne est une carte, chaque valeur porte le titre
 * de sa colonne. Les titres sont ajoutés ici, côté serveur (attribut data-label),
 * pour fonctionner sans JavaScript.
 *
 * @package Briise
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'render_block_core/table',
	static function ( $html, $block ) {
		$classe = $block['attrs']['className'] ?? '';
		if ( ! preg_match( '/(^|\s)br-table(\s|$)/', $classe ) || ! preg_match( '#<thead>(.*?)</thead>#s', $html, $tete ) ) {
			return $html;
		}
		preg_match_all( '#<th[^>]*>(.*?)</th>#s', $tete[1], $titres );
		$titres = array_map( static fn( $t ) => trim( wp_strip_all_tags( $t ) ), $titres[1] );
		if ( count( $titres ) < 4 ) {
			return $html;
		}
		$html = preg_replace_callback(
			'#<tbody>(.*?)</tbody>#s',
			static function ( $corps ) use ( $titres ) {
				return preg_replace_callback(
					'#<tr>(.*?)</tr>#s',
					static function ( $ligne ) use ( $titres ) {
						$i = 0;
						return '<tr>' . preg_replace_callback(
							'#<td(\s[^>]*)?>#',
							static function ( $td ) use ( $titres, &$i ) {
								$titre = $titres[ $i ] ?? '';
								++$i;
								return '<td' . ( $td[1] ?? '' ) . ' data-label="' . esc_attr( $titre ) . '">';
							},
							$ligne[1]
						) . '</tr>';
					},
					$corps[0]
				);
			},
			$html
		);
		return preg_replace( '/class="([^"]*\bbr-table\b[^"]*)"/', 'class="$1 br-table--cartes"', $html, 1 );
	},
	10,
	2
);
