<?php
// Produces a list of pages in the header without whitespace -- er, I mean negative space.
function sandbox_globalnav() {
	echo '<div id="menu"><ul>';
	$menu = wp_list_pages('title_li=&sort_column=menu_order&echo=0'); // Params for the page list in header.php
	echo str_replace(array("\r", "\n", "\t"), '', $menu);
	echo "</ul></div>\n";
}

// Checks for WP 2.1.x language_attributes() function
function sandbox_blog_lang() {
	if ( function_exists('language_attributes') )
		return language_attributes();
}

// Generates semantic classes for BODY element
function sandbox_body_class( $print = true ) {
	global $wp_query, $current_user;
	
	// It's surely a WordPress blog, right?
	$c = array('wordpress');

	// Applies the time- and date-based classes (below) to BODY element
	sandbox_date_classes(time(), $c);

	// Generic semantic classes for what type of content is displayed
	is_home()       ? $c[] = 'home'       : null;
	is_archive()    ? $c[] = 'archive'    : null;
	is_date()       ? $c[] = 'date'       : null;
	is_search()     ? $c[] = 'search'     : null;
	is_paged()      ? $c[] = 'paged'      : null;
	is_attachment() ? $c[] = 'attachment' : null;
	is_404()        ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	// Special classes for BODY element when a single post
	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();
		$c[] = 'single postid-' . $postID;
		if ( isset($wp_query->post->post_date) )
			sandbox_date_classes(mysql2date('U', $wp_query->post->post_date), $c, 's-');
		foreach ( (array) get_the_category() as $cat )
			$c[] = 's-category-' . $cat->category_nicename;
			$c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
		rewind_posts();
	}

	// Author name classes for BODY on author archives
	else if ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	// Category name classes for BODY on category archvies
	else if ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->category_nicename;
	}

	// Page author for BODY on 'pages'
	else if ( is_page() ) {
		$pageID = $wp_query->post->ID;
		the_post();
		$c[] = 'page pageid-' . $pageID;
		$c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
		rewind_posts();
	}

	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$c[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get("paged") ) || ( $page = $wp_query->get("page") ) ) && $page > 1 ) {
		$page = intval($page);
		$c[] = 'paged-'.$page.'';
		if ( is_single() ) {
			$c[] = 'single-paged-'.$page.'';
		} else if ( is_page() ) {
			$c[] = 'page-paged-'.$page.'';
		} else if ( is_category() ) {
			$c[] = 'category-paged-'.$page.'';
		} else if ( is_date() ) {
			$c[] = 'date-paged-'.$page.'';
		} else if ( is_author() ) {
			$c[] = 'author-paged-'.$page.'';
		} else if ( is_search() ) {
			$c[] = 'search-paged-'.$page.'';
		}
	}

	// Separates classes with a single space, collates classes for BODY
	$c = join(' ', apply_filters('body_class',  $c));

	// And tada!
	return $print ? print($c) : $c;
}

// Generates semantic classes for each post DIV element
function sandbox_post_class( $print = true ) {
	global $post, $sandbox_post_alt;

	// gets 'alt' for every other post DIV, describes the post status
	$c = array("p$sandbox_post_alt", $post->post_status);

	// Author for the post queried
	$c[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));

	// For password-protected posts
	if ( $post->post_password )
		$c[] = 'protected';

	// Applies the time- and date-based classes (below) to post DIV
	sandbox_date_classes(mysql2date('U', $post->post_date), $c);

	// If it's the other to the every, then add 'alt' class
	if ( ++$sandbox_post_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for post DIV
	$c = join(' ', get_post_class( $c, $post->ID ));

	// And tada!
	return $print ? print($c) : $c;
}

// Define the num val for 'alt' classes (in post DIV and comment LI)
$sandbox_post_alt = 1;

// Generates semantic classes for each comment LI element
function sandbox_comment_class( $print = true ) {
	global $comment, $post, $sandbox_comment_alt;

	// Collects the comment type (comment, trackback),
	$c = array($comment->comment_type);

	// Counts trackbacks (t[n]) or comments (c[n])
	if ($comment->comment_type == 'trackback') {
		$c[] = "t$sandbox_comment_alt";
	} else {
		$c[] = "c$sandbox_comment_alt";
	}

	// If the comment author has an id (registered), then print the log in name
	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);

		// For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
		$c[] = "byuser comment-author-" . sanitize_title_with_dashes(strtolower($user->user_login));
		// For comment authors who are the author of the post
		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	// If it's the other to the every, then add 'alt' class; collects time- and date-based classes
	sandbox_date_classes(mysql2date('U', $comment->comment_date), $c, 'c-');
	if ( ++$sandbox_comment_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for comment LI
	$c = join(' ', apply_filters('comment_class', $c));

	// Tada again!
	return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function sandbox_date_classes($t, &$c, $p = '') {
	$t = $t + (get_settings('gmt_offset') * 3600);
	$c[] = $p . 'y' . gmdate('Y', $t); // Year
	$c[] = $p . 'm' . gmdate('m', $t); // Month
	$c[] = $p . 'd' . gmdate('d', $t); // Day
	$c[] = $p . 'h' . gmdate('H', $t); // Hour
}

// For category lists on category archives, returns other categorys except the current one (redundant)
function sandbox_cats_meow($glue) {
	$current_cat = single_cat_title('', false);
	$separator = "\n";
	$cats = explode($separator, get_the_category_list($separator));

	foreach ( $cats as $i => $str ) {
		if ( strstr($str, ">$current_cat<") ) {
			unset($cats[$i]);
			break;
		}
	}

	if ( empty($cats) )
		return false;

	return trim(join($glue, $cats));
}

// Widget: Search; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_search($args) {
	extract($args);
	if ( empty($title) )
		$title = __('Search', 'sandbox');
?>
		<?php echo $before_widget ?>
			<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
			<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
				<div>
					<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="10" tabindex="1" />
					<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'sandbox') ?>" tabindex="2" />
				</div>
			</form>
		<?php echo $after_widget ?>

<?php
}

// Widget: Meta; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_meta($args) {
	extract($args);
	if ( empty($title) )
		$title = __('Meta', 'sandbox');
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<?php wp_register() ?>
				<li><?php wp_loginout() ?></li>
				<?php wp_meta() ?>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; to match the Sandbox style
function widget_sandbox_rsslinks($args) {
	extract($args);
	$options = get_option('widget_sandbox_rsslinks');
	$title = empty($options['title']) ? __('RSS Links', 'sandbox') : $options['title'];
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'sandbox'); ?>" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'sandbox') ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> <?php _e('Comments RSS feed', 'sandbox'); ?>" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'sandbox') ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; element controls for customizing text within Widget plugin
function widget_sandbox_rsslinks_control() {
	$options = $newoptions = get_option('widget_sandbox_rsslinks');
	if ( $_POST["rsslinks-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["rsslinks-title"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_sandbox_rsslinks', $options);
	}
	$title = htmlspecialchars($options['title'], ENT_QUOTES);
?>
			<p>
				<label for="rsslinks-title">
					<?php _e('Title:'); ?>
					<input class="widefat" id="rsslinks-title" name="rsslinks-title" type="text" value="<?php echo $title; ?>" />
				</label>
			</p>
			<input type="hidden" id="rsslinks-submit" name="rsslinks-submit" value="1" />
<?php
}

// Widget and Sandbox function: creates bookmark links (blogrolls) for WP 2.0.x or WP 2.1.x
function widget_sandbox_links() {
	wp_list_bookmarks(array('title_before'=>'<h3>', 'title_after'=>'</h3>', 'show_images'=>true));
}

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function sandbox_widgets_init() {
	// Uses H3-level headings with all widgets to match Sandbox style
	$p = array(
		'before_title' => "<h3 class='widgettitle'>",
		'after_title' => "</h3>\n",
	);

	// Table for how many? Two? This way, please.
	register_sidebars(2, $p);

	// Finished intializing Widgets plugin, now let's load the Sandbox default widgets
	unregister_widget('WP_Widget_Search');
	wp_register_sidebar_widget('search', __('Search', 'sandbox'), 'widget_sandbox_search');
	unregister_widget('WP_Widget_Meta');
	wp_register_sidebar_widget('meta', __('Meta', 'sandbox'), 'widget_sandbox_meta');
	unregister_widget('WP_Widget_Links');
	wp_register_sidebar_widget('links', __('Links', 'sandbox'), 'widget_sandbox_links');
	register_sidebar_widget(array(__('RSS Links', 'sandbox'), 'widgets'), 'widget_sandbox_rsslinks');
	register_widget_control(array(__('RSS Links', 'sandbox'), 'widgets'), 'widget_sandbox_rsslinks_control', null, 90);
}

// Translate, if applicable
load_theme_textdomain('sandbox');

// Runs our code at the end to check that everything needed has loaded
add_action('widgets_init', 'sandbox_widgets_init');

// Adds filters so that things run smoothly
add_filter('archive_meta', 'wptexturize');
add_filter('archive_meta', 'convert_smilies');
add_filter('archive_meta', 'convert_chars');
add_filter('archive_meta', 'wpautop');

// Remember: a Sandbox is for play.

// wpcom custom
function sandbox_theme_data($thing='Name', $default='') {
	static $theme_data = NULL;

	if ($theme_data === NULL) {
		$theme_data = get_theme_data(STYLESHEETPATH . '/style.css');
		wp_debug_log(print_r($theme_data, true));
	}

	if (isset($theme_data[$thing]))
		return $theme_data[$thing];
	return $default;
}

?>
