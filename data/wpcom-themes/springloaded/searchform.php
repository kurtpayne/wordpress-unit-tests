<form method="get" action="<?php bloginfo('url'); ?>/">
<p><input type="text" name="s" onblur="this.value=(this.value=='') ? '<?php _e('Search this Blog', 'springloaded'); ?>' : this.value;" onfocus="this.value=(this.value=='<?php _e('Search this Blog', 'springloaded'); ?>') ? '' : this.value;" value="<?php _e('Search this Blog', 'springloaded'); ?>" id="s" />
<input type="submit" name="submit" value="Search" id="some_name"></p>
</form>
