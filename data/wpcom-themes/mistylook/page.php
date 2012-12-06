<?php get_header();?>
<div id="content">
<div id="content-main">
<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
				<div class="posttitle">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				<?php edit_post_link(__('Edit','mistylook'), '<p class="post-info">', '</p>'); ?>
			</div>
				
				<div class="entry">
					<?php the_content(); ?>	
					<?php wp_link_pages(); ?>				
					<?php $sub_pages = wp_list_pages( 'sort_column=menu_order&depth=1&title_li=&echo=0&child_of=' . $id );?>
					<?php if ($sub_pages <> "" ){?>
						<p class="post-info"><?php _e('This page has the following sub pages.','mistylook'); ?></p>
						<ul><?php echo $sub_pages; ?></ul>
					<?php }?>											
				</div>
		
				<p class="postmetadata"><?php comments_popup_link(__('Leave a Comment &#187;','mistylook'), __('1 Comment &#187;','mistylook'), __('% Comments &#187;','mistylook')); ?></p>
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
