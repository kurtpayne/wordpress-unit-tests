<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
	

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>
</head>

<body>
<div id="content">
	
	<div id="header" onclick="location.href='<?php echo get_settings('home'); ?>';" style="cursor: pointer;">
		<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
	</div>

	<div id="pagesnav">
			<div class="alignleft">
				<ul>
				<li><a href="<?php echo get_settings('home'); ?>">Blog</a></li>
				<?php wp_list_pages('title_li=&depth=1'); ?>
				</ul>
			</div>
		
			<div id="search">
				<form id="searchform" method="get" action="<?php bloginfo('home'); ?>/">
					<input type="text" id="s" name="s" onblur="this.value=(this.value=='') ? 'search in blog...' : this.value;" onfocus="this.value=(this.value=='search in blog...') ? '' : this.value;" id="supports" name="s" value="search in blog..." />
				</form>
			</div>
	</div>
	
<!-- end header -->
