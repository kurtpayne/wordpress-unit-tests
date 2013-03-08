<?php





function pp_admin_init()
{
	register_column_headers( 'projects', array(
		'cb' => '<input type="checkbox" />',
		'name' => __('Name', 'prologue-projects'),
		'description' => __('Description', 'prologue-projects'),
		'slug' => __('Slug', 'prologue-projects'),
		'posts' => __('Posts', 'prologue-projects')
	) );

	// If we needed to load a javascript dependancy for the theme, this is how it should be done.
	//$template_dir = basename( dirname( __FILE__ ) );
	//wp_register_script( 'admin-projects', get_theme_root_uri() . '/' . $template_dir . '/js/projects.js', array('wp-lists'), '20090210' );
}
add_action( 'admin_init', 'pp_admin_init' );

// This stops the header from loading when running pp_admin_projects(), feels dirty.
function pp_admin_noheader()
{
	$_GET['noheader'] = true;
}
add_action( 'load-toplevel_page_prologue-projects', 'pp_admin_noheader' );

// Add admin menu and pages
function pp_admin_pages_add()
{
	add_object_page(
		__( 'Projects', 'prologue-projects' ),
		__( 'Projects', 'prologue-projects' ),
		'manage_categories',
		'prologue-projects',
		'pp_admin_projects',
		''
	);
	add_submenu_page(
		'prologue-projects',
		__( 'Edit', 'prologue-projects' ),
		__( 'Edit', 'prologue-projects' ),
		'manage_categories',
		'prologue-projects',
		'pp_admin_projects'
	);
	add_submenu_page(
		'prologue-projects',
		__( 'Settings', 'prologue-projects' ),
		__( 'Settings', 'prologue-projects' ),
		'manage_options',
		'prologue-projects-settings',
		'pp_admin_settings'
	);
}

add_action( 'admin_menu', 'pp_admin_pages_add' );

function pp_insert_project( $project_data, $wp_error = false )
{
	if ( !$project_category_id = pp_get_category_id( 'projects' ) ) {
		return false; // This shouldn't happen from the edit screen.
	}

	if ( isset( $project_data['project_parent'] ) && ( !$project_data['project_parent'] || -1 == $project_data['project_parent'] ) ) {
		unset( $project_data['project_parent'] );
	}

	$project_defaults = array(
		'project_ID'          => 0,
		'project_name'        => '',
		'project_description' => '',
		'project_nicename'    => '',
		'project_parent'      => $project_category_id,
		'project_website'     => '', // Meta
		'project_blog'        => '', // Meta
		'project_svn'         => '', // Meta
		'project_trac'        => '', // Meta
		'project_intertrac'   => '', // Meta
		'project_activity'    => '', // Meta
		'project_overheard'   => ''  // Meta
	);
	$project_data = wp_parse_args( $project_data, $project_defaults );

	$category_data = array(
		'cat_ID'               => $project_data['project_ID'],
		'cat_name'             => $project_data['project_name'],
		'category_description' => $project_data['project_description'],
		'category_nicename'    => $project_data['project_nicename'],
		'category_parent'      => $project_data['project_parent']
	);

	$category_id = wp_insert_category( $category_data, $wp_error );

	if ( !$wp_error && !$category_id ) {
		return false;
	}

	if ( $wp_error && is_wp_error( $category_id ) ) {
		return $cat_ID;
	}

	$project_meta = array();
	$project_meta['logo']      = $project_data['project_logo'];
	$project_meta['website']   = $project_data['project_website'];
	$project_meta['blog']      = $project_data['project_blog'];
	$project_meta['svn']       = $project_data['project_svn'];
	$project_meta['trac']      = $project_data['project_trac'];
	$project_meta['intertrac'] = $project_data['project_intertrac'];
	$project_meta['activity']  = $project_data['project_activity'];
	$project_meta['overheard'] = $project_data['project_overheard'];

	if ( $project_meta['activity'] ) {
		$project_meta['activity'] = str_replace( "\r", '', $project_meta['activity'] );
		$project_meta['activity'] = explode( "\n", $project_meta['activity'] );
		array_walk( $project_meta['activity'], create_function( '&$a', '$a = trim($a);' ) );
		$project_meta['activity'] = array_filter( $project_meta['activity'] );
	}

	if ( $project_meta['overheard'] ) {
		$project_meta['overheard'] = str_replace( "\r", '', $project_meta['overheard'] );
		$project_meta['overheard'] = explode( "\n", $project_meta['overheard'] );
		array_walk( $project_meta['overheard'], create_function( '&$a', '$a = trim($a);' ) );
		$project_meta['overheard'] = array_filter( $project_meta['overheard'] );
	}

	update_option( 'pp_project_meta_' . $category_id, $project_meta );

	return true;
}

function pp_update_project( $project_data )
{
	if ( !$project_category_id = pp_get_category_id( 'projects' ) ) {
		return false; // This shouldn't happen from the edit screen.
	}

	if ( isset( $project_data['project_parent'] ) && ( !$project_data['project_parent'] || -1 == $project_data['project_parent'] ) ) {
		$project_data['project_parent'] = $project_category_id;
	}

	$category_data = array(
		'cat_ID'               => $project_data['project_ID'],
		'cat_name'             => $project_data['project_name'],
		'category_description' => $project_data['project_description'],
		'category_nicename'    => $project_data['project_nicename'],
		'category_parent'      => $project_data['project_parent']
	);

	if ( !$category_id = wp_update_category( $category_data, false ) ) {
		return false;
	}

	$project_meta = array();
	$project_meta['logo']      = $project_data['project_logo'];
	$project_meta['website']   = $project_data['project_website'];
	$project_meta['blog']      = $project_data['project_blog'];
	$project_meta['svn']       = $project_data['project_svn'];
	$project_meta['trac']      = $project_data['project_trac'];
	$project_meta['intertrac'] = $project_data['project_intertrac'];
	$project_meta['activity']  = $project_data['project_activity'];
	$project_meta['overheard'] = $project_data['project_overheard'];

	if ( $project_meta['activity'] ) {
		$project_meta['activity'] = str_replace( "\r", '', $project_meta['activity'] );
		$project_meta['activity'] = explode( "\n", $project_meta['activity'] );
		array_walk( $project_meta['activity'], create_function( '&$a', '$a = trim($a);' ) );
		$project_meta['activity'] = array_filter( $project_meta['activity'] );
	}

	if ( $project_meta['overheard'] ) {
		$project_meta['overheard'] = str_replace( "\r", '', $project_meta['overheard'] );
		$project_meta['overheard'] = explode( "\n", $project_meta['overheard'] );
		array_walk( $project_meta['overheard'], create_function( '&$a', '$a = trim($a);' ) );
		$project_meta['overheard'] = array_filter( $project_meta['overheard'] );
	}

	if ( $current_project_meta = get_option( 'pp_project_meta_' . $category_id ) ) {
		$project_meta = array_merge( $current_project_meta, $project_meta );
	}

	update_option( 'pp_project_meta_' . $category_id, $project_meta );

	return $category_id;
}

function pp_delete_project( $project_id )
{
	if ( true !== wp_delete_category( $project_id ) ) {
		return false;
	}

	delete_option( 'pp_project_meta_' . $project_id );

	return true;
}

// Ugly copy of WordPress category_rows()
function pp_project_rows( $parent = 0, $level = 0, $categories = 0, $page = 1, $per_page = 20 )
{
	$count = 0;
	_pp_project_rows( $categories, $count, $parent, $level, $page, $per_page );
}

// Ugly copy of WordPress _category_rows()
function _pp_project_rows( $categories, &$count, $parent = 0, $level = 0, $page = 1, $per_page = 20 )
{
	if ( empty( $categories ) ) {
		$args = array('hide_empty' => 0);
		if ( !empty($_GET['s']) ) {
			$args['search'] = $_GET['s'];
		}
		$categories = get_categories( $args );
	}

	if ( !$categories ) {
		return false;
	}

	$children = _get_term_hierarchy( 'category' );

	$start = ( $page - 1 ) * $per_page;
	$end = $start + $per_page;
	$i = -1;
	ob_start();
	foreach ( $categories as $category ) {
		if ( $count >= $end ) {
			break;
		}

		$i++;

		if ( $category->parent != $parent ) {
			continue;
		}

		// If the page starts in a subtree, print the parents.
		if ( $count == $start && $category->parent > 0 ) {
			$my_parents = array();
			while ( $my_parent) {
				$my_parent = get_category( $my_parent );
				$my_parents[] = $my_parent;
				if ( !$my_parent->parent )
					break;
				$my_parent = $my_parent->parent;
			}
			$num_parents = count( $my_parents );
			while( $my_parent = array_pop( $my_parents ) ) {
				echo "\t" . _pp_project_row( $my_parent, $level - $num_parents );
				$num_parents--;
			}
		}

		if ( $count >= $start ) {
			echo "\t" . _pp_project_row( $category, $level );
		}

		unset( $categories[$i] ); // Prune the working set
		$count++;

		if ( isset( $children[$category->term_id] ) ) {
			_pp_project_rows( $categories, $count, $category->term_id, $level + 1, $page, $per_page );
		}
	}

	$output = ob_get_contents();
	ob_end_clean();

	echo $output;
}

// Ugly copy of WordPress _category_row()
function _pp_project_row( $category, $level, $name_override = false ) {
	static $row_class = '';

	$category = get_category( $category, OBJECT, 'display' );

	$default_cat_id = (int) get_option( 'default_category' );
	$pad = str_repeat( '&#8212; ', $level );
	$name = ( $name_override ? $name_override : $pad . ' ' . $category->name );
	$edit_link = "admin.php?page=prologue-projects&amp;action=edit&amp;project_ID=$category->term_id";
	if ( current_user_can( 'manage_categories' ) ) {
		$edit = "<a class='row-title' href='$edit_link' title='" . attribute_escape( sprintf( __( 'Edit "%s"', 'prologue-projects' ), $category->name ) ) . "'>" . attribute_escape( $name ) . '</a><br />';
		$actions = array();
		$actions['edit'] = '<a href="' . $edit_link . '">' . __( 'Edit', 'prologue-projects' ) . '</a>';
		if ( $default_cat_id != $category->term_id )
			$actions['delete'] = "<a class='submitdelete' href='" . wp_nonce_url("admin.php?page=prologue-projects&amp;action=delete&amp;project_ID=$category->term_id", 'delete-project_' . $category->term_id) . "' onclick=\"if ( confirm('" . js_escape(sprintf(__("You are about to delete this project '%s'\n 'Cancel' to stop, 'OK' to delete.", 'prologue-projects'), $category->name )) . "') ) { return true;}return false;\">" . __('Delete', 'prologue-projects') . "</a>";
		$action_count = count($actions);
		$i = 0;
		$edit .= '<div class="row-actions">';
		foreach ( $actions as $action => $link ) {
			++$i;
			( $i == $action_count ) ? $sep = '' : $sep = ' | ';
			$edit .= "<span class='$action'>$link$sep</span>";
		}
		$edit .= '</div>';
	} else {
		$edit = $name;
	}

	$row_class = 'alternate' == $row_class ? '' : 'alternate';
	$qe_data = get_category_to_edit($category->term_id);

	$category->count = number_format_i18n( $category->count );
	$posts_count = ( $category->count > 0 ) ? "<a href='edit.php?cat=$category->term_id'>$category->count</a>" : $category->count;
	$output = "<tr id='cat-$category->term_id' class='iedit $row_class'>";

	$columns = get_column_headers('projects');
	$hidden = get_hidden_columns('projects');
	foreach ( $columns as $column_name => $column_display_name ) {
		$class = "class=\"$column_name column-$column_name\"";

		$style = '';
		if ( in_array($column_name, $hidden) )
			$style = ' style="display:none;"';

		$attributes = "$class$style";

		switch ($column_name) {
			case 'cb':
				$output .= "<th scope='row' class='check-column'>";
				if ( $default_cat_id != $category->term_id ) {
					$output .= "<input type='checkbox' name='delete[]' value='$category->term_id' />";
				} else {
					$output .= "&nbsp;";
				}
				$output .= '</th>';
				break;
			case 'name':
				$output .= "<td $attributes>$edit";
				$output .= '<div class="hidden" id="inline_' . $qe_data->term_id . '">';
				$output .= '<div class="name">' . $qe_data->name . '</div>';
				$output .= '<div class="slug">' . $qe_data->slug . '</div>';
				$output .= '<div class="cat_parent">' . $qe_data->parent . '</div></div></td>';
				break;
			case 'description':
				$output .= "<td $attributes>$category->description</td>";
				break;
			case 'slug':
				$output .= "<td $attributes>$category->slug</td>";
				break;
			case 'posts':
				$attributes = 'class="posts column-posts num"' . $style;
				$output .= "<td $attributes>$posts_count</td>\n";
		}
	}
	$output .= '</tr>';

	return $output;
}

function pp_admin_projects()
{
	global $user_identity;

	$title = __( 'Edit Projects', 'prologue-projects' );

	if ( !$project_category_id = pp_get_category_id( 'projects' ) ) {
?>
<div class="wrap nosubsub">
<?php
			screen_icon();
?>
	<h2>
<?php
			echo wp_specialchars( $title );
?>
	</h2>
	<div id="message" class="updated"><p><?php _e( 'You must <a href="admin.php?page=prologue-projects-settings">assign an existing category</a> as the container for all projects.', 'prologue-projects' ); ?></p></div>
</div>
<?php
		return;
	}

	global $action;
	wp_reset_vars( array('action') );

	if ( isset( $_GET['action'] ) && isset( $_GET['delete'] ) && ( 'delete' == $_GET['action'] || 'delete' == $_GET['action2'] ) ) {
		$action = 'bulk-delete';
	}

	switch( $action ) {
		case 'addproject':
			check_admin_referer('add-project');

			if ( !current_user_can( 'manage_categories' ) ) {
				wp_die( __( 'Cheatin&#8217; uh?', 'prologue-projects' ) );
			}

			if ( pp_insert_project( $_POST ) ) {
				wp_redirect( 'admin.php?page=prologue-projects&message=1#addproject' );
			} else {
				wp_redirect( 'admin.php?page=prologue-projects&message=4#addproject' );
			}
			exit;
			break;

		case 'delete':
			$project_ID = (int) $_GET['project_ID'];
			check_admin_referer('delete-project_' .  $project_ID);

			if ( !current_user_can( 'manage_categories' ) ) {
				wp_die( __( 'Cheatin&#8217; uh?', 'prologue-projects' ) );
			}

			$project_name = get_catname( $project_ID );

			// Don't delete the default cats.
    		if ( $project_ID == get_option( 'default_category' ) ) {
				wp_die( sprintf( __( "Can&#8217;t delete the <strong>%s</strong> category: this is the default one", 'prologue-projects' ), $cat_name ) );
			}

			pp_delete_project( $project_ID );

			wp_redirect( 'admin.php?page=prologue-projects&message=2' );
			exit;
			break;

		case 'bulk-delete':
			check_admin_referer( 'bulk-projects' );
echo 1;
			if ( !current_user_can( 'manage_categories' ) ) {
				wp_die( __( 'You are not allowed to delete projects.', 'prologue-projects' ) );
			}

			foreach ( (array) $_GET['delete'] as $project_ID ) {
				$project_name = get_catname( $project_ID );

				// Don't delete the default cats.
				if ( $project_ID == get_option( 'default_category' ) ) {
					wp_die( sprintf( __( "Can&#8217;t delete the <strong>%s</strong> category: this is the default one", 'prologue-projects' ), $cat_name ) );
				}

				pp_delete_project( $project_ID );
			}

			$sendback = wp_get_referer();

			wp_redirect( $sendback );
			exit;
			break;

		case 'edit':
			if ( !current_user_can( 'manage_categories' ) ) {
				wp_die( __( 'You are not allowed to edit projects.', 'prologue-projects' ) );
			}

			$title = __( 'Edit Project', 'prologue-projects' );

			require_once( 'admin-header.php' );
			$project_ID = (int) $_GET['project_ID'];
			$project = pp_get_project_data( $project_ID, 'all', 'editing' );
?>

<div class="wrap nosubsub">
<?php
			screen_icon();
?>

	<h2><?php echo wp_specialchars( $title ); ?></h2>

<?php
			if ( isset($_GET['message']) && ( $msg = (int) $_GET['message'] ) ) {
?>

	<div id="message" class="updated fade"><p><?php echo $messages[$msg]; ?></p></div>

<?php
				$_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
			}
?>

			<div class="wrap">
				<div id="ajax-response"></div>
				<form name="addproject" id="editproject" method="post" action="admin.php?page=prologue-projects" class="validate">
					<input type="hidden" name="action" value="editedproject" />
					<input type="hidden" name="project_ID" value="<?php echo $project['id']; ?>" />
					<?php wp_original_referer_field( true, 'previous' ); ?>
					<?php wp_nonce_field( 'update-project_' . $project['id'] ); ?>

					<table class="form-table">
						<tr class="form-field form-required">
							<th scope="row" valign="top"><label for="project_name"><?php _e( 'Project Name', 'prologue-projects' ) ?></label></th>
							<td><input name="project_name" id="project_name" type="text" value="<?php echo attribute_escape( $project['name'] ); ?>" size="40" aria-required="true" /><br />
							<span class="setting-description"><?php _e( 'The name is used to identify the project almost everywhere, for example under the post or in the project widgets.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_nicename"><?php _e( 'Project Slug', 'prologue-projects' ) ?></label></th>
							<td><input name="project_nicename" id="project_nicename" type="text" value="<?php echo attribute_escape( $project['slug'] ); ?>" size="40" /><br />
							<span class="setting-description"><?php _e( 'The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_parent"><?php _e( 'Project Parent', 'prologue-projects' ) ?></label></th>
							<td><?php wp_dropdown_categories( array( 'child_of' => $project_category_id, 'hide_empty' => 0, 'name' => 'project_parent', 'orderby' => 'name', 'selected' => $project['parent_id'], 'hierarchical' => true, 'show_option_none' => __( 'None', 'prologue-projects' ) ) ); ?><br />
							<span class="setting-description"><?php _e( 'Projects, can have a hierarchy. You might have an event project, and under that have sub-projects for catering and merchandise. Totally optional.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_description"><?php _e( 'Description', 'prologue-projects' ) ?></label></th>
							<td><textarea name="project_description" id="project_description" rows="5" cols="40"><?php echo wp_specialchars( $project['description'] ); ?></textarea><br />
							<span class="setting-description"><?php _e( 'The description is displayed on each project page.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_logo"><?php _e( 'Project Logo', 'prologue-projects' ) ?></label></th>
							<td><input name="project_logo" id="project_logo" type="text" value="<?php echo attribute_escape( $project['logo'] ); ?>" size="255" /><br />
							<span class="setting-description"><?php _e( 'The project\'s logo. Must be a full URL of an image. Maximum size of 64px x 64px is recommended.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_website"><?php _e( 'Project Website', 'prologue-projects' ) ?></label></th>
							<td><input name="project_website" id="project_website" type="text" value="<?php echo attribute_escape( $project['website'] ); ?>" size="255" /><br />
							<span class="setting-description"><?php _e( 'The project\'s external website. Must be a full URL.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_blog"><?php _e( 'Project Blog', 'prologue-projects' ) ?></label></th>
							<td><input name="project_blog" id="project_blog" type="text" value="<?php echo attribute_escape( $project['blog'] ); ?>" size="255" /><br />
							<span class="setting-description"><?php _e( 'The project\'s external blog. Must be a full URL.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_svn"><?php _e( 'Project Subversion Repository', 'prologue-projects' ) ?></label></th>
							<td><input name="project_svn" id="project_svn" type="text" value="<?php echo attribute_escape( $project['svn'] ); ?>" size="255" /><br />
							<span class="setting-description"><?php _e( 'The location of the project\'s Subversion repository. This is only common in software projects.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_trac"><?php _e( 'Project Trac Installation', 'prologue-projects' ) ?></label></th>
							<td><input name="project_trac" id="project_trac" type="text" value="<?php echo attribute_escape( $project['trac'] ); ?>" size="255" /><br />
							<span class="setting-description"><?php _e( 'The location of the project\'s Trac ticketing website. This is only common in software projects.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_intertrac"><?php _e( 'Project InterTrac Code', 'prologue-projects' ) ?></label></th>
							<td><input name="project_intertrac" id="project_intertrac" type="text" value="<?php echo attribute_escape( $project['intertrac'] ); ?>" size="255" /><br />
							<span class="setting-description"><?php _e( 'This code allows users to distinguish between different Trac installations in the same update. This is only common in software projects.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_activity"><?php _e( 'Project Activity Feeds', 'prologue-projects' ) ?></label></th>
							<td><textarea name="project_activity" id="project_activity" rows="5" cols="40"><?php echo wp_specialchars( join( "\n", stripslashes_deep( $project['activity'] ) ) ); ?></textarea><br />
							<span class="setting-description"><?php _e( 'Specify a list of feeds you wish to aggregate into the projects "activity" sidebar. One feed per line. Activity reported by Trac is automatically included here.', 'prologue-projects' ); ?></span></td>
						</tr>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="project_overheard"><?php _e( 'Project Overheard Feeds', 'prologue-projects' ) ?></label></th>
							<td><textarea name="project_overheard" id="project_overheard" rows="5" cols="40"><?php echo wp_specialchars( join( "\n", stripslashes_deep( $project['overheard'] ) ) ); ?></textarea><br />
							<span class="setting-description"><?php _e( 'Specify a list of feeds you wish to aggregate into the projects "overheard" sidebar. One feed per line.', 'prologue-projects' ); ?></span></td>
						</tr>
					</table>

					<p class="submit"><input type="submit" class="button" name="submit" value="<?php _e( 'Update Project', 'prologue-projects' ); ?>" /></p>
				</form>
			</div><!-- /wrap -->



<?php
			break;

		case 'editedproject':
			$project_ID = (int) $_POST['project_ID'];
			check_admin_referer('update-project_' . $project_ID);

			if ( !current_user_can( 'manage_categories' ) ) {
				wp_die( __( 'Cheatin&#8217; uh?', 'prologue-projects' ) );
			}

			$location = 'admin.php?page=prologue-projects';
			if ( $referer = wp_get_original_referer() ) {
				if ( false !== strpos( $referer, 'admin.php') ) {
					$location = $referer;
				}
			}

			if ( pp_update_project( $_POST ) ) {
				$location = add_query_arg( 'message', 3, $location );
			} else {
				$location = add_query_arg( 'message', 5, $location );
			}

			wp_redirect( $location );
			exit;
			break;

		default:
			if ( isset( $_GET['_wp_http_referer'] ) && !empty( $_GET['_wp_http_referer'] ) ) {
				wp_redirect( remove_query_arg( array( '_wp_http_referer', '_wpnonce' ), stripslashes( $_SERVER['REQUEST_URI'] ) ) );
				exit;
			}

			require_once( 'admin-header.php' );

			$messages[1] = __( 'Project added.', 'prologue-projects' );
			$messages[2] = __( 'Project deleted.', 'prologue-projects' );
			$messages[3] = __( 'Project updated.', 'prologue-projects' );
			$messages[4] = __( 'Project not added.', 'prologue-projects' );
			$messages[5] = __( 'Project not updated.', 'prologue-projects' );
?>

<div class="wrap nosubsub">
<?php
			screen_icon();
?>
	<h2>
<?php
			echo wp_specialchars( $title );
			if ( isset( $_GET['s'] ) && $_GET['s'] ) {
				printf( '<span class="subtitle">' . __( 'Search results for &#8220;%s&#8221;', 'prologue-projects' ) . '</span>', wp_specialchars( stripslashes( $_GET['s'] ) ) );
			}
?>
	</h2>

<?php
			if ( isset($_GET['message']) && ( $msg = (int) $_GET['message'] ) ) {
?>
	<div id="message" class="updated fade"><p><?php echo $messages[$msg]; ?></p></div>
<?php
				$_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
			}
?>

	<form class="search-form topmargin" action="" method="get">
		<p class="search-box">
			<label class="hidden" for="project-search-input"><?php _e( 'Search Projects', 'prologue-projects' ); ?>:</label>
			<input type="text" class="search-input" id="project-search-input" name="s" value="<?php _admin_search_query(); ?>" />
			<input type="hidden" name="page" value="prologue-projects" />
			<input type="submit" value="<?php _e( 'Search Projects', 'prologue-projects' ); ?>" class="button" />
		</p>
	</form><br class="clear" />

	<div id="col-container">
		<div id="col-right">
			<div class="col-wrap">
				<form id="posts-filter" action="" method="get">
					<input type="hidden" name="page" value="prologue-projects" />
					<div class="tablenav">

<?php
			$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 0;
			if ( empty( $pagenum ) ) {
				$pagenum = 1;
			}
			if( !isset( $projectsperpage ) || $projectsperpage < 0 ) {
				$projectsperpage = 20;
			}

			$projectstotal = count( pp_get_projects() );

			$page_links = paginate_links( array(
				'base' => add_query_arg( 'pagenum', '%#%' ),
				'format' => '',
				'prev_text' => __('&laquo;', 'prologue-projects'),
				'next_text' => __('&raquo;', 'prologue-projects'),
				'total' => ceil( $projectstotal / $projectsperpage ),
				'current' => $pagenum
			));

			if ( $page_links ) {
?>

						<div class="tablenav-pages"><?php echo $page_links; ?></div>

<?php
			}
?>

						<div class="alignleft actions">
							<select name="action">
								<option value="" selected="selected"><?php _e('Bulk Actions', 'prologue-projects'); ?></option>
								<option value="delete"><?php _e('Delete', 'prologue-projects'); ?></option>
							</select>
							<input type="submit" value="<?php _e('Apply', 'prologue-projects'); ?>" name="doaction" id="doaction" class="button-secondary action" />
							<?php wp_nonce_field('bulk-projects'); ?>
						</div>

						<br class="clear" />
					</div>

					<div class="clear"></div>

					<table class="widefat fixed" cellspacing="0">
						<thead>
							<tr>

<?php
			print_column_headers( 'projects' );
?>

							</tr>
						</thead>

						<tfoot>
							<tr>

<?php
			print_column_headers( 'projects', false );
?>

							</tr>
						</tfoot>

						<tbody id="the-list" class="list:projects">

<?php
			pp_project_rows( $project_category_id, 0, 0, $pagenum, $projectsperpage );
?>

						</tbody>
					</table>

					<div class="tablenav">

<?php
			if ( $page_links ) {
?>

						<div class="tablenav-pages"><?php echo $page_links; ?></div>

<?php
			}
?>

						<div class="alignleft actions">
							<select name="action2">
								<option value="" selected="selected"><?php _e('Bulk Actions', 'prologue-projects'); ?></option>
								<option value="delete"><?php _e('Delete', 'prologue-projects'); ?></option>
							</select>
							<input type="submit" value="<?php _e( 'Apply', 'prologue-projects' ); ?>" name="doaction2" id="doaction2" class="button-secondary action" />
							<?php wp_nonce_field( 'bulk-projects' ); ?>
						</div>

						<br class="clear" />
					</div>
				</form>

				<div class="form-wrap">
					<p><?php _e( '<strong>Note:</strong><br />Deleting a project does not delete the posts in that project.', 'prologue-projects' ); ?></p>
				</div>
			</div>
		</div><!-- /col-right -->

		<div id="col-left">
			<div class="col-wrap">

<?php
			if ( current_user_can( 'manage_categories' ) ) {
?>

				<div class="form-wrap">
					<h3><?php _e( 'Add Project', 'prologue-projects' ); ?></h3>
					<div id="ajax-response"></div>
					<form name="addproject" id="addproject" method="post" action="admin.php?page=prologue-projects" class="add:the-list: validate">
						<input type="hidden" name="action" value="addproject" />
						<?php wp_original_referer_field( true, 'previous' ); ?>
						<?php wp_nonce_field('add-project'); ?>

						<div class="form-field form-required">
							<label for="project_name"><?php _e( 'Project Name', 'prologue-projects' ) ?></label>
							<input name="project_name" id="project_name" type="text" value="" size="40" aria-required="true" />
							<p><?php _e( 'The name is used to identify the project almost everywhere, for example under the post or in the project widgets.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_nicename"><?php _e( 'Project Slug', 'prologue-projects' ) ?></label>
							<input name="project_nicename" id="project_nicename" type="text" value="" size="40" />
							<p><?php _e( 'The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_parent"><?php _e( 'Project Parent', 'prologue-projects' ) ?></label>
							<?php wp_dropdown_categories( array( 'child_of' => $project_category_id, 'hide_empty' => 0, 'name' => 'project_parent', 'orderby' => 'name', 'selected' => 0, 'hierarchical' => true, 'show_option_none' => __( 'None', 'prologue-projects' ) ) ); ?>
							<p><?php _e( 'Projects, can have a hierarchy. You might have an event project, and under that have sub-projects for catering and merchandise. Totally optional.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_description"><?php _e( 'Description', 'prologue-projects' ) ?></label>
							<textarea name="project_description" id="project_description" rows="5" cols="40"></textarea>
							<p><?php _e( 'The description is displayed on each project page.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_logo"><?php _e( 'Project Logo', 'prologue-projects' ) ?></label>
							<input name="project_logo" id="project_logo" type="text" value="" size="255" />
							<p><?php _e( 'The project\'s logo. Must be a full URL of an image. Maximum size of 64px x 64px is recommended.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_website"><?php _e( 'Project Website', 'prologue-projects' ) ?></label>
							<input name="project_website" id="project_website" type="text" value="" size="255" />
							<p><?php _e( 'The project\'s external website. Must be a full URL.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_blog"><?php _e( 'Project Blog', 'prologue-projects' ) ?></label>
							<input name="project_blog" id="project_blog" type="text" value="" size="255" />
							<p><?php _e( 'The project\'s external blog. Must be a full URL.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_svn"><?php _e( 'Project Subversion Repository', 'prologue-projects' ) ?></label>
							<input name="project_svn" id="project_svn" type="text" value="" size="255" />
							<p><?php _e( 'The location of the project\'s Subversion repository. This is only common in software projects.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_trac"><?php _e( 'Project Trac Installation', 'prologue-projects' ) ?></label>
							<input name="project_trac" id="project_trac" type="text" value="" size="255" />
							<p><?php _e( 'The location of the project\'s Trac ticketing website. This is only common in software projects.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_intertrac"><?php _e( 'Project InterTrac Code', 'prologue-projects' ) ?></label>
							<input name="project_intertrac" id="project_intertrac" type="text" value="" size="255" />
							<p><?php _e( 'This code allows users to distinguish between different Trac installations in the same update. This is only common in software projects.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_activity"><?php _e( 'Project Activity Feeds', 'prologue-projects' ) ?></label>
							<textarea name="project_activity" id="project_activity" rows="5" cols="40"></textarea>
							<p><?php _e( 'Specify a list of feeds you wish to aggregate into the projects "activity" sidebar. One feed per line. Activity reported by Trac is automatically included here.', 'prologue-projects' ); ?></p>
						</div>

						<div class="form-field">
							<label for="project_overheard"><?php _e( 'Project Overheard Feeds', 'prologue-projects' ) ?></label>
							<textarea name="project_overheard" id="project_overheard" rows="5" cols="40"></textarea>
							<p><?php _e( 'Specify a list of feeds you wish to aggregate into the projects "overheard" sidebar. One feed per line.', 'prologue-projects' ); ?></p>
						</div>

						<p class="submit"><input type="submit" class="button" name="submit" value="<?php _e( 'Add Project', 'prologue-projects' ); ?>" /></p>
					</form>
				</div>

<?php
			}
?>

			</div>
		</div><!-- /col-left -->
	</div><!-- /col-container -->
</div><!-- /wrap -->

<script type="text/javascript">
/* <![CDATA[ */
(function($){
	$(document).ready(function(){
		$('#doaction, #doaction2').click(function(){
			if ( $('select[name^="action"]').val() == 'delete' ) {
				var m = '<?php echo js_escape( __( "You are about to delete the selected projects.\n  'Cancel' to stop, 'OK' to delete.", 'prologue-projects' ) ); ?>';
				return showNotice.warn(m);
			}
		});
	});
})(jQuery);
/* ]]> */
</script>

<?php
			break;
	}
}

function pp_admin_settings_process()
{
	if ( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' && $_POST['option_page'] == 'prologue-projects-settings' ) {
		check_admin_referer( 'prologue-projects-settings' );

		$project_sidebars = ( isset( $_POST['project_sidebars'] ) && $_POST['project_sidebars'] > 0 ) ? true : false;
		$author_sidebars  = ( isset( $_POST['author_sidebars'] )  && $_POST['author_sidebars']  > 0 ) ? true : false;

		$_options = array(
			'category_projects'      => (int)  $_POST['category_projects'],
			'featured_project'       => (int)  $_POST['featured_project'],
			'project_sidebars'       => (bool) $project_sidebars,
			'category_updates'       => (int)  $_POST['category_updates'],
			'category_tasks'         => (int)  $_POST['category_tasks'],
			'default_task_level'     => (int)  $_POST['default_task_level'],
			'category_questions'     => (int)  $_POST['category_questions'],
			'default_question_state' => (int)  $_POST['default_question_state'],
			'author_sidebars'        => (bool) $author_sidebars
		);
		update_option( 'prologue_projects', $_options );

		$goback = add_query_arg( 'updated', 'true', wp_get_referer() );
		wp_redirect( $goback );
		return;
	}
}

function pp_admin_empty_category_alert( $dropdown )
{
	if ( !$dropdown ) {
		return __( '<em>No categories exist under the parent category specified above.</em>', 'prologue-projects' );
	}

	return $dropdown;
}

function pp_admin_settings()
{
	$options = pp_get_options();
	
	add_filter( 'wp_dropdown_cats', 'pp_admin_empty_category_alert' );
?>
<div class="wrap">
	<h2><?php _e( 'Project Settings', 'prologue-projects' ); ?></h2>
	<form method="post" action="admin.php?page=prologue-projects-settings">
		<?php wp_nonce_field('prologue-projects-settings'); ?>
		<input type="hidden" name="option_page" value="prologue-projects-settings" />
		<h3><?php _e( 'Projects', 'prologue-projects' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="category_projects"><?php _e( 'Projects category', 'prologue-projects' ) ?></label></th>
				<td>
					<?php wp_dropdown_categories( array( 'show_option_none' => __('-- select --', 'prologue-projects'), 'hide_empty' => 0, 'name' => 'category_projects', 'orderby' => 'name', 'selected' => $options['category_projects'], 'hierarchical' => true ) ); ?><br />
					<span class="setting-description"><?php _e( 'Select the category which contains all your projects.', 'prologue-projects' ); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="featured_project"><?php _e( 'Featured project', 'prologue-projects' ) ?></label></th>
				<td>
<?php
	if ( $project_category_id = pp_get_category_id( 'projects' ) ) {
?>
					<?php wp_dropdown_categories( array( 'show_option_none' => __( '-- select --', 'prologue-projects' ), 'child_of' => $project_category_id, 'hide_empty' => 0, 'name' => 'featured_project', 'orderby' => 'name', 'selected' => $options['featured_project'], 'hierarchical' => true ) ); ?><br />
					<span class="setting-description"><?php _e( 'Select the project to be featured on the projects base page.', 'prologue-projects' ); ?></span>
<?php
	} else {
?>
					<span class="setting-description"><?php _e( 'You must select and save the "projects" category above first.', 'prologue-projects' ); ?></span>
<?php
	}
?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="project_sidebars"><?php _e( 'Create project sidebars', 'prologue-projects' ) ?></label></th>
				<td>
<?php
	$project_sidebars_checked = $options['project_sidebars'] ? 'checked="checked" ' : '';
?>
					<input id="project_sidebars" name="project_sidebars" type="checkbox" value="1" <?php echo $project_sidebars_checked; ?>/>
					<?php _e( 'Create unique widget areas for each project\'s page.', 'prologue-projects' ); ?>
				</td>
			</tr>
		</table>
		<h3><?php _e( 'Updates', 'prologue-projects' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="category_updates"><?php _e( 'Updates category', 'prologue-projects' ) ?></label></th>
				<td>
					<?php wp_dropdown_categories( array( 'show_option_none' => __('-- select --', 'prologue-projects'), 'hide_empty' => 0, 'name' => 'category_updates', 'orderby' => 'name', 'selected' => $options['category_updates'], 'hierarchical' => true ) ); ?><br />
					<span class="setting-description"><?php _e( 'Select the category which will contain updates.', 'prologue-projects' ); ?></span>
				</td>
			</tr>
		</table>
		<h3><?php _e( 'Tasks', 'prologue-projects' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="category_tasks"><?php _e( 'Tasks category', 'prologue-projects' ) ?></label></th>
				<td>
					<?php wp_dropdown_categories( array( 'show_option_none' => __('-- select --', 'prologue-projects'), 'hide_empty' => 0, 'name' => 'category_tasks', 'orderby' => 'name', 'selected' => $options['category_tasks'], 'hierarchical' => true ) ); ?><br />
					<span class="setting-description"><?php _e( 'Select the category which will contain tasks.', 'prologue-projects' ); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="default_task_level"><?php _e( 'Default task level', 'prologue-projects' ) ?></label></th>
				<td>
<?php
	if ( $task_category_id = pp_get_category_id( 'tasks' ) ) {
?>
					<?php wp_dropdown_categories( array( 'show_option_none' => __('-- select --', 'prologue-projects'), 'child_of' => $task_category_id, 'hide_empty' => 0, 'name' => 'default_task_level', 'orderby' => 'name', 'selected' => $options['default_task_level'], 'hierarchical' => true ) ); ?><br />
					<span class="setting-description"><?php _e( 'Select the level which new tasks will be set to by default.', 'prologue-projects' ); ?></span>
<?php
	} else {
?>
					<span class="setting-description"><?php _e( 'You must select and save the "tasks" category above first.', 'prologue-projects' ); ?></span>
<?php
	}
?>
				</td>
			</tr>
		</table>
		<h3><?php _e( 'Questions', 'prologue-projects' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="category_questions"><?php _e( 'Questions category', 'prologue-projects' ) ?></label></th>
				<td>
					<?php wp_dropdown_categories( array( 'show_option_none' => __('-- select --', 'prologue-projects'), 'hide_empty' => 0, 'name' => 'category_questions', 'orderby' => 'name', 'selected' => $options['category_questions'], 'hierarchical' => true ) ); ?><br />
					<span class="setting-description"><?php _e( 'Select the category which will contain questions.', 'prologue-projects' ); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="default_question_state"><?php _e( 'Default question state', 'prologue-projects' ) ?></label></th>
				<td>
<?php
	if ( $question_category_id = pp_get_category_id( 'questions' ) ) {
?>
					<?php wp_dropdown_categories( array( 'show_option_none' => __('-- select --', 'prologue-projects'), 'child_of' => $question_category_id, 'hide_empty' => 0, 'name' => 'default_question_state', 'orderby' => 'name', 'selected' => $options['default_question_state'], 'hierarchical' => true ) ); ?><br />
					<span class="setting-description"><?php _e( 'Select the state which new questions will be set to by default.', 'prologue-projects' ); ?></span>
<?php
	} else {
?>
					<span class="setting-description"><?php _e( 'You must select and save the "questions" category above first.', 'prologue-projects' ); ?></span>
<?php
	}
?>
				</td>
			</tr>
		</table>
		<h3><?php _e( 'Authors', 'prologue-projects' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="author_sidebars"><?php _e( 'Create author sidebars', 'prologue-projects' ) ?></label></th>
				<td>
<?php
	$author_sidebars_checked = $options['author_sidebars'] ? 'checked="checked" ' : '';
?>
					<input id="author_sidebars" name="author_sidebars" type="checkbox" value="1" <?php echo $author_sidebars_checked; ?>/>
					<?php _e( 'Create unique widget areas for each author\'s page.', 'prologue-projects' ); ?>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input class="button-primary" type="submit" name="Submit" value="<?php _e( 'Save Changes', 'prologue-projects' ); ?>" />
			<input type="hidden" name="action" value="update" />
		</p>
	</form>
</div>
<?php
}

add_action( 'admin_init', 'pp_admin_settings_process' );


function pp_admin_user_form()
{
	global $profileuser, $blog_id;
	$checked = array();
	$meta = 'prologue_projects_' . $blog_id;
	$projects = maybe_unserialize( $profileuser->$meta );
	foreach ( $projects as $project_id => $project_data ) {
		if ( $project_data[0] ) {
			$checked[] = $project_id;
		}
	}
	$input_name = 'prologue_projects';

	global $is_profile_page;
	if ( $is_profile_page ) {
		$heading = __( 'Your projects', 'prologue-projects' );
		$instruction = __( 'Select the projects which the you participate in. You will be listed on each projects page.', 'prologue-projects' );
	} else {
		$heading = __( 'The user\'s projects', 'prologue-projects' );
		$instruction = __( 'Select the projects which the user participates in. They will be listed on each projects page.', 'prologue-projects' );
	}
?>
<h3><?php echo $heading; ?></h3>
<table class="form-table">
	<tr>
		<th><?php _e( 'Available Projects', 'prologue-projects' ); ?></th>
		<td>
			<?php pp_project_and_role_checklist( $profileuser->id, $checked, $input_name ); ?>
			<?php echo $instruction; ?>
		</td>
	</tr>
</table>
<?php
}

add_action( 'show_user_profile', 'pp_admin_user_form' );
add_action( 'edit_user_profile', 'pp_admin_user_form' );


function pp_admin_user_form_process()
{
	global $user_id, $blog_id;
	$project_active_ids = stripslashes_deep( $_POST['prologue_projects'] );
	$project_roles = stripslashes_deep( $_POST['prologue_projects_role'] );

	$projects = array();
	foreach ( $project_roles as $project_id => $project_role ) {
		$project_active = isset( $project_active_ids[ $project_id ] ) ? 1 : 0;
		$projects[$project_id] = array(
			$project_active,
			$project_role
		);
	}

	update_usermeta( $user_id, 'prologue_projects_' . $blog_id, $projects );
}

add_action( 'personal_options_update', 'pp_admin_user_form_process' );
add_action( 'edit_user_profile_update', 'pp_admin_user_form_process' );

function pp_admin_head()
{
?>

<style type="text/css" media="screen">
	.pp-update-categories li ul { margin-top: 5px; margin-left: 20px; }
</style>

<?php
}

add_action( 'admin_head', 'pp_admin_head' );

?>