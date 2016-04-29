<?php

if ( !isset($ai_did_header) ) {
	$ai_did_header = true;
	// Carga las bibliotecas de Amauto Imperial.
	require_once( dirname(__FILE__) . '/ai-load.php' );
	// Configura la petición de Amauto Imperial
	ai();
	// Carga la plantilla del tema.
	require_once( ABSPATH . AIINC . '/template-loader.php' );
}
