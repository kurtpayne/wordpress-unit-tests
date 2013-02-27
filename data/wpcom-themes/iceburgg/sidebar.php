<div id="middle">
<div class="left">
<ul class="sidebar">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>

<h2>Categories</h2>
<p>Find more posts by selecting categories.</p>
<ul>
<?php wp_list_cats(); ?>
</ul>
<?php endif; ?>
</ul>
</div>
<div class="mid">
<ul class="sidebar">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
<h2>Search</h2>
<p>Search through our entire archives, and find the articles of your dreams.
Use keywords, tags, or the post title if you happen to know it or parts
of it. Chances are, we'll find something for you.</p>
<div class="sf">
<form method="get" action="/">
<input class="searchfield" type="text" name="s" id="s" value="Enter Search" size="20" />
<input type="image" src="<?php bloginfo('template_directory'); ?>/imgs/search.gif" value="Search" class="searchButton" alt="Search" title="Search" />
</form>
</div>
<?php endif; ?>
</ul>
</div>
<div class="right">
<ul class="sidebar">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(3) ) : ?>
<h2>About this blog</h2>
<p>
<?php bloginfo('description'); ?>
</p>
<?php endif; ?>
</ul>
</div>
<div style="clear: both"></div>
</div>