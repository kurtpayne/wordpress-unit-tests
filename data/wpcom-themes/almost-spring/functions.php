<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => 'E58712',
	'url' =>  'E58712'
	);

$content_width = 480;

function widget_almostspring_search() {
?>
	<li>
		<h2><?php _e('Search'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>
<?php
}

register_sidebar(array(
	'before_title' => '<div><h2>',
	'after_title' => "</h2></div>\n",
));

function almostspring_widgets_init() {
	unregister_widget('WP_Widget_Search');
	wp_register_sidebar_widget('search', __('Search'), 'widget_almostspring_search');
}
add_action('widgets_init', 'almostspring_widgets_init');
