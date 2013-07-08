<?php get_header(); ?>
<div class="content">
<div class="primary">

	<?php 
		if (have_posts()) {  
		while (have_posts()) { the_post(); ?>
	
	<div id="post-<?php the_ID(); ?>" <?php post_class('item entry'); ?>>
		<div class="itemhead">
			<h3><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h3>
			
			<?php edit_post_link('<img src="'.get_bloginfo('template_directory').'/images/pencil.png" alt="Edit Link" />','<span class="editlink">','</span>'); ?>
			
			<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
			<p class="caption"></p></p><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></p>
			<p class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></p>
			
			<div class="navigation">
				<p class="alignleft"><?php previous_image_link() ?></p>
				<p class="alignright"><?php next_image_link() ?></p>
			</div>
		</div>
	</div>
	
	<?php }
	
	if (!is_single()) { include (TEMPLATEPATH . '/navigation.php'); } 
	
	} else { $notfound = '1'; /* So we can tell the sidebar what to do */ ?>
	
		<div class="center">
			<h2>Not Found</h2>
		</div>
		
		<div class="item">
			<div class="itemtext2">
			<p>Oh no! You're looking for something which just isn't here! Fear not however,
			errors are to be expected, and luckily there are tools on the sidebar for you to
			use in your search for what you need.</p>
			</div>
		</div>
	
	<?php } ?>
	
	<?php comments_template(); ?>
	
</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>