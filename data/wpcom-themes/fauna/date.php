<?php get_header(); ?>

	<div id="body">

		<div id="main" class="entry">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php include (TEMPLATEPATH . '/template-postloop.php'); ?>
			
			<?php endwhile;
			include("nav.php");
			else : ?>
			
			<div class="box">
				<h2><?php _e('Not Found') ?></h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			</div>		
		
		<?php endif; ?>
			
		</div>

		<?php get_sidebar(); ?>

	</div>
			
	<?php get_footer(); ?>
