</div>

<div id="sidebar">

<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
	<?php wp_list_pages('title_li=<h2>' . __('Pages','almost-spring') . '</h2>' ); ?>
	<li>
		<h2><?php _e('Archives','almost-spring'); ?></h2>
		<ul>
		<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>
	<li>
		<h2><?php _e('Categories','almost-spring'); ?></h2>
		<ul>
		<?php wp_list_cats(); ?>
		</ul>
	</li>
	<li>
		<h2><?php _e('Search','almost-spring'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>


	<?php if ( is_home() ) { wp_list_bookmarks(); } ?>

	<li>
		<h2><?php _e('Meta','almost-spring'); ?></h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0','almost-spring'); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>','almost-spring'); ?></a></li>
			<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS','almost-spring'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>','almost-spring'); ?></a></li>
			<li><a href="http://<?php _e('wordpress.com','almost-spring'); ?>/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.','almost-spring'); ?>"><?php _e('WordPress.com','almost-spring'); ?></a></li>
			<?php wp_meta(); ?>
		</ul>
<?php endif; ?>
	</li>
</ul>

</div>
