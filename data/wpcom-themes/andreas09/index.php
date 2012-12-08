<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

<div id="content">
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>

		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','andreas09'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<p class="date"><?php _e('Posted by','andreas09'); ?> <?php if (get_the_author_url()) { ?><a href="<?php the_author_url(); ?>"><?php the_author(); ?></a><?php } else { the_author(); } ?> <?php _e('on','andreas09'); ?> <?php the_time(get_option("date_format")); ?></p>
			<div class="entry">
				<?php the_content(__('Read the rest of this entry &raquo;','andreas09')); ?>
			</div>

		<p class="category"><?php _e('Posted in','andreas09'); ?> <?php the_category(', ') ?> | <?php the_tags( __( 'Tagged' ) . ': ', ', ', ' | '); ?> <?php edit_post_link(__('Edit','andreas09'), '', ' | '); ?>  <?php comments_popup_link(__('Leave a Comment &#187;','andreas09'), __('1 Comment &#187;','andreas09'), __('% Comments &#187;','andreas09')); ?></p>
		</div>

	<?php endwhile; ?>
		<div class="bottomnavigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries','andreas09')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;','andreas09')) ?></div>
		</div>
	
	<?php else : ?>
	<div id="page">
		<h1 class="center"><?php _e('Not Found','andreas09'); ?></h1>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.','andreas09'); ?></p>
		<p class="center"><?php _e('Perhaps you would like to try a search or select from one of the links on the menu.','andreas09'); ?></p>
	</div>
	
	<?php endif; ?>
</div>

<?php get_footer(); ?>
