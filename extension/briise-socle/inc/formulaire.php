<?php
/**
 * Formulaires de devis et de contact, fabriqués avec Fluent Forms (extension gratuite).
 *
 * Mon entreprise > Fonctions > « Formulaires » crée chaque formulaire en un clic, déjà réglé :
 * champs utiles seulement, messages en français, e-mail à l'entreprise (bouton « Répondre » vers
 * le visiteur), e-mail de confirmation au visiteur, champ piège contre les robots.
 * Les pages appellent [briise_formulaire type="devis"] : sans Fluent Forms, le visiteur voit
 * le téléphone et l'e-mail à la place, jamais une page cassée.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function briise_formulaires_types() {
	return array(
		'devis'       => 'Demande de devis',
		'contact'     => 'Contact',
		'reservation' => 'Réservation',
	);
}

function briise_fluentforms_actif() {
	return class_exists( '\FluentForm\App\Services\Form\FormService' );
}

/**
 * Numéro du formulaire Fluent Forms d'un type, s'il existe encore.
 */
function briise_formulaire_id( $type = 'devis' ) {
	$id = (int) get_option( 'briise_formulaire_' . sanitize_key( $type ) );
	if ( ! $id || ! briise_fluentforms_actif() ) {
		return 0;
	}
	global $wpdb;
	$existe = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}fluentform_forms WHERE id = %d", $id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	return $existe ? $id : 0;
}

/**
 * Services proposés dans la liste « Votre projet » : sous-pages de la page qui en a le plus
 * (la page des services), hors pages légales.
 */
function briise_formulaire_services() {
	$parents = array();
	foreach ( get_pages( array( 'post_status' => 'publish' ) ) as $p ) {
		if ( $p->post_parent && ! ( function_exists( 'briise_est_page_legale' ) && briise_est_page_legale( $p ) ) ) {
			$parents[ $p->post_parent ][] = $p;
		}
	}
	if ( ! $parents ) {
		return array();
	}
	uasort( $parents, function ( $a, $b ) {
		return count( $b ) <=> count( $a );
	} );
	$liste = reset( $parents );
	usort( $liste, function ( $a, $b ) {
		return array( $a->menu_order, $a->post_title ) <=> array( $b->menu_order, $b->post_title );
	} );
	return count( $liste ) >= 2 ? wp_list_pluck( $liste, 'post_title' ) : array();
}

/**
 * Lieux proposés dans le formulaire de réservation (« Au studio », « Chez vous »…), un par ligne.
 * Facultatif : sans lieux, la question n'est pas posée.
 */
function briise_reservation_lieux() {
	$l = get_option( 'briise_reservation_lieux', array() );
	return array_values( array_filter( array_map( 'sanitize_text_field', (array) $l ) ) );
}

/**
 * Libellés d'un type de formulaire : objet de l'e-mail, bouton, message de confirmation.
 */
function briise_formulaire_mots( $type ) {
	$mots = array(
		'devis'       => array( 'demande de devis', 'Envoyer ma demande', 'Votre demande de devis', 'Demande de devis', 'demande', 'e' ),
		'contact'     => array( 'message', 'Envoyer mon message', 'Votre message', 'Message', 'message', '' ),
		'reservation' => array( 'demande de réservation', 'Envoyer ma demande', 'Votre demande de réservation', 'Réservation', 'demande', 'e' ),
	);
	$m = $mots[ $type ] ?? $mots['contact'];
	return array_combine( array( 'quoi', 'bouton', 'objet_visiteur', 'objet', 'court', 'accord' ), $m );
}

/**
 * Définition d'un formulaire au format des modèles Fluent Forms.
 */
function briise_formulaire_definition( $type ) {
	$e        = function_exists( 'briise_entreprise' ) ? briise_entreprise() : array( 'email' => '', 'telephone' => '' );
	$requis   = function ( $oui, $message = 'Ce champ est obligatoire.' ) {
		return array( 'required' => array( 'value' => $oui, 'message' => $message, 'global' => false ) );
	};
	$sans_cond = array( 'type' => 'any', 'status' => false, 'conditions' => array( array( 'field' => '', 'value' => '', 'operator' => '' ) ) );
	$texte    = function ( $nom, $label, $oui, $extra = array(), $aide = '' ) use ( $requis, $sans_cond ) {
		return array(
			'element'        => 'input_text',
			'attributes'     => array_merge( array( 'type' => 'text', 'name' => $nom, 'value' => '', 'class' => '', 'placeholder' => '' ), $extra ),
			'settings'       => array( 'container_class' => '', 'label' => $label, 'label_placement' => '', 'admin_field_label' => $label, 'help_message' => $aide, 'validation_rules' => $requis( $oui ), 'conditional_logics' => $sans_cond ),
			'editor_options' => array( 'title' => 'Simple Text', 'icon_class' => 'ff-edit-text', 'template' => 'inputText' ),
			'uniqElKey'      => 'el_briise_' . $nom,
		);
	};
	$radios = function ( $nom, $label, $options, $aide = '' ) use ( $requis, $sans_cond ) {
		return array(
			'element'        => 'input_radio',
			'attributes'     => array( 'type' => 'radio', 'name' => $nom, 'value' => '' ),
			'settings'       => array( 'container_class' => '', 'label' => $label, 'admin_field_label' => $label, 'label_placement' => '', 'display_type' => '', 'help_message' => $aide, 'validation_rules' => $requis( true, 'Choisissez une réponse.' ), 'conditional_logics' => $sans_cond ),
			'options'        => array_combine( $options, $options ),
			'editor_options' => array( 'title' => 'Radio Button', 'icon_class' => 'icon-dot-circle-o', 'element' => 'input-radio', 'template' => 'inputRadio' ),
			'uniqElKey'      => 'el_briise_' . $nom,
		);
	};
	$champs = array();
	if ( 'reservation' === $type ) {
		// D'abord ce que le visiteur veut, puis où et quand : les coordonnées viennent en dernier.
		$services = briise_formulaire_services();
		$champs[] = $services ? $radios( 'prestation', 'Quelle prestation ?', array_merge( $services, array( 'Je ne sais pas encore' ) ) ) : $texte( 'prestation', 'Quelle prestation ?', true );
		$lieux    = briise_reservation_lieux();
		if ( $lieux ) {
			$champs[] = $radios( 'lieu', 'Où ?', $lieux );
		}
		$champs[] = array(
			'element'        => 'input_date',
			'attributes'     => array( 'type' => 'text', 'name' => 'date', 'value' => '', 'id' => '', 'class' => '', 'placeholder' => 'jj/mm/aaaa' ),
			'settings'       => array( 'container_class' => '', 'label' => 'Date souhaitée', 'admin_field_label' => 'Date souhaitée', 'label_placement' => '', 'date_format' => 'd/m/Y', 'help_message' => 'Une date approximative suffit : nous vous proposons les créneaux libres autour.', 'is_time_enabled' => false, 'validation_rules' => $requis( false ), 'conditional_logics' => $sans_cond ),
			'editor_options' => array( 'title' => 'Time & Date', 'icon_class' => 'icon-calendar-o', 'template' => 'inputText' ),
			'uniqElKey'      => 'el_briise_date',
		);
	}
	$champs[] = $texte( 'nom', 'Nom', true, array( 'autocomplete' => 'name' ) );
	$champs[] = $texte( 'telephone', 'Téléphone', true, array( 'type' => 'tel', 'autocomplete' => 'tel', 'inputmode' => 'tel' ) );
	$champs[] = array(
		'element'        => 'input_email',
		'attributes'     => array( 'type' => 'email', 'name' => 'email', 'value' => '', 'id' => '', 'class' => '', 'placeholder' => '', 'autocomplete' => 'email' ),
		'settings'       => array(
			'container_class'    => '',
			'label'              => 'E-mail',
			'label_placement'    => '',
			'help_message'       => 'Facultatif : pour recevoir une réponse écrite.',
			'admin_field_label'  => 'E-mail',
			'validation_rules'   => array(
				'required' => array( 'value' => false, 'message' => 'Ce champ est obligatoire.', 'global' => false ),
				'email'    => array( 'value' => true, 'message' => 'Cette adresse e-mail n’est pas valide.', 'global' => false ),
			),
			'conditional_logics' => $sans_cond,
		),
		'editor_options' => array( 'title' => 'Email Address', 'icon_class' => 'ff-edit-email', 'template' => 'inputText' ),
		'uniqElKey'      => 'el_briise_email',
	);
	if ( 'devis' === $type ) {
		$champs[] = $texte( 'commune', 'Commune', true, array( 'autocomplete' => 'address-level2' ) );
		$services = briise_formulaire_services();
		if ( $services ) {
			$options  = array_combine( $services, $services ) + array( 'Autre' => 'Autre' );
			$champs[] = array(
				'element'        => 'select',
				'attributes'     => array( 'name' => 'projet', 'value' => '', 'id' => '', 'class' => '' ),
				'settings'       => array( 'label' => 'Votre projet', 'admin_field_label' => 'Projet', 'help_message' => '', 'container_class' => '', 'label_placement' => '', 'placeholder' => '— Choisir —', 'validation_rules' => $requis( true ), 'conditional_logics' => $sans_cond ),
				'options'        => $options,
				'editor_options' => array( 'title' => 'Dropdown', 'icon_class' => 'icon-caret-square-o-down', 'element' => 'select', 'template' => 'select' ),
				'uniqElKey'      => 'el_briise_projet',
			);
		} else {
			$champs[] = $texte( 'projet', 'Votre projet', true );
		}
	}
	$labels   = array( 'devis' => 'Votre projet en quelques mots', 'reservation' => 'Un mot pour préparer (facultatif)' );
	$champs[] = array(
		'element'        => 'textarea',
		'attributes'     => array( 'name' => 'message', 'value' => '', 'id' => '', 'class' => '', 'placeholder' => 'devis' === $type ? 'Ex. : garde-corps de mezzanine, 6 m, acier noir, avant l’été' : '', 'rows' => 'reservation' === $type ? 3 : 5, 'cols' => 2 ),
		'settings'       => array( 'container_class' => '', 'label' => $labels[ $type ] ?? 'Votre message', 'admin_field_label' => 'Message', 'label_placement' => '', 'help_message' => '', 'validation_rules' => $requis( 'reservation' !== $type ), 'conditional_logics' => $sans_cond ),
		'editor_options' => array( 'title' => 'Text Area', 'icon_class' => 'ff-edit-textarea', 'template' => 'inputTextarea' ),
		'uniqElKey'      => 'el_briise_message',
	);
	$confidentialite = get_privacy_policy_url();
	if ( ! $confidentialite ) {
		$p               = get_page_by_path( 'confidentialite' );
		$confidentialite = $p ? get_permalink( $p ) : '';
	}
	$champs[] = array(
		'element'        => 'custom_html',
		'attributes'     => array(),
		'settings'       => array(
			'html_codes'         => '<p class="br-form-info">Vos coordonnées servent uniquement à répondre à votre demande.' . ( $confidentialite ? ' <a href="' . esc_url( $confidentialite ) . '">Politique de confidentialité</a>.' : '' ) . '</p>',
			'conditional_logics' => $sans_cond,
		),
		'editor_options' => array( 'title' => 'Custom HTML', 'icon_class' => 'icon-code', 'template' => 'customHTML' ),
		'uniqElKey'      => 'el_briise_info',
	);
	foreach ( $champs as $i => $c ) {
		$champs[ $i ]['index'] = $i + 1;
	}
	return array(
		'title'         => briise_formulaires_types()[ $type ],
		'form'          => array(
			'fields'       => $champs,
			'submitButton' => array(
				'uniqElKey'      => 'el_briise_envoyer',
				'element'        => 'button',
				'attributes'     => array( 'type' => 'submit', 'class' => 'wp-element-button' ),
				'settings'       => array(
					'align'            => 'left',
					'button_style'     => '',
					'container_class'  => '',
					'help_message'     => '',
					'background_color' => '',
					'button_size'      => 'md',
					'color'            => '',
					'button_ui'        => array( 'type' => 'default', 'text' => briise_formulaire_mots( $type )['bouton'], 'img_url' => '' ),
				),
				'editor_options' => array( 'title' => 'Submit Button' ),
			),
		),
		'notifications' => briise_formulaire_notification_entreprise( $type ),
	);
}

/**
 * E-mail à l'entreprise : « Répondre » écrit directement au visiteur.
 */
function briise_formulaire_notification_entreprise( $type ) {
	$e = function_exists( 'briise_entreprise' ) ? briise_entreprise() : array( 'email' => '' );
	return array(
		'name'           => 'Briise : demande reçue (entreprise)',
		'sendTo'         => array( 'type' => 'email', 'email' => $e['email'] ? $e['email'] : '{wp.admin_email}', 'field' => 'email', 'routing' => array() ),
		'fromName'       => get_bloginfo( 'name' ),
		'fromEmail'      => '',
		'replyTo'        => '{inputs.email}',
		'bcc'            => '',
		'subject'        => briise_formulaire_mots( $type )['objet'] . ' : {inputs.nom}' . ( 'devis' === $type ? ', {inputs.commune}' : '' ) . ( 'reservation' === $type ? ', {inputs.prestation}' : '' ),
		'message'        => '<p>' . ( 'contact' === $type ? 'Nouveau message' : 'Nouvelle ' . briise_formulaire_mots( $type )['quoi'] ) . ' depuis le site.</p><p>{all_data}</p><p>Envoyé depuis la page : {embed_post.permalink}</p><p>Pour répondre par e-mail, utilisez simplement « Répondre ». Pour rappeler : {inputs.telephone}.</p>',
		'conditionals'   => array( 'status' => false, 'type' => 'all', 'conditions' => array( array( 'field' => null, 'operator' => '=', 'value' => null ) ) ),
		'enabled'        => true,
		'email_template' => '',
	);
}

/**
 * E-mail de confirmation au visiteur (s'il a donné son adresse).
 */
function briise_formulaire_notification_visiteur( $type ) {
	$e   = function_exists( 'briise_entreprise' ) ? briise_entreprise() : array( 'email' => '', 'telephone' => '' );
	$tel = $e['telephone'] && function_exists( 'briise_telephone_lisible' ) ? briise_telephone_lisible( $e['telephone'] ) : '';
	return array(
		'name'           => 'Briise : confirmation au visiteur',
		'sendTo'         => array( 'type' => 'field', 'email' => '', 'field' => 'email', 'routing' => array() ),
		'fromName'       => get_bloginfo( 'name' ),
		'fromEmail'      => '',
		'replyTo'        => $e['email'],
		'bcc'            => '',
		'subject'        => briise_formulaire_mots( $type )['objet_visiteur'] . ' à ' . get_bloginfo( 'name' ),
		'message'        => '<p>Bonjour {inputs.nom},</p><p>Nous avons bien reçu votre ' . briise_formulaire_mots( $type )['quoi'] . ' et nous vous répondons rapidement' . ( 'reservation' === $type ? ' avec nos disponibilités. Rien n’est réservé ni payé tant que nous n’avons pas confirmé ensemble.' : '.' ) . '</p>'
			. ( 'devis' === $type ? '<p>Si vous avez des photos de votre projet ou de l’endroit, répondez simplement à cet e-mail en les joignant : elles nous aideront à préparer notre réponse.</p>' : '' )
			. '<p>Pour rappel, votre demande :</p><p>{all_data}</p><p>' . esc_html( get_bloginfo( 'name' ) ) . ( $tel ? ' · ' . esc_html( $tel ) : '' ) . '</p>',
		'conditionals'   => array( 'status' => false, 'type' => 'all', 'conditions' => array( array( 'field' => null, 'operator' => '=', 'value' => null ) ) ),
		'enabled'        => true,
		'email_template' => '',
	);
}

/**
 * Crée le formulaire d'un type (une seule fois). Retourne son numéro, ou une erreur.
 */
function briise_formulaire_creer( $type = 'devis' ) {
	if ( ! isset( briise_formulaires_types()[ $type ] ) ) {
		return new WP_Error( 'type', 'Type de formulaire inconnu.' );
	}
	if ( ! briise_fluentforms_actif() ) {
		return new WP_Error( 'fluentforms', 'Fluent Forms n’est pas actif.' );
	}
	$existant = briise_formulaire_id( $type );
	if ( $existant ) {
		return $existant;
	}
	$cle   = 'briise_' . $type;
	$def   = briise_formulaire_definition( $type );
	$modele = function ( $modeles ) use ( $cle, $def ) {
		$modeles[ $cle ] = array( 'title' => $def['title'], 'createable' => false, 'json' => wp_json_encode( array( $def ) ) );
		return $modeles;
	};
	add_filter( 'fluentform/predefined_forms', $modele );
	try {
		$form = ( new \FluentForm\App\Services\Form\FormService() )->store( array( 'predefined' => $cle, 'type' => 'form' ) );
	} catch ( \Exception $ex ) {
		remove_filter( 'fluentform/predefined_forms', $modele );
		return new WP_Error( 'creation', $ex->getMessage() );
	}
	remove_filter( 'fluentform/predefined_forms', $modele );

	$form->title = $def['title'];
	$form->save();

	// Réglages : message après l'envoi, libellés au-dessus des champs.
	$e        = function_exists( 'briise_entreprise' ) ? briise_entreprise() : array( 'telephone' => '' );
	$tel      = $e['telephone'] && function_exists( 'briise_telephone_lisible' ) ? briise_telephone_lisible( $e['telephone'] ) : '';
	$reglages = \FluentForm\App\Models\Form::getFormsDefaultSettings();
	$reglages['confirmation']['messageToShow']        = '<p><strong>Merci, votre ' . briise_formulaire_mots( $type )['court'] . ' est bien envoyé' . briise_formulaire_mots( $type )['accord'] . '.</strong> Nous vous répondons rapidement' . ( 'reservation' === $type ? ' avec nos disponibilités' : '' ) . ( $tel ? ' ; pour une urgence, appelez le ' . esc_html( $tel ) : '' ) . '.</p>';
	$reglages['confirmation']['samePageFormBehavior'] = 'hide_form';
	$reglages['layout']['labelPlacement']             = 'top';
	$reglages['layout']['asteriskPlacement']          = 'asterisk-right';
	$reglages['layout']['errorMessagePlacement']      = 'inline';
	$reglages['layout']['helpMessagePlacement']       = 'under_input';
	\FluentForm\App\Helpers\Helper::setFormMeta( $form->id, 'formSettings', $reglages );

	// Deuxième e-mail : la confirmation au visiteur.
	\FluentForm\App\Models\FormMeta::create( array(
		'form_id'  => $form->id,
		'meta_key' => 'notifications', // phpcs:ignore WordPress.DB.SlowDBQuery
		'value'    => wp_json_encode( briise_formulaire_notification_visiteur( $type ) ),
	) );

	update_option( 'briise_formulaire_' . $type, (int) $form->id );
	return (int) $form->id;
}

/* ----- Affichage -------------------------------------------------------------------- */

add_action( 'init', function () {
	add_shortcode( 'briise_formulaire', 'briise_formulaire_html' );
} );

function briise_formulaire_html( $atts = array() ) {
	$atts = shortcode_atts( array( 'type' => 'devis' ), $atts, 'briise_formulaire' );
	$id   = briise_formulaire_id( $atts['type'] );
	if ( $id ) {
		return '<div class="br-formulaire-ff">' . do_shortcode( '[fluentform id="' . $id . '"]' ) . '</div>';
	}
	// Pas de formulaire : le visiteur peut toujours appeler ou écrire.
	$rappel = current_user_can( 'manage_options' )
		? '<p class="br-a-remplacer">Formulaire à créer : Mon entreprise > Fonctions > Formulaires' . ( briise_fluentforms_actif() ? '' : ' (installez d’abord l’extension gratuite Fluent Forms)' ) . '.</p>'
		: '';
	return $rappel . ( function_exists( 'briise_contact_rapide_html' ) ? briise_contact_rapide_html() : '' );
}

/**
 * Autres destinataires (Mon entreprise > Entreprise) ajoutés à l'e-mail envoyé à l'entreprise,
 * pour tous les formulaires Briise, sans toucher aux réglages de Fluent Forms.
 */
add_filter( 'fluentform/email_to', function ( $adresses, $notification ) {
	if ( 0 !== strpos( (string) ( $notification['name'] ?? '' ), 'Briise : demande reçue' ) ) {
		return $adresses;
	}
	$autres = (array) ( briise_reglage( 'briise_entreprise' )['destinataires'] ?? array() );
	if ( ! $autres ) {
		return $adresses;
	}
	$liste = is_array( $adresses ) ? $adresses : array_map( 'trim', explode( ',', (string) $adresses ) );
	return implode( ', ', array_values( array_unique( array_filter( array_merge( $liste, $autres ) ) ) ) );
}, 10, 2 );

/**
 * Champ piège contre les robots, toujours actif ; rien à cocher pour le visiteur.
 */
add_filter( 'fluentform/honeypot_status', '__return_true' );

/* ----- Réglage dans Mon entreprise > Fonctions ------------------------------------- */

/* ----- Extensions recommandées : installées et activées en un clic ------------------ */

function briise_extensions_recommandees() {
	return array(
		'fluentform'  => array( 'Fluent Forms', 'fluentform/fluentform.php' ),
		'fluent-smtp' => array( 'FluentSMTP', 'fluent-smtp/fluent-smtp.php' ),
	);
}

function briise_extensions_manquantes() {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	return array_filter( briise_extensions_recommandees(), function ( $e ) {
		return ! is_plugin_active( $e[1] );
	} );
}

add_action( 'admin_post_briise_installer_extensions', function () {
	if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) || ! check_admin_referer( 'briise_installer_extensions' ) ) {
		wp_die( 'Accès refusé.' );
	}
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	$bilan = array();
	foreach ( briise_extensions_manquantes() as $slug => $e ) {
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $e[1] ) ) {
			$info = plugins_api( 'plugin_information', array( 'slug' => $slug, 'fields' => array( 'sections' => false ) ) );
			if ( is_wp_error( $info ) || empty( $info->download_link ) ) {
				$bilan[] = $e[0] . ' : téléchargement impossible depuis WordPress.org' . ( is_wp_error( $info ) ? ' (' . $info->get_error_message() . ')' : '' ) . '. L’installer depuis Extensions > Ajouter.';
				continue;
			}
			$installe = ( new Plugin_Upgrader( new Automatic_Upgrader_Skin() ) )->install( $info->download_link );
			if ( true !== $installe ) {
				$bilan[] = $e[0] . ' : installation impossible' . ( is_wp_error( $installe ) ? ' (' . $installe->get_error_message() . ')' : '' ) . '.';
				continue;
			}
		}
		$actif   = activate_plugin( $e[1] );
		$bilan[] = is_wp_error( $actif ) ? $e[0] . ' : activation impossible (' . $actif->get_error_message() . ').' : $e[0] . ' : installé et activé.';
	}
	set_transient( 'briise_extensions_' . get_current_user_id(), $bilan, 120 );
	wp_safe_redirect( admin_url( 'admin.php?page=briise-entreprise&onglet=fonctions#br-formulaires' ) );
	exit;
} );

function briise_extensions_bouton() {
	$manquantes = briise_extensions_manquantes();
	if ( ! $manquantes || ! current_user_can( 'install_plugins' ) ) {
		return '';
	}
	$noms = implode( ' et ', wp_list_pluck( $manquantes, 0 ) );
	return '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin:8px 0 0">' . wp_nonce_field( 'briise_installer_extensions', '_wpnonce', true, false )
		. '<input type="hidden" name="action" value="briise_installer_extensions">'
		. '<button type="submit" class="button button-primary">Installer et activer ' . esc_html( $noms ) . '</button>'
		. ' <span class="description">Extensions gratuites, depuis WordPress.org ; elles se mettent ensuite à jour comme les autres.</span></form>';
}

add_action( 'admin_post_briise_formulaire_creer', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'briise_formulaire_creer' ) ) {
		wp_die( 'Accès refusé.' );
	}
	$type = sanitize_key( $_POST['type'] ?? 'devis' );
	if ( 'reservation' === $type && isset( $_POST['lieux'] ) ) {
		update_option( 'briise_reservation_lieux', array_values( array_filter( array_map( 'sanitize_text_field', explode( "\n", wp_unslash( $_POST['lieux'] ) ) ) ) ) );
	}
	$r    = briise_formulaire_creer( $type );
	set_transient( 'briise_formulaire_' . get_current_user_id(), is_wp_error( $r ) ? $r->get_error_message() : (int) $r, 120 );
	wp_safe_redirect( admin_url( 'admin.php?page=briise-entreprise&onglet=fonctions#br-formulaires' ) );
	exit;
} );

add_action( 'briise_onglet_apres', function ( $onglet ) {
	if ( 'fonctions' === $onglet && current_user_can( 'manage_options' ) ) {
		echo '<div class="br-admin">';
		briise_formulaires_encadre();
		echo '</div>';
	}
} );

function briise_formulaires_encadre() {
	$r = get_transient( 'briise_formulaire_' . get_current_user_id() );
	if ( false !== $r ) {
		delete_transient( 'briise_formulaire_' . get_current_user_id() );
		echo is_numeric( $r )
			? '<div class="notice notice-success inline"><p>Formulaire créé (n° ' . (int) $r . '). Il apparaît sur les pages qui contiennent la section « Formulaire ».</p></div>'
			: '<div class="notice notice-error inline"><p>' . esc_html( $r ) . '</p></div>';
	}
	$bilan = get_transient( 'briise_extensions_' . get_current_user_id() );
	if ( $bilan ) {
		delete_transient( 'briise_extensions_' . get_current_user_id() );
		echo '<div class="notice notice-info inline"><p>' . implode( '<br>', array_map( 'esc_html', (array) $bilan ) ) . '</p></div>';
	}
	echo '<h2 class="title" id="br-formulaires">Formulaires</h2>';
	if ( ! briise_fluentforms_actif() ) {
		echo '<p class="description">Les formulaires de devis et de contact utilisent l’extension gratuite <strong>Fluent Forms</strong>, et <strong>FluentSMTP</strong> pour que les e-mails arrivent. En attendant, les pages affichent le téléphone et l’e-mail.</p>';
		echo briise_extensions_bouton(); // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans la fonction.
		return;
	}
	echo '<table class="form-table" role="presentation">';
	foreach ( briise_formulaires_types() as $type => $nom ) {
		$id = briise_formulaire_id( $type );
		if ( $id ) {
			$champ = 'Formulaire n° ' . (int) $id . ' · <a href="' . esc_url( admin_url( 'admin.php?page=fluent_forms&route=editor&form_id=' . $id ) ) . '">modifier</a> · <a href="' . esc_url( admin_url( 'admin.php?page=fluent_forms&route=entries&form_id=' . $id ) ) . '">demandes reçues</a>';
		} else {
			$champ = '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin:0">' . wp_nonce_field( 'briise_formulaire_creer', '_wpnonce', true, false )
				. '<input type="hidden" name="action" value="briise_formulaire_creer"><input type="hidden" name="type" value="' . esc_attr( $type ) . '">'
				. ( 'reservation' === $type ? '<label for="br-lieux" style="display:block;margin:0 0 4px">Lieux proposés, un par ligne (facultatif)</label><textarea id="br-lieux" name="lieux" rows="3" cols="40" placeholder="Au studio&#10;Chez vous&#10;En extérieur">' . esc_textarea( implode( "\n", briise_reservation_lieux() ) ) . '</textarea><br>' : '' )
				. '<button type="submit" class="button">Créer le formulaire</button></form>';
		}
		$aides = array(
			'devis'       => 'Nom, téléphone, e-mail (facultatif), commune, projet (liste des services du site) et description. E-mail à l’adresse de Mon entreprise (et aux autres adresses réglées dans l’onglet Entreprise), avec « Répondre » vers le visiteur ; confirmation au visiteur, qui peut y joindre ses photos.',
			'contact'     => 'Nom, téléphone, e-mail (facultatif) et message. Mêmes e-mails que pour le devis.',
			'reservation' => 'Pour les métiers sur rendez-vous (photographe, institut, cours) : la prestation (choix parmi les services du site), le lieu (si vous en indiquez), la date souhaitée, puis nom, téléphone, e-mail et un mot facultatif. Mêmes e-mails que pour le devis. Section « Formulaire de réservation ».',
		);
		briise_ligne( $nom, $champ, $aides[ $type ] );
	}
	echo '</table>';
	$smtp = defined( 'FLUENTMAIL' ) || class_exists( '\FluentMail\App\Services\Mailer\Manager' );
	echo briise_extensions_bouton(); // phpcs:ignore WordPress.Security.EscapeOutput -- échappé dans la fonction.
	echo '<div class="br-a-faire' . ( $smtp ? ' br-ok' : '' ) . '">' . ( $smtp
		? 'FluentSMTP est actif : vérifiez qu’une connexion d’envoi est réglée (Réglages > FluentSMTP) et envoyez un e-mail de test.'
		: 'Pour que les demandes n’arrivent pas en indésirables, installez <strong>FluentSMTP</strong> et reliez-le à la boîte e-mail du domaine du client (avec SPF, DKIM et DMARC réglés chez l’hébergeur).' ) . '</div>';
}

/* ----- Vitesse : le formulaire ne retarde pas l'affichage de la page ------------------ */

// Feuilles de Fluent Forms chargées sans bloquer l'affichage (le formulaire est sous la ligne de flottaison).
add_filter( 'style_loader_tag', function ( $tag, $handle ) {
	if ( is_admin() || ! in_array( $handle, array( 'fluent-form-styles', 'fluentform-public-default' ), true ) || false !== strpos( $tag, 'media="print"' ) ) {
		return $tag;
	}
	$asynchrone = str_replace( array( "media='all'", 'media="all"' ), 'media="print" onload="this.media=\'all\'"', $tag );
	return $asynchrone . '<noscript>' . $tag . '</noscript>';
}, 10, 2 );

// jQuery (utilisé par Fluent Forms) en bas de page, sans jQuery Migrate : il ne bloque plus l'affichage.
add_action( 'wp_enqueue_scripts', function () {
	if ( is_admin() || is_customize_preview() ) {
		return;
	}
	$scripts = wp_scripts();
	if ( isset( $scripts->registered['jquery'] ) ) {
		$scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
	}
	foreach ( array( 'jquery', 'jquery-core' ) as $h ) {
		$scripts->add_data( $h, 'group', 1 );
	}
}, 1 );
