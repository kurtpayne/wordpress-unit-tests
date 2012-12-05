<?php
/**
 *	@package WordPress
 *	@subpackage Grid_Focus
 */
get_header();
?>
<div id="filler" class="fix">
	<div id="mainColumn" class="fix"><a name="main"></a>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="postMeta fix">
				<p class="container">
					<span class="date"><?php edit_post_link(' (Edit)', '', ''); ?></span>
				</p>
			</div>
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
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
		<div id="commentsContainer">
			<?php comments_template(); ?>
		</div>
		<?php endwhile; else: ?>
		<div class="post">
			<h2>No matching results</h2>
			<div class="entry">
				<p>You seem to have found a mis-linked page or search query with no associated results. Please trying your search again. If you feel that you should be staring at something a little more concrete, feel free to email the author of this site or browse the archives.</p>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php include (TEMPLATEPATH . '/second.column.post.php'); ?>
	<?php include (TEMPLATEPATH . '/third.column.shared.php'); ?>
</div>
<?php get_footer(); ?>
