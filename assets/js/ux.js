/**
 * Galet Yoga : confort de navigation.
 * Fonctionne sur les pages existantes, sans modifier leur contenu.
 */
( function () {
	'use strict';

	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var path = window.location.pathname.replace( /\/+$/, '/' );

	/* 1. En-tête qui se cache en descendant et réapparaît en remontant. */
	var header = document.querySelector( 'header.wp-block-template-part' );
	if ( header ) {
		header.classList.add( 'br-smart-header' );
		var lastY = window.scrollY;
		var ticking = false;
		var menuOpen = function () {
			return !! document.querySelector( '.wp-block-navigation__responsive-container.is-menu-open' );
		};
		var update = function () {
			var y = window.scrollY;
			var h = header.offsetHeight;
			header.classList.toggle( 'br-scrolled', y > 8 );
			if ( menuOpen() || header.contains( document.activeElement ) || y <= h ) {
				header.classList.remove( 'br-hidden' );
			} else if ( y > lastY + 2 && y > h * 1.5 ) {
				header.classList.add( 'br-hidden' );
			} else if ( y < lastY - 4 ) {
				header.classList.remove( 'br-hidden' );
			}
			lastY = y;
			ticking = false;
		};
		window.addEventListener( 'scroll', function () {
			if ( ! ticking ) {
				ticking = true;
				window.requestAnimationFrame( update );
			}
		}, { passive: true } );
		header.addEventListener( 'focusin', function () {
			header.classList.remove( 'br-hidden' );
		} );
		update();
	}

	/* 2. Page en cours signalée dans le menu et le pied de page. */
	document.querySelectorAll( '.br-nav a, .br-footer a' ).forEach( function ( a ) {
		try {
			var u = new URL( a.href, window.location.href );
			if ( u.origin === window.location.origin && u.pathname.replace( /\/+$/, '/' ) === path && ! u.hash ) {
				a.setAttribute( 'aria-current', 'page' );
			}
		} catch ( e ) {}
	} );

	/* 3. Numéros de téléphone cliquables partout. */
	var phoneRe = /(?:\+33\s?|0)[1-9](?:[\s. ]?\d{2}){4}/g;
	document.querySelectorAll( 'main p, .br-footer p' ).forEach( function ( p ) {
		if ( p.closest( 'a' ) || ! phoneRe.test( p.textContent ) ) {
			return;
		}
		phoneRe.lastIndex = 0;
		var walker = document.createTreeWalker( p, NodeFilter.SHOW_TEXT );
		var nodes = [];
		while ( walker.nextNode() ) {
			if ( ! walker.currentNode.parentElement.closest( 'a' ) ) {
				nodes.push( walker.currentNode );
			}
		}
		nodes.forEach( function ( node ) {
			var text = node.nodeValue;
			phoneRe.lastIndex = 0;
			if ( ! phoneRe.test( text ) ) {
				return;
			}
			phoneRe.lastIndex = 0;
			var frag = document.createDocumentFragment();
			var last = 0;
			text.replace( phoneRe, function ( m, offset ) {
				frag.appendChild( document.createTextNode( text.slice( last, offset ) ) );
				var a = document.createElement( 'a' );
				var digits = m.replace( /[^\d+]/g, '' );
				a.href = 'tel:' + ( digits.charAt( 0 ) === '0' ? '+33' + digits.slice( 1 ) : digits );
				a.textContent = m;
				frag.appendChild( a );
				last = offset + m.length;
			} );
			frag.appendChild( document.createTextNode( text.slice( last ) ) );
			node.parentNode.replaceChild( frag, node );
		} );
	} );

	/* 4. Planning : les cours du jour mis en avant. */
	var days = [ 'dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi' ];
	var today = days[ new Date().getDay() ];
	document.querySelectorAll( '.br-planning tbody tr' ).forEach( function ( tr ) {
		var cell = tr.querySelector( 'td' );
		if ( cell && cell.textContent.trim().toLowerCase() === today ) {
			tr.classList.add( 'br-today' );
			var badge = document.createElement( 'span' );
			badge.className = 'br-today-badge';
			badge.textContent = 'Aujourd’hui';
			cell.appendChild( badge );
		}
	} );

	/* 5. Pages de questions : sommaire cliquable des rubriques. */
	var main = document.querySelector( 'main' );
	if ( main && main.querySelectorAll( '.wp-block-details' ).length >= 8 ) {
		var heads = Array.prototype.filter.call( main.querySelectorAll( 'h2' ), function ( h ) {
			var section = h.closest( '.br-section' );
			return section && section.querySelector( '.wp-block-details' );
		} );
		if ( heads.length >= 3 ) {
			var nav = document.createElement( 'nav' );
			nav.className = 'br-jump';
			nav.setAttribute( 'aria-label', 'Rubriques de la page' );
			heads.forEach( function ( h ) {
				if ( ! h.id ) {
					h.id = h.textContent.toLowerCase().normalize( 'NFD' ).replace( /[̀-ͯ]/g, '' ).replace( /[^a-z0-9]+/g, '-' ).replace( /^-|-$/g, '' );
				}
				var a = document.createElement( 'a' );
				a.href = '#' + h.id;
				a.textContent = h.textContent;
				nav.appendChild( a );
			} );
			var head = main.querySelector( '.br-page-head .br-head' );
			if ( head ) {
				head.appendChild( nav );
			}
		}
	}

	/* 6. Articles : temps de lecture estimé. */
	if ( document.body.classList.contains( 'single-post' ) ) {
		var content = document.querySelector( '.wp-block-post-content' );
		var date = document.querySelector( '.br-article .wp-block-post-date' );
		if ( content && date ) {
			var words = content.textContent.trim().split( /\s+/ ).length;
			var span = document.createElement( 'span' );
			span.className = 'br-reading';
			span.textContent = Math.max( 1, Math.round( words / 220 ) ) + ' min de lecture';
			date.parentNode.insertBefore( span, date.nextSibling );
		}
	}

	/* 7. Bouton fixe mobile : reprend l'action principale de la page,
	      et s'efface quand un appel à l'action est déjà visible. */
	var sticky = document.querySelector( '.br-sticky' );
	if ( sticky ) {
		var stickyLink = sticky.querySelector( '.wp-block-button__link' );
		var mainAction = document.querySelector( '.br-page-head .wp-block-button:not(.is-style-outline) .wp-block-button__link' );
		if ( stickyLink && mainAction && mainAction.href && mainAction.href !== stickyLink.href ) {
			stickyLink.href = mainAction.href;
			stickyLink.textContent = mainAction.textContent;
		}
		if ( stickyLink && stickyLink.href.replace( /\/+$/, '/' ).indexOf( path ) !== -1 && path !== '/' ) {
			sticky.classList.add( 'br-sticky-off' );
		} else if ( 'IntersectionObserver' in window ) {
			var visible = new Set();
			var io = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( e ) {
					if ( e.isIntersecting ) {
						visible.add( e.target );
					} else {
						visible.delete( e.target );
					}
				} );
				sticky.classList.toggle( 'br-sticky-off', visible.size > 0 );
			}, { threshold: 0.01 } );
			document.querySelectorAll( '.br-hero .wp-block-buttons, .br-page-head .wp-block-buttons, .br-cta, .br-footer' ).forEach( function ( el ) {
				io.observe( el );
			} );
		}
	}

	/* 8. Liens d'ancre : défilement doux, sauf mouvement réduit. */
	if ( ! reduce ) {
		document.documentElement.classList.add( 'br-smooth' );
	}
}() );
