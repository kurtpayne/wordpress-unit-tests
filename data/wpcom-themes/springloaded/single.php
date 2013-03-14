<?php get_header() ?>

<div id="single-content">

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
			<div class="clear"></div>
		</div>
		
			<p class="post-date" title="<?php printf(__('%1$s at %2$s'), get_the_time(get_option('date_format')), get_the_time(get_option('time_format'))); ?>">
				<span class="date-day"><?php the_time('j') ?></span>
				<span class="date-month"><?php the_time('M') ?></span>
			</p>
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), attribute_escape(get_the_title())); ?>"><?php the_title(); ?></a></h2>
			<p class="metadata">
			<?php printf(__('Posted by %1$s in %2$s.'), get_the_author(), get_the_category_list(', ')); ?>
			<?php the_tags(__('Tagged: ', 'sandbox'), ", ", "."); ?>
			<span class="feedback"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></span><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>
			<div class="entry">
				<?php the_content('<span class="more-link">'.__('Continue reading', 'springloaded').'</span>'); ?>
				<?php wp_link_pages('<p>','</p>') ?>
			</div>
		</div>
		
		<?php comments_template() ?>
	
	<?php endwhile; else : ?>
	<div <?php post_class(); ?>>
		<h2 class="center"><?php _e('Not Found'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	</div>

<?php endif; ?>

</div><!-- /content -->

</div><!-- /main -->

<?php get_sidebar() ?>

<?php get_footer() ?>
