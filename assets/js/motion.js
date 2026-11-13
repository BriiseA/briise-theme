/**
 * Galet : animations légères (sans librairie).
 * 1. Apparition des éléments au défilement.
 * 2. Galets vivants : parallaxe à la souris sur le visuel du hero et les formes de l'appel à l'action.
 * 3. Titres principaux révélés ligne par ligne.
 * Tout est désactivé si le visiteur a demandé à réduire les animations.
 */
( function () {
	'use strict';

	window.briiseMotionLoaded = true;
	var root = document.documentElement;
	if ( ! root.classList.contains( 'br-motion' ) ) {
		return;
	}

	/* ---------- 3. Titres ligne par ligne ---------- */
	function splitLines( el ) {
		if ( el.dataset.glSplit ) {
			return;
		}
		// Seulement les titres en texte simple (pas de lien ni de mise en forme).
		if ( el.children.length ) {
			el.classList.add( 'br-reveal' );
			return;
		}
		var original = el.innerHTML;
		var words = el.textContent.split( /(\s+)/ ).filter( function ( w ) { return w.length; } );
		el.innerHTML = words.map( function ( w ) {
			return /^\s+$/.test( w ) && w.indexOf( ' ' ) === -1 ? ' ' : '<span class="br-w">' + w.replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ) + '</span>';
		} ).join( '' );

		var lines = [];
		var lastTop = null;
		el.querySelectorAll( '.br-w' ).forEach( function ( span ) {
			var top = span.offsetTop;
			if ( lastTop === null || Math.abs( top - lastTop ) > 4 ) {
				lines.push( [] );
				lastTop = top;
			}
			lines[ lines.length - 1 ].push( span.textContent );
		} );

		el.innerHTML = lines.map( function ( line, i ) {
			return '<span class="br-line"><span class="br-line-inner" style="--br-i:' + i + '">' + line.join( ' ' ).replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ) + '</span></span>';
		} ).join( ' ' );
		el.dataset.glSplit = '1';
		el.classList.add( 'br-split-title' );

		// Une fois l'animation terminée, on remet le titre d'origine
		// (pour un rendu exact si la fenêtre est redimensionnée).
		var total = ( lines.length - 1 ) * 110 + 1100;
		el._glRestore = function () {
			setTimeout( function () {
				el.innerHTML = original;
				el.classList.remove( 'br-split-title', 'is-in' );
				el.classList.add( 'br-split-done' );
			}, total + 150 );
		};
	}

	/* ---------- 1. Apparition au défilement ---------- */
	var selectors = [
		'main h2:not(.br-cta h2)', '.br-label', '.br-lead', '.br-chips', '.br-statement', '.br-quote',
		'.br-arrow', '.br-project', '.br-expertise', '.br-steps > .wp-block-column', '.br-stats > .wp-block-column',
		'.br-meta > .wp-block-column', '.br-member', '.br-card', '.br-style', '.br-table', '.wp-block-post-template > li',
		'main .wp-block-image:not(.br-hero .wp-block-image)', 'main .wp-block-buttons', '.is-style-br-tirets', '.br-footer-mail'
	];
	var items = Array.prototype.slice.call( document.querySelectorAll( selectors.join( ',' ) ) );

	// Les éléments déjà animés via un parent ne sont pas animés une seconde fois.
	items = items.filter( function ( el ) {
		if ( el.closest( '.br-page-head, .br-hero' ) ) {
			return false;
		}
		var p = el.parentElement;
		while ( p ) {
			if ( items.indexOf( p ) !== -1 ) {
				return false;
			}
			p = p.parentElement;
		}
		return true;
	} );

	items.forEach( function ( el ) {
		el.classList.add( 'br-reveal' );
		// Décalage en cascade pour les éléments voisins (cartes, colonnes).
		var siblings = Array.prototype.filter.call( el.parentElement.children, function ( s ) { return items.indexOf( s ) !== -1; } );
		var index = siblings.indexOf( el );
		if ( siblings.length > 1 && index > 0 ) {
			el.style.setProperty( '--br-delay', Math.min( index, 5 ) * 90 + 'ms' );
		}
	} );

	var titles = Array.prototype.slice.call( document.querySelectorAll( '.br-cta h2' ) );

	function show( el ) {
		if ( titles.indexOf( el ) !== -1 ) {
			splitLines( el );
			requestAnimationFrame( function () {
				requestAnimationFrame( function () {
					el.classList.add( 'is-in' );
					if ( el._glRestore ) {
						el._glRestore();
					}
				} );
			} );
		} else {
			el.classList.add( 'is-in' );
		}
	}

	var start = function () {
		if ( ! ( 'IntersectionObserver' in window ) ) {
			items.concat( titles ).forEach( show );
			return;
		}
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					show( entry.target );
					io.unobserve( entry.target );
				}
			} );
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 } );
		items.concat( titles ).forEach( function ( el ) { io.observe( el ); } );
	};

	// On attend les polices pour mesurer les lignes des titres correctement.
	if ( document.fonts && document.fonts.ready ) {
		var done = false;
		var go = function () { if ( ! done ) { done = true; start(); } };
		document.fonts.ready.then( go );
		setTimeout( go, 350 );
	} else {
		start();
	}

	/* ---------- 2. Galets vivants : parallaxe à la souris ---------- */
	if ( window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches ) {
		var zones = document.querySelectorAll( '.br-hero, .br-cta' );
		zones.forEach( function ( zone ) {
			var raf = null;
			zone.addEventListener( 'pointermove', function ( e ) {
				var r = zone.getBoundingClientRect();
				var x = ( e.clientX - r.left ) / r.width - 0.5;
				var y = ( e.clientY - r.top ) / r.height - 0.5;
				if ( raf ) {
					cancelAnimationFrame( raf );
				}
				raf = requestAnimationFrame( function () {
					zone.style.setProperty( '--br-mx', x.toFixed( 3 ) );
					zone.style.setProperty( '--br-my', y.toFixed( 3 ) );
				} );
			} );
			zone.addEventListener( 'pointerleave', function () {
				zone.style.setProperty( '--br-mx', 0 );
				zone.style.setProperty( '--br-my', 0 );
			} );
		} );
	}
}() );
