<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
				<h1><?php the_title(); ?></h1>
					<div class="entrytext">
						<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
						<?php wp_link_pages(); ?>			
					</div>
				</div>
			  <?php endwhile; endif; ?>
	
				<?php comments_template(); ?>
				
			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
