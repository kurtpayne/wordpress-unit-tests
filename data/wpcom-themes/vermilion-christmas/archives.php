<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<!-- BEGIN ARCHIVES.PHP -->
<div id="content">

<h2 class="page-title">Archives by Subject:</h2>
<ul>
<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=1&children=1'); ?>
</ul>

<h2>Archives by Month:</h2>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>

<?php edit_post_link('edit','<div class="edit">[',']</div>'); ?>
</div>
<!-- END ARCHIVES.PHP -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
