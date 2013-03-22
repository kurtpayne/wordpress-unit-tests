<?php 

$content_width = 800;

// override the posts_per_page setting so we only have one image on the front page
function nautilus_posts_per_page($null) {
	if ( is_home() )
		return 1;
	elseif ( is_archive() )
		return 25;
	return false;
}

add_filter('pre_option_posts_per_page', 'nautilus_posts_per_page');

// has the user set their own widgets for a sidebar? (we don't want the default sidebars)
function nautilus_has_sidebar($num) {
	$num = intval($num);
	$widgets = wp_get_sidebars_widgets();
	return isset($widgets["sidebar-{$num}"]);
}

// add some conditional body classes the stylesheet can use to vary widths based on which sidebars are in use
function nautilus_body_class($classes) {
	if ( nautilus_has_sidebar(1) ) $classes[] = 'sidebar-1';
	if ( nautilus_has_sidebar(2) ) $classes[] = 'sidebar-2';

	return $classes;
}

add_filter('body_class', 'nautilus_body_class');

// show post image thumbnails in archive views
function nautilus_get_the_excerpt($excerpt) {
	global $post;

	if ( is_archive() && !empty($post->thumb_url) ) {
		$link_text = '<img src="'.attribute_escape($post->thumb_url).'" class="img-post-thumbnail" />';
		return '<div class="post-thumbnail"><a href="'.attribute_escape(get_permalink($post->ID)).'" title="'.attribute_escape(get_the_title()).'">'.$link_text.'</a></div>';
	}

	return $excerpt;
}

add_filter('get_the_excerpt', 'nautilus_get_the_excerpt');

function nautilus_post_class($classes) {
	global $post;
	$_post_id = intval($post->ID);

	if ( is_archive() && $_post_id ) {
		if ( $post->thumb_url )
			$classes[] = 'has-thumbnail';
	}

	return $classes;
}

add_filter('post_class', 'nautilus_post_class');

// get the thumbnail of the first attachment of a post
function nautilus_get_post_thumbnail($post_id) {
	$thumb_url = wp_cache_get($post_id, 'post_thumbs');
	if ( false !== $thumb_url ) {
		return $thumb_url;
	}
	else {
		$thumb_url = '';
		$rows =& get_children("post_parent={$post_id}&post_type=attachment&numberposts=1");
		if ( $rows ) {
			$attachment = array_shift($rows);
			$thumb_url = wp_get_attachment_thumb_url($attachment->ID);
		}
		wp_cache_add($post_id, $thumb_url, 'post_thumbs');
		return $thumb_url;
	}
}

function nautilus_clean_post_cache($post_id) {
	wp_cache_delete($post_id, 'post_thumbs');
}

// on archive pages, reorder the posts array to group thumbnails and non-thumbnails 
function nautilus_the_posts($posts) {
	if ( is_archive() ) {
		$with_thumbs = array();
		$no_thumbs = array();
		foreach ($posts as $post) {
			$thumb_url = nautilus_get_post_thumbnail($post->ID);
			if ( $thumb_url ) {
				$post->thumb_url = $thumb_url;
				$with_thumbs[] = $post;
			}
			else {
				$no_thumbs[] = $post;
			}
		}
		$posts = array_merge($with_thumbs, $no_thumbs);
	}

	return $posts;
}

add_filter('the_posts', 'nautilus_the_posts');

?>
