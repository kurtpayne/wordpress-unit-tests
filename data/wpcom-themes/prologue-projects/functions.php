<?php

/**
 * Tells us if we are in WordPress.com or not.
 **/
if ( !defined( 'IS_WPCOM' ) ) {
	define( 'IS_WPCOM', false );
}

/**
 * Some special variables used in WordPress.com.
 */
if ( IS_WPCOM ) {
	$themecolors = array(
		'bg'     => 'f5f5f5',
		'border' => 'dddddd',
		'text'   => '555555',
		'link'   => '21759b'
	);
}
$content_width = 488; // pixels

/**
 * Register some dependencies at initialisation.
 *
 * @return void
 **/
function pp_init()
{
	wp_register_script( 'pp-front', get_bloginfo('template_url') . '/prologue-projects.js', false, '20090218' );
	wp_register_style( 'pp-reset-fonts', get_bloginfo('template_url') . '/reset-fonts.css', false, '20090218' );
	wp_register_style( 'pp-front', get_bloginfo('template_url') . '/style.css', array('pp-reset-fonts'), '20090218' );
}
add_action( 'init', 'pp_init' );

/**
 * Enqueue our dependencies for linking in the html head.
 *
 * @return void
 **/
function pp_head()
{
	wp_enqueue_script( 'pp-front' );
	wp_enqueue_style( 'pp-front' );
}
add_action( 'wp_head', 'pp_head', 1 );

/**
 * Where the bloody hell are ya?
 *
 * @return string The current URL.
 **/
function pp_get_current_url()
{
	$schema = is_ssl() ? 'https://' : 'http://';
	return $schema . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Get stored options for prologue_projects and merge them with the defaults.
 *
 * @return array All the options.
 **/
function pp_get_options()
{
	$defaults = array(
		'category_projects'      => false,
		'featured_project'       => false,
		'project_data'           => array(),
		'projects_sidebars'      => false,
		'category_updates'       => false,
		'category_tasks'         => false,
		'default_task_level'     => false,
		'category_questions'     => false,
		'default_question_state' => false,
		'author_sidebars'        => false
	);

	$options = get_option( 'prologue_projects' );

	return array_merge( $defaults, $options );
}

/**
 * Get a single prologue_projects option
 *
 * @param string $key The key of the option to be retrieved.
 * @return mixed The value of the option or boolean false if not set.
 **/
function pp_get_option( $key )
{
	if ( !$key ) {
		return false;
	}
	$options = pp_get_options();
	if ( !isset( $options[$key] ) ) {
		return false;
	}
	return $options[$key];
}

/**
 * Shorthand function to retrieve the actual category id of a prologue_projects post type
 *
 * @param string $type The post type whose category id is to be returned, can be one of "projects", "updates", "tasks" or "questions".
 * @return int The category id or false if none is set.
 **/
function pp_get_category_id( $type )
{
	return pp_get_option( 'category_' . $type );
}

/**
 * Allows for template customisation of individual projects by injecting new files named after the project slug into the template hierarchy.
 *
 * When a request is made for "updates" in the project "foo", WordPress will look for the following files in order:
 *  1. updates-foo.php
 *  2. updates.php
 *  3. index.php
 *  4. The originally determined category template, passed as parameter $template.
 *
 * @param string $template The originally determined category template.
 * @return void
 **/
function pp_category_template( $template )
{
	$requested_category_id = absint( get_query_var( 'cat' ) );

	$types = array(
		'projects'  => pp_get_category_id( 'projects' ),
		'updates'   => pp_get_category_id( 'updates' ),
		'tasks'     => pp_get_category_id( 'tasks' ),
		'questions' => pp_get_category_id( 'questions' )
	);

	foreach ( $types as $_type => $_category_id ) {
		if ( !$_category_id ) {
			continue;
		}

		$_category = get_category( absint( $_category_id ) );

		if ( !$_category || is_wp_error( $_category ) ) {
			continue;
		}

		if ( $_category_id == $requested_category_id ) {
			return locate_template( array(
				$_type . '.php',
				'index.php',
				$template
			) );
		}

		$_ids = get_categories( array(
			'child_of' => $_category_id,
			'hide_empty' => false,
			'fields' => 'ids'
		) );

		if ( !in_array( $requested_category_id, $_ids ) ) {
			continue;
		}

		$_type_category = get_category( $requested_category_id );

		if ( !$_type_category || is_wp_error( $_type_category ) ) {
			continue;
		}

		return locate_template( array(
			$_type . '-' . $_type_category->slug . '.php',
			$_type . '.php',
			'index.php',
			$template
		) );
	}

	return $template;
}
add_filter( 'category_template', 'pp_category_template' );

/**
 * Allows the use of Trac-style shorthand for links to Trac tickets and changesets.
 *
 * @param string $text The text to be modified.
 * @return string The modified text.
 **/
function pp_make_tracable( $text )
{
	if ( !$text || !preg_match( '@(?:#[a-z0-9]+)|(?:\[[a-z0-9]+\])@i', $text ) ) {
		return $text;
	}

	global $id, $post;

	if ( !$category_ids = wp_get_post_categories( $id ) ) {
		return $text;
	}

	$project_tracs = array();
	$i = 0;
	foreach ( $category_ids as $category_id ) {
		$project_data = pp_get_project_data( $category_id );
		if ( isset( $project_data['trac'] ) && $project_data['trac'] ) {
			$i++;
			$project_tracs[$i][0][0] = '#' . preg_quote( $project_data['slug'] ) . '([0-9]+)';
			$project_tracs[$i][0][1] = $project_data['trac'] . 'ticket/$1';
			$project_tracs[$i][0][2] = '#' . $project_data['slug'] . '$1';
			$project_tracs[$i][1][0] = '\[' . preg_quote( $project_data['slug'] ) . '([0-9]+)\]';
			$project_tracs[$i][1][1] = $project_data['trac'] . 'changeset/$1';
			$project_tracs[$i][1][2] = '[' . $project_data['slug'] . '$1]';
			if ( isset( $project_data['intertrac'] ) && $project_data['intertrac'] ) {
				$project_tracs[$i][2][0] = '#' . preg_quote( $project_data['intertrac'] ) . '([0-9]+)';
				$project_tracs[$i][2][1] = $project_data['trac'] . 'ticket/$1';
				$project_tracs[$i][2][2] = '#' . $project_data['intertrac'] . '$1';
				$project_tracs[$i][3][0] = '\[' . preg_quote( $project_data['intertrac'] ) . '([0-9]+)\]';
				$project_tracs[$i][3][1] = $project_data['trac'] . 'changeset/$1';
				$project_tracs[$i][3][2] = '[' . $project_data['intertrac'] . '$1]';
			}
		}
	}

	if ( !count( $project_tracs ) ) {
		return $text;
	}

	if ( count( $project_tracs ) === 1 ) {
		$project_tracs[0][0][0] = '#([0-9]+)';
		$project_tracs[0][0][1] = $project_tracs[1][0][1];
		$project_tracs[0][0][2] = '#$1';
		$project_tracs[0][1][0] = '\[([0-9]+)\]';
		$project_tracs[0][1][1] = $project_tracs[1][1][1];
		$project_tracs[0][1][2] = '[$1]';
	}

	ksort( $project_tracs );

	foreach ( $project_tracs as $pairs ) {
		foreach ( $pairs as $pair ) {
			$text = preg_replace( '@' . $pair[0] . '@', '<a href="' . $pair[1] . '">' . $pair[2] . '</a>', $text );
		}
	}

	return $text;
}
add_filter( 'the_content', 'pp_make_tracable', 1 );
add_filter( 'the_content', 'make_clickable' );

/**
 * Get the meta data of a given project.
 *
 * @param integer $category_id The category id of the project.
 * @param string $type Optional. The specific meta data to get. Default is "all", which retrieves all meta data.
 * @return mixed The projects meta data in an associative array or the specific data as requested with the $type parameter.
 **/
function pp_get_project_data( $category_id = 0, $type = 'all', $context = '' )
{
	if ( !$category_id ) {
		global $cat;
		$category_id = $cat;
	}

	if ( !$category_id ) {
		return false;
	}

	if ( is_object( $category_id ) && !is_wp_error( $category_id ) ) {
		$category = $category_id;
		$category_id = $category->cat_ID;
	}

	if ( !$context && $cache = wp_cache_get( $category_id, 'pp_project_data' ) ) {
		if ( 'all' === $type ) {
			return $cache;
		}

		if ( !isset( $cache[$type] ) ) {
			return false;
		}

		return $cache[$type];
	}

	if ( !isset( $category ) ) {
		$category = get_category( $category_id );
	}
	if ( !$category || is_wp_error( $category ) ) {
		return false;
	}

	$data = array();
	$data['id'] = $category->cat_ID;
	$data['name'] = $category->name;
	$data['parent_id'] = $category->parent;
	$data['slug'] = $category->slug;
	$data['url'] = get_category_link( $category->cat_ID );
	$data['link'] = '<a href="' . attribute_escape( $data['url'] ) . '">' . $data['name'] . '</a>';
	$data['description'] = $category->description;

	$data['logo']      = '';
	$data['website']   = '';
	$data['blog']      = '';
	$data['svn']       = '';
	$data['trac']      = '';
	$data['intertrac'] = '';
	$data['activity']  = array();
	$data['overheard'] = array();

	if ( $meta = get_option( 'pp_project_meta_' . $data['id'] ) ) {
		foreach ( $meta as $key => $value ) {
			if ( in_array( $key, array( 'intertrac', 'logo' ) ) ) {
				$data[$key] = $value;
			} elseif ( in_array( $key, array( 'activity', 'overheard' ) ) && $value ) {
				$data[$key] = array_merge( $data[$key], $value );
			} elseif ( $value ) {
				$data[$key] = rtrim( $value, '/' ) . '/';
			}
		}
		if ( $data['trac'] && !$context ) {
			$data['activity'][] = $data['trac'] . 'timeline?milestone=on&ticket=on&changeset=on&wiki=on&format=rss&max=20';
		}
	}

	if ( !$context ) {
		wp_cache_add( $category_id, $data, 'pp_project_data' );
	}

	if ( 'all' === $type ) {
		return $data;
	}

	if ( !isset( $data[$type] ) ) {
		return false;
	}

	return $data[$type];
}

/**
 * Callback to clean out the specific project data cache when categories are edited.
 *
 * @param $category_id The category id of the project.
 * @return boolean True if the cache was emptied.
 **/
function pp_delete_project_data_cache( $category_id )
{
	if ( !$category_id ) {
		return false;
	}

	return wp_cache_delete( $category_id, 'pp_project_data' );
}
add_action( 'delete_category', 'pp_delete_project_data_cache', 10, 1 );
add_action( 'edit_category', 'pp_delete_project_data_cache', 10, 1 );

/**
 * Find out if the given category is a project.
 *
 * @param integer $category_id The id of the category.
 * @return boolean True if it is a project, otherwise false.
 **/
function pp_is_project( $category_id = 0 )
{
	$categories = pp_get_projects();

	if ( !$categories || count( $categories ) < 1 ) {
		return false;
	}

	if ( !$category_id = pp_get_project_data( $category_id, 'id' ) ) {
		return false;
	}

	$is_project = false;
	foreach ( $categories as $category ) {
		if ( $category_id == $category->cat_ID ) {
			$is_project = true;
			break;
		}
	}

	return $is_project;
}

function pp_get_projects( $parent_id = 0 )
{
	if ( $parent_id && !pp_is_project( $parent_id ) ) { // Narrowly avoiding circular logic here :)
		return;
	} elseif ( !$parent_id && !$parent_id = pp_get_category_id( 'projects' ) ) {
		return;
	}

	$categories = get_categories( array(
		'child_of' => $parent_id,
		'hierarchical' => 1,
		'hide_empty' => 0
	) );

	return $categories;
}

function pp_get_question_statuses()
{
	if ( !$parent_id = pp_get_category_id( 'questions' ) ) {
		return;
	}

	$categories = get_categories( array(
		'child_of' => $parent_id,
		'hide_empty' => 0
	) );

	return $categories;
}

function pp_is_question_status( $category_id )
{
	if ( !$category_id ) {
		return false;
	}

	$categories = pp_get_question_statuses();

	if ( !$categories || count( $categories ) < 1 ) {
		return false;
	}

	$is_status = false;
	foreach ( $categories as $category ) {
		if ( $category_id == $category->cat_ID ) {
			$is_status = true;
			break;
		}
	}

	return $is_status;
}

function pp_get_project_members( $category_id = 0 )
{
	$project_id = pp_get_project_data( $category_id, 'id' );

	if ( !$project_id ) {
		return false;
	}

	global $wpdb, $blog_id;

	$query = "SELECT `user_id`, `user_login`, `user_nicename`, `display_name`, `user_email`, `meta_value`
				FROM `" . $wpdb->users . "`, `" . $wpdb->usermeta . "`
				WHERE `" . $wpdb->users . "`.`ID` = `" . $wpdb->usermeta . "`.`user_id`
					AND `meta_key` = 'prologue_projects_" . $blog_id . "'
					AND `meta_value` LIKE '%i:" . (int) $project_id . ";a:2:{i:0;i:1;%'
				ORDER BY `" . $wpdb->users . "`.`display_name`;";

	$members = $wpdb->get_results( $query, ARRAY_A );

	$_members = array();
	if ( $members && count( $members ) ) {
		foreach ( $members as $member ) {
			$_member = $member;
			$_member['projects'] = maybe_unserialize( $member['meta_value'] );
			unset( $_member['meta_value'] );
			$_member['project_role'] = strip_tags( trim( wp_filter_kses( wp_specialchars( $_member['projects'][$category_id][1] ) ) ) );
			unset( $_member['projects'] );
			$_members[] = $_member;
		}
	}

	return $_members;
}

function pp_get_user_projects( $user_id = 0 )
{
	if ( !$user = new WP_User( $user_id ) ) {
		return false;
	}

	global $blog_id;
	$meta = 'prologue_projects_' . $blog_id;

	if ( !isset( $user->$meta ) || !$user->$meta || !is_array( $user->$meta ) ) {
		return false;
	}

	$projects = array();
	foreach ( $user->$meta as $project_id => $project_settings ) {
		if ( $project_settings[0] ) {
			$projects[$project_id] = $project_settings[1];
		}
	}

	if ( !count( $projects ) ) {
		return false;
	}

	return $projects;
}


/* Template */

function pp_all_projects_rss()
{
	if ( !$url = get_feed_link() ) {
		return;
	}

	$r = '<a ';
	$r .= 'id="pp-all-projects-rss" ';
	$r .= 'class="pp-all-projects-rss" ';
	$r .= 'href="' . $url . '">';
	$r .= __( 'RSS', 'prologue-projects' );
	$r .= '</a>';

	echo $r;
}

function pp_project_rss( $category_id = 0 )
{
	if ( !$category_id = pp_get_project_data( $category_id, 'id' ) ) {
		return;
	}

	if ( !$url = get_category_feed_link( $category_id ) ) {
		return;
	}

	$r = '<a ';
	$r .= 'id="pp-project-rss-' . $data['slug'] . '" ';
	$r .= 'class="pp-project-rss" ';
	$r .= 'href="' . $url . '">';
	$r .= __( 'RSS', 'prologue-projects' );
	$r .= '</a>';

	echo $r;
}

function pp_project_logo( $category_id = 0 )
{
	if ( !$data = pp_get_project_data( $category_id ) ) {
		return;
	}

	if ( !isset( $data['logo'] ) || !$data['logo'] ) {
		return;
	}

	if ( !parse_url( $data['logo'] ) ) {
		return;
	}

	$r = '<img ';
	$r .= 'id="pp-project-logo-' . $data['slug'] . '" ';
	$r .= 'class="pp-project-logo" ';
	$r .= 'src="' . $data['logo'] . '" ';
	$r .= 'alt="' . __( 'Project logo', 'prologue-projects' ) . '" />';

	echo $r;
}

function pp_project_links( $category_id = 0 )
{
	if ( !$data = pp_get_project_data( $category_id ) ) {
		return;
	}

	$r = '<ul id="pp-project-links-' . attribute_escape( $data['slug'] ) . '" class="pp-project-links">';
	if ( isset( $data['website'] ) && $data['website'] ) {
		$r .= '<li><a href="' . attribute_escape( $data['website'] ) . '">' . __('Website', 'prologue-projects') . '</a></li>' . "\n";
	}
	if ( isset( $data['blog'] ) && $data['blog'] ) {
		$r .= '<li><a href="' . attribute_escape( $data['blog'] ) . '">' . __('Blog', 'prologue-projects') . '</a></li>' . "\n";
	}
	if ( isset( $data['trac'] ) && $data['trac'] ) {
		$trac = attribute_escape( $data['trac'] );
		$r .= '<li><a href="' . $trac . '">' . __( 'Trac', 'prologue-projects' ) . '</a></li>' . "\n";
		$r .= '<li><a href="' . $trac . 'newticket/">' . __( 'Add Trac ticket', 'prologue-projects' ) . '</a></li>' . "\n";
		$r .= '<li><a href="' . $trac . 'browser/">' . __( 'Browse source', 'prologue-projects' ) . '</a></li>' . "\n";
	}
	if ( isset( $data['svn'] ) && $data['svn'] ) {
		$r .= '<li><a href="' . attribute_escape( $data['svn'] ) . '">' . __('Subversion', 'prologue-projects') . '</a></li>' . "\n";
	}
	$r .= '</ul>';

	echo $r;
}

function pp_get_project_base_link()
{
	$project_category = get_category( pp_get_category_id( 'projects' ) );
	if ( !$project_category || is_wp_error( $project_category ) ) {
		return false;
	}

	$project_link = get_category_link( $project_category );
	if ( !$project_link || is_wp_error( $project_link ) ) {
		return false;
	}

	return '<a href="' . $project_link . '">' . $project_category->name . '</a>';
}

function _pp_prepend_parent_link_to_breadcrumbs( $breadcrumbs, $category_id = 0 )
{
	if ( $category_id == pp_get_category_id( 'projects' ) ) {
		return $breadcrumbs;
	}
	if ( !$data = pp_get_project_data( $category_id ) ) {
		return $breadcrumbs;
	}
	$category_id = $data['id'];

	$url = $data['url'];
	if ( isset( $_GET['tasks'] ) ) {
		$url = $url . '?tasks';
	} elseif ( isset( $_GET['questions'] ) ) {
		$url = $url . '?questions';
	}

	$link = '<a href="' . attribute_escape( $url ) . '">' . $data['name'] . '</a>';

	array_unshift( $breadcrumbs, $link );

	if ( (int) $data['id'] === (int) pp_get_category_id( 'projects' ) ) {
		return $breadcrumbs;
	}

	return _pp_prepend_parent_link_to_breadcrumbs( $breadcrumbs, $data['parent_id'] );
}

function pp_project_breadcrumbs( $category_id = 0 )
{
	$data = pp_get_project_data( $category_id );

	$breadcrumbs = array();
	if ( $data ) {
		$breadcrumbs = _pp_prepend_parent_link_to_breadcrumbs( $breadcrumbs, $data['id'] );
	}
	array_unshift( $breadcrumbs, '<a href="' . attribute_escape( get_bloginfo( 'url' ) ) . '">' . __( 'Home', 'prologue-projects' ) . '</a>' );

	$r = '<ul id="pp-project-breadcrumbs-' . $data['slug'] . '" class="pp-project-breadcrumbs">' . "\n";
	foreach ( $breadcrumbs as $breadcrumb ) {
		$r .= '<li>' . $breadcrumb . '</li>' . "\n";
	}
	
	if ( $data ) {
		$sub_projects = get_categories( array(
			'parent' => $data['id'],
			'hide_empty' => false
		) );
	}

	if ( $sub_projects && !is_wp_error( $sub_projects ) ) {
		$r .= '<li class="pp-sub-projects"><form><label for="pp-sub-project-selector">' . __( 'Select a sub-project', 'prologue-projects' ) . '</label><select name="pp-sub-project-selector" onchange="pp_go(this);">';
		$r .= '<option value=""></option>';

		foreach ( $sub_projects as $sub_project ) {
			$sub_project_url = pp_get_project_data( $sub_project, 'url' );
			if ( isset( $_GET['tasks'] ) ) {
				$sub_project_url = $sub_project_url . '?tasks';
			} elseif ( isset( $_GET['questions'] ) ) {
				$sub_project_url = $sub_project_url . '?questions';
			}
			$r .= '<option value="' . attribute_escape( $sub_project_url ) . '">' . wp_specialchars( pp_get_project_data( $sub_project, 'name' ) ) . '</option>';
		}

		$r .= '</select></form></li>' . "\n";
	}

	$r .= '</ul>' . "\n";

	echo $r;
}

function pp_project_name( $category_id = 0 )
{
	echo wp_specialchars( pp_get_project_data( $category_id, 'name' ) );
}

function pp_project_description( $category_id = 0 )
{
	echo wpautop( wp_specialchars( pp_get_project_data( $category_id, 'description' ) ) );
}

function pp_project_website( $category_id = 0 )
{
	echo '<a href="' . attribute_escape( pp_get_project_data( $category_id, 'website' ) ) . '">' . wp_specialchars( pp_get_project_data( $category_id, 'name' ) ) . '</a>';
}

function pp_get_project_activity( $category_id = 0 )
{
	if ( !$data = pp_get_project_data( $category_id ) ) {
		return;
	}

	if ( !isset( $data['activity'] ) || !$data['activity'] ) {
		return;
	}

	require_once( ABSPATH . WPINC . '/rss.php' );

	$feeds = array();
	foreach ( $data['activity'] as $feed_url ) {
		$feeds[] = fetch_rss( $feed_url );
	}

	$items = array();
	foreach ( $feeds as $feed ) {
		if ( !isset( $feed->items ) ) {
			continue;
		}
		foreach ( $feed->items as $item ) {
			$time = strtotime( $item['pubdate'] );
			$item['time'] = $time;
			if ( $parsed = parse_url( $item['link'] ) ) {
				$item['domain'] = $parsed['host'];
			}
			$items[$time] = $item;
		}
	}

	krsort( $items, SORT_NUMERIC );

	$r .= '<ul id="pp-project-activity-' . $data['slug'] . '" class="pp-project-activity"%s>';

	$count = 0;
	foreach ( $items as $item ) {
		$count++;
		if ( $count === 10 ) {
			break;
		}
		$datetime = sprintf( __( '%1$s on %2$s' ), date_i18n( get_option('time_format'), $item['time'] ), date_i18n( get_option( 'date_format' ), $item['time'] ) );
		$r .= '<li>' . wp_specialchars( $datetime ) . '<div><a href="' . attribute_escape( $item['link'] ) . '">' . wp_specialchars( strip_tags( html_entity_decode( $item['title'], ENT_QUOTES ) ) ) . '</a> <span class="domain">@' . wp_specialchars( $item['domain'] ) . '</span></div></li>';
	}

	$r .= '</ul>';

	return $r;
}

function pp_get_project_overheard( $category_id = 0 )
{
	if ( !$data = pp_get_project_data( $category_id ) ) {
		return;
	}

	if ( !isset($data['overheard']) || !$data['overheard'] ) {
		return;
	}

	require_once( ABSPATH . WPINC . '/rss.php' );

	$feeds = array();
	foreach ( $data['overheard'] as $feed_url ) {
		$feeds[] = fetch_rss( $feed_url );
	}

	$items = array();
	foreach ( $feeds as $feed ) {
		if ( !isset( $feed->items ) ) {
			continue;
		}
		foreach ( $feed->items as $item ) {
			$time = strtotime( $item['dc']['date'] );
			$item['time'] = $time;
			if ( $parsed = parse_url( $item['link'] ) ) {
				$item['domain'] = $parsed['host'];
			}
			$items[$time] = $item;
		}
	}

	krsort( $items, SORT_NUMERIC );

	$r .= '<ul id="pp-project-overheard-' . $data['slug'] . '" class="pp-project-overheard"%s>';

	$count = 0;
	foreach ( $items as $item ) {
		$count++;
		if ( $count === 10 ) {
			break;
		}
		$datetime = sprintf( __( '%1$s on %2$s' ), date_i18n( get_option('time_format'), $item['time'] ), date_i18n( get_option( 'date_format' ), $item['time'] ) );
		$r .= '<li>' . wp_specialchars( $datetime ) . '<div><a href="' . attribute_escape( $item['link'] ) . '">' . wp_specialchars( strip_tags( html_entity_decode( $item['title'], ENT_QUOTES ) ) ) . '</a> <span class="domain">@' . wp_specialchars( $item['domain'] ) . '</span></div></li>';
	}

	$r .= '</ul>';

	return $r;
}

function pp_project_feeds( $category_id = 0 )
{
	if ( !$data = pp_get_project_data( $category_id ) ) {
		return;
	}

	$r_nav = array(
		'activity' => '',
		'overheard' => ''
	);
	$r = array(
		'activity' => '',
		'overheard' => ''
	);

	if ( $activity = pp_get_project_activity( $category_id ) ) {
		$r_nav['activity'] = '<li%s>%s' . __('Recent activity', 'prologue-projects') . '%s</li>' . "\n";
		$r['activity'] = $activity;
	}

	if ( $overheard = pp_get_project_overheard( $category_id ) ) {
		$r_nav['overheard'] = '<li%s>%s' . __('Overheard', 'prologue-projects') . '%s</li>' . "\n";
		$r['overheard'] = $overheard;
	}

	if ( $activity ) {
		if ( $overheard ) {
			$r_nav['activity'] = sprintf( $r_nav['activity'], ' class="active"', '<a href="javascript:void(0);" onclick="pp_switch_feeds(\'pp-project-feeds-nav-' . $data['slug'] . '\', this, \'pp-project-activity-' . $data['slug'] . '\', \'pp-project-overheard-' . $data['slug'] . '\')">', '</a>' );
			$r_nav['overheard'] = sprintf( $r_nav['overheard'], '', '<a href="javascript:void(0);" onclick="pp_switch_feeds(\'pp-project-feeds-nav-' . $data['slug'] . '\', this, \'pp-project-overheard-' . $data['slug'] . '\', \'pp-project-activity-' . $data['slug'] . '\')">', '</a>' );
			$r['overheard'] = sprintf( $r['overheard'], ' style="display:none;"' );
		} else {
			$r_nav['activity'] = sprintf( $r_nav['activity'], ' class="active lonely"', '', '' );
			$r['activity'] = sprintf( $r['activity'], '' );
		}
	} elseif ( $overheard ) {
		$r_nav['overheard'] = sprintf( $r_nav['overheard'], ' class="active lonely"', '', '' );
		$r['overheard'] = sprintf( $r['overheard'], '' );
	} else {
		return;
	}

	echo '<ul id="pp-project-feeds-nav-' . $data['slug'] . '" class="pp-project-feeds-nav">' . $r_nav['activity'] . $r_nav['overheard'] . '</ul><div class="pp-project-feeds">' . $r['activity'] . $r['overheard'] . '</div>';
}

class PP_Walker_Category_Checklist extends Walker {
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

	function start_lvl(&$output, $depth, $args) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl(&$output, $depth, $args) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el(&$output, $category, $depth, $args) {
		extract($args);

		$output .= "\n<li id='category-$category->term_id'>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $args['input_name'] . '[' . $category->term_id . ']" id="in-category-' . $category->term_id . '"' . ( in_array( $category->term_id, $selected_cats ) ? ' checked="checked"' : "" ) . '/> ' . wp_specialchars( apply_filters( 'the_category', $category->name ) ) . '</label>';

		if ( isset( $args['user_project_role'] ) ) {
			$output .= '<label>' . __(' &mdash; role', 'prologue-projects') . ' <input name="' . $args['input_name'] . '_role[' . $category->term_id . ']" type="text" value="' . attribute_escape( $args['user_project_role'][$category->term_id][1] ) . '" /></label>';
		}
	}

	function end_el( &$output, $category, $depth, $args ) {
		$output .= '</li>' . "\n";
	}
}

function pp_project_checklist( $checked = false, $input_name = 'post_category' )
{
	$categories = pp_get_projects();

	$walker = new PP_Walker_Category_Checklist();
	$args = array();

	if ( $checked ) {
		$checked = (array) $checked;
		$args['selected_cats'] = $checked;
	} else {
		$args['selected_cats'] = array( absint( get_query_var( 'cat' ) ) );
	}

	if ( !$input_name ) {
		$input_name = 'post_category';
	}
	$args['input_name'] = $input_name;

	echo '<ul class="pp-update-categories">';
	echo call_user_func_array( array( &$walker, 'walk' ), array( $categories, 0, $args ) );
	echo '</ul>';
}

function pp_project_and_role_checklist( $user_id = 0, $checked = false, $input_name = 'post_category' )
{
	$categories = pp_get_projects();

	$walker = new PP_Walker_Category_Checklist();
	$args = array();

	if ( $checked ) {
		$checked = (array) $checked;
		$args['selected_cats'] = $checked;
	} else {
		$args['selected_cats'] = array( absint( get_query_var( 'cat' ) ) );
	}

	if ( !$input_name ) {
		$input_name = 'post_category';
	}
	$args['input_name'] = $input_name;

	global $blog_id;

	$args['user_project_role'] = get_usermeta( $user_id, 'prologue_projects_' . $blog_id );
	$args['user_project_role'] = $args['user_project_role'] ? $args['user_project_role'] : array();

	echo '<ul class="pp-update-categories">';
	echo call_user_func_array( array( &$walker, 'walk' ), array( $categories, 0, $args ) );
	echo '</ul>';
}

function pp_author_title()
{
	global $wp_query;
	if ( !isset( $wp_query->query_vars['author'] ) ) {
		return;
	}

	echo get_author_name( $wp_query->query_vars['author'] );
}

function pp_author_rss()
{
	global $wp_query;
	if ( !isset( $wp_query->query_vars['author'] ) ) {
		return;
	}

	if ( !$url = get_author_feed_link( $wp_query->query_vars['author'] ) ) {
		return;
	}

	$r = '<a ';
	$r .= 'id="pp-project-rss-' . $data['slug'] . '" ';
	$r .= 'class="pp-project-rss" ';
	$r .= 'href="' . attribute_escape( $url ) . '">';
	$r .= __( 'RSS', 'prologue-projects' );
	$r .= '</a>';

	echo $r;
}

function pp_the_projects( $before = 'Projects: ', $sep = ', ', $after = '' )
{
	$terms = get_the_terms( 0, 'category' );

	if ( is_wp_error( $terms ) ) {
		return;
	}

	if ( empty( $terms ) ) {
		return;
	}

	$term_links = array();
	foreach ( $terms as $term ) {
		if ( !pp_is_project( $term->term_id ) ) {
			continue;
		}
		$link = get_term_link( $term, 'category' );
		if ( is_wp_error( $link ) ) {
			continue;
		}
		$term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . '</a>';
	}
	if ( !count( $term_links ) ) {
		return;
	}

	echo $before . join( $sep, $term_links ) . $after;
}

function pp_the_question_status( $before = '', $pattern = '%s', $after = '' )
{
	$terms = get_the_terms( 0, 'category' );

	if ( is_wp_error( $terms ) ) {
		return;
	}

	if ( empty( $terms ) ) {
		return;
	}

	$status = false;
	foreach ( $terms as $term ) {
		if ( !pp_is_question_status( $term->term_id ) ) {
			continue;
		}
		$link = get_term_link( $term, 'category' );
		if ( is_wp_error( $link ) ) {
			continue;
		}
		$status = $term->name;
		break;
	}
	if ( !$status ) {
		return;
	}

	echo $before . sprintf( $pattern, $status ) . $after;
}

function pp_page_navigation()
{
	$newer = get_previous_posts_link( __( '&#x2190; Newer Posts', 'prologue-projects' ) );
	$older = get_next_posts_link( __( 'Older Posts &#x2192;', 'prologue-projects' ) );

	if ( !$newer && !$older ) {
		return;
	}

	$r = '<ul id="pp-page-navigation">';

	if ( $newer ) {
		$r .= '<li class="newer">' . $newer . '</li>';
	}

	if ( $older ) {
		$r .= '<li class="older">' . $older . '</li>';
	}

	$r .= '</ul><div class="pp-clear"></div>';
	echo $r;
}

function pp_maybe_insert_post()
{
	if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'post' ) {
		if ( ! is_user_logged_in() ) {
			auth_redirect();
		}

		if( !current_user_can( 'publish_posts' ) ) {
			$goback = add_query_arg( 'result', -2, wp_get_referer() );
			wp_redirect( $goback );
			exit;
		}

		check_admin_referer( 'pp-update' );

		$user_id		= $current_user->user_id;
		$post_content	= $_POST['posttext'];
		$tags			= $_POST['tags'];

		$char_limit		= 40;
		$post_title		= trim( strip_tags( $post_content ) );
		if( strlen( $post_title ) > $char_limit ) {
			$post_title = substr( $post_title, 0, $char_limit ) . ' ... ';
		}

		$categories = isset( $_POST['post_category'] ) ? $_POST['post_category'] : array();

		if ( !is_array( $categories ) ) {
			$categories = array( $categories );
		}

		if ( isset( $_POST['task_level'] ) ) {
			$categories[] = (int) $_POST['task_level'];
		}

		$options = pp_get_options();
		$category_updates_id = $options['category_updates'];
		$category_tasks_id = $options['category_tasks'];
		$category_questions_id = $options['category_questions'];
		$category_default_questions_status = $options['default_question_state'];

		if ( isset( $_GET['tasks'] ) ) {
			$type = 'tasks';
		} elseif ( isset( $_GET['questions'] ) ) {
			$type = 'questions';
		} else {
			$type = 'updates';
		}

		switch ( $type ) {
			case 'questions':
				if ( $category_questions_id ) {
					$categories[] = $category_questions_id;
					$categories[] = $category_default_questions_status;
				}
				break;
			case 'tasks':
				if ( $category_tasks_id ) {
					$categories[] = $category_tasks_id;
				}
				break;
			case 'updates':
			default:
				if ( $category_updates_id ) {
					$categories[] = $category_updates_id;
				}
				break;
		}

		$categories = array_filter($categories);

		$post_id = wp_insert_post( array(
			'post_author'	=> $user_id,
			'post_title'	=> $post_title,
			'post_content'	=> $post_content,
			'tags_input'	=> $tags,
			'post_status'	=> 'publish',
			'post_category'	=> $categories
		) );

		if ( !$post_id ) {
			$goback = add_query_arg( 'result', -1, wp_get_referer() );
		} else {
			$goback = add_query_arg( 'result', $post_id, wp_get_referer() );
		}
		wp_redirect( $goback );
		exit;
	}
}

require_once( 'functions-sidebars.php' );

// We can leave these out if we are not in the admin area
if ( defined( 'WP_ADMIN' ) && WP_ADMIN ) {
	require_once( 'functions-admin.php' );
}

?>