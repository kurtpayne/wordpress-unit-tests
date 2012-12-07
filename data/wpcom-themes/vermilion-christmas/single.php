<?php get_header(); ?>

<!-- BEGIN SINGLE.PHP -->
<div id="content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post-single">
<h2 class="post-title"><?php the_title(); ?></h2>
<div class="entry">
<?php the_content('Read more &raquo;'); ?>
<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>

<p class="postmetadata">
Posted by <?php the_author() ?> on <?php the_time(get_option('date_format')) ?> at <?php the_time() ?> <br />
Filed under: <?php the_category(', ') ?> &nbsp|&nbsp;
<?php the_tags( 'Tags: ', ', ', ' &nbsp|&nbsp; '); ?>

<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
	// Both Comments and Pings are open ?>
<a href="#respond" class="commentlink">Leave a comment</a> &nbsp;|&nbsp; <a href="<?php trackback_url(true); ?>" rel="trackback" class="trackback">Trackback URI</a>

<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
	// Only Pings are Open ?>
Responses are currently closed, but you can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your own site.

<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
	// Comments are open, Pings are not ?>
You can skip to the end and leave a response. Pinging is currently not allowed.

<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
	// Neither Comments, nor Pings are open ?>
Both comments and pings are currently closed.

<?php } edit_post_link('edit','<div class="edit">[',']</div>'); ?>
</p>
</div>
</div>
<div class="navigation-single">
<?php previous_post_link('<span class="previous-single">Previous Entry: %link</span>') ?>
<?php next_post_link('<br /><span class="next-single">Next Entry: %link</span>') ?>
</div>
<?php comments_template(); ?>
<?php endwhile; else: ?>

<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>
</div>
<!-- END SINGLE.PHP -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
