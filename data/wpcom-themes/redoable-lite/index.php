<?php get_header(); ?>

<div class="content">
	
	<div id="middlecolumn">

		<div id="primary">
				
				<div id="<?php echo $prefix; ?>primarycontent" class="hfeed">
					<?php include (TEMPLATEPATH . '/theloop.php'); ?>
				</div>

		</div><!-- #primary -->
	</div>
	
	<div id="rightcolumn">
		<?php get_sidebar(); ?>
	</div>
	<div class="clear"></div>


</div> <!-- .content -->

<?php get_footer(); ?>
