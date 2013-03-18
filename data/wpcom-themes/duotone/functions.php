<?php
if (function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Sidebar'));

include 'inc/duotonelibrary.php';

function partial($file) { include $file.'.php'; }

add_action('admin_menu', 'duotone_add_theme_page');
function duotone_add_theme_page() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
		if ( isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) {
			check_admin_referer('duotone-background');
			delete_option('background_color');
			if($_REQUEST['choice'] == 'manual') {
				$background_color = preg_replace('/(#[0-9a-fA-F]{6})+/', '$1', $_REQUEST['background_color_manual']);
				update_option('background_color', $background_color);
			}
			wp_redirect("themes.php?page=functions.php&saved=true");
			die;
		}
		add_action('admin_head', 'duotone_admin_head');
	}
	add_theme_page(__('Customize Background Color'), __('Background Color'), 'edit_themes', basename(__FILE__), 'duotone_theme_page');
}
function duotone_admin_head() { ?>
	<script type="text/javascript" src="../wp-includes/js/colorpicker.js"></script>
	<script type='text/javascript'>
	// <![CDATA[
		function pickColor(color) {
			ColorPicker_targetInput.value = color;
			kUpdate(ColorPicker_targetInput.id);
		}
		function PopupWindow_populate(contents) {
			contents += '<br /><p style="text-align:center;margin-top:0px;"><input type="button" value="<?php echo attribute_escape(__('Close Color Picker')); ?>" onclick="cp.hidePopup(\'prettyplease\')"></input></p>';
			this.contents = contents;
			this.populated = false;
		}
		function PopupWindow_hidePopup(magicword) {
			if ( magicword != 'prettyplease' )
				return false;
			if (this.divName != null) {
				if (this.use_gebi) {
					document.getElementById(this.divName).style.visibility = "hidden";
				}
				else if (this.use_css) {
					document.all[this.divName].style.visibility = "hidden";
				}
				else if (this.use_layers) {
					document.layers[this.divName].visibility = "hidden";
				}
			}
			else {
				if (this.popupWindow && !this.popupWindow.closed) {
					this.popupWindow.close();
					this.popupWindow = null;
				}
			}
			return false;
		}
		function colorSelect(t,p) {
			if ( cp.p == p && document.getElementById(cp.divName).style.visibility != "hidden" )
				cp.hidePopup('prettyplease');
			else {
				cp.p = p;
				cp.select(t,p);
			}
		}
		function PopupWindow_setSize(width,height) {
			this.width = 162;
			this.height = 210;
		}

		var cp = new ColorPicker();
		// ]]>
		</script>
<?php }
function duotone_theme_page() {
	if ( isset( $_REQUEST['saved'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.').'</strong></p></div>';
?>
<div class='wrap'>
	<h2><?php _e('Customize Background Color'); ?></h2>

		<form method="post" action="<?php echo attribute_escape($_SERVER['REQUEST_URI']); ?>">
			<?php wp_nonce_field('duotone-background'); ?>
			<p>
				<input type="radio" name="choice" value="manual" id="choice_manual" <?php if(get_option('background_color') != '') echo 'checked="checked"'; ?> />
				<label for="background_color_manual" onclick="jQuery('#choice_manual').attr('checked','checked');"><?php _e('Manual Background Color:'); ?> <input type="text" onclick="tgt=document.getElementById('background_color_manual'); jQuery('#choice_manual').attr('checked','checked'); colorSelect(tgt,'background_color_manual');return false;" name="background_color_manual" id="background_color_manual" value="<?php echo attribute_escape(get_option('background_color')); ?>" /> <small><?php printf(__('Any CSS color (%s or %s or %s)'), '<code>red</code>', '<code>#FF0000</code>', '<code>rgb(255, 0, 0)</code>'); ?></small></label>
				<input type="hidden" name="pick1" id="pick1" value="<?php echo attribute_escape(__('Background Color')); ?>"></input>
				<div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;visibility:hidden;"> </div>
				
			</p>
			<p>
				<input type="radio" name="choice" value="automatic" id="choice_automatic" <?php if(get_option('background_color') == '') echo 'checked="checked"'; ?>/>
				<label for="automatic" onclick="jQuery('#choice_automatic').attr('checked','checked');"><?php echo __('Automatic Background Color'); ?></label>
			</p>
			
			<p class="submit"><input type="hidden" name="action" value="save" /><input type="submit" name="submitform" class="defbutton" value="<?php echo attribute_escape(__('Update Background Color')); ?>" /></p>
		</form>	
		
</div>
<?php }

add_action('admin_menu', 'duotone_add_custom_box');
add_action('save_post', 'duotone_save_postdata');

function duotone_add_custom_box() {
  if( function_exists( 'add_meta_box' )) {
    add_meta_box( 'duotone_background', __( 'Background Color', 'duotone_background_color' ), 
                'duotone_background_box', 'post', 'advanced' );
   }
}
   
/* Prints the inner fields for the custom post/page section */
function duotone_background_box() {
	global $post;
 	// Use nonce for verification
  	echo '<input type="hidden" name="duotone_nonce" id="duotone_nonce" value="' . 
    	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
?>
	<script type="text/javascript" src="../wp-includes/js/colorpicker.js"></script>
	<script type='text/javascript'>
// <![CDATA[
	function pickColor(color) {
		ColorPicker_targetInput.value = color;
		kUpdate(ColorPicker_targetInput.id);
	}
	function PopupWindow_populate(contents) {
		contents += '<br /><p style="text-align:center;margin-top:0px;"><input type="button" value="<?php echo attribute_escape(__('Close Color Picker')); ?>" onclick="cp.hidePopup(\'prettyplease\')"></input></p>';
		this.contents = contents;
		this.populated = false;
	}
	function PopupWindow_hidePopup(magicword) {
		if ( magicword != 'prettyplease' )
			return false;
		if (this.divName != null) {
			if (this.use_gebi) {
				document.getElementById(this.divName).style.visibility = "hidden";
			}
			else if (this.use_css) {
				document.all[this.divName].style.visibility = "hidden";
			}
			else if (this.use_layers) {
				document.layers[this.divName].visibility = "hidden";
			}
		}
		else {
			if (this.popupWindow && !this.popupWindow.closed) {
				this.popupWindow.close();
				this.popupWindow = null;
			}
		}
		return false;
	}
	function colorSelect(t,p) {
		if ( cp.p == p && document.getElementById(cp.divName).style.visibility != "hidden" )
			cp.hidePopup('prettyplease');
		else {
			cp.p = p;
			cp.select(t,p);
		}
	}
	function PopupWindow_setSize(width,height) {
		this.width = 162;
		this.height = 210;
	}

	var cp = new ColorPicker();
	// ]]>
	</script>
	<label for="single_background_color"><?php printf(__('Any CSS color (%s or %s or %s)'), '<code>red</code>', '<code>#FF0000</code>', '<code>rgb(255, 0, 0)</code>'); ?> <input type="text" onclick="tgt=document.getElementById('single_background_color'); colorSelect(tgt,'single_background_color');return false;" name="single_background_color" id="single_background_color" value="<?php echo attribute_escape(get_post_meta($post->ID,'single_background_color', true)); ?>" /></label>
	<input type="hidden" name="pick1" id="pick1" value="<?php echo attribute_escape(__('Background Color')); ?>"></input>
	<div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;visibility:hidden;"> </div>
<?php 
}

/* When the post is saved, saves our custom data */
function duotone_save_postdata( $post_id ) {
  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  if ( !wp_verify_nonce( $_POST['duotone_nonce'], plugin_basename(__FILE__) )) {
    return $post_id;
  }

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ))
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ))
      return $post_id;
  }

  // OK, we're authenticated: we need to find and save the data
	delete_post_meta($post_id, 'single_background_color');
	if(trim($_POST['single_background_color']) != '')
		add_post_meta($post_id, 'single_background_color', $_POST['single_background_color']);

  	return $mydata;
}

// filters and actions
add_action( 'wp_head', header_function );

function header_function() {
	global $vertical;
	if( !is_single() && is_home() && !is_archive() ) query_posts( "what_to_show=posts&posts_per_page=1" );
	if(!is_archive() && !is_search()) : ?>
		<style type="text/css" media="screen">
		<?php
		while ( have_posts() ) : the_post();
			// ececute the specific stylesheet
			print_stylesheet();
			// determine if an image is vertical or not
			if(is_vertical(image_url(true))) { $vertical = true; }
 		endwhile; 
		rewind_posts(); ?>
		</style>
	<?php endif;
}

function print_stylesheet() {
	global $post;
	$color = get_post_colors($post);
	?>
	body {
		background-color: <?php if(get_option('background_color') == '') { ?> #<?php echo $color->bg['+2']; } else { 
			$customcolor =  get_option('background_color');
			if(is_int($customcolor) ) echo '#';
			echo $customcolor;
			}?>;
	}
	#page {
	  	background-color:#<?php echo $color->bg['-4']; ?>;
		color:#<?php echo $color->fg['-2']; ?>;
	}
	#menu a, #menu a:link, #menu a:visited {
		color: #<?php echo $color->bg['-1']; ?>;
	}
	#menu a:hover, #menu a:active {
		color: #<?php echo $color->fg['-3']; ?>;	
	}
	a,a:link, a:visited {
		color: #<?php echo $color->fg['-3']; ?>;
	}
  	a:hover, a:active {
		color: #<?php echo $color->bg['+2']; ?>;
	}	
	h1, h1 a, h1 a:link, h1 a:visited, h1 a:active {
		color: #<?php echo $color->fg['0']; ?>;
	}
	h1 a:hover {
		color:#<?php echo $color->bg['+2']; ?>;
	}
	.navigation a, .navigation a:link, 
	.navigation a:visited, .navigation a:active {
	  	color: #<?php echo $color->fg['0']; ?>;
	}
	h1:hover, h2:hover, h3:hover, h4:hover, h5:hover h6:hover,
	.navigation a:hover {
		color:#<?php echo $color->fg['-2']; ?>;
	}
	.description,
	h3#respond,
	#comments,
	#sidebar,
	#content #sidebar h2,
	h2, h2 a, h2 a:link, h2 a:visited, h2 a:active,
	h3, h3 a, h3 a:link, h3 a:visited, h3 a:active,
	h4, h4 a, h4 a:link, h4 a:visited, h4 a:active,
	h5, h5 a, h5 a:link, h5 a:visited, h5 a:active,
	h6, h6 a, h6 a:link, h6 a:visited, h6 a:active {
	  	/* Use the corresponding foreground color */
	  	color: #<?php echo $color->fg['-1']; ?>;
		border-color: #<?php echo $color->bg['+3']; ?>;
		border-bottom: #<?php echo $color->bg['+3']; ?>;
	}

	#postmetadata, #commentform p, .commentlist li, #post, #postmetadata .sleeve, #post .sleeve,
	#content {
		color: #<?php echo $color->fg['-2']; ?>;
		border-color: #<?php echo $color->fg['-2']; ?>;
	} <?php
}