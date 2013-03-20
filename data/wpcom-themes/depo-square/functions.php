<?php
global $depo_post_types;

$content_width = 450;

if( !function_exists( 'before_post' ) ) { function before_post() { } }
if( !function_exists( 'after_post' ) ) { function after_post() { } }

if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
		'name' => 'Left',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));

register_sidebar(array(
	'name' => 'Center',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
));

register_sidebar(array(
	'name' => 'Right',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
));
}

register_sidebar_widget('DePo Square About', 'depo_square_about_widget');

function depo_square_about_widget() { ?>
<h3>
			<?php if( $page = get_page_by_title('About') ) {  echo "<a href='" . get_permalink($page->ID) . "'>About</a>"; } else { ?>
			About
			<?php } ?>
			</h3>
			<p><?php bloginfo('description'); ?></p>
<?php }
register_sidebar_widget('DePo Square Status', 'depo_square_status_widget');
function depo_square_status_widget() { 
			global $depo_post_types; ?>
			<?php if(get_option( $depo_post_types['status']['id'] )) : ?>
			<h3><a href="<?php echo get_category_link(get_option( $depo_post_types['status']['id'] )); ?>">Status</a></h3>

			<?php
			$depo_status_query = new WP_Query("posts_per_page=1&cat=".get_option( $depo_post_types['status']['id'] )); 
			while ($depo_status_query->have_posts()) : $depo_status_query->the_post(); ?>
			<?php the_content(); ?>
			<?php
			endwhile;
			else :
			?>
			<?php if( is_user_logged_in() ) :?>
			<h3>Status</h3>
			<p><a href="<?php bloginfo('wpurl'); ?>/wp-admin/themes.php?page=depo-square">Setup your post type categories</a> to have your latest status message appear here.</p>
			<?php endif;?>
			<?php endif;?>
<?php }

function depo_square_flickr_widget() {
	if(class_exists('Widget_DePoFlickr')) {
		$args = array('before_title' => '<h3>', 'after_title' => '</h3>', 'title' => 'Flickr');
		$flickr = new Widget_DePoFlickr;
		@$flickr->widget($args);
	}
} 


$depo_post_types = array(
'post' => 
	array(
	'id' => 'type-post', 
	'proper_name' => 'Articles'
	),
'status' => 
	array(
	'id' => 'type-status',
	'proper_name' => 'Statuses'
	),
'quote' => 
	array(
	'id' => 'type-quote',
	'proper_name' => 'Quotes'
	),
'links' => 
	array(
	'id' => 'type-link',
	'proper_name' => 'Links'
	),
'photo' => 
	array(
	'id' => 'type-photo',
	'proper_name' => 'Photos'
	)
);

function depo_post_category_html () {

	$type = depo_post_type();	
	$type = $type['id'];

	echo (!$type or $type == 'type-post') ? 
		"<img src='".get_bloginfo('template_directory')."/i/type-post.png' alt='Post' />"
	:
	"<img src='".get_bloginfo('template_directory')."/i/$type.png' alt='$type[proper_name]' />";
}
function depo_post_type() {
	global $depo_post_types;
	$custom = false;
	foreach( $depo_post_types as $key => $option ) {
		if( in_category(get_option( $option['id'] )) ) {
			$custom = $option;
		}
	}
	if(!$custom)
		return $depo_post_types['post'];
	return $custom;
}

function depo_post_category () {
	$type = depo_post_type();	
	$type = $type['id'];

	return (!$type or $type == 'type-post') ? 
		"type-post"
	:
		$type;
}

// type-photo functions

function replace_empty_tag($m) {
	$no_replace = array('embed'); // expand as required
	if ( in_array( strtolower($m[1]), $no_replace ) )
		return $m[0]; // return the original untouched
	return '';
}

// remove image tag from post_content for display
function image_above($entry) {
	// don't scrape the image for the feed
	if (is_feed()) { return $entry; }
	
	$entry = str_replace('[/wp_caption]','', $entry);
	$entry = str_replace('[/caption]','', $entry);
	
	//remove image tag
	$image = preg_replace('/<img [^>]*src=(\"|\').+?(\1)[^>]*\/*>/','', $entry);
	
	//remove any empty tags left by the scrape.
	$entry = str_replace('<p> </p>', '', $entry);
	$entry = preg_replace_callback( '|<([a-z]+)[^>]*>\s*</\1>|i', 'replace_empty_tag', $entry );
	$entry = preg_replace_callback( '|<([a-z]+)[^>]*>\s*</\1>|i', 'replace_empty_tag', $entry );
	$entry = preg_replace_callback( '|<([a-z]+)[^>]*>\s*</\1>|i', 'replace_empty_tag', $entry );
	return $image.$entry;
}


//admin interface

if( is_admin() ) {
	
	add_action('admin_menu', 'deposquare_add_page');
	function deposquare_add_page() {
		add_theme_page(__('DePo Square Theme Options'), __('Current Theme Options'), 'administrator', 'depo-square', 'deposquare_do_page');
	}
	


	function deposquare_do_page() {
		global $depo_post_types;
		if( esc_attr( $_POST['action'] ) == 'update' ) {
			foreach( $depo_post_types as $key => $option ) {
				if( esc_attr( $_POST[ $option['id'] ] ) ) update_option( $option['id'], esc_attr( $_POST[ $option['id'] ] ) );
			}
		}
		
		foreach( $depo_post_types as $key => $option ) {
			register_setting( 'deposquareops', $option['id'], 'intval' );
		}
		?>
	<div class="wrap">
	<h2><?php _e('DePo Square Theme Options'); ?></h2>
	<form method="post">
		<?php settings_fields( 'deposquareops' ); ?>
		<?php 
		$defaults = array(
		'show_option_all' => '', 'show_option_none' => '',
		'orderby' => 'id', 'order' => 'ASC',
		'show_last_update' => 0, 'show_count' => 0,
		'hide_empty' => 1, 'child_of' => 0,
		'exclude' => '', 'echo' => 1,
		'selected' => 0, 'hierarchical' => 0,
		'name' => 'cat', 'class' => 'postform',
		'depth' => 0, 'tab_index' => 0
		);
	
		$args = array('hide_empty' => 0, 'name' => 'category_parent', 'orderby' => 'name', 'selected' => $category->parent, 'hierarchical' => true, 'show_option_none' => __('None'));
		$r = wp_parse_args( $args, $defaults );
		extract( $r );
		$categories = get_categories($args);
		?>

		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Category Mappings</th>
			</tr>
			<tr>
				<td>
					<table border="0" cellspacing="5" cellpadding="5">
						<tr><th><strong>Type of Post</strong></th> <th><strong>Category to Map</strong></th></tr>

						<?php foreach( $depo_post_types as $key => $option ) { 
							if($key != 'post') {
							?>
						<tr><td><?php _e( $option['proper_name'] ); ?></td><td>
							<?php $value = get_option( $option['id'] ); ?>
							<select name="<?php echo $option['id'] ?>" id="<?php echo $option['id'] ?>" size="1">
							<?php /*foreach($categories as $catkey => $data) { ?>
								<option <?php if( $value == $data->cat_ID) echo ' selected="selected"'; ?>
									value="<?php echo $data->cat_ID; ?>">
									<?php if( $data->parent > 0 ) { $pad .= '&nbsp;&nbsp;&nbsp;'; } else { $pad = ''; } ?>
									<?php echo $pad.$data->category_nicename; ?>
								</option>
							<?php } */?>
							<?php 
							$output = '';
							$output .= walk_category_dropdown_tree( $categories, $r['depth'], $r );
							if($value > 0) $output = preg_replace('/(value="'.$value.'")/', '$1'.' selected="selected"', $output);
							echo $output;
							?>
							</select>
							<?php $value = 0; ?>
						</td></tr>
						<?php } } ?>
					</table>
				</td>
				</tr>
		</table>
	
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	</div>	
	<?php }

}
if( !function_exists('fetch_rss_summary') ) { function fetch_rss_summary( $a, $b ) { return fetch_rss( $a, $b ); } }

register_widget('Widget_DePoFlickr');
class Widget_DePoFlickr extends WP_Widget {
	
	function Widget_DePoFlickr() {
		$widget_ops = array('classname' => 'depo_widget_flickr', 'description' => __( "For DePo Square: Display your flickr photos.") );
		$this->WP_Widget('depo-square-flickr', __('DePo Square Flickr'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $current_blog;
		require_once(ABSPATH . WPINC . '/rss.php');
		extract( $args );

		$flickr_rss_url = esc_url($instance['flickr_rss_url']);
		if ( empty($flickr_rss_url) ) $flickr_rss_url = __('http://feeds.feedburner.com/flickr_interestingness');
		
		if( empty($title) ) $title = apply_filters('widget_title', $instance['title']);
		if ( empty($title) ) $title = __( 'Flickr' );
		if ( empty($items) || $items < 1 || $items > 10 ) $items = 8;

		if(  !$photos = @wp_cache_get('widget-depo-square-flickr') ) {
			$flickr_photos = fetch_rss_summary( $flickr_rss_url, array( 'link', 'title', 'media:thumbnail', 'description' ) );
			if( is_array( $flickr_photos->items ) ) {
				$photos = '';
				$items = array_slice( $flickr_photos->items, 0, $items );
				while( list( $key, $photo ) = each( $items ) ) {
					$href = wp_specialchars($photo['link'], true);
					$itemtitle = wp_specialchars($photo['title'], true);
					if ( isset( $photo['media:thumbnail'] ) ) {
						$src = str_replace( "_s.jpg", "_t.jpg", wp_specialchars($photo['media:thumbnail']['url'], true) );
					} else { // Sometimes the image url is in the description
						$src = preg_match( '/src="(.*?)"/i', $photo['description'], $p );
						$src = $p[1];
						$src = str_replace( '_m.jpg', '_t.jpg', $src );
						$src = wp_specialchars( $src, true );
					}
					if(empty($src)) $src = $photo['enclosure'];
					$photos .= "<li><a href='$href'><img alt='$itemtitle' title='$itemtitle' src='$src' /></a></li>";
				}
				$flickr_home = wp_specialchars( $flickr_photos->channel[ 'link' ], true );
				$flickr_more_title = wp_specialchars( $flickr_photos->channel[ 'title' ], true );
				
				@wp_cache_add( 'widget-depo-square-flickr', $photos, 'widget', $expire );
			}
		}
		echo  $before_title.'<a href="'.$flickr_home.'">'.$title.'</a>'.$after_title;
		echo '<ul class="widget_flickr_depo">'.$photos.'</ul>';
		if(function_exists('stats_extra') ) stats_extra( 'widget', 'depo-square-flickr' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['flickr_rss_url'] = strip_tags(stripslashes($new_instance['flickr_rss_url']));
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));

		wp_cache_delete( 'widget-depo-square-flickr' , 'widget' );

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('flickr_rss_url' => '', 'title' => '') );

		$flickr_rss_url = esc_attr($instance['flickr_rss_url']);
		$title = esc_attr($instance['title']);

		echo '<p><label for="' . $this->get_field_id('title') . '">' . __('Title:') . '
		<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" />
		</label></p>
		<p><label for="' . $this->get_field_id('flickr_rss_url') . '">' . __('RSS URL:') . ' *
		<input class="widefat" id="' . $this->get_field_id('flickr_rss_url') . '" name="' . $this->get_field_name('flickr_rss_url') . '" type="text" value="' . $flickr_rss_url . '" />
		</label></p>
			<p>
		* Your RSS feed can be found on your Flickr homepage. Scroll down to the bottom of the page until you see the <em>Feed</em> link and copy that into the box above.
	</p>
	<p>Leave the Flickr RSS URL blank to display <a href="http://www.flickr.com/explore/interesting">interesting</a> Flickr photos.</p>
		';
	}

}
