<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments',TEMPLATE_DOMAIN); ?><p>
<?php
	return;
}


function freshy_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>

<?php
	$author_comment_class=' none';
	if($comment->comment_author_email == get_the_author_email()) $author_comment_class=' author_comment';
	?>
	<dt class="<?php echo $author_comment_class; ?>">
		<small class="date">
			<span class="date_day"><?php comment_time('j') ?></span>
			<span class="date_month"><?php comment_time('m') ?></span>
			<span class="date_year"><?php comment_time('Y') ?></span>
		</small>
	</dt>

	<dd <?php comment_class(empty( $args['has_children'] ) ? 'commentlist_item' : 'commentlist_item parent') ?> id="comment-<?php comment_ID() ?>">			

		<div class="comment" id="div-comment-<?php comment_ID() ?>">
			<strong class="comment-author vcard author" style="height:32px;line-height:32px;">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			
			<span class="fn"><?php comment_author_link() ?></span></strong> <span class="comment-meta commentmetadata"><small>(<?php comment_time('H:i:s'); ?>)</small> : <?php edit_comment_link(__('edit',TEMPLATE_DOMAIN),'',''); ?></span>
			<?php if ($comment->comment_approved == '0') : ?>
			<small><?php _e('Your comment is awaiting moderation',TEMPLATE_DOMAIN); ?></small>
			<?php endif; ?>
			
			<br style="display:none;"/>
		
			<div class="comment_text">				
			<?php comment_text(); ?>
			</div>
			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		</div>
	</dd>
<?php
}

function freshy_end_comment($comment, $args, $depth) {
// null function here, to prevent extra div stuff at end of comment
}


if (have_comments()) : ?>
	<h3 id="comments"><?php comments_number(__('No responses yet',TEMPLATE_DOMAIN), __('One response',TEMPLATE_DOMAIN), __('% responses',TEMPLATE_DOMAIN));?></h3>

	<dl class="commentlist">
	<?php wp_list_comments(array('callback'=>'freshy_comment', 'end-callback'=>'freshy_end_comment', 'style'=>'div')); ?>
	</dl>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

<?php endif; ?>


<?php if (comments_open()) : ?>
<div id="respond">
<h3><?php comment_form_title( __('Leave a comment',TEMPLATE_DOMAIN), __('Leave a comment to %s',TEMPLATE_DOMAIN) ); ?></h3>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', TEMPLATE_DOMAIN), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>

<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', TEMPLATE_DOMAIN), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', TEMPLATE_DOMAIN); ?>"><?php _e('Log out &raquo;', TEMPLATE_DOMAIN); ?></a></p>

<?php else : ?>

<p>
	<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
	<label for="author"><?php _e('Name',TEMPLATE_DOMAIN); ?> <?php if ($req) _e('(required)',TEMPLATE_DOMAIN); ?></label>
</p>
<p>
	<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
	<label for="email"><?php _e('E-mail',TEMPLATE_DOMAIN); ?> <?php _e('(will not be published)',TEMPLATE_DOMAIN); ?> <?php if ($req) _e('(required)',TEMPLATE_DOMAIN); ?></label>
</p>
<p>
	<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	<label for="url"><?php _e('Website',TEMPLATE_DOMAIN); ?></label>
</p>

<?php endif; ?>

<p>
<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
</p>
<p>
<input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit comment',TEMPLATE_DOMAIN); ?>" />
<?php comment_id_fields(); ?>
</p>

<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
