<?php get_header();?>
<div id="content">
<div id="content-main">
	<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
	<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
	<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>
			
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="posttitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link: %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
			<p class="post-info"><?php printf(__('Posted on %s','mistylook'), get_the_time(get_option("date_format"))); ?> | <?php edit_post_link(__('Edit','mistylook'), '', ' | '); ?>  <?php comments_popup_link(__('Leave a Comment &#187;','mistylook'), __('1 Comment &#187;','mistylook'), __('% Comments &#187;','mistylook')); ?></p>
				</div>				
				<div class="entry">
					<p class="<?php echo $classname; ?>"><?php echo apply_filters('the_content', $attachment_link); ?><br /><?php echo basename($post->guid); ?></p>
					<?php the_content(); ?>
				</div>
				<?php comments_template(); ?>
			</div>
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.','mistylook'); ?></p>
	<?php endif; ?>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
