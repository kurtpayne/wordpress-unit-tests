<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div <?php post_class(); ?>>
	
			<h2 class="posttitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','almost-spring'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
			<p class="postmeta"> 
			<?php the_time(get_option("date_format")); ?> <?php _e('at','almost-spring'); ?> <?php the_time() ?> 
			&#183; <?php _e('Filed under','almost-spring'); ?> <?php the_category(', ') ?>
			<?php the_tags( ' &#183;' . __( 'Tagged' ) . ' ', ', ', ''); ?>
			<?php edit_post_link(__('Edit','almost-spring'), ' &#183; ', ''); ?>
			</p>
		
			<div class="postentry">
			<?php the_content(__('Read the rest of this entry &raquo;','almost-spring')); ?>
			<?php wp_link_pages(); ?>
			</div>

			<p class="postfeedback">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','almost-spring'); ?> <?php the_title(); ?>" class="permalink"><?php _e('Permalink','almost-spring'); ?></a>
			</p>
			
		</div>
		
		<?php comments_template(); ?>
				
	<?php endwhile; else : ?>

		<h2><?php _e('Not Found','almost-spring'); ?></h2>

		<p><?php _e('Sorry, but the page you requested cannot be found.','almost-spring'); ?></p>
		
		<h3><?php _e('Search','almost-spring'); ?></h3>
		
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
