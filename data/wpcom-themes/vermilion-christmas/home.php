<?php get_header(); ?>

<!-- BEGIN HOME.PHP -->
<div id="content">
<!-- Begin conditional statement -->
<?php if ( $paged < 2 ) { // Do stuff specific to first page?>
<?php } else { // Do stuff specific to non-first page ?>
<!-- optional content for /page/2/ and up goes here -->
<?php include (TEMPLATEPATH . "/navigation.php"); ?>
<?php } ?>
<!-- End conditional statement -->

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?>>
<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
<small><?php the_time(get_option('date_format')) ?> <!-- by <?php the_author() ?> --></small>
<div class="entry">
<?php the_content('Read more &raquo;'); ?>
</div>
<p class="postmetadata">Posted in <?php the_category(', ') ?> &nbsp;|&nbsp; <?php the_tags('Tags: ', ', ', ' &nbsp;|&nbsp; '); ?> <span class="commentlink"><?php comments_popup_link('Leave a Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span></p>
<?php edit_post_link('edit','<div class="edit">[',']</div>'); ?>
</div>
<?php endwhile; ?>
<?php include (TEMPLATEPATH . "/navigation.php"); ?>
<?php else : ?>
<h2 class="center">Not Found</h2>
<p class="center">Sorry, but you are looking for something that isn't here.</p>
<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>
</div>
<!-- END HOME.PHP -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
