<?php
/*
Template Name: Links
*/
?>

<?php get_header(); ?>

<!-- BEGIN LINKS.PHP -->
<div id="content">

<h2 class="page-title">Links:</h2>
<ul>
<?php get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
</ul>

<?php edit_post_link('edit','<div class="edit">[',']</div>'); ?>
</div>
<!-- END LINKS.PHP -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
