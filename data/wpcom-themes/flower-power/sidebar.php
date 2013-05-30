
<!-- subcontent ................................. -->
<div id="side">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
</div>
<?php return; endif; ?>
<?php if (is_home() || is_page() || is_single() || is_page("archives") || is_archive() || is_search()) { ?>
	
	<center>
	<form action="<?php bloginfo('home'); ?>/" method="get">
			<input style="width:120px;" value="<?php echo wp_specialchars(get_search_query(), 1); ?>" name="s" id="s" />
			<div style="padding:3px 0px 0px 0px;"></div>
			<input style="width:100px;font-size:11px;font-family:Arial,Verdana;" type="submit" value="   Search   " id="searchbutton" name="searchbutton" />
	</form>
	</center>

<h3><em><?php _e('Pages', 'flower-power'); ?></em></h3>

<ul>
<?php wp_list_pages('title_li=' ); ?>
</ul>

	<h3><em><?php _e('Categories', 'flower-power'); ?></em></h3>

	<ul class="categories">
	<?php wp_list_categories('sort_column=name&hide_empty=0&title_li='); ?> 
	</ul>

<?php if(!is_single()) { ?>

	<h3><em><?php _e('Links', 'flower-power'); ?></em></h3>

	<ul class="links">
	<?php //get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
	<?php wp_list_bookmarks('title_li=&categorize=0'); ?>	
	</ul>

	<h3><em><?php _e('Meta', 'flower-power'); ?></em></h3>

	<ul class="meta">
	<li><?php wp_loginout(); ?></li>
	<li><a href="<?php bloginfo_rss('rss2_url'); ?> "><?php _e('Entries (RSS)', 'flower-power'); ?></a></li>
	<li><a href="<?php bloginfo_rss('comments_rss2_url'); ?> "><?php _e('Comments (RSS)', 'flower-power'); ?></a></li>
	</ul>
	
<?php } ?>

<?php } ?>


<?php if (is_single() || is_page() || is_home()) { ?>

	<h3><em><?php _e('Calendar', 'flower-power'); ?></em></h3>

	<?php get_calendar() ?>


<?php } ?>


<?php if (is_page("archives") || is_archive() || is_search()) { ?>

	<h3><em><?php _e('Calendar', 'flower-power'); ?></em></h3>

	<?php get_calendar() ?>

	<?php if (!is_page("archives")) { ?>

		<h3><em><?php _e('Posts by Month', 'flower-power'); ?></em></h3>

		<ul class="months">
		<?php //get_archives('monthly','','','<li>','</li>',''); ?>
		<?php wp_get_archives(); ?>
		</ul>

	<?php } ?>

	<h3><em><?php _e('Posts by Category', 'flower-power'); ?></em></h3>

	<ul class="categories">
	<?php wp_list_categories(); ?> 
	</ul>

<?php } ?>


</div> <!-- /subcontent -->