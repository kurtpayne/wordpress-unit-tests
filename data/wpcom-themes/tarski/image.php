<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

<div id="primary">

<?php while ( have_posts() ) : the_post(); ?>
	<div class="entry">
		<div class="post-meta">
			<h1 class="post-title" id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h1>
			<p class="post-metadata"><?php edit_post_link('Edit',' (',')'); ?></p>
		</div>
		<div class="post-content">
			<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
			<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
			<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

			<div class="navigation">
				<div class="alignleft"><?php previous_image_link() ?></div>
				<div class="alignright"><?php next_image_link() ?></div>
			</div>
		</div>
	</div>
<?php endwhile; ?>
</div>
<?php else : // have_posts (top of file) ?>
	<div id="primary">
		<div class="entry static">
			<div class="post-meta">
				<h1 class="post-title" id="error-404">Error 404</h1>
			</div>

			<div class="post-content">
				<p>The page you are looking for does not exist; it may have been moved, or removed altogether. You might want to try the search function. Alternatively, return to the <a href="<?php echo get_settings('home'); ?>">front page</a>.</p>
			</div>
		</div>
	</div>
<?php endif; // have_posts (top of file)

get_sidebar();
comments_template();
get_footer();
?>
