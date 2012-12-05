
<hr />

<ul class="secondary">

<?php /* WordPress Widget Support */ if (function_exists('dynamic_sidebar') and dynamic_sidebar('main-sidebar')) { } else { ?>

	<li id="search"><h2><?php _e('Search','k2_domain'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>


	<?php /* Menu for subpages of current page */
		global $notfound;
		if (is_page() and ($notfound != '1')) {
			$current_page = $post->ID;
			while($current_page) {
				$page_query = get_post($current_page);
				$current_page = $page_query->post_parent;
			}
			$parent_id = $page_query->ID;
			$parent_title = $page_query->post_title;

			if ($parent_id && !is_attachment()) {
	?>

	<li class="sb-pagemenu">
		<h2><?php echo $parent_title; ?> <?php _e('Subpages','k2_domain'); ?></h2>
		
		<ul>
			<?php wp_list_pages('sort_column=menu_order&title_li=&child_of='. $parent_id); ?>
		</ul>
			
		<?php if ($parent_id != $post->ID) { ?>
			<a href="<?php echo get_permalink($parent_id); ?>"><?php printf(__('Back to %s','k2_domain'), $parent_title ) ?></a>
		<?php } ?>
	</li>
	<?php } } ?>

	
	<?php if (is_attachment()) { ?>
		<li class="sb-pagemenu">
			<a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php printf(__('Back to \'%s\'','k2_domain'), get_the_title($post->post_parent) ) ?></a>
		</li>
	<?php } ?>

	<li class="sb-about">
		
		<?php /* Frontpage */ if (is_home() and !is_paged()) { ?>
		<p><?php echo stripslashes($k2about); ?></p>
		
		<?php /* Category Archive */ } elseif (is_category()) { ?>
		<p><?php printf(__('You are currently browsing the %1$s weblog archives for the %2$s category.','k2_domain'), '<a href="' . get_settings('siteurl') .'">' . get_bloginfo('name') . '</a>', single_cat_title('', false) ) ?></p>

		<?php /* Day Archive */ } elseif (is_day()) { ?>
		<p><?php printf(__('You are currently browsing the %1$s weblog archives for the day %2$s.','k2_domain'), '<a href="' . get_settings('siteurl') .'">' . get_bloginfo('name') . '</a>', get_the_time(__('l, F jS, Y','k2_domain'))) ?></p>

		<?php /* Monthly Archive */ } elseif (is_month()) { ?>
		<p><?php printf(__('You are currently browsing the %1$s weblog archives for the month %2$s.','k2_domain'), '<a href="'.get_settings('siteurl').'">'.get_bloginfo('name').'</a>', get_the_time(__('F, Y','k2_domain'))) ?></p>

		<?php /* Yearly Archive */ } elseif (is_year()) { ?>
		<p><?php printf(__('You are currently browsing the %1$s weblog archives for the year %2$s.','k2_domain'), '<a href="'.get_settings('siteurl').'">'.get_bloginfo('name').'</a>', get_the_time('Y')) ?></p>
		
		<?php /* Search */ } elseif (is_search()) { ?>
		<p><?php printf(__('You have searched the %1$s weblog archives for \'<strong>%2$s</strong>\'. If you are unable to find anything in these search results, you can try one of the following sections.','k2_domain'),'<a href="'.get_settings('siteurl').'">'.get_bloginfo('name').'</a>', wp_specialchars($s)) ?></p>

		<?php /* Author Archive */ } elseif (is_author()) { ?>
		<p><?php printf(__('Archive for <strong>%s</strong>.','k2_domain'), get_the_author()) ?></p>
		<p><?php the_author_description(); ?></p>
		
		<?php /* Paged Archive */ } elseif (is_paged) { ?>
		<p><?php printf(__('You are currently browsing the %s weblog archives.','k2_domain'), '<a href="'.get_settings('siteurl').'">'.get_bloginfo('name').'</a>') ?></p>

		<?php /* Permalink */ } elseif (is_single()) { ?>
		<p><?php next_post('%', __('Next: ','k2_domain'),'yes') ?><br/>
		<?php previous_post('%', __('Previous: ','k2_domain') ,'yes') ?></p>

		<?php } ?>
	</li>
			
	<?php /* Links */ if ( (is_home()) && !(is_page()) && !(is_single()) && !(is_search()) && !(is_archive()) && !(is_author()) && !(is_category()) && !(is_paged()) ) { $links_list_exist = @$wpdb->get_var("SELECT link_id FROM $wpdb->links LIMIT 1"); if($links_list_exist) { ?>
	<li class="sb-links">
		<ul>
			<?php wp_list_bookmarks(); ?>
		</ul>
	</li>
	<?php } } ?>

<?php } ?>
</ul>
<div class="clear"></div>
