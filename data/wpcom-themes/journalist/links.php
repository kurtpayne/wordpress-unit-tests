<?php
/*
Template Name: Links
*/
?>

<?php get_header(); ?>

<div id="content">

<h2><?php _e('Links','journalist'); ?></h2>

<div class="main">

<p><?php _e("Complete list of the blog's bookmarks.", 'journalist'); ?></p>

<ul>
<?php wp_list_bookmarks('title_li=&title_before=<strong>&title_after=</strong>&category_before=<li>&category_after=</li>'); ?>
</ul>

</div>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
