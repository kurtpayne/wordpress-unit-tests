<?php
/*
Template Name: Links Page
*/
?>
<?php get_header() ?>
	
	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class() ?>">
				<h2 class="entry-title"><?php the_title() ?></h2>
				<div class="entry-content">
<?php the_content() ?>

					<ul id="linkcats">
						<?php wp_list_bookmarks(); ?>
					</ul>
<?php edit_post_link(__('Edit this entry.', 'sandbox'),'<p class="edit-link">','</p>') ?>

				</div>
			</div><!-- .post -->

<?php /* Add a custom field with key "comments" (value is ignored) to turn on comments for a page! */ ?>
<?php if ( get_post_custom_values('comments') ) comments_template() ?>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>
