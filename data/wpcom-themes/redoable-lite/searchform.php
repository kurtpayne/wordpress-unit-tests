<?php if (!is_search()) {
		$search_text = __('search blog archives','redo_domain');
	} else {
		$search_text = the_search_query();
	}
?>
<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="<?php echo (preg_match('/Safari/', $_SERVER['HTTP_USER_AGENT'])) ? 'search" results="5 autosave="com.domain.search' : 'text'; ?>" name="s" id="s" onblur="this.value=(this.value=='') ? '<?php echo $search_text ?>' : this.value;" onfocus="this.value=(this.value=='<?php echo $search_text ?>') ? '' : this.value;" id="supports" name="s" value="<?php echo $search_text; ?>" size="15"  />
	<input type="submit" id="searchsubmit" value="<?php _e('GO','redo_domain'); ?>" />
</form>
