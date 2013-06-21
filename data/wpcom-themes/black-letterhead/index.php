<?php get_header();  ?>

<div id="content" class="narrowcolumn">
<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<?php require('post.php'); ?>
<?php endwhile; ?>

<div class="navigation">
			<div class="alignleft"><?php previous_posts_link(__('&laquo; Previous Entries', 'black-letterhead')) ?></div>
			<div class="alignright"><?php next_posts_link(__('Next Entries &raquo;', 'black-letterhead')) ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found', 'black-letterhead'); ?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.", 'black-letterhead'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
