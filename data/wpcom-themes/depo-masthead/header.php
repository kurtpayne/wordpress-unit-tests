<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if gte IE 6]><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" media="screen" /><![endif]-->

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_enqueue_script('jquery'); ?>

<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); 
?>

<script type="text/javascript" charset="utf-8">
/*<![CDATA[ */
//set title font size
jQuery(document).ready(function() {
	
	function resize(selector, max) {
		jQuery(selector).each(function() {

			var width = jQuery(this).width();
			var height = jQuery(this).height();
			if(width > max) {
			var r = ( height / width );
			var w = max;
			var h = ( w * r );
			jQuery(this).height(h).width(w);
		}});
	}
	
	resize('#home .gallery img', 90);
	resize('#home .entry img', 300);
	resize('#home .wp-caption img', 290);
	resize('#home .wp-caption', 300);
	jQuery('#home .wp-caption').css('height', 'auto');
});
/* ]]> */
</script>
</head>
<body<?php if((is_front_page() or is_home()) && !is_page()) { echo ' id="home"'; } ?>>
<div id="page">

<h1 class="name"><a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('description'); ?>"><span>
	<?php $my_query = new WP_Query('showposts=1');
	  while ($my_query->have_posts() && $count < 1) : $my_query->the_post();
	  $do_not_duplicate = $post->ID;?>
	<?php $count++; $title = get_userdata($post->post_author); $title = $title->display_name; ?><?php endwhile; ?><?php echo (get_option('depo-author-name')) ? get_option('depo-author-name') : $title; ?></span></a></h1>

<div id="container">
	<div class="sleeve">
		
		<div id="header">
			<?php 
				$title = strlen(get_bloginfo('name'));
				if($title >= 30) $title = 40;
				$new_size = (1000/$title)*2;
				if($new_size > 120) $new_size = 120;
				if(preg_match('/.*\s.*/',$title) === false && ($title > 20)) $new_size = 72;
				$size = $new_size;

			?>
			<h1 style="font-size: <?php echo $size; ?>px;">
			<?php if(!is_front_page()) { ?><a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('description'); ?>"><?php } ?>
			<?php bloginfo('name'); ?>
			<?php if(!is_front_page()) { ?></a><?php } ?>
			</h1>

			<ul id="menu">
				<?php 
				  $pages = get_pages('sort_column=menu_order'); 
				  foreach ($pages as $pagg) {
					if ( $pagg->post_parent == 0 ) {
						$option = '<li><a href="'.get_page_link($pagg->ID).'">';
						$option .= $pagg->post_title;
						$option .= '</a><span>|</span></li>';
						echo $option;
					}
				  }
				 ?>
			<li>
				<a href="<?php bloginfo('url'); ?>/<?php echo mysql2date('Y', get_lastpostdate('blog')); ?>/"><?php _e('Archives', 'depo-masthead'); ?></a><span>|</span>
			</li>
			<li>
				<a href="<?php bloginfo('rss2_url'); ?>"><?php _e('RSS Feed', 'depo-masthead'); ?></a>
			</li>
			
			</ul>

		</div>

		<div id="content" class="group">
