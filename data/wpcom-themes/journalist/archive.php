<?php get_header(); ?>

<div id="content">
<?php if (have_posts()) : ?>

<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<h2 class="archive"><?php printf(__('Archive for the &#8216;<strong>%s</strong>&#8217; Category', 'journalist'), single_cat_title('', false)); ?></h2>
<?php /* If this is a tag */ } elseif (is_tag()) { ?>
<h2 class="archive"><?php printf(__('Posts Tagged &#8216;<strong>%s</strong>&#8217;', 'journalist'), single_tag_title('', false)); ?></h2>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="archive"><?php printf(__('Archive for <strong>%s</strong>', 'journalist'), get_the_time('F jS, Y')); ?></h2>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="archive"><?php printf(__('Archive for <strong>%s</strong>', 'journalist'), get_the_time('F Y')); ?></h2>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="archive"><?php printf(__('Archive for <strong>%s</strong>', 'journalist'), get_the_time('Y')); ?></h2>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="archive"><?php _e('Author Archive', 'journalist'); ?></h2>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="archive"><?php _e('Blog Archives', 'journalist'); ?></h2>
<?php } ?>

<?php while (have_posts()) : the_post(); ?>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p class="comments"><a href="<?php comments_link(); ?>"><?php comments_number(__('without comments', 'journalist'),__('with one comment', 'journalist'),__('with % comments', 'journalist')); ?></a></p>

<div class="main">
	<?php the_content(__('Read the rest of this entry &raquo;', 'journalist')); ?>
</div>

<div class="meta group">
<div class="signature">
    <p><?php printf( __('Written by %s', 'journalist'), get_the_author() ); ?> <span class="edit"><?php edit_post_link(__('Edit', 'journalist')); ?></span></p>
    <p><?php printf( __('%s at %s', 'journalist'), get_the_time(get_option('date_format')), get_the_time(get_option('time_format'))); ?></p>
</div>	
<div class="tags">
    <p><?php printf( __('Posted in %s', 'journalist'), get_the_category_list(',')); ?></p>
    <?php if ( the_tags('<p>' . __('Tagged with', 'journalist') .' ', ', ', '</p>') ) ?>
</div>
</div>

<?php endwhile; else: ?>
<div class="warning">
	<p><?php _e("Sorry, but you are looking for something that isn't here.", 'journalist'); ?></p>
</div>
<?php endif; ?>

<div class="navigation group">
	<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'journalist')) ?></div>
	<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'journalist')) ?></div>
</div>

</div> 

<?php get_sidebar(); ?>

<?php get_footer(); ?>
