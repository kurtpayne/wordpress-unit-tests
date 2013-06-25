<?php get_header(); ?>

	<div id="content_box">
	
		<div id="content" class="posts">

		<?php if (have_posts()) : ?>
			
			<?php while (have_posts()) : the_post(); ?>
					
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','cutline'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
			<h4><?php the_time(get_option('date_format')) ?><!-- by <?php the_author() ?> --> &middot; <?php comments_popup_link(__('Leave a Comment','cutline'), __('1 Comment','cutline'), __('% Comments','cutline')); ?></h4>
			<div class="entry">
				<?php the_content(__('Keep reading &rarr;','cutline')); ?>
			</div>	
			<p class="tagged"><span class="add_comment"><?php comments_popup_link(__('&rarr; Leave a Comment','cutline'), __('&rarr; 1 Comment','cutline'), __('&rarr; % Comments','cutline')); ?></span><strong><?php _e('Categories:','cutline'); ?></strong> <?php the_category(' &middot; ') ?>
			<?php the_tags( '<br /><strong>' . __( 'Tagged:','cutline' ) . '</strong> ', ', ', ''); ?></p>

			</div>
		
			<?php endwhile; ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>
			
		<?php else : ?>
	
			<h2 class="page_header center"><?php _e('Not Found','cutline'); ?></h2>
			<div class="entry">
			<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.','cutline'); ?></p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			</div>
	
		<?php endif; ?>
		</div>

		<?php get_sidebar(); ?>
	
	</div>

<?php get_footer(); ?>
