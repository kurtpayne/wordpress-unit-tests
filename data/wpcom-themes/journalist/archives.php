<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="content">

<h2><?php _e('Archives', 'journalist'); ?></h2>

<div class="main">

<p><?php _e("Complete archive of the blog's posts.", 'journalist'); ?></p>

<h3><?php _e('Monthly:', 'journalist'); ?></h3>
<ul>
<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
</ul>

<h3><?php _e('Topic:', 'journalist'); ?></h3>
<ul>
<?php wp_list_categories('orderby=name&show_count=1&title_li='); ?>
</ul>

<h3>Tag:</h3>
<?php wp_tag_cloud('order=ASC&orderby=name&number=0'); ?>

</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
