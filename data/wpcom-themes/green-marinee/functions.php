<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '78a515'
);

$content_width = 475;

register_sidebar( array(
	'name'          => __('Sidebar'),
	'id'            => 'sidebar',
	'before_widget' => '<span class="widget">',
	'after_widget'  => '</span><div class="line"></div>',
	'before_title'  => '<h3>',
	'after_title'   => '</h3>' ) );
