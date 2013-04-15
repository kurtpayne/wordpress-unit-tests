<?php
/*
Template Name: Links
*/
?>

<?php get_header(); ?>

<div id="content" class="widecolumn">
<h2><?php _e('Links:'); ?></h2>
<ul>
<?php wp_list_bookmarks(); ?>
</ul>
</div>

<br style="clear:both" />
</div>	

<?php get_footer(); ?>
