<ul id="sidebar">
<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar() ) : ?>

<li id="searchdiv">
<form id="searchform" method="get" action="/">
<input type="text" name="s" id="s" size="20"/>
<input name="sbutt" type="submit" value="<?php echo attribute_escape(__('Find')); ?>" alt="<?php echo attribute_escape(__('Submit')); ?>"  />
</form>
</li>

<li>
<h2<?php _e('Monthly Archives'); ?></h2>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</li>

<li>
<h2><?php _e('Categories'); ?></h2>
<ul>
<?php wp_list_cats(); ?>
</ul>
</li>

<li>
<h2><?php _e('Stay Updated'); ?></h2>
<ul id="feed">
<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('RSS Articles'); ?></a></li>
</ul>
</li>
<?php endif; ?>

</ul>
