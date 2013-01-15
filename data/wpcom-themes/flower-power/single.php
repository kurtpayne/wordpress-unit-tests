<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'main' ); ?>>

		<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

		<p class="info">
		<?php if ($post->comment_status == "open") ?>
   		<em class="date"><?php the_time(get_option('date_format')) ?><!-- at <?php the_time()  ?>--></em>
   		<em class="author"><?php the_author(); ?></em>
   		<?php edit_post_link(__('Edit', 'flower-power'),'<span class="editlink">','</span>'); ?>
   		</p>

		<?php the_content();?>
		<?php wp_link_pages(); ?>

		<p id="filedunder"><?php _e('Entry Filed under:', 'flower-power'); ?> <?php the_category(','); ?> <?php the_tags( ' ' . __( 'and tagged' , 'flower-power') . ': ', ', ', ''); ?></p>

<?php endwhile; ?>

<?php else : ?>

	<h2><?php _e('Not Found', 'flower-power'); ?></h2>
	<p><?php _e("Sorry, but you are looking for something that isn't here.", 'flower-power'); ?></p>

<?php endif; ?>

<?php comments_template(); ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
