<?php get_header(); ?>

	<div id="content" class="widecolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link(' %link &raquo;') ?></div>
		</div>
	
		<div <?php post_class(); ?>>
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
			<div class="entrytext">
				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;', 'black-letterhead').'</p>'); ?>
	
				<?php wp_link_pages(); ?>
	
				<p class="postmetadata alt">
					<small>
						<?php printf(__('This entry was posted on %s at %s and is filed under %s %s.', 'black-letterhead'),
							get_the_time(get_option('date_format')),
							get_the_time(get_option('time_format')),
							get_the_category_list(', '),
							get_the_tag_list(__('with tags', 'black-letterhead').' ', ', ')
							); ?>
						<?php printf(__('You can follow any responses to this entry through the %s feed', 'black-letterhead'), "<a href='".attribute_escape(get_post_comments_feed_link())."'>RSS 2.0</a>"); ?>

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<?php printf(__('You can <a href="%s">leave a response</a>, or <a href="%s">trackback</a> from your own site.', 'black-letterhead'), '#respond', get_trackback_url()); ?>
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							<?php printf(__('Responses are currently closed, but you can <a href="%s">trackback</a> from your own site.', 'black-letterhead'), get_trackback_url()); ?>
						
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.', 'black-letterhead'); ?>
			
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.', 'black-letterhead'); ?>
						
						<?php } edit_post_link(__('Edit this entry.', 'black-letterhead'),'',''); ?>
						
					</small>
				</p>
	
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.', 'black-letterhead'); ?></p>
	
<?php endif; ?>
	
	</div>

<?php get_footer(); ?>
