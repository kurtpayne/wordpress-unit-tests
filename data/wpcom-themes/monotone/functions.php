<?php

// define widths
$content_width = 315;
define('MIN_WIDTH', 560);
define('MAX_WIDTH', 840);

function partial($file) { include $file.'.php'; }

// filters and actions
add_action('wp_head', 'header_function');
add_filter('the_content', 'image_scrape', 0);
add_action('publish_post', 'image_setup');
add_action('publish_page', 'image_setup');

function header_function() {
	global $vertical;
	if(!is_single() && is_home() && !is_archive()) query_posts("what_to_show=posts&posts_per_page=1");
	if(!is_archive() && !is_search()) : ?>
		<style type="text/css" media="screen">
		<?php
		while ( have_posts() ) : the_post();
			// ececute the specific stylesheet
			print_stylesheet();
			// determine if an image is vertical or not
			if(is_vertical(the_image_url(true))) { $vertical = true; }
 		endwhile; rewind_posts(); ?>
		</style>
	<?php endif;
}

// used by the preg_replace_callback() in image_scrape().
// most empty tags should be replaced but not all.  For example, stripping an empty <embed></embed> breaks YouTube videos.
function replace_empty_tag($m) {
	$no_replace = array('embed'); // expand as required
	if ( in_array( strtolower($m[1]), $no_replace ) )
		return $m[0]; // return the original untouched
	return '';
}

// remove image tag from post_content for display
function image_scrape($entry) {
	// don't scrape the image for the feed
	if (is_feed()) { return $entry; }
	
	$entry = str_replace('[/wp_caption]','', $entry);
	$entry = str_replace('[/caption]','', $entry);
	
	//remove image tag
	$entry = preg_replace('/<img [^>]*src=(\"|\').+?(\1)[^>]*\/*>/','', $entry);
	
	//remove any empty tags left by the scrape.
	$entry = str_replace('<p> </p>', '', $entry);
	$entry = preg_replace_callback( '|<([a-z]+)[^>]*>\s*</\1>|i', 'replace_empty_tag', $entry );
	$entry = preg_replace_callback( '|<([a-z]+)[^>]*>\s*</\1>|i', 'replace_empty_tag', $entry );
	$entry = preg_replace_callback( '|<([a-z]+)[^>]*>\s*</\1>|i', 'replace_empty_tag', $entry );
	return $entry;
}

// this resets post meta
function reset_colors($post) {
	global $post;
	delete_post_meta($post->ID, 'image_md5');
	delete_post_meta($post->ID, 'image_url');
	delete_post_meta($post->ID, 'image_size');
	delete_post_meta($post->ID, 'image_tag');
	
	delete_post_meta($post->ID, 'image_color_base');
	delete_post_meta($post->ID, 'image_colors');
	delete_post_meta($post->ID, 'image_colors_bg');
	delete_post_meta($post->ID, 'image_colors_fg');
}

function image_setup($postid) {
	global $post;
	$post = get_post($postid);
	
	// get url
	if ( !preg_match('/<img ([^>]*)src=(\"|\')(.+?)(\2)([^>\/]*)\/*>/', $post->post_content, $matches) ) {
		reset_colors($post);
		return false;
	}

	// url setup
	$post->image_url = $matches[3];

	if ( !$post->image_url = preg_replace('/\?w\=[0-9]+/','', $post->image_url) )
		return false;
	
	$post->image_url = clean_url( $post->image_url, 'raw' );
	$previous_md5 = get_post_meta($post->ID, 'image_md5', true);
	$previous_url = get_post_meta($post->ID, 'image_url', true);
	
	if ( ( md5($post->image_tag) != $previous_md5 ) or ( $post->image_url != $previous_url ) ) {
		reset_colors($post);

		add_post_meta($post->ID, 'image_url', $post->image_url);
		add_post_meta($post->ID, 'image_md5', md5($post->image_tag));
		
		//image tag setup
		$extra = $matches[1].' '.$matches[5];
		$extra = preg_replace('/width=(\"|\')[0-9]+(\1)/','', $extra);
		$extra = preg_replace('/height=(\"|\')[0-9]+(\1)/','', $extra);
		$width = (is_vertical($post->image_url)) ? MIN_WIDTH : MAX_WIDTH;
		

		delete_post_meta($post->ID, 'image_tag');
		add_post_meta($post->ID, 'image_tag', '<img src="'.$post->image_url.'?w='.$width.'" '.$extra.' />');
		
		// get colors
		get_all_colors($post);
		return false;
	}

	return true;
}

function is_vertical($url) {
	if(preg_match('/(jpg|jpeg|jpe|JPEG|JPG|png|PNG|gif|GIF)/',$url)) {
	global $post;
	$size = get_post_meta($post->ID, 'image_size', true);
	if ( !$size ) {
		$size = getimagesize($url);
		add_post_meta($post->ID, 'image_size', $size);
	}
	$post->image_width = $size[0];
	if($size) {
		if($size[0] == $size[1]) return true;
		if($size[0] < $size[1]) return true;
		if($size[0] < MIN_WIDTH) return true;
	}
	return false;
	}
	return false;
}

function the_image($return = null) {
	global $post;
	if( get_post_status($post->ID) == 'private' ) {
		if( !is_page() && !current_user_can('read_private_posts') ) {
			return false;
		} elseif( is_page() && !current_user_can('read_private_pages') ) {
			return false;
		}
	}

	if( post_password_required() )
		return false;
		
	$tag = get_post_meta($post->ID, 'image_tag', true);
	if(!$tag) {
		image_setup($post->ID);
		$tag = get_post_meta($post->ID, 'image_tag', true);
	}
	$tag = preg_replace('/width=(\"|\')[0-9]+(\1)/','', $tag);
	$tag = preg_replace('/height=(\"|\')[0-9]+(\1)/','', $tag);
	if($return) return $tag; /*else*/ echo $tag;

}

function the_image_url($return = null) {
	global $post;
	$tag = get_post_meta($post->ID, 'image_url', true);
	if(!$tag) {
		image_setup($post->ID);
		$tag = get_post_meta($post->ID, 'image_url', true);
	}
	if($return) return $tag; /*else*/ echo $tag;
}

function the_thumbnail() {
	global $post;
	$src = preg_replace('/\?w\=[0-9]+/','?w=125', the_image(true));
	$src = '<div class="image thumbnail">'.$src.'</div>';
	echo $src;
}

function get_all_colors($post) {
	//pull from DB
	$base->bg = get_post_meta($post->ID, 'image_colors_bg',true);
	$base->fg = get_post_meta($post->ID, 'image_colors_fg',true);
	
	// show return variable if full
	if($base->bg != '' && $base->fg != '') {
		return $base;
	} else {
	// else, get the colors
		include_once("csscolor.php");
		$base = new CSS_Color(base_color($post));
		//set bg
		$bg = $base->bg;
		//set fg
		$fg = $base->fg;
		if( add_post_meta($post->ID, 'image_colors_bg', $bg, false)
		&&  add_post_meta($post->ID, 'image_colors_fg', $fg, false)) return $base;
	}
}

function print_stylesheet() {
	global $post;
	reset_colors($post);
	$color = get_all_colors($post);

	// hack for array keys like -1 being stored in post_meta as 4294967295
	foreach ( $color->bg as $key => $value) {
		if ( is_int($key) && $key > 0 ) $key = -(4294967296 - $key);
		$new_color->bg[$key] = $value;
	}
	
	foreach ( $color->fg as $key => $value) {
		if ( is_int($key) && $key > 0 ) $key = -(4294967296 - $key);
		$new_color->fg[$key] = $value;
	}
	$color = $new_color;
	// end hack

	?>
	#page {
	  	background-color:#<?php echo $color->bg['-1']; ?>;
		color:#<?php echo $color->fg['-2']; ?>;
	}
	
	a,a:link, a:visited {
		color: #<?php echo $color->fg['-3']; ?>;
	}

  	a:hover, a:active {
		color: #<?php echo $color->bg['+2']; ?>;
	}
	
		h1, h1 a, h1 a:link, h1 a:visited, h1 a:active {
		color: #<?php echo $color->fg['0']; ?>;
		}
		h1 a:hover {
			color:#<?php echo $color->bg['+2']; ?>;
		}
		.navigation a, .navigation a:link, 
		.navigation a:visited, .navigation a:active {
		 
		  	color: #<?php echo $color->fg['0']; ?>;
		}
		h1:hover, h2:hover, h3:hover, h4:hover, h5:hover h6:hover,
		.navigation a:hover {
			color:#<?php echo $color->fg['-2']; ?>;
		}
		
	.description,
	h3#respond,
	#comments,
	h2, h2 a, h2 a:link, h2 a:visited, h2 a:active,
	h3, h3 a, h3 a:link, h3 a:visited, h3 a:active,
	h4, h4 a, h4 a:link, h4 a:visited, h4 a:active,
	h5, h5 a, h5 a:link, h5 a:visited, h5 a:active,
	h6, h6 a, h6 a:link, h6 a:visited, h6 a:active {
	  	/* Use the corresponding foreground color */
	  	color: #<?php echo $color->fg['-1']; ?>;
		border-color: #<?php echo $color->bg['+3']; ?>;
	}

	#postmetadata, #commentform p, .commentlist li, #post, #postmetadata .sleeve, #post .sleeve, #content, h3#respond, h3#comments {
		color: #<?php echo $color->fg['-2']; ?>;
		border-color: #<?php echo $color->fg['-2']; ?>;
	} <?php
}

function base_color($post) {
	
	$url = get_post_meta($post->ID, 'image_url', true);
	if(!$url) {
		image_setup($post->ID);
		$url = get_post_meta($post->ID, 'image_url', true);
	}
	
	// get the image name
	$imgname = trim($url);

	if ( !$imgname )
		return 'FFFFFF';
	
	// create a working image 
	$im = imagecreatefromjpeg($imgname);
	
	$height = imagesy($im);
	$top = $height - 400;
	$width = imagesx($im);
	
	// sample five points in the image, based on rule of thirds and center
	$rgb = array();
	
	$topy = round($height / 3);
	$bottomy = round(($height / 3) * 2);
	$leftx = round($width / 3);
	$rightx = round(($width / 3) * 2);
	$centery = round($height / 2);
	$centerx = round($width / 2);
	
	$rgb[1] = imagecolorat($im, $leftx, $topy);
	$rgb[2] = imagecolorat($im, $rightx, $topy);
	$rgb[3] = imagecolorat($im,  $leftx, $bottomy);
	$rgb[4] = imagecolorat($im,  $rightx, $bottomy);
	$rgb[5] = imagecolorat($im, $centerx, $centery);
	
	// extract each value for r, g, b
	$r = array();
	$g = array();
	$b = array();
	$hex = array();
	
	$ct = 0; $val = 50;
	
	// process points
	for ($i = 1; $i <= 5; $i++) {
	   $r[$i] = ($rgb[$i] >> 16) & 0xFF;
	   $g[$i] = ($rgb[$i] >> 8) & 0xFF;
	   $b[$i] = $rgb[$i] & 0xFF;
	
	   // find darkest color
	   $tmp = $r[$i] + $g[$i] + $b[$i];
	
	   	if ($tmp < $val) {
	       $val = $tmp;
	       $ct = $i;
	   	}
		$hex[$i] = rgbhex($r[$i],$g[$i],$b[$i]);
	}
	return $hex[3];
}

function rgbhex($red, $green, $blue) { return sprintf('%02X%02X%02X', $red, $green, $blue); }

?>
