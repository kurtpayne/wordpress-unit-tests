<?php get_header();?>
<div id="content">
<div id="content-main">
<?php if (have_posts()) : ?>
		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    
		<h2 class="pagetitle"><?php printf(__('Search Results for %s','mistylook'), "'".$s."'");?></h2>
		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="posttitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
					<p class="post-info"><?php printf(__('Posted in %s on %s','mistylook'), get_the_category_list(', ').get_the_tag_list(', '.__('tagged','mistylook').' ', ', '), get_the_time(get_option("date_format"))); ?> | <?php edit_post_link(__('Edit','mistylook'), '', ' | '); ?>  <?php comments_popup_link(__('Leave a Comment &#187;','mistylook'), __('1 Comment &#187;','mistylook'), __('% Comments &#187;','mistylook')); ?></p>
				</div>
				
				<div class="entry">
					<?php the_excerpt(); ?>
					<p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php _e('Read Full Post &#187;','mistylook'); ?></a></p>
				</div>
				<?php comments_template(); ?>
			</div>
	
		<?php endwhile; ?>

		<p align="center"><?php posts_nav_link(' - ',__('&#171; Prev','mistylook'), __('Next &#187;','mistylook')) ?></p>
		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found','mistylook'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.','mistylook'); ?></p>
	<?php endif; ?>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
