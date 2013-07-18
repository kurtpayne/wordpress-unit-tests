<?php
get_header();
is_tag();
?>

<div id="content">
  <?php if (have_posts()) : ?>
  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
  <?php 
	if (is_category()) { ?>
  <h2 class='archives'><?php printf(__('Archive for the &#8216;%s&#8217; Category'), single_cat_title('', false)); ?></h2>
  <?php }

	if (is_tag()) { ?>
  <h2 class='archives'><?php printf(__('Archive for the &#8216;%s&#8217; Tag'), single_tag_title('', false) ); ?></h2>
  <?php }
	 
	elseif (is_day()) { ?>
	
  <h2 class='archives'><?php printf(__('Archive for %s|Daily archive page'), get_the_time(__('F jS, Y'))); ?></h2>
  <?php }
	
	elseif (is_month()) { ?>
  <h2 class='archives'><?php printf(__('Archive for %s|Monthly archive page'), get_the_time(__('F, Y'))); ?></h2>
  <?php } 
	
	elseif (is_year()) { ?><?php printf(_c('Archive for %s|Yearly archive page'), get_the_time(__('Y'))); ?></h2>
  <?php } 
	
	elseif (is_author()) { ?>
  <h2 class='archives'><?php _e('Author Archive'); ?></h2>
  <?php }
	 
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2><?php _e('Blog Archives'); ?></h2>
    <?php } ?>
  <?php while (have_posts()) : the_post(); ?>
  <div <?php post_class( 'entry' ); ?>>
    <h3 class="entrytitle" id="post-<?php the_ID(); ?>"> <a href="<?php the_permalink() ?>" rel="bookmark">
      <?php the_title(); ?>
      </a> </h3>
    <div class="entrymeta">
	<?php _e('Posted'); ?> <?php the_time(get_option('date_format')); ?><br />
	<?php _e('Filed under:');?> <?php the_category(',') ?> | <?php the_tags(__('Tags:'). ' ', ', '); ?><br />
	<?php
		$comments_img_link= '<img src="' . get_stylesheet_directory_uri() . '/images/comments.gif"  title="comments" alt="*" /><strong> ';
		comments_popup_link($comments_img_link . __('Leave a Comment'), $comments_img_link . __('Comments (1)'), $comments_img_link . __('Comments (%)')); 
		echo ' ';
		edit_post_link(__('Edit'));
	?>
      </strong> </div>
    <div class="entrybody">
      <?php the_content(__('Read more &raquo;'));?>
<div class="sociable"><?php if(function_exists('wp_email')) { email_link(); } ?>
</div>
    </div>
  </div>
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
