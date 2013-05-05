
    <div>
    <form id="searchform" name="searchform" method="get" action="/?s=">
	<input type="text" id="livesearch" name="s" value="<?php _e('search this site', 'kubrick'); ?>" onblur="this.value=(this.value=='') ? '<?php _e('search this site', 'kubrick'); ?>' : this.value;" onfocus="this.value=(this.value=='<?php _e('search this site', 'kubrick'); ?>') ? '' : this.value;" />
	<input type="submit" id="searchsubmit" style="display: none;" value="<?php _e('Search', 'kubrick'); ?>" />
    </form>
    </div>
