<ul>
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
</ul>
<h2><?php _e('About the Site:'); ?></h2>
<ul><li><?php bloginfo('description'); ?></li></ul>

<h2><?php _e('Links'); ?></h2>
<ul><?php get_links('-1', '<li>', '</li>', ' '); ?></ul>
<h2>Pages</h2>
<ul><?php wp_list_pages('title_li=' ); ?></ul>
<h2><?php _e('Categories:'); ?></h2>
	<ul><?php wp_list_cats('sort_column=name&optioncount=1');    ?></ul>

<h2><label for="s"><?php _e('Search:'); ?></label></h2>
	<ul>
		<li>
			<form id="searchform" method="get" action="<?php bloginfo('home'); ?>/">
				<div style="text-align:center">
					<p><input type="text" name="s" id="s" size="15" /></p>
					<p><input type="submit" name="submit" value="<?php _e('Search'); ?>" /></p>
				</div>
			</form>
		</li>
	</ul>
<h2><?php _e('Monthly:'); ?></h2>
	<ul><?php wp_get_archives('type=monthly&show_post_count=true'); ?></ul>

<?php endif; ?>
</ul>