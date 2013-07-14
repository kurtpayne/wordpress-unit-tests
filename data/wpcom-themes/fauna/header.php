<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<meta name="template" content="Fauna" />
	
	<!-- Feeds -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Comments RSS 2.0" href="<?php bloginfo('comments_rss2_url'); ?>" />

	<?php if (is_category()) { ?>
	<!-- Category Feed -->
	<?php if ( have_posts() ) : the_post(); ?>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php echo($post->cat_name) ?> RSS 2.0" href="<? echo get_category_rss_link(0, $cat, $post->cat_name); ?>" />
	<?php endif; rewind_posts(); ?>
	<?php } ?>


	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<!-- Stylesheet -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="stylesheet" type="text/css" media="screen" title="Fauna" href="<?php bloginfo('stylesheet_directory'); ?>/fauna-default.css" />
	<?php wp_head(); ?>
	
	<!-- JavaScripts -->
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/meta/scripts.js"></script>

	<?php /* Custom Fauna Code */
	function noteworthy_link($id, $link = FALSE, $separator = '/', $nicename = FALSE){
    $chain = '';
		$parent = &get_category($id);
    if ($nicename) {
        $name = $parent->slug;
    } else {
        $name = $parent->name;
    }
    if ($parent->parent) $chain .= get_category_parents($parent->parent, $link, $separator, $nicename);
    if ($link) {
        $chain .= '<a href="' . get_category_link($parent->term_id) . '" title="' . sprintf(__("View all posts in %s"), $parent->name) . '">'."&hearts;".'</a>' . $separator;
    } else {
        $chain .= $name.$separator;
    }
    return $chain;
	}
	?>
</head>

<? // Sections ?>
<? if (is_home()) { ?>
<body class="bg" id="index">
<? } else { ?>
<body class="bg">
<? } ?>

<a id="top"></a>

<div id="wrapper">
	<h1><a href="<?php echo get_settings('home'); ?>" title="<?php bloginfo('name'); ?> <?php _e('Home'); ?>"><?php bloginfo('name'); ?></a></h1>
	<div id="menu">
		<ul>
			<li id="current-index"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>" accesskey="1"><?php _e('Blog') ?></a></li>
			<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
		</ul>
	</div>


	
	<div id="searchbox">
		<fieldset>
			<legend><label for="s"><?php _e('Search') ?></label></legend>
			<form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
				<input name="s" type="text" class="inputbox" id="s" value="<?php echo wp_specialchars($s, 1); ?>" />
				<input type="submit" value="Search" class="pushbutton" />
			</form>
		</fieldset>
	</div>

	<div id="header">&nbsp;</div>

<hr />
