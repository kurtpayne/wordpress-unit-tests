<?php
/*
Filename: 		footer.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

$aOptions = get_option('gi_subtle_theme');

load_theme_textdomain('gluedideas_subtle');

?>
<!-- Footer Start -->
			<br class="clear" />
		
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Advert_2') ) { if (function_exists(displaySubtleAds)) { displaySubtleAds(2); } } ?>

		</div>
	</div>

</div>

<div id="footer">
	<div class="style_content">

<?php if ($aOptions['feedburner_id'] != '') : ?>

		<form action="http://www.feedburner.com/fb/a/emailverify" id="newsletter_signup" method="post" target="popupwindow" onsubmit="window.open('http://www.feedburner.com', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
			<label for="input_email_address" id="label_email_address"><?php _e("E-mail Subscription", 'gluedideas_subtle'); ?></label> <input type="text" id="input_email_address" name="email" class="input" value="" /><input type="image" id="button_email_address" src="<?php bloginfo('stylesheet_directory'); ?>/assets/images/icon_email.gif" align="top" name="submit" value="submit" />
			<input type="hidden" value="http://feeds.feedburner.com/~e?ffid=<?php echo($aOptions['feedburner_id']) ?>" name="url"/>
			<input type="hidden" value="<?php bloginfo('name'); ?>" name="title"/>
		</form>

<?php endif; ?>
		
		<h3 id="footer_title"><a href="<?php echo get_settings('home'); ?>/"><span><?php bloginfo('name'); ?></span></a></h3>
		
		<div id="logos">
			<a href="http://wordpress.org/" class="logo"><img src="<?php bloginfo('stylesheet_directory'); ?>/assets/images/logo_wp.gif" alt="<?php _e("Powered by WordPress", 'gluedideas_subtle'); ?>" align="top" border="0" /></a>
			<a href="http://blog.gluedideas.com/" class="logo"><img src="<?php bloginfo('stylesheet_directory'); ?>/assets/images/logo_gluedideas.gif" alt="<?php _e("Design by Glued Ideas", 'gluedideas_subtle'); ?>" align="top" border="0" /></a>
			<a href="http://www.famfamfam.com/" class="logo"><img src="<?php bloginfo('stylesheet_directory'); ?>/assets/images/logo_famfamfam.gif" alt="<?php _e("Icons by Fam Fam Fam", 'gluedideas_subtle'); ?>" align="top" border="0" /></a>
		</div>
	
		<div id="copyright_notice" class="reduced"><p><?php _e('Unless otherwise specified, all content is made available under the <a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons License</a>.', 'gluedideas_subtle'); ?></p></div>
		
	</div>
</div>
	

<?php wp_footer(); ?>
</body>
</html>

<!-- Footer End -->