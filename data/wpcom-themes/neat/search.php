<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>
		
		<div class="navigation" style="text-align: center;">
			<?php posts_nav_link(' &#183; ', __('&laquo; Newer Entries'), __('Older Entries &raquo;')); ?>
		</div>

		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?>>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/<?php echo 'rtl' == get_bloginfo( 'text_direction' ) ? 'h1-rtl.gif' : 'h1.gif'; ?>" class="lefth2img" alt="h1" /><h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time(get_option('date_format')) ?></small>
				
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
		
				<p class="postmetadata"><?php printf(__('Posted in %s'), get_the_category_list(', ')); ?> <strong>|</strong> <?php the_tags( __('Tagged').' ', ', ', ' <strong>|</strong> '); ?><?php edit_post_link(__('Edit'),'','<strong>|</strong>'); ?>  <?php comments_popup_link(__('Leave a Comment &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></p> 

			</div>
	
		<?php endwhile; ?>

		<div class="navigation" style="text-align: center;">
			<?php posts_nav_link(' &#183; ', __('&laquo; Newer Entries'), __('Older Entries &raquo;')); ?>
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found.'); ?></h2>
		&nbsp;<?php _e('Search something maybe?'); ?> <?php include (TEMPLATEPATH . '/searchform.php'); ?>


	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
