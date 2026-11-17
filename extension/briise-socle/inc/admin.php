<?php
/**
 * Page « Mon entreprise » de l'administration.
 * Onglet « Horaires et annonces » : éditeurs et administrateurs.
 * Onglets « Entreprise », « Mentions légales », « Fonctions » : administrateurs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_onglets() {
	$onglets = array(
		'annonces' => array( 'Horaires et annonces', 'edit_others_pages', 'briise_annonces' ),
		'identite' => array( 'Entreprise', 'manage_options', 'briise_entreprise' ),
		'legal'    => array( 'Mentions légales', 'manage_options', 'briise_legal' ),
		'fonctions' => array( 'Fonctions', 'manage_options', 'briise_fonctions' ),
		'controle'  => array( 'Contrôle', 'manage_options', '' ),
		'depart'    => array( 'Fin de collaboration', 'manage_options', '' ),
	);
	/**
	 * Un thème ou une extension peut ajouter un onglet :
	 * 'cle' => array( libellé, capacité, option enregistrée ou '', fonction d'affichage facultative ).
	 * Le thème Briise y ajoute « Démarrage » (kits et import d'un fichier de site).
	 */
	$onglets = apply_filters( 'briise_onglets', $onglets );
	return array_filter( $onglets, function ( $o ) {
		return current_user_can( $o[1] );
	} );
}

add_action( 'admin_menu', function () {
	add_menu_page( 'Mon entreprise', 'Mon entreprise', 'edit_others_pages', 'briise-entreprise', 'briise_page_reglages', 'dashicons-store', 3 );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( 'toplevel_page_briise-entreprise' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_add_inline_script( 'media-editor', "
		document.addEventListener( 'click', function ( e ) {
			var choisir = e.target.closest( '.br-media-choisir' ), retirer = e.target.closest( '.br-media-retirer' );
			if ( ! choisir && ! retirer ) { return; }
			e.preventDefault();
			var bloc = ( choisir || retirer ).closest( '.br-media' );
			var champ = bloc.querySelector( 'input[type=hidden]' ), apercu = bloc.querySelector( '.br-media-apercu' );
			if ( retirer ) { champ.value = '0'; apercu.innerHTML = ''; bloc.classList.remove( 'br-media-rempli' ); return; }
			var cadre = wp.media( { title: 'Choisir le logo', button: { text: 'Utiliser ce logo' }, library: { type: 'image' }, multiple: false } );
			cadre.on( 'select', function () {
				var img = cadre.state().get( 'selection' ).first().toJSON();
				champ.value = img.id;
				apercu.innerHTML = '<img src=\"' + ( img.sizes && img.sizes.medium ? img.sizes.medium.url : img.url ) + '\" alt=\"\">';
				bloc.classList.add( 'br-media-rempli' );
			} );
			cadre.open();
		} );
	" );
	wp_add_inline_style( 'common', '
		.br-admin .form-table th { width: 220px; }
		.br-admin .description { max-width: 46em; }
		.br-admin h2.title { margin-top: 2.2em; padding-top: 1.2em; border-top: 1px solid #dcdcde; }
		.br-admin h2.title:first-of-type { border-top: 0; padding-top: 0; margin-top: 1em; }
.br-media-apercu img { max-height: 70px; max-width: 260px; display: block; margin: 0 0 8px; padding: 8px; background: #fff; border: 1px solid #dcdcde; }
		.br-media-apercu.br-fonce img { background: #1d2327; }
		.br-media .br-media-retirer { display: none; margin-left: 6px; }
		.br-media.br-media-rempli .br-media-retirer { display: inline-block; }
				.br-jours td, .br-jours th { padding: 6px 10px 6px 0; vertical-align: middle; }
		.br-jours input[type=time] { width: 9em; }
		.br-jours th { text-align: left; white-space: nowrap; }
		.br-jours .br-ferme-txt { color: #646970; }
		.br-a-faire { background: #fff; border-left: 4px solid #dba617; padding: 10px 14px; margin: 16px 0; max-width: 46em; }
		.br-a-faire.br-ok { border-left-color: #00a32a; }
		.br-a-faire ul { margin: 6px 0 0 18px; list-style: disc; }
		.br-fonction { margin: 0 0 14px; }
		.br-fonction .description { margin: 2px 0 0 24px; }
		.br-kits { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; max-width: 980px; margin: 16px 0; }
		.br-kit { text-decoration: none; color: inherit; display: flex; flex-direction: column; gap: 6px; background: #fff; border: 1px solid #c3c4c7; border-radius: 6px; padding: 16px; cursor: pointer; }
		.br-kit:hover, .br-kit:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; color: inherit; }
		.br-admin h3 { margin-top: 2em; }
		.br-kit strong { font-size: 15px; }
		.br-kit-pages { color: #1d2327; }
		.br-kit-cta { color: #50575e; font-style: italic; }
	' );
} );

/* ----- Petits assistants d'affichage ----------------------------------------- */

function briise_nom( $option, $cle ) {
	return esc_attr( $option . '[' . implode( '][', (array) $cle ) . ']' );
}

function briise_ligne( $label, $champ, $aide = '', $pour = '' ) {
	printf(
		'<tr><th scope="row">%s</th><td>%s%s</td></tr>',
		$pour ? '<label for="' . esc_attr( $pour ) . '">' . esc_html( $label ) . '</label>' : esc_html( $label ),
		$champ, // Déjà échappé par l'appelant.
		$aide ? '<p class="description">' . wp_kses_post( $aide ) . '</p>' : ''
	);
}

function briise_texte( $option, $valeurs, $cle, $label, $aide = '', $attrs = '' ) {
	$id = 'br-' . $option . '-' . $cle;
	briise_ligne(
		$label,
		sprintf( '<input type="text" class="regular-text" id="%s" name="%s" value="%s" %s>', esc_attr( $id ), briise_nom( $option, $cle ), esc_attr( $valeurs[ $cle ] ?? '' ), $attrs ),
		$aide,
		$id
	);
}

function briise_zone( $option, $valeurs, $cle, $label, $aide = '', $lignes = 3 ) {
	$id  = 'br-' . $option . '-' . $cle;
	$val = $valeurs[ $cle ] ?? '';
	if ( is_array( $val ) ) {
		$val = implode( "\n", $val );
	}
	briise_ligne(
		$label,
		sprintf( '<textarea class="large-text" rows="%d" id="%s" name="%s">%s</textarea>', (int) $lignes, esc_attr( $id ), briise_nom( $option, $cle ), esc_textarea( $val ) ),
		$aide,
		$id
	);
}

function briise_pages( $option, $valeurs, $cle, $label, $aide = '', $vide = '— Aucune —' ) {
	$id = 'br-' . $option . '-' . $cle;
	briise_ligne(
		$label,
		wp_dropdown_pages( array(
			'name'              => $option . '[' . $cle . ']',
			'id'                => $id,
			'selected'          => (int) ( $valeurs[ $cle ] ?? 0 ),
			'show_option_none'  => $vide,
			'option_none_value' => '0',
			'echo'              => 0,
		) ),
		$aide,
		$id
	);
}

/* ----- Page ------------------------------------------------------------------- */

function briise_page_reglages() {
	$onglets = briise_onglets();
	if ( ! $onglets ) {
		wp_die( 'Accès refusé.' );
	}
	$actif = isset( $_GET['onglet'] ) ? sanitize_key( $_GET['onglet'] ) : 'annonces'; // phpcs:ignore WordPress.Security.NonceVerification
	if ( ! isset( $onglets[ $actif ] ) ) {
		$actif = array_key_first( $onglets );
	}
	$option = $onglets[ $actif ][2];
	?>
	<div class="wrap br-admin">
		<h1>Mon entreprise</h1>
		<?php settings_errors(); ?>
		<?php if ( count( $onglets ) > 1 ) : ?>
			<nav class="nav-tab-wrapper" aria-label="Rubriques">
				<?php foreach ( $onglets as $cle => $o ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=briise-entreprise&onglet=' . $cle ) ); ?>" class="nav-tab<?php echo $cle === $actif ? ' nav-tab-active' : ''; ?>"<?php echo $cle === $actif ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $o[0] ); ?></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
		<?php $rappel = $onglets[ $actif ][3] ?? 'briise_onglet_' . $actif; ?>
		<?php if ( '' === $option ) : ?>
			<?php call_user_func( $rappel ); ?>
		<?php else : ?>
		<form method="post" action="options.php">
			<?php
			settings_fields( $option );
			call_user_func( $rappel, $option, briise_reglage( $option ) );
			submit_button( 'Enregistrer' );
			?>
		</form>
		<?php endif; ?>
		<?php do_action( 'briise_onglet_apres', $actif ); // Réglages qui ont leurs propres boutons (formulaires…). ?>
	</div>
	<?php
}

/* ----- Onglet Horaires et annonces ------------------------------------------------ */

function briise_onglet_annonces( $o, $v ) {
	?>
	<h2 class="title">Horaires d’ouverture</h2>
	<p class="description">Affichés dans le pied de page et transmis à Google. Pour une journée continue, ne remplissez que la première plage.</p>
	<table class="br-jours" role="presentation">
		<?php foreach ( BRIISE_JOURS as $n => $nom ) : $j = $v['jours'][ $n ]; ?>
			<tr>
				<th scope="row"><label><input type="checkbox" name="<?php echo briise_nom( $o, array( 'jours', $n, 'ouvert' ) ); ?>" value="1" <?php checked( $j['ouvert'] ); ?>> <?php echo esc_html( ucfirst( $nom ) ); ?></label></th>
				<?php for ( $i = 0; $i < 2; $i++ ) : ?>
					<td>
						<input type="time" aria-label="<?php echo esc_attr( ucfirst( $nom ) . ', plage ' . ( $i + 1 ) . ', ouverture' ); ?>" name="<?php echo briise_nom( $o, array( 'jours', $n, 'plages', $i, 0 ) ); ?>" value="<?php echo esc_attr( $j['plages'][ $i ][0] ); ?>">
						à
						<input type="time" aria-label="<?php echo esc_attr( ucfirst( $nom ) . ', plage ' . ( $i + 1 ) . ', fermeture' ); ?>" name="<?php echo briise_nom( $o, array( 'jours', $n, 'plages', $i, 1 ) ); ?>" value="<?php echo esc_attr( $j['plages'][ $i ][1] ); ?>">
					</td>
				<?php endfor; ?>
			</tr>
		<?php endforeach; ?>
	</table>
	<p class="description">Case décochée : jour fermé. Rien de coché du tout : les horaires ne s’affichent pas sur le site.</p>
	<table class="form-table" role="presentation">
		<?php briise_texte( $o, $v, 'note', 'Précision', 'Facultatif. Ex. : « Sur rendez-vous uniquement », « Fermé les jours fériés ».' ); ?>
	</table>

	<h2 class="title">Fermetures exceptionnelles</h2>
	<p class="description">Congés, jours fériés travaillés ou non, travaux. Elles s’affichent sous les horaires jusqu’à leur dernier jour, puis disparaissent toutes seules.</p>
	<table class="br-jours" role="presentation">
		<?php foreach ( $v['fermetures'] as $i => $f ) : ?>
			<tr>
				<td>Du <input type="date" aria-label="Fermeture <?php echo (int) $i + 1; ?>, premier jour" name="<?php echo briise_nom( $o, array( 'fermetures', $i, 'du' ) ); ?>" value="<?php echo esc_attr( $f['du'] ); ?>"></td>
				<td>au <input type="date" aria-label="Fermeture <?php echo (int) $i + 1; ?>, dernier jour" name="<?php echo briise_nom( $o, array( 'fermetures', $i, 'au' ) ); ?>" value="<?php echo esc_attr( $f['au'] ); ?>"></td>
				<td><input type="text" class="regular-text" placeholder="Motif (facultatif) : congés d’été" aria-label="Fermeture <?php echo (int) $i + 1; ?>, motif" name="<?php echo briise_nom( $o, array( 'fermetures', $i, 'motif' ) ); ?>" value="<?php echo esc_attr( $f['motif'] ); ?>"></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php if ( briise_fonction( 'bandeau' ) ) : ?>
		<p><label><input type="checkbox" name="<?php echo briise_nom( $o, 'annoncer' ); ?>" value="1" <?php checked( $v['annoncer'] ); ?>> Annoncer aussi chaque fermeture dans le bandeau du site, 7 jours avant</label></p>
	<?php else : ?>
		<input type="hidden" name="<?php echo briise_nom( $o, 'annoncer' ); ?>" value="<?php echo $v['annoncer'] ? '1' : ''; ?>">
	<?php endif; ?>

	<?php if ( briise_fonction( 'bandeau' ) ) : ?>
		<h2 class="title">Bandeau d’information</h2>
		<p class="description">Un message court en haut de toutes les pages. Les visiteurs peuvent le fermer ; il revient si vous changez le texte.</p>
		<table class="form-table" role="presentation">
			<?php
			briise_ligne( 'Afficher', '<label><input type="checkbox" name="' . briise_nom( $o, 'bandeau_actif' ) . '" value="1" ' . checked( $v['bandeau_actif'], true, false ) . '> Le bandeau est visible sur le site</label>' );
			briise_texte( $o, $v, 'bandeau_texte', 'Message', '160 caractères au plus. Ex. : « Nouveau : cours du samedi matin dès janvier ».', 'maxlength="160"' );
			briise_texte( $o, $v, 'bandeau_lien', 'Texte du lien', 'Facultatif. Ex. : « Voir le planning ».' );
			briise_texte( $o, $v, 'bandeau_url', 'Adresse du lien', 'Facultatif. Copiez l’adresse de la page visée.' );
			briise_ligne( 'Dernier jour d’affichage', '<input type="date" id="br-bandeau-fin" name="' . briise_nom( $o, 'bandeau_fin' ) . '" value="' . esc_attr( $v['bandeau_fin'] ) . '">', 'Facultatif. Le bandeau disparaît tout seul le lendemain.', 'br-bandeau-fin' );
			?>
		</table>
	<?php endif; ?>
	<?php
}

/* ----- Onglet Entreprise -------------------------------------------------------- */

/**
 * Choix d'une image de la médiathèque (logo).
 */
function briise_media( $option, $cle, $id, $label, $aide = '', $fonce = false ) {
	$img  = $id ? wp_get_attachment_image_url( $id, 'medium' ) : '';
	$html = '<div class="br-media' . ( $img ? ' br-media-rempli' : '' ) . '">'
		. '<div class="br-media-apercu' . ( $fonce ? ' br-fonce' : '' ) . '">' . ( $img ? '<img src="' . esc_url( $img ) . '" alt="">' : '' ) . '</div>'
		. '<input type="hidden" name="' . briise_nom( $option, $cle ) . '" value="' . (int) $id . '">'
		. '<button type="button" class="button br-media-choisir">Choisir une image</button>'
		. '<button type="button" class="button-link br-media-retirer">Retirer</button></div>';
	briise_ligne( $label, $html, $aide );
}

function briise_onglet_identite( $o, $v ) {
	$manque = array();
	if ( ! $v['telephone'] && ! $v['email'] ) {
		$manque[] = 'un moyen de contact (téléphone ou e-mail)';
	}
	if ( ! $v['street'] || ! $v['city'] ) {
		$manque[] = 'l’adresse complète (ou la ville seule pour une activité à domicile)';
	}
	if ( 'LocalBusiness' === $v['type'] ) {
		$manque[] = 'un type d’activité plus précis que « générique », s’il existe';
	}
	if ( ! $v['description'] ) {
		$manque[] = 'la description de l’activité';
	}
	if ( '' === $v['latitude'] && $v['street'] ) {
		$manque[] = 'les coordonnées GPS (itinéraire plus précis)';
	}
	if ( ! $v['google'] ) {
		$manque[] = 'le lien de la fiche Google';
	}
	if ( ! briise_horaires_renseignes() ) {
		$manque[] = 'les horaires (onglet « Horaires et annonces »)';
	}
	?>
	<div class="br-a-faire<?php echo $manque ? '' : ' br-ok'; ?>">
		<strong>À recopier à l’identique de la fiche Google Business Profile</strong> (nom, adresse, téléphone, horaires) : la moindre différence affaiblit le référencement local.
		<?php if ( $manque ) : ?>
			<ul><?php foreach ( $manque as $m ) { echo '<li>Manque : ' . esc_html( $m ) . '</li>'; } ?></ul>
		<?php else : ?>
			<p style="margin:6px 0 0">Tout l’essentiel est renseigné.</p>
		<?php endif; ?>
	</div>

	<h2 class="title">Identité</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, array( 'name' => get_bloginfo( 'name' ) ), 'name', 'Nom commercial', 'Le nom affiché partout, identique à la fiche Google. C’est aussi le titre du site dans WordPress.' );
		briise_texte( $o, array( 'slogan' => get_bloginfo( 'description' ) ), 'slogan', 'Slogan', 'Une phrase courte sous le nom, dans le pied de page.' );
		briise_media( $o, 'logo', (int) get_theme_mod( 'custom_logo' ), 'Logo', 'Affiché dans l’en-tête à la place du nom (le nom reste lu par Google et les lecteurs d’écran). Format conseillé : PNG transparent ou SVG converti en PNG, au moins 400 px de large. Sans logo, le nom s’affiche en texte.' );
		briise_media( $o, 'logo_clair', (int) $v['logo_clair'], 'Logo pour fond foncé', 'Facultatif : version claire du logo pour le pied de page, qui est sombre. Sans elle, le pied de page affiche le nom en texte.', true );
		?>
	</table>

	<h2 class="title">Activité</h2>
	<table class="form-table" role="presentation">
		<?php
		$select = '<select id="br-type" name="' . briise_nom( $o, 'type' ) . '">';
		foreach ( briise_types_activite() as $cle => $label ) {
			$select .= '<option value="' . esc_attr( $cle ) . '"' . selected( $v['type'], $cle, false ) . '>' . esc_html( $label ) . '</option>';
		}
		$select .= '</select>';
		briise_ligne( 'Type d’activité', $select, 'Indique à Google la nature exacte de l’entreprise. Choisir le plus précis.', 'br-type' );
		briise_zone( $o, $v, 'description', 'Description courte', 'Deux phrases : ce que fait l’entreprise, pour qui, où. Reprise par Google et les assistants IA.' );
		briise_texte( $o, $v, 'price_range', 'Gamme de prix', 'Facultatif. Ex. : « 25 € – 60 € » ou « €€ ».' );
		briise_zone( $o, $v, 'areas', 'Zone d’intervention', 'Une ville ou un secteur par ligne. Utile surtout pour les services à domicile.', 4 );
		?>
	</table>

	<h2 class="title">Coordonnées</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'street', 'Adresse', 'Numéro et rue. Laisser vide si l’activité n’accueille pas de public.' );
		briise_texte( $o, $v, 'postal_code', 'Code postal', '', 'inputmode="numeric" style="width:8em"' );
		briise_texte( $o, $v, 'city', 'Ville' );
		briise_texte( $o, array( 'telephone' => briise_telephone_lisible( $v['telephone'] ) ), 'telephone', 'Téléphone', 'Format libre : 06 12 34 56 78.', 'inputmode="tel"' );
		briise_texte( $o, $v, 'email', 'E-mail de contact', 'Affiché sur le site, protégé contre les robots collecteurs.', 'inputmode="email"' );
		briise_zone( $o, $v, 'destinataires', 'Autres adresses qui reçoivent les demandes', 'Une adresse par ligne. Elles reçoivent aussi les demandes des formulaires de devis et de contact, en plus de l’e-mail de contact. Non affichées sur le site.', 2 );
		$gps_aide = 'Facultatif. Sur Google Maps, clic droit sur l’emplacement exact, puis clic sur les chiffres pour les copier.';
		if ( $v['street'] ) {
			$gps_aide .= ' <a href="' . esc_url( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( briise_adresse_ligne() ) ) . '" target="_blank" rel="noopener">Ouvrir l’adresse dans Google Maps</a>';
		}
		briise_ligne(
			'Coordonnées GPS',
			'<input type="text" aria-label="Latitude" placeholder="Latitude : 48.4045" style="width:12em" name="' . briise_nom( $o, 'latitude' ) . '" value="' . esc_attr( $v['latitude'] ) . '"> <input type="text" aria-label="Longitude" placeholder="Longitude : 2.4661" style="width:12em" name="' . briise_nom( $o, 'longitude' ) . '" value="' . esc_attr( $v['longitude'] ) . '">',
			$gps_aide
		);
		?>
	</table>

	<h2 class="title">Action principale</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'cta_label', 'Libellé du bouton', 'Le bouton de l’en-tête, du pied de page et du bouton fixe mobile. Ex. : « Prendre rendez-vous », « Demander un devis ».' );
		briise_pages( $o, $v, 'cta_page', 'Page visée', 'Par défaut : la page « contact » si elle existe.', '— Page « contact » —' );
		briise_texte( $o, $v, 'cta_url', 'Ou adresse externe', 'Facultatif, remplace la page : lien de réservation en ligne (Doctolib, Calendly, Planity…).' );
		?>
	</table>

	<h2 class="title">Personne mise en avant</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'person_name', 'Nom et prénom', 'Le dirigeant ou le praticien, si l’activité repose sur une personne. Sinon, laisser vide.' );
		briise_texte( $o, $v, 'person_job', 'Métier ou titre' );
		briise_pages( $o, $v, 'person_page', 'Page de présentation', 'La page « À propos » qui lui est consacrée.' );
		?>
	</table>

	<h2 class="title">Réseaux et fiche Google</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'google', 'Fiche Google', 'Lien « Partager » de la fiche Google Business Profile.' );
		briise_texte( $o, $v, 'instagram', 'Instagram' );
		briise_texte( $o, $v, 'facebook', 'Facebook' );
		briise_texte( $o, $v, 'linkedin', 'LinkedIn' );
		briise_texte( $o, $v, 'tiktok', 'TikTok' );
		briise_texte( $o, $v, 'youtube', 'YouTube' );
		briise_texte( $o, $v, 'pinterest', 'Pinterest' );
		briise_zone( $o, $v, 'autres', 'Autres profils', 'Une adresse par ligne (Pages Jaunes, annuaire professionnel…). Non affichés, seulement transmis à Google.', 2 );
		?>
	</table>

	<h2 class="title">Pages particulières</h2>
	<table class="form-table" role="presentation">
		<?php briise_pages( $o, $v, 'faq_page', 'Page de questions', 'Ses questions en accordéon sont transmises à Google. Par défaut : la page « faq ».', '— Page « faq » —' ); ?>
	</table>
	<?php
	?>
	<h2 class="title">Cartes Coordonnées et Zone d’intervention</h2>
	<p class="description">Facultatif. Ces précisions s’affichent dans les sections « Coordonnées (carte) » et « Zone d’intervention (carte) ». Le téléphone, l’e-mail, l’adresse et les horaires viennent des champs ci-dessus : rien n’est à taper deux fois.</p>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'precision_telephone', 'Précision sous le téléphone', 'Exemple : « Le dirigeant décroche lui-même ». Vide : « Appel direct aux heures d’ouverture ».' );
		briise_texte( $o, $v, 'precision_email', 'Précision sous l’e-mail', 'Exemple : « Réponse sous 24 h ouvrées ». Uniquement si c’est tenu.' );
		briise_texte( $o, $v, 'precision_adresse', 'Précision sous l’adresse', 'Exemple : « À 15 min de Nice » ou « Atelier sur rendez-vous ».' );
		briise_texte( $o, $v, 'badge_coord_titre', 'Badge de la carte Coordonnées', 'Un argument fort, court. Exemple : « Urgences industrielles ». Vide : pas de badge.' );
		briise_texte( $o, $v, 'badge_coord_texte', 'Sous le badge', 'Exemple : « Intervention rapide possible ».' );
		briise_texte( $o, $v, 'badge_zone_titre', 'Badge de la carte Zone', 'Exemple : « Intervention mobile ». Vide : pas de badge.' );
		briise_texte( $o, $v, 'badge_zone_texte', 'Sous le badge', 'Exemple : « Sur site ou en atelier ».' );
		briise_texte( $o, $v, 'zone_soustitre', 'Sous-titre de la carte Zone', 'Vide : « Depuis notre atelier de [ville] ».' );
		briise_zone( $o, $v, 'zone_secteurs', 'Secteurs de la zone', 'Une ligne par commune, regroupées par secteur. « # Secteur | précision » ouvre un secteur (3 au plus conseillés) ; « Commune | précision » ajoute une commune ; « + texte » ajoute une étiquette en bas du secteur. Exemple :<br><code># Alpes-Maritimes | Autour de l’atelier</code><br><code>Carros | siège</code><br><code>Nice | et Côte d’Azur</code><br><code>+ Alpes-de-Haute-Provence</code><br>Vide : la carte reprend la liste « Zone d’intervention » ci-dessus.', 9 );
		?>
	</table>
	<?php
}

/* ----- Onglet Mentions légales ---------------------------------------------------- */

function briise_onglet_legal( $o, $v ) {
	?>
	<p class="description" style="margin-top:1em">Ces informations alimentent la page Mentions légales, via le code court <code>[briise_mentions_legales]</code>. Un champ obligatoire vide y apparaît en « [à compléter] ».</p>

	<h2 class="title">Éditeur du site</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'raison_sociale', 'Raison sociale', 'Ou nom et prénom pour un entrepreneur individuel.' );
		briise_texte( $o, $v, 'forme', 'Forme juridique', 'Ex. : SAS, SARL, EURL, Entrepreneur individuel.' );
		briise_texte( $o, $v, 'capital', 'Capital social', 'Facultatif pour un entrepreneur individuel. Ex. : « 5 000 € ».' );
		briise_texte( $o, $v, 'siren', 'SIREN ou SIRET' );
		briise_texte( $o, $v, 'rcs', 'Immatriculation', 'Ex. : « RCS Évry 123 456 789 » ou « RM 123 456 789 ».' );
		briise_texte( $o, $v, 'tva', 'TVA intracommunautaire', 'Facultatif.' );
		briise_zone( $o, $v, 'siege', 'Siège social', 'Si différent de l’adresse de l’onglet « Entreprise ».', 2 );
		briise_texte( $o, $v, 'directeur', 'Directeur de la publication', 'En général le dirigeant.' );
		?>
	</table>

	<h2 class="title">Hébergeur</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'hebergeur_nom', 'Nom', 'Ex. : o2switch, OVH, Hostinger.' );
		briise_zone( $o, $v, 'hebergeur_adresse', 'Adresse', '', 2 );
		briise_texte( $o, $v, 'hebergeur_tel', 'Téléphone', 'Facultatif.' );
		?>
	</table>

	<h2 class="title">Profession réglementée</h2>
	<p class="description">Avocats, professions de santé, experts-comptables, architectes… Sinon, laisser vide.</p>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'titre_pro', 'Titre professionnel', 'Et le pays où il a été obtenu. Ex. : « Masseur-kinésithérapeute (France) ».' );
		briise_texte( $o, $v, 'ordre', 'Ordre ou organisme', 'Ex. : « Ordre des masseurs-kinésithérapeutes de l’Essonne ».' );
		briise_texte( $o, $v, 'regles_url', 'Règles professionnelles', 'Lien vers le code de déontologie.' );
		?>
	</table>

	<h2 class="title">Médiateur de la consommation</h2>
	<p class="description">Obligatoire dès que l’entreprise vend à des particuliers.</p>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'mediateur_nom', 'Nom du médiateur' );
		briise_texte( $o, $v, 'mediateur_url', 'Site du médiateur' );
		?>
	</table>

	<h2 class="title">Réalisation du site</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'realisation', 'Agence' );
		briise_texte( $o, $v, 'realisation_url', 'Site de l’agence', 'Facultatif.' );
		?>
	</table>
	<?php
}

/* ----- Onglet Fonctions ------------------------------------------------------------ */

function briise_onglet_fonctions( $o, $v ) {
	?>
	<h2 class="title">Fonctions du thème</h2>
	<p class="description">Une fonction désactivée ne charge aucun fichier.</p>
	<?php foreach ( briise_fonctions_liste() as $cle => $f ) : ?>
		<div class="br-fonction">
			<label><input type="checkbox" name="<?php echo briise_nom( $o, $cle ); ?>" value="1" <?php checked( $v[ $cle ] ); ?>> <strong><?php echo esc_html( $f[0] ); ?></strong></label>
			<p class="description"><?php echo esc_html( $f[1] ); ?></p>
		</div>
	<?php endforeach; ?>
	<table class="form-table" role="presentation">
		<?php
		$champ = '<select id="br-realisations-nom" name="' . briise_nom( $o, 'realisations_nom' ) . '">';
		foreach ( briise_realisations_noms() as $nom ) {
			$champ .= '<option value="' . esc_attr( $nom ) . '"' . selected( $v['realisations_nom'], $nom, false ) . '>' . esc_html( $nom ) . '</option>';
		}
		$champ .= '</select>';
		briise_ligne( 'Nom des réalisations', $champ, 'Menu de l’administration et adresse des fiches (ex. : /portfolio/mariage-a-fontainebleau/). « Portfolio » convient aux photographes et créatifs, « Chantiers » aux artisans du bâtiment.', 'br-realisations-nom' );
		briise_ligne( 'Texte du crédit', '<input type="text" class="regular-text" id="br-credit-texte" name="' . briise_nom( $o, 'credit_texte' ) . '" value="' . esc_attr( $v['credit_texte'] ?? 'Site réalisé par' ) . '">', 'Suivi du lien « Briise ». Exemples : « Site réalisé par », « Site créé par ». Le lien porte toujours le nom de l’agence, jamais des mots-clés.', 'br-credit-texte' );
		?>
	</table>
	<?php if ( function_exists( 'briise_seo_plugin_active' ) && briise_seo_plugin_active() ) : ?>
		<div class="br-a-faire">Une extension de référencement est active : le référencement intégré du thème est coupé, quel que soit ce réglage.</div>
	<?php endif; ?>

	<h2 class="title">Mesure d’audience et Search Console</h2>
	<table class="form-table" role="presentation">
		<?php
		briise_texte( $o, $v, 'bing', 'Bing Webmaster Tools', 'Collez la balise de validation Bing (msvalidate.01), ou importez le site depuis la Search Console. Bing alimente une partie des réponses de ChatGPT et de Copilot.' );
		briise_texte( $o, $v, 'gsc', 'Search Console', 'Collez la balise HTML de validation fournie par Google (ou seulement son code). Inutile si le domaine est validé par DNS.' );
		briise_texte( $o, $v, 'matomo_url', 'Adresse de Matomo', 'Ex. : https://stats.exemple.fr/. Matomo est chargé sans cookie : réglez aussi l’instance en mode « exemption » de la CNIL.' );
		briise_texte( $o, $v, 'matomo_id', 'Identifiant du site dans Matomo', '', 'inputmode="numeric" style="width:6em"' );
		?>
	</table>
	<p class="description">Google Analytics n’est volontairement pas proposé ici : il exige un bandeau de consentement, à installer avec une extension dédiée (Complianz).</p>
	<?php
}
