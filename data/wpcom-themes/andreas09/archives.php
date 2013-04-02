<?php
/*
Template Name: Archives List
*/
?>

<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

<div id="content">
	<div id="page">
		<div class="archives">
			<h1><?php the_title(); ?></h1>
			<h2 id="months"><?php _e('Archives by Month:','andreas09'); ?></h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
			<h2 id="categories"><?php _e('Archives by Category:','andreas09'); ?></h2>
			<ul>
				<?php wp_list_cats(); ?>
			</ul>
		</div>
	</div>
	<?php edit_post_link(__('Edit this entry.','andreas09'), '<p>', '</p>'); ?>
</div>

<?php get_footer(); ?>
