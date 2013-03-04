<?php
function pp_generate_sidebars()
{
	register_sidebar( array(
		'name' => 'All - Top',
		'id' => 'pp-sidebar-top',
		'before_widget' => '<li id="%1$s" class="widget pp-sidebar-top %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => 'Home',
		'id' => 'pp-home-sidebar',
		'before_widget' => '<li id="%1$s" class="widget pp-home-sidebar %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => 'Single post page',
		'id' => 'pp-single-sidebar',
		'before_widget' => '<li id="%1$s" class="widget pp-single-sidebar %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => 'Project (default)',
		'id' => 'pp-project-sidebar-default',
		'before_widget' => '<li id="%1$s" class="widget pp-project-sidebar pp-project-sidebar-all %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	) );

	$options = pp_get_options();

	if ( $options['project_sidebars'] && $projects = pp_get_projects() ) {
		foreach ( $projects as $project ) {
			register_sidebar( array(
				'name' => 'Project - ' . $project->name,
				'id' => 'pp-project-sidebar-' . $project->cat_ID,
				'before_widget' => '<li id="%1$s" class="widget pp-project-sidebar pp-project-sidebar-' . $project->cat_ID . ' %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>'
			) );
		}
	}

	register_sidebar( array(
		'name' => 'Author (default)',
		'id' => 'pp-author-sidebar-default',
		'before_widget' => '<li id="%1$s" class="widget pp-author-sidebar pp-author-sidebar-all %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	) );

	// Todo: cache the author array
	$authors = array();
	if ( $options['author_sidebars'] && $users = get_users_of_blog() ) {
		foreach ( $users as $user ) {
			$user_object = new WP_User( $user->user_id );
			if ( !$user_object->has_cap( 'publish_posts' ) ) {
				continue;
			}
			$authors[] = $user;
		}
	}

	foreach ( $authors as $author ) {
		register_sidebar( array(
			'name' => 'Author - ' . $author->display_name,
			'id' => 'pp-author-sidebar-' . $author->user_id,
			'before_widget' => '<li id="%1$s" class="widget pp-author-sidebar pp-author-sidebar-' . $author->user_id . ' %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>'
		) );
	}

	register_sidebar( array(
		'name' => 'All - Bottom',
		'id' => 'pp-sidebar-bottom',
		'before_widget' => '<li id="%1$s" class="widget pp-sidebar-bottom %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	) );
}

class PP_Widget_Project_Tree
{
	var $options;

	function PP_Widget_Project_Tree()
	{
		if ( !$this->options = get_option( 'pp_widget_project_tree' ) ) {
			$this->options = array();
		}

		add_action( 'widgets_init', array( $this, 'init' ) );
	}

	function init()
	{
		$widget_options = array(
			'classname' => 'pp-widget-project-tree',
			'description' => __( 'Display projects in a navigable tree', 'prologue-projects' )
		);

		$control_options = array(
			'height' => 350,
			'id_base' => 'pp-widget-project-tree'
		);

		if ( !count($this->options) ) {
			$options = array(-1 => false);
		} else {
			$options = $this->options;
		}
		foreach ( $options as $instance => $option ) {
			wp_register_sidebar_widget(
				'pp-widget-project-tree-' . $instance,
				__('Project Tree', 'prologue-projects'),
				array($this, 'display'),
				$widget_options,
				array( 'number' => $instance )
			);

			wp_register_widget_control(
				'pp-widget-project-tree-' . $instance,
				__('Project Tree', 'prologue-projects'),
				array($this, 'control'),
				$control_options,
				array( 'number' => $instance )
			);
		}
	}

	function display( $args, $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric( $instance ) || 1 > $instance ) {
			return;
		}

		extract( $args );

		$parent_type = $this->options[$instance]['parent'] ? $this->options[$instance]['parent'] : 'all';

		$parent_id = ( pp_is_project() && $parent_type == 'sub') ? pp_get_project_data( 0, 'id' ) : 0;

		if ( $parent_id === false ) {
			return;
		}

		$categories = pp_get_projects( $parent_id );

		if ( !$categories ) {
			return;
		}

		$walker = new Walker_Category();

		echo $before_widget;

		if ( $parent_type == 'sub' && $parent_id !== 0 ) {
			$title = __( 'Sub-projects', 'prologue-projects' );
		} else {
			$title = __( 'Projects', 'prologue-projects' );
		}

		$title = $this->options[$instance]['title'] ? $this->options[$instance]['title'] : $title;

		echo $before_title;
		echo $title;
		echo $after_title;

		echo '<ul>';
		echo call_user_func_array( array( &$walker, 'walk' ), array( $categories, 0, array( 'style' => 'list' ) ) );
		echo '</ul>';

		echo $after_widget;
	}

	function control( $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric($instance) || 1 > $instance ) {
			$instance = '%i%';
		}

		$options = $this->options;

		if ( 'POST' == strtoupper( $_SERVER['REQUEST_METHOD'] ) && isset( $_POST['pp_widget_project_tree'] ) ) {
			foreach ( $_POST['pp_widget_project_tree'] as $_instance => $_value ) {
				if ( !$_value ) {
					continue;
				}
				$options[$_instance]['title'] = strip_tags( stripslashes( $_POST['pp_widget_project_tree'][$_instance]['title'] ) );
				$parent = $_POST['pp_widget_project_tree'][$_instance]['parent'];
				if ( in_array( $parent, array('all', 'sub') ) ) {
					$options[$_instance]['parent'] = $parent;
				} else {
					$options[$_instance]['parent'] = 'all';
				}
			}
			if ( $this->options != $options ) {
				$this->options = $options;
				update_option('pp_widget_project_tree', $this->options);
			}
		}

		$options['%i%']['title'] = '';
		$options['%i%']['parent'] = '';

		$title = attribute_escape( stripslashes( $options[$instance]['title'] ) );
		if ( !$options[$instance]['parent'] ) {
			$options[$instance]['parent'] = 'all';
		}
		$parent = array( 'all' => '', 'sub' => '' );
		$parent[$options[$instance]['parent']] = ' selected="selected"';

		if ( !$project_category_id = pp_get_category_id( 'projects' ) ) {
?>
			<p>
				<?php _e( 'You must select and save the "projects" category in the project settings.', 'prologue-projects' ); ?>
			</p>
<?php
		} else {
?>
			<p>
				<label for="pp_widget_project_tree_title_<?php echo $instance; ?>">
					<?php _e('Title:', 'prologue-projects'); ?>
					<input class="widefat" id="pp_widget_project_tree_title_<?php echo $instance; ?>" name="pp_widget_project_tree[<?php echo $instance; ?>][title]" type="text" value="<?php echo $title; ?>" />
				</label>
			</p>
			<p>
				<label for="pp_widget_project_tree_parent_<?php echo $instance; ?>">
					<?php _e('Show:', 'prologue-projects'); ?><br />
					<select id="pp_widget_project_tree_parent_<?php echo $instance; ?>" name="pp_widget_project_tree[<?php echo $instance; ?>][parent]">
						<option value="all"<?php echo $parent['all']; ?>><?php _e('All projects', 'prologue-projects'); ?></option>
						<option value="sub"<?php echo $parent['sub']; ?>><?php _e('The current projects sub-projects', 'prologue-projects'); ?></option>
					</select>
				</label>
			</p>
			<input type="hidden" id="pp_widget_project_tree_submit" name="pp_widget_project_tree[<?php echo $instance; ?>][submit]" value="1" />
<?php
		}
	}
}

class PP_Widget_Project_Team
{
	var $options;

	function PP_Widget_Project_Team()
	{
		if ( !$this->options = get_option( 'pp_widget_project_team' ) ) {
			$this->options = array();
		}

		add_action( 'widgets_init', array( $this, 'init' ) );
	}

	function init()
	{
		$widget_options = array(
			'classname' => 'pp-widget-project-team',
			'description' => __( 'Display all project team members in the current project', 'prologue-projects' )
		);

		$control_options = array(
			'height' => 350,
			'id_base' => 'pp-widget-project-team'
		);

		if ( !count($this->options) ) {
			$options = array(-1 => false);
		} else {
			$options = $this->options;
		}
		foreach ( $options as $instance => $option ) {
			wp_register_sidebar_widget(
				'pp-widget-project-team-' . $instance,
				__('Project Team', 'prologue-projects'),
				array($this, 'display'),
				$widget_options,
				array( 'number' => $instance )
			);

			wp_register_widget_control(
				'pp-widget-project-team-' . $instance,
				__('Project Team', 'prologue-projects'),
				array($this, 'control'),
				$control_options,
				array( 'number' => $instance )
			);
		}
	}

	function display( $args, $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric( $instance ) || 1 > $instance ) {
			return;
		}

		extract( $args );

		echo $before_widget;

		$title = $this->options[$instance]['title'] ? $this->options[$instance]['title'] : __( 'Project Team', 'prologue-projects' );

		echo $before_title;
		echo $title;
		echo $after_title;

		$data = pp_get_project_data( $category_id );

		if ( $members = pp_get_project_members( $data['id'] ) ) {
			if ( count( $members ) ) {
				echo '<ul id="pp-project-team-list-' . attribute_escape( $data['slug'] ) . '" class="pp-project-team-list">' . "\n";
				foreach ( $members as $member ) {
					echo "\t" . '<li><a href="' . attribute_escape( get_author_posts_url( $member['user_id'], $member['user_nicename'] ) ) . '">';
					echo get_avatar($member['user_id'], 16);
					echo $member['display_name'] . '</a>';
					if ( $member['project_role'] ) {
						echo ' - <span class="role">' . wp_specialchars( $member['project_role'] ) . '</span>';
					}
					echo '</li>' . "\n";
				}
				echo '</ul>' . "\n";
			}
		} else {
			echo '<p class="empty">' . __( 'No team members assigned', 'prologue-projects' ) . '</p>' . "\n";
		}
		
		echo $after_widget;
	}

	function control( $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric($instance) || 1 > $instance ) {
			$instance = '%i%';
		}

		$options = $this->options;

		if ( 'POST' == strtoupper( $_SERVER['REQUEST_METHOD'] ) && isset( $_POST['pp_widget_project_team'] ) ) {
			foreach ( $_POST['pp_widget_project_team'] as $_instance => $_value ) {
				if ( !$_value ) {
					continue;
				}
				$options[$_instance]['title'] = strip_tags( stripslashes( $_POST['pp_widget_project_team'][$_instance]['title'] ) );
			}
			if ( $this->options != $options ) {
				$this->options = $options;
				update_option('pp_widget_project_team', $this->options);
			}
		}

		$options['%i%']['title'] = '';

		$title = attribute_escape( stripslashes( $options[$instance]['title'] ) );
?>
			<p>
				<label for="pp_widget_project_team_title_<?php echo $instance; ?>">
					<?php _e('Title:', 'prologue-projects'); ?>
					<input class="widefat" id="pp_widget_project_team_title_<?php echo $instance; ?>" name="pp_widget_project_team[<?php echo $instance; ?>][title]" type="text" value="<?php echo $title; ?>" />
				</label>
			</p>
			<input type="hidden" id="pp_widget_project_team_submit" name="pp_widget_project_team[<?php echo $instance; ?>][submit]" value="1" />
<?php
	}
}

class PP_Widget_Featured_Project
{
	var $options;

	function PP_Widget_Featured_Project()
	{
		if ( !$this->options = get_option( 'pp_widget_featured_project' ) ) {
			$this->options = array();
		}

		add_action( 'widgets_init', array( $this, 'init' ) );
	}

	function init()
	{
		$widget_options = array(
			'classname' => 'pp-widget-featured-project',
			'description' => __( 'Display the description of the currently featured project', 'prologue-projects' )
		);

		$control_options = array(
			'height' => 350,
			'id_base' => 'pp-widget-featured-project'
		);

		if ( !count($this->options) ) {
			$options = array(-1 => false);
		} else {
			$options = $this->options;
		}
		foreach ( $options as $instance => $option ) {
			wp_register_sidebar_widget(
				'pp-widget-featured-project-' . $instance,
				__('Featured Project', 'prologue-projects'),
				array($this, 'display'),
				$widget_options,
				array( 'number' => $instance )
			);

			wp_register_widget_control(
				'pp-widget-featured-project-' . $instance,
				__('Featured Project', 'prologue-projects'),
				array($this, 'control'),
				$control_options,
				array( 'number' => $instance )
			);
		}
	}

	function display( $args, $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric( $instance ) || 1 > $instance ) {
			return;
		}

		extract( $args );

		if ( !$featured_project_id = pp_get_option( 'featured_project' ) ) {
			return;
		}

		if ( !$featured_project = pp_get_project_data( $featured_project_id ) ) {
			return;
		}

		echo $before_widget;

		$title = $this->options[$instance]['title'] ? $this->options[$instance]['title'] : __( 'Featured Project', 'prologue-projects' );

		echo $before_title;
		echo $title;
		echo $after_title;

		echo '<h4><a href="' . get_category_link( $featured_project_id ) . '">';
		pp_project_name( $featured_project_id );
		echo '</a></h4>';
		pp_project_logo( $featured_project_id );
		pp_project_description( $featured_project_id );

		if ( $this->options[$instance]['show_team'] ) {
			echo '<div class="pp-clear"></div>';
			if ( $members = pp_get_project_members( $featured_project['id'] ) ) {
				if ( count( $members ) ) {
					echo '<ul id="pp-project-team-list-' . $featured_project['slug'] . '" class="pp-featured-project-team-list">' . "\n";
					foreach ( $members as $member ) {
						echo "\t" . '<li><a href="' . attribute_escape( get_author_posts_url( $member['user_id'], $member['user_nicename'] ) ) . '">';
						echo get_avatar($member['user_id'], 16);
						echo $member['display_name'] . '</a>';
						if ( $member['project_role'] ) {
							echo ' - <span class="role">' . ($member['project_role']) . '</span>';
						}
						echo '</li>' . "\n";
					}
					echo '</ul>' . "\n";
				}
			} else {
				echo '<p class="empty">' . __( 'No team members assigned', 'prologue-projects' ) . '</p>' . "\n";
			}
		}

		echo '<p class="go-link"><a href="' . get_category_link( $featured_project_id ) . '">' . __( '&raquo; Visit project', 'prologue-projects' ) . '</a></p>';
		echo '<div class="pp-clear"></div>';

		echo $after_widget;
	}

	function control( $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric($instance) || 1 > $instance ) {
			$instance = '%i%';
		}

		$options = $this->options;

		if ( 'POST' == strtoupper( $_SERVER['REQUEST_METHOD'] ) && isset( $_POST['pp_widget_featured_project'] ) ) {
			foreach ( $_POST['pp_widget_featured_project'] as $_instance => $_value ) {
				if ( !$_value ) {
					continue;
				}
				$options[$_instance]['title'] = strip_tags( stripslashes( $_POST['pp_widget_featured_project'][$_instance]['title'] ) );
				if ( isset( $_POST['pp_widget_featured_project'][$_instance]['show_team'] ) && $_POST['pp_widget_featured_project'][$_instance]['show_team'] ) {
					$options[$_instance]['show_team'] = 1;
				} else {
					$options[$_instance]['show_team'] = 0;
				}
			}
			if ( $this->options != $options ) {
				$this->options = $options;
				update_option('pp_widget_featured_project', $this->options);
			}
		}

		$options['%i%']['title'] = '';
		$options['%i%']['show_team'] = '';

		$title = attribute_escape( stripslashes( $options[$instance]['title'] ) );
		if ( $options[$instance]['show_team'] ) {
			$show_team_checked = ' checked="checked"';
		}
		
?>
			<p>
				<label for="pp_widget_featured_project_title_<?php echo $instance; ?>">
					<?php _e('Title:', 'prologue-projects'); ?>
					<input class="widefat" id="pp_widget_featured_project_title_<?php echo $instance; ?>" name="pp_widget_featured_project[<?php echo $instance; ?>][title]" type="text" value="<?php echo $title; ?>" />
				</label>
			</p>
			<p>
				<label for="pp_widget_featured_project_show_team_<?php echo $instance; ?>">
					<?php _e('Show project team', 'prologue-projects'); ?>
					<input type="checkbox" id="pp_widget_featured_project_show_team_<?php echo $instance; ?>" name="pp_widget_featured_project[<?php echo $instance; ?>][show_team]" value="1"<?php echo $show_team_checked; ?> />
				</label>
			</p>
			<input type="hidden" id="pp_widget_featured_project_submit" name="pp_widget_featured_project[<?php echo $instance; ?>][submit]" value="1" />
<?php
	}
}

class PP_Widget_User_Projects
{
	var $options;

	function PP_Widget_User_Projects()
	{
		if ( !$this->options = get_option( 'pp_widget_user_projects' ) ) {
			$this->options = array();
		}

		add_action( 'widgets_init', array( $this, 'init' ) );
	}

	function init()
	{
		$widget_options = array(
			'classname' => 'pp-widget-user-projects',
			'description' => __( 'Displays the current user\'s projects', 'prologue-projects' )
		);

		$control_options = array(
			'height' => 350,
			'id_base' => 'pp-widget-user-projects'
		);

		if ( !count($this->options) ) {
			$options = array(-1 => false);
		} else {
			$options = $this->options;
		}
		foreach ( $options as $instance => $option ) {
			wp_register_sidebar_widget(
				'pp-widget-user-projects-' . $instance,
				__('User Projects', 'prologue-projects'),
				array($this, 'display'),
				$widget_options,
				array( 'number' => $instance )
			);

			wp_register_widget_control(
				'pp-widget-user-projects-' . $instance,
				__('User Projects', 'prologue-projects'),
				array($this, 'control'),
				$control_options,
				array( 'number' => $instance )
			);
		}
	}

	function display( $args, $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric( $instance ) || 1 > $instance ) {
			return;
		}

		extract( $args );

		global $is_author, $author_id;

		if ( !$is_author || !$author_id ) {
			return;
		}

		if ( !$user = new WP_User( $author_id ) ) {
			return;
		}

		echo $before_widget;

		$title_name = trim( $user->display_name );
		if ( !$title_name ) {
			$title_name = __( 'This User\'s Projects', 'prologue-projects' );
		} else {
			if ( substr( $title_name, '-1' ) === 's' ) {
				$title_name .= "'";
			} else {
				$title_name .= "'s";
			}
			$title = sprintf( __( '%s Projects', 'prologue-projects' ), $title_name );
		}
		$title = $this->options[$instance]['title'] ? $this->options[$instance]['title'] : $title;

		$first_name = trim($user->first_name);
		if ( !$first_name ) {
			$empty = __( 'This user is not a member of any project teams', 'prologue-projects' );
		} else {
			$empty = sprintf( __( '%s is not a member of any project teams', 'prologue-projects' ), wp_specialchars( $first_name ) );
		}

		echo $before_title;
		echo $title;
		echo $after_title;

		if ( $projects = pp_get_user_projects( $author_id ) ) {
			echo '<ul id="pp-user-project-list-' . attribute_escape( $user->user_nicename ) . '" class="pp-user-project-list">' . "\n";
			foreach ( $projects as $project_id => $role ) {
				echo "\t" . '<li>' . pp_get_project_data( $project_id, 'link' );
				if ( $role ) {
					echo ' - <span class="role">' . wp_specialchars( $role ) . '</span>';
				}
				echo '</li>' . "\n";
			}
			echo '</ul>' . "\n";
		} else {
			echo '<p class="empty">' . $empty . '</p>' . "\n";
		}

		echo $after_widget;
	}

	function control( $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric($instance) || 1 > $instance ) {
			$instance = '%i%';
		}

		$options = $this->options;

		if ( 'POST' == strtoupper( $_SERVER['REQUEST_METHOD'] ) && isset( $_POST['pp_widget_user_projects'] ) ) {
			foreach ( $_POST['pp_widget_user_projects'] as $_instance => $_value ) {
				if ( !$_value ) {
					continue;
				}
				$options[$_instance]['title'] = strip_tags( stripslashes( $_POST['pp_widget_user_projects'][$_instance]['title'] ) );
			}
			if ( $this->options != $options ) {
				$this->options = $options;
				update_option('pp_widget_user_projects', $this->options);
			}
		}

		$options['%i%']['title'] = '';

		$title = attribute_escape( stripslashes( $options[$instance]['title'] ) );

		if ( !$project_category_id = pp_get_category_id( 'projects' ) ) {
?>
			<p>
				<?php _e( 'You must select and save the "projects" category in the project settings.', 'prologue-projects' ); ?>
			</p>
<?php
		} else {
?>
			<p>
				<label for="pp_widget_user_projects_title_<?php echo $instance; ?>">
					<?php _e('Title:', 'prologue-projects'); ?>
					<input class="widefat" id="pp_widget_user_projects_title_<?php echo $instance; ?>" name="pp_widget_user_projects[<?php echo $instance; ?>][title]" type="text" value="<?php echo $title; ?>" />
				</label>
			</p>
			<input type="hidden" id="pp_widget_user_projects_submit" name="pp_widget_user_projects[<?php echo $instance; ?>][submit]" value="1" />
<?php
		}
	}
}

// Generate sidebars
pp_generate_sidebars();

// Register widgets
new PP_Widget_Project_Tree();
new PP_Widget_Project_Team();
new PP_Widget_Featured_Project();
new PP_Widget_User_Projects();
?>