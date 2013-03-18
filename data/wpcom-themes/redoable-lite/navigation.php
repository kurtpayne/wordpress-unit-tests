	<?php /*
		This navigation is used on most pages to move back and forth in your archives.
		It has been placed in its own file so it's easier to change across all of K2/Redoable
	*/ ?>

	<hr />

	<?php if (is_single()) { ?>

	<div class="navigation">
		<?php previous_post('<div class="left"><span>&laquo;</span> %</div>','','yes') ?>
		<?php next_post('<div class="right">% <span>&raquo;</span></div>','','yes') ?>
		<div class="clear"></div>
	</div>

	<?php } else { ?>
		
	<?php /* global $pagenow; echo $pagenow; */ $redo_asidescategory = 0; ?>
		
	<div class="navigation <?php if ( is_home() and $redo_asidescategory != 0 ) { echo 'rightmargin'; } ?>">
		<div class="left"><?php next_posts_link('<span>&laquo;</span> '.__('Previous Entries','redo_domain').''); ?></div>
		<div class="right"><?php previous_posts_link(''.__('Next Entries','redo_domain').' <span>&raquo;</span>'); ?></div>
		<div class="clear"></div>
	</div>

	<?php } ?>

	<hr />
