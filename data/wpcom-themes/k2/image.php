<?php get_header(); ?>

<div class="content">
	
	<div id="primary">
		<div id="current-content">
			<div id="primarycontent" class="hfeed">

	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-head">
						<h3 class="entry-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h3>
					</div> <!-- .entry-head -->

					<div class="entry-content">
						<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
						<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
						<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

						<div class="image-navigation">
							<div class="alignleft"><?php previous_image_link() ?></div>
							<div class="alignright"><?php next_image_link() ?></div>
						</div>
					</div> <!-- .entry-content -->
				</div> <!-- #post-ID -->

				<?php comments_template(); ?>	

	<?php } } else { ?>

				<h2><?php _e('Sorry, no attachments matched your criteria.','k2_domain'); ?></h2>

	<?php } ?>
			</div> <!-- #primarycontent -->
		</div> <!-- #current-content -->

		<div id="dynamic-content"></div>

	</div> <!-- #primary -->

	<?php get_sidebar(); ?>

</div> <!-- .content -->

<?php get_footer(); ?>
