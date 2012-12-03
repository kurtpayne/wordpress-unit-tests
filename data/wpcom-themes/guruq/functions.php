<?php
/*
This file is part of SANDBOX.

SANDBOX is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

SANDBOX is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with SANDBOX. If not, see http://www.gnu.org/licenses/.
*/

// Produces a list of pages in the header without whitespace

// For threaded comments

function sandbox_globalnav() {
	if ( $menu = str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages('title_li=&sort_column=menu_order&echo=0') ) )
		$menu = '<ul>' . $menu . '</ul>';
	$menu = '<div id="menu">' . $menu . "</div>\n";
	echo apply_filters( 'globalnav_menu', $menu ); // Filter to override default globalnav: globalnav_menu
}

// Generates semantic classes for BODY element
function sandbox_body_class( $print = true ) {
	global $wp_query, $current_user;

	// It's surely a WordPress blog, right?
	$c = array('wordpress');

	// Applies the time- and date-based classes (below) to BODY element
	sandbox_date_classes( time(), $c );

	// Generic semantic classes for what type of content is displayed
	is_front_page()  ? $c[] = 'home'       : null; // For the front page, if set
	is_home()        ? $c[] = 'blog'       : null; // For the blog posts page, if set
	is_archive()     ? $c[] = 'archive'    : null;
	is_date()        ? $c[] = 'date'       : null;
	is_search()      ? $c[] = 'search'     : null;
	is_paged()       ? $c[] = 'paged'      : null;
	is_attachment()  ? $c[] = 'attachment' : null;
	is_404()         ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	// Special classes for BODY element when a single post
	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();

		// Adds 'single' class and class with the post ID
		$c[] = 'single postid-' . $postID;

		// Adds classes for the month, day, and hour when the post was published
		if ( isset( $wp_query->post->post_date ) )
			sandbox_date_classes( mysql2date( 'U', $wp_query->post->post_date ), $c, 's-' );

		// Adds category classes for each category on single posts
		if ( $cats = get_the_category() )
			foreach ( $cats as $cat )
				$c[] = 's-category-' . $cat->slug;

		// Adds tag classes for each tags on single posts
		if ( $tags = get_the_tags() )
			foreach ( $tags as $tag )
				$c[] = 's-tag-' . $tag->slug;

		// Adds MIME-specific classes for attachments
		if ( is_attachment() ) {
			$mime_type = get_post_mime_type();
			$mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
				$c[] = 'attachmentid-' . $postID . ' attachment-' . str_replace( $mime_prefix, "", "$mime_type" );
		}

		// Adds author class for the post author
		$c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author_login()));
		rewind_posts();
	}

	// Author name classes for BODY on author archives
	elseif ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	// Category name classes for BODY on category archvies
	elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->slug;
	}

	// Tag name classes for BODY on tag archives
	elseif ( is_tag() ) {
		$tags = $wp_query->get_queried_object();
		$c[] = 'tag';
		$c[] = 'tag-' . $tags->slug;
	}

	// Page author for BODY on 'pages'
	elseif ( is_page() ) {
		$pageID = $wp_query->post->ID;
		$page_children = wp_list_pages("child_of=$pageID&echo=0");
		the_post();
		$c[] = 'page pageid-' . $pageID;
		$c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
		// Checks to see if the page has children and/or is a child page; props to Adam
		if ( $page_children )
			$c[] = 'page-parent';
		if ( $wp_query->post->post_parent )
			$c[] = 'page-child parent-pageid-' . $wp_query->post->post_parent;
		if ( is_page_template() ) // Hat tip to Ian, themeshaper.com
			$c[] = 'page-template page-template-' . str_replace( '.php', '-php', get_post_meta( $pageID, '_wp_page_template', true ) );
		rewind_posts();
	}

	// Search classes for results or no results
	elseif ( is_search() ) {
		the_post();
		if ( have_posts() ) {
			$c[] = 'search-results';
		} else {
			$c[] = 'search-no-results';
		}
		rewind_posts();
	}

	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$c[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get('paged') ) || ( $page = $wp_query->get('page') ) ) && $page > 1 ) {
		// Thanks to Prentiss Riddle, twitter.com/pzriddle, for the security fix below.
		$page = intval($page); // Ensures that an integer (not some dangerous script) is passed for the variable
		$c[] = 'paged-' . $page;
		if ( is_single() ) {
			$c[] = 'single-paged-' . $page;
		} elseif ( is_page() ) {
			$c[] = 'page-paged-' . $page;
		} elseif ( is_category() ) {
			$c[] = 'category-paged-' . $page;
		} elseif ( is_tag() ) {
			$c[] = 'tag-paged-' . $page;
		} elseif ( is_date() ) {
			$c[] = 'date-paged-' . $page;
		} elseif ( is_author() ) {
			$c[] = 'author-paged-' . $page;
		} elseif ( is_search() ) {
			$c[] = 'search-paged-' . $page;
		}
	}

	// Separates classes with a single space, collates classes for BODY
	$c = join( ' ', apply_filters( 'body_class',  $c ) ); // Available filter: body_class

	// And tada!
	return $print ? print($c) : $c;
}

// Generates semantic classes for each post DIV element
function sandbox_post_class( $print = true ) {
	global $post, $sandbox_post_alt;

	// hentry for hAtom compliace, gets 'alt' for every other post DIV, describes the post type and p[n]
	$c = array( 'hentry', "p$sandbox_post_alt", $post->post_type, $post->post_status );

	// Author for the post queried
	$c[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));

	// Category for the post queried
	foreach ( (array) get_the_category() as $cat )
		$c[] = 'category-' . $cat->slug;

	// Tags for the post queried; if not tagged, use .untagged
	if ( get_the_tags() == null ) {
		$c[] = 'untagged';
	} else {
		foreach ( (array) get_the_tags() as $tag )
			$c[] = 'tag-' . $tag->slug;
	}

	// For password-protected posts
	if ( $post->post_password )
		$c[] = 'protected';

	// Applies the time- and date-based classes (below) to post DIV
	sandbox_date_classes( mysql2date( 'U', $post->post_date ), $c );

	// If it's the other to the every, then add 'alt' class
	if ( ++$sandbox_post_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for post DIV
	$c = join( ' ', apply_filters( 'post_class', $c ) ); // Available filter: post_class

	// And tada!
	return $print ? print($c) : $c;
}

// Define the num val for 'alt' classes (in post DIV and comment LI)
$sandbox_post_alt = 1;

// Generates semantic classes for each comment LI element
function sandbox_comment_class( $print = true ) {
	global $comment, $post, $sandbox_comment_alt;

	// Collects the comment type (comment, trackback),
	$c = array( $comment->comment_type );

	// Counts trackbacks (t[n]) or comments (c[n])
	if ( $comment->comment_type == 'comment' ) {
		$c[] = "c$sandbox_comment_alt";
	} else {
		$c[] = "t$sandbox_comment_alt";
	}

	// If the comment author has an id (registered), then print the log in name
	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);
		// For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
		$c[] = 'byuser comment-author-' . sanitize_title_with_dashes(strtolower( $user->user_login ));
		// For comment authors who are the author of the post
		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	// If it's the other to the every, then add 'alt' class; collects time- and date-based classes
	sandbox_date_classes( mysql2date( 'U', $comment->comment_date ), $c, 'c-' );
	if ( ++$sandbox_comment_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for comment LI
	$c = join( ' ', apply_filters( 'comment_class', $c ) ); // Available filter: comment_class

	// Tada again!
	return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function sandbox_date_classes( $t, &$c, $p = '' ) {
	$t = $t + ( get_option('gmt_offset') * 3600 );
	$c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
	$c[] = $p . 'm' . gmdate( 'm', $t ); // Month
	$c[] = $p . 'd' . gmdate( 'd', $t ); // Day
	$c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
}

// For category lists on category archives: Returns other categories except the current one (redundant)
function sandbox_cats_meow($glue) {
	$current_cat = single_cat_title( '', false );
	$separator = "\n";
	$cats = explode( $separator, get_the_category_list($separator) );
	foreach ( $cats as $i => $str ) {
		if ( strstr( $str, ">$current_cat<" ) ) {
			unset($cats[$i]);
			break;
		}
	}
	if ( empty($cats) )
		return false;

	return trim(join( $glue, $cats ));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function sandbox_tag_ur_it($glue) {
	$current_tag = single_tag_title( '', '',  false );
	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	foreach ( $tags as $i => $str ) {
		if ( strstr( $str, ">$current_tag<" ) ) {
			unset($tags[$i]);
			break;
		}
	}
	if ( empty($tags) )
		return false;

	return trim(join( $glue, $tags ));
}

// Produces an avatar image with the hCard-compliant photo class
function sandbox_commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar_size = apply_filters( 'avatar_size', '32' ); // Available filter: avatar_size
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, $avatar_size ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}

// Function to filter the default gallery shortcode
function sandbox_gallery($string, $attr) {
	global $post;
	if ( isset($attr['orderby']) ) {
		$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
		if ( !$attr['orderby'] )
			unset($attr['orderby']);
	}

	extract(shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
	), $attr ));

	$id           =  intval($id);
	$orderby      =  addslashes($orderby);
	$attachments  =  get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}&order={$order}");

	if ( empty($attachments) )
		return null;

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link( $id, $size, true ) . "\n";
		return $output;
	}

	$listtag     =  tag_escape($listtag);
	$itemtag     =  tag_escape($itemtag);
	$captiontag  =  tag_escape($captiontag);
	$columns     =  intval($columns);
	$itemwidth   =  $columns > 0 ? floor(100/$columns) : 100;

	$output = apply_filters( 'gallery_style', "\n" . '<div class="gallery">', 9 ); // Available filter: gallery_style

	foreach ( $attachments as $id => $attachment ) {
		$img_lnk = get_attachment_link($id);
		$img_src = wp_get_attachment_image_src( $id, $size );
		$img_src = $img_src[0];
		$img_alt = $attachment->post_excerpt;
		if ( $img_alt == null )
			$img_alt = $attachment->post_title;
		$img_rel = apply_filters( 'gallery_img_rel', 'attachment' ); // Available filter: gallery_img_rel
		$img_class = apply_filters( 'gallery_img_class', 'gallery-image' ); // Available filter: gallery_img_class

		$output  .=  "\n\t" . '<' . $itemtag . ' class="gallery-item gallery-columns-' . $columns .'">';
		$output  .=  "\n\t\t" . '<' . $icontag . ' class="gallery-icon"><a href="' . $img_lnk . '" title="' . $img_alt . '" rel="' . $img_rel . '"><img src="' . $img_src . '" alt="' . $img_alt . '" class="' . $img_class . ' attachment-' . $size . '" /></a></' . $icontag . '>';

		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "\n\t\t" . '<' . $captiontag . ' class="gallery-caption">' . $attachment->post_excerpt . '</' . $captiontag . '>';
		}

		$output .= "\n\t" . '</' . $itemtag . '>';
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= "\n</div>\n" . '<div class="gallery">';
	}
	$output .= "\n</div>\n";

	return $output;
}

// Widget: Search; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_search($args) {
	extract($args);
	$options = get_option('widget_sandbox_search');
	$title = empty($options['title']) ? __( 'Search', 'sandbox' ) : attribute_escape($options['title']);
	$button = empty($options['button']) ? __( 'Find', 'sandbox' ) : attribute_escape($options['button']);
?>
			<?php echo $before_widget ?>
				<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
				<form id="searchform" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<div>
						<input id="s" name="s" type="text" class="text" value="<?php the_search_query() ?>" size="10" tabindex="1" />
						<input type="submit" class="button" value="<?php echo $button ?>" tabindex="2" />
					</div>
				</form>
			<?php echo $after_widget ?>
<?php
}

// Widget: Search; element controls for customizing text within Widget plugin
function widget_sandbox_search_control() {
	$options = $newoptions = get_option('widget_sandbox_search');
	if ( $_POST['search-submit'] ) {
		$newoptions['title'] = strip_tags(stripslashes( $_POST['search-title']));
		$newoptions['button'] = strip_tags(stripslashes( $_POST['search-button']));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_sandbox_search', $options );
	}
	$title = attribute_escape($options['title']);
	$button = attribute_escape($options['button']);
?>
	<p><label for="search-title"><?php _e( 'Title:', 'sandbox' ) ?> <input class="widefat" id="search-title" name="search-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p><label for="search-button"><?php _e( 'Button Text:', 'sandbox' ) ?> <input class="widefat" id="search-button" name="search-button" type="text" value="<?php echo $button; ?>" /></label></p>
	<input type="hidden" id="search-submit" name="search-submit" value="1" />
<?php
}

// Widget: Meta; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_meta($args) {
	extract($args);
	$options = get_option('widget_meta');
	$title = empty($options['title']) ? __( 'Meta', 'sandbox' ) : attribute_escape($options['title']);
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
	$title = empty($options['title']) ? __( 'RSS Links', 'sandbox' ) : attribute_escape($options['title']);
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?> <?php _e( 'Posts RSS feed', 'sandbox' ); ?>" rel="alternate" type="application/rss+xml"><?php _e( 'All posts', 'sandbox' ) ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> <?php _e( 'Comments RSS feed', 'sandbox' ); ?>" rel="alternate" type="application/rss+xml"><?php _e( 'All comments', 'sandbox' ) ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; element controls for customizing text within Widget plugin
function widget_sandbox_rsslinks_control() {
	$options = $newoptions = get_option('widget_sandbox_rsslinks');
	if ( $_POST['rsslinks-submit'] ) {
		$newoptions['title'] = strip_tags( stripslashes( $_POST['rsslinks-title'] ) );
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_sandbox_rsslinks', $options );
	}
	$title = attribute_escape($options['title']);
?>
	<p><label for="rsslinks-title"><?php _e( 'Title:', 'sandbox' ) ?> <input class="widefat" id="rsslinks-title" name="rsslinks-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<input type="hidden" id="rsslinks-submit" name="rsslinks-submit" value="1" />
<?php
}

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function sandbox_widgets_init() {
	if ( !function_exists('register_sidebars') )
		return;

	// Formats the Sandbox widgets, adding readability-improving whitespace
	$p = array(
		'before_widget'  =>   "\n\t\t\t" . '<li id="%1$s" class="widget %2$s">',
		'after_widget'   =>   "\n\t\t\t</li>\n",
		'before_title'   =>   "\n\t\t\t\t". '<h3 class="widgettitle">',
		'after_title'    =>   "</h3>\n"
	);

	// Table for how many? Two? This way, please.
	register_sidebars( 2, $p );

	// Finished intializing Widgets plugin, now let's load the Sandbox default widgets; first, Sandbox search widget
	$widget_ops = array(
		'classname'    =>  'widget_search',
		'description'  =>  __( "A search form for your blog (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'search', __( 'Search', 'sandbox' ), 'widget_sandbox_search', $widget_ops );
	unregister_widget_control('search'); // We're being Sandbox-specific; remove WP default
	wp_register_widget_control( 'search', __( 'Search', 'sandbox' ), 'widget_sandbox_search_control' );

	// Sandbox Meta widget
	$widget_ops = array(
		'classname'    =>  'widget_sandbox_meta',
		'description'  =>  __( "Log in/out and administration links (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'sandbox_meta', __( 'Sandbox Meta', 'sandbox' ), 'widget_sandbox_meta', $widget_ops );

	//Sandbox RSS Links widget
	$widget_ops = array(
		'classname'    =>  'widget_rss_links',
		'description'  =>  __( "RSS links for both posts and comments (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'rss_links', __( 'RSS Links', 'sandbox' ), 'widget_sandbox_rsslinks', $widget_ops );
	wp_register_widget_control( 'rss_links', __( 'RSS Links', 'sandbox' ), 'widget_sandbox_rsslinks_control' );
}

// Translate, if applicable
load_theme_textdomain('sandbox');

// Runs our code at the end to check that everything needed has loaded
add_action( 'init', 'sandbox_widgets_init' );

// Registers our function to filter default gallery shortcode
add_filter( 'post_gallery', 'sandbox_gallery', 10, 2 );

// Adds filters for the description/meta content in archives.php
add_filter( 'archive_meta', 'wptexturize' );
add_filter( 'archive_meta', 'convert_smilies' );
add_filter( 'archive_meta', 'convert_chars' );
add_filter( 'archive_meta', 'wpautop' );

// Remember: the Sandbox is for play.

define( 'GURUQ_CAT', 'GuruQ Questions' );
define( 'GURUQ_SLUG', 'guruq-questions' );

/**
 * Handles inserting questions from the postbox, automatically categorizes them as guruq
 */
function guruq_new_post() {
	if( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['action'] ) || $_POST['action'] != 'post' )
	    return;

	if ( !is_user_logged_in() )
		auth_redirect();

	if( !current_user_can( 'publish_posts' ) ) {
		wp_redirect( get_bloginfo( 'url' ) . '/' );
		exit;
	}

	check_admin_referer( 'new-post' );

	$user_id = $current_user->user_id;
	$post_content = $_POST['posttext'];

	$post_title = guruq_title_from_content( $post_content );

	// Include the taxonomy api so we can check if category exists	
	require_once( ABSPATH . '/wp-admin/includes/taxonomy.php' );
	$guruq_cat_id = (int) category_exists( GURUQ_CAT );
	// cat_id = 0 means it doesn't exist, so we will create it
	if ( 0 == $guruq_cat_id )
		$guruq_cat_id = (int) wp_create_category( GURUQ_CAT );
	
	$post_id = wp_insert_post( array(
		'post_author' => $user_id,
		'post_title' => $post_title,
		'post_content' => $post_content,
		'post_status' => 'draft',
		'post_type' => 'post',
		'post_category' => array( $guruq_cat_id )

	) );

	wp_redirect( get_bloginfo( 'url' ) . '/' );
	
	exit;
}

function guruq_title_from_content( $content ) {
	
    static $strlen =  null;
    if ( !$strlen ) {
        $strlen = function_exists('mb_strlen')? 'mb_strlen' : 'strlen';
    }
    $max_len = 40;
    $title = $strlen( $content ) > $max_len? wp_html_excerpt( $content, $max_len ) . '...' : $content;
    $title = trim( strip_tags( $title ) );
    $title = str_replace("\n", " ", $title);

	//Try to detect image or video only posts, and set post title accordingly
	if ( !$title ) {
		if ( preg_match("/<object|<embed/", $content ) )
			$title = __('Video Post', 'p2');
		elseif ( preg_match( "/<img/", $content ) )
			$title = __('Image Post', 'p2');
	}
    return $title;
}

add_action('admin_menu', 'guruq_questions_menu');

/**
 * Adds a sub-menu item in Posts menu
 */
function guruq_questions_menu() {
	add_posts_page( GURUQ_CAT, GURUQ_CAT, 'administrator', GURUQ_SLUG, 'guruq_edit_page' );
}

/**
 * Generate the data grid of posts categorized as guruq
 */
function guruq_edit_page() {
	include( 'guruq-list.php' );
}

/**
 * Remove Quick Edit link from post row
 */
function guruq_remove_post_row_actions( $actions ) {
	if ( isset( $actions['inline hide-if-no-js'] ) )
		unset( $actions['inline hide-if-no-js'] );
	return $actions;
}
add_action( 'post_row_actions', 'guruq_remove_post_row_actions' );

/**
 * External API handler
 */
function guruq_api_call() {
	if ( !isset( $_GET['guruq-api'] ) )
		return;

	// inits json decoder/encoder object if not already available
	if ( !class_exists( 'Services_JSON' ) ) {
		include_once( dirname( __FILE__ ) . '/class.json.php' );
	}

	$limit = 20;
	if ( isset( $_GET['limit'] ) )
		$limit = (int) $_GET['limit'];
	$offset = 0;
	if ( isset( $_GET['offset'] ) )
		$offset = (int) $_GET['offset'];
	$format = 'json';
	if ( isset( $_GET['format'] ) && ( 'json' == $_GET['format'] || 'xml' == $_GET['format'] ) )
		$format = $_GET['format'];

	$posts = get_posts( "numberposts=$limit&offset=$offset&category_name=" . GURUQ_CAT );

	if ( empty( $posts ) )
		return;

	foreach ( $posts as $id => $post ) {
		$posts[$id] = guruq_filter_post( $post );
	}

	if ( 'json' == $format ) {
		//header('Content-type: application/json');
		echo json_encode( $posts );
		exit();
	}

	$xml = '';
	if ( 'xml' == $format ) {
		header('Content-type: text/plain');
		$bloginfo_charset = get_bloginfo( 'charset' );
		$xml .= '<?xml version="1.0" encoding="' . $bloginfo_charset . '"?>' . "\n";
		$xml .= "<items>\n";
		$xml .= guruq_obj2xml( $posts );
		$xml .= "</items>\n";
		echo $xml;
		exit();
	}
}
guruq_api_call();

/**
 * Return post object with specified member variables
 * 
 * @param object $post
 * @return object
 */
function guruq_filter_post( $post ) {
	$_post = new stdClass();
	$members = array( 'ID', 'post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_name', 
	'post_modified', 'post_modified_gmt', 'post_parent', 'guid' );

	foreach ( $members as $member ) {
		if ( isset( $post->$member ) )
			$_post->$member = $post->$member;
		}
	
	return $_post;
}

/**
 * Take input string and wrap it with CDATA
 * 
 * @param string $str
 * @return string
 */
function guruq_wxr_cdata( $str ) {
	if ( seems_utf8( $str ) == false )
		$str = utf8_encode( $str );

	$str = "<![CDATA[$str" . ( ( substr( $str, - 1 ) == ']' ) ? ' ' : '' ) . "]]>";

	return $str;
}

/**
 * Loop over input array and output XML versions of the post objects
 * 
 * @param array $posts
 * @return string
 */
function guruq_obj2xml( $posts ) {
	$out = '';
	foreach ( $posts as $post ) {
		$post_title = apply_filters( 'the_title_rss', $post->post_title );
		$post_permalink_rss = apply_filters( 'the_permalink_rss', get_permalink( $post->ID ) );
		$post_pub_date = mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true, $post ), false );
		$dc_creator = guruq_wxr_cdata( get_the_author() );
		$post_guid = get_the_guid( $post->ID );
		$post_content = guruq_wxr_cdata( apply_filters( 'the_content_export', $post->post_content ) );

		$out .= <<<EOD

<item>
<title>$post_title</title>
<link>$post_permalink_rss</link>
<pubDate>$post_pub_date</pubDate>
<guid isPermaLink="false">$post_guid</guid>
<content:encoded>$post_content</content:encoded>
<post_id>$post->ID</post_id>
<post_date>$post->post_date</post_date>
<post_date_gmt>$post->post_date_gmt</post_date_gmt>
<post_name>$post->post_name</post_name>
<post_parent>$post->post_parent</post_parent>
</item>

EOD;
	}

	return $out;
}

/**
 * Add a row to Right Now metabox
 */
function guruq_right_now() {
	$cat = get_category_by_slug( GURUQ_SLUG );
	$total = (int) $cat->category_count;
	$link = '<a href="edit.php?page=' . GURUQ_SLUG . '">%s</a>';
	$out = '';
	$out .= '<tr>';
	$out .= '<td class="first b">' . sprintf( $link, $total ) . '</td>';
	$out .= '<td class="t">' . sprintf( $link, __( GURUQ_CAT ) ) . '</td>';
	$out .= '<td class="b"></td>';
	$out .= '<td class="last t"></td>';
	$out .= '</tr>';
	echo $out;
}
add_action( 'right_now_table_end', 'guruq_right_now' );

/**
 * Filter out GuruQ Q's from edit screen
 */
function guruq_remove_from_edit( $notused = null ) {
	global $wp_query;
	$guruq_cat_id = (int) category_exists( GURUQ_CAT );
	if ( 0 < $guruq_cat_id )
		$wp_query->query_vars['cat'] = '-' . $guruq_cat_id;
}
// Add filter action only on edit page
if ( strstr( $_SERVER['REQUEST_URI'], 'edit.php' ) && !isset( $_GET['page'] ) && GURUQ_SLUG !== $_GET['page'] ) {
		add_action( 'pre_get_posts', 'guruq_remove_from_edit' );
}

/**
 * Remove post_status when not specified in $_GET
 */
function guruq_remove_post_status( $query ) {
	if ( isset( $query->query_vars['post_status'] ) )
		unset( $query->query_vars['post_status'] );
	return $query;
}

/**
 * Count number of posts of a post type and is user has permissions to view.
 * This function is similar to wp_count_posts, but takes an extra param for category
 *
 * @param string $type Optional. Post type to retrieve count
 * @param string $perm Optional. 'readable' or empty.
 * @param string $category Optional. Category name
 * @return object Number of posts for each status
 */
function guruq_count_posts( $type = 'post', $perm = '', $category = '' ) {
	global $wpdb;

	$user = wp_get_current_user();

	$cache_key = "$type-$category";

	$cat_join = '';
	$cat_where = '';
	if ( !empty( $category ) ) {
		$cat_id = (int) category_exists( $category );
		$cat_join = " INNER JOIN $wpdb->term_relationships ON ( $wpdb->posts.ID = $wpdb->term_relationships.object_id )
INNER JOIN $wpdb->term_taxonomy ON ( $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id ) ";
		$cat_where = "1=1 AND $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.term_id IN ('$cat_id') AND ";
	}

	$query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} $cat_join WHERE $cat_where post_type = %s";
	if ( 'readable' == $perm && is_user_logged_in() ) {
		if ( !current_user_can( "read_private_{$type}s" ) ) {
			$cache_key .= '_' . $perm . '_' . $user->ID;
			$query .= " AND (post_status != 'private' OR ( post_author = '$user->ID' AND post_status = 'private' ))";
		}
	}
	$query .= ' GROUP BY post_status';

	$count = wp_cache_get( $cache_key, 'counts' );
	if ( false !== $count )
		return $count;

	$sql = $wpdb->prepare( $query, $type );
	$count = $wpdb->get_results( $sql, ARRAY_A );

	$stats = array( 'publish' => 0, 'private' => 0, 'draft' => 0, 'pending' => 0, 'future' => 0, 'trash' => 0 );
	foreach( (array) $count as $row_num => $row ) {
		$stats[$row['post_status']] = $row['num_posts'];
	}

	$stats = (object) $stats;
	wp_cache_set( $cache_key, $stats, 'counts' );

	return $stats;
}




