<?php
/*
Hack Name: WordPress Theme Toolkit
Plugin URI: http://frenchfragfactory.net/ozh/my-projects/wordpress-theme-toolkit-admin-menu/
Description: Helps theme authors set up an admin menu. Helps theme users customise the theme.
Version: 1.12
Author: Ozh
Author URI: http://planetOzh.com/
*/

/************************************************************************************
*							 DO NOT MODIFY THIS FILE !
************************************************************************************/

/* RELEASE HISTORY :
* 1.0 : initial release
* 1.1 : update for WordPress 2.0 compatibility
* 1.11 : added {separator} template
* 1.12 : more or less minor bug fixing (one when no plugin activated, other with rare mod_security issue) and better compliancy with WP 2.0 roles
*/

if (!function_exists('themetoolkit')) {
	function themetoolkit($theme='',$array='',$file='') {
		global ${$theme};
		if ($theme == '' or $array == '' or $file == '') {
			die ('No theme name, theme option, or parent defined in Theme Toolkit');
		}
		${$theme} = new ThemeToolkit($theme,$array,$file);
	}
}

if (!class_exists('ThemeToolkit')) {
	class ThemeToolkit{

		var $option, $infos;

		function ThemeToolkit($theme,$array,$file){
			
			global $wp_version;

/*			// is it WP 2.0+ and do we have plugins like "../themes/foo/functions.php" running ?
			if ( $wp_version >= 2 and count(@preg_grep('#^\.\./themes/[^/]+/functions.php$#', get_settings('active_plugins'))) > 0 ) {
				wp_cache_flush();
				$this->upgrade_toolkit();
			}
*/			
			$this->infos['path'] = '../themes/' . basename(dirname($file));

			/* Create some vars needed if an admin menu is to be printed */
			if ($array['debug']) {
				if ((basename($file)) == $_GET['page']) $this->infos['debug'] = 1;
				unset($array['debug']);
			}
			if ((basename($file)) == $_GET['page']){
				$this->infos['menu_options'] = $array;
				$this->infos['classname'] = $theme;
			}
			$this->option=array();

			/* Check this file is registered as a plugin, do it if needed */
//			$this->pluginification();

			/* Get infos about the theme and particularly its 'shortname'
			 * which is used to name the entry in wp_options where data are stored */
			$this->do_init();

			/* Read data from options table */
			$this->read_options();

			/* Are we in the admin area ? Add a menu then ! */
			$this->file = $file;
			add_action('admin_menu', array(&$this, 'add_menu'));
		}


		/* Add an entry to the admin menu area */
		function add_menu() {
			global $wp_version;
			if ( $wp_version >= 2 ) {
				$level = 'edit_themes';
			} else {
				$level = 9;
			}
			//add_submenu_page('themes.php', 'Configure ' . $this->infos[theme_name], $this->infos[theme_name], 9, $this->infos['path'] . '/functions.php', array(&$this,'admin_menu'));
			add_theme_page('Configure ' . $this->infos['theme_name'], 'Theme Options', 'edit_themes', basename($this->file), array(&$this,'admin_menu'));
			/* Thank you MCincubus for opening my eyes on the last parameter :) */
		}

		/* Get infos about this theme */
		function do_init() {
			$themes = get_themes();
			$shouldbe= basename($this->infos['path']);
			foreach ($themes as $theme) {
				$current= basename($theme['Template Dir']);
				if ($current == $shouldbe) {
					if (get_settings('template') == $current) {
						$this->infos['active'] = TRUE;
					} else {
						$this->infos['active'] = FALSE;
					}
				$this->infos['theme_name'] = $theme['Name'];
				$this->infos['theme_shortname'] = $current;
				$this->infos['theme_site'] = $theme['Title'];
				$this->infos['theme_version'] = $theme['Version'];
				$this->infos['theme_author'] = preg_replace("#>\s*([^<]*)</a>#", ">\\1</a>", $theme['Author']);
				}
			}
		}

		/* Read theme options as defined by user and populate the array $this->option */
		function read_options() {
			$options = get_option('theme-'.$this->infos['theme_shortname'].'-options');
			$options['_________junk-entry________'] = 'ozh is my god';
			foreach ($options as $key=>$val) {
				$this->option["$key"] = stripslashes($val);
			}
			array_pop($this->option);
			return $this->option;
			/* Curious about this "junk-entry" ? :) A few explanations then.
			 * The problem is that get_option always return an array, even if
			 * no settings has been previously saved in table wp_options. This
			 * junk entry is here to populate the array with at least one value,
			 * removed afterwards, so that the foreach loop doesn't go moo. */
		}

		/* Write theme options as defined by user in database */
		function store_options($array) {
			update_option('theme-'.$this->infos['theme_shortname'].'-options','');
			if (update_option('theme-'.$this->infos['theme_shortname'].'-options',$array)) {
				return "Options successfully stored";
			} else {
				return "Could not save options !";
			}
		}

		/* Delete options from database */
		  function delete_options() {
			/* Remove entry from database */
			delete_option('theme-'.$this->infos['theme_shortname'].'-options');
			/* Unregister this file as a plugin (therefore remove the admin menu) */
			$this->depluginification();
			/* Revert theme back to Kubrick if this theme was activated */
			if ($this->infos['active']) {
				update_option('template', 'default');
				update_option('stylesheet', 'default');
				do_action('switch_theme', 'Default');
			}
			/* Go back to Theme admin */
			print '<meta http-equiv="refresh" content="0;URL=themes.php?activated=true">';
			echo "<script> self.location(\"themes.php?activated=true\");</script>";
			exit;
		}

		/* Check if the theme has been loaded at least once (so that this file has been registered as a plugin) */
		function is_installed() {
			global $wpdb;
			$where = 'theme-'.$this->infos['theme_shortname'].'-options';
			$check = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->options WHERE option_name = '$where'");
			if ($check == 0) {
				return FALSE;
			} else {
				return TRUE;
			}
		}

		/* Theme used for the first time (create blank entry in database) */
		function do_firstinit() {
			global $wpdb;
			$options = array();
			foreach(array_keys($this->option) as $key) {
				$options["$key"]='';
			}
			add_option('theme-'.$this->infos['theme_shortname'].'-options',$options, 'Options for theme '.$this->infos['theme_name']);
//			return "Theme options added in database (1 entry in table '". $wpdb->options ."')";
		}

		/* The mother of them all : the Admin Menu printing func */
		function admin_menu () {
			global $cache_settings, $wpdb;

			/* Process things when things are to be processed */
			if (@$_POST['action'] == 'store_option') {
				unset($_POST['action']);
				$msg = $this->store_options($_POST);
			} elseif (@$_POST['action'] == 'delete_options') {
				$this->delete_options();
			} elseif (!$this->is_installed()) {
				$msg = $this->do_firstinit();
			}

			if (@$msg) print "<div class='updated'><p><b>" . $msg . "</b></p></div>\n";

			if (!$this->infos['active']) { /* theme is not active */
				echo '<p>(Please note that this theme is currently <strong>not activated</strong> on your site as the default theme.)</p>';
			}

			$cache_settings = '';
			$check = $this->read_options();
			
			echo "<div class='wrap'><h2>Layout Options</h2>";
			echo '<p>This theme allows you to configure some variables to suit your blog, which are :</p>
			<form action="" method="post">
			<input type="hidden" name="action" value="store_option" />
			<table cellspacing="2" cellpadding="5" border="0" width=100% class="editform">';

			/* Print form, here comes the fun part :) */
			foreach ($this->infos['menu_options'] as $key=>$val) {
				$items='';
				preg_match('/\s*([^{#]*)\s*({([^}]*)})*\s*([#]*\s*(.*))/', $val, $matches);
				if ($matches[3]) {
					$items = split("\|", $matches[3]);
				}

				print "<tr valign='top'><th scope='row' width='33%'>\n";
				if (@$items) {
					$type = array_shift($items);
					switch ($type) {
					case 'separator':
						print '<h3>'.$matches[1]."</h3></th>\n<td>&nbsp;</td>";
						break;
					case 'radio':
						print $matches[1]."</th>\n<td>";
						while ($items) {
							$v=array_shift($items);
							$t=array_shift($items);
							$checked='';
							if ($v == $this->option[$key]) $checked='checked';
							print "<label for='${key}${v}'><input type='radio' id='${key}${v}' name='$key' value='$v' $checked /> $t</label>";
							if (@$items) print "<br />\n";
						}
						break;
					case 'textarea':
						$rows=array_shift($items);
						$cols=array_shift($items);
					print "<label for='$key'>".$matches[1]."</label></th>\n<td>";
						print "<textarea name='$key' id='$key' rows='$rows' cols='$cols'>" . $this->option[$key] . "</textarea>";
						break;
					case 'checkbox':
						print $matches[1]."</th>\n<td>";
						while ($items) {
							$k=array_shift($items);
							$v=array_shift($items);
							$t=array_shift($items);
							$checked='';
							if ($v == $this->option[$k]) $checked='checked';
							print "<label for='${k}${v}'><input type='checkbox' id='${k}${v}' name='$k' value='$v' $checked /> $t</label>";
							if (@$items) print "<br />\n";
						}
						break;
					}
				} else {
					print "<label for='$key'>".$matches[1]."</label></th>\n<td>";
					print "<input type='text' name='$key' id='$key' value='" . $this->option[$key] . "' />";
				}

				if ($matches[5]) print '<br/>'. $matches[5];
				print "</td></tr>\n";
			}
			echo '</table>
			<p class="submit"><input type="submit" value="Update Layout &raquo;" /></p>
			</form></div>';
		}

		/* Make this footer part of the real #footer DIV of WordPress admin area */
		function footercut($string) {
			return preg_replace('#</div><!-- footercut -->.*<div id="footer">#m', '', $string);
		}


		/***************************************
		 * Self-Pluginification (TM)(R)(C) . © ®
		 *
		 * The word "Self-Pluginification" and
		 * any future derivatives are licensed,
		 * patented and trademarked under the
		 * terms of the OHYEAHSURE agreement.
		 * Hmmmmmkey ? Fine.
		 **************************************/
		function pluginification () {
			global $wp_version;
			if ($wp_version<2) {		
				$us = $this->infos['path'].'/functions.php';
				$them = get_settings('active_plugins');
				/* Now, are we members of the PPC (Plugins Private Club) yet ? */
				if (!in_array($us,$them)) {
					/* No ? Jeez, claim member card ! */
					$them[]=$us;
					update_option('active_plugins',$them); 
					/* Wow. We're l33t now. */ 
					return TRUE; 
				} else { 
					return FALSE; 
				} 
			}
		} 
		 
		/*************************************** 
		 * De-Pluginification (TM)(R)(C) . © ® 
		 * 
		 * Same legal notice. It's not that I 
		 * really like it, but my lawyer asked 
		 * for it. I swear. 
		 **************************************/ 
		function depluginification () {
			global $wp_version;
			if ($wp_version<2) {
				$us = $this->infos['path'].'/functions.php';
				$them = get_settings('active_plugins');
				if (in_array($us,$them)) {
					$here = array_search($us,$them);
					unset($them[$here]);
					update_option('active_plugins',$them);
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}

		/***************************************
		 * Really, the whole plugin management
		 * system is really neat in WP, and very
		 * easy to use.
		 **************************************/

		/* Clean plugins lists in order to work with WordPress 2.0 */
		function upgrade_toolkit () {
			$plugins=get_settings('active_plugins');
			$delete=@preg_grep('#^\.\./themes/[^/]+/functions.php$#', $plugins);
			$result=array_diff($plugins,$delete);
			$temp = array();
			foreach($result as $item) $temp[]=$item;
			$result = $temp;
			update_option('active_plugins',$result);
			wp_cache_flush;
		}

	}
}

?>
