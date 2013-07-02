<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '444444',
	'link' => '1c9bdc'
);

$content_width=500;

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/books.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 770);
define('HEADER_IMAGE_HEIGHT', 200);
define( 'NO_HEADER_TEXT', true );

function pressrow_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}
</style>
<?php
}

function header_style() {
?>
<style type="text/css">
#pic { background: url(<?php header_image() ?>) no-repeat; }
</style>
<?php
}

add_custom_image_header('header_style', 'pressrow_admin_header_style');

function widget_pressrow_search($args) {
	extract($args);
	if ( empty($title) )
		$title = __('Search');
?>

		<?php echo $before_widget ?>
			<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
				<div class="sidebar_section">
					<form id="search_form" method="get" action="<?php bloginfo('home') ?>">
					<input id="s" name="s" class="text_input" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="10" />
					<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find &raquo;') ?>" />
					</form>
				</div>
		<?php echo $after_widget ?>

<?php
}

function pressrow_widgets_init() {
	register_sidebars(1);
	unregister_widget('WP_Widget_Search');
	wp_register_sidebar_widget('Search', __('Search'), 'widget_pressrow_search');
}
add_action('widgets_init', 'pressrow_widgets_init');

?>
