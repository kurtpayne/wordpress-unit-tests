<?php get_header(); ?>

		<div class="title">
			<h2><?php _e('Error 404 - File Not Found'); ?></h2>
		</div>
        <div <?php post_class(); ?>>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		  <?php include (TEMPLATEPATH . "/searchform.php"); ?>
	    </div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
