<?php

function get_option( $opcion, $default = false ) {
	global $aidb;

	$opcion = trim( $opcion );
	if ( empty( $opcion ) )
		return false;

	if ( defined( 'AI_SETUP_CONFIG' ) )
		return false;

	
	$value = $aidb->obtener_valor( /*$aidb->prepare(*/ "CALL sp_Opciones('url')" /*)*/ );
	
	if(!empty($value)) {
		return $value;
	}
	else {
		//Vacío por mientras.
		return $opcion;
	}

	// Si está escritp 'inicio' tomarlo como 'url'.
	if ( 'inicio' == $opcion && '' == $value ) {
		return get_option( 'url' );
	}
}