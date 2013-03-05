<?php get_header(); ?>

<!-- content ................................. -->
<div id="content">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

	<?php /* This is the navigation for previous/next post. It's disabled by default. ?>
	<p id="entrynavigation">
		<?php previous_post('<span class="previous">%</span>','','yes') ?>
		<?php next_post('<span class="next">%</span>','','yes') ?>
	</p>
	<?php */ ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'entry single' ); ?>>

		<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

		<p class="info">
		<?php if ($post->comment_status == "open") ?>
   		<em class="date"><?php the_time(get_option('date_format')) ?><!-- at <?php the_time()  ?>--></em>
   		<!--<em class="author"><?php the_author(); ?></em>-->
   		<?php edit_post_link('Edit','<span class="editlink">','</span>'); ?>
   		</p>

		<?php the_content();?>
		<?php wp_link_pages(); ?>
		<p id="filedunder">Entry Filed under: <?php the_category(','); ?>.  <?php the_tags( __( 'Tags' ) . ': ', ', ', ''); ?>.</p>

   </div>

<?php endwhile; ?>

<?php else : ?>

	<h2>Not Found</h2>
	<p>"Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>

<?php comments_template(); ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
