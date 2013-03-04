<?php
get_header();
?>

<div id="content">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div <?php post_class( 'entry' ); ?>>
    <h3 class="entrytitle" id="post-<?php the_ID(); ?>"> <a href="<?php the_permalink() ?>" rel="bookmark">
      <?php the_title(); ?>
      </a> </h3>
    <div class="entrymeta">
		<?php _e('Posted'); ?> <?php the_time(get_option('date_format')); ?><br />
		<?php _e('Filed under:');?> <?php the_category(',') ?> | <?php the_tags(__('Tags:'). ' ', ', '); ?><br />
        <?php
                $comments_img_link= '<img src="' . get_stylesheet_directory_uri() . '/images/comments.gif"  title="comments" alt="*" />';
                comments_popup_link($comments_img_link .'<strong> '. __('Leave a Comment').'</strong>', $comments_img_link .'<strong> '. __('Comments (1)').'</strong>', $comments_img_link .'<strong> '. __('Comments (%)').'</strong>'); 
				echo ' ';
                edit_post_link(' <strong>'.__('Edit').'</strong>');  
        ?>
 	</div>
    <div class="entrybody">
      <?php the_content(__('Read more &raquo;'));?>
	<div class="clear"></div>
    </div>
  </div>
  <?php comments_template(); // Get wp-comments.php template ?>
  <?php endwhile; else: ?>
  <p>
    <?php _e('Sorry, no posts matched your criteria.'); ?>
  </p>
  <?php endif; ?>
  <p>
    <?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
  </p>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
