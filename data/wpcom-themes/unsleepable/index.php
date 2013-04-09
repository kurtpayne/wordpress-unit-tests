<?php get_header(); ?>

<div class="content">
	
	<div class="primary">

		<?php include (TEMPLATEPATH . '/theloop.php'); ?>

	</div>

	<?php get_sidebar(); ?>
	
<?php if (!is_paged() && is_home()) { ?>
	<?php include("bottomblock.php"); ?>
	<?php } ?>

</div>
<?php get_footer(); ?>
