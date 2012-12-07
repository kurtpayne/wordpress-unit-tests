<?php if (!is_search()) {
		$search_text = __('search');
	} else {
		$search_text = the_search_query();
	}
?>

<form method="get" id="searchform" action="/">
	<input type="text" id="s" name="s" onblur="this.value=(this.value=='') ? '<?php echo $search_text ?>' : this.value;" onfocus="this.value=(this.value=='<?php echo $search_text ?>') ? '' : this.value;" id="supports" name="s" value="<?php echo $search_text; ?>" />
	<input type="submit" id="searchsubmit" value="<?php _e('go','k2_domain'); ?>" />
</form>


