<?php

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

function wp_list_page($args = '') {
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

	// Query pages.
	$pages = & get_pages($args);
	if ( $pages ) {

		if ( $r['title_li'] )
			$output .= '<li class="pagenav">' . $r['title_li'] . '<ul>';

		// Now loop over all pages that were selected
		$page_tree = Array();
		foreach ( $pages as $page ) {
			// set the title for the current page
			$page_tree[$page->ID]['title'] = $page->post_title;
			$page_tree[$page->ID]['name'] = $page->post_name;

			// set the selected date for the current page
			// depending on the query arguments this is either
			// the createtion date or the modification date
			// as a unix timestamp. It will also always be in the
			// ts field.
			if ( !empty($r['show_date']) ) {
				if ( 'modified' == $r['show_date'] )
					$page_tree[$page->ID]['ts'] = $page->post_modified;
				else
					$page_tree[$page->ID]['ts'] = $page->post_date;
			}

			// The tricky bit!!
			// Using the parent ID of the current page as the
			// array index we set the curent page as a child of that page.
			// We can now start looping over the $page_tree array
			// with any ID which will output the page links from that ID downwards.
			if ( $page->post_parent != $page->ID)
				$page_tree[$page->post_parent]['children'][] = $page->ID;
		}
		// Output of the pages starting with child_of as the root ID.
		// child_of defaults to 0 if not supplied in the query.
		$output .= _page_level_out1($r['child_of'],$page_tree, $r, 0, false);
		if ( $r['title_li'] )
			$output .= '</ul></li>';
	}

	$output = apply_filters('wp_list_page', $output);

	if ( $r['echo'] )
		echo $output;
	else
		return $output;
}


function _page_level_out1($parent, $page_tree, $args, $depth = 0, $echo = true) {
	global $wp_query;
	$queried_obj = $wp_query->get_queried_object();
	$output = '';

	if ( $depth )
		$indent = str_repeat("\t", $depth);
		//$indent = join('', array_fill(0,$depth,"\t"));

	if ( !is_array($page_tree[$parent]['children']) )
		return false;

	foreach ( $page_tree[$parent]['children'] as $page_id ) {
		$cur_page = $page_tree[$page_id];
		$title = $cur_page['title'];

		$css_class = 'page_item';
		if ( $page_id == $queried_obj->ID )
			$css_class .= ' current_page_item';

		$output .= $indent . '<li class="' . $css_class . '"><a href="' . get_page_link($page_id) . '" title="' . wp_specialchars($title) . '"><span>' . $title . '</span></a>';

		if ( isset($cur_page['ts']) ) {
			$format = get_settings('date_format');
			if ( isset($args['date_format']) )
				$format = $args['date_format'];
			$output .= " " . mysql2date($format, $cur_page['ts']);
		}

		if ( isset($cur_page['children']) && is_array($cur_page['children']) ) {
			$new_depth = $depth + 1;

			if ( !$args['depth'] || $depth < ($args['depth']-1) ) {
				$output .= "$indent<ul>\n";
				$output .= _page_level_out1($page_id, $page_tree, $args, $new_depth, false);
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
?>
