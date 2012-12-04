
<!-- subcontent ................................. -->
<div id="side">
<?php if ( !dynamic_sidebar('sidebar') ) {
	if (is_home() || is_page() || is_single() || is_page("archives") || is_archive() || is_search()) { ?>
	
	<?php get_search_form(); ?>

	<h3><em>Pages</em></h3>

	<ul>
		<li<?php if (is_home()) echo " class=\"selected\""; ?>><a href="<?php bloginfo('url'); ?>">Home</a></li>
		<?php
		$pages = BX_get_pages();
		if ($pages) {
			foreach ($pages as $page) {
				$page_id = $page->ID;
   				$page_title = $page->post_title;
   				$page_name = $page->post_name;
   				if ($page_name == "archives") {
   					(is_page($page_id) || is_archive() || is_search() || is_single())?$selected = ' class="selected"':$selected='';
   					echo "<li".$selected."><a href=\"".get_page_link($page_id)."\">Archives</a></li>\n";
   				}
   				elseif($page_name == "about") {
   					(is_page($page_id))?$selected = ' class="selected"':$selected='';
   					echo "<li".$selected."><a href=\"".get_page_link($page_id)."\">About</a></li>\n";
   				}
   				elseif ($page_name == "contact") {
   					(is_page($page_id))?$selected = ' class="selected"':$selected='';
   					echo "<li".$selected."><a href=\"".get_page_link($page_id)."\">Contact</a></li>\n";
   				}
   				elseif ($page_name == "about_short") {/*ignore*/}
           	 	else {
            		(is_page($page_id))?$selected = ' class="selected"':$selected='';
            		echo "<li".$selected."><a href=\"".get_page_link($page_id)."\">$page_title</a></li>\n";
            	}
    		}
    	}
		?>
	</ul>

	<h3><em>Categories</em></h3>

	<ul class="categories">
	<?php wp_list_cats('sort_column=name'); ?> 
	</ul>

<?php if(!is_single()) { ?>

	<h3><em>Links</em></h3>

	<ul class="links">
	<?php get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
	</ul>

	<h3><em>Meta</em></h3>

	<ul class="meta">
	<li><?php wp_loginout(); ?></li>
	<li><a href="<?php bloginfo_rss('rss2_url'); ?> ">Entries (RSS)</a></li>
	<li><a href="<?php bloginfo_rss('comments_rss2_url'); ?> ">Comments (RSS)</a></li>
	</ul>
	
<?php } ?>

<?php } ?>


<?php if (is_single() || is_page() || is_home()) { ?>

	<h3><em>Calendar</em></h3>

	<?php get_calendar() ?>

	<h3><em>Most Recent Posts</em></h3>

	<ul class="posts">
	<?php BX_get_recent_posts($p,10); ?>
	</ul>

<?php } ?>


<?php if (is_page("archives") || is_archive() || is_search()) { ?>

	<h3><em>Calendar</em></h3>

	<?php get_calendar() ?>

	<?php if (!is_page("archives")) { ?>

		<h3><em>Posts by Month</em></h3>

		<ul class="months">
		<?php get_archives('monthly','','','<li>','</li>',''); ?>
		</ul>

	<?php } ?>

	<h3><em>Posts by Category</em></h3>

	<ul class="categories">
	<?php wp_list_cats('sort_column=name&hide_empty=0'); ?> 
	</ul>

<?php } } ?>


</div> <!-- /subcontent -->
