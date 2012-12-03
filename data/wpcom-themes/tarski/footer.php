</div>

<div id="footer">

	<div id="miscellany">
	
	<?php if (function_exists('dynamic_sidebar')) { echo "<div class=\"widgets\">\n"; } ?>

	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widgets')) :  // Footer widgets ?>

		<?php if (!is_search()) { include (TEMPLATEPATH . "/searchform.php"); } ?>

	<?php endif; // end widgets if ?>
	
	<?php if (function_exists('dynamic_sidebar')) { echo "</div>\n"; } ?>

	</div>


	<div id="about">
		<div class="navigation">
		<?php $_SERVER['REQUEST_URI']  = preg_replace("/(.*?).php(.*?)&(.*?)&(.*?)&_=/","$2$3",$_SERVER['REQUEST_URI']); ?>
			<div class="left"><?php next_posts_link('<span>&laquo;</span> '.__('Previous Entries','').''); ?></div>
			<div class="right"><?php previous_posts_link(''.__('Next Entries','').' <span>&raquo;</span>'); ?></div>
		</div>		
	</div>


	<div id="theme-info">
		<div class="primary content">
			<p> <a href="http://tarskitheme.com/">Theme by Ben Eastaugh and Chris Sternal-Johnson.</a> Get a free blog at <a href="http://wordpress.com/">WordPress.com</a>.</p>
		</div>
		<div class="secondary">
			<p><a class="feed" title="Subscribe to the <?php bloginfo('name'); ?> feed" href="<?php echo get_bloginfo_rss('rss2_url'); ?>">Subscribe to feed.</a></p>
		</div>
	</div>

</div>

</div><?php wp_footer(); ?></body></html>
