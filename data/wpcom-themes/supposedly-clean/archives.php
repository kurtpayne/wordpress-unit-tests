<?php
/*
Template Name: Archives
*/
?>

<?php 
get_header();
?>
<div id="mike_content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		 <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2>Archives by Month:</h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>
<br />
<h2>Archives by Subject:</h2>
  <ul>
     <?php wp_list_cats(); ?>
  </ul>

            <?php wp_link_pages(); ?>
        
	
	
		   </div><!--close post, WP-loop-->

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div><!--close mike content-->
<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
