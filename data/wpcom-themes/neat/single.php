<?php get_header(); ?>

	<div id="content">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignleft"><?php previous_post('&laquo; %','','yes') ?></div>
			<div class="alignright"><?php next_post(' % &raquo;','','yes') ?></div>
		</div>
	
		<div <?php post_class(); ?>>
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/<?php echo 'rtl' == get_bloginfo( 'text_direction' ) ? 'h1-rtl.gif' : 'h1.gif'; ?>" class="lefth2img" alt="h1" /><h2 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <small><?php the_time(get_option('date_format')) ?> <!-- by <?php the_author() ?> --></small>
            
			<div class="entrytext">
				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;').'</p>'); ?>
	
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
			</div>
			<p class="postmetadata"><?php printf(__('Posted in %s'), get_the_category_list(', ')); ?> <strong>|</strong> <?php the_tags( __('Tagged').' ', ', ', ' <strong>|</strong> '); ?><?php edit_post_link(__('Edit'),''); ?></p>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	
<?php endif; ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
