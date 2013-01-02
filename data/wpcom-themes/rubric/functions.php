<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => 'b54141'
);

define('HEADER_TEXTCOLOR', 'B54141');
define('HEADER_IMAGE', '%s/images/rubric/pen-sm.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 215);
define('HEADER_IMAGE_HEIGHT', 150);

function header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) no-repeat top right;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header a {
	display: none;
}
<?php } else { ?>
#header a {
	color:#<?php header_textcolor() ?>;
}
<?php } ?>
</style>
<?php
}

function rubric_admin_header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) no-repeat top right;
	width: 550px;
	height: 160px;
	font-family: Georgia;
	font-weight: normal;
}
#header h1{
font-size: 32px;
font-weight: normal;
padding-top: 20px;
text-align: left;
}
#header h1 a{
	color:#<?php header_textcolor() ?>;
	text-decoration: none;
	border-bottom: none;
}

<?php if ( 'blank' == get_header_textcolor() ) : ?>
#headimg h1 {
	display: none;
}
<?php endif; ?>

</style>
<?php
}

add_custom_image_header('header_style', 'rubric_admin_header_style');

if ( function_exists('register_sidebars') )
	register_sidebars(1);

?>
