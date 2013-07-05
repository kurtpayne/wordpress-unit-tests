	<div id="sidebar">
		<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
		</ul>
	</div>
<?php return; endif; ?>
			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2><?php _e('Author','whiteasmilk'); ?></h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<?php wp_list_pages('title_li=<h2>' . __('Pages','whiteasmilk') . '</h2>' ); ?>

			<li><h2><?php _e('Archives','whiteasmilk'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<li><h2><?php _e('Categories','whiteasmilk'); ?></h2>
				<ul>
				<?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?>
				</ul>
			</li>

				<?php wp_list_bookmarks(); ?>

		<?php if (function_exists('wp_theme_switcher')) { ?>
			<li><h2><?php _e('Themes','whiteasmilk'); ?></h2>
			<?php wp_theme_switcher(); ?>
			</li>
		<?php } ?>
				
				<li><h2><?php _e('Meta','whiteasmilk'); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional','whiteasmilk'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>','whiteasmilk'); ?></a></li>
					<li><?php _e('<a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a>','whiteasmilk'); ?></li>
					<li><a href="http://<?php _e('wordpress.com','whiteasmilk'); ?>/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.','whiteasmilk'); ?>"><?php _e('WordPress.com','whiteasmilk'); ?></a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			
			<li>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>			
		</ul>
	</div>
