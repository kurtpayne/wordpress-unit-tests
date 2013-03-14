<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="pagepost">
		<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
			<div class="entrytext">
				<?php the_content('<p class="serif">'.__('Read more &raquo;', 'black-letterhead').'</p>'); ?>
	
				<?php wp_link_pages(); ?>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>
	<?php edit_post_link(__('Edit this entry.', 'black-letterhead'), '<p>', '</p>'); ?>

	<?php comments_template(); ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
