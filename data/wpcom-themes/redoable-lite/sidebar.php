<?php
	$redo_listencategory = get_option('redo_listencategory');
	$redo_listennumber = get_option('redo_listennumber');
	$redo_watchcategory = get_option('redo_watchcategory');
	$redo_watchnumber = get_option('redo_watchnumber');
	$redo_blogrollnumber = get_option('redo_blogrollnumber');
	$twitt_twoo_user_name = get_option('twitt_twoo_user_name');
	
?>
<hr />

<div class="secondary">
	
	
	<div id="current-content">
	
<?php /* WordPress Widget Support */ if (function_exists('dynamic_sidebar') and dynamic_sidebar(1)) { } else { ?>
	
	<div id="search">
		<h2><?php _e('Search','redo_domain'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
	<div class="sb-spacer"></div>

	<div id="dynamic-content"></div>		

	<div class="sb-calendar" style="float:left">
		<?php get_calendar(); ?>
	</div>
	
	<div class="sb-months" style="float:right;width:85px;">
		<h2><?php _e('Months','redo_domain'); ?></h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</div>
	<div class="sb-spacer"></div>
	
	<div class="sb-links">
		<h2><?php _e('Blogroll','redo_domain'); ?></h2>
		<div>
				<?php get_links(-1, '', '', '', false, 'name', false, false, 10, false ); ?>
		</div>
	</div>

	<!-- ?php if (!is_single() and !is_page() and !is_category() and !is_day() and !is_month() and !is_year() and !is_search() and !is_paged()) { ? -->
	
	<div class="sb-spacer"></div>

	<div class="sb-latest">
		<h2><?php _e('Recent Entries','redo_domain'); ?></h2>
		<ul>
			<?php $posts = get_posts('numberposts=10&offset=0'); foreach($posts as $post) : ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<!-- ?php } ? -->
	
	<?php } ?>

	
	</div><!-- .current-content -->

</div>
