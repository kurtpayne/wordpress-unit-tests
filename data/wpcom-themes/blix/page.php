<?php get_header(); ?>

<!-- content ................................. -->
<div id="content">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class('post'); // no entry ?>>

		<h2><?php the_title(); ?></h2>

		<?php the_content(); ?>
                <?php wp_link_pages(); ?>

		</div>
<?php endwhile; ?>

<?php endif; ?>

<?php comments_template(); ?>

</div> <!-- /content -->

<?php get_footer(); ?>
