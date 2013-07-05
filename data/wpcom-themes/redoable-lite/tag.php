<?php get_header(); ?>

<div class="content">
	
	<div id="middlecolumn">

		<div id="primary">
			<?php if( get_option('redo_livesearchposition') == 1 ) { ?>
			<div id="current-content">
			<?php } ?>
				
				<div id="<?php echo $prefix; ?>primarycontent" class="hfeed">
					<?php include (TEMPLATEPATH . '/theloop.php'); ?>
				</div>

			<?php if( get_option('redo_livesearchposition') == 1 ) { ?>
			</div> <!-- #current-content -->
			
			<div id="dynamic-content"></div>
			<?php } ?>

		</div><!-- #primary -->
	</div>
	
	<div id="rightcolumn">
		<?php get_sidebar(); ?>
	</div>
	<div class="clear"></div>


</div> <!-- .content -->

<?php get_footer(); ?>