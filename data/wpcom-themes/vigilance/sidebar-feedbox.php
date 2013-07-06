<?php 
  $feed_title = get_option('V_feed_title'); 
  $feed_intro = get_option('V_feed_intro');
  $feed_email = get_option('V_feed_email');
?>
    <h2 class="widgettitle"><?php echo $feed_title; ?></h2>
    <div id="rss-feed" class="clear"> 
      <p><?php echo $feed_intro; ?></p>
      <a class ="rss" href="<?php bloginfo('rss2_url'); ?>"><?php _e('Subscribe to RSS', 'vigilance'); ?></a>
      <a class="email" href="<?php echo htmlspecialchars($feed_email, UTF-8); ?>"><?php _e('Receive email updates', 'vigilance'); ?></a>
    </div>
  	