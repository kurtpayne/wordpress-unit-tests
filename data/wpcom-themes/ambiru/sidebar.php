<div id="sidebar">
<div class="sec-a">
<?php if ( !dynamic_sidebar('bottom-1') ) { ?>
<h2><?php _e('Categories','ambiru'); ?></h2>
<ul>
<?php wp_list_categories('sort_column=name&optioncount=1&hierarchical=0&title_li='); ?>
</ul>
<h2><?php _e('Archives','ambiru'); ?></h2>
<ul>
 <?php wp_get_archives('type=monthly'); ?>
</ul>
<?php } ?>
</div>
<div class="sec-a">
<?php if ( !dynamic_sidebar('bottom-2') ) { ?>
<?php wp_list_bookmarks('category_before=<h2>&category_after=</h2>'); ?>
<?php } ?>
</div>
</div>
