<?php get_header(); ?>
<?php get_sidebar(); ?>

		<div class="narrowcolumn">

<?php include(TEMPLATEPATH . '/top-menu.php'); ?>

<!-- CONTENT -->

	<div <?php post_class(); ?>>
<h2><?php _e('Not Found'); ?></h2>
<div class="entry"><?php _e('Sorry, but you are looking for something that isn&#39;t here.'); ?></div>
	</div>

<!-- END CONTENT -->

		</div>

<?php get_footer(); ?>