<div class="comments">

<?php
	if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
		die ( 'Please do not load this page directly. Thanks!' );
	if ( post_password_required() ) :
?>
	<div class="nopassword"><?php _e('This post is password protected. Enter the password to proceed.', 'sandbox') ?></div>
	</div>
<?php
		return;	
	endif;
	

function chaostheory_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class(sandbox_comment_class(false)); ?>>
	<div id="div-comment-<?php comment_ID() ?>">
	<ul class="comment-meta">
		<li class="comment-author vcard">
		<div class="comment-avatar"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
		<span class="fn"><?php comment_author_link() ?></span></li>
		<?php printf(__('<li>Posted %1$s at %2$s</li> <li><a href="%3$s" title="Permalink to this comment">Permalink</a></li>', 'sandbox'),
			get_comment_date(),
			get_comment_time(),
			'#comment-' . get_comment_ID() );
			?> <li><? edit_comment_link(__('(Edit)', 'sandbox'), ' ', ''); ?> <?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></li>
	</ul>
	<div class="comment-content">
		<?php if ($comment->comment_approved == '0') : ?><span class="unapproved"><?php _e('Your comment is awaiting moderation.', 'sandbox') ?></span><?php endif; ?>
		<?php comment_text() ?>
	</div>
	</div>
<?php
}

function chaostheory_ping($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class(sandbox_comment_class(false)); ?>>
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="comment-meta">
		<?php printf(__('By %1$s on %2$s at %3$s', 'sandbox'),
			get_comment_author_link(),
			get_comment_date('d M Y'),
			get_comment_time('g:i a'));
		?>
		<?php edit_comment_link(__('(Edit)', 'sandbox'), ' ', '') ?>
	</div>
	<div class="trackback-content">
	<div class="comment-mod"><?php if ($comment->comment_approved == '0') _e('<em>Your trackback/pingback is awaiting moderation.</em>', 'sandbox') ?></div>
	<?php comment_text() ?>
	</div>
	</div>
<?php
}

?>

<?php if ( have_comments() ) : ?>
<?php global $sandbox_comment_alt ?>

<?php /* NUMBERS OF PINGS AND COMMENTS */
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>

<?php if ( $comment_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

	<h3 class="comment-header" id="numcomments"><?php printf(__($comment_count > 1 ? '%d Comments' : 'One Comment', 'sandbox'), $comment_count) ?></h3>
	<ol id="comments" class="commentlist">
	<?php wp_list_comments(array('callback'=>'chaostheory_comment', 'avatar_size'=>16, 'type'=>'comment')); ?>
	</ol>
	
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<br />
	

<?php endif; /* if ( $comment_count ) */ ?>

<?php if ( $ping_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

	<h3 class="comment-header" id="numpingbacks"><?php printf(__($ping_count > 1 ? '%d Trackbacks/Pingbacks' : 'One Trackback/Pingback', 'sandbox'), $ping_count) ?></h3>
	<ol id="pingbacks" class="commentlist">
	<?php wp_list_comments(array('callback'=>'chaostheory_ping', 'type'=>'pings')); ?>
	</ol>

<?php endif /* if ( $ping_count ) */ ?>

<?php endif /* if ( $comments ) */ ?>

<?php if ( comments_open() ) : ?>
	<div id="respond">
	<h3><?php comment_form_title( __('Post a Comment', 'sandbox'), __('Post a Comment to %s', 'sandbox') ); ?></h3>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<div id="mustlogin"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'sandbox'),
			get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></div>

<?php else : ?>

	<div class="formcontainer">	

		<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">


<?php if ( $user_ID ) : ?>

			<div class="form-one">
				<div id="loggedin"><?php printf(__('Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'sandbox'),
						get_option('siteurl') . '/wp-admin/profile.php',
						wp_specialchars($user_identity, true),
						get_option('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . get_permalink() ) ?></div>

<?php else : ?>

			<div class="form-one">
				<div class="form-label"><label for="author"><?php _e('Name', 'sandbox') ?></label> <?php if ($req) _e('<span class="req-field">*</span>', 'sandbox') ?></div>
				<div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /></div>

				<div class="form-label"><label for="email"><?php _e('Email', 'sandbox') ?></label> <?php if ($req) _e('<span class="req-field">*</span>', 'sandbox') ?></div>
				<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /></div>

				<div class="form-label"><label for="url"><?php _e('Website', 'sandbox') ?></label></div>
				<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="30" maxlength="50" tabindex="5" /></div>
			
<?php endif /* if ( $user_ID ) */ ?>
			</div>

			<div class="form-two">
				<div class="form-label"><label for="comment"><?php _e('Comment', 'sandbox') ?></label></div>
				<div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6"></textarea></div>

				<div class="form-submit">
				<input id="submit" name="submit" type="submit" value="<?php _e('Post Comment &raquo;', 'sandbox') ?>" tabindex="7" />
				<?php comment_id_fields(); ?>
				</div>
			</div>

<?php do_action('comment_form', $post->ID); ?>

		</form><!-- commentform -->
	</div><!-- formcontainer -->

<?php endif /* if ( get_option('comment_registration') && !$user_ID ) */ ?>
	</div>
<?php endif /* if ( 'open' == $post->comment_status ) */ ?>

</div>
