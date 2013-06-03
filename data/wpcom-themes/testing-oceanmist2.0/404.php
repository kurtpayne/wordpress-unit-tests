<?php get_header(); ?>

	<div id="mainCol">
    	<p class="title">Page Not Found</p>
			<div class="post">
				<h1>Sorry, the page you're looking for doesn't seem to exist...</h1>
				<p>Why not return to the <a href="<?php echo get_option('home'); ?>/">homepage</a>, or maybe you'd like to search for something:</p>
		    <?php include (TEMPLATEPATH . "/searchform.php"); ?>
			</div>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>