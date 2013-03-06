<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div <?php post_class('entry entry-' . $postCount); ?> id="post-<?php the_ID(); ?>">
		<div class="entrytitle">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2> 
			<?php if (!is_page()) { ?>
			<?php } ?>
		</div>
		<div class="entrybody">
			<div class="attachment">
			<p><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
			<p class="caption"></p></p><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></p>
			<p class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></p>
			
				<div class="navigation">
					<p class="alignleft"><?php previous_image_link() ?></p>
					<p class="alignright"><?php next_image_link() ?></p>
				</div>
			</div>
		</div>
		
		<div class="entrymeta"><?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('Leave a Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?><br /><?php the_tags('Tags: ', ', ', '<br />'); ?></p>
		</div>
		
	</div>
	<div class="commentsblock">
		<?php comments_template(); ?>
	</div>
		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>
		
	<?php else : ?>

		<h2>Not Found</h2>
		<div class="entrybody">Sorry, but you are looking for something that isn't here.</div>

	<?php endif; ?>
	<?php get_footer(); ?>
	</div>


<?php get_sidebar(); ?>

</div>
</body>
<?php wp_footer(); ?>
</html>
