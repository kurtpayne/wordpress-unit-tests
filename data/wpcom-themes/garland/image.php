<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?>>

<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
<span class="submitted"><?php edit_post_link(__('Edit'), '', ''); ?></span>

<div class="content">
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
	<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

	<div class="image-navigation">
		<div class="alignleft"><?php previous_image_link() ?></div>
		<div class="alignright"><?php next_image_link() ?></div>
	</div>
</div>

<div class="meta">
<?php comments_popup_link(__('Leave a Comment &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
</div>

</div>
<?php endwhile; endif; ?>

<?php comments_template(); ?>

<?php get_footer(); ?>
