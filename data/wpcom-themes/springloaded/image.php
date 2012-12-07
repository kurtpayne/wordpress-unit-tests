<?php get_header() ?>

<div id="single-content">

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
			<p class="metadata">
			<span class="feedback"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></span><?php edit_post_link(__('Edit'), ' | ', ''); ?></p>
			<div class="entry">
				<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
				<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
				<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

				<div class="navigation">
					<div class="alignleft"><?php previous_image_link() ?></div>
					<div class="alignright"><?php next_image_link() ?></div>
				</div>
			</div>
		</div>
		
		<?php comments_template() ?>
	
	<?php endwhile; else : ?>
	<div <?php post_class(); ?>>
		<h2 class="center"><?php _e('Not Found'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	</div>

<?php endif; ?>

</div><!-- /content -->

</div><!-- /main -->

<?php get_sidebar() ?>

<?php get_footer() ?>
