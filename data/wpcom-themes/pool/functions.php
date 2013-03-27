<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '333333',
	'link' => '0b76ae'
);

$content_width = 550;

define('HEADER_TEXTCOLOR', 'FFFFFF');
define('HEADER_IMAGE', '%s/images/logo.gif'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 795);
define('HEADER_IMAGE_HEIGHT', 150);

function pool_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1 {
font-size: 30px;
letter-spacing: 0.1em;
margin: 0;
padding: 20px 0 20px 30px;
width: 300px;
}

#headimg a, #headimg a:hover {
background: transparent;
text-decoration: none;
color: #<?php header_textcolor() ?>;
border-bottom: none;
}
		
#headimg #desc {
	display: none;
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headerimg h1, #headerimg #desc {
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
#header {
	background: #8EBAFD url(<?php header_image() ?>) left repeat-y;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1 a, #header #desc {
	display: none;
}
<?php } else { ?>
#header h1 a, #header h1 a:hover, #header #desc {
	color: #<?php header_textcolor() ?>;
}	
<?php } ?>
</style>
<?php
}

add_custom_image_header('header_style', 'pool_admin_header_style');

if ( function_exists('register_sidebars') )
        register_sidebars(1);

?>
