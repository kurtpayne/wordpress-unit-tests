<?php get_header();?>
<div id="content">
<div id="content-main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="posttitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				<p class="postmetadata"><?php the_time(get_option("date_format")); ?> <?php printf(__('by %s','mistylook'), mistylook_get_author_posts_link()); ?> <?php edit_post_link(__('Edit','mistylook'), ' | ', ' '); ?> </p>
				</div>
				
				<div class="entry">
					<?php the_content(__('Continue Reading &raquo;','mistylook')); ?>
					<?php wp_link_pages(); ?>
				</div>
		
				<p class="post-info"><?php printf(__('Posted in %s','mistylook'), get_the_category_list(', ')); ?> | <?php the_tags( __('Tagged','mistylook').' ', ', ', ' | ' ); ?><?php comments_popup_link(__('Leave a Comment &#187;','mistylook'), __('1 Comment &#187;','mistylook'), __('% Comments &#187;','mistylook')); ?></p>
				<?php comments_template(); ?>
			</div>
		<?php endwhile; else : ?>
			<h2 class="center"><?php _e('Not Found','mistylook'); ?></h2>
			<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.','mistylook'); ?></p>
		<?php endif; ?>
		<p align="center"><?php posts_nav_link(' - ',__('&#171; Newer Posts','mistylook'),__('Older Posts &#187;','mistylook')) ?></p>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
