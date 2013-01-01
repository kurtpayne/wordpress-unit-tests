<?php get_header(); ?>

<!-- BEGIN INDEX.PHP -->
<div id="content">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<small><?php the_time(get_option('date_format')) ?> <!-- by <?php the_author() ?> --></small>
<div class="entry">
<?php the_content('Read the rest of this entry &raquo;'); ?>
</div>
<p class="postmetadata">Posted in <?php the_category(', ') ?> &nbsp;|&nbsp; <?php the_tags('Tags: ', ', ', ' &nbsp;|&nbsp; '); ?> <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('Leave a Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>

<?php endwhile; ?>
<div class="navigation">
<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
</div>
<?php else : ?>
<h2 class="center">Not Found</h2>
<p class="center">Sorry, but you are looking for something that isn't here.</p>
<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>
</div>
<!-- END INDEX.PHP -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
