<?php get_header(); ?>
<?php is_tag(); ?>

	<?php if (have_posts()) : ?>
	
		<?php while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?>>
<div class="heading"><span id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></span></div>

<div class="entry">
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
	<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

	<div class="navigation">
		<div class="alignleft"><?php previous_image_link() ?></div>
		<div class="alignright"><?php next_image_link() ?></div>
	</div>
</div>

<div class="footer"><?php edit_post_link(__('Edit?','girl'),' (',')'); ?> 
<?php comments_popup_link(__('Leave a Comment &#187;','girl'),__('1 Comment &#187;','girl'),__('% Comments &#187;','girl')); ?> </div>
</div>

<br />
<br />

			<?php comments_template(); ?>

		<?php endwhile; ?>
		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found','girl'); ?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.","girl"); ?></p>
		
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
