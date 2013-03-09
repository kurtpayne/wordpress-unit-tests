<?php // This is the one template that is based on Kubrick, simply because it does it so well. Thanks Michael!

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?></p>
<?php
	return;
}

function fresh_bananas_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
	<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<span class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<p><strong class="fn"><?php printf(__('%s replied:'), get_comment_author_link()); ?></strong>
	</span>
		<?php if ($comment->comment_approved == '0') : ?>
		<br />
		<em><?php _e('Your comment is awaiting moderation.'); ?></em>
		<?php endif; ?>
		</p>

		<?php comment_text() ?>

		<p class="comment-meta commentmetadata"><?php comment_date(get_option('date_format')) ?> at <?php comment_time() ?>. <a href="#comment-<?php comment_ID() ?>" title="<?php echo attribute_escape(__('Permalink for this comment')); ?>"><?php _e('Permalink'); ?></a>. <?php edit_comment_link(__('Edit'),'',''); ?></p>

	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
}

if (have_comments()) : ?>

	<h2 id="comments"><?php comments_number(__('No Comments Yet'), __('One Comment'), __('% Comments'));?></h2> 
	<ol id="commentlist">
	<?php wp_list_comments(array('callback'=>'fresh_bananas_comment', 'avatar_size'=>48)); ?>
	</ol>
	
	<div class="navigation">
		<p class="alignleft"><?php previous_comments_link() ?></p>
		<p class="alignright"><?php next_comments_link() ?></p>
	</div>
	
 <?php else : // no comments yet ?>

  <?php if (comments_open()) : ?> 
		<!-- If comments are open, but there are no comments. -->
		<h3><?php _e('No Comments Yet'); ?></h3>
		<p><?php _e('Be the first to comment!'); ?></p>
	<?php endif; ?>
<?php endif; ?>

<?php if (comments_open()) : ?>

<div id="respond">
	<h2><?php comment_form_title( __('Leave a Reply'), __('Leave a Reply to %s') ); ?></h2>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'kubrick'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>

<form id="reply" method="post" action="<?php echo get_settings('siteurl'); ?>/wp-comments-post.php">
	<div id="hidden">
		<?php comment_id_fields(); ?>
		<input type="hidden" name="redirect_to" value="<?php echo attribute_escape($_SERVER["REQUEST_URI"]); ?>" />
	</div>

	<div id="c_personal">

<?php if ( $user_ID ) : ?>
<?php // If logged in. ?>

	<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'kubrick'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account', 'kubrick'); ?>"><?php _e('Logout &raquo;', 'kubrick'); ?></a></p>
<?php else : ?>
<?php // If not logged in show user-related form fields ?>

	<p><label for="author"><?php _e('Name');?></label><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /></p>

	<p><label for="email"><?php _e('Email'); ?></label><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /></p>

	<p><label for="url"><?php _e('Website'); ?></label><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></p>

<?php endif; ?>
<?php // Always show text-area and submit ?>
	</div>

	<div id="c_comment">
	<p><label for="comment"><?php _e('Comment'); ?></label>
			<textarea name="comment" id="comment" rows="5" cols="34"></textarea></p>

			<input id="submit" class="button" type="submit" value="<?php echo attribute_escape(__('Reply')); ?>" />
	</div>

<?php // Tell your users which, if any, text-to-html system you are using. ?>
	<?php if(function_exists('markdown')) { ?>
		<p>You may use <a href="http://daringfireball.net/projects/markdown/" title="Markdown, the greatest html-to-text tool">Markdown</a> syntax in your comment. All inappropriate comments will be deleted.</p>
	<?php } elseif (function_exists('textile')) {  ?>
		<p>You may use <a href="http://www.textism.com/tools/textile/" title="Textile, a good html-to-text tool">Textile</a> syntax in your comment. All inappropriate comments will be deleted.</p>
	<?php } ?>
</form>
<?php endif; ?>
</div>
<?php endif; // need to be registered ?>

	<?php if (pings_open() ) { ?>
	<?php // Show the trackback address if ping is enabled ?>
	<p><a href="<?php trackback_url(); ?>" title="<?php echo attribute_escape(__('Trackback URI')); ?>"><?php _e('Trackback URI'); ?></a></p>
<?php } ?>
