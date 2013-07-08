<?php get_header(); ?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="post-header">
        <h1><?php the_title(); ?></h1>
        <div id="single-date" class="date"><span><?php the_time('Y') ?></span> <?php the_time('F j') ?></div>
			</div><!--end post header-->
			<div class="meta clear">
				<div class="tags"><?php the_tags(__('tags:', 'vigilance'). ' ', ', ', ''); ?></div>
				<div class="author">by <?php the_author() ?></div>
			</div><!--end meta-->
			<div class="entry clear">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
        <?php edit_post_link(__('Edit This', 'vigilance'),'<p>','</p>'); ?>
			</div><!--end entry-->
			<div class="post-footer">
				<p><?php _e('from &rarr;', 'vigilance'); ?> <?php the_category(', ') ?></p>
			</div><!--end post footer-->
		</div><!--end post-->
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		<?php comments_template('', true); ?>
		<?php else : ?>
		<?php endif; ?>
	</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>