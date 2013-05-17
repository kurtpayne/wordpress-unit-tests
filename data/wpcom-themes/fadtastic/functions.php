<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '80ae14'
);

$content_width = 544;

function widget_fadtastic_links() {
	wp_list_bookmarks(array('title_before'=>'<h3>', 'title_after'=>'</h3>', 'show_images'=>true));
}

function fadtastic_widget_init() {
	register_sidebar(array('before_title' => "<h3 class='widgettitle'>", 'after_title' => "</h3>", 'name' => 'Sidebar 1', 'id' => 'main-sidebar'));
	register_sidebar(array('before_title' => "<h3 class='widgettitle'>", 'after_title' => "</h3>", 'name' => 'Sidebar 2', 'id' => 'bottom-bar'));
	unregister_widget('WP_Widget_Links');
	wp_register_sidebar_widget('links', __('Links', 'sandbox'), 'widget_fadtastic_links');
}
add_action('widgets_init', 'fadtastic_widget_init');

?>
