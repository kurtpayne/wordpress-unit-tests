<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '1177aa'
);

$content_width = 500;

register_sidebar( array(
	'name'          => __('Sidebar'),
	'id'            => 'sidebar',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>' ) );

?>
