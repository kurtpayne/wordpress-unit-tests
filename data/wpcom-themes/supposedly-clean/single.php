<?php 
get_header();
?>
<div id="mike_content">
<?php is_tag(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		 <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		 <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <span>| <?php the_time('M dS Y'); ?></span></h2>
		
			<?php the_content(); ?>

            <?php wp_link_pages(); ?>
        
	
		 <hr class="post_line" />
	<div class="category">Posted in <?php the_category(', '); ?><br /><?php the_tags( '<p>Tags: ', ', ', '</p>'); ?></div>
		 </div><!--close post, WP-loop-->
		

<?php comments_template(); // Get wp-comments.php template ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

</div><!--close mike content-->
<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
