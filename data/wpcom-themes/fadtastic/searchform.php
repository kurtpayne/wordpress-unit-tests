<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/" class="float_right">
<label for="s">Search: </label><input value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" type="text" />
<input id="searchsubmit" value="Search" class="button" type="submit" />
<div class="clear"></div>
</form>