<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="<?php bloginfo('template_url'); ?>/pngfix.js"></script>
<![endif]-->
<?php if ( is_single() or is_page() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body>
	
<div id="header">
	<div class="sleeve">
	<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a> <span><? bloginfo('description') ?></span></h1>
	
	<div class="search-bar">
		<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
			<p><input type="text" name="s" onblur="this.value=(this.value=='') ? '<?php _e('Search this Blog', 'springloaded'); ?>' : this.value;" onfocus="this.value=(this.value=='<?php _e('Search this Blog', 'springloaded'); ?>') ? '' : this.value;" value="<?php _e('Search this Blog', 'springloaded'); ?>" id="s" />
			<button type="submit" id="submit"><img src="<?php bloginfo('template_url'); ?>/images/search-btn.gif" alt="Search" /></button></p>
		</form>
	</div>
	</div>
</div><!-- /header -->


<div id="wrapper">
<div id="main">

<ul id="navigation">
	<li class="page_item <?php if(is_front_page()) { echo 'current_page_item'; } ?>"><a href="<?php bloginfo('home'); ?>"><?php _e('Home', 'springloaded'); ?></a></li>
	<?php wp_list_pages('title_li=&depth=1' ); ?>
</ul>

