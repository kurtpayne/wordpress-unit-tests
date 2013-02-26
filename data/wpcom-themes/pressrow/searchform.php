<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
	<p style="margin-bottom: 5px;"><input type="text" class="text_input" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" /></p>
	<p style="margin-bottom: 0;"><input type="submit" id="searchsubmit" value="<?php echo attribute_escape(__('Search')); ?>" /></p>
</form>
