<?php
/*
Filename: 		functions.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

$content_width = 440;

load_theme_textdomain('gluedideas_subtle');

class themeGluedIdeas_Subtle {

	function addOptions () {

		if (isset($_POST['gi_subtle_reset'])) { themeGluedIdeas_Subtle::initOptions(true); }

		if (isset($_POST['gi_subtle_save'])) {

			$aOptions = themeGluedIdeas_Subtle::initOptions(false);

			$aOptions['errors'] = array();

			$aOptions['style'] = $_POST['gi_subtle_style'];
			$aOptions['description'] = stripslashes($_POST['gi_subtle_description']);
			$aOptions['lead_count'] = $_POST['gi_subtle_lead_count'];
			$aOptions['lead_cats'] = $_POST['gi_subtle_lead_cats'];
			$aOptions['feedburner'] = $_POST['gi_subtle_feedburner'];
			$aOptions['feedburner_id'] = $_POST['gi_subtle_feedburner_id'];

			if ($_POST['gi_subtle_show_archives'] == 'true') {
				$aOptions['show_archives'] = true;
			} else {
				$aOptions['show_archives'] = false;
			}

			if ($_POST['gi_subtle_show_metalinks'] == 'true') {
				$aOptions['show_metalinks'] = true;
			} else {
				$aOptions['show_metalinks'] = false;
			}

			$aOptions['archives_cat'] = $_POST['gi_subtle_archives_cat'];

			if ($_POST['gi_subtle_show_subpages'] == 'true') {
				$aOptions['show_subpages'] = true;
			} else {
				$aOptions['show_subpages'] = false;
			}
			
			if ($_POST['gi_subtle_show_feedflare'] == 'true') {
				$aOptions['show_feedflare'] = true;
			} else {
				$aOptions['show_feedflare'] = false;
			}

			if ($_POST['gi_subtle_show_gravatar'] == 'true') {
				$aOptions['show_gravatar'] = true;
			} else {
				$aOptions['show_gravatar'] = false;
			}

			$aOptions['gravatar_rating'] = $_POST['gi_subtle_gravatar_rating'];
			$aOptions['gravatar_default'] = $_POST['gi_subtle_gravatar_default'];
			
			// Handle header creation if a valid JPG was sent
			$sStyleFolder = get_theme_root() . '/' . get_template() . '/styles/' . $aOptions['style'] . '/';

			if (is_uploaded_file($_FILES['gi_subtle_header']['tmp_name']) || $_POST['gi_subtle_reset_header'] == 'true') {
				if (file_exists($sStyleFolder . 'generator.php')) {
					include_once($sStyleFolder . 'generator.php');
					$aOptions['errors'] = generateHeader($sStyleFolder, $_POST['gi_subtle_reset_header']);
				} else {
					$aOptions['errors'][] = __('This theme style does not support uploadable headers', 'gluedideas_subtle');
				}
			}

			update_option('gi_subtle_theme', $aOptions);

		}
		
		add_theme_page("Glued Ideas 'Subtle' Theme Options", "Current Theme Options", 'edit_themes', basename(__FILE__), array('themeGluedIdeas_Subtle', 'displayOptions'));
	}
	
	function initOptions ($bReset) {
		$aOptions = get_option('gi_subtle_theme');
		if (!is_array($aOptions) || $bReset) {
			$aOptions['style'] = 'default';
			$aOptions['description'] = '<h2>Welcome to ' . get_bloginfo('name') . '</h2><p>Thank you for taking the time to visit my blog!  Take a second to peek around and check out some of my previous posts.  Of course, I would love to find out what you think as well, so make sure to comment.  See you around!</p><ul class="links"><li class="icon information"><a href="/?page_id=2"><span>Find out more...</span></a></li></ul>';
			$aOptions['lead_count'] = 1;
			$aOptions['lead_cats'] = '';
			$aOptions['feedburner'] = '';
			$aOptions['feedburner_id'] = '';
			$aOptions['show_archives'] = false;
			$aOptions['archives_cat'] = 'Uncategorized';
			$aOptions['show_subpages'] = false;
			$aOptions['show_feedflare'] = false;
			update_option('gi_subtle_theme', $aOptions);
		}
		return $aOptions;
	}

	function displayOptions () {
		$aOptions = themeGluedIdeas_Subtle::initOptions(false);

		// Get the styles folder listing
		$sStyleFolder = TEMPLATEPATH . '/styles/';
		$aStyleFolder = array();
		$objStyleFolder = dir($sStyleFolder);
		while (false !== ($sFile = $objStyleFolder->read())) {
			 if (is_dir($sStyleFolder . $sFile) && $sFile != '.' &&  $sFile != '..') {
			 	$aStyleFolder[] = $sFile;
			 }
		}
		$objStyleFolder->close();

?>
<div class="wrap">
	<h2>Glued Ideas Themes - Subtle</h2>
	<p><?php _e('Based on a joke my brother-in-law made, Subtle is the first public theme released by Glued Ideas.  Designed for sites that have multiple authors, Subtle also makes use of WordPress Widgets, making customization a snap.  For more information about this and other themes from Glued Ideas, <a href="http://blog.gluedideas.com">visit us at our blog</a>.', 'gluedideas_subtle'); ?></p>
<?php
	if (count($aOptions['errors']) > 0) {
		echo ('<div class="error"><p>' . __('The following errors occured when saving your options:', 'gluedideas_subtle') . '</p><ul>');
		foreach($aOptions['errors'] as $sError) {
			echo ('<li>' . $sError . '</li>');
		}
		echo ('</ul></div>');
		$aOptions['errors'] = array();
		update_option('gi_subtle_theme', $aOptions);
	}
?>
	<form action="#" method="post" enctype="multipart/form-data" name="gi_subtle_form" id="gi_subtle_form">
		<fieldset name="general_options" class="options">
			<legend><?php _e('Theme Specific Options', 'gluedideas_subtle'); ?></legend>
			<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Theme Style', 'gluedideas_subtle'); ?></th> 
					<td><select name="gi_subtle_style" size="1">
<?php
		if (is_array($aStyleFolder)) {
			foreach ($aStyleFolder as $sStyle) {
				if ($sStyle == $aOptions['style']) {
					$sSelected = ' selected ';
				} else {
					$sSelected = '';
				}
				echo '<option value="' . $sStyle . '"' . $sSelected . '>' . $sStyle . '</option>' . "\n";
			}
		} else {
			echo '<option value="0">' . __('Please install a valid style in the /styles/ folder.', 'gluedideas_subtle') . '</option>';
		}
?>
					</select>
					<br /><?php _e('Select a style for this theme.  Find more styles at our <a href="http://blog.gluedideas.com/">development blog</a>.', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Upload Header', 'gluedideas_subtle'); ?></th> 
					<td><input name="gi_subtle_header" id="gi_subtle_header" type="file" size="50" />
					<br /><?php _e('Select an image from your computer to use as your header image.<br />Note: File dimensions should be 820 x 145 pixels.', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Reset Header', 'gluedideas_subtle'); ?></th> 
					<td><input name="gi_subtle_reset_header" type="checkbox" value="true" /><?php _e('Reset the Default style\'s header.', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Show Metalinks', 'gluedideas_subtle'); ?></th> 
					<td><?php if ($aOptions['show_metalinks'] == true) { echo ('<input name="gi_subtle_show_metalinks" type="checkbox" value="true" checked>'); } else { echo ('<input name="gi_subtle_show_metalinks" type="checkbox" value="true">'); } ?> <?php _e('Show Comment Number and Technorati / Digg / Delicious links with posts.', 'gluedideas_subtle'); ?></td> 
				</tr>

				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Show Sub-Pages', 'gluedideas_subtle'); ?></th> 
					<td><?php if ($aOptions['show_subpages'] == true) { echo ('<input name="gi_subtle_show_subpages" type="checkbox" value="true" checked>'); } else { echo ('<input name="gi_subtle_show_subpages" type="checkbox" value="true">'); } ?> <?php _e('Show sub-pages when viewing a page.', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Site Description', 'gluedideas_subtle'); ?></th> 
					<td><textarea name="gi_subtle_description" cols="50" rows="10" id="gi_subtle_description"><?php echo($aOptions['description']); ?></textarea><br /><?php _e('If a description for the site is given here, it will be displayed as a prominent information box on the home page.', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Number of Leads', 'gluedideas_subtle'); ?></th> 
					<td><input name="gi_subtle_lead_count" type="text" id="gi_subtle_lead_count" value="<?php echo($aOptions['lead_count']); ?>" size="2" />
					<br /><?php _e('The number of posts on the home page to be shown as "lead stories" - these will display with their full-text (up to the "more" tag).', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Categories to Display', 'gluedideas_subtle'); ?></th> 
					<td><input name="gi_subtle_lead_cats" type="text" id="gi_subtle_lead_cats" value="<?php echo($aOptions['lead_cats']); ?>" size="50" />
					<br /><?php _e('Display only the categories you want to display in your front-page loop.  Just provide a comma-separated list of category slugs you\'d like to use.', 'gluedideas_subtle'); ?></td> 
				</tr>
			</table>
		</fieldset>

		<?php if (function_exists('gravatar')) : ?>

		<fieldset name="gravatar_options" class="options">
			<legend><?php _e('Gravatar Options', 'gluedideas_subtle'); ?></legend>
			<p><?php _e('Allow your readers to show off their personalities in comments through <a href="http://gravatar.com">Gravatars</a>.', 'gluedideas_subtle'); ?></p>
			<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Show Gravatars', 'gluedideas_subtle'); ?></th> 
					<td><?php if ($aOptions['show_gravatar'] == true) { echo ('<input name="gi_subtle_show_gravatar" type="checkbox" value="true" checked>'); } else { echo ('<input name="gi_subtle_show_gravatar" type="checkbox" value="true">'); } ?> <?php _e('Show gravatars on comments (replaces comment number).', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Default Gravatar URL', 'gluedideas_subtle'); ?></th> 
					<td><input name="gi_subtle_gravatar_default" type="text" id="gi_subtle_gravatar_default" value="<?php echo($aOptions['gravatar_default']); ?>" size="50" /><br /><?php _e('Provide a URL to the default image used when a user doesn\'t have a gravatar.', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Gravatar Rating', 'gluedideas_subtle'); ?></th> 
					<td><input name="gi_subtle_gravatar_rating" type="text" id="gi_subtle_gravatar_rating" value="<?php echo($aOptions['gravatar_rating']); ?>" size="50" /><br /><?php _e('Is your site PG rated?  Check out the Gravatar site for more information.', 'gluedideas_subtle'); ?></td> 
				</tr>
			</table>
		</fieldset>

		<?php endif; ?>

		<fieldset name="feedburner_options" class="options">
			<legend><?php _e('Feedburner Options', 'gluedideas_subtle'); ?></legend>
			<p><?php _e('Make reading your RSS feeds easier for your audience by signing up with <a href="http://www.feedburner.com">FeedBurner</a>.', 'gluedideas_subtle'); ?></p>
			<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('E-mail Subscription (Feed ID)', 'gluedideas_subtle'); ?></th> 
					<td><input name="gi_subtle_feedburner_id" type="text" id="gi_subtle_feedburner_id" value="<?php echo($aOptions['feedburner_id']); ?>" size="50" /><br /><?php _e('If you have enabled e-mail subscriptions, type the numeric ID for your feed.  You can find this by going to "My Feeds" and then clicking on the feed for this blog.  The URL will end with "?id=XXXXXXX" - that number is the Feed ID.', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Feedburner Link', 'gluedideas_subtle'); ?></th> 
					<td><input name="gi_subtle_feedburner" type="text" id="gi_subtle_feedburner" value="<?php echo($aOptions['feedburner']); ?>" size="50" /><br /><?php _e('The URL that people go to for this feed.', 'gluedideas_subtle'); ?></td> 
				</tr>
				<tr valign="top"> 
					<th width="33%" scope="row"><?php _e('Show Feedflare', 'gluedideas_subtle'); ?></th> 
					<td><?php if ($aOptions['show_feedflare'] == true) { echo ('<input name="gi_subtle_show_feedflare" type="checkbox" value="true" checked>'); } else { echo ('<input name="gi_subtle_show_feedflare" type="checkbox" value="true">'); } ?> <?php _e('Show FeedFlare on my posts.', 'gluedideas_subtle'); ?></td> 
				</tr>
			</table>
		</fieldset>

		<p class="submit"><input type="submit" name="gi_subtle_reset" value="Reset" /></p>
		<p class="submit"><input type="submit" name="gi_subtle_save" value="Save" /></p>
	</form>
</div>
<?php
	}
}

// Register functions
add_action('admin_menu', array('themeGluedIdeas_Subtle', 'addOptions'));

// Add widget support
if ( function_exists('register_sidebar') ) {

	register_sidebars(2, array('name' => 'Sidebar_%d', 'before_widget' => '<div id="%1$s" class="widget home %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>') );
	register_sidebars(3, array('name' => 'Posts_/_Pages_%d', 'before_widget' => '<div id="%1$s" class="widget post %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>') );
	register_sidebars(2, array('name' => 'Archives_%d', 'before_widget' => '<div id="%1$s" class="archive_group %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>') );
	register_sidebars(3, array('name' => 'Advert_%d', 'before_widget' => '<div id="%1$s" class="advert %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>') );
}

?>