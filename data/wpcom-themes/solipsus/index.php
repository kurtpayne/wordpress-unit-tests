<?php get_header(); ?>

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
		
			<div <?php post_class(); ?>>
	
				<h2 class="posttitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
				<p class="postmeta"> 
				{ <?php the_time(get_option('date_format')) ?> @ <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_time() ?></a> }
				&#183; 
				{ <?php the_category(', ') ?> }
				<br />
				{ <?php the_tags('Tags: ', ', ', ''); ?> }
				&#183; 
				{ <?php comments_popup_link(__('Leave a Comment'), __('Comments (1)'), __('Comments (%)'), 'commentslink', __('Comments off')); ?> }
				</p>
			
				<div class="postentry">
				<?php the_content("... continue reading this entry."); ?>
				</div>
			
				<p class="postfeedback">
				<?php edit_post_link(__('Edit'), '&nbsp; {', '}'); ?>
				</p>
			
			</div>
				
		<?php endwhile; ?>

		<?php posts_nav_link(' &#183; ', __('Newer entries &raquo;'), __('&laquo; Older entries')); ?>
		
	<?php else : ?>

		<h2><?php _e('Not Found'); ?></h2>

		<p><?php _e('Sorry, but the page you requested cannot be found.'); ?></p>
		
		<h3><?php _e('Search'); ?></h3>
		
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
