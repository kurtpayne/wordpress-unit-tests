<?php
/***
Duotone Library
**/

define(MIN_WIDTH, 560);
define(MAX_WIDTH, 840);

if($_GET['reset'] == true)
	reset_post_colors($post);

add_filter( 'the_content', 'duotone_content_setup' );
// remove image tag from post_content for display
function duotone_content_setup($entry) {
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

// used by the preg_replace_callback() in duotone_content_setup().
// most empty tags should be replaced but not all.  For example, stripping an empty <embed></embed> breaks YouTube videos.
function replace_empty_tag($m) {
	$no_replace = array('embed'); // expand as required
	if ( in_array( strtolower($m[1]), $no_replace ) )
		return $m[0]; // return the original untouched
	return '';
}


add_action( 'publish_post', 'image_information_init' );
add_action( 'publish_page', 'image_information_init' );
function image_information_init($postid) {
	global $post;
	$post = get_post($postid);
	
	// get url
	if ( !preg_match( '/<img ([^>]*)src=(\"|\')(.+?)(\2)([^>\/]*)\/*>/', $post->post_content, $matches ) ) {
		reset_post_colors($post);
		return false;
	}
	
	$post->image_url = $matches[3];

	if ( !$post->image_url = preg_replace( '/\?w\=[0-9]+/', '', $post->image_url ) )
		return false;
	
	$post->image_url = clean_url( $post->image_url, 'raw' );
	$previous_url = get_post_meta( $post->ID, 'image_url', true );

	if ( $post->image_url != $previous_url ) {
		
		//image tag setup
		$extra = $matches[1].' '.$matches[5];
		$extra = preg_replace('/width=(\"|\')[0-9]+(\1)/','', $extra);
		$extra = preg_replace('/height=(\"|\')[0-9]+(\1)/','', $extra);
		$width = (is_vertical($post->image_url)) ? MIN_WIDTH : MAX_WIDTH;
		
		// reset
		reset_post_colors($post);
		add_post_meta($post->ID, 'image_url', $post->image_url);
		add_post_meta($post->ID, 'image_tag', '<img src="'.$post->image_url.'?w='.$width.'" '.$extra.' />');
		
		// set colors
		$base = get_post_colors($post);
		if( add_post_meta($post->ID, 'image_colors_bg', $base->bg, false)
			&&  add_post_meta($post->ID, 'image_colors_fg', $base->fg, false) )
		return false;
	}

	return true;
}

// printed functions
function image_html($return = null) {
	global $post;
	$tag = get_post_meta( $post->ID, 'image_tag', true );
	if(!$tag) {
		image_information_init( $post->ID );
		$tag = get_post_meta( $post->ID, 'image_tag', true );
	}
	$tag = preg_replace('/width=(\"|\')[0-9]+(\1)/','', $tag);
	$tag = preg_replace('/height=(\"|\')[0-9]+(\1)/','', $tag);
	if($return) return $tag; /*else*/ echo $tag;
}

function image_url($return = null) {
	global $post;
	$tag = get_post_meta($post->ID, 'image_url', true);

	if(!$tag) {
		image_information_init($post->ID);
		$tag = get_post_meta($post->ID, 'image_url', true);
	}
	if($return) return $tag; /*else*/ echo $tag;
}

function the_thumbnail() {
	global $post;
	$src = preg_replace( '/\?w\=[0-9]+/','?w=125', image_html(true) );
	$src = '<div class="image thumbnail">'.$src.'</div>';
	echo $src;
}

// Color Functions
function get_post_colors($post) {
	global $post;
	//pull from DB
	$base->bg = get_post_meta($post->ID, 'image_colors_bg', true);
	$base->fg = get_post_meta($post->ID, 'image_colors_fg', true);
	// show return variable if full
	if(isset($base->bg['+1']) && isset($base->fg['+1'])) {
		return $base;
	} else {
		image_information_init($post);
		// else, get the colors
		include_once("csscolor.php");
		$base = new CSS_Color(best_color(get_post_meta($post->ID, 'image_url', true)));
		return $base;
	}
}
function set_post_colors($post) {
	global $post;
	$base = get_post_colors($post);
	if( add_post_meta($post->ID, 'image_colors_bg', $base->bg, false)
		&&  add_post_meta($post->ID, 'image_colors_fg', $base->fg, false) )
	return true;
	return false;
}
function reset_post_colors($post) {
	global $post;
	delete_post_meta($post->ID, 'image_url');
	delete_post_meta($post->ID, 'image_size');
	delete_post_meta($post->ID, 'image_tag');
	delete_post_meta($post->ID, 'image_colors_bg');
	delete_post_meta($post->ID, 'image_colors_fg');
	delete_post_meta($post->ID, 'image_colors_bg');
	delete_post_meta($post->ID, 'image_colors_fg');
	//deprecated
	delete_post_meta($post->ID, 'image_md5');
	delete_post_meta($post->ID, 'image_colors');
	delete_post_meta($post->ID, 'image_color_base');
}


function get_colors($url) {
	// get the image name
	$url = trim($url);
	
	// create a working image 
	$im = imagecreatefromjpeg($url);
	
	$height = imagesy($im);
	$width = imagesx($im);
	
	// sample five points in the image, based on rule of thirds and center	
	$topy = round($height / 3);
	$bottomy = round(($height / 3) * 2);
	$leftx = round($width / 3);
	$rightx = round(($width / 3) * 2);
	$centery = round($height / 2);
	$centerx = round($width / 2);
	
	// grab those colors
	$rgb[] = imagecolorat($im, $leftx, $topy);
	$rgb[] = imagecolorat($im, $rightx, $topy);
	
	$rgb[] = imagecolorat($im,  $leftx, $bottomy);
	$rgb[] = imagecolorat($im,  $rightx, $bottomy);
	
	$rgb[] = imagecolorat($im, $centerx, $centery);
	
	// process points
	for ($i = 0; $i <= count($rgb) - 1; $i++) {
	   	$r[$i] = ($rgb[$i] >> 16) & 0xFF;
	   	$g[$i] = ($rgb[$i] >> 8) & 0xFF;
	   	$b[$i] = $rgb[$i] & 0xFF;
		//rgb
		list($colors[$i]['r'],$colors[$i]['g'],$colors[$i]['b']) = array($r[$i],$g[$i],$b[$i]);
		//hsv
		list($colors[$i]['h'],$colors[$i]['s'],$colors[$i]['v']) = hsv($r[$i],$g[$i],$b[$i]);
		//hex
		$colors[$i]['hex'] = rgbhex($r[$i],$g[$i],$b[$i]);
	}
	return $colors;
}

function best_color($url) {
	$colors = get_colors($url);
	foreach ($colors as $color => $value) {
	  	if($value['s'] > $best_saturation) {
	   		$best_saturation = $value['s'];
	   		$the_best_s = $value;
		}
		if($value['v'] > $best_brightness) {
	   		$best_brightness = $value['v'];
	   		$the_best_v = $value;
		}
	}

	// is brightest the same as most saturated?
	$the_best = ($the_best_s['v'] >= ($the_best_v['v'] - ($the_best_v['v'] / 2) )) ? $the_best_s : $the_best_v;
	return $the_best['hex'];
}

function dec2frac( $decimal ) {
  	$decimal = (string)$decimal;
  	$num = '';
  	$den = 1;
  	$dec = false;
 
  	// find least reduced fractional form of number
  	for( $i = 0, $ix = strlen( $decimal ); $i < $ix; $i++ ) {
    	// build the denominator as we 'shift' the decimal to the right
    	if( $dec ) $den *= 10;
  
    	// find the decimal place/ build the numberator
    	if( $decimal{$i} == '.' ) $dec = true;
    	else $num .= $decimal{$i};
  	}
  	$num = (int)$num;
   
  	// whole number, just return it
  	if( $den == 1 ) return $num;
   
  	$num2 = $num;
  	$den2 = $den;
  	$rem  = 1;
  	// Euclid's Algorithm (to find the greatest common divisor)
  	while( $num2 % $den2 ) {
    	$rem = $num2 % $den2;
    	$num2 = $den2;
    	$den2 = $rem;
  	}
  	if( $den2 != $den ) $rem = $den2;
   
  	// now $rem holds the gcd of the numerator and denominator of our fraction
	if($rem == 1) { $den = $den2; $num = $num2; }
  	$r = ($num / $rem );
	if($den / $rem != 1) echo "/" . ($den / $rem);
	return $r;
}

function rgbhex( $red, $green, $blue ) { return sprintf( '%02X%02X%02X', $red, $green, $blue ); }

function hsv( $r,$g,$b ) {
    $max = max($r,$g,$b);
    $min = min($r,$g,$b);
    $delta = $max-$min;
    $v = round(($max / 255) * 100);
	$s = ($max != 0) ? (round($delta/$max * 100)) : 0;
    if($s == 0){
      $h = false;
    }else{
      if($r == $max){
		$h = ($g - $b) / $delta;
      }elseif($g == $max){
		$h = 2 + ($b - $r) / $delta;
      }elseif($b == $max){
		$h = 4 + ($r - $g) / $delta;
      }

      $h = round($h * 60);
      if($h > 360) $h = 360;
      if($h < 0) $h += 360;
    }

	return array($h, $s, $v);
}

function file_is_image($url) {
	if(preg_match('/\.(jpg|jpeg|jpe|JPEG|JPG|png|PNG|gif|GIF)/', $url)) 
		return true;
	return false;
}

function is_vertical($url) {
	global $post;

	if( !file_is_image($url) )
		return false;
				
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
}

function image_orientation() {
	global $vertical;
	//set vertical class or archive class, if needed
	echo ( $vertical == true && !is_archive() && !is_search() ) ? ' class="vertical' : ' class="horizontal';
	if(is_archive() or is_search()) echo ' archive';
	echo '"';
}

function post_exif() {
	global $post;
	
	$id = intval($post->ID);
	$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

	foreach ( $attachments as $id => $attachment ) {
		$m = get_post_meta(intval($id), '_wp_attachment_metadata' , true);
	}
	?>

	<table class="photo-tech" >

	<?php if ( $m['image_meta']['aperture'] ) { ?>
	<tr>
	<th width="100">Aperture:</th>
	<td>f/<?php echo $m['image_meta']['aperture']; ?></td>
	</tr>
	<?php } ?>

	<?php if ( $m['image_meta']['focal_length'] ) { ?>
	<tr>
	<th>Focal Length:</th>
	<td><?php echo $m['image_meta']['focal_length']; ?>mm</td>
	</tr>
	<?php } ?>

	<?php if ( $m['image_meta']['iso'] ) { ?>
	<tr>
	<th>ISO:</th>
	<td><?php echo $m['image_meta']['iso']; ?></td>
	</tr>
	<?php } ?>

	<?php if ( $m['image_meta']['shutter_speed'] ) { ?>
	<tr>
	<th>Shutter:</th>
	<td><?php 
	$t = dec2frac($m['image_meta']['shutter_speed']);
	echo $t. ' sec';
	?></td>
	</tr>
	<?php } ?>

	<?php if ( $m['image_meta']['camera'] ) { ?>
	<tr>
	<th>Camera:</th>
	<td><?php echo $m['image_meta']['camera']; ?></td>
	</tr>
	<?php } ?>

	</table>

	<?php 
}