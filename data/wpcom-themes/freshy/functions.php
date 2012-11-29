<?php

define('TEMPLATE_DOMAIN', 'freshy');

if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
        'before_title' => '<h2 class="title">',
        'after_title' => '</h2>',
    ));
}

// modded version to highlight parent menu !
function freshy_wp_list_pages($args = '') {
	parse_str($args, $r);
	if ( !isset($r['depth']) )
		$r['depth'] = 0;
	if ( !isset($r['show_date']) )
		$r['show_date'] = '';
	if ( !isset($r['child_of']) )
		$r['child_of'] = 0;
	if ( !isset($r['title_li']) )
		$r['title_li'] = __('Pages');
	if ( !isset($r['echo']) )
		$r['echo'] = 1;
	
	$output = '';

	$pages = & get_pages($args);
	if ( $pages ) {

		if ( $r['title_li'] )
			$output .= '<li class="pagenav">' . $r['title_li'] . '<ul>';

		$page_tree = array();
		foreach ( $pages as $page ) {
			if(get_page_link($page->ID) != get_option('home')) {
				$page_tree[$page->ID]['title'] = $page->post_title;
				$page_tree[$page->ID]['name'] = $page->post_name;
				if ( !empty($r['show_date']) ) {
					if ( 'modified' == $r['show_date'] )
						$page_tree[$page->ID]['ts'] = $page->post_modified;
					else
						$page_tree[$page->ID]['ts'] = $page->post_date;
				}
				if ( $page->post_parent != $page->ID)
					$page_tree[$page->post_parent]['children'][] = $page->ID;
			}
		}
		$output .= freshy_page_level_out($r['child_of'],$page_tree, $r, 0, false);
		if ( $r['title_li'] )
			$output .= '</ul></li>';
	}

	$output = apply_filters('wp_list_pages', $output);

	if ( $r['echo'] )
		echo $output;
	else
		return $output;
}

// modded version to highlight parent menu !
function freshy_page_level_out($parent, $page_tree, $args, $depth = 0, $echo = true) {
	global $wp_query, $post, $wpdb;
	$queried_obj = $wp_query->get_queried_object();
	$output = '';
	
	$current_page = $post->ID;
	$i=0; // loop to get the top parent page
	$page_query = false;
	while($current_page) {
		$i++;
		if ($i>100) break; // avoid infinite loop
		$page_query = $wpdb->get_row("SELECT ID, post_title, post_parent FROM $wpdb->posts WHERE ID = '$current_page'");
		$current_page = $page_query->post_parent;
	}
	$parent_id = $page_query->ID;


	$indent = str_repeat("\t", $depth? $depth : 0);

	if ( !is_array($page_tree[$parent]['children']) )
		return false;

	foreach ( $page_tree[$parent]['children'] as $page_id ) {
		$cur_page = $page_tree[$page_id];
		$title = $cur_page['title'];

		$css_class = 'page_item';
		if ( ($page_id == $queried_obj->ID || $page_id == $parent_id) && !is_front_page() )
			$css_class .= ' current_page_item';

		$output .= $indent . '<li class="' . $css_class . '"><a href="' . get_page_link($page_id) . '" title="' . wp_specialchars($title) . '">' . $title . '</a>';

		if ( isset($cur_page['ts']) ) {
			$format = get_option('date_format');
			if ( isset($args['date_format']) )
				$format = $args['date_format'];
			$output .= " " . mysql2date($format, $cur_page['ts']);
		}

		if ( isset($cur_page['children']) && is_array($cur_page['children']) ) {
			$new_depth = $depth + 1;

			if ( !$args['depth'] || $depth < ($args['depth']-1) ) {
				$output .= "$indent<ul>\n";
				$output .= freshy_page_level_out($page_id, $page_tree, $args, $new_depth, false);
				$output .= "$indent</ul>\n";
			}
		}
		$output .= "$indent</li>\n";
	}
	if ( $echo )
		echo $output;
	else
		return $output;
}


// SET OPTIONS

$freshy_options=array();
//update_option('freshy_options', $freshy_options);
$freshy_theme_default=array();
$freshy_theme_red=array();
$freshy_theme_blue=array();
$freshy_theme_lime=array();

freshy_set_options();

function freshy_set_options() {
	
	global $freshy_options, $freshy_theme_red, $freshy_theme_lime, $freshy_theme_blue;
	
	$freshy_theme_default['highlight_color']='#FF3C00';
	$freshy_theme_default['description_color']='#ADCF20';
	$freshy_theme_default['author_color']='#a3cb00';
	$freshy_theme_default['sidebar_bg']='#FFFFFF';
	$freshy_theme_default['sidebar_titles_color']='#f78b0c';
	$freshy_theme_default['sidebar_titles_bg']='#FFFFFF';
	$freshy_theme_default['menu_bg']='menu_start_triple.gif';
	$freshy_theme_default['menu_color']='#000000';
	$freshy_theme_default['header_bg']='header_image6.jpg';
	$freshy_theme_default['header_bg_custom']='';
	$freshy_theme_default['sidebar_titles_type']='stripes';
	
	$freshy_theme_default['first_menu_label']='Home';
	$freshy_theme_default['blog_menu_label']='Blog';
	$freshy_theme_default['last_menu_label']='Contact';
	$freshy_theme_default['last_menu_type']='';
	$freshy_theme_default['contact_email']='';
	$freshy_theme_default['contact_link']='';
	
	$freshy_theme_default['menu_type']='auto';
	$freshy_theme_default['args_pages']='sort_column=menu_order&title_li=';
	$freshy_theme_default['args_cats']='hide_empty=0&sort_column=name&optioncount=1&title_li=&hierarchical=1&feed=RSS&feed_image='.get_bloginfo('stylesheet_directory').'/images/icons/feed-icon-10x10.gif';
	
	$freshy_theme_lime['highlight_color']='#FF3C00';
	$freshy_theme_lime['description_color']='#ADCF20';
	$freshy_theme_lime['author_color']='#a3cb00';
	$freshy_theme_lime['sidebar_bg']='#FFFFFF';
	$freshy_theme_lime['sidebar_titles_color']='#f78b0c';
	$freshy_theme_lime['sidebar_titles_bg']='#FFFFFF';
	$freshy_theme_lime['menu_bg']='menu_start_triple.gif';
	$freshy_theme_lime['menu_color']='#000000';
	$freshy_theme_lime['header_bg']='header_image6.jpg';
	$freshy_theme_lime['header_bg_custom']='';
	$freshy_theme_lime['sidebar_titles_type']='stripes';

	
	$freshy_theme_red['highlight_color']='#d80f2a';
	$freshy_theme_red['description_color']='#eca50d';
	$freshy_theme_red['author_color']='#eca50d';
	$freshy_theme_red['sidebar_bg']='#F3F3F3';
	$freshy_theme_red['sidebar_titles_color']='#000000';
	$freshy_theme_red['sidebar_titles_bg']='#c2c2c2';
	$freshy_theme_red['menu_bg']='menu_start_triple_red.gif';
	$freshy_theme_red['menu_color']='#ffffff';
	$freshy_theme_red['header_bg']='header_image8.jpg';
	$freshy_theme_red['header_bg_custom']='';
	$freshy_theme_red['sidebar_titles_type']='stripes';
	

	$freshy_theme_blue['highlight_color']='#f5690c';
	$freshy_theme_blue['description_color']='#ff6c00';
	$freshy_theme_blue['author_color']='#f5bb0c';
	$freshy_theme_blue['sidebar_bg']='#dbefff';
	$freshy_theme_blue['sidebar_titles_color']='#0f80d8';
	$freshy_theme_blue['sidebar_titles_bg']='#FFFFFF';
	$freshy_theme_blue['menu_bg']='menu_start_triple_lightblue.gif';
	$freshy_theme_blue['menu_color']='#ffffff';
	$freshy_theme_blue['header_bg']='header_image3.jpg';
	$freshy_theme_blue['header_bg_custom']='';
	$freshy_theme_blue['sidebar_titles_type']='stripes';

		$freshy_options=$freshy_theme_default;

}


// ADD HEAD TO THE TEMPLATE

add_action('wp_head', 'freshy_head');

function freshy_head() {
	
	global $freshy_options, $freshy_theme_lime;
	
	$menu_triple = str_replace("menu_start_triple", "menu_triple", $freshy_options['menu_bg']);
	$menu_end_triple = str_replace("menu_start_triple", "menu_end_triple", $freshy_options['menu_bg']);

	
	?>

	<style type="text/css">
	.menu li a {
		background-image:url("<?php bloginfo('stylesheet_directory'); ?>/images/menu/<?php echo $menu_triple; ?>");
	}
	.menu li a.first_menu {
		background-image:url("<?php bloginfo('stylesheet_directory'); ?>/images/menu/<?php echo $freshy_options['menu_bg']; ?>");
	}
	.menu li a.last_menu {
		background-image:url("<?php bloginfo('stylesheet_directory'); ?>/images/menu/<?php echo $menu_end_triple; ?>");
	}
	.menu li.current_page_item a {
		color:<?php echo $freshy_options['menu_color']; ?> !important;
	}
	
	.description {
		color:<?php echo $freshy_options['description_color']; ?>;
	}
	#content .commentlist dd.author_comment {
		background-color:<?php echo $freshy_options['author_color']; ?> !important;
	}
	html > body #content .commentlist dd.author_comment {
		background-color:<?php echo $freshy_options['author_color']; ?> !important;
	}
	#content .commentlist dt.author_comment .date {
		color:<?php echo $freshy_options['author_color']; ?> !important;
		border-color:<?php echo $freshy_options['author_color']; ?> !important;
	}
	#content .commentlist .author_comment .author,
	#content .commentlist .author_comment .author a {
		color:<?php echo $freshy_options['author_color']; ?> !important;
		border-color:<?php echo $freshy_options['author_color']; ?> !important;
	}
	#sidebar h2 {
		color:<?php echo $freshy_options['sidebar_titles_color']; ?>;
		background-color:<?php echo $freshy_options['sidebar_titles_bg']; ?>;
		border-bottom-color:<?php echo $freshy_options['sidebar_titles_color']; ?>;
	}
	#sidebar {
		background-color:<?php echo $freshy_options['sidebar_bg']; ?>;
	}
	*::-moz-selection {
		background-color:<?php echo $freshy_options['highlight_color']; ?>;
	}

	#content a:hover {
		border-bottom:1px dotted <?php echo $freshy_options['highlight_color']; ?>;
	}

	#sidebar a:hover,
	#sidebar .current_page_item li a:hover,
	#sidebar .current-cat li a:hover,
	#sidebar .current_page_item a,
	#sidebar .current-cat a ,
	.readmore,
	#content .postmetadata a
	{
		color : <?php echo $freshy_options['highlight_color']; ?>;
	}
	
	#title_image {
		margin:0;
		text-align:left;
		display:block;
		height:95px;
	}
	
	</style>

	<?php
}


function freshy_stupid_dir() {
	return substr(strrchr(get_bloginfo('stylesheet_directory'), "/"),1);
}

// Custom Headers

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/headers/header_image6.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 780);
define('HEADER_IMAGE_HEIGHT', 95);
define( 'NO_HEADER_TEXT', true );

function freshy_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}

</style>
<?php
}

function header_style() {
?>
<style type="text/css">
	#title_image {
	background-image:url(<?php header_image() ?>);
	}
</style>
<?php
}

add_custom_image_header('header_style', 'freshy_admin_header_style');

$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'ffffff',
	'text' => '000000',
	'link' => '515151'
);

$content_width = 510;

?>
