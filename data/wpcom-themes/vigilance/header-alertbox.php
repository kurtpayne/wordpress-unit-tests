<?php //Load Variables
  $alertbox_state = get_option('V_alertbox_state'); 
  $alertbox_title = get_option('V_alertbox_title');
  $alertbox_content = get_option('V_alertbox_content');
?> 

<?php
if ($alertbox_state == 'On') {?>
  <div class="alert-box entry">
    <h2><?php echo stripslashes(wp_filter_post_kses($alertbox_title)); ?></h2>

    <?php echo stripslashes(wp_filter_post_kses($alertbox_content)); ?>
  </div><!--end alert-box-->
<?php 
} ?>
