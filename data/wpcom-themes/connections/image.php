<?php get_header()?>	
	<div id="main">
	<div id="content">
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div <?php post_class(); ?>>
				<div class="post-info"><h2 class="post-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2></div>
			<div class="post-content">
				<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
				<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
				<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

				<div class="navigation">
					<div class="alignleft"><?php previous_image_link() ?></div>
					<div class="alignright"><?php next_image_link() ?></div>
				</div>
		        </div>
        <div class="post-footer">&nbsp;</div>
</div>
				<?php comments_template(); // Get wp-comments.php template ?>
			</div>
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		<p align="center"><?php posts_nav_link() ?></p>		
	</div>
	<div id="sidebar">
	<?php if ($posts) { ?>
	<h2><?php _e('Archived Entry') ?></h2>
	<ul>
	<li><?php _e('<strong>Post Date :</strong>') ?></li>
	<li><?php the_time(get_option('date_format')) ?> at <?php the_time() ?></li>
	<?php if ( !is_attachment() ) { ?>
	<li><?php _e('<strong>Category :</strong>') ?></li>
	<li><?php the_category(__(', ')); ?></li>
	<?php the_tags( '<li>' . __( 'Tags' ) . ': ', ', ', '</li>'); ?>
	<?php } ?>
	<li><?php _e('<strong>Do More :</strong>') ?></li>
	<li><?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(display); ?>">trackback</a> from your own site.
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(display); ?> ">trackback</a> from your own site.
						
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.') ?>
			
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.') ?>			
						
						<?php } edit_post_link(__('Edit this entry.'),'',''); ?></li>
	</ul>
	<?php }; ?>	
	</div>
<?php  get_footer();?>
</div>
</div>
</body>
</html>
