			<div id="comments">
<?php
	$req = get_settings('require_name_email'); // Checks if fields are required. Thanks, Adam. ;-)
	if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
		die ( 'Please do not load this page directly. Thanks!' );
	if ( post_password_required() ) :
?>		<div class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'sandbox') ?></div>
		</div><!-- .comments -->
<?php
	return;
endif;

function sandbox_097_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(sandbox_comment_class(false)); ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="vcard">
	<div class="comment-avatar"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
	<div class="comment-author"><span class="fn n"><?php comment_author_link() ?></span></div>
	</div>
	<div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'sandbox'),
				get_comment_date(),
				get_comment_time(),
				'#comment-' . get_comment_ID() );
				edit_comment_link(__('Edit', 'sandbox'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'sandbox') ?>
	<?php comment_text(); ?>

	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
}


function sandbox_097_ping($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(sandbox_comment_class(false)); ?> id="comment-<?php comment_ID() ?>">
	<div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'sandbox'),
			get_comment_author_link(),
			get_comment_date(),
			get_comment_time() );
			edit_comment_link(__('Edit', 'sandbox'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'sandbox') ?>
	<?php comment_text() ?>
<?php
}

if ( have_comments() ) : ?>
<?php global $sandbox_comment_alt ?>

<?php /* numbers of pings and comments */
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>
<?php if ( $comment_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

	<div id="comments-list" class="comments">
		<h3><?php printf($comment_count > 1 ? __('<span>%d</span> Comments', 'sandbox') : __('<span>One</span> Comment', 'sandbox'), $comment_count) ?></h3>

		<ol>
		<?php wp_list_comments(array('callback'=>'sandbox_097_comment', 'avatar_size'=>16, 'type'=>'comment')); ?>
		</ol>

		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
		<br />

	</div><!-- #comments-list .comments -->

<?php endif; /* if ( $comment_count ) */ ?>
<?php if ( $ping_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

				<div id="trackbacks-list" class="comments">
					<h3><?php printf($ping_count > 1 ? __('<span>%d</span> Trackbacks', 'sandbox') : __('<span>One</span> Trackback', 'sandbox'), $ping_count) ?></h3>

					<ol>
					<?php wp_list_comments(array('callback'=>'sandbox_097_ping', 'type'=>'pings')); ?>
					</ol>
				</div><!-- #trackbacks-list .comments -->

<?php endif /* if ( $ping_count ) */ ?>
<?php endif /* if ( $comments ) */ ?>
<?php if ( comments_open() ) : ?>
				<div id="respond">
					<h3><?php comment_form_title( __('Post a Comment', 'sandbox'), __('Post a Comment to %s', 'sandbox') ); ?></h3>
					<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
					<p id="login-req"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'sandbox'),
					get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>

<?php else : ?>
					<div class="formcontainer">	
						<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

<?php if ( $user_ID ) : ?>
							<p id="login"><?php printf(__('<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Log out of this account">Log out?</a></span>', 'sandbox'),
								get_option('siteurl') . '/wp-admin/profile.php',
								wp_specialchars($user_identity, true),
								get_option('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . get_permalink() ) ?></p>

<?php else : ?>

							<p id="comment-notes"><?php _e('Your email is <em>never</em> published nor shared.', 'sandbox') ?> <?php if ($req) _e('Required fields are marked <span class="required">*</span>', 'sandbox') ?></p>

							<div class="form-label"><label for="author"><?php _e('Name', 'sandbox') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></div>
							<div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /></div>

							<div class="form-label"><label for="email"><?php _e('Email', 'sandbox') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></div>
							<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /></div>

							<div class="form-label"><label for="url"><?php _e('Website', 'sandbox') ?></label></div>
							<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="30" maxlength="50" tabindex="5" /></div>

<?php endif /* if ( $user_ID ) */ ?>

							<div class="form-label"><label for="comment"><?php _e('Comment', 'sandbox') ?></label></div>
							<div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6"></textarea></div>

							<div class="form-submit"><input id="submit" name="submit" type="submit" value="<?php _e('Post Comment', 'sandbox') ?>" tabindex="7" /><?php comment_id_fields(); ?></div>

							<?php do_action('comment_form', $post->ID); ?>

						</form><!-- #commentform -->
					</div><!-- .formcontainer -->
<?php endif /* if ( get_option('comment_registration') && !$user_ID ) */ ?>

				</div><!-- #respond -->
<?php endif /* if ( 'open' == $post->comment_status ) */ ?>

			</div><!-- #comments -->
