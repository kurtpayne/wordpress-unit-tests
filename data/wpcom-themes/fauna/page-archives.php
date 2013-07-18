<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

	<div id="body">

		<div id="main" class="entry">
			<div class="box">
				<h2><?php _e('Archives by Month') ?></h2>
				<ul>
					<? get_archives('monthly', '', 'html', '', '', true); ?>
				</ul>
				
				<br />
				
				<h2><?php _e('Last 50 Entries') ?></h2>
				<ul>
					<?php get_archives('postbypost','50','html','','', false); ?> 
				</ul>
			</div>
			
			<hr />

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>