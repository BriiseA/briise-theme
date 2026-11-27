/**
 * Briise : panneau « Version » de l'éditeur.
 * Quand la section sélectionnée appartient à une famille (classe br-services…), la barre
 * latérale propose ses versions. Choisir une version remplace la classe br-<famille>--<version> :
 * le texte et les photos restent en place. La liste des familles vient de inc/familles.php.
 * Toute section qui a un titre reçoit aussi le panneau « Titre » (position du titre).
 */
( function ( wp ) {
	'use strict';

	if ( ! wp || ! wp.hooks || ! wp.compose || ! wp.blockEditor || ! wp.components ) {
		return;
	}
	var el = wp.element.createElement;
	var familles = window.briiseFamilles || {};
	var titres = window.briiseTitres || {};
	var PREFIXE_TITRE = 'br-titre--';

	function classesDe( className ) {
		return String( className || '' ).split( /\s+/ ).filter( Boolean );
	}
	function familleDe( classes ) {
		for ( var cle in familles ) {
			if ( Object.prototype.hasOwnProperty.call( familles, cle ) && classes.indexOf( familles[ cle ].classe ) >= 0 ) {
				return familles[ cle ];
			}
		}
		return null;
	}

	/* La section a-t-elle un en-tête (titre) parmi ses blocs directs ? */
	function aUnEnTete( clientId ) {
		var bloc = wp.data && wp.data.select( 'core/block-editor' ).getBlock( clientId );
		return !! ( bloc && bloc.innerBlocks.some( function ( b ) {
			var c = classesDe( b.attributes.className );
			return c.indexOf( 'br-head' ) >= 0 || c.indexOf( 'br-section-head' ) >= 0;
		} ) );
	}

	/* Panneau « Titre » : la position du titre de la section (liste propre à la famille, sinon la liste générale). */
	function panneauTitre( props, classes, liste ) {
		var positions = liste || titres;
		var trouvee = classes.filter( function ( c ) {
			return 0 === c.indexOf( PREFIXE_TITRE );
		} )[ 0 ];
		var actuelle = trouvee ? trouvee.slice( PREFIXE_TITRE.length ) : 'site';
		return el(
			wp.components.PanelBody,
			{ title: 'Titre', initialOpen: true },
			el( wp.components.SelectControl, {
				label: 'Position du titre',
				value: actuelle,
				options: Object.keys( positions ).map( function ( v ) {
					return { label: positions[ v ][ 0 ], value: v };
				} ),
				help: ( positions[ actuelle ] || [] )[ 1 ] || '',
				onChange: function ( v ) {
					var suite = classes.filter( function ( c ) {
						return 0 !== c.indexOf( PREFIXE_TITRE );
					} );
					if ( 'site' !== v ) {
						suite.push( PREFIXE_TITRE + v );
					}
					props.setAttributes( { className: suite.join( ' ' ) } );
				},
			} )
		);
	}

	var avecVersion = wp.compose.createHigherOrderComponent( function ( BlockEdit ) {
		return function ( props ) {
			if ( 'core/group' !== props.name ) {
				return el( BlockEdit, props );
			}
			var classes = classesDe( props.attributes.className );
			var famille = familleDe( classes );
			var titre = classes.indexOf( 'br-section' ) >= 0 && ( ( famille && famille.titres ) || aUnEnTete( props.clientId ) );
			if ( ! famille && ! titre ) {
				return el( BlockEdit, props );
			}
			if ( ! famille ) {
				return el(
					wp.element.Fragment,
					null,
					el( BlockEdit, props ),
					el( wp.blockEditor.InspectorControls, null, panneauTitre( props, classes ) )
				);
			}
			var prefixe = famille.classe + '--';
			var trouvee = classes.filter( function ( c ) {
				return 0 === c.indexOf( prefixe );
			} )[ 0 ];
			var actuelle = trouvee ? trouvee.slice( prefixe.length ) : famille.defaut;
			var options = Object.keys( famille.variantes ).map( function ( v ) {
				return { label: famille.variantes[ v ][ 0 ], value: v };
			} );
			return el(
				wp.element.Fragment,
				null,
				el( BlockEdit, props ),
				el(
					wp.blockEditor.InspectorControls,
					null,
					el(
						wp.components.PanelBody,
						{ title: 'Version : ' + famille.nom, initialOpen: true },
						el( wp.components.RadioControl, {
							selected: actuelle,
							options: options,
							help: ( famille.variantes[ actuelle ] || [] )[ 1 ] || '',
							onChange: function ( v ) {
								var suite = classes.filter( function ( c ) {
									return 0 !== c.indexOf( prefixe );
								} );
								suite.push( prefixe + v );
								props.setAttributes( { className: suite.join( ' ' ) } );
							},
						} )
					),
					titre ? panneauTitre( props, classes, famille.titres ) : null
				)
			);
		};
	}, 'briiseAvecVersion' );

	wp.hooks.addFilter( 'editor.BlockEdit', 'briise/familles-version', avecVersion );
}( window.wp ) );
