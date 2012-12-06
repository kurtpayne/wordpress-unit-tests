<div id="sidebar">

	<ul class="sidebar-list">
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
		<li>
		<h2><?php _e('Search It!'); ?></h2>
			<div class="sidebar_section">
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
		</li>
		<li>
		<h2><?php _e('Feed It!'); ?></h2>
			<div class="sidebar_section">
				<p class="center"><a href="<?php bloginfo_rss('rss2_url'); ?>"><img class="off" src="<?php bloginfo('template_url'); ?>/images/icon_feed.gif" width="32" height="32" alt="Grab this site's feed!" /></a></p>
				<p class="center"><a href="<?php bloginfo_rss('rss2_url'); ?>"><?php _e('Subscribe to this site!'); ?></a></p>
			</div>
		</li>
		<li>
		<h2><?php _e('Recent Entries'); ?></h2>
			<div class="sidebar_section">
				<ul>
					<?php query_posts('showposts=8'); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a><span class="quick_date"><?php the_time('m.j') ?></span></li>
					<?php endwhile; endif; ?>
				</ul>
			</div>
		</li>
		<li>
			<h2>Links</h2>
			<div class="sidebar_section">
				<ul>
					<?php wp_list_bookmarks(); ?>
				</ul>
			</div>
		</li>
<?php endif; ?>
	</ul>
</div>
