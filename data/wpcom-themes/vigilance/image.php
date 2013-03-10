<?php get_header(); ?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="post-header">
        <h1><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h1>
			</div><!--end post header-->
			<div class="entry clear">
				<p><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
				<p class="caption"></p></p><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></p>
				<p class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></p>
			        <?php edit_post_link(__('Edit This', 'vigilance'),'<p>','</p>'); ?>
			<div class="navigation">
					<div class="alignleft"><?php previous_image_link() ?></div>
					<div class="alignright"><?php next_image_link() ?></div>
			</div>
			</div><!--end entry-->
			<div class="post-footer">&nbsp;
			</div><!--end post footer-->
			
		</div><!--end post-->
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		<?php comments_template('', true); ?>
		<?php else : ?>
		<?php endif; ?>
	</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
