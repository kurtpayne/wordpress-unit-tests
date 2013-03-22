<?php
/*
Template Name: Links
*/
?>

<?php 
get_header();
?>
<div id="mike_content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		 <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<h2>Links:</h2>
<ul>
<?php get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
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
