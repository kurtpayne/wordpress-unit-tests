<?php
// PHP 4 compatiblity
if ( !function_exists('str_split')):
function str_split($string,$string_length=1) {
	if(strlen($string)>$string_length || !$string_length) {
		do {
			$c = strlen($string);
			$parts[] = substr($string,0,$string_length);
			$string = substr($string,$string_length);
		} while($string !== false);
	} else {
		$parts    = array($string);
	}
	return $parts;
}
endif;

// WordPress <2.8 compatibility
if ( !function_exists( 'get_the_author_meta' ) ):
function get_the_author_meta($field = '', $user_id = false) {
	if ( ! $user_id )
		global $authordata;
	else
		$authordata = get_userdata( $user_id );

	$field = strtolower($field);
	$user_field = "user_$field";

	if ( 'id' == $field )
		$value = isset($authordata->ID) ? (int)$authordata->ID : 0;
	elseif ( isset($authordata->$user_field) )
		$value = $authordata->$user_field;
	else
		$value = isset($authordata->$field) ? $authordata->$field : '';

	return apply_filters('get_the_author_' . $field, $value);
}
endif;

if ( !function_exists( 'the_author_meta' ) ):
function the_author_meta($field = '', $user_id = false) {
	echo apply_filters('the_author_' . $field, get_the_author_meta($field, $user_id));
}
endif;