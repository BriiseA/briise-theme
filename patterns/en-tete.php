<?php
/**
 * Title: En-tête
 * Slug: briise/en-tete
 * Categories: header
 * Inserter: no
 *
 * La forme suit Mon entreprise > Apparence ; les textes, le téléphone et le bouton viennent de Mon entreprise.
 */
$e       = briise_theme_entreprise();
$v       = function_exists( 'briise_apparence' ) ? briise_apparence( 'entete' ) : 'classique';
$tel     = trim( (string) ( $e['telephone'] ?? '' ) );
$tel_url = preg_replace( '/[^\d+]/', '', $tel );
if ( 0 === strpos( $tel_url, '0' ) ) {
	$tel_url = '+33' . substr( $tel_url, 1 );
}
$centre  = in_array( $v, array( 'logo-centre', 'medaillon' ), true );
// Sur un fond sombre (capsule, médaillon, bandeau), le logo pour fond foncé de Mon entreprise, sinon le nom en texte.
$sombre  = in_array( $v, array( 'capsule', 'medaillon', 'bandeau' ), true );
$logo    = $sombre ? '<!-- wp:site-title {"level":0,"className":"br-logo br-logo--pied"} /-->' : '<!-- wp:site-logo {"width":220,"shouldSyncIcon":false,"className":"br-logo-img"} /-->' . "\n\n" . '<!-- wp:site-title {"level":0,"className":"br-logo"} /-->';
// « Menu plein écran » : le menu reste derrière le bouton « Menu », même sur ordinateur.
$nav     = '<!-- wp:navigation {"overlayMenu":"' . ( 'menu-plein' === $v ? 'always' : 'mobile' ) . '",' . ( 'menu-plein' === $v ? '"hasIcon":false,' : '' ) . '"className":"br-nav","layout":{"type":"flex","justifyContent":"' . ( $centre ? 'left' : 'right' ) . '"}} /-->';
$tel_html = '';
if ( $tel ) {
	$tel_html = '<!-- wp:html -->' . "\n" . '<a class="br-header-tel" href="tel:' . esc_attr( $tel_url ) . '" aria-label="' . esc_attr( 'Appeler ' . $e['name'] . ' au ' . briise_theme_telephone( $tel ) ) . '"><span class="br-header-tel-icone" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg></span><span class="br-header-tel-num" aria-hidden="true">' . esc_html( briise_theme_telephone( $tel ) ) . '</span></a>' . "\n" . '<!-- /wp:html -->';
}
$cta = '<!-- wp:buttons {"className":"br-header-cta"} -->' . "\n" . '<div class="wp-block-buttons br-header-cta"><!-- wp:button -->' . "\n" . '<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $e['cta_url'] ) . '">' . esc_html( $e['cta_label'] ) . '</a></div>' . "\n" . '<!-- /wp:button --></div>' . "\n" . '<!-- /wp:buttons -->';
$dispo = ( $centre && function_exists( 'briise_disponibilite_parties' ) ) ? briise_disponibilite_parties() : array();
$statut = $dispo ? '<!-- wp:html -->' . "\n" . '<p class="br-header-statut"><span class="br-point" aria-hidden="true"></span>' . esc_html( $dispo[0] . ' dès ' . $dispo[1] ) . '</p>' . "\n" . '<!-- /wp:html -->' : '';

// Barre d'infos : au-dessus du menu, état du jour calculé dans le navigateur (le cache de page ne le fige pas).
if ( 'barre-infos' === $v ) :
	$zone   = $e['areas'] ?? array();
	$zone   = array_values( array_filter( array_map( 'trim', is_array( $zone ) ? $zone : preg_split( '/\r\n|\r|\n/', (string) $zone ) ) ) );
	$infos  = array();
	$json   = function_exists( 'briise_horaires_json' ) ? briise_horaires_json() : '';
	if ( $json ) {
		$infos[] = '<span class="br-infos-jour" data-horaires="' . esc_attr( $json ) . '" hidden></span>';
	}
	if ( function_exists( 'briise_disponibilite_parties' ) && ( $d = briise_disponibilite_parties() ) ) {
		$infos[] = '<span>' . esc_html( $d[0] . ' dès ' . $d[1] ) . '</span>';
	}
	if ( $zone ) {
		$infos[] = '<span class="br-infos-zone">' . esc_html( 'Intervention à ' . $zone[0] . ( count( $zone ) > 1 ? ' et alentours' : '' ) ) . '</span>';
	}
	?>
<!-- wp:html -->
<div class="br-infos"><div class="br-infos-inner"><p class="br-infos-gauche"><?php echo implode( '', $infos ); // phpcs:ignore WordPress.Security.EscapeOutput -- échappé ci-dessus. ?></p><?php if ( $tel ) : ?><p class="br-infos-droite"><a href="tel:<?php echo esc_attr( $tel_url ); ?>"><?php echo esc_html( briise_theme_telephone( $tel ) ); ?></a></p><?php endif; ?></div></div>
<!-- /wp:html -->
<?php endif; ?>

<?php if ( 'ilots' === $v ) : ?>
<!-- wp:group {"align":"full","className":"br-header br-header--ilots","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-header br-header--ilots"><!-- wp:group {"className":"br-header-inner","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-inner"><!-- wp:group {"className":"br-ilot br-ilot--logo","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-ilot br-ilot--logo"><?php echo $logo; // phpcs:ignore ?></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-ilot br-ilot--nav","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-ilot br-ilot--nav"><?php echo $nav; // phpcs:ignore ?></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-header-right br-ilot--actions","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-right br-ilot--actions"><?php echo $tel_html . $cta; // phpcs:ignore ?></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php elseif ( $centre ) : ?>
<!-- wp:group {"align":"full","className":"br-header br-header--<?php echo esc_attr( $v ); ?>","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-header br-header--<?php echo esc_attr( $v ); ?>"><!-- wp:group {"className":"br-header-inner br-header-grille","layout":{"type":"default"}} -->
<div class="wp-block-group br-header-inner br-header-grille"><?php echo $nav; // phpcs:ignore ?>

<!-- wp:group {"className":"br-header-centre","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group br-header-centre"><?php echo $logo; // phpcs:ignore ?></div>
<!-- /wp:group -->

<!-- wp:group {"className":"br-header-right","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group br-header-right"><?php echo $statut . $tel_html . $cta; // phpcs:ignore ?></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php else : ?>
<!-- wp:group {"align":"full","className":"br-header br-header--<?php echo esc_attr( $v ); ?>","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull br-header br-header--<?php echo esc_attr( $v ); ?>"><!-- wp:group {"className":"br-header-inner","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-inner"><?php echo $logo; // phpcs:ignore ?>

<!-- wp:group {"className":"br-header-right","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group br-header-right"><?php echo $nav . "\n\n" . $tel_html . $cta; // phpcs:ignore ?></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endif; ?>
