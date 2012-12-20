<?php get_header(); ?>
<?php get_sidebar(); ?>

		<div class="narrowcolumn">

<?php include(TEMPLATEPATH . '/top-menu.php'); ?>

<!-- CONTENT -->

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

<div class="entry">
<?php the_content(); ?>
<?php link_pages('<strong>Pages&#58;</strong> ', '', 'number'); ?>

<p class="postmetadata">
<?php the_time(get_option('date_format')) ?><br />
<?php _e('Categories&#58;'); ?> <?php the_category(', ') ?> . <?php the_tags( __('Tags&#58; ') ); ?> . <?php _e('Author&#58;'); ?> <a href="<?php the_author_url(); ?>"><?php the_author(); ?></a> <?php edit_post_link(__('Edit this entry'), '', ''); ?></p>

<?php comments_template(); ?>

</div>

	</div>

<?php endwhile; ?>

	<div class="navigation"><?php previous_post_link('%link') ?> <?php next_post_link('%link') ?></div>

<?php else : ?>

	<div <?php post_class(); ?>>
<h2><?php _e('Not Found'); ?></h2>
<div class="entry"><?php _e('Sorry, but you are looking for something that isn&#39;t here.'); ?></div>
	</div>

<?php endif; ?>

<!-- END CONTENT -->

		</div>

<?php get_footer(); ?>
