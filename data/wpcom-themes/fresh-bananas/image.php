<?php get_header(); ?>

<?php // This is the main loop. Body content is passed in through this code. ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<h1><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h1>

<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

<div class="navigation">
	<div class="alignleft"><?php previous_image_link() ?></div>
	<div class="alignright"><?php next_image_link() ?></div>
</div>

<p class="meta"><?php edit_post_link(__('Edit')); ?></p>

</div>

<?php comments_template(); ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p> 
<?php endif; ?>

<?php get_footer(); ?>
