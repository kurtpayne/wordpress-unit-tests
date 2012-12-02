<?php
get_header();
?>

<div id="content">	
<h2 class="archives"><?php _e('Search results'); ?></h2>

  <?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
  	<div <?php post_class( 'entry' ); ?>>
    <p><strong> <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></strong> </p>
	  <div class="entrymeta">
		<?php the_time(get_option('date_format'));?>
	</div>
  </div>
  <?php endwhile; else: ?>
  <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

  <?php endif; ?>
  <p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
