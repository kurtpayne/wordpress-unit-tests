</div>
<div id="sidebar-1" class="sidebar">
<ul>
	 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

	<?php wp_list_pages('title_li=<h2>' . __('Pages') . '</h2>' ); ?>
	
	<li>
		<h2><?php _e('Archives'); ?></h2>
		<ul>
		<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>
	
	<li>
		<h2><?php _e('Categories'); ?></h2>
		<ul>
		<?php wp_list_cats(); ?> 
		</ul>
	</li>

	<?php endif; ?>

</ul>
</div>
<div id="sidebar-2" class="sidebar">
<ul>
 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>
	<li>
	<h2><?php _e('About'); ?></h2>
	<p><?php bloginfo('description'); ?></p>
	</li>

      <li>
		<h2><?php _e('Links'); ?></h2>
<?php get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
</li>

      <li>
		<h2><?php _e('Search'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>
	<?php endif; ?>
</ul>
</div>

<div id="sidebar-3" class="sidebar">
<ul>
 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : ?>
	<li>
	<h2><?php _e('Meta'); ?></h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0'); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<?php wp_meta(); ?>
		</ul>
	</li>
	<?php endif; ?>
	<li>
	<h2><?php _e('Credits'); ?></h2>
	<p><a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a> | Theme: Fjords by Peterandrej</p>
	</li>
</ul>
</div>

