<?php 
  $sideimg_state = get_option('V_sideimg_state'); 
  $feed_state = get_option('V_feed_state');
?>
	<div id="sidebar">
  	<?php if ($sideimg_state !== 'Do not show an image') {?>
  		<?php include (TEMPLATEPATH . '/sidebar-imagebox.php'); ?>
  	<?php } ?>
    <?php if ($feed_state == 'Enabled') {?>
  		<?php include (TEMPLATEPATH . '/sidebar-feedbox.php'); ?>
  	<?php } ?>
  	<ul>
  		<?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('Wide Sidebar') ) : ?>
  		<?php endif; ?>
  	</ul>
  	<ul class="thin-sidebar spad">
  		<?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('Left Sidebar') ) : ?>
  		<?php endif; ?>
  	</ul>
  	<ul class="thin-sidebar">
  		<?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('Right Sidebar') ) : ?>
  		<?php endif; ?>
  	</ul>
	</div><!--end sidebar-->