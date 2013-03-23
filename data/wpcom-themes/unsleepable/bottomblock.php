<hr />
<div id="glass-bottomblock">
<?php /* WordPress Widget Support */ if (function_exists('dynamic_sidebar') and dynamic_sidebar('bottom-bar')) { } else { ?>

	<div class="bottomblockleft">
		<h2><?php _e('Recent Entries','k2_domain'); ?></h2>
		<div class="sb-latest">
		<ul>
			<?php wp_get_archives('type=postbypost&limit=11'); ?>	
		</ul>
		</div>
	</div>

	<div class="bottomblockmiddle">	
		<h2><?php _e('Categories','k2_domain'); ?></h2>
		<div class="sb-categories">
		<ul>
			<?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?>
		</ul>
		</div>
	</div>

	<div class="bottomblockright">
		<h2><?php _e('Archives','k2_domain'); ?></h2>		
		<div class="sb-months">
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
		</div>
	</div>
	
<?php } ?>
</div>
