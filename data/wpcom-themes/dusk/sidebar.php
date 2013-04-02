<div id="sidebar">
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
</ul>
</div>
<?php return; endif; ?>
	<?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>
	<li><h2><?php _e('Archives'); ?></h2>
		<ul>
		<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>
	<li><h2><?php _e('Categories'); ?></h2>
		<ul>
		<?php wp_list_cats(); ?>
		</ul>
	</li>
	<?php if (function_exists('wp_theme_switcher')) { ?>
	<li>
		<h2><?php _e('Themes'); ?></h2>
		<?php wp_theme_switcher(); ?>
	</li>
	<?php } ?>
	<li>
		<h2><?php _e('Search'); ?></h2>
		<form method="get" action="<?php bloginfo('home'); ?>/">
			<p>
			<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" />
			<input type="submit" value="<?php _e('Go'); ?>" />
			</p>
		</form>
	</li>
	<?php if (is_home()) { ?>				
	<?php wp_list_bookmarks(); ?>
	<?php } ?>
	<li><h2><?php _e('Meta'); ?></h2>
		<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> Feed'); ?></a></li>
		<li><a href="http://wordpress.com/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress.com</a></li>
		<?php wp_meta(); ?>
		</ul>
	</li>
</ul>
</div>

