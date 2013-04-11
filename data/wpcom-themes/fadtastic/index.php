<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); $loopcounter++; ?>
				<?php if ( $loopcounter == 1 || is_sticky() ) { $saved_ids[] = get_the_ID(); ?>
				<h1 id="post-<?php the_ID(); ?>" ><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<p class="author fresh" >Posted on <em><?php the_time(get_option('date_format')) ?></em>. Filed under: <?php the_category(',') ?> | <?php the_tags('Tags: ', ', ', ' | '); ?> <?php edit_post_link('Edit This'); ?></p>

				<?php the_content(); ?>
				<br class="clear" />
				<big>
					<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">Read Full Post</a></strong> | 
					<strong>
						<?php if ('open' == $post->comment_status) : ?> 
						<a href="<?php the_permalink() ?>#respond" title="Make a comment">Make a Comment</a>
						<?php else : ?> 
						Comments are Closed
						<?php endif;?>
					</strong> 
					<small>
						<?php if ('open' == $post->comment_status) : ?> 
						 ( <strong><?php comments_popup_link('None', '1', '%'); ?></strong> so far )
						<?php endif; ?>
					</small>
				</big>
				<?php } ?>
				<?php endwhile; ?>
								
				<?php else : ?>

				<h2>Not Found</h2>
				<p>Sorry, but you are looking for something that isn't here.</p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
				<?php endif; ?>
				
				<!-- Minor posts start here -->
				
				<h2 class="recently">Recently on <?php bloginfo('name'); ?>...</h2>
				<?php
				query_posts(array(
				'showposts' => 10,
				'post__not_in' => $saved_ids,
				));
				?>
				
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<?php if(!is_sticky()) :?>
				<div class="recent_post">
					<h2 id="post-<?php the_ID(); ?>" ><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<p class="author" >Posted on <em><?php the_time(get_option('date_format')) ?></em>. Filed under: <?php the_category(',') ?> | <?php the_tags('Tags: ', ', ', ' | '); ?> <?php edit_post_link('Edit This'); ?></p>
				</div>

				<?php endif; endwhile; ?>
								
				<?php else : ?>

				<h2>Not Found</h2>
				<p>Sorry, but you are looking for something that isn't here.</p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
				<?php endif; ?>

			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
