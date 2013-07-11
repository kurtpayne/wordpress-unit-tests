<?php get_header(); ?>
	<div id="content" class="widecolumn">
<?php is_tag(); ?>				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
	
			<div class="entrytext">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
	
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
	
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p>Sorry, no posts matched your criteria.</p>
	
<?php endif; ?>
	
	</div>
	
	<div id="sidebar" style="color: #ccc; font-size: 0.8em;">
	
		<p><a href="<?php bloginfo('url'); ?>">Home</a></p>
	
		<p class="postmeta_single">
				This entry was posted
				on <?php the_time(get_option('date_format')) ?> at <?php the_time() ?>
				and is filed under <?php the_nice_category(' , ', ' and ') ?>.
				You can follow any responses to this entry through the <?php comments_rss_link('RSS 2.0'); ?> feed. 

				<?php print get_the_term_list( $post->ID, 'post_tag', '<p>Tags: ', ', ', '</p>'); ?>
				
				<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
					// Both Comments and Pings are open ?>
					You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(true); ?>" rel="trackback">trackback</a> from your own site.
				
				<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
					// Only Pings are Open ?>
					Responses are currently closed, but you can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your own site.
				
				<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
					// Comments are open, Pings are not ?>
					You can skip to the end and leave a response. Pinging is currently not allowed.
	
				<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
					// Neither Comments, nor Pings are open ?>
					Both comments and pings are currently closed.			
				
				<?php } edit_post_link('Edit this entry.','',''); ?>
		</p>
	
	
		<div class="navigation">
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
		</div>
	
	</div>

<?php get_footer(); ?>
