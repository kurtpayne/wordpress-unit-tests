<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>


	<!-- feeds -->
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<link href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" rel="stylesheet" />
	<link href="<?php bloginfo('template_url'); ?>/switch.css" type="text/css" rel="stylesheet" />

	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head();
	
	$headerImageURL = preg_replace( '|[^~_\-a-z0-9.:/]|i', '', get_settings( 'regulus_headerImageURL' ) );
	
	if ( $headerImageURL != "" ) {

		echo "<style type=\"text/css\">
		
	#header {
	
		background:url( $headerImageURL ) #fff;
		
	}
		
</style>";

	}
	


	?>
	
	<!--
	Regulus Theme Created by Ben Gillbanks @ Binary Moon (http://www.binarymoon.co.uk/)
	-->
	
</head>

<?php

	// write the body tag.
	// needs some php fanciness to set the default header graphic

	// set default
	$headerImage = get_settings( 'regulus_headerImage' );
	$classExtra = "";
	
	if ( $headerImage == "" ) {
		$headerImage = "1";
	}
	
	if ( bm_getProperty( 'sidealign' ) == 1 ) {
		$classExtra = "leftAlign ";
	}
	
	$classExtra .= get_settings( 'regulus_colourScheme' );
	
	if ( $headerImageURL == "" ) {
		$classExtra .= " hid_$headerImage";
	}
	
	echo "<body class=\"$classExtra\">";

?>


<div id="wrapper">

	<div id="header">

		<?php if( bm_getProperty( 'heading' ) != 1 ) { ?>
		<h1><?php bloginfo('name'); ?></h1>
		<p class="site_description"><?php bloginfo('description'); ?></p>
		<?php } ?>

		<ul id="nav">
		<li <?php if ( is_front_page() )  { echo "class=\"current_page_item\""; } ?> ><a href="<?php echo get_settings('home'); ?>" ><?php _e('Home'); ?></a></li>
		<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
		</ul>

	</div>
	
	<a href="#nav" class="skipnav">jump to navigation</a>
	


