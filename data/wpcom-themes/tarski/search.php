<?php get_header(); ?>
	<?php if (have_posts()) : ?>
		<div id="intro">
			<h1>Search results</h1>
		</div>

		<div id="primary">
		<?php while (have_posts()) : the_post(); ?>
			<div class="post-brief">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<p class="post-metadata"><?php the_time(get_option('date_format')) ?> in <?php the_category(', ', '' ); ?> | <?php comments_popup_link('Leave a comment', '1 comment', '% comments', '', 'Comments closed'); ?><br /> <?php the_tags('Tags: ', ', ', '<br />'); ?></p>
				<p class="excerpt"><?php the_excerpt() ?></p>
			</div>
		<?php endwhile; ?>
		</div>

		<div id="secondary">
			<?php include (TEMPLATEPATH . "/searchform.php"); ?>
		</div>
<?php else : ?>
		<div id="intro">
			<h1>Not found</h1>
		</div>

		<div id="primary">
			<p>Sorry, there were no results returned for the terms you searched for. Please try a new search.</p>
		</div>

		<div id="secondary">
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</div>
<?php endif; ?>
<?php get_footer(); ?>
