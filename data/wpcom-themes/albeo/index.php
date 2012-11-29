<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
		
<!--Start Post-->
<div <?php post_class(); ?> style="margin-bottom: 20px;">
      			
<div class="p-head">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'albeo'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
<p class="p-who-date"><?php printf( __('Posted by: %s on: %s', 'albeo'), get_the_author(), get_the_time(get_option('date_format')) ); ?></p>
</div>

<div class="p-det">
 <ul>
  <li class="p-cat"><?php printf( __('In: %s', 'albeo'), get_the_category_list('|') ); ?></li>
  <li class="p-com"><?php comments_popup_link(__('Leave a Comment', 'albeo'), __('<strong>1</strong> Comment', 'albeo'), __('<strong>%</strong> Comments', 'albeo')); ?></li>
 </ul>
</div>

<div class="p-con">
<?php the_content(__('Read the rest of this entry &raquo;', 'albeo')); ?>
<div class="clear"></div>
<?php wp_link_pages(); ?>
<?php edit_post_link(__('Edit this entry.', 'albeo'), '<p>', '</p>'); ?>
</div>

<?php if (function_exists('the_tags')) { ?> <?php the_tags('<div class="p-tag">'.__('Tags:', 'albeo').' ', ', ', '</div>'); ?> <?php } ?>

</div>
<!--End Post-->

				
<?php endwhile; ?>
<?php include("nav.php"); ?>
<?php else : ?>

<?php include("404.php"); ?>
<?php endif; ?>

<?php get_footer(); ?>
