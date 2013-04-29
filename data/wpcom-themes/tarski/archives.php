<?php
/*
Template Name: Archives
*/
?><?php get_header(); ?>
	<div id="intro">
		<h1><?php _e('Archives'); ?></h1>
	</div>
<?php if(function_exists(srg_clean_archives)) { ?>
	<div id="primary">
		<h3><?php _e('Monthly archives'); ?></h3>

		<ul class="archivelist">
		<?php srg_clean_archives(); ?>
		</ul>
	</div>
<?php } else { ?>
	<div id="primary">
		<h3><?php _e('Monthly archives'); ?></h3>

		<ul class="archivelist">
		<?php get_archives('monthly', '', 'html', '', '', 'TRUE'); ?>
		</ul>
	</div>
<?php } ?>
	<div id="secondary">
		<?php if(!get_option('tarski_hide_categories')) { ?>
		<h3><?php _e('Category archives'); ?></h3>
		<ul class="archivelist">
		<?php wp_list_cats('sort_column=name&sort_order=desc'); ?>
		</ul>
		<?php } // end hide categories code ?>
		<?php @include('constants.php'); echo $archivesPageInclude; ?>
	</div>
<?php get_footer(); ?>