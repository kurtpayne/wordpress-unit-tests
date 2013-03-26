<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '003366'
	);

$content_width = 565;

if ( function_exists('register_sidebars') )
	register_sidebars(3);

// No CSS, just IMG call

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/imgs/freehead.gif'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 790);
define('HEADER_IMAGE_HEIGHT', 150);
define( 'NO_HEADER_TEXT', true );

function iceburgg_admin_header_style() {
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

function header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) no-repeat;
}
</style>
<?php
}

add_custom_image_header('header_style', 'iceburgg_admin_header_style');

?>
