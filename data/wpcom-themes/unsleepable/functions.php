<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => 'da1071'
);

$content_width = 500; // actually 503

/* blast you red baron! */
require_once (ABSPATH . WPINC . '/class-snoopy.php');

// WordPress Wigets
if (function_exists('register_sidebar')) 
	register_sidebar(array('before_widget' => '<li id="%1$s" class="widget %2$s">','after_widget' => '</li>', 'name' => 'Main Sidebar', 'id' => 'main-sidebar'));

if (function_exists('register_sidebar')) 
	register_sidebar(array('before_widget' => '<div id="%1$s" class="widget %2$s bottomblock">','after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>', 'name' => 'Bottom Bar', 'id' => 'bottom-bar'));
 
$current = 'r167';
function k2info($show='') {
global $current;
	switch($show) {
	case 'version' :
    	$info = 'Beta Two '. $current;
    	break;
    case 'scheme' :
    	$info = bloginfo('template_url') . '/styles/' . get_option('k2scheme');
    	break;
    }
    echo $info;
}

?>
