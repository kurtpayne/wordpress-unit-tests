<?php get_header(); ?>
<?php if (have_posts()) : ?>


<h2 class="title"><?php _e('Search Results', 'albeo'); ?></h2>

<?php include("nav.php"); ?>
<?php while (have_posts()) : the_post(); ?>

<div <?php post_class(); ?>>

<div class="p-head">
<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'albeo'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
<p class="p-who-date"><?php _e('Posted by:', 'albeo'); ?> <?php the_author() ?> <?php _e('on:', 'albeo'); ?> <?php the_time(get_option('date_format')); ?></p>
</div>

<div class="p-det">
 <ul>
  <li class="p-cat"><?php printf( __('Posted by: %s on: %s', 'albeo'), get_the_author(), get_the_time(get_option('date_format')) ); ?></li>
  <li class="p-com"><?php comments_popup_link( __('Leave a Comment', 'albeo'), __('<strong>1</strong> Comment', 'albeo'), __('<strong>%</strong> Comments', 'albeo')); ?></li>
 </ul>
</div>

 <div class="p-con">
 <?php the_excerpt(); ?>
 </div> 
 
<?php if (function_exists('the_tags')) { ?> <?php the_tags('<div class="p-tag">'.__('Tags:', 'albeo').' ', ', ', '</div>'); ?> <?php } ?>
 
</div>

<?php endwhile; ?>
<br clear="all" />	
<?php include("nav.php"); ?>
<?php else : ?>

<h2 class="title"><?php _e('No posts found.', 'albeo'); ?></h2>
<p><?php _e('Try a different search!', 'albeo'); ?></p>
<?php endif; ?>


<?php get_footer(); ?>
