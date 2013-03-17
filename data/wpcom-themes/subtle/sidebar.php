<?php
/*
Filename: 		sidebar.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

?>
<h3>Archives</h3>
<ul class="icon category">
	<?php wp_get_archives('type=monthly'); ?>
</ul>

<h3>Meta</h3>
<ul class="icon jump">
	<?php wp_register(); ?>
	<li><?php wp_loginout(); ?></li>
	<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
	<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
	<?php wp_meta(); ?>
</ul>
