<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'main' ); ?>>

		<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>

		<p class="info">
   		<?php edit_post_link(__('Edit', 'flower-power'),'<span class="editlink">','</span>'); ?>
   		</p>

		<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
		<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
		<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

		<div class="navigation">
			<div class="alignleft"><?php previous_image_link() ?></div>
			<div class="alignright"><?php next_image_link() ?></div>
		</div>

<?php endwhile; ?>

<?php else : ?>

	<h2><?php _e('Not Found', 'flower-power'); ?></h2>
	<p><?php _e("Sorry, but you are looking for something that isn't here.", 'flower-power'); ?></p>

<?php endif; ?>

<?php comments_template(); ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
