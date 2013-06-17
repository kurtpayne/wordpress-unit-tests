<?php get_header(); ?>

<div id="content">

	<?php // Post dates off by default the_date('','<h2>','</h2>'); ?>
	<h2><?php _e('Not found', 'journalist-13'); ?></h2>
	<div class="warning">
		<p><?php _e('Apologies, but we were unable to find what you were looking for. Perhaps  searching will help.', 'journalist-13') ?></p>
	</div>

</div> <!-- End content -->

<?php get_sidebar(); ?>

<div class="clearleft"></div>

<?php get_footer(); ?>
