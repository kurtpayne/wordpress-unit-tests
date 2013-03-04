<?php
/*
Template Name: Links
*/
?><?php get_header(); ?>
<div id="intro">
<?php the_post(); ?>
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
</div>

<div id="primary">
<?php $link_cats = $wpdb->get_results("SELECT cat_id, cat_name FROM $wpdb->categories WHERE link_count > 0");
foreach ($link_cats as $link_cat) { ?>
	<h3><?php echo $link_cat->cat_name; ?></h3>
	<ul class="navlist" id="linkcat-<?php echo $link_cat->cat_id; ?>">
		<?php get_linksbyname($link_cat->cat_name, '<li>', '</li>', ' ', false, 'name', false, false, -1, false); ?>
	</ul>
<?php } ?>
</div>
<?php if(!get_option('tarski_hide_sidebar')) { get_sidebar(); } ?>
<?php get_footer(); ?>
