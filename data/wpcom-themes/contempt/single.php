<?php
	get_header();
	$time_since = '';
?>

	<div id="content" class="widecolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	

	
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','contempt'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
			<div class="entry">
				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;', 'contempt').'</p>'); ?>
	
				<?php wp_link_pages(); ?>
	
				<p class="postmetadata alt">
					<small>
					<?php printf(__('This entry was posted %1$s on %2$s at %3$s and is filed under %4$s.', 'contempt'), $time_since, get_the_time(__('l, F jS, Y', 'contempt')), get_the_time(), get_the_category_list(', ')); ?>
					<?php printf(__("You can follow any responses to this entry through the <a href='%s'>RSS 2.0</a> feed.", "contempt"), get_post_comments_feed_link()); ?> 

					<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
						// Both Comments and Pings are open ?>
						<?php printf(__('You can <a href="#respond">leave a response</a>, or <a href="%s" rel="trackback">trackback</a> from your own site.', 'contempt'), trackback_url(false)); ?>

					<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
						// Only Pings are Open ?>
						<?php printf(__('Responses are currently closed, but you can <a href="%s" rel="trackback">trackback</a> from your own site.', 'contempt'), trackback_url(false)); ?>

					<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
						// Comments are open, Pings are not ?>
						<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.', 'contempt'); ?>

					<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
						// Neither Comments, nor Pings are open ?>
						<?php _e('Both comments and pings are currently closed.', 'contempt'); ?>

					<?php } edit_post_link(__('Edit this entry', 'contempt'),'','.'); ?>
						
					</small>
				</p>
	
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.','contempt'); ?></p>
	
<?php endif; ?>
	
	</div>
	
	

<?php get_sidebar(); ?>	
	
<?php get_footer(); ?>
