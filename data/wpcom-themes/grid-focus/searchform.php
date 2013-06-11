<?php
/**
 *	@package WordPress
 *	@subpackage Grid_Focus
 */
?>
<div>
	<form method="get" id="searchForm" action="<?php bloginfo('home'); ?>/">
	<span><input type="text" value="Search the archives..." onfocus="if (this.value == 'Search the archives...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search the archives...';}" name="s" id="s" /></span>
	</form>
</div>