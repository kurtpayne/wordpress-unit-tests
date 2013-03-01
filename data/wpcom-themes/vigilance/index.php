<?php get_header(); ?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<div class="post-header">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'vigilance'), the_title_attribute('',0)); ?>"><?php the_title(); ?></a></h2>
				<div class="date"><span><?php the_time('Y') ?></span> <?php the_time('F j') ?></div>
				<div class="comments"><?php comments_popup_link(__('Leave a comment', 'vigilance'), __('1 Comment', 'vigilance'), __('% Comments', 'vigilance')); ?></div>
			</div><!--end post header-->
			<div class="meta clear">
				<div class="tags"><?php the_tags(__('tags:', 'vigilance') . ' ', ', ', ''); ?></div>
				<div class="author"><?php printf(__('by %s', 'vigilance'), get_the_author()); ?></div>
			</div><!--end meta-->
			<div class="entry clear">
				<?php the_content(__('read more...', 'vigilance')); ?>
				<?php wp_link_pages(); ?>
        <?php edit_post_link('Edit This','<p>','</p>'); ?>
			</div><!--end entry-->
			<div class="post-footer">
				<p><?php _e('from &rarr;', 'vigilance'); ?> <?php the_category(', ') ?></p>
			</div><!--end post footer-->
		</div><!--end post-->
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		<div class="navigation index">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'vigilance')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'vigilance')) ?></div>
		</div><!--end navigation-->
		<?php else : ?>
		<?php endif; ?>
	</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>