<?php get_header(); ?>

	<div id="content" class="sanda">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>

		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?>>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a><br />
				<?php the_time(get_option('date_format')) ?></h3>
				
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
				
				<p class="postmetadata">Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('Leave a Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			</div>
	
		<?php endwhile; ?>
		
		<?php 
			// This young snippet fixes something too difficult to explain
			
			$numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'");
			$perpage = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'posts_per_page'");

			if ($numposts > $perpage) {
		?>
				<div class="navigation">
					<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
					<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
				</div>
		<?php
			}
		?>
	
	<?php else : ?>

		<h4>No posts found. Try a different search?</h4>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		<div style="width: 100%; height: 40px;"></div>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
