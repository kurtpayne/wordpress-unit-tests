<?php get_header(); ?>

<div class="content">
	
	<div id="middlecolumn">

		<div id="primary">
			<div id="current-content">
				
				<div id="<?php echo $prefix; ?>primarycontent" class="hfeed">

					<div class="hentry four04">

						<div class="page-head">
							<h2><?php _e('Error 404 - Not Found','redo_domain'); ?></h2>
						</div>

						<div class="entry-content">
							<p><?php _e('Oh no! You\'re looking for something which just isn\'t here! Fear not however, errors are to be expected, and luckily there are tools on the sidebar for you to use in your search for what you need.','redo_domain'); ?></p>
						</div>

					</div> <!-- .hentry .four04 -->

				</div>

			</div> <!-- #current-content -->

		</div><!-- #primary -->
	</div>
	
	<div id="rightcolumn">
		<?php get_sidebar(); ?>
	</div>
	<div class="clear"></div>

</div> <!-- .content -->

<?php get_footer(); ?>

<!-- jegelskerRikke -->
