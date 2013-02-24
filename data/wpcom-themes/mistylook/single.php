<?php get_header();?>
<div id="content">
<div id="content-main">
<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="posttitle">
					<h2><?php the_title(); ?></h2>
					<p class="post-info"><?php the_time(get_option("date_format")); ?> <?php printf(__('by %s','mistylook'), mistylook_get_author_posts_link()); ?> <?php edit_post_link(__('Edit','mistylook'), ' | ', ''); ?> </p>
				</div>
				
				<div class="entry">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
		
				<p class="postmetadata"><?php printf(__('Posted in %s','mistylook'), get_the_category_list(', ')); ?> | <?php the_tags( __('Tagged','mistylook').' ', ', ', ' | ' ); ?><?php comments_number(__('No Comments Yet','mistylook'), __('1 Comment','mistylook'), __('% Comments','mistylook')); ?></p>
				<?php comments_template(); ?>
			</div>
	
		<?php endwhile; ?>

		<p align="center"><?php posts_nav_link(' - ',__('&#171; Prev','mistylook'),__('Next &#187;','mistylook')) ?></p>
		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found','mistylook'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.','mistylook'); ?></p>		

	<?php endif; ?>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
