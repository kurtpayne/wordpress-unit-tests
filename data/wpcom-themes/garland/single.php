<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?>>

<h2><?php the_title(); ?></h2>
<span class="submitted"><?php the_time(get_option('date_format')) ?> &#8212; <?php the_author() ?> <?php edit_post_link(__('Edit'), ' | ', ''); ?></span>

<div class="content">
<?php the_content(__('Read the rest of this entry &raquo;')); ?>
<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
</div>

<div class="meta">
<?php printf(__('Posted in %s'), get_the_category_list(', ')); ?>. <?php if (is_callable('the_tags')) the_tags(__('Tags:').' ', ', ', '.'); ?> <?php comments_popup_link(__('Leave a Comment &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
</div>

</div>
<?php endwhile; endif; ?>

<?php comments_template(); ?>

<div class="nextprev">
<div class="alignleft"><?php next_posts_link(__('&laquo; Older posts')) ?> <?php previous_post_link('&laquo; %link') ?></div><br />
<div class="alignright"><?php previous_posts_link(__('Newer posts &raquo;')) ?> <?php next_post_link('%link &raquo;') ?></div>
</div>

<?php get_footer(); ?>
