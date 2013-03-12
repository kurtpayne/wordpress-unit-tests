<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '545454',
	'link' => '005a80'
);

$content_width = 500;

$themeData = get_theme_data(TEMPLATEPATH . '/style.css');
$installedVersion = $themeData['Version'];
if(!$installedVersion) {
	$installedVersion = "unknown";
}

$highlightColor = "#a3c5cc";

// widgets!
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'id' => 'main-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Footer Widgets',
		'id' => 'footer-widgets',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

// No CSS, just IMG call

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/greytree.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 720);
define('HEADER_IMAGE_HEIGHT', 180);
define('NO_HEADER_TEXT', true );

function tarski_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}

</style>
<?php
}

add_custom_image_header('', 'tarski_admin_header_style');

/*function tarski_nopaging($query) {
	if ( !is_home() && !is_feed() && !is_admin() && '' === $query->get('nopaging') )
		$query->set('nopaging', 1);
}

add_action('parse_query', 'tarski_nopaging');
*/
?>
