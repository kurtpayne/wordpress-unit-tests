<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

		<h2><?php the_title(); ?></h2>

	<?php
		the_content();
		wp_link_pages();
		comments_template();
	endwhile;
	endif; ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
