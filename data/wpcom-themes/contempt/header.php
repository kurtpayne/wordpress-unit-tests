<?php
	load_theme_textdomain('contempt');
	$pg_li = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>


<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head();
?>
</head>
<body style="background-image: url(<?php bloginfo('stylesheet_directory'); ?>/images/blue_flower/bg.jpg); background-attachment:fixed; background-repeat: repeat-y; background-position: top center;">


<div id="page">

<div id="header">
	<div id="headerimg" onclick="location.href='<?php bloginfo('url'); ?>';" style="cursor: pointer;">
		<h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
		<div class="description"><?php bloginfo('description'); ?></div>
	</div>
</div>

<ul id="pagebar" style="background: url(<?php bloginfo('stylesheet_directory'); ?>/images/blue_flower/pagebar.jpg);">
	<?php
		if (is_home()) {$pg_li .="current_page_item";}
	?>
	<li class="page_item <?php echo $pg_li; ?>"><a href="<?php echo get_option('home'); ?>"><?php _e('Home','contempt'); ?></a></li>
	<?php wp_list_pages('depth=1&title_li='); ?> 
</ul>

<div id="grad" style="height: 65px; width: 100%; background: url(<?php bloginfo('stylesheet_directory'); ?>/images/blue_flower/topgrad.jpg);">&nbsp;</div>
