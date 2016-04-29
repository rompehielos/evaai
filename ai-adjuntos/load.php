<?php

/**
 * Fix `$_SERVER` variables for various setups.
 *
 * @since 3.0.0
 * @access private
 *
 * @global string $PHP_SELF The filename of the currently executing script,
 *                          relative to the document root.
 */
function ai_fix_server_vars() {
	global $PHP_SELF;

	$default_server_values = array(
		'SERVER_SOFTWARE' => '',
		'REQUEST_URI' => '',
	);

	$_SERVER = array_merge( $default_server_values, $_SERVER );

	// Fix for IIS when running with PHP ISAPI
	if ( empty( $_SERVER['REQUEST_URI'] ) || ( PHP_SAPI != 'cgi-fcgi' && preg_match( '/^Microsoft-IIS\//', $_SERVER['SERVER_SOFTWARE'] ) ) ) {

		// IIS Mod-Rewrite
		if ( isset( $_SERVER['HTTP_X_ORIGINAL_URL'] ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
		}
		// IIS Isapi_Rewrite
		elseif ( isset( $_SERVER['HTTP_X_REWRITE_URL'] ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
		} else {
			// Use ORIG_PATH_INFO if there is no PATH_INFO
			if ( !isset( $_SERVER['PATH_INFO'] ) && isset( $_SERVER['ORIG_PATH_INFO'] ) )
				$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];

			// Some IIS + PHP configurations puts the script-name in the path-info (No need to append it twice)
			if ( isset( $_SERVER['PATH_INFO'] ) ) {
				if ( $_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME'] )
					$_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
				else
					$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
			}

			// Append the query string if it exists and isn't null
			if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
				$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
			}
		}
	}

	// Fix for PHP as CGI hosts that set SCRIPT_FILENAME to something ending in php.cgi for all requests
	if ( isset( $_SERVER['SCRIPT_FILENAME'] ) && ( strpos( $_SERVER['SCRIPT_FILENAME'], 'php.cgi' ) == strlen( $_SERVER['SCRIPT_FILENAME'] ) - 7 ) )
		$_SERVER['SCRIPT_FILENAME'] = $_SERVER['PATH_TRANSLATED'];

	// Fix for Dreamhost and other PHP as CGI hosts
	if ( strpos( $_SERVER['SCRIPT_NAME'], 'php.cgi' ) !== false )
		unset( $_SERVER['PATH_INFO'] );

	// Fix empty PHP_SELF
	$PHP_SELF = $_SERVER['PHP_SELF'];
	if ( empty( $PHP_SELF ) )
		$_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( '/(\?.*)?$/', '', $_SERVER["REQUEST_URI"] );
}

/**
* Return the HTTP protocol sent by the server.
*
* @return string The HTTP protocol. Default: HTTP/1.0.
*/
function ai_get_server_protocol() {
	$protocol = $_SERVER['SERVER_PROTOCOL'];
	if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {
		$protocol = 'HTTP/1.0';
	}
	return $protocol;
}

/**
 * Check for the required PHP version, and the MySQL extension or
 * a database drop-in.
 *
 * Dies if requirements are not met.
 *
 * @access private
 *
 * @global string $required_php_version The required PHP version string.
 * @global string $wp_version           The WordPress version string.
 */
function ai_check_php_mysql_versions() {
	global $required_php_version, $wp_version;
	$php_version = phpversion();

	if ( version_compare( $required_php_version, $php_version, '>' ) ) {
		#ai_load_translations_early();

		$protocol = ai_get_server_protocol();
		header( sprintf( '%s 500 Internal Server Error', $protocol ), true, 500 );
		header( 'Content-Type: text/html; charset=utf-8' );
		die( sprintf( 'El servidor está ejecutando la versión de PHP %1$s, pero Amauto Imperial %2$s necesita al menos la %3$s.', $php_version, $ai_version, $required_php_version ) );
	}

	/*if ( ! extension_loaded( 'mysql' ) && ! extension_loaded( 'mysqli' ) && ! file_exists( WP_CONTENT_DIR . '/db.php' ) ) {
		#ai_load_translations_early(); //Translate before loads strings.

		$protocol = ai_get_server_protocol();
		header( sprintf( '%s 500 Internal Server Error', $protocol ), true, 500 );
		header( 'Content-Type: text/html; charset=utf-8' );
		die( 'Your PHP installation appears to be missing the MySQL extension which is required by Amauto Imperial.' );
	}*/
}

/**
* Don't load all of Amauto Imperial when handling a favicon.ico request.
*
* En vez de eso, envía las cabeceras para un favicon de tamaño 0 y libera todo.
*
*/
function ai_favicon_request() {
	if ( '/favicon.ico' == $_SERVER['REQUEST_URI'] ) {
		header('Content-Type: image/vnd.microsoft.icon');
		exit;
	}
}

function ai_maintenance() {
	if ( ! file_exists( ABSPATH . '.maintenance' ) || ai_installing() )
	return;
	global $upgrading;
	include( ABSPATH . '.maintenance' );
	// If the $upgrading timestamp is older than 10 minutes, don't die.
	if ( ( time() - $upgrading ) >= 600 )
	return;
	if ( file_exists( AI_CONTENT_DIR . '/maintenance.php' ) ) {
	require_once( AI_CONTENT_DIR . '/maintenance.php' );
	die();
	}
	ai_load_translations_early();
	$protocol = ai_get_server_protocol();
	header( "$protocol 503 Service Unavailable", true, 503 );
	header( 'Content-Type: text/html; charset=utf-8' );
	header( 'Retry-After: 600' );
	?>
	<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Mantenimiento</title>
	</head>
	<body>
	<h1>En mantenimiento</h1>
	<p>Regrese en unos minutos a esta plataforma educativa.</p>
	</body>
	</html>
	<?php
	die();
}

/*
 * @access private
 */
function ai_debug_mode() {
	if ( AI_DEBUG ) {
		error_reporting( E_ALL );
		if ( AI_DEBUG_DISPLAY )
		ini_set( 'display_errors', 1 );
		elseif ( null !== AI_DEBUG_DISPLAY )
		ini_set( 'display_errors', 0 );
		if ( AI_DEBUG_LOG ) {
			ini_set( 'log_errors', 1 );
			ini_set( 'error_log', AI_CONTENT_DIR . '/debug.log' );
		}
	}
	else {
		error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
	}
	if ( defined( 'XMLRPC_REQUEST' ) || defined( 'REST_REQUEST' ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		ini_set( 'display_errors', 0 );
	}
}
