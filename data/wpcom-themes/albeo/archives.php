<?php get_header(); ?>

<h2><?php _e('Archives by Month:', 'albeo'); ?></h2>
	<ul>
	 <?php wp_get_archives('type=monthly'); ?>
	</ul>

<h2><?php _e('Archives by Subject:', 'albeo'); ?></h2>
	<ul>
	 <?php wp_list_categories(); ?>
	</ul>

<?php get_footer(); ?>