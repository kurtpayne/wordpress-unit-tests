<?php get_header(); ?>
<?php get_sidebar(); ?>

		<div class="narrowcolumn">

<?php include(TEMPLATEPATH . '/top-menu.php'); ?>

<!-- CONTENT -->

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

	<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">

<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

<div class="entry">
<?php the_content(); ?>
<?php link_pages('<strong>Pages&#58;</strong> ', '', 'number'); ?>

<?php comments_template(); ?>

</div>

	</div>

<?php endwhile; ?>

	<div class="navigation"><?php edit_post_link('Edit this entry', '', ''); ?></div>

<?php else : ?>

	<div <?php post_class('post'); ?>>
<h2><?php _e('Not Found'); ?></h2>
<div class="entry"><?php _e('Sorry, but you are looking for something that isn&#39;t here.'); ?></div>
	</div>

<?php endif; ?>

<!-- END CONTENT -->

		</div>

<?php get_footer(); ?>
