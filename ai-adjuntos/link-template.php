<?php

function admin_url( $path = '', $scheme = 'admin' ) {
	return get_admin_url( $path, $scheme );
}

function get_admin_url( $path = '', $scheme = 'admin' ) {
	$url = get_site_url( 'ai-administracion/', $scheme);

	if ( $path && is_string( $path ) ) {
		$url .= ltrim( $path, '/' );
	}

	return $url;
}

function get_site_url( $path = '', $scheme = null ) {
	$url = get_option( 'url' );
	
	#$url = set_url_scheme( $url, $scheme );

	if ( $path && is_string( $path ) )
		$url .= '/' . ltrim( $path, '/' );

	return $url;
}