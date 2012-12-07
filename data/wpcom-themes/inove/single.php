<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>

<?php if (have_posts()) : the_post(); ?>

	<div id="postpath">
		<a title="<?php _e('Go to homepage', 'inove'); ?>" href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'inove'); ?></a>
		 &gt; <?php the_category(', '); ?>
		 &gt; <?php the_title(); ?>
	</div>

	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
		<div class="info">
			<span class="date"><?php the_time(get_option('date_format')); ?></span>
			<?php if ($options['author']) : ?><span class="author"><?php the_author_posts_link(); ?></span><?php endif; ?>
			<?php edit_post_link(__('Edit', 'inove'), '<span class="editpost">', '</span>'); ?>
			<?php if ( have_comments() || comments_open() ) : ?>
				<span class="addcomment"><a href="#respond"><?php _e('Leave a comment', 'inove'); ?></a></span>
				<span class="comments"><a href="#comments"><?php _e('Go to comments', 'inove'); ?></a></span>
			<?php endif; ?>
			<div class="fixed"></div>
		</div>
		<div class="content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
			<div class="fixed"></div>
		</div>
		<div class="under">
			<span><?php if ($options['categories']) : ?><span class="categories"><?php _e('Categories: ', 'inove'); ?></span><?php the_category(', '); ?><?php endif; ?></span>
			<span><?php if ($options['tags']) : ?><?php the_tags('<span class="tags">' . __('Tags: ', 'inove') . '</span>', ', ', ''); ?><?php endif; ?></span>
		</div>
		<div class="fixed"></div>
	</div>

	<?php comments_template('', true); ?>

	<div id="postnavi">
		<span class="prev"><?php next_post_link('%link') ?></span>
		<span class="next"><?php previous_post_link('%link') ?></span>
		<div class="fixed"></div>
	</div>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
