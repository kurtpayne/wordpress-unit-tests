<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
	?>
			
		<p class="center"><?php _e("This post is password protected. Enter the password to view comments.",'cutline'); ?></p>
				
<?php	return; } }

?>

<!-- You can start editing here. -->

<?php if ( comments_open() || have_comments() ) { ?>

<div id="comments">

	<a name="comments"></a>
	<h3 class="comments_headers"><?php comments_number(__('0 responses','cutline'), __('1 response','cutline'), __('% responses','cutline') );?> <?php _e('so far &darr;','cutline'); ?></h3>
	
	<ul id="comment_list" class="commentlist">

	<?php if (have_comments()) { ?>
		<?php wp_list_comments(array('callback' => 'cutline_comment')); ?>	

		<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
		</div>

		<?php if (!comments_open()) { ?>
			<li class="comment">
				<div class="entry">
					<p><?php _e('Like gas stations in rural Texas after 10 pm, comments are closed.','cutline'); ?></p>
				</div>
			</li>
		<?php } ?>
	</ul>
		
	<?php } else { // this is displayed if there are no comments so far ?>

		<?php if (comments_open()) { ?> 
			<!-- If comments are open, but there are no comments. -->
				<li class="comment">
					<div class="entry">
						<p><?php _e('There are no comments yet...Kick things off by filling out the form below.','cutline'); ?></p>
					</div>
				</li>

		<?php } ?>

	</ul>

	<?php } ?>


	<!-- Comment Form -->
	<?php if (comments_open()) : ?>
	
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	
			<p class="unstyled"><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.','cutline'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
	
		<?php else : ?>

			<div id="respond">
				
			<h3 class="comments_headers"><?php _e("Leave a Comment",'cutline'); ?></h3>
			<div class="cancel-comment-reply">
				<small><?php cancel_comment_reply_link() ?></small>
			</div>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment_form">
			<?php comment_id_fields(); ?>
			<?php if ( $user_ID ) { ?>
	
				<p class="unstyled"><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.','cutline'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','cutline'); ?>"><?php _e('Logout &raquo;','cutline'); ?></a></p>
	
			<?php } ?>
			<?php if ( !$user_ID ) { ?>
				<p><input class="text_input" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" /><label for="author"><strong><?php _e('Name','cutline'); ?></strong></label></p>
				<p><input class="text_input" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" /><label for="email"><strong><?php _e('E-mail','cutline'); ?></strong></label></p>
				<p><input class="text_input" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /><label for="url"><strong><?php _e('Website','cutline'); ?></strong></label></p>
			<?php } ?>
				<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->
			
				<p><textarea class="text_input text_area" name="comment" id="comment" rows="7" tabindex="4"></textarea></p>
			
				<?php if (function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?>
			
				<p>
				<input name="submit" class="form_submit" type="submit" id="submit" src="<?php bloginfo('template_url') ?>/images/submit_comment.gif" tabindex="5" value="<?php echo attribute_escape(__('Submit','cutline')); ?>" />
					<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
				</p>
		
				<?php do_action('comment_form', $post->ID); ?>
	
			</form>
			</div>
		<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
</div> <!-- Close #comments container -->
<div class="clear"></div>
<?php } ?>
