<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	
			<h2 class="posttitle"><?php the_title(); ?></h2>
			
			<p class="postmeta"> 
			<?php the_time(get_option('date_format')) ?> <?php //_e('at'); ?> <?php //the_time() ?> 
			&#183; <?php _e('Filed under'); ?> <?php the_category(', ') ?>
			<?php if (is_callable('the_tags')) the_tags('&#183 Tagged ', ', '); ?>
			<?php edit_post_link(__('Edit'), ' &#183; ', ''); ?>
			</p>
		
			<div class="postentry">
			<?php the_content(__('Read the rest of this entry &raquo;')); ?>
			<?php wp_link_pages(); ?>
			</div>
			
		</div>
		
		<?php comments_template(); ?>
				
	<?php endwhile; else : ?>

		<h2><?php _e('404 Not Found'); ?></h2>

		<p><?php _e('Oops...! What you requested cannot be found.'); ?></p>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
