<?php get_header(); ?>
<?php include("loop.php"); ?>
<?php get_sidebar(); ?>
<?php if(is_single() || is_page()) { comments_template(); } ?>
<?php get_footer(); ?>