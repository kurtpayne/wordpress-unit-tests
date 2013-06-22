<?php get_header(); ?>

		<div id="content_box">
		
			<div id="content">

				<?php if (have_posts()) : ?>
			
					<h2 class="archive_head">Search Results</h2>
			
					<?php while (have_posts()) : the_post(); ?>
							
						<div <?php post_class(); ?>>
							<h4><?php the_time(get_option('date_format')) ?></h4>
							<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
							<div class="post_meta">
								<p class="num_comments"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></p>
								<p class="tagged"><?php printf(__('Filed under %s'), get_the_category_list(', ')); ?></p>
								<p class="tagged"><?php the_tags(__('Tags:').' ', ', ', '<br />'); ?></p>
							</div> 

						</div>
				
					<?php endwhile; ?>
					
					<div class="navigation">
						<p class="next"><?php previous_posts_link(__('Newer Entries')) ?></p>
						<p class="previous"><?php next_posts_link(__('Older Entries')) ?></p>

					</div>
				
				<?php else : ?>
			
				<h2 style="text-align: center; margin-bottom: 15px;"><?php _e('No posts found. Try a different search?'); ?></h2>
					<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			
				<?php endif; ?>
				
			</div>

			<?php get_sidebar(); ?>

		</div>

<?php get_footer(); ?>
