<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<?php function springloaded_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<div class="comment-gravatar">
				<?php echo get_avatar( $comment, 30 ); ?>
			</div>
			<div class="comment-body">
				<div class="comment-head">
					<p><?php printf(__('Posted by %1$s on <a href="#comment-%2$s">%3$s at %4$s</a>'), get_comment_author_link(), get_comment_ID(), get_comment_date(), get_comment_time()); ?><?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></p>
					<?php if ($comment->comment_approved == '0') : ?>
						<p><em><?php _e('Your comment is awaiting moderation.'); ?></em></p>
					<?php endif; ?>
				</div>
				<div class="comment-text">
					<?php comment_text() ?>
					<p><?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '')) ?></p>
				</div>
			</div>
		</li>
<?php } ?>
<div class="comments-show">


<?php if ( have_comments() ) { ?>	
	<h3 id="comments"><?php comments_number(__('No Responses Yet'), __('One Response'), __('% Responses') );?> to this post.</h3>

	<ol class="commentlist">

	<?php wp_list_comments(array('callback' => 'springloaded_comment')); ?>

	</ol>

	<div class="prev-next">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

<?php } ?>


	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php elseif( have_comments() && !comments_open() ) : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.'); ?></p>

	<?php endif; ?>


<?php if ( comments_open() ) : ?>
<div id="respond">
<h3><?php _e('Respond to this post'); ?></h3>
<div class="cancel-comment-reply">
    <small><?php cancel_comment_reply_link() ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p id="login-req"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'sandbox'),
get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>
<?php else : ?>
<div class="comment-form">
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php comment_id_fields(); ?>
<?php if ( $user_ID ) : ?>

<p id="login"><?php printf(__('<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Log out of this account">Log out?</a></span>', 'sandbox'),
	get_option('siteurl') . '/wp-admin/profile.php',
	wp_specialchars($user_identity, true),
	get_option('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . get_permalink() ) ?></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name'); ?> <?php if ($req) _e("(required)"); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)');?> <?php if ($req) _e("(required)"); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website'); ?></small></label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment'); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>
</div>
</div>
<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>

</div>
