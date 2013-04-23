<?php 
/* Current version of Redoable */
$current = '1.2';

load_theme_textdomain('redo_domain');

define('HEADER_TEXTCOLOR', 'ffffff');
define('HEADER_IMAGE_WIDTH', 730);
define('HEADER_IMAGE_HEIGHT', 180);
define('HEADER_IMAGE', '');

function redo_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	background-color: #900;
}
#headimg h1 {
	font-family:"Century Gothic","Lucida Grande",Verdana,Arial !important;
	font-size: 38px;
	font-weight: normal;
	padding-left: 18px;
	padding-top: 120px;
	margin: 0;
}
#headimg h1 a {
	color:#<?php header_textcolor() ?>;
	border: none;
	text-decoration: none;
}

#headimg #desc {
	display: none;
	background-image:
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headerimg h1, #headerimg #desc {
	display: none;
}
#headimg h1 a, #headimg #desc {
	color:#<?php echo HEADER_TEXTCOLOR ?>;
}
<?php } ?>
</style>
<?php
}

function redo_header_style() {
?>
<style type="text/css">
#header_content {
	background:#900 url(<?php header_image() ?>) center repeat-y;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header_content #title {
	display: none;
}
<?php } else { ?>
#header_content h1 a, #header_content h1 a:hover {
	color: #<?php header_textcolor() ?>;
}	
<?php } ?>
</style>
<?php
}

add_custom_image_header('redo_header_style', 'redo_admin_header_style');

$themecolors = array(
	'bg' => '333333',
	'border' => '111111',
	'text' => 'eeeeee',
	'link' => 'cccccc'
);
$content_width = 655; // pixels

#require(TEMPLATEPATH . '/options/app/info.php');

function get_redo_ping_type($trackbacktxt = 'Trackback', $pingbacktxt = 'Pingback') {
	$type = get_comment_type();
	switch( $type ) {
		case 'trackback' :
			return $trackbacktxt;
			break;
		case 'pingback' :
			return $pingbacktxt;
			break;
	}
	return false;
}

/* By Mark Jaquith, http://txfx.net */
function redo_nice_category($normal_separator = ', ', $penultimate_separator = ' and ') { 
	$categories = get_the_category(); 

	if (empty($categories)) { 
		_e('Uncategorized','redo_domain'); 
		return; 
	} 

	$thelist = ''; 
	$i = 1; 
	$n = count($categories); 

	foreach ($categories as $category) { 
		if (1 < $i and $i != $n) {
			$thelist .= $normal_separator;
		}

		if (1 < $i and $i == $n) {
			$thelist .= $penultimate_separator;
		}

		$thelist .= '<a href="' . get_category_link($category->cat_ID) . '" title="' . sprintf(__("View all posts in %s"), $category->cat_name) . '">'.$category->cat_name.'</a>'; 
		++$i; 
	} 
	return apply_filters('the_category', $thelist, $normal_separator);
}

function redo_body_id() {
	if (get_option('permalink_structure') != '' and is_page()) {
		echo "id='" . get_query_var('name') . "'";
	}
}

// Semantic class functions from Sandbox 0.6.1 (http://www.plaintxt.org/themes/sandbox/)

// Template tag: echoes semantic classes in the <body>
function redo_body_class() {
	global $wp_query, $current_user;

	$c = array('wordpress', 'k2');

	redo_date_classes(time(), $c);

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
		if ( isset($wp_query->post->post_date) ) {
			redo_date_classes(mysql2date('U', $wp_query->post->post_date), $c, 's-');
		}
		foreach ( (array) get_the_category() as $cat ) {
			$c[] = 's-category-' . $cat->category_nicename;
		}
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

	echo join(' ', apply_filters('body_class',  $c));
}

// Template tag: echoes semantic classes in each post <div>
function redo_post_class( $post_count = 1, $post_asides = false ) {
	global $post;

	$c = array("p$post_count", $post->post_status);

	$c[] = 'author-' . get_the_author_login();

	redo_date_classes(mysql2date('U', $post->post_date), $c);

	if ( $post_asides ) {
		$c[] = 'redo-asides';
	}

	if ( $post_count & 1 == 1 ) {
		$c[] = 'alt';
	}

	echo join(' ', get_post_class( $c, $post->ID ));
}

// Template tag: echoes semantic classes for a comment <li>
function redo_comment_class( $comment_count = 1, $echo = true) {
	global $comment, $post;

	$c = array($comment->comment_type, "c$comment_count");

	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);

		$c[] = "byuser commentauthor-$user->user_login";

		if ( $comment->user_id === $post->post_author ) {
			$c[] = 'bypostauthor';
		}
	}

	redo_date_classes(mysql2date('U', $comment->comment_date), $c, 'c-');

	if ( $comment_count & 1 == 1 ) {
		$c[] = 'alt';
	}
		
	if ( is_trackback() ) {
		$c[] = 'trackback';
	}

	$return = join(' ', apply_filters('comment_class', $c));
	if ($echo) echo $return;
	else return $return;
}

// Adds four time- and date-based classes to an array
// with all times relative to GMT (sometimes called UTC)
function redo_date_classes($t, &$c, $p = '') {
	$t = $t + (get_option('gmt_offset') * 3600);
	$c[] = $p . 'y' . gmdate('Y', $t); // Year
	$c[] = $p . 'm' . gmdate('m', $t); // Month
	$c[] = $p . 'd' . gmdate('d', $t); // Day
	$c[] = $p . 'h' . gmdate('h', $t); // Hour
}

// Register the sidebar - This allows for multiple sidebars to be used.
if(function_exists('register_sidebars')) {
	register_sidebars(1, array('before_widget' => '<div id="%1$s" class="module %2$s">','after_widget' => '</div>'));
}

// this ends the admin page ?>
