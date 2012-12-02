<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
<input type="text" class="search_input" value="<?php echo attribute_escape(__('To search, type and hit enter','cutline')); ?>" name="s" id="s" onfocus="if (this.value == '<?php echo js_escape(__('To search, type and hit enter','cutline')); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo js_escape(__('To search, type and hit enter','cutline')); ?>';}" />
<input type="hidden" id="searchsubmit" value="<?php echo attribute_escape(__('Search','cutline')); ?>" />
</form>
