<?php get_header() ?>

<div id="postpage">

	<div class="sleeve_main">

		<div id="main">

			<?php if ( have_posts() ) : ?>
				
				<?php while ( have_posts( ) ) : the_post() ?>

					<div <?php post_class('post'); ?> id="post-<?php the_ID( ); ?>">
						
						<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title() ?></h2>
						
						<div class="entry">
							<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
		
							<p><?php echo wp_get_attachment_image( $post->ID, array($content_width - 8, 700)); ?></p>
							
							<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
							<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>		

							<div class="navigation">
								<div class="alignleft"><?php previous_image_link() ?></div>
								<div class="alignright"><?php next_image_link() ?></div>
							</div>
				
							<?php comments_template(); ?>

						</div> <!-- // entry -->
						
					</div> <!-- post-<?php the_ID( ); ?> -->

				<?php endwhile; ?>
					
			<?php endif; ?>

		</div> <!-- // main -->
		
	</div>
	
</div>

<?php get_footer() ?>
