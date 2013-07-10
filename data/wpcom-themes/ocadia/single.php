<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div <?php post_class(); ?>>

			<?php the_date('m.d.y', '<h1 class="storydate">', '</h1>'); ?> 
			<h2 id="post-<?php the_ID(); ?>" class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<p class="meta"><?php _e('Posted in'); ?> <?php the_category(', ') ?> <?php the_tags( 'tagged ' ); ?> <?php _e('at'); ?> <?php the_time(); ?> <?php _e('by'); ?> <?php the_author(); ?></p>
		
			<?php the_content(__('Read the rest of this entry &raquo;')); ?>
			<?php wp_link_pages(); ?>

			<p class="feedback">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>" class="permalink"><?php _e('Permalink'); ?></a>
			<?php edit_post_link(__('Edit'), ' &#183; ', ''); ?>
			</p>
		
		</div>
			
		<?php comments_template(); ?>
	
	<?php endwhile; else: ?>

		<h2><?php _e('Not Found'); ?></h2>
		<p><?php _e('Sorry, but the page you requested cannot be found.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
