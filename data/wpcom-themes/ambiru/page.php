<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( "entry entry-$postCount" ); ?>>
		<div class="entrytitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'ambiru'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2> 
		</div>
		<div class="entrybody">
			<?php the_content('Read the rest of this entry &raquo;'); ?>
			<?php wp_link_pages(); ?>
		</div>
		
		<div class="entrymeta"><?php edit_post_link(__('Edit', 'ambiru'), '', ' | '); ?></p>
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
		<div class="entrybody"><?php _e("Sorry, but you are looking for something that isn't here.","ambiru"); ?></div>

	<?php endif; ?>
	
</div>


<?php get_sidebar(); ?>


<?php get_footer(); ?>
</body>
</html>
