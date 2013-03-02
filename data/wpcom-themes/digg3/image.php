<?php get_header(); ?>

	<div class="wrapper"><!-- This wrapper class appears only on Page and Single Post pages. -->
	<div class="narrowcolumnwrapper"><div class="narrowcolumn">

		<div class="content">

			<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

			<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">

				<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>

				<div class="entry">
					<p class="image"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
					<?php if ( !empty($post->post_excerpt) ) the_excerpt(); /* this is the caption */ ?>
					<?php if ( !empty($post->post_content) ) the_content(); /* this is the description */ ?>
				</div>

				<div class="navigation">
					<div class="alignleft"><?php previous_image_link() ?></div>
					<div class="alignright"><?php next_image_link() ?></div>
				</div>

			</div><!-- /post -->

			<?php endwhile; ?>

		</div><!-- /content -->

		<?php include (TEMPLATEPATH . '/browse.php'); ?>

			<?php else : ?>

			<div <?php post_class(); ?>>
				<h2><?php _e('Not Found',TEMPLATE_DOMAIN); ?></h2>
				<p><?php _e('Sorry, but you are looking for something that isn\'t here.',TEMPLATE_DOMAIN); ?></p>
			</div>

			<?php endif; ?>

	</div><!-- /narrowcolumn -->
	</div><!-- /narrowcolumnwrapper -->
	<?php comments_template(); ?>
	</div><!-- /wrapper -->

<?php get_footer(); ?>
