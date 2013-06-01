<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( "entry entry-$postCount" ); ?>>
		<div class="entrytitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','emire'), get_the_title()) ?>"><?php the_title(); ?></a></h2>
		</div>
		<div class="entrybody">
			<?php the_content(__('Read the rest of this entry','emire').' &raquo;'); ?>
			<?php wp_link_pages(); ?>
		</div>
		
		<div class="entrymeta"><?php edit_post_link(__('Edit','emire'), '', ' | '); ?>  <?php comments_popup_link(__('Leave a Comment','emire').' &#187;', __('1 Comment','emire').' &#187;', __('% Comments','emire').' &#187;'); ?></p>
		</div>
		
	</div>
	<div class="commentsblock">
		<?php comments_template(); ?>
	</div>
		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; '.__('Previous Entries','emire')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries','emire').' &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2>Not Found</h2>
		<div class="entrybody"><?php _e('Sorry, but you are looking for something that isn\'t here.','emire'); ?></div>

	<?php endif; ?>
	
</div>


<?php get_sidebar(); ?>


<?php get_footer(); ?>
</body>
</html>


