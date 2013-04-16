<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<div><input type="text" value="<?php echo attribute_escape(__('search archives')); ?>" name="s" id="s" onblur="if (this.value == '') {this.value = '<?php echo js_escape(__('search archives')); ?>';}" onfocus="if (this.value == '<?php echo js_escape(__('search archives')); ?>') {this.value = '';}" />
<input type="submit" id="searchsubmit" />
</div>
</form>
