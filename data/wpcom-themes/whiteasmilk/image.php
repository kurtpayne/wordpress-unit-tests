<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="content" class="narrowcolumn" style="margin:0px; ">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div <?php post_class(); ?>>
		<h2 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
		
		<div class="entry">
			<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
			<p class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></p>
			<p class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></p>
		</div>
		
		<div class="navigation">
			<div class="alignleft"><?php previous_image_link() ?></div>
			<div class="alignright"><?php next_image_link() ?></div>
		</div>	
		
		<?php  edit_post_link(__('Edit this entry.','whiteasmilk'),'',''); ?>
	
	</div>
	
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.','whiteasmilk'); ?></p>
	
	<?php endif; ?>

</div> 

<?php get_footer(); ?>
