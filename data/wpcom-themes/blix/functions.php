<?php
include (TEMPLATEPATH . '/BX_functions.php');

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '6C8C37'
	);

$content_width = 455;

function widget_blix_categories() {
?>
	<h2><em><?php _e('Categories'); ?></em></h2>

	<ul class="categories">
	<?php wp_list_cats('sort_column=name'); ?>
	</ul>
<?php
}

function widget_blix_feeds() {
?>
	<h2><em><?php _e('Feeds'); ?></em></h2>

	<ul class="feeds">
	<li><a href="<?php bloginfo_rss('rss2_url'); ?> ">Entries (RSS)</a></li>
	<li><a href="<?php bloginfo_rss('comments_rss2_url'); ?> ">Comments (RSS)</a></li>
	</ul>
<?php
}

function widget_blix_recent_posts($args) {
	extract($args);
	$options = get_option('widget_recent_entries');
	$title = empty($options['title']) ? __('Recent Posts') : $options['title'];
	if ( !$number = (int) $options['number'] )
		$number = 10;
	else if ( $number < 1 )
		$number = 1;
	else if ( $number > 15 )
		$number = 15;
?>
	<h2><em><?php _e($title); ?></em></h2>

	<ul class="posts">
	<?php BX_get_recent_posts($p, $number); ?>
	</ul>
<?php
}

register_sidebars(1, array(
	'before_widget' => "\n",
	'after_widget' => "\n",
	'before_title' => '<h2><em>',
	'after_title' => '</em></h2>',
));

wp_register_sidebar_widget('categories', __('Categories'), 'widget_blix_categories');
unregister_widget_control('categories');
wp_register_sidebar_widget('feeds', __('Feeds'), 'widget_blix_feeds');
wp_register_sidebar_widget('recent-posts', __('Recent Posts'), 'widget_blix_recent_posts');
unregister_widget_control('recent-posts');

define('HEADER_TEXTCOLOR', '009193');
define('HEADER_IMAGE', '%s/images/spring_flavour/header_bg.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 690);
define('HEADER_IMAGE_HEIGHT', 115);

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

function blix_admin_header_style() {
?>
<style type="text/css">
#headimg{
	background: url(<?php header_image() ?>) no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
  padding:0 0 0 18px;
}

#headimg h1{
	padding-top:40px;
	margin: 0;
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

#desc {
	display: none;
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

add_custom_image_header('header_style', 'blix_admin_header_style');

?>
