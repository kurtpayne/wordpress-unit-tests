<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '333333'
);

$content_width = 460;

	// WIDGETS
function regulus_widgets_init() {
		register_sidebars(1);

		register_sidebar_widget( __('Calendar'), 'bm_calendar', null, 'calendar' );
}
add_action('widgets_init', 'regulus_widgets_init');

function regulus_add_theme_page() {

	if ( $_GET['page'] == basename(__FILE__) ) {
	
	    // save settings
		if ( 'save' == $_REQUEST['action'] ) {

			update_option( 'regulus_name', $_REQUEST[ 'r_name' ] );
			update_option( 'regulus_email', $_REQUEST[ 'r_email' ] );
			update_option( 'regulus_about', $_REQUEST[ 'r_about' ] );
			update_option( 'regulus_headerImage', $_REQUEST[ 'r_headerImage' ] );
			update_option( 'regulus_colourScheme', $_REQUEST[ 'r_colourScheme' ] );
			update_option( 'regulus_headerImageURL', $_REQUEST[ 'r_headerImageURL' ] );

			
			if( isset( $_REQUEST[ 'r_calendar' ] ) ) { update_option( 'regulus_calendar', 1 ); } else { delete_option( 'regulus_calendar' ); }
			if( isset( $_REQUEST[ 'r_meta' ] ) ) { update_option( 'regulus_meta', 1 ); } else { delete_option( 'regulus_meta' ); }
			if( isset( $_REQUEST[ 'r_admin' ] ) ) { update_option( 'regulus_admin', 1 ); } else { delete_option( 'regulus_admin' ); }
			if( isset( $_REQUEST[ 'r_posts' ] ) ) { update_option( 'regulus_posts', 1 ); } else { delete_option( 'regulus_posts' ); }
			if( isset( $_REQUEST[ 'r_months' ] ) ) { update_option( 'regulus_months', 1 ); } else { delete_option( 'regulus_months' ); }
			if( isset( $_REQUEST[ 'r_excerpt' ] ) ) { update_option( 'regulus_excerpt', 1 ); } else { delete_option( 'regulus_excerpt' ); }
			if( isset( $_REQUEST[ 'r_author' ] ) ) { update_option( 'regulus_author', 1 ); } else { delete_option( 'regulus_author' ); }
			if( isset( $_REQUEST[ 'r_linkcat' ] ) ) { update_option( 'regulus_linkcat', 1 ); } else { delete_option( 'regulus_linkcat' ); }
			if( isset( $_REQUEST[ 'r_sidealign' ] ) ) { update_option( 'regulus_sidealign', 1 ); } else { delete_option( 'regulus_sidealign' ); }
			if( isset( $_REQUEST[ 'r_heading' ] ) ) { update_option( 'regulus_heading', 1 ); } else { delete_option( 'regulus_heading' ); }

			// goto theme edit page
			header("Location: themes.php?page=functions.php&saved=true");
			die;

  		// reset settings
		} else if( 'reset' == $_REQUEST['action'] ) {

			delete_option( 'regulus_name' );
			delete_option( 'regulus_email' );
			delete_option( 'regulus_about' );
			delete_option( 'regulus_headerImage' );
			delete_option( 'regulus_headerImageURL' );
			delete_option( 'regulus_colourScheme' );

			delete_option( 'regulus_calendar' );
			delete_option( 'regulus_meta' );
			delete_option( 'regulus_admin' );
			delete_option( 'regulus_posts' );
			delete_option( 'regulus_months' );
			delete_option( 'regulus_excerpt' );
			delete_option( 'regulus_author' );
			delete_option( 'regulus_linkcat' );
			delete_option( 'regulus_sidealign' );
			delete_option( 'regulus_heading' );

			// goto theme edit page
			header("Location: themes.php?page=functions.php&reset=true");
			die;

		}
	}

    add_theme_page("Regulus Theme Options", "Current Theme Options", 'edit_themes', basename(__FILE__), 'regulus_theme_page');

}

function regulus_theme_page() {

	// --------------------------
	// regulus theme page content
	// --------------------------

	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>Settings reset.</strong></p></div>';
	if ( $_REQUEST['super'] ) $superUser = true; else $superUser = false;
	
?>

<div class="wrap">
<h2>Regulus 2.1</h2>

<p>Developed by Ben Gillbanks at Binary Moon. Check the <a href="http://www.binarymoon.co.uk/projects/regulus/">Regulus page for updates</a></p>

<form method="post">


<!-- blog layout options -->
<style type="text/css">

	#colourSchemePreview { display:block; width:60%; height:40px; border:1px solid #000; }

	.CS_orange { background-color:#fc0; }
	.CS_green { background-color:#5f7; }
	.CS_blue { background-color:#bbf; }
	.CS_pink { background-color:#f9c; }
	.CS_white { background-color:#fff; }
	.CS_blend { background-color:#eef; }

</style>

<script>

function updateHeaderImage( newpic ) {

	newimage = "<?php bloginfo('template_url') ?>/images/bg_" + newpic.value + ".jpg";

	document.getElementById( 'placeholder' ).src = newimage;
	return true;

}

function updateColour( newcolour ) {

	document.getElementById( 'colourSchemePreview' ).className = "CS_" + newcolour.value;

}

function updateHeaderImageSelect( form ) {

	text = form.r_headerImageURL.value;
	
    if ( text == "" ) {
    
        newpic = form.r_headerImage.value;
    
		newimage = "<?php bloginfo('template_url') ?>/images/bg_" + newpic + ".jpg";

 		form.r_headerImage.disabled = 0;
		
	} else {
	
		newimage = form.r_headerImageURL.value;
		
		form.r_headerImage.disabled = 1;
		
	}
	
	document.getElementById( 'placeholder' ).src = newimage;
}

function defaultImage() {

	newimage = "<?php bloginfo('template_url') ?>/images/bg_disabled.jpg";

	document.getElementById( 'placeholder' ).src = newimage;

}

</script>

<fieldset class="options">
<legend>Header settings</legend>

<p>To use your own header image enter the <strong>complete</strong> url into the Header Image URL box below - eg "http://www.yoursite.com/yourfile.jpg". To fill the header area completely you should make the image <strong>730</strong> pixels wide by <strong>140</strong> pixels high. Any smaller and the image will tile. To use one of the supplied images simply leave this box blank and select the image from the drop down.</p>

<table width="100%" cellspacing="2" cellpadding="5" class="editform">

<?php


	regulus_th( "Header Image URL" );
		regulus_input( "r_headerImageURL", "text", "", get_settings( 'regulus_headerImageURL' ), "", "updateHeaderImageSelect( this.form )" );
	regulus_cth();

	$value = get_settings( 'regulus_headerImage' );
	
	if ( get_settings( 'regulus_headerImageURL' ) != "" ) {
	
	    $disabled = true;

	}
	
	regulus_th( "Header Image" );

		if ( $disabled == true ) {
			echo "<select name=\"r_headerImage\" style=\"width:60%;\" onchange=\"updateHeaderImage( this )\" disabled=\"true\">";
		} else {
            echo "<select name=\"r_headerImage\" style=\"width:60%;\" onchange=\"updateHeaderImage( this )\">";
		}
	    
		regulus_input( "r_headerImage", "option", "Regulus Classic", "1", $value );
		regulus_input( "r_headerImage", "option", "Electric Swirl", "2", $value );
		regulus_input( "r_headerImage", "option", "Smooth", "3", $value );
		regulus_input( "r_headerImage", "option", "Piece of the Puzzle", "4", $value );
		regulus_input( "r_headerImage", "option", "Skyline", "5", $value );
		regulus_input( "r_headerImage", "option", "Tech Style", "6", $value );
		regulus_input( "r_headerImage", "option", "Old and New", "7", $value );
		regulus_input( "r_headerImage", "option", "Bloom", "8", $value );
		// regulus_input( "r_headerImage", "option", "Random", "random", $value );
		echo "</select>";
		
		echo "<img id=\"placeholder\" onError=\"defaultImage();\" src=\"";
		bloginfo('template_url');
		
		if ( $disabled == true ) {
			echo "/images/bg_disabled.jpg\" width=\"60%\" />";
		} else {
			echo "/images/bg_$value.jpg\" width=\"60%\" />";
		}

		
	regulus_cth();
	
	regulus_th( "Header Text" );
			regulus_input( "r_heading", "checkbox", "Hide blog title and description? (Useful if you use the custom header image)", "1", get_settings( 'regulus_heading' ) );
	regulus_cth();
	
?>

</table>
</fieldset>

<fieldset class="options">
<legend>Blog Settings</legend>

<p>Change the way your blog looks and acts with the many blog settings below</p>

<table width="100%" cellspacing="2" cellpadding="5" class="editform">

<?php
	
	$value = get_settings( 'regulus_colourScheme' );
	regulus_th( "Colour Scheme" );

	    echo "<select name=\"r_colourScheme\" style=\"width:60%;\" onchange=\"updateColour( this )\">";
		regulus_input( "r_colourScheme", "option", "Orange Spice", "orange", $value );
		regulus_input( "r_colourScheme", "option", "Green Peace", "green", $value );
		regulus_input( "r_colourScheme", "option", "Calm Blue", "blue", $value );
		regulus_input( "r_colourScheme", "option", "Passionate Pink", "pink", $value );
		regulus_input( "r_colourScheme", "option", "Whitewash", "white", $value );
		regulus_input( "r_colourScheme", "option", "Blend it in", "blend", $value );
		echo "</select>";
		
		echo "<div id=\"colourSchemePreview\" class=\"CS_" . $value . "\"></div>";
		
	regulus_cth();

	if ( $superUser == true ) {
	
	regulus_th( "Post Options" );
		regulus_input( "r_excerpt", "checkbox", "Show Excerpts on the homepage (removes images and some other tags)?", "1", get_settings( 'regulus_excerpt' ) );
		// regulus_input( "r_author", "checkbox", "Show Post Author on the homepage?", "1", get_settings( 'regulus_author' ) );
	regulus_cth();
	
	}
	
	$display_regulus_sidebar = false;

	regulus_th( "Sidebar Options" );
	
		// if plugin installed
		if ( !function_exists('is_dynamic_sidebar') ) {
		
			$display_regulus_sidebar = true;
			
		} else {
		
		    //plugin installed - is it used?
		    if ( is_dynamic_sidebar() == false ) { $display_regulus_sidebar = true; }

		}

		// display regulus sidebar settings
 		if ( $display_regulus_sidebar == true ) {

			regulus_input( "r_calendar", "checkbox", "Show Calendar?", "1", get_settings( 'regulus_calendar' ) );
			regulus_input( "r_meta", "checkbox", "Show meta content (login, site admin etc)?", "1", get_settings( 'regulus_meta' ) );
			regulus_input( "r_posts", "checkbox", "Show Recent Posts", "1", get_settings( 'regulus_posts' ) );
			regulus_input( "r_months", "checkbox", "Show all archive months", "1", get_settings( 'regulus_months' ) );
			regulus_input( "r_linkcat", "checkbox", "Use Link categories in blog roll?", "1", get_settings( 'regulus_linkcat' ) );

		}

		//if ( $superUser == true ) regulus_input( "r_admin", "checkbox", "Display Admin options (only for admin user when logged in)", "1", get_settings( 'regulus_admin' ) );
		regulus_input( "r_admin", "checkbox", "Display Admin options (only for admin user when logged in)", "1", get_settings( 'regulus_admin' ) );
		
		regulus_input( "r_sidealign", "checkbox", "Align sidebar to the left?", "1", get_settings( 'regulus_sidealign' ) );
	regulus_cth();

?>

</table>

</fieldset>


<!-- personal options -->
<fieldset class="options">
<legend>Personal Information</legend>

<p>The name and email address are used to highlight the comments you post. The about information will appear at the top of the right hand column (optional)</p>

<table width="100%" cellspacing="2" cellpadding="5" class="editform">

<?php

	regulus_th( "Your Name" );
		regulus_input( "r_name", "text", "", get_settings( 'regulus_name' ) );
	regulus_cth();

	regulus_th( "Your Email Address" );
		regulus_input( "r_email", "text", "", get_settings( 'regulus_email' ) );
	regulus_cth();

	regulus_th( "About You" );
		regulus_input( "r_about", "textarea", "", get_settings( 'regulus_about' ) );
	regulus_cth();

?>

</table>

</fieldset>

<?php

	regulus_input( "save", "submit", "", "Save Settings" );
	
?>

<input type="hidden" name="action" value="save" />

</form>



<form method="post">

<fieldset class="options">
<legend>Reset</legend>

<p>If for some reason you want to uninstall Regulus then press the reset button to clean things up in the database.</p>
<?php

	regulus_input( "reset", "submit", "", "Reset Settings" );
	
?>

</div>

<input type="hidden" name="action" value="reset" />

</form>

<?php
}

add_action('admin_menu', 'regulus_add_theme_page');


// helper functions
// ----------------

function regulus_input( $var, $type, $description = "", $value = "", $selected="", $onchange="" ) {

	// ------------------------
	// add a form input control
	// ------------------------
	
 	echo "\n";
 	
	switch( $type ){
	
	    case "text":

	 		echo "<input name=\"$var\" id=\"$var\" type=\"$type\" style=\"width: 60%\" class=\"code\" value=\"$value\" onchange=\"$onchange\"/>";
			
			break;
			
		case "submit":
		
	 		echo "<p class=\"submit\"><input name=\"$var\" type=\"$type\" value=\"$value\" /></p>";

			break;

		case "option":
		
			if( $selected == $value ) { $extra = "selected=\"true\""; }

			echo "<option value=\"$value\" $extra >$description</option>";
		
		    break;
  		case "radio":
  		
			if( $selected == $value ) { $extra = "checked=\"true\""; }
  		
  			echo "<label><input name=\"$var\" id=\"$var\" type=\"$type\" value=\"$value\" $extra /> $description</label><br/>";
  			
  			break;
  			
		case "checkbox":
		
			if( $selected == $value ) { $extra = "checked=\"true\""; }

  			echo "<label><input name=\"$var\" id=\"$var\" type=\"$type\" value=\"$value\" $extra /> $description</label><br/>";

  			break;

		case "textarea":
		
		    echo "<textarea name=\"$var\" id=\"$var\" style=\"width: 60%; height: 10em;\" class=\"code\">$value</textarea>";
		
		    break;
	}

}

function regulus_th( $title ) {

	// ------------------
	// add a table header
	// ------------------

   	echo "<tr valign=\"top\">";
	echo "<th width=\"33%\" scope=\"row\">$title :</th>";
	echo "<td>";

}

function regulus_cth() {

	echo "</td>";
	echo "</tr>";
	
}


function bm_writeAbout() {

	$tempVar = get_settings( 'regulus_about' );
	
	// $tempVar = apply_filters( "the_content", $tempVar );
	
	$tempVar = bm_tidy_html( $tempVar );

	if( $tempVar != "" && $tempVar != "<br />\n" ) {
	    echo "\t<li id=\"about\">";
		echo "\t\t<h2>About...</h2>\n";
		echo "\t\t" . $tempVar . "\n";
		echo "\t</li>\n";
	}

}

function bm_getProperty( $property ) {

	$value = get_settings( "regulus_" . $property );
	
	if( $value == "1" ) {
        return 1;
	} else {
		return 0;
	}
	

}
/*
function bm_calendar() {

	echo "<li>";
	echo "<div id=\"wp-cal-container\">";
	get_calendar( 3 );
	echo "</div>";
	echo "</li>";
	
}
*/
function bm_calendar() {
	$options = get_option('widget_calendar');
	$title = $options['title'] ? '<h2>' . $options['title'] . '</h2>' : '';
	echo '<li>' . $title;
	echo '<div id="wp-cal-container">';
	get_calendar( 3 );
	echo '</div>';
	echo '</li>';
}

// -------------------------------------
// format html for display in a web page
// -------------------------------------
function bm_tidy_html( $data ) {

	//remove dodgy characters
	$data = htmlspecialchars( $data );
	//remove carriage returns
	$data = str_replace( "\r", "", $data );
	//swap newlines for line breaks
	$data = str_replace( "\n", "<br />", $data );
	//replace <br>
	$data = str_replace( "<br>", "<br />", $data );
	//add paragraph tags
	$data = "<p>" . str_replace( "<br /><br />", "</p>\n<p>", $data ) . '</p>';
	//remove newline at the end of paragraphs
	$data = str_replace( "<br /></p>", "</p>", $data);
	//remove empty paragraphs
	$data = str_replace( "<p></p>", "", $data);
	$data = str_replace( "<p><br></p>", "", $data );

	$data = stripslashes( $data );

	return $data;

}

/*

Plugin Name: WP Admin Bar 2
Version: 2.2
Plugin URI: http://mattread.com/archives/2005/03/wp-admin-bar-20/
Description: Adds a small admin bar to the top of every page.
Author: Matt Read
Author URI: http://www.mattread.com/

modified by Ben Gillbanks for use in Regulus theme
url :http://www.binarymoon.co.uk

*/

function bm_admin_bar()
{
	global $user_level, $user_ID, $user_nickname, $posts, $author;
	$_authordata = get_userdata($posts[0]->post_author);
	get_currentuserinfo();

	if ( isset($user_level) ) {

		?>
		<li>
		<h2>Admin Controls</h2>
		<ul id="wp-admin-bar">

		<?php

		// START Special case for write.
		$write_level	= ( get_settings('new_users_can_blog') ) ? 0 : 1;
		//$write_text		= ( is_single() OR is_page() ) ? 'Write' : '<strong>Write</strong>';
		$write_array	= array( '<strong>Write</strong>', $write_level, 'post-new.php' );
		// END

		// START Special case for edit.
		// if (single OR page) AND (user level greater than author level OR is author OR is admin).
		$edit_level		= ( ( is_single() OR is_page() ) AND ( $user_level > $_authordata->user_level OR $_authordata->ID == $user_ID OR $user_level == 10 ) ) ? 0 : 11;
		$edit_array		= array('<strong>Edit</strong>',$edit_level,'post.php?action=edit&amp;post=' . $posts[0]->ID );
		// END

		$menu			= array(

			array('Dashboard',8,'index.php','dashboard'),

			$write_array,
			$edit_array,

		);

		$menu = apply_filters( 'wp_admin_bard', $menu ); // user level 11 to skip

		foreach ( $menu as $item ) {
			if ($user_level >= $item[1]) {
				echo "\n\t<li><a href='".get_settings('siteurl')."/wp-admin/{$item[2]}' title='$item[3]'>{$item[0]}</a></li>";
			}
		}

		// Login and logout link.
		echo "\n\t<li>"; wp_loginout(); echo "</li>";
		echo "\n</ul>";
		echo "</li>";

	}
}



/*

Plugin Name: Author Highlight
Plugin URI: http://dev.wp-plugins.org/wiki/AuthorHighlight
Description: Author Highlight is a plugin that prints out a user-specified class attribute if the comment is made by the specified author. It is useful if you would like to apply a different style to comments made by yourself.
Version: 1.0
Author: Jonathan Leighton
Author URI: http://turnipspatch.com/
Licence: This WordPress plugin is licenced under the GNU General Public Licence. For more information see: http://www.gnu.org/copyleft/gpl.html

For documentation, please visit http://dev.wp-plugins.org/wiki/AuthorHighlight

modified by Ben Gillbanks for use in Regulus theme
url :http://www.binarymoon.co.uk

*/

$bm_author_highlight = array(
	"class_name_highlight" => "highlighted",
	"class_name_else" => "",
   	"email" => get_settings( 'regulus_email' ),
   	"author" => get_settings( 'regulus_name' )
);

function bm_author_highlight() {

	global $comment;
	global $bm_author_highlight;

	if ( empty( $bm_author_highlight["author"] ) || empty( $bm_author_highlight["email"] ) || empty( $bm_author_highlight["class_name_highlight"] ) )
		return;

	$author = $comment -> comment_author;
	$email	= $comment -> comment_author_email;

	if ( strcasecmp( $author, $bm_author_highlight[ "author" ] ) == 0 && strcasecmp( $email, $bm_author_highlight["email"]) == 0 ) {

	return $bm_author_highlight[ "class_name_highlight" ];

	} else {

		return $bm_author_highlight[ "class_name_else" ];

	}

}

/*
Plugin Name: the_excerpt Reloaded
Plugin URI: http://guff.szub.net/the-excerpt-reloaded
Description: This mod of WordPress' template function the_excerpt() knows there is no spoon.
Version: 0.2
Author: Kaf Oseo
Author URI: http://szub.net

~Changelog:
0.2 (16-Dec-2004)
Plugin now attempts to correct *broken* HTML tags (those allowed
through 'allowedtags') by using WP's balanceTags function.  This
is controlled through the 'fix_tags' parameter.

Copyright (c) 2004
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt

	This is a WordPress plugin (http://wordpress.org).

	WordPress is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published
	by the Free Software Foundation; either version 2 of the License,
	or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
	General Public License for more details.

	For a copy of the GNU General Public License, write to:

	Free Software Foundation, Inc.
	59 Temple Place, Suite 330
	Boston, MA  02111-1307
	USA

	You can also view a copy of the HTML version of the GNU General
	Public License at http://www.gnu.org/copyleft/gpl.html

modified by Ben Gillbanks for use in Regulus theme
url :http://www.binarymoon.co.uk

*/

function bm_the_excerpt_reloaded($excerpt_length=100, $allowedtags='<a>,<ul>,<li>,<blockquote>', $filter_type='excerpt', $use_more_link=false, $more_link_text="(more...)", $force_more_link=false, $fakeit=1, $fix_tags=true) {
	if (preg_match('%^content($|_rss)|^excerpt($|_rss)%', $filter_type)) {
		$filter_type = 'the_' . $filter_type;
	}
	$text = apply_filters($filter_type, bm_get_the_excerpt_reloaded($excerpt_length, $allowedtags, $use_more_link, $more_link_text, $force_more_link, $fakeit));
	$text = ($fix_tags) ? balanceTags($text) : $text;
	echo $text;
}

function bm_get_the_excerpt_reloaded($excerpt_length, $allowedtags, $use_more_link, $more_link_text, $force_more_link, $fakeit) {
	global $id, $post;
	$output = '';
	$output = $post->post_excerpt;
	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			$output = __('There is no excerpt because this is a protected post.');
			return $output;
		}
	}


	// If we haven't got an excerpt, make one.
	if ((($output == '') && ($fakeit == 1)) || ($fakeit == 2)) {
		$output = $post->post_content;
		$output = strip_tags($output, $allowedtags);
		$blah = explode(' ', $output);
		if (count($blah) > $excerpt_length) {
			$k = $excerpt_length;
			$use_dotdotdot = 1;
		} else {
			$k = count($blah);
			$use_dotdotdot = 0;
		}
		$excerpt = '';
		for ($i=0; $i<$k; $i++) {
			$excerpt .= $blah[$i] . ' ';
		}
		// Display "more" link (use css class 'more-link' to set layout).
		if (($use_more_link && $use_dotdotdot) || $force_more_link) {
			$excerpt .= "<div class=\"more-link\"> <a href=\"". get_permalink() . "#more-$id\">$more_link_text</a></div>";
		} else {
			$excerpt .= ($use_dotdotdot) ? '...' : '';
		}
		 $output = $excerpt;
	} // end if no excerpt
	return $output;
}

?>
