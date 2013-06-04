<?php
define('HEADER_TEXTCOLOR', '000000');
define('HEADER_IMAGE', '%s/images/'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 920);
define('HEADER_IMAGE_HEIGHT', 180);

function vigilance_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	background:;
	overflow: hidden;
}

#headimg h1, #headimg #desc {
		font-size: 48px;
	font-weight: bold;
	line-height: 180px;
	text-align: center;
	font-family: Georgia, "Times New Roman", Times, Serif;
	margin: 0;
}
</style>
<?php
}

add_custom_image_header('header_style', 'vigilance_admin_header_style'); 

function header_style() {
$test = HEADER_IMAGE;
 if ( !strstr( get_theme_mod('header_image', HEADER_IMAGE), $test) ) { ?>
	<style type="text/css">
		#title  { margin: 0; height: 180px; vertical-align: middle; display: table-cell; width: 920px; overflow: hidden; margin-bottom: 15px; text-align: center;}
		#title { background: url(<?php header_image() ?>) no-repeat top;}
	<?php if ( 'blank' == get_theme_mod('header_textcolor', HEADER_TEXTCOLOR) ) { ?>
		h1#title, div#title {
			text-indent: -1000em !important;
		}
	<?php } else { ?>
		h1#title a, div#title a,
		h1#title a:hover, div#title a:hover {
			color: #<?php header_textcolor() ?> !important;
			font-size: 48px;
			height: 100%;
			overflow: auto; 
			text-align: center;
		}
	<?php } ?>
	</style>
<?php }
}
