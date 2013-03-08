<?php get_header(); ?>

	<div id="content">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class('post'); ?>>
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/<?php echo 'rtl' == get_bloginfo( 'text_direction' ) ? 'h1-rtl.gif' : 'h1.gif'; ?>" class="lefth2img" alt="h1" /><h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
			<div class="entrytext">
				<?php the_content('<p class="serif">'.__('Read the rest of this page &raquo;').'</p>'); ?>
	
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>
	<?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>
	
	<?php comments_template(); ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
