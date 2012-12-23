<?php
$themecolors = array(
	'bg' => 'ffffff',
	'border' => '666666',
	'text' => '333333',
	'link' => '105CB6'
);

$content_width = 468; // pixels

if ( function_exists('register_sidebar') )
    register_sidebars(2);

function digg3_admin_image_header() {
?>
<style>

#headimg {
	margin: 0 0 10px;
	width: 904px;
	height: 160px;
	color: #333;
}

#headimg h1{
	padding: 32px 28px 0;
	font-size: 24px;
	font-weight: bold;
	letter-spacing: 1px;
	text-transform: uppercase;
	color: #<?php header_textcolor() ?>;
}

#headimg h1 a{
	text-decoration: none;
	color: #<?php header_textcolor() ?>;
	border: none;
}
#desc {
	display: none;
}


</style>
<?php
}

function digg3_header_style() {
?>
<style type="text/css">
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1 a, #header .description {
display: none;
}
<?php } else { ?>
#header h1 a, #header h1 a:hover, #header .description {
color: #<?php header_textcolor() ?>;
}
<?php } ?>
</style>
<?php
}


add_custom_image_header('digg3_header_style', 'digg3_admin_image_header');

define('HEADER_TEXTCOLOR', 'ffffff');
define('HEADER_IMAGE', '%s/images/bg_header_img.png'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 904);
define('HEADER_IMAGE_HEIGHT', 160);

?>
