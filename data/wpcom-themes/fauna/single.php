<?php get_header(); ?>

	<div id="body">
	
		<div id="main" class="entry">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
			<div class="box">
				<?php previous_post('&laquo; % |','','yes') ?>
				<a href="<?php bloginfo('url'); ?>"><?php _e('Home') ?></a>
				<?php next_post('| % &raquo;','','yes') ?>
			</div>
		
			<hr />
		
			<?php include (TEMPLATEPATH . '/template-postloop.php'); ?>

			<?php comments_template(); ?>

			<?php endwhile; else: ?>
			
			<div class="box">
				<h2><?php _e('Not Found') ?></h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			</div>		
			
		<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

	<?php get_footer(); ?>