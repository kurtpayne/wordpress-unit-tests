<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); 
		if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts);  ?>

					<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
						<p class="postmetadata"><?php the_tags('', ', ', '<br />'); ?></p>
						<h2><?php the_title(); ?></h2>
						<small><?php printf(__('In %1$s on <strong>%2$s at %3$s</strong>', 'depo-masthead'), get_the_category_list(__(', ', 'depo-masthead')), get_the_time(get_option('date_format')), get_the_time()); ?></small>

						<div class="entry">
							<?php the_content(__('Read the rest of this entry &raquo;', 'depo-masthead')); ?>
							<?php wp_link_pages(); ?>
							<?php edit_post_link(__('Edit this entry.', 'depo-masthead'), '<p>', '</p>'); ?>
						</div>
					</div>

					<?php comments_template(); ?>
					
					<div class="navigation">
						<div class="previous">
								<?php previous_post_link('%link', '<span class="arrow">&laquo;</span> <span class="link"> <span class="before">'.__('Before', 'depo-masthead').'</span> <span class="title">%title</span> <span class="date">%date</span> </span>') ?>
						</div>
						
						<div class="next">
								<?php next_post_link('%link', '<span class="link"> <span class="after">'.__('After', 'depo-masthead').'</span><span class="title">%title</span> <span class="date">%date</span></span> <span class="arrow">&raquo;</span>') ?>
						</div>
						<div class="clear"></div>
					</div>
	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.', 'depo-masthead'); ?></p>

<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
