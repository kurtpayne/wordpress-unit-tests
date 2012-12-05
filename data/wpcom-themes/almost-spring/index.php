<?php get_header(); ?>

	<?php if (have_posts()) : ?>
	
		<?php $post = $posts[0]; // Thanks Kubrick for this code ?>
		
		<?php if (is_category()) { ?>				
		<h2><?php _e('Archive for','almost-spring'); ?> <?php echo single_cat_title(); ?></h2>
		
 	  	<?php } elseif (is_tag()) { ?>
		<h2><?php _e('Posts Tagged','almost-spring'); ?> <?php single_tag_title(); ?></h2>
		
 	  	<?php } elseif (is_day()) { ?>
		<h2><?php _e('Archive for','almost-spring'); ?> <?php the_time('F j, Y'); ?></h2>
		
	 	<?php } elseif (is_month()) { ?>
		<h2><?php _e('Archive for','almost-spring'); ?> <?php the_time('F, Y'); ?></h2>

		<?php } elseif (is_year()) { ?>
		<h2><?php _e('Archive for','almost-spring'); ?> <?php the_time('Y'); ?></h2>

		<?php } elseif (is_author()) { ?>
		<h2><?php _e('Author Archive','almost-spring'); ?></h2>

		<?php } elseif (is_search()) { ?>
		<h2><?php _e('Search Results','almost-spring'); ?></h2>

		<?php } ?>
				
		<?php while (have_posts()) : the_post(); ?>
		
			<div <?php post_class(); ?>>
	
				<h2 class="posttitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','almost-spring'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
				<p class="postmeta"> 
				<?php the_time(get_option("date_format")); ?> <?php _e('at','almost-spring'); ?> <?php the_time() ?> 
				&#183; <?php _e('Filed under','almost-spring'); ?> <?php the_category(', ') ?>
				<?php the_tags( ' &#183;' . __( 'Tagged' ) . ' ', ', ', ''); ?>
				<?php edit_post_link(__('Edit','almost-spring'), ' &#183; ', ''); ?>
				</p>
			
				<div class="postentry">
				<?php if (is_search()) { ?>
					<?php the_excerpt() ?>
				<?php } else { ?>
					<?php the_content(__('Read the rest of this entry &raquo;','almost-spring')); ?>
				<?php } ?>
				</div>
			
				<p class="postfeedback">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','almost-spring'); ?> <?php the_title(); ?>" class="permalink"><?php _e('Permalink'); ?></a>
				<?php comments_popup_link(__('Leave a Comment','almost-spring'), __('Comments (1)','almost-spring'), __('Comments (%)','almost-spring'), 'commentslink', __('Comments off','almost-spring')); ?>
				</p>
			
			</div>
				
		<?php endwhile; ?>

		<?php posts_nav_link(' &#183; ', __('&laquo; Newer Posts','almost-spring'), __('Older Posts &raquo;','almost-spring')); ?>
		
	<?php else : ?>

		<h2><?php _e('Not Found','almost-spring'); ?></h2>

		<p><?php _e('Sorry, but no posts matched your criteria.','almost-spring'); ?></p>
		
		<h3><?php _e('Search','almost-spring'); ?></h3>
		
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
