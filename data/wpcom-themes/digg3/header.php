<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head();
?>
</head>
<body><div id="container">

<div id="header">

	<div id="menu">
		<ul>
			<li><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('name'); ?>"><?php _e('Home', 'digg3'); ?></a></li>
			<?php wp_list_pages('depth=1&title_li=0'); ?>
		</ul>
	</div>

	<div id="header-box">
	<div id="header-image">
		<img src="<?php header_image() ?>" alt="" />
	</div>
	<div id="header-overlay">
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/bg_header_overlay.png" alt="" />
	</div>

	<div id="pagetitle">
		<h1><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
	</div>

	<div id="syndication">
		<a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS', 'digg3'); ?>" class="feed"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>', 'digg3'); ?></a> &#124; <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('Syndicate comments using RSS', 'digg3'); ?>">Comments RSS</a>
	</div>
	<div id="searchbox">
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
	</div>
</div>

<div class="pagewrapper"><div id="page">

<?php include (TEMPLATEPATH . '/obar.php'); ?>
