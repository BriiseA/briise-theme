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
	var regles = window.briiseReglesTitres || {};
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

	/* Ce que contient la section : ses classes et ses codes courts, le texte de son titre, et si
	   le titre est suivi d'une phrase d'introduction. Sert aux règles des positions permises. */
	function analyse( clientId ) {
		var bloc = wp.data && wp.data.select( 'core/block-editor' ).getBlock( clientId );
		var a = { classes: [], textes: [], titre: '', phrase: false };
		if ( ! bloc ) {
			return a;
		}
		( function parcourir( b ) {
			classesDe( b.attributes.className ).forEach( function ( c ) {
				a.classes.push( c );
			} );
			if ( 'core/shortcode' === b.name ) {
				a.textes.push( String( b.attributes.text || '' ) );
			}
			( b.innerBlocks || [] ).forEach( parcourir );
		}( bloc ) );
		var tete = bloc.innerBlocks.filter( function ( b ) {
			var c = classesDe( b.attributes.className );
			return c.indexOf( 'br-head' ) >= 0 || c.indexOf( 'br-section-head' ) >= 0;
		} )[ 0 ];
		( tete ? tete.innerBlocks : [] ).forEach( function ( x ) {
			if ( 'core/heading' === x.name && ! a.titre ) {
				a.titre = String( x.attributes.content || '' ).replace( /<[^>]+>/g, '' ).trim();
			}
			if ( classesDe( x.attributes.className ).indexOf( 'br-lead' ) >= 0 ) {
				a.phrase = true;
			}
		} );
		return a;
	}
	/* Une position convient-elle à cette section ? (règles : inc/familles.json, « reglesTitres ») */
	function permise( position, a ) {
		var r = regles[ position ];
		if ( ! r || ! a ) {
			return true;
		}
		if ( ( 'requise' === r.phrase && ! a.phrase ) || ( 'interdite' === r.phrase && a.phrase ) ) {
			return false;
		}
		if ( r.titre_max && a.titre.length > r.titre_max ) {
			return false;
		}
		var contient = function ( m ) {
			return 0 === m.indexOf( 'br-' ) ? a.classes.indexOf( m ) >= 0 : a.textes.some( function ( t ) {
				return t.indexOf( m ) >= 0;
			} );
		};
		// Liste blanche : sans l'un de ces contenus, la position n'est pas proposée.
		if ( r.seulement_si && ! r.seulement_si.some( contient ) ) {
			return false;
		}
		return ! ( r.contenus || [] ).some( contient );
	}

	/* Panneau « Titre » : la position du titre de la section (liste propre à la famille, sinon la liste
	   générale, réduite aux positions qui conviennent à son contenu). */
	function panneauTitre( props, classes, liste ) {
		var positions = liste || titres;
		var a = liste ? null : analyse( props.clientId );
		var trouvee = classes.filter( function ( c ) {
			return 0 === c.indexOf( PREFIXE_TITRE );
		} )[ 0 ];
		var actuelle = trouvee ? trouvee.slice( PREFIXE_TITRE.length ) : 'site';
		var horsRegle = ! permise( actuelle, a );
		var aide = ( positions[ actuelle ] || [] )[ 1 ] || '';
		if ( horsRegle ) {
			aide = 'Cette position ne convient pas au contenu de la section (titre trop long, phrase d’introduction, tableau ou galerie trop large…) : choisissez-en une autre.';
		}
		return el(
			wp.components.PanelBody,
			{ title: 'Titre', initialOpen: true },
			el( wp.components.SelectControl, {
				label: 'Position du titre',
				value: actuelle,
				options: Object.keys( positions ).filter( function ( v ) {
					return v === actuelle || permise( v, a );
				} ).map( function ( v ) {
					return { label: positions[ v ][ 0 ] + ( v === actuelle && horsRegle ? ' (déconseillé ici)' : '' ), value: v };
				} ),
				help: aide,
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
			// L'en-tête de page (titre principal, fil d'Ariane) n'a pas de panneau « Titre ».
			var titre = classes.indexOf( 'br-section' ) >= 0 && classes.indexOf( 'br-page-head' ) < 0 && ( ( famille && famille.titres ) || aUnEnTete( props.clientId ) );
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

/* Format « Mots qui changent » : entoure « mot 1 / mot 2 / mot 3 » dans un titre ; sur le site, les
   mots se succèdent (assets/js/familles.js). */
( function ( wp ) {
	if ( ! wp || ! wp.richText || ! wp.blockEditor || ! wp.element ) {
		return;
	}
	var el = wp.element.createElement;
	wp.richText.registerFormatType( 'briise/mots', {
		title: 'Mots qui changent',
		tagName: 'span',
		className: 'br-mots',
		edit: function ( props ) {
			return el( wp.blockEditor.RichTextToolbarButton, {
				icon: 'update',
				title: 'Mots qui changent (séparés par « / »)',
				isActive: props.isActive,
				onClick: function () {
					props.onChange( wp.richText.toggleFormat( props.value, { type: 'briise/mots' } ) );
				},
			} );
		},
	} );
}( window.wp ) );
