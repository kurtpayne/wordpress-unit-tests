<?php get_header(); ?>
<!-- borrowed directly from Kubrick -->

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle"><?php _e('Search Results'); ?></h2>
		
		<div class="navigation">
			<div class="alignleft"><?php previous_posts_link(__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php next_posts_link(__('Next Entries &raquo;')) ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?>>
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time(get_option("date_format")); ?></small>
				
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
		
				<p class="postmetadata"><?php _e('Posted in'); ?> <?php the_category(', ') ?> | <?php edit_post_link(__('Edit'),'',' | '); ?>  <?php comments_popup_link(__('Leave a Comment &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></p> 
				
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php previous_posts_link(__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php next_posts_link(__('Next Entries &raquo;')) ?></div>
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
