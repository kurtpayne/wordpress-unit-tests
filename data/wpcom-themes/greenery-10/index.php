<?php get_header(); ?>

<?php is_tag(); ?>
	<?php if (have_posts()) : ?>
	
		<?php $post = $posts[0]; // Thanks Kubrick for this code ?>
		
		<?php if (is_category()) { ?>				
		<h2><?php _e('Archive for'); ?> <?php single_cat_title(); ?></h2>
		
 	  	<?php } elseif (is_tag()) { ?>
		<h2><?php _e('Posts tagged'); ?> <?php single_tag_title(); ?></h2>

 	  	<?php } elseif (is_day()) { ?>
		<h2><?php _e('Archive for'); ?> <?php the_time('F j, Y'); ?></h2>
		
	 	<?php } elseif (is_month()) { ?>
		<h2><?php _e('Archive for'); ?> <?php the_time('F, Y'); ?></h2>

		<?php } elseif (is_year()) { ?>
		<h2><?php _e('Archive for'); ?> <?php the_time('Y'); ?></h2>

		<?php } elseif (is_author()) { ?>
		<h2><?php _e('Author Archive'); ?></h2>

		<?php } elseif (is_search()) { ?>
		<h2><?php _e('Search Results'); ?></h2>

		<?php } ?>
				
		<?php while (have_posts()) : the_post(); ?>
		
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	
				<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
				<p class="postmeta"> 
				<?php the_time(get_option('date_format')) ?> <?php //_e('at'); ?> <?php //the_time() ?> 
				&#183; <?php _e('Filed under'); ?> <?php the_category(', ') ?>
				<?php if (is_callable('the_tags')) the_tags('&#183 Tagged ', ', '); ?>
				<?php edit_post_link(__('Edit'), ' &#183; ', ''); ?>
				</p>
			
				<div class="postentry">
				<?php if (is_search()) { ?>
					<?php the_excerpt() ?>
				<?php } else { ?>
					<?php the_content(__('Read the rest of this entry &raquo;')); ?>
				<?php } ?>
				</div>

				<p class="postfeedback">
				<?php comments_popup_link(__('Leave a comment &raquo;'), __('Comments (1) &raquo;'), __('Comments (%) &raquo;'), 'commentslink', __('Comments off')); ?>
				</p>
			</div>
				
		<?php endwhile; ?>

			<!-- Page Navigation -->
			<div class="pagenav">
				<div class="alignleft"><?php posts_nav_link('', '', __('&laquo; Previous entries')); ?></div>
					<?php // posts_nav_link(' &#183; ', '', ''); ?>
				<div class="alignright"><?php posts_nav_link('', __('Next entries &raquo;'), ''); ?></div>
			</div>


	<?php else : ?>

		<h2><?php _e('404 Not Found'); ?></h2>

		<p><?php _e('Oops...! What you requested cannot be found.'); ?></p>

	<?php endif; ?>
		

<?php get_sidebar(); ?>

<?php get_footer(); ?>
