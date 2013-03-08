<?php get_header(); ?>
<div id="content">
<?php is_tag(); ?>
	<?php if (have_posts()) :?>
		<?php while (have_posts()) : the_post();?>
	<div <?php post_class('entry entry-' . $postCount); ?> id="post-<?php the_ID(); ?>">
		<div class="entrytitle">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
		</div>
		<div class="entrybody">
			<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
			<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
			<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

			<div class="navigation">
				<div class="alignleft"><?php previous_image_link() ?></div>
				<div class="alignright"><?php next_image_link() ?></div>
			</div>
		</div>
		
		<div class="entrymeta">
		<div class="postinfo">
			<?php edit_post_link(__('Edit'), '<span class="filedto">', '</span>'); ?>
		</div>
		<?php comments_popup_link('Leave a Comment &#187;', '1 Comment &#187;', '% Comments &#187;', 'commentslink'); ?>
		</div>
		
	</div>
	<div class="commentsblock">
		<?php comments_template(); ?>
	</div>
	<?php endwhile; ?>
		
	<?php else : ?>

		<h2>Not Found</h2>
		<div class="entrybody">Sorry, but you are looking for something that isn't here.</div>

	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
