<?php
/**
 * Installs WordPress for running the tests and loads WordPress and the test libraries
 */

error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT );

require_once 'PHPUnit/Autoload.php';

$config_file_path = dirname( __FILE__ ) . '/wp-tests-config.php';

/*
 * Globalize some WordPress variables, because PHPUnit loads this file inside a function
 * See: https://github.com/sebastianbergmann/phpunit/issues/325
 *
 * These are not needed for WordPress 3.3+, only for older versions
*/
global $table_prefix, $wp_embed, $wp_locale, $_wp_deprecated_widgets_callbacks, $wp_widget_factory;

// These are still needed
global $wpdb, $current_site, $current_blog, $wp_rewrite, $shortcode_tags, $wp;

if ( !is_readable( $config_file_path ) ) {
	die( "ERROR: wp-tests-config.php is missing! Please use wp-tests-config-sample.php to create a config file.\n" );
}
require_once $config_file_path;

define( 'DIR_TESTDATA', dirname( __FILE__ ) . '/data' );

if ( ! defined( 'WP_TESTS_FORCE_KNOWN_BUGS' ) )
	define( 'WP_TESTS_FORCE_KNOWN_BUGS', false );

// Cron tries to make an HTTP request to the blog, which always fails, because tests are run in CLI mode only
define( 'DISABLE_WP_CRON', true );

define( 'WP_MEMORY_LIMIT', -1 );
define( 'WP_MAX_MEMORY_LIMIT', -1 );

$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['HTTP_HOST'] = WP_TESTS_DOMAIN;
$PHP_SELF = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = '/index.php';

system( WP_PHP_BINARY . ' ' . escapeshellarg( dirname( __FILE__ ) . '/bin/install.php' ) . ' ' . escapeshellarg( $config_file_path ) );

if ( defined( 'WP_TESTS_MULTISITE' ) && WP_TESTS_MULTISITE ) {
	define( 'MULTISITE', true );
	define( 'SUBDOMAIN_INSTALL', false );
	define( 'DOMAIN_CURRENT_SITE', WP_TESTS_DOMAIN );
	define( 'PATH_CURRENT_SITE', '/' );
	define( 'SITE_ID_CURRENT_SITE', 1 );
	define( 'BLOG_ID_CURRENT_SITE', 1 );
	$GLOBALS['base'] = '/';
}

require dirname( __FILE__ ) . '/includes/functions.php';

// Preset WordPress options defined in bootstrap file.
// Used to activate themes, plugins, as well as  other settings.
if(isset($GLOBALS['wp_tests_options'])) {
	function wp_tests_options( $value ) {
		$key = substr( current_filter(), strlen( 'pre_option_' ) );
		return $GLOBALS['wp_tests_options'][$key];
	}

	foreach ( array_keys( $GLOBALS['wp_tests_options'] ) as $key ) {
		tests_add_filter( 'pre_option_'.$key, 'wp_tests_options' );
	}
}

// Load WordPress
require_once ABSPATH . '/wp-settings.php';

// Delete any default posts & related data
_delete_all_posts();

require dirname( __FILE__ ) . '/includes/testcase.php';
require dirname( __FILE__ ) . '/includes/testcase-xmlrpc.php';
require dirname( __FILE__ ) . '/includes/testcase-ajax.php';
require dirname( __FILE__ ) . '/includes/exceptions.php';
require dirname( __FILE__ ) . '/includes/utils.php';
