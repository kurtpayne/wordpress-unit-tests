<?php get_header();?>
<div id="content">
<div id="content-main">
	<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
			
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="posttitle">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
			<p class="post-info"><?php edit_post_link(__('Edit','mistylook'), '', ' | '); ?>  <?php comments_popup_link(__('Leave a Comment &#187;','mistylook'), __('1 Comment &#187;','mistylook'), __('% Comments &#187;','mistylook')); ?></p>
				</div>
				<div class="entry">
					<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
					<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
					<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

					<div class="navigation">
						<div class="alignleft"><?php previous_image_link() ?></div>
						<div class="alignright"><?php next_image_link() ?></div>
					</div>
				<br class="clear" />

				</div>
				<?php comments_template(); ?>
			</div>
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.','mistylook'); ?></p>
	<?php endif; ?>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
