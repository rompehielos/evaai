<?php

function info($opcion) {
	switch($opcion) {
		case 'home':
			echo 'http://192.168.88.100';
			break;
		case 'nombre':
			echo 'Plataforma electrónica';
			break;
		case 'info':
			echo 'La mejor plataforma de aprendizaje en línea';
			break;
	}
}

/**
 * Determine if SSL is used.
 *
 * @return bool True if SSL, false if not used.
 */
function is_ssl() {
	if ( isset($_SERVER['HTTPS']) ) {
		if ( 'on' == strtolower($_SERVER['HTTPS']) )
			return true;
		if ( '1' == $_SERVER['HTTPS'] )
			return true;
	} elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
		return true;
	}
	return false;
}

/**
 * Guess the URL for the site.
 *
 * Will remove ai-admin links to retrieve only return URLs not in the ai-admin
 *
 * @return string The guessed URL.
 */
function ai_guess_url() {
	if ( defined('AI_SITEURL') && '' != AI_SITEURL ) {
		$url = AI_SITEURL;
	}
	else {
		$abspath_fix = str_replace( '\\', '/', ABSPATH );
		$script_filename_dir = dirname( $_SERVER['SCRIPT_FILENAME'] );

		// The request is for the admin
		if ( strpos( $_SERVER['REQUEST_URI'], 'ai-admin' ) !== false || strpos( $_SERVER['REQUEST_URI'], 'ai-login.php' ) !== false ) {
			$path = preg_replace( '#/(ai-admin/.*|ai-login.php)#i', '', $_SERVER['REQUEST_URI'] );

		// The request is for a file in ABSPATH
		} elseif ( $script_filename_dir . '/' == $abspath_fix ) {
			// Strip off any file/query params in the path
			$path = preg_replace( '#/[^/]*$#i', '', $_SERVER['PHP_SELF'] );

		} else {
			if ( false !== strpos( $_SERVER['SCRIPT_FILENAME'], $abspath_fix ) ) {
				// Request is hitting a file inside ABSPATH
				$directory = str_replace( ABSPATH, '', $script_filename_dir );
				// Strip off the sub directory, and any file/query params
				$path = preg_replace( '#/' . preg_quote( $directory, '#' ) . '/[^/]*$#i', '' , $_SERVER['REQUEST_URI'] );
			} elseif ( false !== strpos( $abspath_fix, $script_filename_dir ) ) {
				// Request is hitting a file above ABSPATH
				$subdirectory = substr( $abspath_fix, strpos( $abspath_fix, $script_filename_dir ) + strlen( $script_filename_dir ) );
				// Strip off any file/query params from the path, appending the sub directory to the install
				$path = preg_replace( '#/[^/]*$#i', '' , $_SERVER['REQUEST_URI'] ) . $subdirectory;
			} else {
				$path = $_SERVER['REQUEST_URI'];
			}
		}

		$schema = is_ssl() ? 'https://' : 'http://'; // set_url_scheme() is not defined yet
		$url = $schema . $_SERVER['HTTP_HOST'] . $path;
	}

	return rtrim($url, '/');
}

/**
 * Configuración de la consulta Amauto Imperial.
 * @global AI       $ai_locale
 * @global AI_Query $ai_query
 * @global AI_Query $ai_the_query
 *
 * @param string|array $query_vars Default AI_Query arguments.
 */
function ai( $query_vars = '' ) {
	global $ai, $ai_query, $ai_the_query;
	$ai->main( $query_vars );
	
	echo $_SERVER['SERVER_NAME'];

	if ( !isset($ai_the_query) ) {
		$ai_the_query = $ai_query;
	}
}
