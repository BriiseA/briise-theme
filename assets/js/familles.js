/**
 * Briise : comportements des familles de sections.
 * Services en onglets : la liste devient des onglets, un service affiché à la fois.
 * Services et avis en défilement : flèches « précédent » et « suivant ».
 * Ouverture en diaporama : les photos changent en fondu toutes les 6 secondes, bouton pause.
 * Ouverture avec vidéo : vidéo muette en boucle, bouton pause.
 * Logos qui défilent, galerie en bande, réalisations en défilement.
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
	// o : liste (sélecteur de la bande), precedent et suivant (libellés des flèches).
	function defilement( section, o ) {
		o = o || { liste: '.br-services-liste', precedent: 'Service précédent', suivant: 'Service suivant' };
		var liste = section.querySelector( o.liste );
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
			var premier = liste.firstElementChild;
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
		var precedent = bouton( -1, o.precedent, '←' );
		var suivant = bouton( 1, o.suivant, '→' );
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

	/* ----- Logos qui défilent : la rangée est doublée (copie cachée aux lecteurs d'écran) et glisse
	   en boucle ; pause au survol, au clavier ou avec le bouton. Moins d'animations : la rangée reste fixe. */
	function logosDefilants( section ) {
		var rangee = section.querySelector( '.br-logos' );
		if ( ! rangee || calme || rangee.classList.contains( 'br-logos--actif' ) || rangee.children.length < 3 ) {
			return;
		}
		Array.prototype.slice.call( rangee.children ).forEach( function ( logo ) {
			var copie = logo.cloneNode( true );
			copie.setAttribute( 'aria-hidden', 'true' );
			copie.querySelectorAll( 'img' ).forEach( function ( img ) {
				img.setAttribute( 'alt', '' );
			} );
			copie.querySelectorAll( 'a' ).forEach( function ( a ) {
				a.setAttribute( 'tabindex', '-1' );
			} );
			rangee.appendChild( copie );
		} );
		rangee.classList.add( 'br-logos--actif' );
		boutonPause( section, function () {
			section.classList.add( 'br-logos--pause' );
		}, function () {
			section.classList.remove( 'br-logos--pause' );
		}, false );
	}


	/* ----- Abonnements : « Au mois » / « À l'année ». Sans script, les deux prix restent affichés. */
	function abonnement( section ) {
		var cartes = section.querySelector( '.br-prices' );
		if ( ! cartes || section.querySelector( '.br-abonnement-choix' ) ) {
			return;
		}
		var choix = document.createElement( 'div' );
		choix.className = 'br-abonnement-choix';
		choix.setAttribute( 'role', 'group' );
		choix.setAttribute( 'aria-label', 'Afficher les prix' );
		var boutons = [ [ 'mois', 'Au mois' ], [ 'an', 'À l’année' ] ].map( function ( c ) {
			var b = document.createElement( 'button' );
			b.type = 'button';
			b.textContent = c[ 1 ];
			b.addEventListener( 'click', function () {
				montrer( c[ 0 ] );
			} );
			choix.appendChild( b );
			return [ c[ 0 ], b ];
		} );
		function montrer( v ) {
			section.classList.toggle( 'is-mois', 'mois' === v );
			section.classList.toggle( 'is-an', 'an' === v );
			boutons.forEach( function ( b ) {
				b[ 1 ].setAttribute( 'aria-pressed', b[ 0 ] === v ? 'true' : 'false' );
			} );
		}
		var tete = section.querySelector( '.br-head' );
		( tete || cartes ).insertAdjacentElement( tete ? 'beforeend' : 'beforebegin', choix );
		montrer( 'mois' );
	}

	/* ----- Mot qui change : « mot 1 / mot 2 / mot 3 » dans un titre. Les lecteurs d'écran lisent
	   la liste entière ; moins d'animations : le premier mot reste. */
	function motsQuiChangent( el ) {
		if ( el.dataset.brPret ) {
			return;
		}
		var mots = el.textContent.split( ' / ' ).map( function ( m ) { return m.trim(); } ).filter( Boolean );
		if ( mots.length < 2 ) {
			return;
		}
		el.dataset.brPret = '1';
		el.textContent = '';
		var lu = document.createElement( 'span' );
		lu.className = 'screen-reader-text';
		lu.textContent = mots.slice( 0, -1 ).join( ', ' ) + ' ou ' + mots[ mots.length - 1 ];
		var zone = document.createElement( 'span' );
		zone.className = 'br-mots-zone';
		zone.setAttribute( 'aria-hidden', 'true' );
		var spans = mots.map( function ( m, i ) {
			var s = document.createElement( 'span' );
			s.textContent = m;
			if ( ! i ) {
				s.className = 'is-visible';
			}
			zone.appendChild( s );
			return s;
		} );
		el.appendChild( lu );
		el.appendChild( zone );
		if ( calme ) {
			return;
		}
		var i = 0;
		setInterval( function () {
			spans[ i ].classList.remove( 'is-visible' );
			i = ( i + 1 ) % spans.length;
			spans[ i ].classList.add( 'is-visible' );
		}, 2600 );
	}

	/* ----- Manifeste : les mots se colorent au fil de la lecture. */
	function manifeste( titre ) {
		if ( calme || titre.dataset.brPret ) {
			return;
		}
		titre.dataset.brPret = '1';
		var mots = [];
		Array.prototype.slice.call( titre.childNodes ).forEach( function ( n ) {
			if ( 3 !== n.nodeType ) {
				return;
			}
			var frag = document.createDocumentFragment();
			n.textContent.split( /(\s+)/ ).forEach( function ( t ) {
				if ( ! t.trim() ) {
					frag.appendChild( document.createTextNode( t ) );
					return;
				}
				var s = document.createElement( 'span' );
				s.className = 'br-mf';
				s.textContent = t;
				mots.push( s );
				frag.appendChild( s );
			} );
			n.parentNode.replaceChild( frag, n );
		} );
		function maj() {
			var r = titre.getBoundingClientRect();
			var vh = window.innerHeight;
			var p = Math.max( 0, Math.min( 1, ( vh * 0.8 - r.top ) / ( r.height + vh * 0.35 ) ) );
			var n = Math.round( p * mots.length );
			mots.forEach( function ( m, k ) {
				m.classList.toggle( 'is-lu', k < n );
			} );
		}
		window.addEventListener( 'scroll', maj, { passive: true } );
		window.addEventListener( 'resize', maj );
		maj();
	}

	function demarrer() {
		document.querySelectorAll( '.br-abonnement' ).forEach( abonnement );
		document.querySelectorAll( '.br-mots' ).forEach( motsQuiChangent );
		document.querySelectorAll( '.br-manifeste-texte' ).forEach( manifeste );
		document.querySelectorAll( '.br-partenaires--defile' ).forEach( logosDefilants );
		document.querySelectorAll( '.br-galeries--bande' ).forEach( function ( s ) {
			defilement( s, { liste: '.br-galeries-photos', precedent: 'Photo précédente', suivant: 'Photo suivante' } );
		} );
		document.querySelectorAll( '.br-projets--defile' ).forEach( function ( s ) {
			defilement( s, { liste: '.br-projects', precedent: 'Réalisation précédente', suivant: 'Réalisation suivante' } );
		} );
		document.querySelectorAll( '.br-equipe--defile' ).forEach( function ( s ) {
			defilement( s, { liste: '.br-team', precedent: 'Personne précédente', suivant: 'Personne suivante' } );
		} );
		// Questions ouvertes : toutes les réponses visibles (sans script, l'accordéon reste utilisable).
		document.querySelectorAll( '.br-questions--ouvertes details' ).forEach( function ( d ) {
			d.open = true;
			d.querySelector( 'summary' ).addEventListener( 'click', function ( e ) {
				e.preventDefault();
			} );
		} );
		document.querySelectorAll( '.br-services--onglets' ).forEach( onglets );
		document.querySelectorAll( '.br-services--defile' ).forEach( function ( s ) {
			defilement( s );
		} );
		document.querySelectorAll( '.br-temoignages--defile' ).forEach( function ( s ) {
			defilement( s, { liste: '.br-temoin-liste', precedent: 'Avis précédent', suivant: 'Avis suivant' } );
		} );
		document.querySelectorAll( '.br-ouverture--diaporama' ).forEach( diaporama );
		document.querySelectorAll( '.br-ouverture' ).forEach( video );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', demarrer );
	} else {
		demarrer();
	}
}() );
