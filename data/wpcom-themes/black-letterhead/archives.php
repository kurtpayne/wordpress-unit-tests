<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="content" class="narrowcolumn">

	<div class="pagepost">

	<h2><?php _e('Archives by Month:', 'black-letterhead'); ?></h2>
	  <ul>
	    <?php wp_get_archives('type=monthly'); ?>
	  </ul>

	<h2><?php _e('Archives by Subject:', 'black-letterhead'); ?></h2>
	  <ul>
	     <?php wp_list_categories('title_li='); ?>
	  </ul>

	  </div>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
