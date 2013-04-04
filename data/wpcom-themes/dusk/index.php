<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h2 class="posttitle"><a href="<?php the_permalink() ?>" title="<?php _e('Permanent link to'); ?><?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<p class="commentmeta">
					<?php the_time(get_option('date_format')) ?> at <?php the_time() ?> 
					(<?php the_category(', ') ?>)
					<?php the_tags( ' (', ', ', ') '); ?>
					<?php edit_post_link(__('Edit'),' &#183; ',''); ?>
				</p>
				<?php if (is_search()) { ?>
					<?php the_excerpt(); ?>
				<?php } else { ?>
					<?php the_content(__('Read the rest of this entry &raquo;')); ?>
				<?php } ?>
				<p class="postfeedback">
					<a href="<?php the_permalink() ?>" title="<?php _e('Permanent link to'); ?>"><?php _e('Permalink'); ?></a>
					<?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?>
				</p>
			</div>
	
		<?php endwhile; ?>

		<p style="text-align:center;">
			<?php posts_nav_link(' &#183; ', __('&laquo; Previous page'), __('Next page &raquo;')); ?>
		</p>
		
	<?php else : ?>

		<h2 class="pagetitle"><?php _e('Search Results'); ?></h2>
		<p><?php _e('Sorry, but no posts matched your criteria.'); ?></p>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
