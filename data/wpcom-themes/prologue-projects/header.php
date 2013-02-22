<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php
if ( IS_WPCOM ) {
?>
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
<?php
} else {
?>
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<?php
}
?>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
</head>

<body>
	<div id="pp-header">
		<h1><a href="<?php bloginfo('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
	</div>
	<div id="pp-nav">
		<p class="pp-login">
<?php
if ( is_user_logged_in() ) {
	global $user_identity;
?>
			<?php printf(__('Howdy, <a href="%1$s" title="Edit your profile">%2$s</a>'), admin_url('profile.php'), $user_identity) ?> |
			<a href="<?php echo wp_logout_url( urlencode( pp_get_current_url() ) ) ?>" title="<?php _e('Log Out') ?>"><?php _e('Log Out'); ?></a>
<?php
} else {
?>
			<a href="<?php echo wp_login_url( urlencode( pp_get_current_url() ) ); ?>" title="<?php _e('Log In') ?>"><?php _e('Log In'); ?></a>
<?php
}
?>
		</p>
		<?php pp_project_breadcrumbs(); ?>
	</div>