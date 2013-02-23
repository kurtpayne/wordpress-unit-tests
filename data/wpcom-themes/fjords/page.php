<?php get_header(); ?>
	<div id="pagina">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<h2 class="pagina-titulo" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
			
		<?php the_content(__('Read the rest of this page &raquo;')); ?>
		<?php wp_link_pages(); ?>
		
		<?php edit_post_link(__('Edit'), '<p>', '</p>'); ?>
	
	<?php endwhile; endif; ?>
	</div>
	<?php comments_template(); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
