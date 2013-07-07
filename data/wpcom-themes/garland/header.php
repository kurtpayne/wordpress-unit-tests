<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<style type="text/css" media="screen">
@import "<?php bloginfo('stylesheet_url'); ?>";
</style>
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); 
?>
</head>

<body class="sidebars">

<div id="navigation"></div>

<div id="wrapper">
<div id="container" class="clear-block">

<div id="header">
<div id="logo-floater">
<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
</div>
<ul class="links primary-links">
<?php wp_list_pages( 'title_li=&depth=1' ); ?>
</ul>                
</div> <!-- /header -->


<?php get_sidebar(); ?>


<div id="center"><div id="squeeze"><div class="right-corner"><div class="left-corner">
<!-- begin content -->
<div class="node">