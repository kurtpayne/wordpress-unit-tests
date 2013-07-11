<?php

$themecolors = array(
	'bg' => 'eeeeee',
	'text' => '000000',
	'link' => 'cc0000'
);

$content_width = 460;

// No CSS, just IMG call

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/main.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 480);
define('HEADER_IMAGE_HEIGHT', 250);
define( 'NO_HEADER_TEXT', true );

function neosapien_admin_header_style() {
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

add_custom_image_header('', 'neosapien_admin_header_style');

if ( function_exists('register_sidebar') ) {
register_sidebar(1);
register_sidebar(2);
register_sidebar(3);
}

?>
