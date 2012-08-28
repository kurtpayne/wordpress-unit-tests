<?php get_header(); ?>

	<div id="content">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="postwrapper wideposts" id="post-<?php the_ID(); ?>">
			<div class="title">
				<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
			</div>
			<div <?php post_class(); ?>>
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
			<br style="clear:both" />
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<div class="title">
		<h2><?php _e('Not Found'); ?></h2>
		</div>
		<div <?php post_class(); ?>>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	    </div>
<?php endif; ?>
	
	<div class="title">
		<h2><?php _e('Categories'); ?></h2>
	</div>
	<div <?php post_class(); ?>>
	  <ul class="catlist">
        <?php wp_list_categories('title_li='); ?>	
	  </ul>
	</div>
	
  </div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
