<?php get_header() ?>

<div id="content">

<?php if (have_posts()) : ?>
 	  <h2 class="pagetitle"><?php _e('Search Results'); ?></h2>

	<?php while (have_posts()) : the_post(); ?>

		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<p class="post-date" title="<?php printf(__('%1$s at %2$s'), get_the_time(get_option('date_format')), get_the_time(get_option('time_format'))); ?>">
				<span class="date-day"><?php the_time('j') ?></span>
				<span class="date-month"><?php the_time('M') ?></span>
			</p>
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), attribute_escape(get_the_title())); ?>"><?php the_title(); ?></a></h3>
			<p class="metadata">
			<?php printf(__('Posted by %1$s in %2$s.'), get_the_author(), get_the_category_list(', ')); ?>
			<?php the_tags(__('Tagged: ', 'sandbox'), ", ", "."); ?>
			<span class="feedback"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></span><?php edit_post_link('Edit', ' | ', ''); ?></p>
			<div class="entry">
				<?php the_excerpt('<span class="more-link">'.__('Continue reading', 'springloaded').'</span>'); ?>
			</div>
		</div>

	<?php endwhile; ?>
	
		<div class="prev-next">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries')); ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;')); ?></div>
		</div>

<?php else : ?>
	<div <?php post_class(); ?>>
		<h2><?php _e('Not Found'); ?></h2>
		<div class="post">
			<div class="entry">
		<p><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
		</div></div>
	</div>

<?php endif; ?>

</div><!-- /content -->

</div><!-- /main -->

<?php get_sidebar() ?>

<?php get_footer() ?>
