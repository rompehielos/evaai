<?php

define( 'AIINC', 'ai-adjuntos' );

// Include files required for initialization.
require( ABSPATH . AIINC . '/load.php' );
#require( ABSPATH . AIINC . '/default-constants.php' );

/*
 * These can't be directly globalized in version.php. When updating,
 * we're including version.php from another install and don't want
 * these values to be overridden if already set.
 */
global $ai_version, $ai_db_version, $required_php_version, $required_mysql_version;
require( ABSPATH . AIINC . '/version.php' );

// Check for the required PHP version and for the MySQL extension or a database drop-in.
ai_check_php_mysql_versions();

// Check if we have received a request due to missing favicon.ico
ai_favicon_request();

// Check if we're in WP_DEBUG mode.
ai_debug_mode();



//Carga temprano de archivos de Amauto Imperial
require( ABSPATH . AIINC . '/class-ai-db.php' );
require( ABSPATH . AIINC . '/functions.php' );
require( ABSPATH . AIINC . '/option.php' );
require( ABSPATH . AIINC . '/plugin.php' );
require( ABSPATH . AIINC . '/formatting.php' );


//Carga otras cosas importantes de Amauto Imperial
require( ABSPATH . AIINC . '/link-template.php' );
require( ABSPATH . AIINC . '/theme.php' );
require( ABSPATH . AIINC . '/class-ai-theme.php' );
require( ABSPATH . AIINC . '/template.php' );
require( ABSPATH . AIINC . '/general-template.php' );


/***********************************/

/**
 * Amauto Imperial Object
 * @global object $ai
 */

#echo "ai-settings.php";

class AI {
	public function main() {
		echo "AI().main()";
	}
}

$GLOBALS['ai'] = new AI();