			<?php if(!is_archive()) :?>
				<div id="sidebar">
				<ul>
					<?php 	/* Widgetized sidebar, if you have the plugin installed. */
							if (!function_exists('dynamic_sidebar') || !dynamic_sidebar() ) { } ?>
				</ul>
			</div>
			<?php endif; ?>
			<div id="footer">
			<?php get_sidebar(); ?>
			<!-- If you'd like to support WordPress, having the "powered by" link somewhere on your blog is the best way; it's our only promotion or advertising. -->
			<p class="info">
					<a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss.png" alt="RSS" /></a>
					<a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a>
				<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
			</p>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
	
		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
