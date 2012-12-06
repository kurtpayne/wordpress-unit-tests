<?php get_header(); ?>

<div class="navigation">
	<div class="previous alignleft"><?php next_post_link('%link') ?></div>
	<div class="next alignright"><?php previous_post_link('%link') ?></div>
</div>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div <?php post_class(); ?> id="post-<?php the_ID(); ?>" style="margin-bottom: 20px;">

<div class="p-head">
<h1><?php the_title(); ?></h1>
<p class="p-who-date"><?php printf( __('Posted by: %s on: %s', 'albeo'), get_the_author(), get_the_time(get_option('date_format')) ); ?></p>
</div>

<div class="p-det">
 <ul>
  <li class="p-cat"><?php printf( __('In: %s', 'albeo'), get_the_category_list('|') ); ?></li>
  <li class="p-com"><a href="<?php the_permalink() ?>#respond" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'albeo'), the_title_attribute('echo=0')); ?>"><?php _e('Comment!', 'albeo'); ?></a></li>
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


<?php comments_template(); ?>
<?php endwhile; else: ?>

<p><?php _e('Sorry, no posts matched your criteria.', 'albeo'); ?></p>

<?php endif; ?>
<?php get_footer(); ?>