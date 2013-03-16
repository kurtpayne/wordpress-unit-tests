<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;', 'contempt').'</p>'); ?>
	
				<?php wp_link_pages(); ?>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>
	<?php edit_post_link(__('Edit this entry.', 'contempt'), '<p>', '</p>'); ?>

	<?php comments_template(); ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
