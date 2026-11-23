/**
 * Briise Socle : dans l'éditeur, les codes [briise_…] s'affichent sous forme
 * d'étiquette lisible (ce que c'est, où ça se règle). Sur le site, rien ne change.
 * Un administrateur peut toujours afficher le code.
 */
( function ( wp ) {
	if ( ! wp || ! wp.hooks || ! wp.compose || ! wp.element || ! wp.blockEditor ) {
		return;
	}
	var el = wp.element.createElement;
	var useState = wp.element.useState;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var cfg = window.briiseEditeur || {};
	var admin = !! cfg.admin;
	var portfolio = cfg.realisations || 'Réalisations';

	var ICI_HORAIRES = 'Se règle dans Mon entreprise > Horaires et annonces.';
	var ICI_COORD = admin
		? 'Se règle dans Mon entreprise > Entreprise.'
		: 'Pour les modifier, demandez à la personne qui gère votre site.';
	var ICI_ZONE = admin
		? 'Se règle dans Mon entreprise > Entreprise.'
		: 'Pour la modifier, demandez à la personne qui gère votre site.';
	var AUTO = 'Se met à jour tout seul. Rien à faire.';

	function etiquette( code, a ) {
		switch ( code ) {
			case 'disponibilite':
				return [ 'Prochaine date libre', ICI_HORAIRES ];
			case 'horaires':
				return [ 'Horaires d’ouverture', ICI_HORAIRES ];
			case 'fil_ariane':
				return [ 'Chemin de la page (Accueil > …)', AUTO ];
			case 'pages_liees':
				return [ 'Liens vers les pages de la même rubrique', 'La liste se met à jour toute seule quand une page est ajoutée.' ];
			case 'appel':
				return [ 'Bouton « ' + ( a.texte || 'Appeler' ) + ' »', 'Le numéro vient de vos coordonnées. ' + ICI_COORD ];
			case 'formulaire':
				var noms = { devis: 'Formulaire de demande de devis', contact: 'Formulaire de contact', reservation: 'Formulaire de réservation' };
				return [ noms[ a.type ] || noms.devis, 'Les demandes arrivent par e-mail. Les questions du formulaire se changent sur demande à la personne qui gère votre site.' ];
			case 'realisations':
				return [
					a.filtres === '1' ? 'Toutes les fiches « ' + portfolio + ' », avec filtres' : 'Dernières fiches « ' + portfolio + ' »',
					'Une fiche publiée dans le menu « ' + portfolio + ' » apparaît ici toute seule.'
				];
			case 'realisation_infos':
				return [ 'Informations de la fiche (lieu, date, prestation)', 'Se remplissent dans le cadre « Informations » à droite de la fiche.' ];
			case 'carte_coordonnees':
			case 'coordonnees':
			case 'contact_rapide':
				return [ 'Vos coordonnées (adresse, téléphone, e-mail)', ICI_COORD ];
			case 'telephone':
				return [ 'Votre numéro de téléphone', ICI_COORD ];
			case 'info':
				var champs = { name: 'Nom de l’entreprise', email: 'Adresse e-mail', telephone: 'Téléphone', adresse: 'Adresse' };
				return [ champs[ a.champ ] || 'Information de l’entreprise', ICI_COORD ];
			case 'zone':
			case 'zone_liste':
			case 'zone_schema':
			case 'carte_zone':
				return [ 'Zone d’intervention', ICI_ZONE ];
			case 'reseaux':
				return [ 'Liens vers vos réseaux sociaux', ICI_COORD ];
			case 'qualifications':
				return [ 'Qualifications et assurances', ICI_COORD ];
			case 'mentions_legales':
				return [ 'Mentions légales', ICI_COORD ];
		}
		return null;
	}

	function lireAttributs( s ) {
		var a = {};
		var re = /([a-z_]+)\s*=\s*"([^"]*)"/g;
		var m;
		while ( ( m = re.exec( s ) ) ) {
			a[ m[ 1 ] ] = m[ 2 ];
		}
		return a;
	}

	function Etiquette( props ) {
		var blockProps = useBlockProps( {
			className: 'br-etiquette-code',
			style: {
				fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
				fontSize: '14px',
				lineHeight: 1.5,
				color: '#1e1e1e',
				background: '#f6f7f7',
				border: '1px solid #dcdcde',
				borderLeft: '4px solid #2271b1',
				borderRadius: '4px',
				padding: '12px 16px',
				margin: '8px 0'
			}
		} );
		return el(
			'div',
			blockProps,
			el( 'strong', { style: { display: 'block', fontSize: '15px' } }, props.titre ),
			el( 'span', { style: { display: 'block', color: '#50575e' } }, props.aide ),
			el( 'span', { style: { display: 'block', color: '#50575e', marginTop: '4px', fontSize: '13px' } }, 'Ce bloc s’affiche automatiquement sur le site : ne le supprimez pas.' ),
			props.admin
				? el(
					'button',
					{
						type: 'button',
						onClick: props.voirCode,
						style: { marginTop: '8px', background: 'none', border: 0, padding: 0, color: '#2271b1', textDecoration: 'underline', cursor: 'pointer', font: 'inherit' }
					},
					'Afficher le code'
				)
				: null
		);
	}

	var avecEtiquette = wp.compose.createHigherOrderComponent( function ( BlockEdit ) {
		return function ( props ) {
			var code = useState( false );
			if ( props.name !== 'core/shortcode' ) {
				return el( BlockEdit, props );
			}
			var texte = ( props.attributes && props.attributes.text ) || '';
			var m = /^\s*\[briise_([a-z_]+)([^\]]*)\]\s*$/.exec( texte );
			var e = m ? etiquette( m[ 1 ], lireAttributs( m[ 2 ] ) ) : null;
			if ( ! e || code[ 0 ] ) {
				return el( BlockEdit, props );
			}
			return el( Etiquette, {
				titre: e[ 0 ],
				aide: e[ 1 ],
				admin: admin,
				voirCode: function () {
					code[ 1 ]( true );
				}
			} );
		};
	}, 'briiseEtiquetteCode' );

	wp.hooks.addFilter( 'editor.BlockEdit', 'briise/etiquette-code', avecEtiquette );
} )( window.wp );
