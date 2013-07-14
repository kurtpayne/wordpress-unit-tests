<?php get_header(); ?>

	<div id="content">

	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
				<h2 class="pagetitle"><?php the_title(); ?></h2>
				<?php the_content(__('Read the rest of this page &raquo;')); ?>
				<?php wp_link_pages(); ?>
				<?php edit_post_link(__('Edit'), '<p>', '</p>'); ?>
			</div>

		<?php comments_template(); ?>

		<?php endwhile; endif; ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
