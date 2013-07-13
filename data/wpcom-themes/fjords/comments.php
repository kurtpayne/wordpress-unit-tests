<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p><?php _e('Enter your password to view comments.'); ?></p>
<?php
	return;
}
?>
<?php if ( have_comments() || comments_open() ) : ?>
<h2 id="comments"><?php comments_number(__('No comments yet'), __('1 Comment'), __('% Comments')); ?> 
<?php if ( comments_open() ) : ?>
<a href="#postcomment" title="<?php _e("Leave a comment"); ?>">&raquo;</a>
<?php endif; ?>
</h2>
<?php endif; ?>

<?php 

function fjords_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<div <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="comentarios">
		<span class="comment-author vcard"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>&nbsp;
		<span class="fn"><a href="<?php comment_author_url(); ?>"> 
		<?php comment_author(); ?></a></span> wrote @ <span class="comment-meta commentmetadata"><?php comment_date(); ?> at <?php comment_time(); ?></span>
		</span>
	</div>	
	<?php comment_text(); ?>
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
}

if ( have_comments() ) : 
wp_list_comments(array('callback'=>'fjords_comment', 'style'=>'div'));
?>
<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
</div>
<br />
	
<?php if ( !comments_open() ) : ?>
	<p>Sorry, the comment form is closed at this time.</p>
<?php endif; ?>

<?php else : // If there are no comments yet ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>
<div id="respond">
<h2 id="postcomment"><?php comment_form_title( __('Your comment'), __('Your comment to %s') ); ?></h2>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" class="input" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label></p>

<p><input type="text" class="input" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small>E-mail <?php if ($req) echo "(Required, not published )"; ?></small></label></p>

<p><input type="text" class="input" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small>Website</small></label></p>

<?php endif; ?>

<p><textarea name="comment" class="textarea" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
<?php if (function_exists('lmbbox_smileys_display')) { lmbbox_smileys_display(true); } ?>
<p><input name="submit" class="sub" type="submit" id="submit" tabindex="5" value="Submit" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<p> <strong>HTML-Tags:</strong>
<br />
<small><?php echo allowed_tags(); ?></small>
</p>
<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; ?>
