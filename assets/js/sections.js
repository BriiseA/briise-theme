/**
 * Briise : comportements des sections 1.16.
 * Bandes qui défilent, FAQ avec recherche, orientation « Je cherche … pour … », estimateur.
 * Sans ce script, chaque section reste lisible : bande fixe, FAQ complète, liste de liens, barème.
 */
( function () {
	'use strict';

	var calme = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ----- Bandes qui défilent ------------------------------------------------
	   La piste est recopiée assez de fois pour remplir deux largeurs d'écran,
	   puis glisse d'une longueur de contenu : la boucle ne se voit pas.
	   Les copies sont masquées aux lecteurs d'écran et sorties du clavier. */
	function bande( bloc ) {
		var piste = bloc.querySelector( '.br-defile-piste' );
		if ( ! piste || calme || bloc.classList.contains( 'br-defile--actif' ) ) {
			return;
		}
		var items = Array.prototype.slice.call( piste.children );
		if ( items.length < 2 ) {
			return;
		}
		bloc.classList.add( 'br-defile--actif' );
		var largeur = piste.scrollWidth;
		if ( ! largeur ) {
			bloc.classList.remove( 'br-defile--actif' );
			return;
		}
		var tours = Math.max( 1, Math.ceil( ( bloc.clientWidth * 2 ) / largeur ) );
		for ( var t = 0; t < tours; t++ ) {
			items.forEach( function ( item ) {
				var copie = item.cloneNode( true );
				copie.setAttribute( 'aria-hidden', 'true' );
				copie.setAttribute( 'inert', '' );
				copie.querySelectorAll( 'a, button, [tabindex]' ).forEach( function ( el ) {
					el.setAttribute( 'tabindex', '-1' );
				} );
				copie.querySelectorAll( 'img' ).forEach( function ( img ) {
					img.setAttribute( 'alt', '' );
					img.removeAttribute( 'loading' );
				} );
				piste.appendChild( copie );
			} );
		}
		piste.style.setProperty( '--br-defile-l', largeur + 'px' );
		// Vitesse constante, quelle que soit la longueur : environ 40 px par seconde.
		var vitesse = bloc.classList.contains( 'br-defile--avis' ) ? 32 : 42;
		piste.style.setProperty( '--br-defile-d', Math.round( largeur / vitesse ) + 's' );

		// Bouton pause : obligatoire pour une animation de plus de cinq secondes (WCAG 2.2.2).
		var bouton = document.createElement( 'button' );
		bouton.type = 'button';
		bouton.className = 'br-defile-pause';
		bouton.setAttribute( 'aria-pressed', 'false' );
		bouton.innerHTML = '<span class="screen-reader-text">Mettre en pause le défilement</span><svg aria-hidden="true" focusable="false" width="14" height="14" viewBox="0 0 14 14"><path class="br-defile-ic-pause" d="M3 2h3v10H3zM8 2h3v10H8z"/><path class="br-defile-ic-lecture" d="M3 1.5v11l9-5.5z"/></svg>';
		bouton.addEventListener( 'click', function () {
			var pause = bouton.getAttribute( 'aria-pressed' ) !== 'true';
			bouton.setAttribute( 'aria-pressed', pause ? 'true' : 'false' );
			bloc.classList.toggle( 'br-defile--pause', pause );
			bouton.querySelector( '.screen-reader-text' ).textContent = pause ? 'Reprendre le défilement' : 'Mettre en pause le défilement';
		} );
		bloc.appendChild( bouton );
	}

	/* ----- FAQ avec recherche --------------------------------------------- */
	function sansAccent( s ) {
		return ( s || '' ).normalize( 'NFD' ).replace( /[̀-ͯ]/g, '' ).toLowerCase();
	}

	function faq( section ) {
		var details = Array.prototype.slice.call( section.querySelectorAll( 'details' ) );
		if ( details.length < 3 || section.querySelector( '.br-faq-outils' ) ) {
			return;
		}
		var zone = details[ 0 ].parentNode;
		// Chaque question est rattachée à l'intertitre qui la précède.
		var themes = [];
		var courant = null;
		Array.prototype.slice.call( zone.children ).forEach( function ( el ) {
			if ( /^H[3-4]$/.test( el.tagName ) ) {
				courant = { titre: el, nom: el.textContent.trim(), items: [] };
				themes.push( courant );
			} else if ( el.tagName === 'DETAILS' && courant ) {
				courant.items.push( el );
				el.setAttribute( 'data-theme', themes.length - 1 );
			}
		} );
		themes = themes.filter( function ( t ) { return t.items.length; } );
		var vide = section.querySelector( '.br-faq-vide' );

		var outils = document.createElement( 'div' );
		outils.className = 'br-faq-outils';
		var id = 'br-faq-q-' + Math.random().toString( 36 ).slice( 2, 7 );
		outils.innerHTML = '<div class="br-faq-champ"><label for="' + id + '">Chercher une question</label>'
			+ '<input id="' + id + '" type="search" autocomplete="off" placeholder="Devis, délai, prix…"></div>'
			+ ( themes.length > 1 ? '<div class="br-filtres br-faq-themes" role="group" aria-label="Thèmes"></div>' : '' )
			+ '<p class="br-faq-compte" aria-live="polite"></p>';
		zone.insertBefore( outils, zone.firstChild );
		var champ = outils.querySelector( 'input' );
		var compte = outils.querySelector( '.br-faq-compte' );
		var theme = '';

		if ( themes.length > 1 ) {
			var groupe = outils.querySelector( '.br-faq-themes' );
			[ { nom: 'Toutes', i: '' } ].concat( themes.map( function ( t, i ) { return { nom: t.nom, i: String( i ) }; } ) ).forEach( function ( t ) {
				var b = document.createElement( 'button' );
				b.type = 'button';
				b.className = 'br-filtre';
				b.textContent = t.nom;
				b.setAttribute( 'aria-pressed', t.i === '' ? 'true' : 'false' );
				b.addEventListener( 'click', function () {
					theme = t.i;
					groupe.querySelectorAll( 'button' ).forEach( function ( x ) { x.setAttribute( 'aria-pressed', x === b ? 'true' : 'false' ); } );
					filtrer();
				} );
				groupe.appendChild( b );
			} );
		}
		themes.forEach( function ( t, i ) {
			t.items.forEach( function ( d ) { d.setAttribute( 'data-theme', i ); } );
		} );

		function filtrer() {
			var mots = sansAccent( champ.value ).split( /\s+/ ).filter( function ( m ) { return m.length > 1; } );
			var n = 0;
			details.forEach( function ( d ) {
				var texte = sansAccent( d.textContent );
				var ok = ( theme === '' || d.getAttribute( 'data-theme' ) === theme ) && mots.every( function ( m ) { return texte.indexOf( m ) !== -1; } );
				d.hidden = ! ok;
				n += ok ? 1 : 0;
			} );
			themes.forEach( function ( t ) {
				t.titre.hidden = ! t.items.some( function ( d ) { return ! d.hidden; } );
			} );
			if ( vide ) {
				vide.hidden = n > 0;
			}
			var filtre = mots.length || theme !== '';
			compte.textContent = filtre ? ( n ? n + ( n > 1 ? ' questions' : ' question' ) : '' ) : '';
		}
		champ.addEventListener( 'input', filtrer );
		section.classList.add( 'br-faq-cherche--actif' );
		if ( vide ) {
			vide.hidden = true;
		}
	}

	/* ----- Orientation « Je cherche … pour … » ------------------------------ */
	function orientation( section ) {
		var phrase = section.querySelector( '.br-oriente-phrase' );
		var liens = Array.prototype.slice.call( section.querySelectorAll( '.br-oriente-choix a' ) );
		if ( ! phrase || ! liens.length || section.querySelector( '.br-oriente-form' ) ) {
			return;
		}
		var choix = liens.map( function ( a ) {
			var p = a.textContent.split( '|' ).map( function ( x ) { return x.trim(); } );
			return { a: p[ 0 ] || '', b: p[ 1 ] || '', nom: p[ 2 ] || '', url: a.getAttribute( 'href' ) };
		} ).filter( function ( c ) { return c.a && c.url; } );
		var deux = choix.some( function ( c ) { return c.b; } );
		var morceaux = phrase.textContent.split( /…|\.\.\./ );
		if ( morceaux.length < 2 ) {
			morceaux = [ phrase.textContent + ' ', '' ];
		}
		var uniq = function ( arr ) { return arr.filter( function ( v, i ) { return v && arr.indexOf( v ) === i; } ); };

		var form = document.createElement( 'div' );
		form.className = 'br-oriente-form';
		var n = Math.random().toString( 36 ).slice( 2, 7 );
		var selA = document.createElement( 'select' );
		selA.id = 'br-or-a-' + n;
		var selB = document.createElement( 'select' );
		selB.id = 'br-or-b-' + n;
		uniq( choix.map( function ( c ) { return c.a; } ) ).forEach( function ( v ) { selA.add( new Option( v, v ) ); } );

		var p = document.createElement( 'p' );
		p.className = 'br-oriente-ligne';
		var lab = function ( texte, sel ) {
			var l = document.createElement( 'label' );
			l.setAttribute( 'for', sel.id );
			l.textContent = texte.trim();
			return l;
		};
		p.appendChild( lab( morceaux[ 0 ], selA ) );
		p.appendChild( selA );
		if ( deux ) {
			p.appendChild( lab( morceaux[ 1 ] || 'pour', selB ) );
			p.appendChild( selB );
		}
		var aller = document.createElement( 'a' );
		aller.className = 'wp-block-button__link wp-element-button br-oriente-aller';
		p.appendChild( aller );
		form.appendChild( p );

		function majB() {
			var garde = selB.value;
			selB.innerHTML = '';
			uniq( choix.filter( function ( c ) { return c.a === selA.value; } ).map( function ( c ) { return c.b; } ) ).forEach( function ( v ) { selB.add( new Option( v, v ) ); } );
			if ( garde ) {
				selB.value = garde;
			}
			if ( ! selB.value && selB.options.length ) {
				selB.selectedIndex = 0;
			}
			selB.disabled = selB.options.length < 2;
		}
		function majLien() {
			var c = choix.filter( function ( x ) { return x.a === selA.value && ( ! deux || ! x.b || x.b === selB.value ); } )[ 0 ] || choix[ 0 ];
			aller.href = c.url;
			aller.textContent = c.nom ? 'Voir : ' + c.nom : 'Voir la page';
		}
		selA.addEventListener( 'change', function () { if ( deux ) { majB(); } majLien(); } );
		selB.addEventListener( 'change', majLien );
		if ( deux ) {
			majB();
		}
		majLien();
		phrase.parentNode.insertBefore( form, phrase );
		section.classList.add( 'br-oriente--actif' );
	}


	/* ----- Estimateur : le tableau du barème devient trois questions --------
	   Ligne : question | choix | montant bas | montant haut (ajoutés au total). */
	function montant( t ) {
		var n = parseInt( String( t || '' ).replace( /[^\d-]/g, '' ), 10 );
		return isNaN( n ) ? 0 : n;
	}
	function euros( n ) {
		// Espace insécable ordinaire : certaines polices n'ont pas l'espace fine que renvoie toLocaleString.
		return ( Math.round( n / 100 ) * 100 ).toLocaleString( 'fr-FR' ).replace( /[\u202f\u00a0\s]/g, '\u00a0' ) + '\u00a0€';
	}
	function estimateur( section ) {
		var table = section.querySelector( '.br-estim-bareme table' );
		var sortie = section.querySelector( '.br-estim-montant' );
		if ( ! table || ! sortie || section.querySelector( '.br-estim-questions' ) ) {
			return;
		}
		var questions = [];
		var index = {};
		Array.prototype.slice.call( table.tBodies[ 0 ] ? table.tBodies[ 0 ].rows : [] ).forEach( function ( tr ) {
			var c = tr.cells;
			if ( c.length < 3 ) {
				return;
			}
			var q = c[ 0 ].textContent.trim();
			var choix = { nom: c[ 1 ].textContent.trim(), bas: montant( c[ 2 ].textContent ), haut: montant( ( c[ 3 ] || c[ 2 ] ).textContent ) };
			if ( ! q || ! choix.nom ) {
				return;
			}
			if ( ! ( q in index ) ) {
				index[ q ] = questions.length;
				questions.push( { nom: q, choix: [] } );
			}
			questions[ index[ q ] ].choix.push( choix );
		} );
		if ( ! questions.length ) {
			return;
		}
		var etat = questions.map( function ( q ) { return q.choix.length > 1 ? 0 : -1; } );
		var boite = document.createElement( 'div' );
		boite.className = 'br-estim-questions';
		var n = Math.random().toString( 36 ).slice( 2, 7 );
		questions.forEach( function ( q, i ) {
			if ( q.choix.length === 1 ) {
				var lab = document.createElement( 'label' );
				lab.className = 'br-estim-case';
				var cb = document.createElement( 'input' );
				cb.type = 'checkbox';
				cb.addEventListener( 'change', function () { etat[ i ] = cb.checked ? 0 : -1; calculer(); } );
				lab.appendChild( cb );
				lab.appendChild( document.createTextNode( ' ' + q.nom ) );
				boite.appendChild( lab );
				return;
			}
			var groupe = document.createElement( 'fieldset' );
			groupe.className = 'br-estim-q';
			var leg = document.createElement( 'legend' );
			leg.textContent = q.nom;
			groupe.appendChild( leg );
			var ligne = document.createElement( 'div' );
			ligne.className = 'br-estim-choix';
			q.choix.forEach( function ( c, j ) {
				var l = document.createElement( 'label' );
				var r = document.createElement( 'input' );
				r.type = 'radio';
				r.name = 'br-estim-' + n + '-' + i;
				r.checked = j === 0;
				r.addEventListener( 'change', function () { etat[ i ] = j; calculer(); } );
				var span = document.createElement( 'span' );
				span.textContent = c.nom;
				l.appendChild( r );
				l.appendChild( span );
				ligne.appendChild( l );
			} );
			groupe.appendChild( ligne );
			boite.appendChild( groupe );
		} );
		var bareme = section.querySelector( '.br-estim-bareme' );
		bareme.parentNode.insertBefore( boite, bareme );
		sortie.setAttribute( 'aria-live', 'polite' );
		var detail = document.createElement( 'p' );
		detail.className = 'br-estim-detail';
		sortie.parentNode.insertBefore( detail, sortie.nextSibling );

		function calculer() {
			var bas = 0;
			var haut = 0;
			var mots = [];
			questions.forEach( function ( q, i ) {
				if ( etat[ i ] < 0 ) {
					return;
				}
				var c = q.choix[ etat[ i ] ];
				bas += c.bas;
				haut += c.haut;
				mots.push( q.choix.length === 1 ? q.nom.charAt( 0 ).toLowerCase() + q.nom.slice( 1 ) : c.nom.toLowerCase() );
			} );
			sortie.textContent = bas === haut ? euros( bas ) : euros( bas ) + ' à ' + euros( haut );
			detail.textContent = mots.join( ', ' ).replace( /^./, function ( x ) { return x.toUpperCase(); } );
		}
		calculer();
		section.classList.add( 'br-estim--actif' );
	}

	function demarrer() {
		document.querySelectorAll( '.br-defile' ).forEach( function ( b ) {
			// Les logos se mesurent une fois chargés.
			var imgs = Array.prototype.slice.call( b.querySelectorAll( 'img' ) );
			imgs.forEach( function ( img ) { img.loading = 'eager'; } );
			var attente = imgs.filter( function ( img ) { return ! img.complete; } );
			if ( ! attente.length ) {
				bande( b );
				return;
			}
			var reste = attente.length;
			attente.forEach( function ( img ) {
				var fin = function () { if ( --reste === 0 ) { bande( b ); } };
				img.addEventListener( 'load', fin, { once: true } );
				img.addEventListener( 'error', fin, { once: true } );
			} );
		} );
		document.querySelectorAll( '.br-faq-cherche' ).forEach( faq );
		document.querySelectorAll( '.br-oriente' ).forEach( orientation );
		document.querySelectorAll( '.br-estim' ).forEach( estimateur );
	}
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', demarrer );
	} else {
		demarrer();
	}
}() );
