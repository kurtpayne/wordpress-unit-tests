<?php get_header(); ?>
		
		<div id="content_box">

			<div id="content">
		

				<?php if (have_posts()) : ?>
		
					<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			
					<?php /* If this is a category archive */ if (is_category()) { ?>				
						<h2 class="archive_head"><?php printf(__('Entries Tagged as &#8216;%s&#8217;'), single_cat_title('', false)); ?></h2>


<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="archive_head"><?php printf(__('Posts Tagged as &#8216;%s&#8217;'), single_cat_title('', false)); ?></h2>


					
					<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
						<h2 class="archive_head"><?php printf(__('Entries from %s'), get_the_time('F Y')); ?></h2>
					
					<?php /* If this is a search */ } elseif (is_search()) { ?>
					<h2 class="archive_head"><?php _e('Search Results'); ?></h2>
		
				<?php } ?>

				<?php while (have_posts()) : the_post(); ?>
					<div <?php post_class(); ?>>
						<h4><?php the_time(get_option('date_format')) ?></h4>
						<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
						
						<div class="entry">
							<?php the_excerpt() ?>
						</div>
				
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
			
				<h2 class="center"><?php _e('Not Found'); ?></h2>
					<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			
				<?php endif; ?>
				
			</div>
		
			<?php get_sidebar(); ?>
			
		</div>
		
<?php get_footer(); ?>
