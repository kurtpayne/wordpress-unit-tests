<div id="sidebar" class="clearfix">
	<div id="innerbar">
		<div id="primary" class="sidebar">
			<ul>
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : // BEGIN PRIMARY SIDEBAR WIDGETS ?>
		<?php if ( !is_home() || is_paged() ) { // DISPLAYS EVERYWHERE EXCEPT ON HOME PAGES ?>
				<li class="home-link">
					<h3><a href="<?php bloginfo('home') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?>"><?php _e('&laquo; Home', 'sandbox') ?></a></h3>
				</li>
		<?php } ?>
	<?php wp_list_pages('title_li=<h3>'.__('Pages').'</h3>' ) ?>

				<li class="category-links">
					<h3><?php _e('Categories', 'sandbox'); ?></h3>
					<ul>
	<?php wp_list_cats('sort_column=name&hierarchical=1') ?>

					</ul>
				</li>
				<li class="archive-links">
					<h3><?php _e('Archives', 'sandbox') ?></h3>
					<ul>
	<?php wp_get_archives('type=monthly') ?>

					</ul>
				</li>
		<?php endif; // END PRIMARY SIDEBAR WIDGETS  ?>
			</ul>
		</div><!-- #primary .sidebar -->

		<div id="secondary" class="sidebar">
			<ul>
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : // BEGIN  SECONDARY SIDEBAR WIDGETS ?>
				<li class="blog-search">
					<h3><label for="s"><?php _e('Search', 'sandbox') ?></label></h3>
					<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
						<div>
							<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="10" />
							<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find &raquo;', 'sandbox') ?>" />
						</div>
					</form>
				</li>
	<?php widget_sandbox_links() ?>

				<li class="feed-links">
					<h3><?php _e('RSS Feeds', 'sandbox') ?></h3>
					<ul>
						<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'sandbox') ?></a></li>
						<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> Comments RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'sandbox') ?></a></li>
					</ul>
				</li>
				<li class="meta-links">
					<h3><?php _e('Meta', 'sandbox') ?></h3>
					<ul>
						<?php wp_register() ?>
						<li><?php wp_loginout() ?></li>
						<?php wp_meta() ?>
					</ul>
				</li>
		<?php endif; // END SECONDARY SIDEBAR WIDGETS  ?>
			</ul>
		</div><!-- #secondary .sidebar -->
	</div>
</div>