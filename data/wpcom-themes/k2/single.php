<?php get_header(); ?>

<div class="content">
	
	<div id="primary">
		<div id="current-content">
			<div id="primarycontent" class="hfeed">

				<?php include (TEMPLATEPATH . '/theloop.php'); ?>
				<?php comments_template(); ?>

			</div> <!-- #primarycontent .hfeed -->
		</div> <!-- #current-content -->

		<div id="dynamic-content"></div>
	</div> <!-- #primary -->

	<?php get_sidebar(); ?>

</div> <!-- .content -->

<?php get_footer(); ?>
