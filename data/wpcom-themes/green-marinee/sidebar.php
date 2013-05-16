
<!-- begin sidebar -->
<div id="right">
	<?php if ( !dynamic_sidebar('sidebar') ) { ?>
		<div id="links">

		<div id="pages">
			<h3><?php _e('The Pages','greenmarinee'); ?></h3>
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
		</div>

		<div class="line"></div>

		<h3><?php _e('The Search','greenmarinee'); ?></h3>
			<?php get_search_form(); ?>

		<div class="line"></div>
		
		<h3><?php _e('The Associates','greenmarinee'); ?></h3>
			<ul>
				<?php get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
			</ul>

		<div class="line"></div>

		<h3><?php _e('The Storage','greenmarinee'); ?></h3>
			<ul>
		 		<?php wp_get_archives('type=monthly'); ?>
 			</ul>
 
		<div class="line"></div>

			<h3><?php _e('The Categories','greenmarinee'); ?></h3>
				<ul>
					<?php wp_list_cats(); ?>
				</ul>	
		<div class="line"></div>

			<h3><?php _e('The Meta','greenmarinee'); ?></h3>
				<ul>
					<!-- <li><?php // wp_register(); ?></li> -->
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://<?php _e('wordpress.com','greenmarinee'); ?>/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.','greenmarinee'); ?>"><abbr title="WordPress"><?php _e('WP.com','greenmarinee'); ?></abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS','greenmarinee'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>','greenmarinee'); ?></a></li>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS','greenmarinee'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>','greenmarinee'); ?></a></li>
					<li><a href="#content" title="<?php _e('Back to top','greenmarinee'); ?>"><?php _e('Back to top','greenmarinee'); ?></a></li>
					<?php wp_meta(); ?>
				</ul>

		</div>
	<?php } ?>
</div>

<!-- end sidebar -->
