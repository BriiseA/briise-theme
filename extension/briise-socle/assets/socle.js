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
