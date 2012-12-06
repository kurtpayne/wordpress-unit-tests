<?php get_header() ?>

<div id="content">

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

		<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
			<p class="post-date" title="<?php printf(__('%1$s at %2$s'), get_the_time(get_option('date_format')), get_the_time(get_option('time_format'))); ?>">
				<span class="date-day"><?php the_time('j') ?></span>
				<span class="date-month"><?php the_time('M') ?></span>
			</p>
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), attribute_escape(get_the_title())); ?>"><?php the_title(); ?></a></h2>
			<p class="metadata">
			<?php printf(__('Posted by %1$s.'), get_the_author()); ?>
			<?php edit_post_link(__('Edit'), ' | ', ''); ?></p>
			<div class="entry">
				<?php the_content('<span class="more-link">'.__('Continue reading', 'springloaded').'</span>'); ?>
				<?php wp_link_pages(); ?>
			</div>
		</div>

		<?php comments_template(); ?>

	<?php endwhile; endif; ?>

</div><!-- /content -->

</div><!-- /main -->

<?php get_sidebar() ?>

<?php get_footer() ?>
