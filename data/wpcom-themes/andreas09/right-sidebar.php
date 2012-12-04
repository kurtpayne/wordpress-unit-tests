<!-- Right Sidebar Template -->
<div id="rightside">
	<ul>
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('right-sidebar') ) : ?>
		</ul>
	</div>
	<?php return; endif; ?>

		<li><?php include (TEMPLATEPATH . '/searchform.php'); ?></li>
</ul>
<ul>
 <?php wp_list_bookmarks(); ?>
</ul>
<ul>
 <li><h2><?php _e('Meta','andreas09'); ?></h2>
  <ul>
   <?php wp_register(); ?>
   <li><?php wp_loginout(); ?></li>
   <?php wp_meta(); ?>
  </ul>
 </li>
</ul>
<ul>
 <li><h2><?php _e('Subscribe','andreas09'); ?></h2>
  <ul>
   <li class="feed"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)','andreas09'); ?></a></li>
   <li class="feed"><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)','andreas09'); ?></a></li>
  </ul>
 </li>
</ul>
</div>
