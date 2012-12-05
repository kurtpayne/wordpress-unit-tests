<?php
/*
Template Name: 2 Column Page
*/
?>

<?php get_header(); ?>
<?php include (TEMPLATEPATH . '/alt-right-sidebar.php'); ?>

<div id="contentalt">
	<div id="page">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<h1><?php the_title(); ?></h1>

		<div class="entrytext">	
			<?php the_content('<p class="serif">'.__('Read the rest of this page &raquo;','andreas09').'</p>'); ?>
		</div>
		
		<?php link_pages('<p><strong>'.__('Pages','andreas09').':</strong> ', '</p>', 'number'); ?>
		
		<?php endwhile; endif; ?>
	
	</div>
	<?php comments_template(); ?>	
	<?php edit_post_link(__('Edit this entry.','andreas09'), '<p>', '</p>'); ?>

</div>

<?php get_footer(); ?>
