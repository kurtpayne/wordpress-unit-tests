<?php get_header(); ?>

	<div id="mainCol">

	<?php if (have_posts()) : ?>

	<h2 class="title"><?php next_post_link('%link', '<span class="next">Next Post</span>'); ?> <?php previous_post_link('%link', '<span class="prev">Previous Post</span>'); ?> Search results</h2>

		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<p class="date">
				  <span class="d1"><?php the_time('j') ?></span>
					 <span class="d2"><?php the_time('M') ?></span>
					 <span class="d3"><?php the_time('Y') ?></span>
				</p>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				<p class="author">Posted by <span><?php the_author() ?></span>. <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></p>
				<?php the_tags('<div class="tags"><p><strong>Tags:</strong> ', ' , ' , '</p></div>'); ?>
			</div>
		<?php endwhile; ?>

	<?php else : ?>
		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
		
	<?php endif; ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
