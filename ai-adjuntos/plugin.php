<?php

function do_action($tag, $arg = '') {
	global $ai_filter, $ai_actions, $merged_filters, $ai_current_filter;

	if ( ! isset($ai_actions[$tag]) )
		$ai_actions[$tag] = 1;
	else
		++$ai_actions[$tag];

	// Do 'all' actions first
	if ( isset($ai_filter['all']) ) {
		$ai_current_filter[] = $tag;
		$all_args = func_get_args();
		_ai_call_all_hook($all_args);
	}

	if ( !isset($ai_filter[$tag]) ) {
		if ( isset($ai_filter['all']) )
			array_pop($ai_current_filter);
		return;
	}

	if ( !isset($ai_filter['all']) )
		$ai_current_filter[] = $tag;

	$args = array();
	if ( is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0]) ) // array(&$this)
		$args[] =& $arg[0];
	else
		$args[] = $arg;
	for ( $a = 2, $num = func_num_args(); $a < $num; $a++ )
		$args[] = func_get_arg($a);

	// Ordenar
	if ( !isset( $merged_filters[ $tag ] ) ) {
		ksort($ai_filter[$tag]);
		$merged_filters[ $tag ] = true;
	}

	reset( $ai_filter[ $tag ] );

	do {
		foreach ( (array) current($ai_filter[$tag]) as $the_ )
			if ( !is_null($the_['function']) )
				call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

	} while ( next($ai_filter[$tag]) !== false );

	array_pop($ai_current_filter);
}


function apply_filters( $tag, $value ) {
	global $ai_filter, $merged_filters, $ai_current_filter;

	$args = array();

	// Do 'all' actions first.
	if ( isset($ai_filter['all']) ) {
		$ai_current_filter[] = $tag;
		$args = func_get_args();
		_ai_call_all_hook($args);
	}

	if ( !isset($ai_filter[$tag]) ) {
		if ( isset($ai_filter['all']) )
			array_pop($ai_current_filter);
		return $value;
	}

	if ( !isset($ai_filter['all']) )
		$ai_current_filter[] = $tag;

	// Sort.
	if ( !isset( $merged_filters[ $tag ] ) ) {
		ksort($ai_filter[$tag]);
		$merged_filters[ $tag ] = true;
	}

	reset( $ai_filter[ $tag ] );

	if ( empty($args) )
		$args = func_get_args();

	do {
		foreach ( (array) current($ai_filter[$tag]) as $the_ )
			if ( !is_null($the_['function']) ){
				$args[1] = $value;
				$value = call_user_func_array($the_['function'], array_slice($args, 1, (int) $the_['accepted_args']));
			}

	} while ( next($ai_filter[$tag]) !== false );

	array_pop( $ai_current_filter );

	return $value;
}


function _ai_call_all_hook($args) {
	global $ai_filter;

	reset( $ai_filter['all'] );
	do {
		foreach ( (array) current($ai_filter['all']) as $the_ )
			if ( !is_null($the_['function']) )
				call_user_func_array($the_['function'], $args);

	} while ( next($ai_filter['all']) !== false );
}