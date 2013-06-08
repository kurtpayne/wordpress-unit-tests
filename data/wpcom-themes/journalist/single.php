<?php get_header(); ?>

<div id="content" class="group">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<?php if ( comments_open() || have_comments() ) : ?>
	<p class="comments"><a href="<?php comments_link(); ?>"><?php comments_number(__('leave a comment &raquo;','journalist'), __('with one comment','journalist'), __('with % comments','journalist')); ?></a></p>
<?php endif; ?>

<div class="main">
	<?php the_content(__('Read the rest of this entry &raquo;','journalist')); ?>
	<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:','journalist') . '</strong> ')); ?>
</div>

<div class="meta group">
<div class="signature">
    <p><?php printf(__('Written by %s','journalist'), get_the_author()); ?> <span class="edit"><?php edit_post_link(__('Edit','journalist')); ?></span></p>
    <p><?php the_time(get_option('date_format')); ?> <?php _e('at','journalist'); ?> <?php the_time(); ?></p>
</div>	
<div class="tags">
    <p><?php printf(__('Posted in %s','journalist'), get_the_category_list(',')); ?></p>
    <?php if ( the_tags('<p>' .__('Tagged with','journalist') . ' ', ', ', '</p>') ) ?>
</div>
</div>

<div class="navigation group">
	<div class="alignleft"><?php previous_post_link(__('&laquo; %link','journalist')); ?></div>
	<div class="alignright"><?php next_post_link(__('%link &raquo;','journalist')); ?></div>
</div>

<?php comments_template(); ?>

<?php endwhile; else: ?>
<div class="warning">
	<p><?php _e("Sorry, but you are looking for something that isn't here.",'journalist'); ?></p>
</div>
<?php endif; ?>

</div> 

<?php get_sidebar(); ?>

<?php get_footer(); ?>
