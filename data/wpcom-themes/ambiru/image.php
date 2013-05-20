<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( "entry entry-$postCount" ); ?>>
		<div class="entrytitle">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
		</div>
		<div class="entrybody">
			<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
			<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
			<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>
		</div>

		<div class="navigation">
			<div class="alignleft"><?php previous_image_link() ?></div>
			<div class="alignright"><?php next_image_link() ?></div>
		</div>
	</div>
	<div class="commentsblock">
		<?php comments_template(); ?>
	</div>
		<?php endwhile; ?>
	<?php else : ?>

		<h2><?php _e('Not Found', 'ambiru'); ?></h2>
		<div class="entrybody"><?php _e("Sorry, but you are looking for something that isn't here.", "ambiru"); ?></div>

	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
</body>
</html>
