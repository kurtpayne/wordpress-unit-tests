<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<p>
<input size="12" type="text" value="<?php echo attribute_escape(apply_filters('the_search_query', get_search_query())); ?>" name="s" id="s" /><input class="btn" type="submit" id="searchsubmit" value="<?php _e('Search',TEMPLATE_DOMAIN); ?>" />
</p>
</form>
