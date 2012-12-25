<?php get_header(); ?>

	<div id="content">

		<h2>Doh!</h2>
		<p>Something has gone wrong, the page you're looking for can't be found.</p>
		<p>Hopefully one of the options below will help you</p>
		<ul>
		<li>You can search the site using the search box to the right</li>
		<li>You could visit <a href="<?php echo get_settings('home'); ?>">the homepage</a></li>
		<li>Or you could have a look through the recent posts listed below, maybe what you're looking for is there</li>
		</ul>
		
		<h3>Recent Posts</h3>
		<ul>
		<?php
		query_posts('posts_per_page=5');
		if (have_posts()) : while (have_posts()) : the_post(); ?>
			<li><a href="<?php the_permalink() ?>" title="Permalink for : <?php the_title(); ?>"><?php the_title(); ?></a>
		<?php endwhile; endif; ?>
		</ul>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
