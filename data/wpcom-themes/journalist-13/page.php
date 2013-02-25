<?php get_header(); ?>

<div id="content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class() ?>>
	<?php // Post dates off by default the_date('','<h2>','</h2>'); ?>
	<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>	
	<div class="meta"><?php edit_post_link(__('Edit This','journalist-13')); ?></div>
	<div class="main">
		<?php the_content(__('(more...)','journalist-13')); ?>
	</div>
	<div class="comments">
		<?php wp_link_pages(); ?>
	</div>
</div>

<?php comments_template(); ?>

<?php endwhile; else: ?>
<div class="warning">
	<p><?php _e('Sorry, no posts matched your criteria, please try and search again.','journalist-13'); ?></p>
</div>
<?php endif; ?>

</div> <!-- End content -->

<?php get_sidebar(); ?>

<div class="clearleft"></div>

<?php get_footer(); ?>
