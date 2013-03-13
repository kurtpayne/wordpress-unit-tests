<?php

function sanitize_color( $get ) {
	if ( !isset($_GET[$get]) )
		return '000000';
	$color = substr(preg_replace('/[^a-fA-F0-9]/', '', $_GET[$get]), 0, 6);
	if ( 6 != strlen($color) )
		$color = $color . str_repeat('0', 6 - strlen($color));
	return $color;
}
	
$info = array(
	'body.png'			=> array(
						array( 'type' => 'fill', 'color' => sanitize_color('base') ),
						array( 'type' => 'gradient', 'top' => sanitize_color('top'), 'bottom' => sanitize_color('bottom'), 'y' => 0, 'h' => 121 )
					),
	'bg-bar.png'			=> array( array( 'type' => 'fill', 'color' => sanitize_color('base') ) ),
	'bg-bar-white.png'		=> array( array( 'type' => 'fill', 'color' => sanitize_color('base') ) ),
	'bg-tab.png'			=> array( array( 'type' => 'fill', 'color' => sanitize_color('link') ) ),
	'bg-navigation.png'		=> array( array( 'type' => 'fill', 'color' => sanitize_color('base') ) ),
	'bg-content-left.png'		=> array(
						array( 'type' => 'fill', 'color' => sanitize_color('base') ),
						array( 'type' => 'gradient', 'top' => sanitize_color('top'), 'bottom' => sanitize_color('bottom'), 'y' => 0, 'h' => 41, 'start' => -80 )
					),
	'bg-content-right.png'		=> array(
						array( 'type' => 'fill', 'color' => sanitize_color('base') ),
						array( 'type' => 'gradient', 'top' => sanitize_color('top'), 'bottom' => sanitize_color('bottom'), 'y' => 0, 'h' => 41, 'start' => -80 )
					),
	'bg-content.png'		=> array(
						array( 'type' => 'fill', 'color' => sanitize_color('base') ),
						array( 'type' => 'gradient', 'top' => sanitize_color('top'), 'bottom' => sanitize_color('bottom'), 'y' => 0, 'h' => 41, 'start' => -80 )
					),
	'bg-navigation-item.png'	=> array(
						array( 'type' => 'gradient', 'top' => sanitize_color('top'), 'bottom' => sanitize_color('bottom'), 'y' => 0, 'h' => 48, 'stop' => 121 ),
						array( 'type' => 'gradient', 'top' => sanitize_color('top'), 'bottom' => sanitize_color('bottom'), 'y' => 48, 'h' => 12, 'stop' => 169 )
					),
	'gradient-inner.png'		=> array( 'type' => 'fill', 'color' => sanitize_color('base') ),
	'preview.png'			=> array(
						array( 'type' => 'fill', 'color' => sanitize_color('base') ),
						array( 'type' => 'gradient', 'top' => sanitize_color('top'), 'bottom' => sanitize_color('bottom'), 'y' => 18, 'h' => 121 )
					),
	'screenshot.png'		=> array(
						array( 'type' => 'fill', 'color' => sanitize_color('base') ),
						array( 'type' => 'gradient', 'top' => sanitize_color('top'), 'bottom' => sanitize_color('bottom'), 'y' => 0, 'h' => 121 )
					)
);

?>
