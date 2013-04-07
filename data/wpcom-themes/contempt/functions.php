<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '333333',
	'link' => '0066cc'
	);

$content_width = 450;

define('HEADER_TEXTCOLOR', 'E5F2E9');
define('HEADER_IMAGE', '%s/images/blue_flower/head.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 750);
define('HEADER_IMAGE_HEIGHT', 140);

function header_style() {
?>
<style type="text/css">
#headerimg{
	background: url(<?php header_image() ?>) no-repeat;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1, #header .description {
	display: none;
}
<?php } else { ?>
#header h1 a, .description {
	color:#<?php header_textcolor() ?>;
}
<?php } ?>
</style>
<?php
}

function contempt_admin_header_style() {
?>
<style type="text/css">
#headimg{
	background: url(<?php header_image() ?>) no-repeat;
	background-repeat: no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
	font-family: 'Trebuchet MS','Lucida Grande',Verdana,Arial,Sans-Serif
}
#headimg h1{
font-family: 'Trebuchet MS','Lucida Grande',Verdana,Arial,Sans-Serif;
font-size: 40px;
font-weight: bold;
padding-top: 40px;
text-align: center;
margin: 0;
}
#headimg h1 a{
	color:#<?php header_textcolor() ?>;
	text-decoration: none;
	border-bottom: none;
}
#headimg #desc{
	color:#<?php header_textcolor() ?>;
font-size: 12px;
margin-top: -5px;
text-align: center;
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headimg h1, #headimg #desc {
	display: none;
}
#headimg h1 a, #headimg #desc {
	color:#<?php echo HEADER_TEXTCOLOR ?>;
}
<?php } ?>

</style>
<?php
}

add_custom_image_header('header_style', 'contempt_admin_header_style');

if ( function_exists('register_sidebars') )
	register_sidebars(1);

?>