<?php
$content_width = 604;

function continue_reading_excerpt() {
		$text = get_the_excerpt();
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text, '<p>');
		$excerpt_length = 50;
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, ' ... <a href="'. get_permalink() . '">'.__('Continue reading &raquo;').'</a>');
			$text = implode(' ', $words);
		}
	echo $text;
}

if ( function_exists('register_sidebars') ) {
    register_sidebar(array(
		'name' => 'Right',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));

register_sidebar(array(
	'name' => 'Middle',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
));

register_sidebar(array(
	'name' => 'Left',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
));
}

register_sidebar_widget('Search', 'search_widget');
function search_widget() { ?>
	<li id="search_widget" class="widget widget_search">
<?php if ( !is_dynamic_sidebar() ) { ?><h2><?php _e('Etc', 'depo-masthead'); ?></h2><?php } ?>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<label class="hidden" for="s"><?php _e('Search for:'); ?></label>
<div><input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
<input type="submit" id="searchsubmit" value="Search" />
</div>
</form></li><?php 
}

register_sidebar_widget(__('DePo About', 'depo-masthead'), 'depo_about_widget');
function depo_about_widget() { ?>
	<li id="depo_about">
		<?php query_posts('pagename=about'); ?>
		<?php while (have_posts()) : the_post(); ?>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'depo-masthead'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<?php continue_reading_excerpt(); ?>
				</div>
		<?php endwhile; ?>
	</li>
	<?php 
}

register_sidebar_widget(__('DePo Archives & Categories', 'depo-masthead'), 'depo_archives_widget');
function depo_archives_widget() { ?>
<li id="depo_archives">
	<h2><?php _e('Archives', 'depo-masthead'); ?></h2>
	<ul>
	<?php wp_get_archives('type=monthly&number=7'); ?>
	</ul>
	
	<ul>
		<?php wp_list_categories('show_count=0&number=7&title_li'); ?>
	</ul>
	<br class="clear" />
</li>
<?php }

register_sidebar_widget(__('RSS Link', 'depo-masthead'), 'rss_widget');
function rss_widget() { ?>
	<li id="rss_link" class="widget widget_rss"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('RSS Feed', 'depo-masthead'); ?></a></li>
<?php 
}

/*
Plugin Name: Next/Previous Archive Date
Version: v 2.1
Plugin URI: http://www.scriptygoddess.com/archives/2004/06/27/previous-archive-date-next-archive-date-links/
Description: This plugin will give you two functions for your "date archive" pages that will give you links to the next/previous date. (works for day, month, or year archives)
Author: Modded by Originally - Jennifer - Scriptygoddess
Author URI: http://jcksn.com
*/

function previous_archive_link($user_text='',$before='', $after='') {
	global $wpdb, $tableposts, $wp_query;

	
	if (!isset($tableposts)) 
		$tableposts = $wpdb->posts;

	//get home url for base of link	
	$info = get_bloginfo('url');
	$info = apply_filters('bloginfo', $info);
	$homeurl = convert_chars($info);
	
	$query = $wp_query->query_vars;
	$date->month = $query['m'];
	$date->year = $query['year'];
	$date->monthnum = $query['monthnum'];
	if ( $date->monthnum < 10 ) $date->monthnum = "0" . $date->monthnum;
	$date->day = $query['day'];
	if ( $date->day < 10 ) $date->day = "0" . $date->day;

	foreach($date as $key => $value) {
		if($value != '' && $value != 0) $m .= $value;
	}

	if ($m != '') {
		
		switch(strlen($m)) {
			case 4:
				//archive is year
				$m = (int)$m;

				$past = $wpdb->get_row("SELECT post_date, YEAR(post_date) as year FROM $tableposts WHERE YEAR(post_date) < '".$m."' AND post_type='post' AND post_status='publish' ORDER BY post_date DESC");

				if ($past) {
					$link = get_year_link($past->year);
					$text = $past->year;
				}
				break;
			case 6:

				//archive is month
				$thisYear = substr($m, 0, 4);
				$thisMonth = substr($m, 4, 2);
				
				if (substr($thisMonth,0,1) == '0')
					$thisMonth = substr($m, 5, 1);
				
				$thisMonth = (int)$thisMonth;
				$thisYear = (int)$thisYear;
				
				$timestamp = mktime(0, 0, 0, $thisMonth, 1, $thisYear);

				$currentdate = date("Y-m-d G:i:s", $timestamp);
				//echo $currentdate;

				$past = $wpdb->get_row("SELECT post_date, YEAR(post_date) as year, MONTH(post_date) as month FROM $tableposts WHERE post_date < '".$currentdate."' AND post_type='post' AND post_status='publish' ORDER BY post_date DESC");

				$timestampfordisplay = mktime(0,0,0,$past->month,1,$past->year);
				$forDisplay = __(date("F", $timestampfordisplay));
				$forDisplay .= " ".date("Y", $timestampfordisplay);


				if ($past) {
					$link = get_month_link($past->year,$past->month);
					$text = $forDisplay;
				}
				break;
			case 8:
				//archive is day YYYYMMDD
				$thisYear = substr($m, 0, 4);
				$thisMonth = substr($m, 4, 2);
				$thisDay = substr($m, 6, 2);
				
				if (substr($thisDay,0,1) == '0') {
					$thisDay = substr($m, 7, 1);
				}
				if (substr($thisMonth,0,1) == '0') {
					$thisMonth = substr($m, 5, 1);
				}
				$thisDay = (int)$thisDay;
				$thisMonth = (int)$thisMonth;
				$thisYear = (int)$thisYear;

				$timestamp = mktime(0, 0, 0, $thisMonth, $thisDay, $thisYear);

				$currentdate = date("Y-m-d G:i:s", $timestamp);
				//echo $currentdate;

				$past = $wpdb->get_row("SELECT post_date, YEAR(post_date) as year, MONTH(post_date) as month, DAYOFMONTH(post_date) as day FROM $tableposts WHERE post_date < '".$currentdate."' AND post_type='post' AND post_status='publish' ORDER BY post_date DESC");
				$timestampfordisplay = mktime(0,0,0,$past->month,$past->day,$past->year);
				$forDisplay = __(date("F", $timestampfordisplay));
				$forDisplay .= " ".date("j, Y", $timestampfordisplay);


				if ($past) {
					$link = get_day_link($past->year,$past->month,$past->day);
					$text = $forDisplay;
				}
				break;
		}
		if($user_text != '') $text = str_replace('%title',$text,$user_text);
		if($link) echo $before.'<a href="'.$link.'">'.$text.'</a>'.$after;
	}
}

function next_archive_link($user_text='',$before='', $after='') {
	global $wpdb, $tableposts, $wp_query;
	
	if (!isset($tableposts)) 
		$tableposts = $wpdb->posts;
	
	//get home url for base of link	
	$info = get_bloginfo('url');
	$info = apply_filters('bloginfo', $info);
	$homeurl = convert_chars($info);
	
	$query = $wp_query->query_vars;
	$date->month = $query['m'];
	$date->year = $query['year'];
	$date->monthnum = $query['monthnum'];
	if ( $date->monthnum < 10 ) $date->monthnum = "0" . $date->monthnum;
	$date->day = $query['day'];
	if ( $date->day < 10 ) $date->day = "0" . $date->day;

	foreach($date as $key => $value) {
		if($value != '' && $value != 0) $m .= $value;
	}
	
	
	if ($m != '') {
		switch(strlen($m)) {
			case 4:
				//archive is year
				$m = (int)$m;
				$m++;
				$past = $wpdb->get_row("SELECT post_date, YEAR(post_date) as year FROM $tableposts WHERE YEAR(post_date) >= '".$m."' AND post_type='post' AND post_status='publish' ORDER BY post_date ASC");

				if ($past) {
					$link = get_year_link($past->year);
					$text = $past->year;
				}
				break;
			case 6:
				//archive is month
				$thisYear = substr($m, 0, 4);
				$thisMonth = substr($m, 4, 2);
				
				if (substr($thisMonth,0,1) == '0')
					$thisMonth = substr($m, 5, 1);

				$thisMonth = (int)$thisMonth;
				$thisYear = (int)$thisYear;
				
				$timestamp = mktime(0, 0, 0, $thisMonth+1, 1, $thisYear);

				$currentdate = date("Y-m-d G:i:s", $timestamp);
				//echo $currentdate;

				$past = $wpdb->get_row("SELECT post_date, YEAR(post_date) as year, MONTH(post_date) as month FROM $tableposts WHERE post_date >= '".$currentdate."' AND post_type='post' AND post_status='publish' ORDER BY post_date ASC");
				$timestampfordisplay = mktime(0,0,0,$past->month,1,$past->year);
				$forDisplay = __(date("F", $timestampfordisplay));
				$forDisplay .= " ".date("Y", $timestampfordisplay);


				if ($past) {
					$link = get_month_link($past->year, $past->month);
					$text = $forDisplay;
				}
				break;
			case 8:
				//archive is day YYYYMMDD
				$thisYear = substr($m, 0, 4);
				$thisMonth = substr($m, 4, 2);
				$thisDay = substr($m, 6, 2);
				
				if (substr($thisDay,0,1) == '0')
					$thisDay = substr($m, 7, 1);

				if (substr($thisMonth,0,1) == '0')
					$thisMonth = substr($m, 5, 1);

				$thisDay = (int)$thisDay;
				$thisMonth = (int)$thisMonth;
				$thisYear = (int)$thisYear;
				
				$timestamp = mktime(0, 0, 0, $thisMonth, $thisDay+1, $thisYear);

				$currentdate = date("Y-m-d G:i:s", $timestamp);
				//echo $currentdate;

				$past = $wpdb->get_row("SELECT post_date, YEAR(post_date) as year, MONTH(post_date) as month, DAYOFMONTH(post_date) as day FROM $tableposts WHERE post_date >= '".$currentdate."' AND post_type='post' AND post_status='publish' ORDER BY post_date ASC");
				$timestampfordisplay = mktime(0,0,0,$past->month,$past->day,$past->year);
				$forDisplay = __(date("F", $timestampfordisplay));
				$forDisplay .= " ".date("j, Y", $timestampfordisplay);


				if ($past) {
					$link = get_day_link($past->year,$past->month,$past->day);
					$text = $forDisplay;
				}
				break;
		}
		if($user_text != '') $text = str_replace('%title',$text,$user_text);
		if($link) echo $before.'<a href="'.$link.'">'.$text.'</a>'.$after;
	}
}

add_action('admin_menu', 'depo_add_theme_page');

function depo_add_theme_page() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
		if ( isset( $_POST['action'] ) && 'save' == $_POST['action'] ) {
			if(isset($_POST['author-name'])) {
				check_admin_referer('depo-name');
				if ( '' == $_POST['author-name'] ) {
					delete_option('depo-author-name');
				} else {
					update_option('depo-author-name', attribute_escape($_POST['author-name']));
				}
				wp_redirect("themes.php?page=functions.php&saved=true");
				die;
			}
			
		}
	}
	add_theme_page(__('DePo Options', 'depo-masthead'), __('DePo Options', 'depo-masthead'), 'edit_themes', basename(__FILE__), 'depo_theme_page');
}
function depo_theme_page() {
	if ( isset( $_REQUEST['saved'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.', 'depo-masthead').'</strong></p></div>';
	?>
	<div class='wrap'>
	<form method="post" action="<?php echo attribute_escape($_SERVER['REQUEST_URI']); ?>">
		<?php wp_nonce_field('depo-name'); ?>
		<p><label for="author-name"><?php _e('Author Box Text:', 'depo-masthead'); ?></label> <input type="text" name="author-name" value="<?php echo get_option('depo-author-name'); ?>" id="author-name" /> <small><?php _e('Leaving this field blank will insert the blog author\'s name.', 'depo-masthead'); ?></small></p>
		<p><input type="hidden" name="action" value="save" /> <input type="submit" name="submit" value="<?php echo attribute_escape(__('Submit', 'depo-masthead')); ?>" id="submit" /></p>
		
	</form>
	</div>
<?php }
?>
