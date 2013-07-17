<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="bloque">

	<div id="noticias">
		<div class="entrada">
			<h2>Archives</h2>
				<h3>By month:</h3>
				<ul>
					<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
				</ul>
			
				<h3>By category:</h3>
				<ul>
					<?php wp_list_cats('sort_column=name&optioncount=1&feed=Feed'); ?>
				</ul>
		</div>
	</div>

<?php get_footer(); ?>
