<?php get_header(); ?>

	<div id="bloque">
		<div id="noticias">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div <?php post_class( 'entrada' ); ?>>
				<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?> </h2>
				<small style="font-size: 10px; "><?php edit_post_link('Edit this page'); ?></small>
				
				
			<?php the_content("Continue reading ".the_title('', '', false)."..."); ?>
			
			<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div>
			<?php comments_template(); ?>
		</div>

		<?php endwhile; endif; ?>

<?php get_footer(); ?>
