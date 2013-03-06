<?php get_header(); ?>

<div class="content">
	
	<div id="primary">
		<div id="current-content">

<div id="<?php echo $prefix; ?>primarycontent" class="hfeed">
        <?php include (TEMPLATEPATH . '/theloop.php'); ?>
</div><!-- #<?php echo $prefix; ?>primarycontent .hfeed -->
<p align="center"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page', 'k2_domain'), __('Next Page &raquo;', 'k2_domain')); ?></p>	
		</div> <!-- #current-content -->

		<div id="dynamic-content"></div>
	</div> <!-- #primary -->

	<?php get_sidebar(); ?>
	
</div> <!-- .content -->

<?php get_footer(); ?>
