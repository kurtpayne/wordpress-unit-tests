<!-- Start Sidebar -->

	<div class="sidebar">
<ul>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>

	<li><h2><?php _e('Calendar', 'digg3'); ?></h2>
		<ul>
			<li><?php get_calendar(); ?></li>
		</ul>
	</li>

	<?php wp_list_bookmarks(); ?>

	<?php wp_meta(); ?>

<?php endif; ?>

</ul>
	</div>

<!-- End Sidebar -->
