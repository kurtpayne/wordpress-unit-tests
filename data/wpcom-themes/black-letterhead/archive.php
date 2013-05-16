<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
		<h2 class="pagetitle"><?php printf(__('Archive for the %s Category', 'black-letterhead'), single_cat_title('', false)); ?></h2>
		
 	  <?php /* If this is a tag archive */ } elseif (is_tag()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for %s', 'black-letterhead'), single_tag_title('', false)); ?></h2>

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for %s', 'black-letterhead'), get_the_time(get_option('date_format'))); ?></h2>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for %s', 'black-letterhead'), get_the_time('F, Y')); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for %s', 'black-letterhead'), get_the_time('Y')); ?></h2>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle"><?php _e('Search Results', 'black-letterhead'); ?></h2>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive', 'black-letterhead'); ?></h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives', 'black-letterhead'); ?></h2>

		<?php } ?>


		<div class="navigation">
			<div class="alignleft"><?php previous_posts_link(__('&laquo; Previous Entries', 'black-letterhead')) ?></div>
			<div class="alignright"><?php next_posts_link(__('Next Entries &raquo;', 'black-letterhead')) ?></div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
		<?php require('post.php'); ?>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php previous_posts_link(__('&laquo; Previous Entries', 'black-letterhead')) ?></div>
			<div class="alignright"><?php next_posts_link(__('Next Entries &raquo;', 'black-letterhead')) ?></div>
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found', 'black-letterhead'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
