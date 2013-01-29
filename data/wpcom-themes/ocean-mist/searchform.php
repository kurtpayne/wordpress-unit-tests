<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<div><input type="text" value="<?php echo attribute_escape(__('Search','ocean-mist')); ?>" name="s" id="s" onfocus="if (this.value == '<?php echo js_escape(__('Search','ocean-mist')); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo js_escape(__('Search','ocean-mist')); ?>';}" />
<input type="image" src="<?php bloginfo('stylesheet_directory'); ?>/images/button-search.gif" id="searchsubmit" value="Search" />
</div>
</form>
