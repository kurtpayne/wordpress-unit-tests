<?php get_header(); ?>

<!-- BEGIN ARCHIVE.PHP -->
<div id="content">
<?php is_tag(); ?>
<?php if (have_posts()) : ?>

<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<h2 class="archive-title">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>

<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
<h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>

<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="archive-title">Archive for <?php the_time('F jS, Y'); ?></h2>

<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="archive-title">Archive for <?php the_time('F, Y'); ?></h2>

<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="archive-title">Archive for <?php the_time('Y'); ?></h2>

<?php /* If this is a search */ } elseif (is_search()) { ?>
<h2 class="archive-title">Search Results</h2>

<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="archive-title">Author Archive</h2>

<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="archive-title">Blog Archives</h2>

<?php } ?>
<?php while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?>>
<h3 class="post-title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
<small><?php the_time(get_option('date_format')) ?> <!-- by <?php the_author() ?> --></small>
<div class="entry">
<?php the_excerpt(); ?>
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
<!-- END ARCHIVE.PHP -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
