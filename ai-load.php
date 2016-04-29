<?php
/** Define ABSPATH como el directorio de este archivo */
define( 'ABSPATH', dirname(__FILE__) . '/' );
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

if ( file_exists( ABSPATH . 'ai-config.php') ) {
/** El archivo de configuración está en ABSPATH */
	#echo 'El arch. de conf. está en ABSPATH';
	require_once( ABSPATH . 'ai-config.php' );
}
else {
	if ( @file_exists( dirname( ABSPATH ) . '/ai-config.php' ) && ! @file_exists( dirname( ABSPATH ) . '/ai-settings.php' ) ) {
/** El archivo de configuración está un nivel superior de ABSPATH pero no es parte de otra instalación. */
	require_once( dirname( ABSPATH ) . '/ai-config.php' );
	}
	else {
		// A config file doesn't exist
		define( 'AIINC', 'ai-adjuntos' );
		require_once( ABSPATH . AIINC . '/load.php' );

		ai_fix_server_vars();

		require_once( ABSPATH . AIINC . '/functions.php' );

		define( 'AI_CONTENT_DIR', ABSPATH . 'ai-content' );
		require_once( ABSPATH . AIINC . '/version.php' );
	}
}