<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class('post'); ?>>

<h2><?php the_title(); ?></h2>
<span class="submitted"><?php the_time(get_option('date_format')) ?> &#8212; <?php the_author() ?> <?php edit_post_link(__('Edit'), ' | ', ''); ?></span>

<div class="content">
<?php the_content(__('Read the rest of this entry &raquo;')); ?>
<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
</div>

<div class="meta">
<?php comments_popup_link(__('Leave a Comment &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
</div>

</div>
<?php endwhile; endif; ?>

<?php comments_template(); ?>


<?php get_footer(); ?>
