<?php get_header(); ?>

	<div id="content_box">
		<div id="content">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
			<div class="entry">
				<p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>

				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;').'</p>'); ?>
	
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
	
				<div class="post_meta">
					<p class="num_comments"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></p>
				</div> 

			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no attachments matched your criteria.'); ?></p>
	
<?php endif; ?>
		</div>

		<?php get_sidebar(); ?>

	</div>
<?php get_footer(); ?>
