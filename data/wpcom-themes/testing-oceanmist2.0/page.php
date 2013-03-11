<?php get_header(); ?>

	<div id="mainCol">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<p class="title"><?php edit_post_link('Edit'); ?> Posted by <span><?php the_author() ?></span></p>
		<div class="post" id="post-<?php the_ID(); ?>">
				<h1 class="pageH1"><?php the_title(); ?></h1>
				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				  <?php the_tags('<div class="tags"><p><strong>Tags:</strong> ', ' , ' , '</p></div>'); ?>
				</div>
		</div>
		<?php endwhile; endif; ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>