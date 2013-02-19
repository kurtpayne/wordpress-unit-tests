<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<h1 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<p class="author">Posted on <em><?php the_time(get_option('date_format')) ?></em>. Filed under: <?php the_category(',') ?> | <?php the_tags('Tags: ', ', ', ' | '); ?> <?php edit_post_link('Edit This'); ?></p>

				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
				
				<?php if ('open' == $post->comment_status) : ?> 
					<p class="clear"><strong><a href="#respond">Make a Comment</a></strong></p>
				<? endif;?>
								
				<?php endwhile; ?>
				
				
				<?php else : ?>

				<h2>Not Found</h2>
				<p>Sorry, but you are looking for something that isn't here.</p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
				<?php endif; ?>
				
				<!-- Story ends here -->
				
				<?php comments_template(); ?>

			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
