<div id="sidebar">
	<ul class="sidebar_list">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar()) : ?>
		<li class="widget">
		<h2><?php _e('Search It!'); ?></h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</li>
		<li class="widget">
		<h2><?php _e('Recent Entries','cutline'); ?></h2>
			<ul>
				<?php query_posts('showposts=10'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a><span class="recent_date"><?php the_time('n.j') ?></span></li>
				<?php endwhile; endif; ?>
			</ul>
		</li>
		<?php if (function_exists('get_flickrrss')) { ?>
		<li class="widget">
			<h2><span class="flickr_blue">Flick</span><span class="flickr_pink">r</span></h2>
			<ul class="flickr_stream">
				<?php get_flickrrss(); ?>
			</ul>
		</li>
		<?php } ?>
		<li class="widget">
		<h2><?php _e('Links','cutline'); ?></h2>
			<ul>
				<?php get_links(-1, '<li class="snap_preview">', '</li>', '', FALSE, 'name', FALSE, FALSE, -1, TRUE); ?>
			</ul>
		</li>
		<?php endif; ?>
	</ul>
</div>
