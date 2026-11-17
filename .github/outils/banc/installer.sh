#!/usr/bin/env bash
# Installe (ou remet à neuf) le WordPress de test : cœur, base SQLite, Fluent Forms, FluentSMTP,
# et des liens vers le thème et l'extension du dépôt (on teste toujours le code en cours).
set -euo pipefail
DEPOT="$1"
WP="$BANC_WP"
TMP="$(dirname "$WP")/telechargements"
mkdir -p "$TMP"

telecharger_extension() { # $1 = nom wordpress.org
	[ -d "$WP/wp-content/plugins/$1" ] && return 0
	curl -sSL -o "$TMP/$1.zip" "https://downloads.wordpress.org/plugin/$1.latest-stable.zip"
	unzip -q -o "$TMP/$1.zip" -d "$WP/wp-content/plugins/"
}

if [ ! -f "$WP/wp-settings.php" ]; then
	mkdir -p "$WP"
	if [ -n "${BANC_COPIE_DE:-}" ]; then
		echo "  copie de WordPress depuis $BANC_COPIE_DE"
		( cd "$BANC_COPIE_DE" && tar cf - --exclude=wp-content/database --exclude=wp-content/uploads --exclude=wp-content/themes/briise --exclude=wp-content/plugins/briise-socle --exclude=wp-content/mu-plugins --exclude=wp-content/debug.log --exclude=wp-config.php . ) | ( cd "$WP" && tar xf - )
		if [ -d "$WP/wp-content/plugins/sqlite-database-integration-main" ] && [ ! -d "$WP/wp-content/plugins/sqlite-database-integration" ]; then
			mv "$WP/wp-content/plugins/sqlite-database-integration-main" "$WP/wp-content/plugins/sqlite-database-integration"
		fi
	else
		echo "  téléchargement de WordPress"
		curl -sSL -o "$TMP/wordpress.tar.gz" https://wordpress.org/latest.tar.gz
		tar xzf "$TMP/wordpress.tar.gz" -C "$TMP"
		cp -a "$TMP/wordpress/." "$WP/"
	fi
fi

telecharger_extension sqlite-database-integration
telecharger_extension fluentform
telecharger_extension fluent-smtp
cp "$WP/wp-content/plugins/sqlite-database-integration/db.copy" "$WP/wp-content/db.php"

cat > "$WP/wp-config.php" << 'CONF'
<?php
define( 'DB_NAME', 'banc' ); define( 'DB_USER', '' ); define( 'DB_PASSWORD', '' ); define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' ); define( 'DB_COLLATE', '' );
define( 'DB_DIR', __DIR__ . '/wp-content/database/' ); define( 'DB_FILE', '.ht.sqlite' );
foreach ( array( 'AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY', 'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT' ) as $k ) { define( $k, 'banc-briise-' . $k ); }
$table_prefix = 'wp_';
define( 'WP_DEBUG', true ); define( 'WP_DEBUG_LOG', true ); define( 'WP_DEBUG_DISPLAY', false );
define( 'DISABLE_WP_CRON', true ); define( 'FS_METHOD', 'direct' ); define( 'AUTOMATIC_UPDATER_DISABLED', true );
if ( ! defined( 'ABSPATH' ) ) { define( 'ABSPATH', __DIR__ . '/' ); }
require_once ABSPATH . 'wp-settings.php';
CONF

rm -rf "$WP/wp-content/database" "$WP/wp-content/uploads" "$WP/wp-content/debug.log"
mkdir -p "$WP/wp-content/database" "$WP/wp-content/themes" "$WP/wp-content/plugins"
ln -sfn "$DEPOT" "$WP/wp-content/themes/briise"
ln -sfn "$DEPOT/extension/briise-socle" "$WP/wp-content/plugins/briise-socle"
echo "  WordPress prêt dans $WP"
