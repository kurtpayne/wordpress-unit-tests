<?php get_header(); ?>

<?php is_tag(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class('post'); ?>>
<div class="postop">
<img src="<?php bloginfo('template_directory'); ?>/img/tl.gif" alt="" width="15" height="15" class="corner" style="display: none" />
</div>

<h3 class="storytitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php unset($previousday); the_date('','<span class="date">','</span>'); ?></h3>
<div class="meta"><?php _e("Filed under:"); ?> <?php the_category(',') ?> &#8212; <?php the_author() ?> @ <?php the_time() ?> <?php edit_post_link(__('Edit This')); ?>
<br /> <?php the_tags('Tags: ', ', ', '<br />'); ?>
</div><!-- end META -->

<div class="storycontent">
<?php the_content(__('(more...)')); ?>
<?php wp_link_pages(); ?>
</div><!-- end STORYCONTENT -->
<div class='reset'>&nbsp;</div>
<div class="feedback">
<?php comments_popup_link(__('Leave a Comment'), __('Comments (1)'), __('Comments (%)')); ?>
</div><br /><!-- end FEEDBACK -->

<div class="postbottom">
<img src="<?php bloginfo('template_directory'); ?>/img/bl.gif" alt="" width="15" height="15" class="corner" style="display: none" />
</div>

</div><!-- end POST -->

<div id="comments-post">
<?php comments_template(); ?>
</div><!-- end COMMENTS-POST -->

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<div id="postnav">
<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
</div>

<?php get_footer(); ?>
