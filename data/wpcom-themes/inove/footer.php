	</div>
	<!-- main END -->

	<?php
		$options = get_option('inove_options');
		global $inove_nosidebar;
		if(!$options['nosidebar'] && !$inove_nosidebar) {
			get_sidebar();
		}
	?>
	<div class="fixed"></div>
</div>
<!-- content END -->

<!-- footer START -->
<div id="footer">
	<a id="gotop" href="#" onclick="MGJS.goTop();return false;"><?php _e('Top', 'inove'); ?></a>
	<a id="powered" href="http://wordpress.com/">WordPress</a>
	<div id="copyright">
		<?php
			$copyright = wp_cache_get('inove-copyright');
			if ( false == $copyright ) {
				global $wpdb;
				$post_datetimes = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS firstyear, YEAR(max(post_date_gmt)) AS lastyear FROM $wpdb->posts WHERE post_date_gmt > 1970");
				if ($post_datetimes) {
					$firstpost_year = $post_datetimes[0]->firstyear;
					$lastpost_year = $post_datetimes[0]->lastyear;

					$copyright = __('Copyright &copy; ', 'inove') . $firstpost_year;
					if($firstpost_year != $lastpost_year) {
						$copyright .= '-'. $lastpost_year;
					}
					$copyright .= ' ';

				}

				wp_cache_set('inove-copyright', $copyright, 'theme', 21600); //cache for 6 hours
			}

			echo $copyright;
			bloginfo('name');
		?>
	</div>
	<div id="themeinfo">
		<?php _e('Theme by <a href="http://www.neoease.com/">NeoEase</a>. Valid <a href="http://validator.w3.org/check?uri=referer">XHTML 1.1</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS 3</a>.', 'inove'); ?>
	</div>
</div>
<!-- footer END -->

</div>
<!-- container END -->
</div>
<!-- wrap END -->

<?php wp_footer(); ?>

</body>
</html>
