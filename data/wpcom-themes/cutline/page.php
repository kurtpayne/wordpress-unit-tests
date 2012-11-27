<?php get_header(); ?>

	<div id="content_box">
	
		<div id="content" class="pages">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

			<h2><?php the_title(); ?></h2>	
			<div class="entry">		
				<?php the_content('<p>'.__('Read the rest of this page &rarr;','cutline').'</p>'); ?>
				<?php link_pages('<p><strong>'.__('Pages:','cutline').'</strong> ', '</p>', 'number'); ?>
			</div>
			<?php if ( 'open' == $post-> comment_status ) { ?><h4><a href="<?php the_permalink() ?>#comments"><?php comments_number(__('Leave a Comment','cutline'), __('1 Comment','cutline'), __('% Comments','cutline')); ?></a></h4><?php } ?>

			</div>

			<?php endwhile; endif; ?>

			<?php comments_template(); ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
