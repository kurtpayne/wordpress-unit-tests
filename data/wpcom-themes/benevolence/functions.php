<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => 'ff3333'
	);

$content_width = 420;

load_theme_textdomain('benevolence');

function benevolence_widgets_init() {
	register_sidebars(1);
	unregister_widget('WP_Widget_Search');
	wp_register_sidebar_widget('search', __('Search'), 'benevolence_search');
}
add_action('widgets_init', 'benevolence_widgets_init');

function benevolence_search() {
?>
<li>
	<form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
	<h2><?php _e('Search:','benevolence'); ?></h2>
	<input type="text" class="input" name="s" id="search" size="15" />
	<input name="submit" type="submit" tabindex="5" value="<?php _e('GO','benevolence'); ?>" />
	</form>
</li>
<?php
}

?>
<?php

define('HEADER_TEXTCOLOR', '000000');
define('HEADER_IMAGE', '%s/images/masthead.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 700);
define('HEADER_IMAGE_HEIGHT', 225);

function header_style() {
?>
<style type="text/css">
#masthead{
	background: url(<?php header_image() ?>) no-repeat;
}
<?php if ( 'blank' == get_theme_mod('header_textcolor', HEADER_TEXTCOLOR) ) { ?>
#blogTitle, #blogTitle a {
	display: none;
}
<?php } else { ?>
#masthead h1#blogTitle, #masthead #blogTitle a, #blogTitle a:hover {
	color: #<?php header_textcolor() ?>;
}

<?php } ?>
</style>
<?php
}

function benevolence_admin_header_style() {
?>
<style type="text/css">

#headimg {
	position: relative;
	top: 0px;
	background: url(<?php header_image() ?>);
 	width: 700px;
 	height: 225px;
	margin: 0px;
	margin-top: 0px;
}

#headimg h1 {
	position: relative;
	top: 50px;
	left: 20px;
	font-family: 'Arial Black';
	color: #<?php header_textcolor() ?>;
	font-size: 8pt;
	text-transform: uppercase;
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

add_custom_image_header('header_style', 'benevolence_admin_header_style');

?>
