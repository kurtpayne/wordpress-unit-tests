<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

	<div id="content">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignleft">&nbsp;</div>
			<div class="alignright">&nbsp;</div>
		</div>
<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','andreas09'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="entrytext">
				<p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>

				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;','andreas09').'</p>'); ?>
	
				<?php link_pages('<p><strong>'.__('Pages','andreas09').':</strong> ', '</p>', 'number'); ?>
	
				<p class="postmetadata alt">
					<small>
						<?php _e('This entry was posted on','andreas09'); ?>
						<?php /* This is commented, because it requires a little adjusting sometimes.
							You'll need to download this plugin, and follow the instructions:
							http://binarybonsai.com/archives/2004/08/17/time-since-plugin/ */
							/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?> 
						<?php the_time(get_option("date_format")); ?> <?php _e('at','andreas09'); ?> <?php the_time() ?>.
						<?php _e('You can follow any responses to this entry through the','andreas09'); ?> <?php comments_rss_link('RSS 2.0'); ?> <?php _e('feed','andreas09'); ?>. 
						
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
					</small>
				</p>
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no attachments matched your criteria.','andreas09'); ?></p>
	
<?php endif; ?>
	
	</div>

<?php get_footer(); ?>
