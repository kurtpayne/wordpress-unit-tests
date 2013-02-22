<?php get_header(); ?>
	<div id="body">
	
		<div id="main" class="entry">

			<div class="box">
				<h2><?php _e('Category Archive'); ?></h2>
				<p><?php _e('The following is a list of all entries from the'); ?> <?php single_cat_title('', 'display'); ?> <?php _e('category.'); ?></p>
			</div>


			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php if ( !in_category($noteworthy_cat) ) { ?>
				<?php include (TEMPLATEPATH . '/template-postloop.php'); ?>
				<?php } ?>
						
			<?php endwhile; ?>

			<?php include("nav.php"); ?>

			<?php else: ?>

			<div class="box">
				<h2><?php _e('Not Found') ?></h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			</div>		

		<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

	<?php get_footer(); ?>
