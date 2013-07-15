<?php get_header(); ?>

<div class="content">
	
	<div id="primary">
		<div id="current-content">

			<?php include (TEMPLATEPATH . '/theloop.php'); ?>
			<p align="center"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page', 'k2_domain'), __('Next Page &raquo;', 'k2_domain')); ?></p>
		</div> <!-- #current-content -->
		<div id="dynamic-content"></div>
	</div> <!-- #primary -->

	<?php get_sidebar(); ?>

</div> <!-- .content -->

<?php get_footer(); ?>
