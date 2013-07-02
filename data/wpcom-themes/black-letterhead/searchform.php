<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="text" value="<?php echo wp_specialchars(get_search_query(), true); ?>" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="<?php echo attribute_escape(__('Search', 'black-letterhead')); ?>" />
</div>
</form>
