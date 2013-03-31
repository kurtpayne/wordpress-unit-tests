<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11"> 
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />  
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>"/>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); 
?>
</head>
<body class="<?php if (is_single()) echo permalink; ?>"><div id="page"><hr />

<div id="header" onclick="location.href='<?php bloginfo('url'); ?>';" style="cursor: pointer;"><h1><?php bloginfo('name'); ?></h1><p class="description"><?php bloginfo('description'); ?></p></div>
