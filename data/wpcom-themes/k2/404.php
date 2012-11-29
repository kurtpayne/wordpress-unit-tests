<?php get_header(); ?>

<div class="content">
	
	<div id="primary">
		<div id="current-content">
			<div id="primarycontent" class="hfeed">

				<div class="hentry four04">

					<div class="page-head">
						<h2><?php _e('Error 404 - Not Found','k2_domain'); ?></h2>
					</div>

					<div class="entry-content">
						<p><?php _e('Oh no! You\'re looking for something which just isn\'t here! Fear not however, errors are to be expected, and luckily there are tools on the sidebar for you to use in your search for what you need.','k2_domain'); ?></p>
					</div>

				</div> <!-- .hentry .four04 -->

			</div> <!-- #primarycontent .hfeed -->
		</div> <!-- #current-content -->

		<div id="dynamic-content"></div>
	</div> <!-- #primary -->

	<?php $notfound = '1'; /* So we can tell the sidebar what to do */ ?>
	<?php get_sidebar(); ?>

</div> <!-- .content -->

<?php get_footer(); ?>

<!-- jegelskerRikke -->