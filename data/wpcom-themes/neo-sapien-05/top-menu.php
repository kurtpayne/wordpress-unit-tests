<!-- TOP MENU -->

<div id="menu">
<ul>
<li <?php if(is_home()){echo 'class="current_page_item"';}?>><a href="<?php bloginfo('siteurl'); ?>/" title="Home">Home</a></li>
		<?php wp_list_pages('title_li=&depth=1'); ?>
</ul>
</div>

<!-- END TOP MENU -->


<div id="header"><img src="<?php header_image() ?>" width="480" height="250" alt="" /></div>

