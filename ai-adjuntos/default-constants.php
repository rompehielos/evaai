<?php

function ai_initial_constants() {
	// configuración de límites de memoria
	if ( !defined('AI_MEMORY_LIMIT') ) {
		define('AI_MEMORY_LIMIT', '40M');
	}
	if ( ! defined( 'AI_MAX_MEMORY_LIMIT' ) ) {
		define( 'AI_MAX_MEMORY_LIMIT', '256M' );
	}
	
	if ( !defined('AI_CONTENT_DIR') )
		define( 'AI_CONTENT_DIR', ABSPATH . 'ai-content' ); // no trailing slash, full paths only - AI_CONTENT_URL is defined further down

	// Add define('AI_DEBUG', true); to ai-config.php to enable display of notices during development.
	if ( !defined('AI_DEBUG') )
		define( 'AI_DEBUG', false );

	// Add define('AI_DEBUG_DISPLAY', null); to ai-config.php use the globally configured setting for
	// display_errors and not force errors to be displayed. Use false to force display_errors off.
	if ( !defined('AI_DEBUG_DISPLAY') )
		define( 'AI_DEBUG_DISPLAY', true );

	// Add define('AI_DEBUG_LOG', true); to enable error logging to ai-content/debug.log.
	if ( !defined('AI_DEBUG_LOG') )
		define('AI_DEBUG_LOG', false);

	if ( !defined('AI_CACHE') )
		define('AI_CACHE', false);
}

/**
 * Defines cookie related WordPress constants
 */
function ai_cookie_constants() {
	/**
	 * Usado para garantizar cookies de hash únicos.
	 */
	if ( !defined( 'COOKIEHASH' ) ) {
		$siteurl = get_site_option( 'siteurl' );
		if ( $siteurl ) {
			define( 'COOKIEHASH', md5( $siteurl ) );
		}
		else {
			define( 'COOKIEHASH', '' );
		}
	}
	

	if ( !defined('USER_COOKIE') )
		define('USER_COOKIE', 'wordpressuser_' . COOKIEHASH);

	if ( !defined('PASS_COOKIE') )
		define('PASS_COOKIE', 'wordpresspass_' . COOKIEHASH);

	if ( !defined('AUTH_COOKIE') )
		define('AUTH_COOKIE', 'wordpress_' . COOKIEHASH);

	if ( !defined('SECURE_AUTH_COOKIE') )
		define('SECURE_AUTH_COOKIE', 'wordpress_sec_' . COOKIEHASH);

	if ( !defined('LOGGED_IN_COOKIE') )
		define('LOGGED_IN_COOKIE', 'wordpress_logged_in_' . COOKIEHASH);

	if ( !defined('TEST_COOKIE') )
		define('TEST_COOKIE', 'wordpress_test_cookie');

	if ( !defined('COOKIEPATH') )
		define('COOKIEPATH', preg_replace('|https?://[^/]+|i', '', get_option('home') . '/' ) );

	if ( !defined('SITECOOKIEPATH') )
		define('SITECOOKIEPATH', preg_replace('|https?://[^/]+|i', '', get_option('siteurl') . '/' ) );

	if ( !defined('ADMIN_COOKIE_PATH') )
		define( 'ADMIN_COOKIE_PATH', SITECOOKIEPATH . 'wp-admin' );

	if ( !defined('COOKIE_DOMAIN') )
		define('COOKIE_DOMAIN', false);
}