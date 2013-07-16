<?php get_header(); ?>

<div class="content">
	
	<div id="middlecolumn">
		<div id="primary">
			<?php if( get_option('redo_livesearchposition') == 1 ) { ?>
			<div id="current-content">
			<?php } ?>
			
				<div id="primarycontent" class="hfeed">
					
					<?php include (TEMPLATEPATH . '/single_post.php'); ?>
					
				</div> <!-- #primarycontent .hfeed -->
			
			<?php if( get_option('redo_livesearchposition') == 1 ) { ?>
			</div> <!-- #current-content -->
			
			<div id="dynamic-content"></div>
			<?php } ?>
			
		</div> <!-- #primary -->
	</div>

	<?php comments_template(); ?>

	<div id="rightcolumn">
		<?php get_sidebar(); ?>
	</div>
	<div class="clear"></div>

</div> <!-- .content -->

<?php get_footer(); ?>
