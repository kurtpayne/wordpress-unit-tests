<?php get_header(); ?>
	<?php if (have_posts()) :
		while (have_posts()) : the_post(); ?>
			<div <?php post_class(depo_post_category()) ?> id="post-<?php the_ID(); ?>">
				<?php before_post(); ?>
				<p class="category"><?php depo_post_category_html(); ?></p>
				<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>

				<div class="entry">
					<p class="attachment aligncenter"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></p>
					<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt();  ?></div>
					<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

					<div class="navigation">
						<div class="alignleft"><?php previous_image_link() ?></div>
						<div class="alignright"><?php next_image_link() ?></div>
					</div>
				</div>

				<div class="endbuttski">
					<p class="comment-status"><?php comments_popup_link(__('Leave a Comment ', 'depo-square'), __('1 Comment', 'depo-square'), __('% Comments', 'depo-square')); ?></p>
				</div>
				<?php comments_template(); ?>
				<?php after_post(); ?>
			</div>
		<?php endwhile; ?>
			
		<?php if( !is_home() && !is_front_page() ): ?><div class="navigation_to_home"><a href="<?php bloginfo('wpurl'); ?>"><?php _e('&laquo Back to Home'); ?></div><?php endif; ?>

	<?php else : ?>
		<div class="post">
		<h2 class="center"><?php _e('Not Found', 'depo-square'); ?></h2>
		<div class="entry">
		<br />
		<p><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'depo-square'); ?></p>
		</div>
		</div>
	<?php endif; ?>
	
<?php get_footer(); ?>
