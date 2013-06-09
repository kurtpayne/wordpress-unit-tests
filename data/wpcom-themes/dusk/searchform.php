<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<p>
<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
<input type="submit" id="searchsubmit" value="<?php _e('Search'); ?>" />
</p>
</form>