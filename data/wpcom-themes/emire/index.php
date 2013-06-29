<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( "entry entry-$postCount" ); ?>>
		<div class="entrytitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','emire'), get_the_title()) ?>"><?php the_title(); ?></a></h2>
			<h3><?php the_time(get_option('date_format')) ?></h3>
		</div>
		<div class="entrybody">
			<?php the_content(__('Read the rest of this entry','emire').' &raquo;'); ?>
			<?php wp_link_pages(); ?>
		</div>
		
		<div class="entrymeta">
		<div class="postinfo">
			<div class="postedby"><?php printf(__('Posted by %s','emire'), get_the_author()) ?></div>
			<div class="filedto"><?php printf(__('Filed in %s','emire'), get_the_category_list(', ')) ?> <?php the_tags( '<br />' . __( 'Tagged' ) . ': ', ', ', ''); ?> <?php edit_post_link(__('Edit','emire'), ' | ', ''); ?></div>
		</div>
		<?php comments_popup_link(__('Leave a Comment','emire').' &#187;', __('1 Comment','emire').' &#187;', __('% Comments','emire').' &#187;', 'commentslink'); ?>
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

		<h2><?php _e('Not Found','emire'); ?></h2>
		<div class="entrybody"><?php _e('Sorry, but you are looking for something that isn\'t here.','emire'); ?></div>

	<?php endif; ?>
	
</div>


<?php get_sidebar(); ?>


<?php get_footer(); ?>
</body>
</html>


