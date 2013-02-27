	<?php /*
		This navigation is used on most pages to move back and forth in your archives.
		It has been placed in its own file so it's easier to change across all of K2
	*/ ?>

	<hr />

	<?php if (is_single()) { ?>

	<div class="navigation">
		<?php previous_post('<div class="left"><span>&laquo;</span> %</div>','','yes') ?>
		<?php next_post('<div class="right">% <span>&raquo;</span></div>','','yes') ?>
		<div class="clear"></div>
	</div>

	<?php } else { ?>
		
	<?php //global $pagenow; echo $pagenow; ?>
		
	<div class="navigation">
	<?php $_SERVER['REQUEST_URI']  = preg_replace("/(.*?).php(.*?)&(.*?)&(.*?)&_=/","$2$3",$_SERVER['REQUEST_URI']); ?>
		<div class="left"><?php next_posts_link('<span>&laquo;</span> '.__('Previous Entries','k2_domain').''); ?></div>
		<div class="right"><?php previous_posts_link(''.__('Next Entries','k2_domain').' <span>&raquo;</span>'); ?></div>
		<div class="clear"></div>
	</div>

	<?php } ?>

	<hr />
