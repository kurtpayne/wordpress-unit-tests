<?php get_header(); ?>
<?php
	$options = get_option('inove_options');
/*	if (function_exists('wp_list_comments')) {
		add_filter('get_comments_number', 'comment_count', 0);
	}
*/
?>

<?php if ($options['notice'] && $options['notice_content']) : ?>
	<div class="post" id="notice">
		<div class="content">
			<?php echo($options['notice_content']); ?>
			<div class="fixed"></div>
		</div>
	</div>
<?php endif; ?>

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><a class="title" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="info">
				<span class="date"><?php the_time(get_option('date_format')); ?></span>
				<?php if ($options['author']) : ?><span class="author"><?php the_author_posts_link(); ?></span><?php endif; ?>
				<?php edit_post_link(__('Edit', 'inove'), '<span class="editpost">', '</span>'); ?>
				<span class="comments"><?php comments_popup_link(__('Leave a comment', 'inove'), __('1 comment', 'inove'), __('% comments', 'inove'), '', __('Comments off', 'inove')); ?></span>
				<div class="fixed"></div>
			</div>
			<div class="content">
				<?php the_content(__('Read more...', 'inove')); ?>
				<?php wp_link_pages(); ?>
				<div class="fixed"></div>
			</div>
			<div class="under">
				<span><?php if ($options['categories']) : ?><span class="categories"><?php _e('Categories: ', 'inove'); ?></span><?php the_category(', '); ?><?php endif; ?></span>
				<span><?php if ($options['tags']) : ?><?php the_tags('<span class="tags">' . __('Tags: ', 'inove') . '</span>', ', ', ''); ?><?php endif; ?></span>
			</div>
		</div>
	<?php endwhile; ?>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<div id="pagenavi">
	<span class="newer"><?php previous_posts_link(__('Newer Entries', 'inove')); ?></span>
	<span class="older"><?php next_posts_link(__('Older Entries', 'inove')); ?></span>
	<div class="fixed"></div>
</div>

<?php get_footer(); ?>
