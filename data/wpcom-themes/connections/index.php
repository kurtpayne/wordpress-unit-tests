<?php get_header(); ?>

	<div id="main">
	<div id="content">
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div <?php post_class(); ?>>
				<?php require('post.php'); ?>
				<?php comments_template(); // Get wp-comments.php template ?>
			</div>
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		<p align="center"><?php posts_nav_link() ?></p>		
	</div>
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>
</div>
</div>
</body>
</html>
