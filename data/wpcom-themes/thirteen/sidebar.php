<div id="sidebar">

<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : ?>
<?php else : ?>
	<li>
		<h2><?php _e('Search'); ?></h2>
		<form method="get" action="/">
		<p>
		<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" />
		<input type="submit" class="submit" value="Search" />
		</p>
		</form>
	</li>
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
	<?php if (is_home()) { ?>			
		<?php wp_list_bookmarks(); ?>
	<?php } ?>
	<li>
		<h2><?php _e('Meta'); ?></h2>
		<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
		<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
		<?php wp_meta(); ?>
		</ul>
	</li>
<?php endif; ?>

</ul>

</div>

