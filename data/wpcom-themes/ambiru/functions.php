<?php

define('HEADER_TEXTCOLOR', 'E5F2E9');
define('HEADER_IMAGE', '%s/images/header.png'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 500);
define('HEADER_IMAGE_HEIGHT', 225);

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '557799'
	);

$content_width = 460;

register_sidebar( array(
	'name'          => sprintf(__('Bottom 1')),
	'id'            => 'bottom-1',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2>',
	'after_title'   => '</h2>' ) );

register_sidebar( array(
	'name'          => sprintf(__('Bottom 2')),
	'id'            => 'bottom-2',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2>',
	'after_title'   => '</h2>' ) );

function ambiru_admin_header_style() {
?>
<style type="text/css">
#headimg{
	font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
	line-height:1.5;
	background: url(<?php header_image() ?>) no-repeat;
	background-repeat: no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	text-align:right;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
	padding:30px 0;
}
#headimg h1{
	font-family: Sylfaen, Georgia, "Times New Roman", Times, serif;
	font-weight:normal;
	letter-spacing: -1px;
	margin:0;
	font-size:2em;
	margin-top:120px;
}
#headimg h1 a{
	color:#<?php header_textcolor() ?>;
	text-decoration: none;
	border-bottom: none;
}
#headimg #desc{
	color:#<?php header_textcolor() ?>;
	font-size:1em;
	margin-top:-0.5em;
}
#headimg h1, #desc{
	margin-right:30px;
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

function header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) no-repeat;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1, #header #desc {
	display: none;
}
<?php } else { ?>
#header h1 a, #desc {
	color:#<?php header_textcolor() ?>;
}
#desc {
	margin-right: 30px;
}
<?php } ?>
</style>
<?php
}

add_custom_image_header('header_style', 'ambiru_admin_header_style');

?>
