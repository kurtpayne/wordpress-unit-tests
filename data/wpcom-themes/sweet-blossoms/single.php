<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">
	<div class="main">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>


		<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

		<p class="info">
		<?php if ($post->comment_status == "open") ?>
   		<em class="date"><?php the_time(get_option('date_format')) ?><!-- at <?php the_time()  ?>--></em>
   		<em class="author"><?php the_author(); ?></em>
   		<?php edit_post_link('Edit','<span class="editlink">','</span>'); ?>
		<br />
		<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
   		</p>

		<?php the_content();?>
		<?php wp_link_pages(); ?>

		<p id="filedunder">Entry Filed under: <?php the_category(','); ?></p>

<?php endwhile; ?>

<?php else : ?>

	<h2>Not Found</h2>
	<p>"Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>

<?php comments_template(); ?>
</div>
</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
