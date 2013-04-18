<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	<link href="<?php bloginfo('stylesheet_directory'); ?>/styles/default.css" rel="stylesheet" media="all" type="text/css" />
	<link href="<?php bloginfo('stylesheet_directory'); ?>/styles/presets.css" rel="stylesheet" media="all" type="text/css" />
	<link href="<?php bloginfo('stylesheet_directory'); ?>/styles/client.css" rel="stylesheet" media="all" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if IE 7]>
	<link href="<?php bloginfo('stylesheet_directory'); ?>/styles/ie7.css" rel="stylesheet" type="text/css" media="screen" />
	<![endif]-->
	<!--[if lt IE 7]>
	<link href="<?php bloginfo('stylesheet_directory'); ?>/styles/ie6.css" rel="stylesheet" type="text/css" media="screen" />
	<![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/oceanmist.js" type="text/javascript"></script>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
</head>
<body class="<?php body_sub_theme(); ?>">
<div id="center">
  <div id="container">
		<div class="rightShade"></div>
		<div class="leftShade"></div>
	  <div id="header">
			<p id="logo"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></p>
			<p id="strapline"><?php bloginfo('description'); ?></p>
		</div>
		<div id="photo">
		  <img src="<?php bloginfo('stylesheet_directory'); ?>/images/mainpic.jpg" alt="Ocean Mist" />
			<ul id="nav">
			  <li><a href="<?php echo get_option('home'); ?>/">Home</a></li>
			  <?php wp_list_pages('title_li='); ?>
			</ul>
		</div>
		<div id="content">
