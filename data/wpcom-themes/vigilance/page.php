<?php get_header(); ?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<h1 class="pagetitle"><?php the_title(); ?></h1>
			<div class="entry page clear">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
				<?php edit_post_link(__('Edit This', 'vigilance'),'<p>','</p>'); ?>
			</div><!--end entry-->
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		<?php comments_template('', true); ?>
		<?php else : ?>
		<?php endif; ?>
	</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
