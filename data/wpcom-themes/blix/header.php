<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php require_once get_template_directory()."/BX_functions.php"; ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?1" type="text/css" media="screen, projection" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php /*comments_popup_script(520, 550);*/ ?>
	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head();
	?>
</head>

<body>
<div id="container"<?php if (is_page() && !is_page("archives")) echo " class=\"singlecol\""; ?>>

<!-- header ................................. -->
<div id="header">
	<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
</div> <!-- /header -->

<!-- navigation ................................. -->
<div id="navigation">

	<form action="<?php bloginfo('home'); ?>/" method="get">
		<fieldset>
			<input value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
			<input type="submit" value="Go!" id="searchbutton" name="searchbutton" />
		</fieldset>
	</form>

	<ul>
		<li<?php if (is_home()) echo " class='selected'"; ?>><a href="<?php bloginfo('home'); ?>">Home</a></li>
		<?php wp_list_pages('depth=1&title_li=' ); ?>
	</ul>

</div><!-- /navigation -->

<hr class="low" />
