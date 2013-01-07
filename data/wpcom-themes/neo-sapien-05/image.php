<?php get_header(); ?>
<?php get_sidebar(); ?>

		<div class="narrowcolumn">

<?php include(TEMPLATEPATH . '/top-menu.php'); ?>

<!-- CONTENT -->

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>

<div class="entry">
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
	<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

	<div class="image-navigation">
		<div class="alignleft"><?php previous_image_link() ?></div>
		<div class="alignright"><?php next_image_link() ?></div>
	</div>

<p class="postmetadata"><?php edit_post_link(__('Edit this entry'), '', ''); ?></p>

<?php comments_template(); ?>

</div>

	</div>

<?php endwhile; ?>

<?php else : ?>

	<div <?php post_class(); ?>>
<h2><?php _e('Not Found'); ?></h2>
<div class="entry"><?php _e('Sorry, but you are looking for something that isn&#39;t here.'); ?></div>
	</div>

<?php endif; ?>

<!-- END CONTENT -->

		</div>

<?php get_footer(); ?>
