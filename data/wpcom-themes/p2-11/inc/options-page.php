<?php

add_action( 'init', array('P2Options', 'init') );

class P2Options {
	
	function init() {
		add_action('admin_menu', array('P2Options', 'add_options_page'));
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
		
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'colorpicker' );
		wp_enqueue_style( 'colorpicker' );
	}

	function add_options_page() {
  		add_theme_page(__('P2 Options', 'p2'), __('P2 Options', 'p2'), 8, 'p2-options-page', array('P2Options', 'page'));
	}

	function page() {
		
		register_setting('p2ops', 'prologue_show_titles');
		register_setting('p2ops', 'p2_allow_users_publish');
		register_setting('p2ops', 'p2_prompt_text');
		register_setting('p2ops', 'p2_hide_sidebar');
		register_setting('p2ops', 'p2_background_color');
		register_setting('p2ops', 'p2_background_image');
		register_setting('p2ops', 'p2_hide_threads');
		
		$prologue_show_titles_val    = get_option( 'prologue_show_titles' );
		$p2_allow_users_publish_val  = get_option( 'p2_allow_users_publish' ); 
		$p2_prompt_text_val          = get_option( 'p2_prompt_text' );
		$p2_hide_sidebar           	 = get_option( 'p2_hide_sidebar' );
		$p2_background_color      	 = get_option( 'p2_background_color' );
		$p2_background_image      	 = get_option( 'p2_background_image' );
		$p2_hide_threads    	  	 = get_option( 'p2_hide_threads' );

		if ( esc_attr( $_POST[ 'action' ] ) == 'update' ) {

			$prologue_show_titles_val = intval( $_POST[ 'prologue_show_titles' ] );
			$p2_allow_users_publish_val = intval( $_POST[ 'p2_allow_users_publish' ] );
			$p2_hide_sidebar = intval( $_POST[ 'p2_hide_sidebar' ] );
			$p2_background_color = $_POST[ 'p2_background_color_hex' ];
			$p2_background_image = $_POST[ 'p2_background_image' ];
			$p2_hide_threads = $_POST[ 'p2_hide_threads' ];

			if( esc_attr( $_POST[ 'p2_prompt_text' ] ) != __( "Whatcha' up to?" ) )
				$p2_prompt_text_val = esc_attr( $_POST[ 'p2_prompt_text' ] );

			if( !isset( $_POST[ 'p2_hide_sidebar' ] ) )
				$p2_hide_sidebar = false;

			if( !isset( $_POST[ 'p2_hide_threads' ] ) )
				$p2_hide_threads = false;
				
			if ( !isset( $_POST['p2_background_image'] ) )
				$p2_background_image = 'none';

			update_option( 'prologue_show_titles', $prologue_show_titles_val );
			update_option( 'p2_allow_users_publish', $p2_allow_users_publish_val );
			update_option( 'p2_prompt_text', $p2_prompt_text_val );
			update_option( 'p2_hide_sidebar', $p2_hide_sidebar );
			update_option( 'p2_background_color', $p2_background_color );
			update_option( 'p2_background_image', $p2_background_image );
			update_option( 'p2_hide_threads', $p2_hide_threads );
			
		?>
			<div class="updated"><p><strong><?php _e( 'Options saved.', 'p2' ); ?></strong></p></div>
		<?php

    	} ?>

		<div class="wrap">
	    <?php echo "<h2>" . __( 'P2 Options', 'p2' ) . "</h2>"; ?>
	
		<form enctype="multipart/form-data" name="form1" method="post" action="<?php echo esc_attr( str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ) ); ?>">

			<h3 style="font-family: georgia, times, serif; font-weight: normal; border-bottom: 1px solid #ddd; padding-bottom: 5px">
				<?php _e( 'Functionality Options', 'p2' ) ?>
			</h3>

			<?php settings_fields('p2ops'); ?>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><?php _e( 'Posting Access:', 'p2' ) ?></th>
						<td>
				
						<input id="p2_allow_users_publish" type="checkbox" name="p2_allow_users_publish" <?php if( $p2_allow_users_publish_val == 1 ) echo 'checked="checked"'; ?> value="1" />
			
						<?php if ( defined('IS_WPCOM') && IS_WPCOM ) 
								$msg = 'Allow any WordPress.com member to post'; 
							  else 
							  	$msg = 'Allow any registered member to post'; 
						 ?>
			 
						<label for="p2_allow_users_publish"><?php _e( $msg, 'p2' ); ?></label> 

						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Hide Threads:', 'p2' ) ?></th>
						<td>
				
						<input id="p2_hide_threads" type="checkbox" name="p2_hide_threads" <?php if( $p2_hide_threads == 1 ) echo 'checked="checked"'; ?> value="1" />
						<label for="p2_hide_threads"><?php _e( 'Hide comment threads by default', 'p2' ); ?></label> 

						</td>
					</tr>
				</tbody>
			</table>

			<p>&nbsp;
			</p>
			
			<h3 style="font-family: georgia, times, serif; font-weight: normal; border-bottom: 1px solid #ddd; padding-bottom: 5px">
				<?php _e( 'Design Options', 'p2' ) ?>
			</h3>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><?php _e( 'Custom Background Color:', 'p2' ) ?></th>
						<td>
							<input id="pickcolor" type="button" class="button" name="pickcolor" value="<?php _e( 'Pick a Color', 'buddypress' ) ?> "/>
							<input name="p2_background_color_hex" id="p2_background_color_hex" type="text" value="<?php echo attribute_escape( $p2_background_color ) ?>" />
							<div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"> </div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Background Image:', 'p2' ) ?></th>
						<td>
							<input type="radio" id="bi_none" name="p2_background_image" value="none"<?php if ( 'none' == $p2_background_image ) : ?> checked="checked" <?php endif; ?>/> <?php _e( 'None', 'p2' ) ?><br />
							<input type="radio" id="bi_bubbles" name="p2_background_image" value="bubbles"<?php if ( 'bubbles' == $p2_background_image ) : ?> checked="checked" <?php endif; ?>/> <?php _e( 'Bubbles', 'p2' ) ?><br />
							<input type="radio" id="bi_polka" name="p2_background_image" value="dots"<?php if ( 'dots' == $p2_background_image ) : ?> checked="checked" <?php endif; ?>/> <?php _e( 'Polka Dots', 'p2' ) ?><br />
							<input type="radio" id="bi_squares" name="p2_background_image" value="squares"<?php if ( 'squares' == $p2_background_image ) : ?> checked="checked" <?php endif; ?>/> <?php _e( 'Squares', 'p2' ) ?><br />
							<input type="radio" id="bi_plaid" name="p2_background_image" value="plaid"<?php if ( 'plaid' == $p2_background_image ) : ?> checked="checked" <?php endif; ?>/> <?php _e( 'Plaid', 'p2' ) ?><br />
							<input type="radio" id="bi_stripes" name="p2_background_image" value="stripes"<?php if ( 'stripes' == $p2_background_image ) : ?> checked="checked" <?php endif; ?>/> <?php _e( 'Stripes', 'p2' ) ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Sidebar display:', 'p2' ) ?></th>
						<td>
							<input id="p2_hide_sidebar" type="checkbox" name="p2_hide_sidebar" <?php if ( $p2_hide_sidebar ) echo 'checked="checked"'; ?> value="1" />
							<label for="p2_hide_sidebar"><?php _e('Hide the Sidebar', 'p2' ); ?></label> 
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Post prompt:', 'p2' ) ?></th>
						<td>
							<input id="p2_prompt_text" type="input" name="p2_prompt_text" value="<?php echo ($p2_prompt_text_val == __("Whatcha' up to?") ) ? __("Whatcha' up to?") : stripslashes( $p2_prompt_text_val ); ?>" />
				 			(<?php _e('if empty, defaults to <strong>Whatcha up to?</strong>', 'p2' ); ?>)
						</td>
					</tr>
					<tr>
						<th><?php _e( 'Post Titles:', 'p2' )?></th>
						<td>
							<input id="prologue_show_titles" type="checkbox" name="prologue_show_titles" <?php if( $prologue_show_titles_val != 0 ) echo 'checked="checked"'; ?> value="1" />
							<label for="prologue_show_titles"><?php _e('Display titles', 'p2' ); ?></label> 
						</td>
					</tr>
				</tbody>
			</table>

			<p>
			</p>

			<p class="submit">
				<input type="submit" name="Submit" value="<?php esc_attr_e('Update Options', 'p2' ) ?>" />
			</p>

		</form>
		</div>
		
		<script type="text/javascript">
	var farbtastic;

	function pickColor(color) {
		jQuery('#p2_background_color_hex').val(color);
		farbtastic.setColor(color);
	}

	jQuery(document).ready(function() {
		jQuery('#pickcolor').click(function() {
			jQuery('#colorPickerDiv').show();
		});

		jQuery('#hidetext').click(function() {
			toggle_text();
		});

		farbtastic = jQuery.farbtastic('#colorPickerDiv', function(color) { pickColor(color); });

	});

	jQuery(document).mousedown(function(){
		// Make the picker disappear, since we're using it in an independant div
		hide_picker();
	});

	function colorDefault() {
		pickColor('#<?php echo HEADER_TEXTCOLOR; ?>');
	}

	function hide_picker(what) {
		var update = false;
		jQuery('#colorPickerDiv').each(function(){
			var id = jQuery(this).attr('id');
			if (id == what) {
				return;
			}
			var display = jQuery(this).css('display');
			if (display == 'block') {
				jQuery(this).fadeOut(2);
			}
		});
	}

	function toggle_text(force) {
		if(jQuery('#textcolor').val() == 'blank') {
			//Show text
			jQuery( buttons.toString() ).show();
			jQuery('#textcolor').val('<?php echo HEADER_TEXTCOLOR; ?>');
			jQuery('#hidetext').val('<?php _e('Hide Text'); ?>');
		}
		else {
			//Hide text
			jQuery( buttons.toString() ).hide();
			jQuery('#textcolor').val('blank');
			jQuery('#hidetext').val('<?php _e('Show Text'); ?>');
		}
	}



</script>


<?php
	}
}
