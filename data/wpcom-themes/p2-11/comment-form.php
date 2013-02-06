<?php
	// @names
	// $init_var_names = array( 'comment_author', 'comment_author_email', 'comment_author_url' );
	// foreach($init_var_names as $name) {
	// 	if (!isset($$name)) $$name = '';
	// }
	
	// Moved to functions.php - p2_init_at_names() on template_redirect but should be on a new custom action
?>
    <h3>
		<?php _e( 'Reply', 'p2' ) ?> 
		
		<small id="cancel-comment-reply">
			<?php echo cancel_comment_reply_link() ?>
    	
	    	<?php if ( is_user_logged_in() ) : ?>
	    		(<?php printf( __( 'Logged in as <a href="%1$s">%2$s</a>.', 'p2' ), site_url( '/wp-admin/profile.php' ), p2_get_user_identity() ); ?> 
				
				<a href="<?php echo wp_logout_url( get_permalink() ) ?>" title="<?php echo attribute_escape( __( 'Log out of this account', 'p2' ) ); ?>">
					<?php _e( 'Log out &rarr;', 'p2'); ?>
				</a>)
	    	<?php endif; ?>
		</small>
	</h3>
	
	<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>

		<p><?php printf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'p2'), site_url( '/wp-login.php?redirect_to=' . urlencode( get_permalink() ) ) ) ?></p>
    
	<?php else : // current user is allowed to comment ?>

 	   <form id="commentform" action="<?php echo site_url( 'wp-comments-post.php' ) ?>" method="post">
	        <div class="form">
	            <textarea id="comment" name="comment" cols ="45" rows="3"></textarea>
	        </div>
	
	        <label class="post-error" for="comment" id="commenttext_error"></label>
	
	        <?php if ( !is_user_logged_in() ) : ?>
		
		        <table>
		        	<tr>
		        		<td>
		        			<label for="author"><?php _e('Name <em>(required)</em>', 'p2'); ?></label>
		        			<div class="form"><input id="author" name="author" type="text" value="<?php echo attribute_escape($comment_author); ?>" /></div>
		        		</td>
		        		<td>
		        			<label for="email"><?php _e('Email <em>(required)</em>', 'p2'); ?></label>
		        			<div class="form"><input id="email" name="email" type="text" value="<?php echo attribute_escape($comment_author_email); ?>"  /></div>
		        		</td>
		        		<td class="last-child">
		        			<label for="url"><?php _e('Web Site', 'p2'); ?></label>
		        			<div class="form"><input id="url" name="url" type="text" value="<?php echo attribute_escape($comment_author_url); ?>"  /></div>
		        		</td>
		        	</tr>
		        </table>
		
			<?php else : ?>
				
				<?php do_action( 'comment_form' ); ?>
				
	        <?php endif; // if user_ID ?>
	
	        <div>
	            <input id="comment-submit" name="submit" type="submit" value="<?php echo attribute_escape( __( 'Reply', 'p2' ) ); ?>" />
	            <?php comment_id_fields() ?>&nbsp;
	            
				<span class="progress">
	                <img src="<?php echo str_replace( WP_CONTENT_DIR, content_url(), locate_template( array( 'i/indicator.gif' ) ) ) ?>" alt="<?php echo attribute_escape( __('Loading...', 'p2' ) ); ?>" title='<?php echo attribute_escape( __( 'Loading...', 'p2' ) ); ?>' />
	            </span>
	        </div>
	
		</form>
	
	<?php endif; // comment registration ?>