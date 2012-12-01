<?php get_header(); ?>

	<div id="mainCol">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
    	<p class="title"><?php next_post_link('%link', '<span class="next">Next Post</span>'); ?> <?php previous_post_link('%link', '<span class="prev">Previous Post</span>'); ?> <?php edit_post_link('Edit'); ?></p>
			<div class="post" id="post-<?php the_ID(); ?>">
				<p class="date">
				  <span class="d1"><?php the_time('j') ?></span>
					 <span class="d2"><?php the_time('M') ?></span>
					 <span class="d3"><?php the_time('Y') ?></span>
				</p>
				<h1><?php the_title(); ?></h1>
				<p class="author">Posted by <span><?php the_author() ?></span></p>
				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				  <?php the_tags('<div class="tags"><p><strong>Tags:</strong> ', ' , ' , '</p></div>'); ?>
				</div>
			</div>
			
	<?php comments_template(); ?>

	<?php endwhile; else: ?>
		<h2 class="center">Oops...</h2>
		<p class="center">Sorry, no posts matched your criteria.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
		
	<?php endif; ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
