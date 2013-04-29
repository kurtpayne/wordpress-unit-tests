<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die (__('Please do not load this page directly. Thanks!', 'flower-power'));
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", 'flower-power'); ?></p>
</div> <!-- /comments -->
<?php
	return;
}

global $commentcount;
$commentcount = 1;

function flower_power_comment($comment, $args, $depth) {
	global $comment_alt, $commentcount;
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php echo $commentcount ?>">
<div id="div-comment-<?php comment_ID() ?>">
<div class="comment-author vcard">
	<div class="avatar"><?php echo get_avatar($comment, 32); ?></div>
	<p class="header<?php if ( $comment_alt % 2 ) { echo 'alt'; } ?>"><strong><?php echo $commentcount ?>.</strong>

	<?php if ($comment->comment_type == "comment") comment_author_link();
		  else {
		  		strlen($comment->comment_author)?$author=substr($comment->comment_author,0,25)."&hellip":$author=substr($comment->comment_author,0,25);
		  		echo '<a href="'.$comment->comment_author_url.'">'.$author.'</a>';

		  }
	?> &nbsp;|&nbsp; <span class="comment-meta commentmetadata"><?php printf(__('%s at %s', 'flower-power'), get_comment_date(), get_comment_time()); ?></span></p>
</div>
	<?php if ($comment->comment_approved == '0') : ?><p><em><?php _e('Your comment is awaiting moderation.', 'flower-power'); ?></em></p><?php endif; ?>
	<?php comment_text(); ?>
	<?php edit_comment_link(__('Edit Comment', 'flower-power'),'<span class="editlink">','</span>'); ?>
	
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
$commentcount++;
}

if (have_comments()) : ?>

	<div class="divider"></div>

	<h2><?php comments_number(__('No Comments Yet'), __('1 Comment'), __('% Comments') ); if($post->comment_status == "open") { ?> <a href="#commentform" class="more">Add your own</a><?php } ?></h2>

	<ul class="commentlist">
	<?php wp_list_comments(array('callback'=>'flower_power_comment')); ?>
	</ul>

	<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	
<?php endif; ?>

<?php if (comments_open()) : ?>

	<div class="divider"></div>
	<div id="respond">
	<h2><?php comment_form_title( __('Leave a Comment', 'flower-power'), __('Leave a Comment to %s', 'flower-power') ); ?></h2>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
<?php if (get_option('comment_registration') && !$user_ID) : ?>
	<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'flower-power'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
	
<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ($user_ID) : ?>

		<p class="info"><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'flower-power'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'flower-power'); ?>"><?php _e('Log out &raquo;', 'flower-power'); ?></a></p>

<?php else : ?>

			<p><label for="author"><?php _e('Name', 'flower-power'); ?></label> <?php if ($req) echo "<em>Required</em>"; ?> <br /> <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" /></p>
			<p><label for="email"><?php _e('Email', 'flower-power'); ?></label> <em><?php if ($req) ?> <?php _e('Required,', 'flower-power'); ?> <?php _e('hidden', 'flower-power'); ?></em> <br /> <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" /></p>
			<p><label for="url"><?php _e('Url', 'flower-power'); ?></label><br /> <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /></p>

<?php endif; ?>

			<p><label for="comment"><?php _e('Comment', 'flower-power'); ?></label><br /> <textarea name="comment" id="comment" cols="25" rows="10" tabindex="4"></textarea></p>
			<p><?php comment_id_fields(); ?>
			<input type="submit" name="submit" value="Submit" class="button" tabindex="5" /></p>

	<?php do_action('comment_form', $post->ID); ?>
	</form>

	<p><strong><?php _e('Some HTML allowed:', 'flower-power'); ?></strong><br/><?php echo allowed_tags(); ?></p>
<?php endif; // If registration required and not logged in ?>
	</div>
<?php endif; // if you delete this the sky will fall on your head ?>

<?php if (comments_open() && pings_open()) { ?>
	<p><a href="<?php trackback_url('display'); ?>"><?php _e('Trackback this post', 'flower-power'); ?></a> &nbsp;|&nbsp; <?php post_comments_feed_link(__('Subscribe to comments via RSS Feed', 'flower-power')); ?></p>
<?php } elseif (comments_open()) {?>
	<p><?php post_comments_feed_link(__('Subscribe to comments via RSS Feed', 'flower-power')); ?></p>
<?php } elseif (pings_open()) {?>
	<p><a href="<?php trackback_url('display'); ?>"><?php _e('Trackback', 'flower-power'); ?></a></p>
<?php } ?>

<div class="divider"></div>
		
</div> <!-- /comments -->
