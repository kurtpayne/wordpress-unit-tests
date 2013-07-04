<?php
// And thus begins the Sandbox guts! Registers our default
// options, specifically loads the 2c-1.css file as default skin
function sandbox_get_option($name) {
	$defaults = array(
		'skin' => '2c-l',
		);

	$options = array_merge($defaults, (array) get_option('sandbox_options'));

	if ( isset($options[$name]) )
		return $options[$name];

	return false;
}

// Andy really goes nuts with arrays, which has been a good thing. Very good.
function sandbox_set_options($new_options) {
	$options = (array) get_option('sandbox_options');

	$options = array_merge($options, (array) $new_options);

	return update_option('sandbox_options', $options);
}

// Template tag: echoes a stylesheet link if one is selected
function sandbox_stylesheets() {
	$skin = sandbox_get_option('skin');

	if ( strtolower(get_current_theme()) !== 'sandbox 0.6.1' ) {
?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri() ?>" />
<?php
	} else if ( $skin !== 'none' ) {
?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() . "/skins/$skin.css" ?>" title="Sandbox" />
<?php
	}
}

// Template tag: echoes a link to skip navigation if the
// global_navigation option is set to "Y" in the skin file
function sandbox_skipnav() {
	if ( !sandbox_get_option('globalnav') )
		return;

	echo '<p class="access"><a href="#content" title="'.__('Skip navigation to the content', 'sandbox').'">'.__('Skip navigation', 'sandbox').'</a></p>';
}

// Template tag: echoes a page list for navigation if the
// global_navigation option is set to "Y" in the skin file
function sandbox_globalnav() {
	if ( !sandbox_get_option('globalnav') )
		return;

	echo "<div id='globalnav'><ul id='menu'>";
	$menu = wp_list_pages('title_li=&sort_column=menu_order&echo=0');
	echo str_replace(array("\r", "\n", "\t"), '', $menu); // Strip intratag whitespace
	echo "</ul></div>";
}

// Template tag: echoes semantic classes in the <body>
function sandbox_body_class( $print = true ) {
	global $wp_query, $current_user;

	$c = array('wordpress');

	sandbox_date_classes(time(), $c);

	is_home()       ? $c[] = 'home'       : null;
	is_archive()    ? $c[] = 'archive'    : null;
	is_date()       ? $c[] = 'date'       : null;
	is_search()     ? $c[] = 'search'     : null;
	is_paged()      ? $c[] = 'paged'      : null;
	is_attachment() ? $c[] = 'attachment' : null;
	is_404()        ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	if ( is_single() ) {
		the_post();
		$c[] = 'single';
		if ( isset($wp_query->post->post_date) )
			sandbox_date_classes(mysql2date('U', $wp_query->post->post_date), $c, 's-');
		foreach ( (array) get_the_category() as $cat )
			$c[] = 's-category-' . $cat->category_nicename;
			$c[] = 's-author-' . get_the_author_login();
		rewind_posts();
	}

	else if ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	else if ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->category_nicename;
	}

	else if ( is_page() ) {
		the_post();
		$c[] = 'page';
		$c[] = 'page-author-' . get_the_author_login();
		rewind_posts();
	}

	if ( $current_user->ID )
		$c[] = 'loggedin';

	$c = join(' ', apply_filters('body_class',  $c));

	return $print ? print($c) : $c;
}

// Template tag: echoes semantic classes in each post <div>
function sandbox_post_class( $print = true ) {
	global $post, $sandbox_post_alt;

	$c = array("p$sandbox_post_alt", $post->post_status);

	$c[] = 'author-' . get_the_author_login();

	sandbox_date_classes(mysql2date('U', $post->post_date), $c);

	if ( ++$sandbox_post_alt % 2 )
		$c[] = 'alt';

	$c = join(' ', get_post_class( $c, $post->ID ));

	return $print ? print($c) : $c;
}
$sandbox_post_alt = 1;

// Template tag: echoes semantic classes for a comment <li>
function sandbox_comment_class( $print = true ) {
	global $comment, $post, $sandbox_comment_alt;

	$c = array($comment->comment_type, "c$sandbox_comment_alt");

	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);

		$c[] = "byuser commentauthor-$user->user_login";

		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	sandbox_date_classes(mysql2date('U', $comment->comment_date), $c, 'c-');
	if ( 0 == ++$sandbox_comment_alt % 2 )
		$c[] = 'alt';
		
	if ( is_trackback() ) {
		$c[] = 'trackback';
	}

	$c = join(' ', apply_filters('comment_class', $c));

	return $print ? print($c) : $c;
}

// Adds four time- and date-based classes to an array
// with all times relative to GMT (sometimes called UTC)
function sandbox_date_classes($t, &$c, $p = '') {
	$t = $t + (get_settings('gmt_offset') * 3600);
	$c[] = $p . 'y' . gmdate('Y', $t); // Year
	$c[] = $p . 'm' . gmdate('m', $t); // Month
	$c[] = $p . 'd' . gmdate('d', $t); // Day
	$c[] = $p . 'h' . gmdate('h', $t); // Hour
}

// Returns a list of the post's categories, minus the queried one
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

// Sandbox widgets: Replaces the default search widget with one 
// that matches what is in the Sandbox sidebar by default
function widget_sandbox_search($args) {
	extract($args);
	if ( empty($title) )
		$title = __('Search', 'sandbox');
?>
		<?php echo $before_widget ?>

			<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
			<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
				<div>
					<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="10" />
					<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find &raquo;', 'sandbox') ?>" />
				</div>
			</form>
		<?php echo $after_widget ?>

<?php
}

// Sandbox widgets: Replaces the default meta widget with one
// that matches what is in the Sandbox sidebar by default
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

// Sandbox widgets: Adds the Sandbox's home link as a widget, which
// appears when NOT on the home page OR on a page of the home page
function widget_sandbox_homelink($args) {
	extract($args);
	$options = get_option('widget_sandbox_homelink');
	$title = empty($options['title']) ? __('&laquo; Home') : $options['title'];
?>
<?php if ( !is_home() || is_paged() ) { ?>
		<?php echo $before_widget; ?>
			<?php echo $before_title ?><a href="<?php bloginfo('home') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?>"><?php echo $title ?></a><?php echo $after_title ?>
		<?php echo $after_widget; ?>
<?php } ?>
<?php
}

// Sandbox widgets: Adds the option to set the text for the home link widget
function widget_sandbox_homelink_control() {
	$options = $newoptions = get_option('widget_sandbox_homelink');
	if ( $_POST["homelink-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["homelink-title"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_sandbox_homelink', $options);
	}
	$title = htmlspecialchars($options['title'], ENT_QUOTES);
?>
		<p style="text-align:left;"><?php _e('Adds a link to the home page on every page <em>except</em> the home.', 'sandbox'); ?></p>
		<p>
			<label for="homelink-title">
				<?php _e('Link Text:'); ?>
				<input class="widefat" id="homelink-title" name="homelink-title" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		<input type="hidden" id="homelink-submit" name="homelink-submit" value="1" />
<?php
}

// Sandbox widgets: Adds a widget with the Sandbox RSS links
// as they appear in the default Sandbox sidebar, which are good
function widget_sandbox_rsslinks($args) {
	extract($args);
	$options = get_option('widget_sandbox_rsslinks');
	$title = empty($options['title']) ? __('RSS Links') : $options['title'];
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'sandbox') ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> Comments RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'sandbox') ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Sandbox widgets: Adds the option to set the text for the RSS link widget
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

// Template tag & Sandbox widget: Creates a string to produce
// links in either WP 2.1 or then WP 2.0 style, relative to install
function widget_sandbox_links() {
	wp_list_bookmarks(array('title_before'=>'<h3>', 'title_after'=>'</h3>', 'show_images'=>true));
}

// Sandbox skins menu: creates the array to collect
// information from the skins currently installed
function sandbox_skin_info($skin) {
	$info = array(
		'skin_name' => $skin,
		'skin_uri' => '',
		'description' => '',
		'version' => '1.0',
		'author' => __('Anonymous', 'sandbox'),
		'author_uri' => '',
		'global_navigation' => 'Y',
		);

	if ( !file_exists(TEMPLATEPATH."/skins/$skin.css") )
		return array();

	$css = (array) file(TEMPLATEPATH."/skins/$skin.css");

	foreach ( $css as $line ) {
		if ( strstr($line, '*/') )
			return $info;

		if ( !strstr($line, ':') )
			continue;

		list ( $k, $v ) = explode(':', $line, 2);

		$k = str_replace(' ', '_', strtolower(trim($k)));

		if ( array_key_exists($k, $info) )
			$info[$k] = stripslashes(wp_filter_kses(trim($v)));
	}
}

// Sandbox skins menu: Registers the workings of the skins menu
function sandbox_admin_skins() {
	$skins = array();
	if ( isset ( $_GET['message'] ) ) {
		switch ( $_GET['message'] ) {
			case 'updated' :
				echo "\n<div id='message' class='updated fade'><p>".__('Sandbox skin saved successfully.', 'sandbox')."</p></div>\n";
				break;
		}
	}
	$current_skin = sandbox_get_option('skin');
	$_skins = glob(TEMPLATEPATH.'/skins/*.css');
	foreach ( $_skins as $k => $v ) {
		$info = array();
		preg_match('/\/([^\/]+).css$/i', $v, $matches);
		if ( !empty($matches[1]) ) {
			$skins[$matches[1]] = sandbox_skin_info($matches[1]);
		}
	}
?>
<script type="text/javascript">
<!-- function showme(o) { document.getElementById('show').src = o.src; } //-->
</script>
<div class="wrap">
<h2><?php _e('Current Skin', 'sandbox') ?></h2>
<div id="currenttheme">
<?php if ( file_exists(get_template_directory() . "/skins/$current_skin.png") ) : ?>
<img src="<?php echo get_template_directory_uri() . "/skins/$current_skin.png"; ?>" alt="<?php _e('Current skin preview', 'sandbox'); ?>" />
<?php endif; ?>
<?php
	if ( is_array($skins[$current_skin]) )
		extract($skins[$current_skin]);
	if ( !empty($skin_uri) )
		$skin_name = "<a href=\"$skin_uri\" title=\"$skin_name by $author\">$skin_name</a>";
	if ( !empty($author_uri) )
		$author =  "<a href=\"$author_uri\" title=\"$author\">$author</a>";
?>
<h3><?php printf(__('%1$s %2$s by %3$s'), $skin_name, $version, $author) ; ?></h3>
<p><?php echo $description; ?></p>
</div>
<div class="clearer" style="clear:both;"></div>
<h2><?php _e('Available Skins', 'sandbox') ?></h2>
<?php
	foreach ( $skins as $skin => $info ) :
	if ( $skin == $current_skin || !is_array($info) )
		continue;
	extract($info);
	$activate_link = "themes.php?page=skins&amp;action=activate&amp;skin=$skin";
	// wp_nonce_url first introduced in WP 2.0.3
	if ( function_exists('wp_nonce_url') )
		$activate_link = wp_nonce_url($activate_link, 'switch-skin_' . $skin);
?>
<div class="available-theme">
<h3><a href="<?php echo $activate_link; ?>" title="Activate the <?php echo "$skin_name"; ?> skin"><?php echo "$skin_name $version"; ?></a></h3>
<a href="<?php echo $activate_link; ?>" class="screenshot" title="Activate the <?php echo "$skin_name"; ?> skin">
<?php if ( file_exists(get_template_directory() . "/skins/$skin.png" ) ) : ?>
<img src="<?php echo get_template_directory_uri() . "/skins/$skin.png"; ?>" alt="<?php echo "$skin_name"; ?>" />
<?php endif; ?>
</a>

<p><?php echo $description; ?></p>
</div>
<?php endforeach; ?>

<!--<h2><?php _e('Sandbox Info', 'sandbox'); ?></h2>
<p><?php printf(__('Check the <a href="%1$s" title="Read the Sandbox readme.html">documentation</a> for help installing new skins and information on the rich semantic markup that makes the Sandbox unique.', 'sandbox'), get_template_directory_uri() . '/readme.html'); ?></p>-->
</div>
<?php
}

// Sandbox skins menu: initializes the settings for the skins menu
function sandbox_init() {
	load_theme_textdomain('sandbox');

	if ( $GLOBALS['pagenow'] == 'themes.php'
			&& isset($_GET['page']) && $_GET['page'] == 'skins'
			&& isset($_GET['action']) && $_GET['action'] == 'activate'
			&& current_user_can('switch_themes') ) {
		check_admin_referer('switch-skin_' . $_GET['skin']);
		$info = sandbox_skin_info($_GET['skin']);
		sandbox_set_options(array(
			'skin' => wp_filter_kses($_GET['skin']),
			'globalnav' => bool_from_yn($info['global_navigation'])
			));
		wp_redirect('themes.php?page=skins&message=updated');
	}
}

// Sandbox skins menu: tells WordPress (nicely) to load the skins menu
function sandbox_admin_menu() {
	add_theme_page(__('Sandbox Skins', 'sandbox'), __('Sandbox Skins', 'sandbox'), 'switch_themes', 'skins', 'sandbox_admin_skins');
}

// Sandbox widgets: initializes Widgets for the Sandbox
function sandbox_widgets_init() {
	// Overrides the Widgets default and uses <h3>'s for sidebar headings
	$p = array(
		'before_title' => "<h3 class='widgettitle'>",
		'after_title' => "</h3>\n",
	);

	// How many? Two?! That's it?
	register_sidebars(2, $p);

	// Registers the widgets specific to the Sandbox, as set earlier
	unregister_widget('WP_Widget_Search');
	wp_register_sidebar_widget('search', __('Search', 'sandbox'), 'widget_sandbox_search');
	unregister_widget('WP_Widget_Meta');
	wp_register_sidebar_widget('meta', __('Meta', 'sandbox'), 'widget_sandbox_meta');
	unregister_widget('WP_Widget_Links');
	wp_register_sidebar_widget('links', __('Links', 'sandbox'), 'widget_sandbox_links');
	wp_register_sidebar_widget('home-link', __('Home Link', 'widgets'), 'widget_sandbox_homelink');
	wp_register_widget_control('home-link', __('Home Link', 'widgets'), 'widget_sandbox_homelink_control');
	wp_register_sidebar_widget('rss-links', __('RSS Links', 'widgets'), 'widget_sandbox_rsslinks');
	wp_register_widget_control('rss-links', __('RSS Links', 'widgets'), 'widget_sandbox_rsslinks_control');
}

// Runs our code at the end to check that everything needed has loaded
add_action('init', 'sandbox_init', 1);
add_action('widgets_init', 'sandbox_widgets_init');
add_action('admin_menu', 'sandbox_admin_menu');

// Adds filters for greater compliance
add_filter('archive_meta', 'wptexturize');
add_filter('archive_meta', 'convert_smilies');
add_filter('archive_meta', 'convert_chars');
add_filter('archive_meta', 'wpautop');

?>
