<?php
/*
Filename: 		header.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

load_theme_textdomain('gluedideas_subtle');

if (file_exists(dirname(__FILE__) . '/advert.php')) { include_once('advert.php'); }

if (is_home()) { $sMenuHome = 'current_page_item'; } else { $sMenuHome = 'page_item'; }

if (is_archive()) { $sMenuArchive = 'current_page_item'; } else { $sMenuArchive = 'page_item'; }

$aOptions = themeGluedIdeas_Subtle::initOptions(false);

if (!file_exists(get_theme_root() . '/' . get_template() . '/styles/' . $aOptions['style'])) {
	$aOptions['style'] = 'default';
}

// If the style has a header that needs generating, do it.
$sStyleFolder = get_theme_root() . '/' . get_template() . '/styles/' . $aOptions['style'] . '/';
if (file_exists($sStyleFolder . 'generator.php')) {
	include_once($sStyleFolder . 'generator.php');
	$sStyleCSS = getHeaderCSS($sStyleFolder);
} else {
	$sStyleCSS = '';
}


?>
<!-- Header Start -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
    <link href="<?php bloginfo('stylesheet_directory'); ?>/assets/css/layout.css" rel="stylesheet" media="screen" type="text/css" />
    <link href="<?php bloginfo('stylesheet_directory'); ?>/assets/css/print.css" rel="stylesheet" media="print" type="text/css" />
    <link href="<?php bloginfo('stylesheet_directory'); ?>/styles/<?php if (isset($aOptions['style'])) { echo($aOptions['style']); } else { echo('default'); } ?>/default.css" rel="stylesheet" media="all" type="text/css" />

<style type="text/css">
<!--

<?php echo($sStyleCSS); ?>

-->
</style>

	<?php if (isset($aOptions['feedburner']) && $aOptions['feedburner'] != "") : ?>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - Feedburner" href="<?php echo $aOptions['feedburner']; ?>" />
	<?php else : ?>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<?php endif; ?>

	<?php global $wp_version; global $wpmu_sitefeed; if (is_object($wpmu_sitefeed)) : ?>
	<?php global $wpmu_feed; if ($wpmu_feed == '') { $wpmu_feed = get_bloginfo('home') . "/wpmu_feed/"; } ?>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - Master Feed" href="<?php echo($wpmu_feed); ?>" />
	<?php endif; ?>	

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />

	<script language="JavaScript" type="text/javascript" src="<?php bloginfo('template_directory'); ?>/assets/js/core.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php bloginfo('template_directory'); ?>/assets/js/dom.js"></script>


	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>
</head>

<body>

<div id="container">

	<div id="header">
		<div class="style_content">

			<form action="<?php bloginfo('home'); ?>/" name="search_box" id="search_box" method="get">
				<label for="input_search" id="label_search"><?php _e('Find this', 'gluedideas_subtle'); ?></label> <input type="text" id="input_search" class="input" name="s" /><input type="image" src="<?php bloginfo('stylesheet_directory'); ?>/assets/images/icon_search.gif" align="top" id="button_search" value="Search" />
			</form>
			
			<h1 id="title"><a href="<?php echo get_settings('home'); ?>/"><span><?php bloginfo('name'); ?></span></a></h1>
			<p id="tagline"><span><?php bloginfo('description'); ?></span></p>
			
			<ul id="menu">
				<li class="<?php echo($sMenuHome); ?>"><a href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'gluedideas_subtle'); ?></a></li>
				<?php wp_list_pages('depth=1&title_li=0&sort_column=menu_order'); ?>
			</ul>

		</div>
	</div>


	<div id="content">
		<div class="style_content">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Advert_1') ) { if (function_exists(displaySubtleAds)) { displaySubtleAds(1); } } ?>

<!-- Header End -->
