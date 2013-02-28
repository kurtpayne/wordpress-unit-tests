<div id="sidebar">
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : ?>
</ul>
</div>
<?php return; endif; ?>

<li>
	<form style="padding: 0px; margin-top: 0px; margin-bottom: 0px;" id="searchform" method="get" action="<?php bloginfo('url'); ?>">
	<div class="title"><?php _e('Search:','benevolence'); ?></div>
	<p style="padding: 0px; margin-top: 0px; margin-bottom: 0px;"><input type="text" class="input" name="s" id="search" size="15" />
	<input name="submit" type="submit" tabindex="5" value="<?php _e('GO','benevolence'); ?>" /></p>
	</form>
</li>

<li>
	<h2><?php _e('Categories','benevolence'); ?></h2>
<?php wp_list_cats('list=0'); ?>
</li>

<li>
	<h2><?php _e('Archives','benevolence'); ?></h2>
<?php wp_get_archives('type=monthly&format=other&after=<br />'); ?>
</li>

<li>
	<h2 class="title"><?php _e('Links','benevolence'); ?></h2>
<?php get_links('-1', '', '<br />', '<br />', 0, 'name', 0, 0, -1, 0); ?> 
</li>
</ul>
</div>

