<hr class="low" />

<!-- subcontent ................................. -->
<div id="subcontent">

<?php /**
       * Pages navigation. Disabled by default because all new pages are added
       * to the main navigation.
       * If enabled: Blix default pages are excluded by default.
       *
?>
	<h2><em>Pages</em></h2>
	<ul class="pages">
	<?php
		$excluded = BX_excluded_pages();
		wp_list_pages('title_li=&sort_column=menu_order&exclude='.$excluded);
	?>
	</ul>

<?php */ ?>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>

<?php if (is_home()) { ?>

	<?php
	/**
	 * If a page called "about_short" has been set up its content will be put here.
	 * In case that a page called "about" has been set up, too, it'll be linked to via 'More'.
	 */
	$pages = BX_get_pages('with_content');
	if ($pages) {
		foreach ($pages as $page) {
			$page_id = $page->ID;
   			$page_title = $page->post_title;
   			$page_name = $page->post_name;
   			$page_content = $page->post_content;

   			if ($page_name == "about") $more_url = '<a href="'.get_page_link($page_id).'" class="more">More</a>';
   			if ($page_name == "about_short") {
   				$about_title = $page_title;
   				$about_text = BX_remove_p($page_content);
   			}
		}
		if ($about_text != "") {
			echo "<h2><em>".$about_title."</em></h2>\n";
			echo "<p>".$about_text;
			if ($more_url != "") echo " ".$more_url;
			echo "</p>\n";
		}
	}
	?>

	<h2><em>Categories</em></h2>

	<ul class="categories">
	<?php wp_list_categories('sort_column=name&show_count=0&hierarchical=0&title_li='); ?>
	</ul>

	<?php wp_list_bookmarks('title_before=<h2><em>&title_after=</em></h2>'); ?>

	<h2><em>Feeds</em></h2>

	<ul class="feeds">
	<li><a href="<?php bloginfo_rss('rss2_url'); ?> ">Entries (RSS)</a></li>
	<li><a href="<?php bloginfo_rss('comments_rss2_url'); ?> ">Comments (RSS)</a></li>
	</ul>

<?php } ?>


<?php if (is_single()) { ?>

	<h2><em>Calendar</em></h2>

	<?php get_calendar() ?>

	<h2><em>Most Recent Posts</em></h2>

	<ul class="posts">
	<?php BX_get_recent_posts($p,10); ?>
	</ul>

<?php } ?>


<?php if (is_page("archives") || is_archive() || is_search()) { ?>

	<h2><em>Calendar</em></h2>

	<?php get_calendar() ?>

	<?php if (!is_page("archives")) { ?>

		<h2><em>Posts by Month</em></h2>

		<ul class="months">
		<?php get_archives('monthly','','','<li>','</li>',''); ?>
		</ul>

	<?php } ?>

	<h2><em>Posts by Category</em></h2>

	<ul class="categories">
	<?php wp_list_cats('sort_column=name&hide_empty=0'); ?>
	</ul>

<?php } ?>

<?php endif; /* Dynamic Sidebar */ ?>

</div> <!-- /subcontent -->
