<?php get_header(); ?>

	<div id="primary">
	<div class="inside">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	
		<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
		<br class="clear" />
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

	<?php endwhile; endif; ?>
	</div>
	</div>

	<hr class="hide" />
	<div id="secondary">
		<div class="inside">
			<?php comments_template(); ?>
	</div>
	</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
