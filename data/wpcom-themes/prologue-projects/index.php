<?php
pp_maybe_insert_post();

get_header();
?>

<?php
$is_front_page = false;
if ( is_front_page() ) {
	// Because $wp_query gets stomped on later
	$is_front_page = true;
?>

<div class="pp-project-info">
	<h2 class="pp-project-name"><?php _e( 'All Projects', 'prologue-projects' ); ?></h2>
	<div class="pp-clear"></div>
</div>

<div class="pp-project-main">

<?php
}

$is_author = false;
if ( is_author() ) {
	// Because $wp_query gets stomped on later
	$is_author = true;
	$author_id = $wp_query->query_vars['author'];
?>

<div class="pp-project-info">
	<h2 class="pp-project-name"><?php pp_author_title(); ?> <?php pp_author_rss(); ?></h2>
	<div class="pp-clear"></div>
</div>

<div class="pp-project-main">

<?php
}

if ( pp_is_project() ) {
?>

<div class="pp-project-info">
	<h2 class="pp-project-name"><?php pp_project_name(); ?> <?php pp_project_rss(); ?></h2>
	<?php pp_project_links(); ?>
	<div class="pp-clear"></div>
</div>

<div class="pp-project-main">
	<?php pp_project_logo(); ?>
	<div class="pp-project-description">
		<?php pp_project_description(); ?>
	</div>
	<div class="pp-clear"></div>

<?php
}
?>

<?php

$tab_class = array(
	'tasks'     => '',
	'updates'   => '',
	'questions' => ''
);

$show_form = false;
if ( is_user_logged_in() && ( !$is_author || ( $is_author && $author_id == $current_user->ID ) ) ) {
	$show_form = true;

	$tab_class = array(
		'tasks'     => 'loggedin',
		'updates'   => 'loggedin',
		'questions' => 'loggedin'
	);
}

if ( isset( $_GET['questions'] ) ) {
	$tab_class['questions'] .= ' active';
} elseif ( isset( $_GET['tasks'] ) ) {
	$tab_class['tasks'] .= ' active';
} else {
	$tab_class['updates'] .= ' active';
}

?>

	<ul class="pp-project-tabs-nav">
		<li class="<?php echo trim( $tab_class['updates'] ); ?>"><a href="./"><?php _e( 'Updates', 'prologue-projects' ); ?></a></li>
		<!--<li class="<?php echo trim( $tab_class['tasks'] ); ?>"><a href="./?tasks"><?php _e( 'Tasks', 'prologue-projects' ); ?></a></li>-->
		<li class="<?php echo trim( $tab_class['questions'] ); ?>"><a href="./?questions"><?php _e( 'Questions', 'prologue-projects' ); ?></a></li>
	</ul>

	<div class="pp-project-tabs">
<?php
$mode = 'updates';
if ( isset( $_GET['tasks'] ) && $task_category_id = pp_get_category_id( 'tasks' ) ) {
	$default_task_level = pp_get_option( 'default_task_level' );
	$mode = 'tasks';
} elseif ( isset( $_GET['questions'] ) && $question_category_id = pp_get_category_id( 'questions' ) ) {
	$default_question_state = pp_get_option( 'default_question_state' );
	$mode = 'questions';
}

if ( current_user_can( 'publish_posts' ) && $show_form ) {
	require_once dirname( __FILE__ ) . '/post-form.php';
}

switch ( $mode ) {
	case 'updates':
?>
		<h3>Latest Updates</h3>
<?php
		break;
	case 'tasks':
?>
		<h3>Current Tasks</h3>
<?php
		break;
	case 'questions':
?>
		<h3>Latest Questions</h3>
<?php
		break;
}

$query_categories = array();

$project_id = pp_get_project_data( 0, 'id' );

if ( $project_id && (int) pp_get_category_id( 'projects' ) !== (int) $project_id ) {
	$query_categories[] = $project_id;
}

switch ( $mode ) {
	case 'updates':
		$query_categories[] = pp_get_category_id( 'updates' );
		break;
	case 'tasks':
		$query_categories[] = pp_get_category_id( 'tasks' );
		break;
	case 'questions':
		$query_categories[] = pp_get_category_id( 'questions' );
		break;
}

if ( 1 < count( $query_categories ) ) {
	$query_args = array( 'category__and' => $query_categories );
} else {
	$query_args = array( 'cat' => $query_categories[0] );
}

if ( $paged ) {
	$query_args['paged'] = get_query_var( 'paged' );
}

if ( $is_author ) {
	$query_args['author'] = $author_id;
}

query_posts( $query_args );

if ( have_posts() ) {
?>
		<ul class="pp-updates">
<?php
	$previous_user_id = 0;
	while ( have_posts() ) {
		the_post();
?>
			<li id="pp-update-<?php the_ID(); ?>" class="pp-update">
<?php
		// Don't show the avatar if the previous post was by the same user
		$current_user_id = get_the_author_ID();
		if ( $previous_user_id !== $current_user_id ) {
			echo get_avatar( $current_user_id, 48 );
		}
		$previous_user_id = $current_user_id;
?>
				<h4>
					<?php the_author_posts_link(); ?>
					<span class="meta">
						<?php printf( __( '%1$s on %2$s', 'prologue-projects' ), get_the_time(), the_date( '', '', '', false ) ); ?> |
						<?php comments_popup_link( __( '0', 'prologue-projects' ), __( '1', 'prologue-projects' ), __( '%', 'prologue-projects' ) ); ?> |
						<a href="<?php the_permalink(); ?>">#</a> | 
						<?php edit_post_link( __( 'e', 'prologue-projects' ) ); ?>
					</span>
				</h4>
				<ul class="taxonomy">
					<?php the_tags( '<li>' . __( 'Tags: ', 'prologue-projects' ), ', ', '</li>' ); ?>
					<?php pp_the_projects( '<li>' . __( 'Projects: ', 'prologue-projects' ), ', ', '</li>' ); ?>
					<?php pp_the_question_status( '<li>', __( 'This question is <span class="question-status">%s</span>', 'prologue-projects' ), '</li>' ); ?>
				</ul>
				<div class="pp-update-content">
					<?php the_content( __( '(More ...)', 'prologue-projects' ) ); ?>
				</div>
			</li>
<?php
	} // while have_posts
?>
		</ul>

		<?php pp_page_navigation(); ?>
<?php
} // if have_posts
?>
	</div>
</div>

<div id="pp-sidebar">
	<ul>
<?php
dynamic_sidebar( 'pp-sidebar-top' );

if ( $is_front_page ) {
	dynamic_sidebar( 'pp-home-sidebar' );
}
?>

<?php
if ( pp_is_project() ) {
	if ( !dynamic_sidebar( 'pp-project-sidebar-' . pp_get_project_data( 0, 'id' ) ) ) {
		dynamic_sidebar( 'pp-project-sidebar-default');
	}
?>
		<li id="pp-widget-project-feeds-<?php echo pp_get_project_data( 0, 'id' ); ?>" class="widget pp-project-sidebar pp-project-sidebar-<?php echo pp_get_project_data( 0, 'id' ); ?> pp-widget-project-feeds"><?php pp_project_feeds(); ?></li>
<?php
}

if ( $is_author ) {
	if ( !dynamic_sidebar( 'pp-author-sidebar-' . $author_id ) ) {
		dynamic_sidebar( 'pp-author-sidebar-default' );
	}
}

dynamic_sidebar( 'pp-sidebar-bottom' );
?>
		<li id="pp-widget-credits" class="widget pp-project-sidebar pp-project-sidebar-<?php echo pp_get_project_data( 0, 'id' ); ?> pp-widget-credits">
			<p>
<?php
if ( IS_WPCOM ) {
?>
				<a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a><br />
<?php
} else {
?>
				<a href="http://wordpress.org/" rel="generator"><?php _e( 'Proudly powered by WordPress', 'prologue-projects' ); ?></a><br />
<?php
}
?>
				<?php printf( __( 'Prologue Projects theme by %s', 'prologue-projects' ), '<a href="http://automattic.com/" rel="designer">Automattic</a>' ); ?>
			</p>
		</li>
	</ul>
</div>

<?php
get_footer();
?>