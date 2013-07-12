<hr />

<div class="secondary">

<?php /* WordPress Widget Support */ if (function_exists('dynamic_sidebar') and dynamic_sidebar()) { } else { ?>

	<div id="search"><h2><?php _e('Search','k2_domain'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>

	<?php /* Latest Entries */ if ( (is_home()) or (is_search() or (is_404()) or ($notfound == '1')) or (function_exists('is_tag') and is_tag()) or ( (is_archive()) and (!is_author()) ) ) { ?>
	<div class="sb-latest">
		<h2><?php _e('Latest','k2_domain'); ?></h2>
		<span class="metalink"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('RSS Feed for Blog Entries','k2_domain'); ?>" class="feedlink"><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" alt="RSS" /></a></span>

		<ul>
			<?php wp_get_archives('type=postbypost&limit=10'); ?>
		</ul>
	</div>
	<?php } ?>

	<?php /* Links */ if ( (is_home()) and !(is_page()) and !(is_single()) and !(is_search()) and !(is_archive()) and !(is_author()) and !(is_category()) and !(is_paged()) ) { $links_list_exist = @$wpdb->get_var("SELECT link_id FROM $wpdb->links LIMIT 1"); if($links_list_exist) { ?>
	<div class="sb-links">
		<ul>
			<?php wp_list_bookmarks(); ?>
		</ul>
	</div>
	<?php } } ?>


	<?php /* Archives */ if ( (is_archive()) or (is_search()) or (is_paged()) or ($notfound == '1') or (function_exists('is_tag') and is_tag()) ) { ?>
	<div class="sb-months">
		<h2><?php _e('Archives','k2_domain'); ?></h2>
		
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</div>

	<div class="sb-categories">
		<h2><?php _e('Categories','k2_domain'); ?></h2>
		
		<ul>
			<?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?>
		</ul>
	</div>

<?php } ?>
<?Php } ?>

</div>
<div class="clear"></div>
