===========
INSTALLATION
===========

- Unzip the downloaded file. You'll get a folder named "digg-3-col"
- Upload the entire "digg-3-col" folder to your 'wp-content/themes/" folder
- Login into WordPress administration
- Click on the 'Presentation" tab
- Click on the "digg-3-col" theme thumbnail/screenshot or title

That's it. Go back to the front page of your blog and hit refresh to see your newly installed theme.

=============
CUSTOMIZATION
=============

Adding items to the top Menu:
- The top menu features two links: Home and About
- To add more links, use a text editor (i.e: Notepad) to open the header.php file and copy and paste:
	<li><a href="<?php echo get_permalink(2); ?>" title="<?php _e('About'); ?>"><?php _e('About'); ?></a></li>
- Remember to edit your link title and the destination of your link within href=" ".

Different Header Background:
- By default, the header uses the bg_header.gif image for the background.
- Check the "images/" sub-folder to see if your like the alternate header background (bg_header_alt.gif).
- Use a text editor (i.e: Notepad) to open up the style.css file, look for #header and change the background image from 'bg_header.gif' to 'bg_header_alt.gif'

=============
TIP
=============

- Use alignleft or alignright to make your images float left or right. For example: <img src="yourimage.gif" class="alignleft">

=============================
THEME USAGE WITH WIDGET ENABLED
=============================

By default, this theme has a search form in the header region. If you enable the widget plugin, don't add the search box to your widget list. If you rather have the search form in the sidebar then add the search box to the widget list, but remember to remove the search form in the header region.

=======
SUPPORT
=======
For all questions and answers, use the Wpdesigner forums at:
http://www.wpdesigner.com/forums/ 