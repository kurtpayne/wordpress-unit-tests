<?php get_header(); ?>

		<div id="content_box">
		
			<div id="content">
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<div class="navigation">
						<div class="previous"><?php previous_post_link('%link') ?></div>
						<div class="next"><?php next_post_link('%link') ?></div>
					</div>
				
					<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h4><?php the_time(get_option('date_format')) ?>...<?php the_time() ?></h4>
						<h2><?php the_title(); ?></h2>
				
						<div class="entry">
							<?php if ( have_comments() || comments_open() ) : ?>
								<span class="jump"><a href="<?php the_permalink() ?>#comments"><?php _e('Jump to Comments'); ?></a></span>
								<br class="clear" />
							<?php endif; ?>
							<?php the_content('<p>'.__('Read the rest of this entry &raquo;').'</p>'); ?>
				
							<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
				
							<div class="post_meta">
								<p class="num_comments"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></p>
								<p class="tagged"><?php printf(__('Filed under %s'), get_the_category_list(', ')); ?></p>
								<p class="tagged"><?php the_tags(__('Tags:').' ', ', ', '<br />'); ?></p>
							</div> 

						</div>
					</div>
					
					<?php comments_template(); ?>
				
				<?php endwhile; else: ?>
				
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				
				<?php endif; ?>
			
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>

<?php get_footer(); ?>
