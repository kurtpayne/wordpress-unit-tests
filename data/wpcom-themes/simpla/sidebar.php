<ul id="sidebar">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
<h2>Pages</h2>
<ul>
<li><a href="<?php echo get_settings('home'); ?>/">Home</a></li>
<?php wp_list_pages('title_li='); ?> 
</ul>
<h2>Categories</h2>
<ul>
<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
</ul>
<ul>
<?php wp_list_bookmarks(); ?>
</ul>
<?php endif; ?>
</ul>