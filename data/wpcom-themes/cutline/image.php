<?php get_header(); ?>

	<div id="content_box">
		
		<div id="content" class="posts">
			
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
				<div class="entry">
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
		
			<h2 class="page_header"><?php _e('Uh oh.','cutline'); ?></h2>
			<div class="entry">
			<p><?php _e('Sorry, no posts matched your criteria. Wanna search instead?','cutline'); ?></p>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			
		<?php endif; ?>
		
		</div>
		
		<?php get_sidebar(); ?>
			
	</div>

<?php get_footer(); ?>
