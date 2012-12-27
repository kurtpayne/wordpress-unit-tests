<?php get_header(); ?>

<div id="content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<?php if ( comments_open() || have_comments() ) : ?>
	<p class="comments"><a href="<?php comments_link(); ?>"><?php comments_number(__('without comments', 'journalist'),__('with one comment', 'journalist'),__('with % comments', 'journalist')); ?></a></p>
<?php endif; ?>

<div class="main">
	<?php the_content('<p class="serif">' . __('Read the rest of this page &raquo;', 'journalist') . '</p>'); ?>
	<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:','journalist') . '</strong> ')); ?>
</div>

<div class="meta group">
<div class="signature">
    <p><?php printf(__('Written by %s','journalist'), get_the_author()); ?> <span class="edit"><?php edit_post_link(__('Edit','journalist')); ?></span></p>
    <p><?php the_time(get_option('date_format')); ?> <?php _e('at','journalist'); ?> <?php the_time(); ?></p>
</div>	
</div>

<?php comments_template(); ?>

<?php endwhile; else: ?>
<div class="warning">
	<p><?php _e("Sorry, but you are looking for something that isn't here.", 'journalist'); ?></p>
</div>
<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
