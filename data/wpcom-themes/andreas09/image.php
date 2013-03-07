<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

<div id="content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>

		<div class="entrytext">
			<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
			<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
			<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

			<div class="navigation">
				<div class="alignleft"><?php previous_image_link() ?></div>
				<div class="alignright"><?php next_image_link() ?></div>
			</div>
		</div>

			<p class="postmetadata">
						<?php if (comments_open() && pings_open()) {
							// Both Comments and Pings are open ?>
							<?php _e('You can','andreas09'); ?> <a href="#respond"><?php _e('leave a response','andreas09'); ?></a>, <?php _e('or','andreas09'); ?> <a href="<?php trackback_url(true); ?>" rel="trackback"><?php _e('trackback','andreas09'); ?></a> <?php _e('from your own site','andreas09'); ?>.
						
						<?php } elseif (!comments_open() && pings_open()) {
							// Only Pings are Open ?>
							<?php _e('Responses are currently closed, but you can','andreas09'); ?> <a href="<?php trackback_url(true); ?> " rel="trackback"><?php _e('trackback','andreas09'); ?></a> <?php _e('from your own site','andreas09'); ?>.
						
						<?php } elseif (comments_open() && !pings_open()) {
							// Comments are open, Pings are not ?>
							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.','andreas09'); ?>
			
						<?php } elseif (!comments_open() && !pings_open()) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.','andreas09'); ?>			
						
						<?php } edit_post_link(__('Edit this entry.','andreas09'),'',''); ?>
			</p>		
		
	</div>
		
	<?php comments_template(); ?>
	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.','andreas09'); ?></p>
	
	<?php endif; ?>

</div>

<?php get_footer(); ?>
