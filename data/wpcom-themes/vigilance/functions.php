<?php
$content_width = 600;

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '333333',
	'link' => '000000',
	'border' => 'ffffff'
	);
	
	
define ('FUNCTIONS', 'functions/');
define ('COPY', FUNCTIONS . '/vigilance.php');
require_once (FUNCTIONS . '/sidebars.php');
require_once (FUNCTIONS . '/comments.php');
require_once (FUNCTIONS . '/wpcom-header.php');


// Use legacy comments template for versions less than 2.7
add_filter('comments_template', 'legacy_comments');
function legacy_comments($file) {
	if(!function_exists('wp_list_comments')) 	$file = 'legacy.comments.php';
	return $file;
}

$themename = "Vigilance";
$shortname = "V";
$options = array (
         array(	"name" => __("Navigation", 'vigilance'),
						"type" => "subhead"),
        
        array(  "name" => __("Exclude pages from header", 'vigilance'),
              "id" => $shortname."_pages_to_exclude",
              "desc" => __("Page ID's you don't want displayed in your header navigation. Use a comma-delimited list, eg. 1,2,3", 'vigilance'),
              "std" => "",
              "type" => "text"),
              
         array(	"name" => __("Color Scheme", 'vigilance'),
						"type" => "subhead"),
            
        array(	"name" => __("Customize colors", 'vigilance'),
						"desc" => __("If enabled the theme will use the layouts and colors you choose below.", 'vigilance'),
					    "id" => $shortname."_background_css",
					    "std" => "Disabled",
					    "type" => "select",
					    "options" => array("Disabled", "Enabled")), 
              
        array(	"name" => __("Background color", 'vigilance'),
					    "id" => $shortname."_background_color",
						"desc" => "Your background color. Use Hex values and leave out the leading #.",
					    "std" => "dcdfc2",
					    "type" => "text"),
        
        array(	"name" => "Border color",
					    "id" => $shortname."_border_color",
						"desc" => "Your border color. Use Hex values and leave out the leading #.",
					    "std" => "d7dab9",
					    "type" => "text"),
        
        array(	"name" => __("Link color", 'vigilance'),
					    "id" => $shortname."_link_color",
						"desc" => __("Your link color. Use Hex values and leave out the leading #.", 'vigilance'),
					    "std" => "772124",
					    "type" => "text"),
        
        array(	"name" => __("Link hover color", 'vigilance'),
					    "id" => $shortname."_hover_color",
						"desc" => __("Your link hover color. Use Hex values and leave out the leading #.", 'vigilance'),
					    "std" => "58181b",
					    "type" => "text"),
         
        array(	"name" => __("Disable hover images", 'vigilance'),
					    "id" => $shortname."_image_hover",
						"desc" => __("This is useful if you use custom link colors and don't want the default red showing when a user hovers over the comments bubble or the sidebar menu items.", 'vigilance'),
					    "std" => "false",
					    "type" => "checkbox"),

                       
        array(	"name" => __("Alert Box", 'vigilance'),
						"type" => "subhead"),
            
        array(	"name" => __("Alert Box On/Off", 'vigilance'),
						"desc" => __("Toggle the alert box.", 'vigilance'),
			    		"id" => $shortname."_alertbox_state",
					"std" => "Off", 
			    		"type" => "select",
					"options" => array("Off", "On")), 
              
        array(	"name" => __("Alert Title", 'vigilance'),
					    "id" => $shortname."_alertbox_title",
              "desc" => __("The title of your alert.", 'vigilance'),
					    "std" => "",
					    "type" => "text"),
        
        array(	"name" => __("Alert Message", 'vigilance'),
						"id" => $shortname."_alertbox_content",
						"desc" => __("Must use HTML in the message including <code>&#60;p&#62;</code> tags.", 'vigilance'),
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "8",
										   "cols" => "70") ),
		  );

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page($themename . " Options", $themename . " Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>' . sprintf(__('%s settings saved.', 'vigilance'),$themename) . '</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>' . sprintf(__('%s settings reset.', 'vigilance'),$themename) . '</strong></p></div>';
    
?>
<div class="wrap">
<h2 class="updatehook" style=" padding-top: 20px; font-size: 2.8em;"><?php printf(__('%s Options', 'vigilance'), $themename); ?></h2>

<form action="themes.php?page=functions.php" method="post">

<table class="form-table">

<?php foreach ($options as $value) { 
	
	switch ( $value['type'] ) {
		case 'subhead':
		?>
			</table>
			
			<h3 style="padding-top: 15px;"><?php echo $value['name']; ?></h3>
			
			<table class="form-table">
		<?php
		break;
		case 'text':
		option_wrapper_header($value);
		?>
		        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
		<?php
		option_wrapper_footer_nobreak($value);
		break;
		
		case 'select':
		option_wrapper_header($value);
		?>
	            <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
	                <?php foreach ($value['options'] as $option) { ?>
	                <option value="<?php echo $option; ?>" <?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php _e($option); ?></option>
	                <?php } ?>
	            </select>
		<?php
		option_wrapper_footer($value);
		break;
		
		case 'textarea':
		$ta_options = $value['options'];
		option_wrapper_header($value);
		?>
				<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
				if( get_settings($value['id']) != "") {
						echo stripslashes(get_settings($value['id']));
					}else{
						echo stripslashes($value['std']);
				}?></textarea>
		<?php
		option_wrapper_footer($value);
		break;

		case "radio":
		option_wrapper_header($value);
		
 		foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_settings($value['id']);
				if($radio_setting != ''){
		    		if ($key == get_settings($value['id']) ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				}else{
					if($key == $value['std']){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				}?>
	            <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
		<?php 
		}
		 
		option_wrapper_footer_nobreak($value);
		break;
		
		case "checkbox":
		option_wrapper_header($value);
						if(get_settings($value['id'])){
							$checked = "checked=\"checked\"";
						}else{
							$checked = "";
						}
					?>
		            <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
		<?php
		option_wrapper_footer_nobreak($value);
		break;

		default:

		break;
	}
}
?>

</table>

<p class="submit">
<input name="save" type="submit" value="<?php _e('Save Changes', 'vigilance'); ?>" />    
<input type="hidden" name="action" value="save" />
</p>
</form>
<form action="themes.php?page=functions.php" method="post">
<p class="submit">
<input name="reset" type="submit" value="<?php _e('Reset', 'vigilance'); ?>" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
<?php
}

function option_wrapper_header($values){
	?>
	<tr valign="top"> 
	    <th scope="row"><?php echo $values['name']; ?>:</th>
	    <td>
	<?php
}
function option_wrapper_footer($values){
	?>
		<br />
		<?php echo $values['desc']; ?>
	    </td>
	</tr>
	<?php 
}
function option_wrapper_footer_nobreak ($values){
	?>
		<?php echo $values['desc']; ?>
	    </td>
	</tr>
	<?php 
}
add_action('admin_menu', 'mytheme_add_admin');
?>
