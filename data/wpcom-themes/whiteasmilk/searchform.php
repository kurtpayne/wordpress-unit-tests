<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<div><input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" /><br />
<input type="submit" id="searchsubmit" value="<?php _e('Search','whiteasmilk'); ?>" />
</div>
</form>