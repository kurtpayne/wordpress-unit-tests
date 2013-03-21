<?php get_header(); ?>

		<div id="content_box">
		
			<div id="content">
			
				<?php if (have_posts()) : ?>
					
					<?php while (have_posts()) : the_post(); ?>
							
						<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
							<h4><?php the_time(get_option('date_format')) ?> <!-- by <?php the_author() ?> --></h4>
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
							
							<div class="entry">
								<?php the_content(__('Keep reading &rarr;')); ?>
							</div>
							
							<div class="post_meta">
								<p class="num_comments"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></p>
								<p class="tagged"><?php printf(__('Filed under %s'), get_the_category_list(', ')); ?></p>
								<p class="tagged"><?php the_tags(__('Tags:').' ', ', ', '<br />'); ?></p>
							</div> 

						</div>
				
					<?php endwhile; ?>
					
				<?php else : ?>
			
					<h2 class="center"><?php _e('Not Found'); ?></h2>
					<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
					<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
				<?php endif; ?>

				<div class="navigation">
					<p class="next"><?php previous_posts_link(__('Newer Entries')) ?></p>
					<p class="previous"><?php next_posts_link(__('Older Entries')) ?></p>

				</div>

			</div>

			<?php get_sidebar(); ?>
		
		</div>

<?php get_footer(); ?>
