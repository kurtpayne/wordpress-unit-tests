<?php get_header(); ?>

	<div id="primary" class="single-post">
		<div class="inside">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="primary">
				<h1><?php the_title(); ?></h1>
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
				<?php wp_link_pages(); ?>
			</div>
			<hr class="hide" />
			<div class="secondary">
				<h2>About this entry</h2>
				<div class="featured">
					<p>You&rsquo;re currently reading &ldquo;<?php the_title(); ?>,&rdquo; an entry on <?php bloginfo('name'); ?></p>
					<dl>
						<dt>Published:</dt>
						<dd><?php the_time(get_option('date_format')) ?> / <?php the_time() ?></dd>
					</dl>
					<dl>
						<dt>Category:</dt>
						<dd><?php the_category(', ') ?></dd>
					</dl>
					<?php if (is_callable('the_tags')) : ?>
					<dl>
						<dt>Tags:</dt>
						<dd><?php the_tags(''); ?></dd>
					</dl>
					<?php endif; ?>
					<?php edit_post_link('Edit this entry.', '<dl><dt>Edit:</dt><dd> ', '</dd></dl>'); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- [END] #primary -->
	
	<hr class="hide" />
	<div id="secondary">
		<div class="inside">
			<?php comments_template(); ?>
			
			<?php endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
			<?php endif; ?>
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
