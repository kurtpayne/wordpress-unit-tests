<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
		
	<div id="content_box">

		<div id="content" class="pages">
		
		<h2><?php _e('Browse the Archives...','cutline'); ?></h2>
			<div class="entry">
			<h3 class="top"><?php _e('by month:','cutline'); ?></h3>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
					<h3><?php _e('by Category:','cutline'); ?></h3>
				<ul>
					<?php wp_list_categories('title_li='); ?>
				</ul>
			</div>
			<h4></h4>
			
		</div>	
		
		<?php get_sidebar(); ?>
			
	</div>
		
<?php get_footer(); ?>
