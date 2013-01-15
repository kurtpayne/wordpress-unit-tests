<?php get_header(); ?>
<?php if (have_posts()) : ?>

<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<h2 class="title"><?php printf(__('Archive for the &#8216;<strong>%s</strong>&#8217; Category', 'albeo'), single_cat_title('', false)); ?></h2>
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
<h2 class="title"><?php printf(__('Posts Tagged &#8216;<strong>%s</strong>&#8217;', 'albeo'), single_tag_title('', false)); ?></h2>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="title"><?php printf(__('Archive for <strong>%s</strong>', 'albeo'), get_the_time('F jS, Y')); ?></h2>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="title"><?php printf(__('Archive for <strong>%s</strong>', 'albeo'), get_the_time('F Y')); ?></h2>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="title"><?php printf(__('Archive for <strong>%s</strong>', 'albeo'), get_the_time('Y')); ?></h2>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="title"><?php _e('Author Archive', 'albeo'); ?></h2>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="title"><?php _e('Blog Archives', 'albeo'); ?></h2>
<?php } ?>

<?php include("nav.php"); ?>

<?php while (have_posts()) : the_post(); ?>

<div <?php post_class(); ?>>

<div class="p-head">
<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'albeo'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
<p class="p-who-date"><?php printf( __('Posted by: %s on: %s', 'albeo'), get_the_author(), get_the_time(get_option('date_format')) ); ?></p>
</div>

<div class="p-det">
 <ul>
  <li class="p-cat"><?php printf( __('In: %s', 'albeo'), get_the_category_list('|') ); ?></li>
  <li class="p-com"><?php comments_popup_link(__('Leave a Comment', 'albeo'), __('<strong>1</strong> Comment', 'albeo'), __('<strong>%</strong> Comments', 'albeo')); ?></li>
 </ul>
</div>

 <div class="p-con">
 <?php the_excerpt(); ?>
 </div> 
 
<?php if (function_exists('the_tags')) { ?> <?php the_tags('<div class="p-tag">'.__('Tags:', 'albeo').' ', ', ', '</div>'); ?> <?php } ?>
 
</div>

<?php endwhile; ?>
<br />
<?php include("nav.php"); ?>
<?php else : ?>

<h2 class="center"><?php _e('Not Found', 'albeo'); ?></h2>

<?php endif; ?>
<?php get_footer(); ?>
