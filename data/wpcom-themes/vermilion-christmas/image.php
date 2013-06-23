<?php get_header(); ?>

<!-- BEGIN SINGLE.PHP -->
<div id="content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post-single">
			<h2 class="post-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
			
			<div class="entry">
				<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
				<p class="caption"></p></p><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></p>
				<p class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></p>
				
				<div class="navigation">
					<p class="alignleft"><?php previous_image_link() ?></p>
					<p class="alignright"><?php next_image_link() ?></p>
				</div>
				
				<p class="postmetadata">
					<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
					// Both Comments and Pings are open ?>
					<a href="#respond" class="commentlink">Leave a comment</a> &nbsp;|&nbsp; <a href="<?php trackback_url(true); ?>" rel="trackback" class="trackback">Trackback URI</a>
					
					<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
					// Only Pings are Open ?>
					Responses are currently closed, but you can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your own site.
					
					<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
					// Comments are open, Pings are not ?>
					You can skip to the end and leave a response. Pinging is currently not allowed.
					
					<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
					// Neither Comments, nor Pings are open ?>
					Both comments and pings are currently closed.
					
					<?php } edit_post_link('edit','<div class="edit">[',']</div>'); ?>
				</p>
			</div>
		</div>
		<?php comments_template(); ?>
	<?php endwhile; else: ?>
		
		<p>Sorry, no posts matched your criteria.</p>
		
	<?php endif; ?>
</div>
<!-- END SINGLE.PHP -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>