</div><!-- end MAIN -->
</div><!-- end CONTENT -->

<?php get_sidebar(); ?>

<div id="clearer">&nbsp;</div>
<div id="footer">


	 <div id="footertop">
	 <img src="<?php bloginfo('template_directory'); ?>/img/ftl.gif" alt="" 
	 width="15" height="15" class="corner" 
	 style="display: none" />
	 </div>




		<div id="footercontent">

				<div class="credit">
				<a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a>
				Theme: Rounded by <a href='http://www.release.fr'>Release</a>.
		</div><!-- close footer content-->

				<!-- SITE CREDITS -->
				<div class="footermeta">

					<span class="rss"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></span>
						<a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a>
					
						

						<a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a>
						<a href="http://wordpress.com/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>"><abbr title="WordPress">WP</abbr></a>
						<?php wp_meta(); ?>
						
					</div>

		</div><!-- end footercontent-->



<div id="footerbottom">
				 <img src="<?php bloginfo('template_directory'); ?>/img/fbl.gif" alt="" 
				 width="15" height="15" class="corner" 
				 style="display: none" />
			   </div>



</div><!-- end FOOTER -->
</div><!-- end RAP -->

<?php do_action('wp_footer'); ?>
</body>
</html>
