<?php //$freshy_options = get_option('freshy_options'); 
	global $yy_options;
	global $freshy_options;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" title="Freshy"/>
<!--[if gte IE 7]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie7.css" type="text/css" media="screen" />
<![endif]-->
<!--[if lt IE 7]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie6.css" type="text/css" media="screen" />
<![endif]-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head();
?>
</head>
<body>

<div id="page">
	
	<!-- header -->
	<div id="header">
		<div id="title">
			<h1>
				<a href="<?php echo get_option('home'); ?>">
					<span><?php bloginfo('name'); ?></span>
				</a>
			</h1>
			<div class="description">
				<small><?php bloginfo('description'); ?></small>
			</div>
		</div>
		<div id="title_image"></div>
	</div>
	
	<!-- main div -->
	<div id="frame">

	<!-- main menu -->
		<ul class="menu">
			<li class="<?php if (is_front_page() ) echo "current_page_item "; ?>page_item">
				<a class="first_menu" href="<?php echo get_option('home'); ?>">
					<?php _e($freshy_options['first_menu_label'],TEMPLATE_DOMAIN); ?>
				</a>
			</li>
					
			<?php freshy_wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
				
			<li class="last_menu">
				
				<!-- put an empty link to have the end of the menu anyway -->
					
				<a class="last_menu_off">
				</a>
					
			</li>

		</ul>
	
	<hr style="display:none"/>
