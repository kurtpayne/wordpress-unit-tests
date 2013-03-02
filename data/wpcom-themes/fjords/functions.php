<?php
if ( function_exists('register_sidebars') )
    register_sidebars(3);

function resize_youtube( $content ) {
	return str_replace( "width='425' height='350'></embed>", "width='240' height='197'></embed>", $content );
}
add_filter( 'the_content', 'resize_youtube', 999 );

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '888888',
	'link' => '8AB459'
);

$content_width = 270;

define('HEADER_TEXTCOLOR', 'ffffff');
define('HEADER_IMAGE', '%s/imagenes_qwilm/beach.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 900);
define('HEADER_IMAGE_HEIGHT', 200);

function header_style() {
?>
<style type="text/css">
#content, #sidebar-1, #sidebar-2, #sidebar-3  {
	background-image:url(<?php header_image() ?>);
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#hode h4, #hode span {
	display: none;
}
<?php } else { ?>
#hode a, #hode {
	color: #<?php header_textcolor() ?>;
}	
<?php } ?>
</style>
<?php
}

function admin_header_style() {
?>

<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1 {
font-family: "Lucida Grande",Tahoma,Arial,sans-serif;
font-size: 17px;
font-weight: bold;
margin-left: 15px;
padding-top: 15px;
}
#headimg h1 a {
	color:#<?php header_textcolor() ?>;
	border: none;
	text-decoration: none;
}
#headimg a:hover
{
	text-decoration:underline;
}
#headimg #desc
{
	font-weight:normal;
	color:#<?php header_textcolor() ?>;
	margin-left: 15px;
	padding: 0;
	margin-top: -10px;
font-family: "Lucida Grande",Tahoma,Arial,sans-serif;
	font-size: 11px;
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

<?php }

add_custom_image_header('header_style', 'admin_header_style');

?>