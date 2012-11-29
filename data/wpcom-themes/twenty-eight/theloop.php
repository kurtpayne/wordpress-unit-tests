<?php /* Initialize The Loop */ if (have_posts()) { $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

<?php is_tag(); ?>
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

	<?php while (have_posts()) { the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('item entry'); ?>>
				<div class="itemhead">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title='<?php strip_tags(the_title()); ?>'><?php the_title(); ?></a></h3>

					<?php edit_post_link('<img src="'.get_bloginfo('template_directory').'/images/pencil.png" alt="Edit Link" />','<span class="editlink">','</span>'); ?>
						
				<p class="metadata"><?php the_time(get_option('date_format')) ?> in <?php { the_category(', '); }?><?php if ( (is_home()) && !(is_page()) && !(is_single()) && !(is_search()) && !(is_archive()) && !(is_author()) && !(is_category()) && !(is_paged()) OR is_search() ) { ?>&nbsp;with&nbsp;<?php comments_popup_link('Leave a <span>Comment</span>', '1&nbsp;<span>Comment</span>', '%&nbsp;<span>Comments</span>', 'commentslink', '<span class="commentslink">Closed</span>'); ?><?php } ?><br /><?php the_tags('Tags: ', ', ', '<br />'); ?></p>
						
				</div>
	
				<div class="itemtext">
					<?php if (is_archive() or is_search()) { 
						the_excerpt();
					} else {
						the_content("Continue Reading &raquo;");
					} ?>
	
					<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				</div>

			</div>


<?php	/* End The Loop */ }

	/* Insert Paged Navigation */ if (!is_single()) { include (TEMPLATEPATH . '/navigation.php'); } ?>

<?php /* If there is nothing to loop */  } else { $notfound = '1'; /* So we can tell the sidebar what to do */ ?>

<h2>Oops, I Did Not Find Anything</h2><div class="item"><div class="itemtext"><p>What you were searching for could not be found. Maybe what you are looking for can be found by trying an alternate search query or browsing through the archives.</p></div></div>

<?php /* End Loop Init */ } ?>
