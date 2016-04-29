<?php

function get_header( $name = null ) {
	
	do_action( 'get_header', $name );

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name ) {
		$templates[] = "header-{$name}.php";
	}

	$templates[] = 'header.php';

	locate_template( $templates, true );
}

function get_footer( $name = null ) {

	do_action( 'get_footer', $name );

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name ) {
		$templates[] = "footer-{$name}.php";
	}

	$templates[]    = 'footer.php';

	locate_template( $templates, true );
}