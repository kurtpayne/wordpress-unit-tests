<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

<div id="content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="navigation">
		<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
		<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
	</div>
	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','andreas09'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>

		<p class="date"><?php _e('Posted by','andreas09'); ?> <?php if (get_the_author_url()) { ?><a href="<?php the_author_url(); ?>"><?php the_author(); ?></a><?php } else { the_author(); } ?> <?php _e('on','andreas09'); ?> <?php the_time(get_option("date_format")); ?></p>

		<div class="entrytext">
			<?php the_content(__('Read the rest of this entry &raquo;','andreas09')); ?>
</div>

			<?php link_pages('<p><strong>'.__('Pages:','andreas09').'</strong> ', '</p>', 'number'); ?>
			<p class="postmetadata">
				 		<?php _e('This entry was posted on','andreas09'); ?> <?php the_time(get_option('date_format')) ?> <?php _e('at','andreas09'); ?> <?php the_time() ?>
						<?php _e('and is filed under','andreas09'); ?> <?php the_category(', ') ?>.
						<?php the_tags( __( 'Tagged' ) . ': ', ', ', '. '); ?>
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
			</p>		
		
	</div>
		
	<?php comments_template(); ?>
<div class="bottomnavigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>
	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.','andreas09'); ?></p>
	
	<?php endif; ?>

</div>

<?php get_footer(); ?>
