<?php get_header(); ?>

<?php // This is the main loop. Body content is passed in through this code. ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<h1><?php the_title(); ?></h1>

<?php the_content(); ?>
<?php wp_link_pages(); ?>

</div>

<?php comments_template(); ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p> 
<?php endif; ?>

<?php get_footer(); ?>
