<div id="footer">
<div id="footer_box">
	<p>
		<a href="http://wordpress.org/" rel="generator">Powered by WordPress</a></p>
	<p><?php _e('Theme:'); ?> <strong>DePo Square</strong> <?php _e('by'); ?> <a href="http://powazek.com" rel="designer">Derek Powazek</a></p>
	<p class="rss">
		<a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/i/depo-rss.png" alt="rss" /></a><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('RSS Feed', 'depo-squared') ?></a>
	</p>
</div>
<p class="archives">

<?php 
	_e('View more by category:');
	$variable = wp_list_categories('echo=0&show_count=1&title_li=&style=none&number=10&orderby=count&order=desc');
	$variable = str_replace('<br />', ', ', trim($variable));
	echo ' ' . rtrim($variable,', ') . '. ';

	$last_post_date = get_lastpostdate('blog');
	_e('Or by month:'); ?> <a href="<?php bloginfo('url'); ?>/<?php echo mysql2date('Y/m', $last_post_date); ?>/"><?php echo mysql2date('F Y', $last_post_date); ?></a>.
	<?php _e('Or visit the'); ?> <a href="<?php bloginfo('url'); ?>/<?php echo mysql2date('Y', $last_post_date); ?>/"><?php _e('Complete Archive'); ?></a>.</p>
	
</div>
<!-- content -->
</div>
<!-- rap -->
</div>
<?php wp_footer(); ?>
</body>
</html>
