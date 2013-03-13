<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/javascript/tabs.js"></script>
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head();
?>
</head>
<body>

<div id="top"></div>

<!-- Start BG -->
<div id="bg">
	
<!-- Start Header -->
<div class="header">
 <h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
 <ul class="rss">
  <li><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)', 'albeo'); ?></a></li>
  <li><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)', 'albeo'); ?></a></li>
 </ul>
</div>
<!-- End Header -->

<div class="menu">
 <ul>
   <li<?php if ( is_front_page() ) echo ' class="current_page_item"'; ?>><a href="<?php echo get_option('home'); ?>/"><span><?php _e('Home', 'albeo'); ?></span></a></li>
<?php $pages = wp_list_pages('sort_column=menu_order&title_li=&echo=0');
$pages = preg_replace('%<a ([^>]+)>%U','<a $1><span>', $pages);
$pages = str_replace('</a>','</span></a>', $pages);
echo $pages; ?>
  </ul>
<? unset($pages); ?> 
</div>

<!-- Start Con-->
<div class="con<?php if(is_attachment()) echo ' attachment-container'; ?>">

<!-- Start SL -->
<div class="sl-a">
<div class="sl-t"></div>
<div class="sl">
