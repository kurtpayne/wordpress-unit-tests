<?php get_header(); ?>

	<div id="content">
		
	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>

						
					<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
						<div class="data"><?php the_time(get_option('date_format')) ?> - <?php comments_popup_link('Leave a Response', 'One Response', '% Responses'); ?></div>
						
						<div class="entry">
							<?php the_content('Read the rest of this entry &raquo;'); ?>
							<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
						</div>

							<p class="postmetadata">
								Categorized in <?php the_nice_category(', ', ' and '); ?> <?php edit_post_link('Edit', ' | ', ''); ?>
<br />
<?php the_tags('Tags: ', ', ', ''); ?>
							</p>

					</div>
				
				<?php endwhile; ?>
		
				<div class="navigation">
					<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
					<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
				</div>
		
	<?php else : ?>

		<h4>Not Found</h4>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	</div>
	

<?php get_sidebar(); ?>

<?php get_footer(); ?>
