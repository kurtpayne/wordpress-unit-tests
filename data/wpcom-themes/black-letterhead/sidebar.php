	<div id="sidebar">
		<ul>
		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			
			<li>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>
			
			<li>
			<?php /* If this is a category archive */ if (is_category()) { ?>
				<p><?php printf(__('You are currently browsing the archives for the %s category.'), single_cat_title('', false)); ?></p>

			
				<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
				<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for the day %3$s.'), get_bloginfo('url'), get_bloginfo('name'), get_the_time(__('l, F jS, Y'))); ?></p>

				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for %3$s.'), get_bloginfo('url'), get_bloginfo('name'), get_the_time(__('F, Y'))); ?></p>

				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for the year %3$s.'), get_bloginfo('url'), get_bloginfo('name'), get_the_time('Y')); ?></p>

				<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
				<p><?php printf(__('You have searched the <a href="%1$s/">%2$s</a> blog archives for <strong>&#8216;%3$s&#8217;</strong>. If you are unable to find anything in these search results, you can try one of these links.'), get_bloginfo('url'), get_bloginfo('name'), wp_specialchars(get_search_query(), true)); ?></p>

				<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives.'), get_bloginfo('url'), get_bloginfo('name')); ?></p>

				<?php } ?>
			</li>

			<?php wp_list_pages('title_li=<h2>' . __('Pages') . '</h2>' ); ?>
			
			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>				
				<?php wp_list_bookmarks(); ?>
			
			<?php wp_list_categories('show_count=1&title_li=<h2>' . __('Categories') . '</h2>'); ?>
			
			<li><?php get_calendar(); ?></li>

			<li><h2><?php _e('Archives'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>
			
				<li><h2><?php _e('Meta'); ?></h2>
				<ul>
                         	<?php wp_register(); ?>

				<li><?php wp_loginout(); ?></li>

<li><a href="<?php bloginfo('atom_url'); ?>" title="<?php _e('Syndicate this site using Atom'); ?>">Atom 1.0</a></li>

<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0'); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>

<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>

<li><a href="http://wordpress.com/" title="<?php _e('Powered by WordPress.com'); ?>">WordPress</a></li>

					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>
			
		<?php endif; ?>	

		</ul>
	</div>
