<?php get_header(); ?>

	<div id="content_box">
		
		<div id="content" class="posts">
			
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<h2><?php the_title(); ?></h2>
			<h4><?php the_time(get_option('date_format')); ?><!-- by <?php the_author() ?> --> &middot; <a href="<?php the_permalink() ?>#comments"><?php comments_number(__('Leave a Comment','cutline'), __('1 Comment','cutline'), __('% Comments','cutline')); ?></a><?php edit_post_link(__('Edit This'), ' &middot;  '); ?></h4>
			<div class="entry">
				<?php the_content('<p>'.__('Read the rest of this entry &raquo;','cutline').'</p>'); ?>
				<?php link_pages('<p><strong>'.__('Pages:','cutline').'</strong> ', '</p>', 'number'); ?>
			</div>
			<?php if ( !is_attachment() ) { ?><p class="tagged"><strong><?php _e('Categories:','cutline'); ?></strong> <?php the_category(' &middot; ') ?> <?php the_tags( '<br /><strong>' . __( 'Tagged:','cutline' ) . '</strong> ', ', ', ''); ?></p><?php } ?>

			</div>
			
			<?php comments_template(); ?>
			
		<?php endwhile; else: ?>
		
			<h2 class="page_header"><?php _e('Uh oh.','cutline'); ?></h2>
			<div class="entry">
			<p><?php _e('Sorry, no posts matched your criteria. Wanna search instead?','cutline'); ?></p>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			
		<?php endif; ?>
		
		</div>
		
		<?php get_sidebar(); ?>
			
	</div>

<?php get_footer(); ?>
