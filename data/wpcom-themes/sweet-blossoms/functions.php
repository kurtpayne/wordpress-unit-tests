<?php

$themecolors = array(
	'bg' => 'eecad4',
	'border' => 'eecad4',
	'text' => '000000',
	'link' => 'de3894'
);

$content_width = 305;

register_sidebar( array(
	'name'          => __('Sidebar'),
	'id'            => 'sidebar',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h3><em>',
	'after_title'   => '</em></h3>' ) );
