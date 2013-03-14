<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '61636a',
	'link' => '36769c'
);

$content_width = 450;

load_theme_textdomain('neat');

define('HEADER_TEXTCOLOR', 'blank');
define('HEADER_IMAGE', '%s/images/header.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 700);
define('HEADER_IMAGE_HEIGHT', 200);

function header_style() {
?>
<style type="text/css">
#header {
	font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
	text-align: left;
	background: url(<?php header_image() ?>);
 	width: <?php echo HEADER_IMAGE_WIDTH ?>px;
 	height: <?PHP echo HEADER_IMAGE_HEIGHT ?>px;
	margin: 0px;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header * {
	display: none;
}
<?php } else { ?>
#header h1 {
	display: block;
	color: #<?php header_textcolor() ?>;
	font-size: 28px;
	margin: 0 0 5px 15px;
	padding-top: 15px;
}
#header .description {
	display: block;
	color: #<?php header_textcolor() ?>;
	font-size: 14px;
	margin-left: 15px;
}
#header a, #header a:active, #header a:hover, #header a:visited {
	color: #<?php header_textcolor() ?>;
}
<?php } ?>
</style>
<?php
}

function admin_header_style() {
?>
<style type="text/css">

#header {
	text-align: left;
	background: url(<?php header_image() ?>) no-repeat top left;
 	width: <?php echo HEADER_IMAGE_WIDTH ?>px;
 	height: <?PHP echo HEADER_IMAGE_HEIGHT ?>px;
	margin: 0px;
}

#header h1 {
	font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
	color: #<?php header_textcolor() ?>;
	font-size: 28px;
	margin: 0 0 5px 15px;
	padding-top: 10px;
}

#header .description {
	font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
	color: #<?php header_textcolor() ?>;
	font-size: 14px;
	margin-left: 15px;
}
#header a, #header a:active, #header a:hover, #header a:visited {
	font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
	color: #<?php header_textcolor() ?>;
	border-bottom: none;
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headimg h1, #headimg #desc {
	display: none;
}
<?php } ?>

</style>
<?php
}

add_custom_image_header('header_style', 'admin_header_style');

if ( function_exists('register_sidebars') )
	register_sidebars(1);

?>
