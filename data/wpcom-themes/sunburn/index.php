<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			
				<div class="date">
					<div class="date_month"><?php the_time('M') ?></div>
					<div class="date_day"><?php the_time('d') ?></div>
				</div>
				
				<div class="title_box">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2> 
					<div class="comment_link"><?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></div>
				</div>
				
				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>
		
				<p class="postmetadata">Categorized in <?php the_nice_category(', ', ' and '); ?><?php edit_post_link('Edit', ' | ', ''); ?><br /><?php the_tags('Tags: ', ', ', '<br />'); ?></p>
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
