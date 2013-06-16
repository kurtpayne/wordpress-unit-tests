<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header() ?>
	
	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h2 class="entry-title"><?php the_title() ?></h2>
				<div class="entry-content">
<?php the_content(); ?>

					<div id="archives-by-category" class="content-column">
					<h3><?php _e('Archives by Category', 'sandbox') ?></h3>
						<ul>
							<?php wp_list_cats('sort_column=name&optioncount=1&feed=RSS') ?> 
						</ul>
					</div>
					<div id="archives-by-month" class="content-column">
					<h3><?php _e('Archives by Month', 'sandbox') ?></h3>
						<ul>
							<?php wp_get_archives('type=monthly&show_post_count=1') ?>
						</ul>
					</div>
<?php edit_post_link(__('Edit this entry.', 'sandbox'),'<p class="edit-link">','</p>') ?>

				</div>
			</div><!-- .post -->

<?php /* Add a custom field with key "comments" (value is ignored) to turn on comments for a page! */ ?>
<?php if ( get_post_custom_values('comments') ) comments_template() ?>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>