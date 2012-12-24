	<div id="sidebar">
		<ul>
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
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
		</ul>
	</div>
<?php return; endif; ?>
			
			<?php wp_list_pages('title_li=<h2>' . __('Pages') . '</h2>' ); ?>

			<li><h2><?php _e('Categories'); ?></h2>
			
				<ul>
				<?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?>
				</ul>
			</li>

			<li><h2><?php _e('Archives'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>
			
			<li>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>

				<?php wp_list_bookmarks(); ?>
				
				<li><h2><?php _e('Meta'); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://wordpress.com/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>">WordPress.com</a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>

		</ul>
	</div>

