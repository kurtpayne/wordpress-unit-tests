<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

	<div id="content">
	<?php if (have_posts()) : ?>

		<h1 class="pagetitle"><?php _e('Search Results','andreas09'); ?></h1>
		
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries','andreas09')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;','andreas09')) ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?>>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','andreas09'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<p class="date"><?php _e('Posted on','andreas09'); ?> <?php the_time(get_option("date_format")); ?></small></p>
		<?php the_excerpt(''); ?>
		<p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php _e('Read the rest of this post...','andreas09'); ?></a></p>
				<p class="category"><?php _e('Posted in','andreas09'); ?> <?php the_category(', ') ?> | <?php edit_post_link(__('Edit','andreas09'), '', ' | '); ?>  <?php comments_popup_link(__('Leave a Comment &#187;','andreas09'), __('1 Comment &#187;','andreas09'), __('% Comments &#187;','andreas09')); ?></p>
			</div>
	
		<?php endwhile; ?>

		<div class="bottomnavigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries','andreas09')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;','andreas09')) ?></div>
		</div>
	
	<?php else : ?>
	<div id="page">
		<h1 class="center"><?php _e('Search Results','andreas09'); ?></h1>
		<h2 class="center"><?php _e('Not Found','andreas09'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.','andreas09'); ?></p>
		<p class="center"><?php _e('Perhaps you would like to try another search or select from one of the links on the menu.','andreas09'); ?></p>
	</div>
	<?php endif; ?>

	</div>

<?php get_footer(); ?>
