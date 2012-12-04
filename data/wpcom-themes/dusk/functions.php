<?php

$themecolors = array(
	'bg' => 'eeeae8',
	'text' => '000000',
	'link' => '497ca7',
	'border' => 'eeeae8'
);

$content_width = 495;

register_sidebars(1);

function dusk_widgets_init() {
	unregister_widget('WP_Widget_Search');
	register_sidebar_widget('Search', 'dusk_search', null, 'search');
}
add_action('widgets_init', 'dusk_widgets_init');

function dusk_search() {
?>
<li>
	<form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
	<h2>Search:</h2>
	<p><input type="text" class="input" name="s" id="search" size="15" />
	<input name="submit" type="submit" value="<?php _e('GO'); ?>" /></p>
	</form>
</li>
<?php
}

?>
