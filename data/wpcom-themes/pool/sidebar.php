
<!-- begin sidebar -->
		<div id="sidebar">
			<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

			
			<div id="categories">			
			<h3><?php _e('Categories:'); ?></h3>
				<ul>
				<?php wp_list_cats('sort_column=name&optioncount=1&feed=rss'); ?>
				</ul>
			</div>
			
			<div id="archives">			
			<h3><?php _e('Archives:'); ?></h3>
				<ul>
				<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
				</ul>
			</div>
			
			<div id="blogroll">
			<h3>Blogroll</h3>
				<ul>
				<?php get_links(-1, '<li>', '</li>', ' - '); ?>
				</ul>
			</div>

			<div id="meta">
				<h3><?php _e('Meta:'); ?></h3>
				<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
				<li><a href="http://wordpress.com/">Get a blog at WordPress.com</a></li>
				<?php wp_meta(); ?>
				</ul>
			</div>
<?php endif; ?>		
			</ul>
		</div>
			
<div class="both"></div>
			
</div>

<!-- end sidebar -->
