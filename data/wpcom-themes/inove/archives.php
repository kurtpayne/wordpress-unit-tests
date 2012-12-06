<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : the_post(); ?>

	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
		<div class="info">
			<span class="date"><?php the_time(get_option('date_format')); ?></span>
			<?php edit_post_link(__('Edit', 'inove'), '<span class="editpost">', '</span>'); ?>
			<?php if ( have_comments() || comments_open() ) : ?>
				<span class="addcomment"><a href="#respond"><?php _e('Leave a comment', 'inove'); ?></a></span>
				<span class="comments"><a href="#comments"><?php _e('Go to comments', 'inove'); ?></a></span>
			<?php endif; ?>
			<div class="fixed"></div>
		</div>
		<div class="content">
			<ul>
			<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
			</ul>
		</div>
	</div>

	<?php comments_template('', true); ?>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
