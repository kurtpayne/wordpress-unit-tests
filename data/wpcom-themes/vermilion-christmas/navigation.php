<div class="navigation">
<?php if ( $paged < 2 ) { // Do stuff specific to first page?>
<?php next_posts_link('<span class="previous">Previous Entries</span>') ?>
<?php } else { // Do stuff specific to non-first page ?>
<?php next_posts_link('<span class="previous">Previous Entries</span>') ?> &nbsp;|&nbsp; <?php previous_posts_link('<span class="next">Next Entries</span>') ?>
<?php } ?>
</div>