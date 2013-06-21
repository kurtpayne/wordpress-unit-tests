<?php get_header(); ?>

<!-- BEGIN search.php -->
<div id="content">
<?php if (have_posts()) : ?>
<h2 class="search-title">Search Results for &quot;<?php echo wp_specialchars($s); ?>&quot;...</h2>
<?php while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?>>
<h3 class="post-title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
<small><?php the_time(get_option('date_format')) ?> <!-- by <?php the_author() ?> --></small>
<div class="entry">
<?php the_excerpt(); ?>
</div>
<p class="postmetadata">Posted in <?php the_category(', ') ?> &nbsp;|&nbsp; <span class="commentlink"><?php comments_popup_link('Leave a Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span><br /><?php the_tags('Tags: ', ', ', '<br />'); ?></p>
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
<!-- END search.php -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
