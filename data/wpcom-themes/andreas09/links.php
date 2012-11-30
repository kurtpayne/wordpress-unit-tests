<?php

/*

Template Name: Links List

*/

?>

<?php get_header(); ?>
<?php get_sidebar();?>
<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

<div id="content">

<div id="page" class="linkspage">
<h1><?php the_title(); ?></h1>

<ul>

<?php wp_list_bookmarks(); ?>

</ul>
</div>
	<?php edit_post_link(__('Edit this entry.','andreas09'), '<p>', '</p>'); ?>


</div>	



<?php get_footer(); ?>
