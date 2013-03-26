<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p><?php _e("This post is password protected. Enter the password to view comments."); ?></p>
<?php
	return;
}


function tarski_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
	<?php if ($comment->comment_approved == '0') : ?>
		<p>Your comment is awaiting moderation.</p>
	<?php endif; ?>
	
	<div <?php comment_class(empty( $args['has_children'] ) ? 'vcard' : 'vcard parent') ?> id="comment-<?php comment_ID() ?>">
		<div class="comment-metadata">
			<p class="comment-permalink"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" title="Permalink to this comment"><?php comment_date() ?> <?php _e('at'); ?> <?php comment_time() ?></a></p>
			<p class="comment-author"><strong class="fn"><?php comment_author_link(); ?></strong></p>
			<?php edit_comment_link('edit', '<p class="comment-permalink">(', ')</p>'); ?> 
		</div>
		
		<div class="comment-content">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php comment_text(); ?>
		</div>
		<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
	</div>
<?php
}

function tarski_comment_end($comment, $args, $depth) {
// null function to prevent extra ending /div
}

?>

<?php if (have_comments()) : ?>
<div id="comments" class="commentlist">
<?php if (comments_open()) : ?>

	<div id="comments-meta">
		<h2 class="comments-title"><?php comments_number('No comments yet', '1 comment', '% comments' );?></h2>
		<p class="comments-feed"><?php comments_rss_link('Comments feed for this article'); ?></p>
	</div>

<?php else : // comments are closed ?>

	<div id="comments-meta">
		<h2 class="comments-title"><?php comments_number('No comments yet', '1 comment', '% comments' );?></h2>
	</div>

<?php endif; ?>

	<?php wp_list_comments(array('callback'=>'tarski_comment', 'end-callback'=>'tarski_comment_end','style'=>'li')); ?>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<br />


</div>
<?php else : // this is displayed if there are no comments so far ?>

<?php if (comments_open()) : ?>
<div id="comments">
	<div id="comments-meta">
		<h2 class="comments-title"><?php comments_number('No comments yet', '1 comment', '% comments' );?></h2>
		<p class="comments-feed"><a title="Subscribe to this article&#8217;s comments feed" href="<?php the_permalink() ?>feed/"><?php _e('Comments feed for this article'); ?></a></p>
	</div>
</div>
<?php else : // comments are closed ?>

<?php endif; ?>

<?php endif; ?>

<?php if (comments_open()) : ?>

<div id="respond">
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
<?php // if registration is mandatory
	if ( get_option('comment_registration') && !$user_ID ) : ?>

		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
	</div>
<?php else : ?>

		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform"><fieldset>

<?php // if user is logged in
	if ( $user_ID ) : ?>

		<div id="info-input">
			<p class="userinfo">You are logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.</p>
			<p><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>
			<?php if(function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?>
		</div>

<?php // if user is not logged in - name, email and website fields
	else : ?>

			<div id="info-input">
				<label for="author">Name<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /></label>
				<label for="email">Email<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /></label>
				<label for="url">Website<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></label>
				<?php if(function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?>
			</div>


<?php // actual comment form
endif; ?>
			<div id="comment-input">
				<label for="comment">Your comment</label>
				<textarea name="comment" id="comment" cols="60" rows="12" tabindex="4"></textarea>
				<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
				<?php comment_id_fields(); ?>
				<?php if (function_exists('live_preview')) { live_preview(); } ?>
				<?php @include('constants.php'); echo $commentsFormInclude; ?>
			</div>
<?php do_action('comment_form', $post->ID); ?>
		</fieldset></form>
	</div>

<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head / O RLY / YA RLY ?>
