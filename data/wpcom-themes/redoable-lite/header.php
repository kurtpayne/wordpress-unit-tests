<?php load_theme_textdomain('redo_domain'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?2" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); 
?>
</head>
	
	<?php
		$redo_pagemenu = 0;
	?>
	


<body class="<?php redo_body_class(); ?>" <?php redo_body_id(); ?>>

	<div id="header">
    	<div class="top">
			
			<div id="header_content" onclick="document.location='<?php bloginfo('url'); ?>';" style="cursor: pointer;">
				<div id="title" class="title">
					<h1><a href="<?php echo get_option('home'); ?>" title="Back to the front page"><?php bloginfo('name'); ?></a></h1>
           		</div>
			
				<div id="rightcolumnheader">
				<?php if($redo_pagemenu == 1) { ?>
				<ul id="menu">
					<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
				</ul>
				<?php } ?>
				</div>
				
			</div>
  
		</div>
		
	</div>
	
	<?php if($redo_pagemenu == 0) { ?>
	<div>
	<ul id="alt_menu">
		<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
	</ul>
	</div>
	<?php } ?>
	
<div id="page">	
	<hr />
