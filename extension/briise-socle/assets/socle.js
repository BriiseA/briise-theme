/**
 * Briise Socle : bandeau d'information et mesure des prises de contact.
 * Indépendant du thème.
 */
( function () {
	'use strict';

	/* Bandeau d'information : fermé, il ne revient que si son texte change. */
	var bandeau = document.getElementById( 'br-bandeau' );
	if ( bandeau ) {
		bandeau.querySelector( '.br-bandeau-fermer' ).addEventListener( 'click', function () {
			bandeau.hidden = true;
			try {
				localStorage.setItem( 'br-bandeau', bandeau.dataset.id );
			} catch ( e ) {}
		} );
	}

	/* Formulaire en étapes (etapes="1") : le projet, les détails, les coordonnées.
	   Les champs restent ceux de Fluent Forms : on les range seulement dans trois étapes. */
	document.querySelectorAll( '.br-form-etapes form.frm-fluent-form' ).forEach( function ( form ) {
		var zone = form.querySelector( 'fieldset' ) || form;
		var etapeDe = { projet: 0, prestation: 0, lieu: 0, commune: 1, date: 1, message: 1, nom: 2, telephone: 2, email: 2 };
		var noms = [ 'votre projet', 'les détails', 'vos coordonnées' ];
		var titres = [ 'Quel est votre projet ?', 'Aidez-nous à préparer la visite', 'Où pouvons-nous vous répondre ?' ];
		var groupes = Array.prototype.slice.call( zone.querySelectorAll( ':scope > .ff-el-group:not(.ff-hpsf-container)' ) );
		var envoi = zone.querySelector( ':scope > .ff_submit_btn_wrapper' );
		if ( groupes.length < 3 || ! envoi ) {
			return;
		}
		var paquets = [ [], [], [] ];
		groupes.forEach( function ( g ) {
			if ( g === envoi ) {
				return;
			}
			var champ = g.querySelector( '[name]' );
			var nom = champ ? champ.getAttribute( 'name' ).replace( /\[\]$/, '' ) : '';
			paquets[ nom in etapeDe ? etapeDe[ nom ] : ( g.classList.contains( 'ff-custom_html' ) ? 2 : 1 ) ].push( g );
		} );
		var ordre = [ 0, 1, 2 ].filter( function ( i ) { return paquets[ i ].length; } );
		if ( ordre.length < 2 ) {
			return;
		}
		var tete = document.createElement( 'div' );
		tete.className = 'br-etapes-tete';
		tete.innerHTML = '<p class="br-etapes-compte"></p><div class="br-etapes-barre" aria-hidden="true"><span></span></div><p class="br-etapes-titre" tabindex="-1"></p>';
		zone.insertBefore( tete, groupes[ 0 ] );
		var blocs = ordre.map( function ( i ) {
			var b = document.createElement( 'div' );
			b.className = 'br-etape';
			paquets[ i ].forEach( function ( g ) { b.appendChild( g ); } );
			zone.insertBefore( b, envoi );
			return b;
		} );
		var nav = document.createElement( 'div' );
		nav.className = 'br-etapes-nav';
		var prec = document.createElement( 'button' );
		prec.type = 'button';
		prec.className = 'br-etapes-prec';
		prec.textContent = 'Précédent';
		var suiv = document.createElement( 'button' );
		suiv.type = 'button';
		suiv.className = 'wp-element-button br-etapes-suiv';
		suiv.textContent = 'Continuer';
		nav.appendChild( prec );
		nav.appendChild( suiv );
		zone.insertBefore( nav, envoi );
		envoi.insertBefore( prec.cloneNode( true ), envoi.firstChild ).addEventListener( 'click', function () { aller( n - 1 ); } );

		// Le projet en grandes cases à cocher plutôt qu'une liste déroulante.
		var select = form.querySelector( 'select[name="projet"]' );
		if ( select && select.options.length <= 8 ) {
			var cases = document.createElement( 'div' );
			cases.className = 'br-etapes-cases';
			cases.setAttribute( 'role', 'group' );
			var etiquette = form.querySelector( 'label[for="' + select.id + '"]' );
			if ( etiquette ) {
				etiquette.id = etiquette.id || select.id + '-lab';
				cases.setAttribute( 'aria-labelledby', etiquette.id );
				etiquette.removeAttribute( 'for' );
			}
			Array.prototype.slice.call( select.options ).forEach( function ( o ) {
				if ( ! o.value ) {
					return;
				}
				var b = document.createElement( 'button' );
				b.type = 'button';
				b.textContent = o.textContent;
				b.setAttribute( 'aria-pressed', select.value === o.value ? 'true' : 'false' );
				b.addEventListener( 'click', function () {
					select.value = o.value;
					select.dispatchEvent( new Event( 'change', { bubbles: true } ) );
					cases.querySelectorAll( 'button' ).forEach( function ( x ) { x.setAttribute( 'aria-pressed', x === b ? 'true' : 'false' ); } );
					effacer( select.closest( '.ff-el-group' ) );
				} );
				cases.appendChild( b );
			} );
			select.parentNode.insertBefore( cases, select );
			select.hidden = true;
		}

		function effacer( g ) {
			if ( ! g ) {
				return;
			}
			g.classList.remove( 'ff-el-is-error' );
			var e = g.querySelector( '.br-etapes-erreur' );
			if ( e ) {
				e.remove();
			}
			g.querySelectorAll( '[aria-invalid]' ).forEach( function ( c ) { c.setAttribute( 'aria-invalid', 'false' ); } );
		}
		function valide( bloc ) {
			var premier = null;
			bloc.querySelectorAll( '[aria-required="true"]' ).forEach( function ( c ) {
				var g = c.closest( '.ff-el-group' );
				var vide = c.type === 'radio' || c.type === 'checkbox'
					? ! g.querySelector( 'input:checked' )
					: ! String( c.value || '' ).trim();
				effacer( g );
				if ( vide ) {
					g.classList.add( 'ff-el-is-error' );
					c.setAttribute( 'aria-invalid', 'true' );
					var m = document.createElement( 'div' );
					m.className = 'error text-danger br-etapes-erreur';
					m.id = ( c.id || c.name ) + '-err';
					m.textContent = 'Ce champ est obligatoire.';
					c.setAttribute( 'aria-describedby', m.id );
					( g.querySelector( '.ff-el-input--content' ) || g ).appendChild( m );
					premier = premier || ( c.hidden ? g.querySelector( '.br-etapes-cases button' ) : c );
				}
			} );
			if ( premier ) {
				premier.focus();
			}
			return ! premier;
		}
		form.addEventListener( 'input', function ( ev ) { effacer( ev.target.closest && ev.target.closest( '.ff-el-group.ff-el-is-error' ) ); } );

		var n = 0;
		function aller( i, focus ) {
			n = Math.max( 0, Math.min( blocs.length - 1, i ) );
			blocs.forEach( function ( b, k ) { b.hidden = k !== n; } );
			var der = n === blocs.length - 1;
			nav.hidden = der;
			envoi.hidden = ! der;
			prec.hidden = n === 0;
			tete.querySelector( '.br-etapes-compte' ).textContent = 'Étape ' + ( n + 1 ) + ' sur ' + blocs.length + ' : ' + noms[ ordre[ n ] ];
			tete.querySelector( '.br-etapes-barre span' ).style.width = Math.round( ( n + 1 ) / blocs.length * 100 ) + '%';
			var t = tete.querySelector( '.br-etapes-titre' );
			t.textContent = titres[ ordre[ n ] ];
			if ( focus !== false ) {
				t.focus();
			}
		}
		suiv.addEventListener( 'click', function () {
			if ( valide( blocs[ n ] ) ) {
				aller( n + 1 );
			}
		} );
		prec.addEventListener( 'click', function () { aller( n - 1 ); } );
		// Entrée dans un champ d'une étape intermédiaire : passer à la suivante, pas envoyer.
		form.addEventListener( 'keydown', function ( ev ) {
			if ( ev.key === 'Enter' && ev.target.tagName === 'INPUT' && n < blocs.length - 1 ) {
				ev.preventDefault();
				suiv.click();
			}
		} );
		form.closest( '.br-form-etapes' ).classList.add( 'br-form-etapes--actif' );
		aller( 0, false );
	} );

	/* Zone sur un plan : la commune choisie s'allume sur le plan, la distance s'affiche. */
	document.querySelectorAll( '.br-zplan' ).forEach( function ( bloc ) {
		var info = bloc.querySelector( '.br-zplan-info-txt' );
		var depart = info ? info.textContent : '';
		var boutons = bloc.querySelectorAll( '.br-zplan-communes button' );
		boutons.forEach( function ( bouton ) {
			bouton.addEventListener( 'click', function () {
				var actif = bouton.getAttribute( 'aria-pressed' ) !== 'true';
				boutons.forEach( function ( b ) { b.setAttribute( 'aria-pressed', b === bouton && actif ? 'true' : 'false' ); } );
				bloc.querySelectorAll( '.br-zplan-point[data-n]' ).forEach( function ( p ) {
					p.classList.toggle( 'is-choisi', actif && p.getAttribute( 'data-n' ) === bouton.getAttribute( 'data-n' ) );
				} );
				if ( info ) {
					info.innerHTML = '';
					if ( actif ) {
						var fort = document.createElement( 'strong' );
						fort.textContent = bouton.firstChild.textContent;
						info.appendChild( fort );
						info.appendChild( document.createTextNode( bouton.getAttribute( 'data-info' ) ) );
					} else {
						info.textContent = depart;
					}
				}
			} );
		} );
	} );

	/* Réalisations : filtres par catégorie, sans rechargement. */
	document.querySelectorAll( '.br-realisations' ).forEach( function ( bloc ) {
		var boutons = bloc.querySelectorAll( '.br-filtre' );
		var etat = bloc.querySelector( '.br-filtres-etat' );
		boutons.forEach( function ( bouton ) {
			bouton.addEventListener( 'click', function () {
				var filtre = bouton.getAttribute( 'data-filtre' );
				var n = 0;
				boutons.forEach( function ( b ) {
					b.setAttribute( 'aria-pressed', b === bouton ? 'true' : 'false' );
				} );
				bloc.querySelectorAll( '.br-project, .br-galerie-tuile' ).forEach( function ( carte ) {
					var cats = ( ' ' + ( carte.getAttribute( 'data-cats' ) || '' ) + ' ' );
					var visible = ! filtre || cats.indexOf( ' ' + filtre + ' ' ) !== -1;
					carte.hidden = ! visible;
					n += visible ? 1 : 0;
				} );
				if ( etat ) {
					etat.textContent = n + ( n > 1 ? ' résultats' : ' résultat' );
				}
			} );
		} );
	} );

	/* Mesure des prises de contact : clic sur un téléphone, un e-mail, envoi d'un
	   formulaire. Envoyé à Matomo s'il est présent, et à Google Tag Manager
	   (dataLayer) pour les conversions Google Ads, qui restent soumises au consentement. */
	var mesurer = function ( type, detail ) {
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push( { event: 'briise_contact', briise_type: type, briise_detail: detail } );
		if ( window._paq ) {
			window._paq.push( [ 'trackEvent', 'Contact', type, detail ] );
		}
	};
	document.addEventListener( 'click', function ( ev ) {
		var lien = ev.target.closest && ev.target.closest( 'a[href^="tel:"], a[href^="mailto:"]' );
		if ( lien ) {
			mesurer( lien.href.indexOf( 'tel:' ) === 0 ? 'telephone' : 'email', location.pathname );
		}
	} );
	// Formulaire envoyé. Fluent Forms : seulement quand l'envoi a réussi (pas les essais refusés).
	document.addEventListener( 'submit', function ( ev ) {
		if ( ev.target && ev.target.tagName === 'FORM' && ! ev.target.closest( '.wp-block-search' ) && ! ev.target.classList.contains( 'frm-fluent-form' ) ) {
			mesurer( 'formulaire', location.pathname );
		}
	}, true );
	if ( window.jQuery ) {
		window.jQuery( document.body ).on( 'fluentform_submission_success', function () {
			mesurer( 'formulaire', location.pathname );
		} );
	}
}() );
