<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
	<div>
		<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true); ?>" size="40" />
		<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Search &raquo;', 'sandbox') ?>" />
	</div>
</form>