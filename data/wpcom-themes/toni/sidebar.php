
<!-- begin sidebar -->
<div id="menu">

<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
</ul>
</div>
<?php return; endif; ?>
	<?php wp_list_pages(); ?>
	<?php wp_list_bookmarks(); ?>
 <li id="categories"><?php _e('Categories:'); ?>
	<ul>
	<?php wp_list_cats(); ?>
	</ul>
 </li>
 <li id="search">
   <label for="s"><?php _e('Search:'); ?></label>	
   <form id="searchform" method="get" action="<?php bloginfo('home'); ?>/">
	<div>
		<input type="text" name="s" id="s" size="15" /><br />
		<input type="submit" value="<?php _e('Search'); ?>" />
	</div>
	</form>
 </li>
 <li id="archives"><?php _e('Archives:'); ?>
 	<ul>
	 <?php wp_get_archives('type=monthly'); ?>
 	</ul>
 </li>
 <li id="meta"><?php _e('Meta:'); ?>
 	<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
		<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
		<li><a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a></li>
		<?php wp_meta(); ?>
	</ul>
 </li>

</ul>

</div>
<!-- end sidebar -->
