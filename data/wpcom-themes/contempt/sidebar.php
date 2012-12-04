	<div id="sidebar">
		<ul>

		<?php if ( is_404() || is_category() || is_day() || is_month() ||
					is_year() || is_search() || is_paged() ) {
		?> <li>

		<?php /* If this is a 404 page */ if (is_404()) { ?>
		<?php /* If this is a category archive */ } elseif (is_category()) { ?>
		<p><?php printf(__('You are currently browsing the archives for the %s category.', 'contempt'), single_cat_title('', false)); ?></p>

		<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
		<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for the day %3$s.', 'contempt'), get_bloginfo('url'), get_bloginfo('name'), get_the_time(__('l, F jS, Y', 'contempt'))); ?></p>

		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for %3$s.', 'contempt'), get_bloginfo('url'), get_bloginfo('name'), get_the_time(__('F, Y', 'contempt'))); ?></p>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for the year %3$s.', 'contempt'), get_bloginfo('url'), get_bloginfo('name'), get_the_time('Y')); ?></p>

		<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
		<p><?php printf(__('You have searched the <a href="%1$s/">%2$s</a> blog archives for <strong>&#8216;%3$s&#8217;</strong>. If you are unable to find anything in these search results, you can try one of these links.', 'contempt'), get_bloginfo('url'), get_bloginfo('name'), wp_specialchars(get_search_query(), true)); ?></p>

		<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives.', 'contempt'), get_bloginfo('url'), get_bloginfo('name')); ?></p>

		<?php } ?>
			</li> <?php }?>
<?php
	if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
		</ul>
	</div>
<?php
		return;
	endif;
?>
			<li><h2><?php _e('Archives','contempt'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<li><h2><?php _e('Categories','contempt'); ?></h2>
				<ul>
					<?php wp_list_categories('orderby=name&hierarchical=0&title_li='); ?>
				</ul>
			</li>

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>				
				<?php wp_list_bookmarks(); ?>
				
				<li><h2><?php _e('Meta','contempt'); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional','contempt'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>','contempt'); ?></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="http://<?php _e('wordpress.com','contempt'); ?>/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.','contempt'); ?>"><?php _e('WordPress.com','contempt'); ?></a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>
			
		</ul>
	</div>