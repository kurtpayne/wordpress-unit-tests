<?php /*
	This is the loop, which fetches entries from your database. It is used in some
	form on most of the K2 pages. Because of that, to make editing all of them easier,
	it has been placed in its own file, which is then included where needed.
*/ ?>

<?php is_tag(); ?>
<?php /* Initialize The Loop */ if (have_posts()) { $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

	<?php // Headlines for archives
	if (!is_single() && !is_home() or is_paged()) { ?>
	<div class="pagetitle">
		<h2>
		<?php /* If this is a category archive */ if (is_category()) { ?>				
		Archive for the '<?php echo single_cat_title(); ?>' Category

		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
        <h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>

		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		Archive for <?php the_time('F jS, Y'); ?>

		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		Archive for <?php the_time('F, Y'); ?>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		Archive for <?php the_time('Y'); ?>

		<?php /* If this is a search */ } elseif (is_search()) { ?>
		Search Results for '<?php echo $s; ?>'

		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		Author Archive for <?php $post = $wp_query->post;
			$the_author = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$post->post_author' AND meta_key = 'nickname'"); echo $the_author; ?>
		
		<?php /* If this is a paged archive */ } elseif (is_paged()) { ?>
		Archive Page <?php echo $paged; ?>
		
		<?php } ?>
		</h2>
	</div>

	<?php } ?>

	<?php /*
		The 'next page' and 'previous page' navigation for permalinks have to be inside the loop.
		The exact opposite is true for the same navigation links on all other pages.
		Also, we don't want them at the top of the frontpage: */
		
		if (!is_single() && !is_home() or is_paged()) include (TEMPLATEPATH . '/navigation.php');

		/* Start The Loop */ while (have_posts()) { the_post();	

		if (is_single()) include (TEMPLATEPATH . '/navigation.php');
	?>
	
			<div id="post-<?php the_ID(); ?>" <?php post_class('item entry'); ?>>
				<div class="itemhead">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title='Permanent Link to "<?php strip_tags(the_title()); ?>"'><?php the_title(); ?></a></h3>
					<div class="chronodata"><?php { the_time('dMy') ?><?php } ?></div>
	
					<!-- The following two sections are for a noteworthy plugin currently in alpha. They'll get cleaned up and integrated better -->
					<?php foreach((get_the_category()) as $cat) {  if ($cat->cat_name == 'Noteworthy') { ?>
						<span class="metalink favorite"><img src="<?php bloginfo('template_url'); ?>/images/favorite.gif" alt="Favorite Entry" /></span>
					<?php } } ?>

						<?php edit_post_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="Edit Link" />','<span class="editlink">','</span>'); ?>					

				</div>
	
				<div class="itemtext">
					<?php if (is_archive() or is_search()) { 
						the_excerpt();
					} else {
						the_content("Continue reading '" . the_title('', '', false) . "'");
					} ?>
	
					<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				</div>
				<br class="clear" />
				<small class="metadata">			
					<span class="category">Filed under: <?php the_category(', '); ?>	</span>
					&nbsp;&nbsp;|&nbsp;&nbsp;<?php comments_popup_link('Leave a <span>Comment</span>', '1&nbsp;<span>Comment</span>', '%&nbsp;<span>Comments</span>', 'commentslink', '<span class="commentslink">Closed</span>'); ?>	
					<br /><?php the_tags('Tags: ', ', ', '<br />'); ?>
				</small>
			</div>

<?php
	/* End The Loop */ }

	/* Insert Paged Navigation */ if (!is_single()) { include (TEMPLATEPATH . '/navigation.php'); } ?>

<?php /* If there is nothing to loop */  } else { $notfound = '1'; /* So we can tell the sidebar what to do */ ?>

	<div class="center">
		<h2>Not Found</h2>
	</div>

	<div class="item">
	<div class="itemtext2">
		<p>Oh no! You're looking for something which just isn't here! Fear not however,
		errors are to be expected, and luckily there are tools on the sidebar for you to
		use in your search for what you need.</p>
	</div>
	</div>

<?php /* End Loop Init */ } ?>
