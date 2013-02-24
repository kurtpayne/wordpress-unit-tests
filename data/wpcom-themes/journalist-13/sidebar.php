<div id="sidebar">
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>

		<?php $blogdesc = get_bloginfo('description'); 
		if ( !empty ($blogdesc) ) { ?>
		<div id="author">
			<h3><?php _e('The Author','journalist-13'); ?></h3>
			<p><?php echo $blogdesc; ?></p>
		</div>
		<?php } ?>
		
		<?php $pagelist= get_pages();
		if ( !empty ($pagelist) ) { ?>
		<div id="pages">
			<h3><?php _e('The Pages','journalist-13'); ?></h3>
			<ul>
				<?php wp_list_pages('title_li='); ?>
			</ul>
		</div>
		<?php } ?>
		
		<h3><?php _e('The Search','journalist-13'); ?></h3>
			<p class="searchinfo"><?php _e('search site archives','journalist-13'); ?></p>
			<div id="search">
				<div id="search_area">
					<form id="searchform" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div>
						<input class="searchfield" type="text" name="s" id="s" value="" title="<?php _e('Enter keyword to search','journalist-13'); ?>" />
						<input class="submit" type="submit" value="<?php _e('search','journalist-13'); ?>" title="<?php _e('Click to search archives','journalist-13'); ?>" />
                    </div>
					</form>
				</div>
			</div>
		
		<h3><?php _e('The Associates','journalist-13'); ?></h3>
			<ul>
				<?php get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
			</ul>
		
		<h3><?php _e('The Archives','journalist-13'); ?></h3>
			<ul>
		 		<?php wp_get_archives('type=monthly'); ?>
 			</ul>
		
			<h3><?php _e('The Categories','journalist-13'); ?></h3>
				<ul>
					<?php wp_list_cats(); ?>
				</ul>	
		
			<h3><?php _e('The Meta','journalist-13'); ?></h3>
				<ul>
					<li><?php // wp_register(); ?></li>
					<li><?php wp_loginout(); ?></li>
					<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS','journalist-13'); ?>">Site Feed</a></li>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS','journalist-13'); ?>"><?php _e('Comments Feed','journalist-13'); ?></a></li>
					<li><a href="#content" title="back to top"><?php _e('Back to top'); ?></a></li>
					<?php wp_meta(); ?>
				</ul>
		<?php endif; ?>

			<?php if (function_exists('wp_theme_switcher')) { ?>
			<h3><?php _e('The Themes','journalist-13' ); ?></h3>
			<div class="themes">
				<?php wp_theme_switcher(); ?>
			</div>
			<?php } ?>
</div>
