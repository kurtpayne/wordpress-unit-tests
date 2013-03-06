<?php

$themecolors = array(
	'bg' => 'fcf7ef',
	'border' => 'fcf7ef',
	'text' => '000000',
	'link' => '7094b7'
);

$content_width = 370;

register_sidebar( array(
        'name'          => __('Sidebar'),
        'id'            => 'sidebar',
        'before_widget' => '<ul class="nonnavigational">',
        'after_widget'  => '</ul>',
        'before_title'  => '<p class="side_title">',
        'after_title'   => '</p>' ) );

/*
File Name: WordPress Theme Toolkit Implementation for Theme Minimalissimplistic
Version: 1.0
Author: Ozh
Author URI: http://planetOzh.com/
*/

/************************************************************************************
 * THEME USERS : don't touch anything !! Or don't ask the theme author for support :)
 ************************************************************************************/

include(dirname(__FILE__).'/themetoolkit.php');

/************************************************************************************
 * THEME AUTHOR : edit the following function call :
 ************************************************************************************/

themetoolkit(
	'mytheme', /* Make yourself at home :
					* Name of the variable that will contain all the options of
					* your theme admin menu (in the form of an array)
					* Name it according to PHP naming rules (http://php.net/variables) */

	array(     /* Variables used by your theme features (i.e. things the end user will
					* want to customize through the admin menu)
 					* Syntax :
					* 'option_variable' => 'Option Title ## optionnal explanations',
					* 'option_variable' => 'Option Title {radio|value1|Text1|value2|Text2} ## optionnal explanations',
					* 'option_variable' => 'Option Title {textarea|rows|cols} ## optionnal explanations',
					* 'option_variable' => 'Option Title {checkbox|option_var1|value1|Text1|option_var2|value2|Text2} ## optionnal explanations',
					* Examples :
					* 'your_age' => 'Your Age',
					* 'cc_number' => 'Credit Card Number ## I can swear I will not misuse it :P',
					* 'gender' => 'Gender {radio|girl|You are a female|boy|You are a male} ## What is your gender ?'
					* Dont forget the comma at the end of each line ! */
	'floatbar' => 'Sidebar Menu on the {radio|right|Right Hand (default)|left|Left Hand}',
	'colortheme' => 'Color theme {radio|red|red (default)|blue|blue|green|green}',

	/*'debug' => 'debug', 	 this is a fake entry that will activate the "Programmer's Corner"
								 * showing you vars and values while you build your theme. Remove it
								 * when your theme is ready for shipping */
	),
	__FILE__	 /* Parent. DO NOT MODIFY THIS LINE !
				  * This is used to check which file (and thus theme) is calling
				  * the function (useful when another theme with a Theme Toolkit
				  * was installed before */
);
	
/************************************************************************************
 * THEME AUTHOR : Congratulations ! The hard work is all done now :)
 *
 * From now on, you can create functions for your theme that will use the array
 * of variables $mytheme->option. For example there will be now a variable
 * $mytheme->option['your_age'] with value as set by theme end-user in the admin menu.
 ************************************************************************************/

/***************************************
 * Additionnal Features and Functions for
 * Theme 'minimalissimplistic'
 *
 * Create your own functions using the array
 * of user defined variables $mytheme->option.
 * An example of function could be :
 *
 * function creditcard() {
 *		global $mytheme;
 *		print "My Credit Card Number is : ";
 * 	print $mytheme->option['creditcard'];
 * }
 *
 **************************************/
 
/* mytheme_about
	use <?php mytheme_about() ?> to print either what the author
	wrote in his profile (Admin Area, Users page), or a friendly
	message if nothing has been filled in.
*/
function mytheme_about() {
	if (get_the_author_description()) {
		print get_the_author_description();
	} else {
		print "The author does not say much about himself";
	}
}

/* mytheme_sidebar()
	Prints css style according to what has been defined
	in the admin pannel
*/
function mytheme_sidebar() {
	global $mytheme;
	if ($mytheme->option['floatbar'] == 'left') {
		echo '
		/* Menu of the Left */
		#mike_content {float: right;padding-right:0;padding-left:15px;}
		#dooncha_sidebar {float: left;text-align:right;}
		#dooncha_sidebar ul.nonnavigational li{background-position:203px 1px;padding:0 17px 0 0;}
		';
	} else {
		echo '';
	}	
}

/* mytheme_theme()
	Prints css style according to what has been defined
	in the admin pannel
*/
function mytheme_theme() {
	global $mytheme;
	if ($mytheme->option['colortheme'] == 'green') {
		echo '
		/* green theme */
		#boren_head{background:#8d0a0a url(' . get_bloginfo('template_directory') . '/images/competition_green.gif) no-repeat;}
		#dooncha_sidebar ul#navigational, #dooncha_sidebar ul.nonnavigational, #author_talk{border-bottom:3px solid #8e9d54;}		
		.sidebar_line{	border-bottom:2px solid #8e9d54!important;	border-bottom:3px solid #8e9d54;
		';
		}
	elseif ($mytheme->option['colortheme'] == 'blue') {
		print '
		/* blue theme */
		#boren_head{background:#8d0a0a url(' . get_bloginfo('template_directory') . '/images/competition_blue.gif) no-repeat;}
		#dooncha_sidebar ul#navigational, #dooncha_sidebar ul.nonnavigational, #author_talk{border-bottom:3px solid #425b82;}		
		.sidebar_line{	border-bottom:2px solid #425b82!important;	border-bottom:3px solid #425b82;
		}
		';
	 }
	 else {
		echo '';
	}	
}

/* mytheme_colors()
	Prints css style according to what has been defined
	in the admin pannel
*/
function mytheme_colors() {
	global $mytheme;
	if ( $mytheme->option['textcolor'] or $mytheme->option['bgcolor'] ) print "body {\n";
		if ($mytheme->option['textcolor']) print 'color: '. $mytheme->option['textcolor'] . ";\n";
		if ($mytheme->option['bgcolor']) print 'background: '. $mytheme->option['bgcolor'] .";\n";
	if ($mytheme->option['textcolor'] or $mytheme->option['bgcolor']) print "}\n";
	if ($mytheme->option['contentlinkcolor']) print '#mike_content a{color: '. $mytheme->option['contentlinkcolor'] . ";}\n";
	if ($mytheme->option['sidebarlinkcolor']) print '#dooncha_sidebar ul#navigational li a, #dooncha_sidebar ul.nonnavigational li a{color: '. $mytheme->option['sidebarlinkcolor'] . ";}\n";
	if ($mytheme->option['contentlinkcolorhover']) print '#mike_content a:hover{background:none;border:none;color: '. $mytheme->option['contentlinkcolorhover'] . ";}\n";
	if ($mytheme->option['sidebarlinkcolorhover']) print '#dooncha_sidebar ul#navigational li a:hover, #dooncha_sidebar ul.nonnavigational li a:hover{color: '. $mytheme->option['sidebarlinkcolorhover'] . ";}\n";
	if ($mytheme->option['wrapcolor']) print '#matt{background: '. $mytheme->option['wrapcolor'] . ";}\n";
}

?>
