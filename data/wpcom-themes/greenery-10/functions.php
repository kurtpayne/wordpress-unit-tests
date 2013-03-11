<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '556b38',
	'link' => '95c725'
);

$content_width = 470;

if ( function_exists('register_sidebars') )
	register_sidebars(1);

?>
<?php

define('HEADER_TEXTCOLOR', '80904F');
define('HEADER_IMAGE', '%s/images/header.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 740);
define('HEADER_IMAGE_HEIGHT', 171);

function header_style() {
?>
<style type="text/css">
#header {
	background-image: url(<?php header_image() ?>);
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1 {
	display: none;
}
<?php } else { ?>
#header h1, #header h1 a, #header a:hover {
	color: #<?php header_textcolor() ?>;
}

<?php } ?>
</style>
<?php
}

function greenery_10_admin_header_style() {
?>
<style type="text/css">

#headimg {
	background: url(<?php header_image() ?>);
 	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
 	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	margin: 0 0 10px 0;
}

#headimg h1 {
	padding: 40px 0 0 20px;
	font-size: 22px;
	color: #<?php header_textcolor() ?>;
	font-family: "Trebuchet MS",Tahoma,Arial,Sans-Serif;
	text-align: left;
}

#headimg h1 a {
	color: #<?php header_textcolor() ?>;
	border-bottom: none;
}

#desc { display: none; }

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

add_custom_image_header('header_style', 'greenery_10_admin_header_style');

?>
