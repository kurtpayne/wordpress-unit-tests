<?php

/**
 * Function BX_get_recent_posts
 * ------------------------------------------------------
 * Outputs an unorderd list of the most recent posts.
 *
 * $current_id		this post will be excluded
 * $limit			max. number of posts
 */

function BX_get_recent_posts($current_id, $limit)
{
	global $wpdb;
	$posts = $wpdb->get_results("SELECT ID, post_title FROM " . $wpdb->posts . " WHERE post_status='publish' AND post_type='post' ORDER BY post_date DESC LIMIT " . $limit);
	foreach ($posts as $post) {
		$post_title = stripslashes($post->post_title);
		$permalink  = get_permalink($post->ID);
		if ($post->ID != $current_id) echo "<li><a href=\"" . $permalink . "\">" . $post_title . "</a></li>\n";
	}
}


/**
 * Function BX_get_pages
 * ------------------------------------------------------
 * Returns the following of all WP pages:
 * ID, title, name, (content)
 *
 * $withcontent		specifies if the page's content will
 *					also be returned
 */

function BX_get_pages($with_content = '')
{
	global $wpdb;
	$query = "SELECT ID, post_title, post_name FROM " . $wpdb->posts . " WHERE post_status='publish' AND post_type='page' AND post_parent = '0' ORDER BY menu_order ASC";
	if ($with_content == "with_content") {
	   $query = "SELECT ID, post_title,post_name, post_content FROM " . $wpdb->posts . " WHERE post_status='publish' AND post_type='page' ORDER BY menu_order ASC";
	}
	return $wpdb->get_results($query);
}


/**
 * Function BX_excluded_pages()
 * ------------------------------------------------------
 * Returns the Blix default pages that are excluded
 * from the navigation in the sidebar
 *
 */

function BX_excluded_pages()
{
	$pages = BX_get_pages();
	$exclude = "";
	if ($pages) {
		foreach ($pages as $page) {
			$page_id = $page->ID;
   			$page_name = $page->post_name;
   			if ($page_name == "archives" || $page_name == "about"  || $page_name == "about_short" || $page_name == "contact") {
   				$exclude .= ", ".$page_id;
   			}
   		}
   		$exclude = preg_replace("/^, (.*?)/","\\1",$exclude);
   	}
   	return $exclude;
}


/**
 * Function BX_shift_down_headlines
 * ------------------------------------------------------
 * Shifts down the headings by one level (<h5> --> </h6>)
 * Used for posts in the archive
 */

function BX_shift_down_headlines($text)
{
	$text = apply_filters('the_content', $text);
	$text = preg_replace("/h5>/","h6>",$text);
	$text = preg_replace("/h4>/","h5>",$text);
	$text = preg_replace("/h3>/","h4>",$text);
	echo $text;
}


/**
 * Function BX_remove_p
 * ------------------------------------------------------
 * Removes the opening <p> and closing </p> from $text
 * Used for the short about text on the front page
 */

function BX_remove_p($text)
{
	$text = apply_filters('the_content', $text);
    $text = preg_replace("/^[\t|\n]?<p>(.*)/","\\1",$text); // opening <p>
    $text = preg_replace("/(.*)<\/p>[\t|\n]$/","\\1",$text); // closing </p>
    return $text;
}

?>
