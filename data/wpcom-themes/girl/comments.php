<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','girl'); ?></p>
<?php
	return;
}

function girl_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<div <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
<div class="comment-author vcard">
<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
<div class="heading"><span class="fn"><?php comment_author_link() ?></span> <?php _e('says:','girl'); ?></div>
</div>
<div class="entry">
<?php if ($comment->comment_approved == '0') : ?>
<b><?php _e('Your comment is awaiting moderation.','girl'); ?></em></b><br />
<?php endif; ?>
<?php comment_text() ?>
<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => 'comment-footer', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
</div>
</div>
<div class="footer comment-meta commentmetadata" id="comment-footer-<?php comment_ID() ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" title=""><?php comment_date(get_option('date_format')) ?> <?php _e('at','girl'); ?> <?php comment_time() ?></a> <?php edit_comment_link(__('e','girl'),'',''); ?></div>
<br />
<br />
<?php
}

if (have_comments()) : ?>

<div class="commentlist">
	<?php wp_list_comments(array('callback'=>'girl_comment', 'style'=>'div')); ?>
</div>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
<?php endif; ?>

<div class="comments">
<?php if (comments_open()) : ?>
<div id="respond">
<h3><?php comment_form_title( __('Leave a Reply','girl'), __('Leave a Reply to %s','girl')); ?></h3>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be','girl'); ?> <a href="../wp/flowers/simplicity/<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in','girl'); ?></a> <?php _e('to post a comment.','girl'); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p class="logged"><?php _e('Logged in as','girl'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','girl'); ?>"><?php _e('Logout','girl'); ?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name','girl'); ?> <?php if ($req) _e('(required)','girl'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)','girl'); ?> <?php if ($req) _e('(required)','girl'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','girl'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="75%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment','girl'); ?>" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php elseif ( have_comments() ) : ?>
	<p class="nocomments"><?php _e('Comments are closed.','girl'); ?></p>
<?php endif; // if you delete this the sky will fall on your head ?>

</div>
