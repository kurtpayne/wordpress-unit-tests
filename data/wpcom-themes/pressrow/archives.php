<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
		
		<div id="content_box">

			<div id="content">

				<div class="post entry">			
				<h2 style="padding-top: 0;"><?php _e('Browse by Month:'); ?></h2>
					<ul>
						<?php wp_get_archives('type=monthly'); ?>
					</ul>
						<h2><?php _e('Browse by Category:'); ?></h2>
					<ul>
						<?php wp_list_cats(); ?>
					</ul>
				</div>

			</div>	
			
			<?php get_sidebar(); ?>
				
		</div>
		
<?php get_footer(); ?>
