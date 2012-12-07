<?php get_header(); ?>
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<div class="p-head">
<small><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a></small>
<h2><strong><?php the_title(); ?></strong></h2>
</div>

<div class="p-con">
<p><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a>
<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

<div class="nav">
 <div class="left"><?php previous_image_link() ?></div>
 <div class="right"><?php next_image_link() ?></div>
</div>

<small><?php edit_post_link(__('Edit this entry.', 'albeo'),'',''); ?></small>

</div>
</div>

<?php comments_template(); ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no attachments matched your criteria.', 'albeo'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
