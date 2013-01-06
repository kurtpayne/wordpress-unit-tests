<?php include("pagefunctions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>


<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen">
		<!-- @import url( <?php bloginfo('stylesheet_url'); ?>?1 ); -->
</style>

<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); 
?>
</head>

<body id="home" class="log">
<div id="header">
  <div id="logo">
    <h1 id="blogname"><a href="<?php bloginfo('siteurl'); ?>">
      <?php  bloginfo('name'); ?>
      </a></h1>
    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
  </div>
  <div>
    <ul class="navigation">
      <?php

if (is_home() || is_front_page()) {$pg_li .="current_page_item";}
?>
      <li class="<?php echo $pg_li; ?>"><a href="<?php bloginfo('siteurl'); ?>" title="Blog"><span><?php _e('Blog'); ?></span></a></li>
      <?php wp_list_page('depth=1&title_li=&exclude=143' ); ?>
    </ul>
  </div>
</div>
<div id="wrap">
