/**
 * Galet : animations légères (sans librairie).
 * 1. Apparition des éléments au défilement.
 * 2. Galets vivants : parallaxe à la souris sur le visuel du hero et les formes de l'appel à l'action.
 * 3. Titres principaux révélés ligne par ligne.
 * 6. Frise et fil des étapes remplis au rythme du défilement.
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
		'main .wp-block-image:not(.br-hero .wp-block-image)', 'main .wp-block-buttons', '.is-style-br-tirets', '.br-footer-mail',
		'.br-tuiles > .br-tuile', '.br-confiance-item', '.br-schema'
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
			compter( el );
		}
	}

	/* ---------- 4. Chiffres qui comptent jusqu'à leur valeur ---------- */
	// Seule une valeur purement numérique compte : un symbole facultatif devant (+, ~, ≈, <, >),
	// le nombre (espace des milliers acceptée), puis au plus une unité courte : %, /5, + collés,
	// ou un mot court après une espace (ans, h, jours, km, m²). Un prix (€), un mot devant
	// ou une phrase restent fixes : « Formule + 290 € » ou « Dès 690 € HT » ne s'animent pas.
	var ESP = '[\\s\\u00a0\\u202f]';
	var CHIFFRE = new RegExp( '^([+~≈<>]?' + ESP + '?)(\\d{1,3}(?:' + ESP + '\\d{3})+|\\d+)(?:([.,])(\\d+))?' +
		'(' + ESP + '?(?:%|\\/' + ESP + '?\\d+|\\+)|' + ESP + '[a-zà-ÿ²³]{1,8}\\+?)?$', 'i' );
	function lireChiffre( texte ) {
		var m = texte.trim().match( CHIFFRE );
		if ( ! m ) {
			return null;
		}
		var milliers = m[ 2 ].match( new RegExp( ESP ) );
		return {
			avant: m[ 1 ],
			valeur: parseFloat( m[ 2 ].replace( new RegExp( ESP, 'g' ), '' ) + ( m[ 4 ] ? '.' + m[ 4 ] : '' ) ),
			dec: m[ 4 ] ? m[ 4 ].length : 0,
			sep: m[ 3 ] || ',',
			milliers: milliers ? milliers[ 0 ] : '',
			apres: m[ 5 ] || '',
		};
	}
	function ecrireChiffre( n, v ) {
		var parts = v.toFixed( n.dec ).split( '.' );
		if ( n.milliers ) {
			parts[ 0 ] = parts[ 0 ].replace( /\B(?=(\d{3})+$)/g, n.milliers );
		}
		return n.avant + parts.join( n.sep ) + n.apres;
	}

	function compter( el ) {
		var cibles = el.matches( '.br-tuile-chiffre, .br-stat' ) ? [ el ] : el.querySelectorAll( '.br-tuile-chiffre, .br-stat' );
		Array.prototype.forEach.call( cibles, function ( c ) {
			if ( c.dataset.brCompte || c.children.length ) {
				return;
			}
			var n = lireChiffre( c.textContent );
			if ( ! n || ! ( n.valeur > 1 ) ) {
				return;
			}
			c.dataset.brCompte = '1';
			var final = c.textContent;
			var cible = n.valeur;
			c.setAttribute( 'aria-label', final );
			var t0 = null;
			var pas = function ( t ) {
				if ( t0 === null ) {
					t0 = t;
				}
				var k = Math.min( 1, ( t - t0 ) / 1300 );
				var v = cible * ( 1 - Math.pow( 1 - k, 3 ) );
				c.textContent = ecrireChiffre( n, v );
				if ( k < 1 ) {
					requestAnimationFrame( pas );
				} else {
					c.textContent = final;
					c.removeAttribute( 'aria-label' );
				}
			};
			requestAnimationFrame( pas );
		} );
	}

	/* ---------- 5. Étapes : les numéros s'allument l'un après l'autre ---------- */
	var etapes = document.querySelectorAll( '.br-steps' );
	if ( etapes.length && 'IntersectionObserver' in window ) {
		var ioEtapes = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( e ) {
				if ( e.isIntersecting ) {
					e.target.classList.add( 'br-etapes-on' );
					ioEtapes.unobserve( e.target );
				}
			} );
		}, { threshold: 0.35 } );
		Array.prototype.forEach.call( etapes, function ( el ) {
			el.classList.add( 'br-etapes-anim' );
			ioEtapes.observe( el );
		} );
	}

	/* ---------- 6. Frise et fil des étapes : remplis au rythme du défilement ---------- */
	var fils = Array.prototype.slice.call( document.querySelectorAll( '.br-fil' ) );
	if ( fils.length ) {
		var borne = function ( v ) { return Math.max( 0, Math.min( 1, v ) ); };
		var rafFil = null;
		var majFils = function () {
			rafFil = null;
			var vh = window.innerHeight;
			fils.forEach( function ( fil ) {
				var r = fil.getBoundingClientRect();
				if ( r.bottom < -vh || r.top > vh * 2 ) {
					return;
				}
				var etapes = fil.querySelectorAll( ':scope > .br-fil-etape' );
				var n = etapes.length;
				var ronds = Array.prototype.map.call( etapes, function ( e ) {
					var num = e.querySelector( '.br-fil-num' );
					var b = ( num || e ).getBoundingClientRect();
					return b.top + b.height / 2;
				} );
				// Frise : les numéros sont sur une même ligne, on suit la position de la section.
				var frise = n > 1 && Math.abs( ronds[ 0 ] - ronds[ 1 ] ) < 2;
				var pos = borne( ( vh * 0.85 - r.top ) / ( vh * 0.45 ) ) * ( n - 1 );
				var entree = r.top < vh * 0.85;
				Array.prototype.forEach.call( etapes, function ( e, i ) {
					var f;
					var on;
					if ( frise ) {
						on = entree && pos >= i - 0.001;
						f = borne( pos - i );
					} else {
						// Fil vertical : une étape s'allume quand son numéro passe aux deux tiers de l'écran.
						var ligne = vh * 0.66;
						on = ronds[ i ] <= ligne;
						f = i < n - 1 ? borne( ( ligne - ronds[ i ] ) / ( ronds[ i + 1 ] - ronds[ i ] ) ) : 0;
					}
					e.classList.toggle( 'is-on', on );
					e.style.setProperty( '--br-f', f.toFixed( 3 ) );
				} );
			} );
		};
		var demanderFils = function () {
			if ( ! rafFil ) {
				rafFil = requestAnimationFrame( majFils );
			}
		};
		fils.forEach( function ( fil ) { fil.classList.add( 'br-fil-anim' ); } );
		majFils();
		window.addEventListener( 'scroll', demanderFils, { passive: true } );
		window.addEventListener( 'resize', demanderFils );
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
