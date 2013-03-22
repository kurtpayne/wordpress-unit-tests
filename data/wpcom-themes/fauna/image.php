<?php get_header(); ?>

	<div id="body">
	
		<div id="main" class="entry">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
			<div class="box">
				<a href="<?php bloginfo('url'); ?>"><?php _e('Home') ?></a>
			</div>
		
			<hr />
		
			<div <?php post_class( 'box entry' ); ?>>
		        	<h2 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>

				<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
				<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
				<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

				<div class="navigation">
					<div class="alignleft"><?php previous_image_link() ?></div>
					<div class="alignright"><?php next_image_link() ?></div>
				</div>

		       		<div class="entry-meta"><?php edit_post_link('Edit This', ' &#8212; '); ?></div>
			</div>

			<?php comments_template(); ?>

			<?php endwhile; else: ?>
			
			<div class="box">
				<h2><?php _e('Not Found') ?></h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			</div>		
			
		<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

	<?php get_footer(); ?>
