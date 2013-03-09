<?php get_header(); ?>

<div id="content">
				
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2 class="posttitle"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
			
			<div class="postentry">
				<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
				<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
				<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

				<div class="navigation">
					<div class="alignleft"><?php previous_image_link() ?></div>
					<div class="alignright"><?php next_image_link() ?></div>
				</div>
			</div>
		</div>
			
		<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<h2 class="posttitle"><?php _e('Not Found'); ?></h2>
		<p><?php _e('Sorry, but no posts matched your criteria.'); ?></p>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	
	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
