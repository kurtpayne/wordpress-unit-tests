<?php
get_header();
?>
<div id="content">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div <?php post_class( 'entry' ); ?>>
    <h3 class="entrytitle" id="post-<?php the_ID(); ?>"> <a href="<?php the_permalink() ?>" rel="bookmark">
      <?php the_title(); ?>
      </a> </h3>
    <div class="entrymeta">
        Posted <?php the_time(get_option('date_format')); ?><br />
        Filed under: <?php the_category(',') ?> | <?php the_tags('Tags: ', ', ', ' | '); ?> <?php edit_post_link(__(' Edit')); ?>
	</div>
	  
    <div class="entrybody">
      <?php the_content(__('Read more &raquo;'));?>
      <?php wp_link_pages(); ?>
<div class="sociable"><?php if(function_exists('wp_email')) { email_link(); } ?>
</div>
    </div>

  </div>
  <?php comments_template(); // Get wp-comments.php template ?>
  <?php endwhile; else: ?>
  <p>
    <?php _e('Sorry, no posts matched your criteria.'); ?>
  </p>
  <?php endif; ?>
  <p>
    <?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
  </p>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
