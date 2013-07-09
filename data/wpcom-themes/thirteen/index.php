<?php get_header(); ?>

<div id="content">

<?php is_tag(); ?>
	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
		
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
				<p class="postdate">
					<?php the_time(get_option('date_format')) ?> <?php _e('at'); ?> <?php the_time() ?>
					(<?php the_category(', ') ?>)
					<?php edit_post_link(__('Edit'),' &#183; ',''); ?>
					<br />
					<?php the_tags('Tags: ', ', ', '<br />'); ?>
				</p>
				
				<div class="postentry">
					<?php the_content(__('Read the rest of this entry &raquo;')); ?>
				</div>
				
				<p class="postmeta">
					<?php comments_popup_link(__('Leave a Comment', 'thirteen'), __('1 Comment', 'thirteen'), __('% Comments', 'thirteen')); ?>
				</p>
			</div>
	
		<?php endwhile; ?>

		<p>
			<?php next_posts_link(__('&laquo; Older entries')); ?>
			<?php previous_posts_link(__('Newer entries &raquo;')); ?>
		</p>
		
	<?php else : ?>

		<h2 class="posttitle"><?php _e('Not Found'); ?></h2>
		<p><?php _e('Sorry, but no posts matched your criteria.'); ?></p>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
