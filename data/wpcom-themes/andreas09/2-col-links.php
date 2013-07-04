<?php
/*
Template Name: 2 Column Links List
*/
?>

<?php get_header(); ?>

<?php include (TEMPLATEPATH . '/alt-right-sidebar.php'); ?>

<div id="contentalt">

	<div id="page" class="linkspage">

		<h1><?php the_title(); ?></h1>

		<ul>
			<?php wp_list_bookmarks(); ?>
		</ul>
	</div>
	
	<?php edit_post_link(__('Edit this entry.','andreas09'), '<p>', '</p>'); ?>

</div>	

<?php get_footer(); ?>
