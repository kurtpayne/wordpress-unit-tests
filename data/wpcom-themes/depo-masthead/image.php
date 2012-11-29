<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); 
		if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts);  ?>

		

					<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
						<p class="postmetadata"><?php the_tags('', ', ', '<br />'); ?></p>
						<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
						<small>On <strong><?php the_time(get_option('date_format')) ?></strong> at <strong><?php the_time() ?></strong></small>

						<div class="entry">
							<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
							
							<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
							<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

							<?php edit_post_link(__('Edit this entry.', 'depo-masthead'), '<p>', '</p>'); ?>
						</div>
						


					</div>

					<div id="showcomments"><a href="#comments">&#9654; <?php comments_number(__('No Responses', 'depo-masthead'), __('One Response', 'depo-masthead'), __('% Responses', 'depo-masthead'));?></a></div>
					
					<div id="comments">
						<?php comments_template(); ?>
					</div>
					
					<div class="navigation attachment">
						<div class="previous">
							
							<div class="link">
								<span class="title image"><?php previous_image_link() ?></span>
							</div>	
						</div>
						
						<div class="next">
							<div class="link">
								<span class="title image"><?php next_image_link() ?></span>
							</div>	
						</div>
						<div class="clear"></div>
					</div>	

	
	
	
	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.', 'depo-masthead'); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
