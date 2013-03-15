<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div id="pagina">
	
			<h2 class="post-titulo" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
			<p class="postmeta"> 
			<?php the_time(get_option('date_format')) ?> <?php _e('at'); ?> <?php the_time() ?> 
			&#183; <?php _e('Filed under'); ?> <?php the_category(', ') ?>
			<?php the_tags( ' and ' . __( 'tagged' ) . ': ', ', ', ''); ?>
			<?php edit_post_link(__('Edit'), ' &#183; ', ''); ?>
			</p>
		
			<div class="postentry">
			<?php the_content(__('Read the rest of this entry &raquo;')); ?>
			<?php wp_link_pages(); ?>
			</div>

			<p class="linkpermanente">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>" class="permalink"><?php _e('Permalink'); ?></a>
			</p>
			
		</div>
		
		<?php comments_template(); ?>
				
	<?php endwhile; else : ?>

		<h2><?php _e('Not Found'); ?></h2>

		<p><?php _e('Sorry, but the page you requested cannot be found.'); ?></p>
		
		<h3><?php _e('Search'); ?></h3>
		
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
