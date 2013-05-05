<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'depo-squared'); ?></p>
	<?php
		return;
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<!-- You can start editing here. -->
<?php
function depo_squared_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
			<li <?php comment_class() ?> id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment->user_id, 32 ); ?>
			<div class="commentmetadata">
			<?php printf(__('<cite>%s</cite>', 'depo-squared'), get_comment_author_link()); ?>
			<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.', 'depo-squared'); ?></em>
			<?php endif; ?>

			<small><a href="#comment-<?php comment_ID() ?>" title=""><?php printf(__('%1$s at %2$s', 'depo-squared'), get_comment_date(), get_comment_time()); ?></a><?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ')) ?> <?php edit_comment_link(__('edit', 'depo-squared'),'&nbsp;&nbsp;',''); ?></small>
			</div>
			<div class="comment-text">
				<?php comment_text() ?>
			</div>
<?php } ?>
<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number(__('No Responses', 'depo-squared'), __('One Response', 'depo-squared'), __('% Responses', 'depo-squared'));?> <?php printf(__('to &#8220;%s&#8221;', 'depo-squared'), the_title('', '', false)); ?></h3>

	<ol class="commentlist">
		<?php wp_list_comments(array('callback' => 'depo_squared_comment')); ?>	
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
<?php endif; ?>

<?php if ( have_comments() && !comments_open() ) { ?>
<p class="nocomments"><?php _e('Comments are closed.', 'depo-squared'); ?></p>
<?php } ?> 

<?php if ( comments_open() ) : ?>
<div id="respond">
<h3><?php _e('Leave a Reply', 'depo-squared'); ?></h3>
<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link() ?></small>
</div>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'depo-squared'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php comment_id_fields(); ?>

<?php if ( $user_ID ) : ?>

<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'depo-squared'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account', 'depo-squared'); ?>"><?php _e('Logout &raquo;', 'depo-squared'); ?></a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="author"><small><?php _e('Name', 'depo-squared'); ?> <?php if ($req) _e("(required)", "kubrick"); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="email"><small><?php _e('E-mail (will not be published)', 'depo-squared'); ?> <?php if ($req) _e("(required)", "kubrick"); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website', 'depo-squared'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><?php printf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', 'depo-squared'), allowed_tags()); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'depo-squared'); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>
<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
