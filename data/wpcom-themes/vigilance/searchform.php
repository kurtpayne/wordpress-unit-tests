<h2 class="widgettitle"><?php _e('Search', 'vigilance'); ?></h2>
<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
	<div>
    <input type="text" value="<?php _e('type and press enter', 'vigilance'); ?>" name="s" id="s" onfocus="if (this.value == '<?php _e('type and press enter', 'vigilance'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('type and press enter', 'vigilance'); ?>';}" />
    <input type="hidden" value="Search" />
  </div>
</form>
