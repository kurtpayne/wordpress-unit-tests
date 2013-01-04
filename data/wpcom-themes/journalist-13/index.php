<?php get_header(); ?>

<div id="content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class() ?>>
	<?php // Post dates off by default the_date('','<h2>','</h2>'); ?>
	<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>	
	<div class="meta">
		<?php 
			if ( !is_attachment() )
				printf(__("Posted in %s by %s on %s",'journalist-13'), get_the_category_list(','), get_the_author(), get_the_time(get_option('date_format')));
			edit_post_link(__('Edit This','journalist-13'), ' ');
		?>
	</div>
	<div class="main">
		<?php the_content(__('(more...)','journalist-13')); ?>
	</div>
	<?php if( !is_attachment() ) { ?>
		<div class="tags">
		<?php the_tags(__('Tagged with: ','journalist-13'),', ',' '); ?>
		</div>
	<?php } ?>
	<div class="comments">
		<?php wp_link_pages(); ?>
		<p><?php comments_popup_link(__('leave a comment','journalist-13'), __('<strong>1</strong> comment','journalist-13'), __('<strong>%</strong> comments','journalist-13')); ?></p>
	</div>
</div>

<div class="navigation">
<div class="previous"><?php previous_post_link('&laquo; %link') ?></div>
<div class="next"><?php next_post_link('%link &raquo;') ?></div>
</div>

<?php if ( is_singular() ) comments_template(); ?>

<?php endwhile; else: ?>
<div class="warning">
	<p><?php _e('Sorry, no posts matched your criteria, please try and search again.','journalist-13'); ?></p>
</div>
<?php endif; ?>

<div id="postnav"><?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts','journalist-13'), __('Older Posts &raquo;','journalist-13')); ?></div>

</div> <!-- End content -->

<?php get_sidebar(); ?>

<div class="clearleft"></div>

<?php get_footer(); ?>
