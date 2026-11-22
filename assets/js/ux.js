/**
 * Briise : confort de navigation.
 * Fonctionne sur les pages existantes, sans modifier leur contenu.
 * Les réglages viennent de « Mon entreprise > Fonctions » (window.briiseUx).
 * Le bandeau d'information et la mesure des contacts sont dans l'extension Briise Socle.
 */
( function () {
	'use strict';

	var cfg = window.briiseUx || {};
	var on = function ( key ) {
		return cfg[ key ] !== false;
	};
	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var path = window.location.pathname.replace( /\/+$/, '/' );

	/* 1. En-tête qui se cache en descendant et réapparaît en remontant. */
	var header = document.querySelector( 'header.wp-block-template-part' );
	if ( header && on( 'menu' ) ) {
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

	/* 4. Planning et horaires : la ligne du jour mise en avant. */
	var days = [ 'dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi' ];
	var today = days[ new Date().getDay() ];
	var isoDay = String( new Date().getDay() || 7 );
	var addBadge = function ( el ) {
		var badge = document.createElement( 'span' );
		badge.className = 'br-today-badge';
		badge.textContent = 'Aujourd’hui';
		el.appendChild( badge );
	};
	document.querySelectorAll( on( 'jour' ) ? '.br-horaires-ligne' : '.br-none' ).forEach( function ( row ) {
		if ( row.dataset.jours.split( ',' ).indexOf( isoDay ) !== -1 ) {
			row.classList.add( 'br-today' );
			addBadge( row.querySelector( 'dt' ) );
		}
	} );
	document.querySelectorAll( on( 'jour' ) ? '.br-planning tbody tr' : '.br-none' ).forEach( function ( tr ) {
		var cell = tr.querySelector( 'td' );
		if ( cell && cell.textContent.trim().toLowerCase() === today ) {
			tr.classList.add( 'br-today' );
			addBadge( cell );
		}
	} );

	/* 5. Pages de questions : sommaire cliquable des rubriques. */
	var main = document.querySelector( 'main' );
	if ( main && on( 'sommaire' ) && main.querySelectorAll( '.wp-block-details' ).length >= 8 ) {
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
		var stickyLink = sticky.querySelector( '.wp-block-button:not(.br-sticky-tel) .wp-block-button__link' );
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
			document.querySelectorAll( '.br-hero .wp-block-buttons, .br-banniere .wp-block-buttons, .br-page-head .wp-block-buttons, .br-cta, .br-footer' ).forEach( function ( el ) {
				io.observe( el );
			} );
		}
	}

	/* 8. Retour en haut : seulement sur les longues pages, après deux écrans,
	      au-dessus du bouton fixe mobile quand celui-ci est affiché. */
	var haut = document.getElementById( 'br-haut' );
	if ( haut ) {
		var majHaut = function () {
			var longue = document.documentElement.scrollHeight > window.innerHeight * 3;
			haut.classList.toggle( 'br-haut-visible', longue && window.scrollY > window.innerHeight * 2 );
			var stickyVisible = sticky && ! sticky.classList.contains( 'br-sticky-off' ) && getComputedStyle( sticky ).display !== 'none';
			haut.classList.toggle( 'br-haut-releve', !! stickyVisible );
		};
		window.addEventListener( 'scroll', majHaut, { passive: true } );
		window.addEventListener( 'resize', majHaut, { passive: true } );
		if ( sticky && 'MutationObserver' in window ) {
			new MutationObserver( majHaut ).observe( sticky, { attributes: true, attributeFilter: [ 'class' ] } );
		}
		majHaut();
		haut.addEventListener( 'click', function ( ev ) {
			ev.preventDefault();
			window.scrollTo( { top: 0, behavior: reduce ? 'auto' : 'smooth' } );
			// Le clavier repart du début de la page, pas du bas.
			var cible = document.querySelector( '.br-skip, header a' );
			if ( cible ) {
				cible.focus( { preventScroll: true } );
			}
		} );
	}

	/* 9. Liens d'ancre : défilement doux, sauf mouvement réduit. */
	if ( ! reduce ) {
		document.documentElement.classList.add( 'br-smooth' );
	}
}() );

/* Avant / après à faire glisser : souris (survol ou glisser), doigt, clavier. */
(function () {
	document.querySelectorAll('.br-glisse').forEach(function (c) {
		if (c.querySelectorAll('img').length < 2) { return; }
		c.classList.add('is-pret');
		var p = document.createElement('div');
		p.className = 'br-comp-poignee';
		p.setAttribute('aria-hidden', 'true');
		p.innerHTML = '<span><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l-6 6l6 6"/><path d="M15 6l6 6l-6 6"/></svg></span>';
		var r = document.createElement('input');
		r.type = 'range'; r.min = '0'; r.max = '100'; r.value = '50';
		r.className = 'br-comp-range';
		r.setAttribute('aria-label', 'Comparer avant et après');
		c.appendChild(p); c.appendChild(r);
		var appui = false;
		function regler(v) { v = Math.max(0, Math.min(100, v)); c.style.setProperty('--br-pos', v + '%'); r.value = String(Math.round(v)); }
		function depuis(e) { var b = c.getBoundingClientRect(); regler((e.clientX - b.left) / b.width * 100); }
		c.addEventListener('pointerdown', function (e) { appui = true; if (c.setPointerCapture) { c.setPointerCapture(e.pointerId); } depuis(e); });
		c.addEventListener('pointermove', function (e) { if (appui || e.pointerType === 'mouse') { depuis(e); } });
		['pointerup', 'pointercancel'].forEach(function (t) { c.addEventListener(t, function () { appui = false; }); });
		r.addEventListener('input', function () { regler(+r.value); });
		regler(50);
	});
	/* Le temps derrière le prix : une barre dessinée à partir des durées du tableau (« 30 min », « 2 h 30 »).
	   Le tableau reste la source lisible ; la barre est décorative (aria-hidden). */
	document.querySelectorAll('.br-temps table').forEach(function (t) {
		var lignes = t.querySelectorAll('tbody tr');
		var minutes = function (txt) {
			var h = /(\d+)\s*h\s*(\d+)?/.exec(txt), m = /(\d+)\s*min/.exec(txt);
			return h ? (+h[1]) * 60 + (+(h[2] || 0)) : (m ? +m[1] : 0);
		};
		var barre = document.createElement('div');
		barre.className = 'br-temps-barre';
		barre.setAttribute('aria-hidden', 'true');
		var total = 0;
		lignes.forEach(function (tr, i) {
			var c = tr.querySelectorAll('td');
			var d = c.length > 1 ? minutes(c[c.length - 1].textContent) : 0;
			if (!d) { return; }
			total += d;
			var s = document.createElement('span');
			s.className = 'br-temps-c' + (i % 6 + 1);
			s.style.flex = String(d);
			barre.appendChild(s);
			var pastille = document.createElement('span');
			pastille.className = 'br-temps-pastille br-temps-c' + (i % 6 + 1);
			pastille.setAttribute('aria-hidden', 'true');
			c[0].insertBefore(pastille, c[0].firstChild);
		});
		if (total) { t.parentNode.insertBefore(barre, t); }
	});
})();
