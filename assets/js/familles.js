/**
 * Briise : comportements des familles de sections.
 * Services en onglets : la liste devient des onglets, un service affiché à la fois.
 * Services en défilement : flèches « précédent » et « suivant ».
 * Ouverture en diaporama : les photos changent en fondu toutes les 6 secondes, bouton pause.
 * Ouverture avec vidéo : vidéo muette en boucle, bouton pause.
 * Sans ce script, chaque version reste lisible : les onglets restent une grille de cartes,
 * le défilement se fait au doigt, à la souris ou au clavier.
 */
( function () {
	'use strict';

	var calme = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var compteur = 0;

	function items( liste ) {
		return Array.prototype.filter.call( liste.children, function ( el ) {
			return el.classList.contains( 'br-service' );
		} );
	}

	/* ----- Onglets (modèle « tabs » des recommandations ARIA) ---------------------- */
	function onglets( section ) {
		var liste = section.querySelector( '.br-services-liste' );
		if ( ! liste || section.classList.contains( 'br-onglets--actif' ) ) {
			return;
		}
		var panneaux = items( liste );
		if ( panneaux.length < 2 ) {
			return;
		}
		var barre = document.createElement( 'div' );
		barre.className = 'br-services-onglets';
		barre.setAttribute( 'role', 'tablist' );
		var titre = section.querySelector( 'h2' );
		if ( titre ) {
			titre.id = titre.id || 'br-services-titre-' + ( ++compteur );
			barre.setAttribute( 'aria-labelledby', titre.id );
		}
		var boutons = panneaux.map( function ( panneau, i ) {
			panneau.id = panneau.id || 'br-service-' + ( ++compteur );
			var nom = panneau.querySelector( '.br-service-nom, h3' );
			var b = document.createElement( 'button' );
			b.type = 'button';
			b.id = panneau.id + '-onglet';
			b.setAttribute( 'role', 'tab' );
			b.setAttribute( 'aria-controls', panneau.id );
			b.textContent = nom ? nom.textContent.trim() : 'Service ' + ( i + 1 );
			panneau.setAttribute( 'role', 'tabpanel' );
			panneau.setAttribute( 'aria-labelledby', b.id );
			barre.appendChild( b );
			return b;
		} );

		function choisir( i, focus ) {
			boutons.forEach( function ( b, j ) {
				var actif = i === j;
				b.setAttribute( 'aria-selected', actif ? 'true' : 'false' );
				b.tabIndex = actif ? 0 : -1;
				panneaux[ j ].hidden = ! actif;
			} );
			if ( focus ) {
				boutons[ i ].focus();
			}
		}

		barre.addEventListener( 'click', function ( e ) {
			var b = e.target.closest( '[role="tab"]' );
			if ( b ) {
				choisir( boutons.indexOf( b ) );
			}
		} );
		barre.addEventListener( 'keydown', function ( e ) {
			var i = boutons.indexOf( document.activeElement );
			if ( i < 0 ) {
				return;
			}
			var cible = { ArrowRight: i + 1, ArrowLeft: i - 1, Home: 0, End: boutons.length - 1 }[ e.key ];
			if ( cible === undefined ) {
				return;
			}
			e.preventDefault();
			choisir( ( cible + boutons.length ) % boutons.length, true );
		} );

		liste.parentNode.insertBefore( barre, liste );
		section.classList.add( 'br-onglets--actif' );
		choisir( 0 );
	}

	/* ----- Défilement : flèches ---------------------------------------------------- */
	function defilement( section ) {
		var liste = section.querySelector( '.br-services-liste' );
		if ( ! liste || section.querySelector( '.br-services-fleches' ) ) {
			return;
		}
		var titre = section.querySelector( 'h2' );
		// La bande se fait défiler au clavier (flèches) une fois qu'elle a le focus.
		liste.setAttribute( 'tabindex', '0' );
		liste.setAttribute( 'role', 'region' );
		liste.setAttribute( 'aria-label', ( titre ? titre.textContent.trim() + ' : ' : '' ) + 'liste à faire défiler' );

		var nav = document.createElement( 'div' );
		nav.className = 'br-services-fleches';

		function pas() {
			var premier = items( liste )[ 0 ];
			var ecart = parseFloat( window.getComputedStyle( liste ).columnGap ) || 20;
			return premier ? premier.getBoundingClientRect().width + ecart : liste.clientWidth * 0.8;
		}
		function bouton( sens, libelle, fleche ) {
			var b = document.createElement( 'button' );
			b.type = 'button';
			b.setAttribute( 'aria-label', libelle );
			b.innerHTML = '<span aria-hidden="true">' + fleche + '</span>';
			b.addEventListener( 'click', function () {
				liste.scrollBy( { left: sens * pas(), behavior: calme ? 'auto' : 'smooth' } );
			} );
			return b;
		}
		var precedent = bouton( -1, 'Service précédent', '←' );
		var suivant = bouton( 1, 'Service suivant', '→' );
		function majour() {
			var max = liste.scrollWidth - liste.clientWidth - 2;
			nav.hidden = max <= 0;
			precedent.disabled = liste.scrollLeft <= 2;
			suivant.disabled = liste.scrollLeft >= max;
		}
		nav.appendChild( precedent );
		nav.appendChild( suivant );
		liste.insertAdjacentElement( 'afterend', nav );
		liste.addEventListener( 'scroll', majour, { passive: true } );
		window.addEventListener( 'resize', majour );
		majour();
	}

	/* ----- Bouton pause (diaporama, vidéo) ---------------------------------------- */
	var ICONE_PAUSE = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M7 5h4v14H7zM13 5h4v14h-4z"/></svg>';
	var ICONE_LECTURE = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M8 5v14l11-7z"/></svg>';
	function boutonPause( parent, arreter, reprendre, enPause ) {
		var b = document.createElement( 'button' );
		b.type = 'button';
		b.className = 'br-ouv-pause';
		function maj( pause ) {
			b.setAttribute( 'aria-label', pause ? 'Reprendre l’animation' : 'Mettre l’animation en pause' );
			b.innerHTML = pause ? ICONE_LECTURE : ICONE_PAUSE;
			b.setAttribute( 'aria-pressed', pause ? 'true' : 'false' );
		}
		var pause = !! enPause;
		maj( pause );
		b.addEventListener( 'click', function () {
			pause = ! pause;
			( pause ? arreter : reprendre )();
			maj( pause );
		} );
		parent.appendChild( b );
	}

	/* ----- Ouverture en diaporama : les photos changent en fondu, le texte reste ------- */
	function diaporama( section ) {
		var media = section.querySelector( '.br-ouv-media' );
		if ( ! media || media.classList.contains( 'br-diapo--actif' ) || media.querySelector( '.wp-block-video' ) ) {
			return;
		}
		var photos = Array.prototype.filter.call( media.children, function ( el ) {
			return el.classList.contains( 'br-ouv-photo' );
		} );
		if ( photos.length < 2 ) {
			return;
		}
		// Les photos suivantes se chargent tout de suite : le fondu ne montre jamais d'image vide.
		photos.forEach( function ( p, i ) {
			var img = p.querySelector( 'img' );
			if ( img && i ) {
				img.loading = 'eager';
			}
			if ( i ) {
				p.setAttribute( 'aria-hidden', 'true' );
			}
		} );
		var i = 0;
		var minuterie = null;
		function montrer( n ) {
			photos.forEach( function ( p, j ) {
				p.classList.toggle( 'is-visible', j === n );
			} );
		}
		function suivante() {
			i = ( i + 1 ) % photos.length;
			montrer( i );
		}
		function arreter() {
			clearInterval( minuterie );
			minuterie = null;
		}
		function reprendre() {
			if ( ! minuterie ) {
				minuterie = setInterval( suivante, 6000 );
			}
		}
		media.classList.add( 'br-diapo--actif' );
		montrer( 0 );
		if ( calme ) {
			// Moins d'animations demandé : la première photo reste, sans défilement.
			return;
		}
		reprendre();
		boutonPause( media, arreter, reprendre, false );
	}

	/* ----- Ouverture avec vidéo : muette, en boucle, avec pause --------------------- */
	function video( section ) {
		var v = section.querySelector( '.br-ouv-media video' );
		if ( ! v || v.dataset.brPret ) {
			return;
		}
		v.dataset.brPret = '1';
		v.muted = true;
		v.loop = true;
		v.playsInline = true;
		v.removeAttribute( 'controls' );
		v.setAttribute( 'aria-hidden', 'true' );
		if ( calme ) {
			v.pause();
			v.removeAttribute( 'autoplay' );
		} else {
			var lecture = v.play();
			if ( lecture && lecture.catch ) {
				lecture.catch( function () {} );
			}
		}
		boutonPause( section.querySelector( '.br-ouv-media' ), function () { v.pause(); }, function () { v.play(); }, calme );
	}

	function demarrer() {
		document.querySelectorAll( '.br-services--onglets' ).forEach( onglets );
		document.querySelectorAll( '.br-services--defile' ).forEach( defilement );
		document.querySelectorAll( '.br-ouverture--diaporama' ).forEach( diaporama );
		document.querySelectorAll( '.br-ouverture' ).forEach( video );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', demarrer );
	} else {
		demarrer();
	}
}() );
