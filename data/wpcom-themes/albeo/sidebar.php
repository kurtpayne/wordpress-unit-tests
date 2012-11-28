<div class="sr-a">
	<div class="sr-t"></div>
	<div class="sr">

<!--Start Dynamic Sidebar -->
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

	<div class="search-all"><div class="search">
	 <h3><?php _e('Search', 'albeo'); ?></h3>
	  <form id="search" action="<?php bloginfo('url'); ?>/">
	    <fieldset>
	    <input type="text" value="<?php the_search_query(); ?>" name="s" style="width: 200px;" />
	    </fieldset>
	    </form>
	</div></div>

	<?php albeo_selector(); ?>
	
	<div class="categ-all"><div class="categ"> 
	<h3><?php _e('Categories', 'albeo'); ?></h3> 
	<ul> 
		<?php wp_list_categories('show_count=1&title_li='); ?> 
	</ul> 
	</div></div>

	<div class="widget"><div class="widget-all">
	 <h3><?php _e('Archives', 'albeo'); ?></h3>
	  <ul>
	   <?php wp_get_archives('type=monthly'); ?>
	  </ul>
	</div></div>

<?php endif; ?>
<!--End Dynamic Sidebar -->

	</div>
	<div class="sr-b"></div>
</div>
