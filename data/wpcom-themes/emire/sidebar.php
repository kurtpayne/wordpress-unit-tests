<div id="sidebar">
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
</ul>
</div>
<?php return; endif; ?>
<h2><?php _e('Categories','emire'); ?></h2>
<ul>
<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
</ul>
</ul>
<h2><?php _e('Archives','emire'); ?></h2>
<ul>
 <?php wp_get_archives('type=monthly'); ?>
</ul>
<ul>
<?php wp_list_bookmarks(); ?>

</div>