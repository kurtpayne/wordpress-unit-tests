<?php get_header(); ?>

<div class="post-page">

<h2><?php _e('Links:', 'albeo'); ?></h2>
 <ul>
 <?php wp_list_bookmarks(); ?>
</ul>

</div>

<?php get_footer(); ?>