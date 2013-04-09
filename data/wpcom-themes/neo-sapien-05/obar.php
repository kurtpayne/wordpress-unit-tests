		<div id="obar">

	<div class="sub-obar">
<ul>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2)) : ?>
	<li><h2>Categories</h2>
	<ul>
		<?php wp_list_cats('sort_column=name&optioncount=0&children=0'); ?>
	</ul>
	</li>
	<li><h2><?php _e('Archives'); ?></h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>
	</li>

	<?php wp_list_bookmarks(); ?>
<?php endif; ?>

</ul>
	</div>

	<div class="sub-obar">
<ul>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(3)) : ?>
	<li><h2><?php _e('Calendar'); ?></h2>
	<ul>
		<li><?php get_calendar(); ?></li>
	</ul>
	</li>
	<li><h2><?php _e('Search'); ?></h2>
	<ul>
		<li><?php include(TEMPLATEPATH . '/searchform.php'); ?></li>
	</ul>
	</li>
<?php endif; ?>
	<li>
	<ul>
	<li>
	Neo-Sapian by <a href="http://wpdesigner.com/">WP Designer</a>.
	</li>
	<li><a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a></li>
	</ul>
	</li>
</ul>
	</div>

		</div>