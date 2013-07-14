<?php 
get_header();
?>

<?php is_tag(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php the_date('','<h2>','</h2>'); ?>

<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	 <h3 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	<div class="meta"><?php _e('Filed under:','classic'); ?>  <?php the_category(',') ?> &#8212; <?php the_author() ?> @ <?php the_time() ?> <?php edit_post_link(__('Edit This','classic')); ?><br /><?php the_tags('Tags: ', ', ', '<br />'); ?></div>

	<div class="storycontent">
		<?php the_content(__('(more...)','classic')); ?>
	</div>

	<div class="feedback">
            <?php wp_link_pages(); ?>
            <?php comments_popup_link(__('Leave a Comment','classic'), __('Comments (1)','classic'), __('Comments (%)','classic')); ?>
	</div>

</div>

<?php comments_template(); // Get wp-comments.php template ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.','classic'); ?></p>
<?php endif; ?>

<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page','classic'), __('Next Page &raquo;','classic')); ?>

<?php get_footer(); ?>
