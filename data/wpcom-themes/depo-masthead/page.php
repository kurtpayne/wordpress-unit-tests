<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); 
		if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts);  ?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<h2 class="page"><?php the_title(); ?></h2>

				<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;', 'depo-masthead'); ?>
				<?php wp_link_pages(); ?>
				<?php edit_post_link(__('Edit this entry.', 'depo-masthead'), '<p>', '</p>'); ?>
				</div>
			</div>

			<?php comments_template(); ?>
					
	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.', 'depo-masthead'); ?></p>

	<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
