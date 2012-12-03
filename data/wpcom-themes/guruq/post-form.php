<?php if( !is_home() && !is_front_page() ) return; ?>
<?php
$user = get_userdata( $current_user->ID );
$name = isset( $user->first_name ) && $user->first_name? $user->first_name : $user->display_name;
?>

<div id="postbox">
	<form id="new_post" name="new_post" method="post" action="<?php echo site_url(); ?>/">
		<input type="hidden" name="action" value="post" />
		<?php wp_nonce_field( 'new-post' ); ?>
		<div class="avatar"><?php if ( $user ) echo get_avatar( $user->user_email, 48 ); ?></div>
		<div class="inputarea">
<?php 
if ( !$user ) {
	$greeting = '%s%s';
	$prompt = 'Please <a href="' . wp_login_url( get_bloginfo('url') ) . '" title="Login">Login</a> to post your question.';

} else {
	$greeting = __( 'Hi, %s. %s' );
	$prompt = __( 'Post your question to the Guru.' );
}
?>
			<label for="posttext"><?php printf( $greeting, wp_specialchars( $name ), $prompt ) ?></label>
			<div>
				<textarea name="posttext" id="posttext" tabindex="1" rows="3" cols="60"></textarea>
			</div>
			<label class="post-error" for="posttext" id="posttext_error"></label>  
			<div class="postrow">
				<input id="submit" type="submit" tabindex="3" value="<?php echo attribute_escape(__('Post it', 'p2')); ?>" />
			</div>
		</div>
		<div class="clear"></div>
	</form>
</div> <!-- // postbox -->
