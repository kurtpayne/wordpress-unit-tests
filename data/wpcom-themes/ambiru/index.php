<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( "entry entry-$postCount" ); ?>>
		<div class="entrytitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','ambiru'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2> 
			<h3><?php the_time(get_option("date_format")); ?></h3>
		</div>
		<div class="entrybody">
			<?php the_content(__('Read the rest of this entry &raquo;','ambiru')); ?>
			<?php wp_link_pages(); ?>
		</div>

		
		<div class="entrymeta">
		<div class="postinfo">
			<div class="postedby"><?php _e('Posted by','ambiru'); ?> <?php the_author() ?></div>
			<div class="filedto"><?php _e('Filed in','ambiru'); ?> <?php the_category(', ') ?> <?php the_tags( ' &#183;' . __( 'Tags' ) . ': ', ', ', ''); ?> <?php edit_post_link(__('Edit','ambiru'), ' | ', ''); ?></div>
		</div>
		<?php comments_popup_link(__('Leave a Comment &#187;','ambiru'), __('1 Comment &#187;','ambiru'), __('% Comments &#187;','ambiru'), 'commentslink', __('Comments off','ambiru')); ?>
		</div>
		
	</div>
	<div class="commentsblock">
		<?php comments_template(); ?>
	</div>
		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries', 'ambiru')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;', 'ambiru')) ?></div>
		</div>
		
	<?php else : ?>

		<h2><?php _e('Not Found', 'ambiru'); ?></h2>
		<div class="entrybody"><?php _e("Sorry, but you are looking for something that isn't here.", "ambiru"); ?></div>

	<?php endif; ?>
	
</div>


<?php get_sidebar(); ?>


<?php get_footer(); ?>
</body>
</html>
