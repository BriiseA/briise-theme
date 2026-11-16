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
	document.addEventListener( 'submit', function ( ev ) {
		if ( ev.target && ev.target.tagName === 'FORM' && ! ev.target.closest( '.wp-block-search' ) ) {
			mesurer( 'formulaire', location.pathname );
		}
	}, true );
}() );
