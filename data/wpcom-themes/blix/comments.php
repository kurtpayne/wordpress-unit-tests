<!-- comments ................................. -->
<div id="comments">

<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) { 
	echo '<p class="nocomments">' . __("This post is password protected. Enter the password to view comments.") . '</p></div>';
	return;
}
global $commentcount;
$commentcount = 1;

function blix_callback($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	global $comment_alt, $commentcount;
	if ( $comment_alt % 2 ) $commentalt = ' alt';
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="comment-author vcard">
	<p class="header<?php echo $commentalt; ?>"><strong><?php echo $commentcount ?>.</strong>

	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>

	<span class="fn"><?php if ($comment->comment_type == "comment") comment_author_link();
		  else {
		  		strlen($comment->comment_author) > 25 ? $author = substr($comment->comment_author,0,25) . "&hellip" : $author=substr($comment->comment_author,0,25);
		  		echo get_comment_author_link();

		  }
	?></span> &nbsp;|&nbsp; <?php comment_date() ?> at <?php comment_time() ?></p></div>
	<?php if ($comment->comment_approved == '0') : ?><p><em>Your comment is awaiting moderation.</em></p><?php endif; ?>
	<?php comment_text() ?>
	<?php edit_comment_link('Edit Comment','<span class="editlink">','</span>'); ?>
	<span class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</span>
	</div>
	
<?php 
	$commentcount++;
}

if (have_comments()) : ?>

	<h2><?php comments_number('No Comments Yet', '1 Comment', '% Comments' ); if(comments_open()) { ?> <a href="#commentform" class="more">Add your own</a><?php } ?></h2>

	<ul class="commentlist">
		<?php wp_list_comments(array('callback'=>'blix_callback', 'avatar_size'=>23)); ?>
	</ul>
	<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
	</div>

<?php endif; ?>
<?php if (comments_open()) : ?>
	<div id="respond">
	<h2><?php comment_form_title( 'Leave a Comment', 'Leave a Comment to %s' ); ?></h2>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
	<?php if (get_option('comment_registration') && !$user_ID) : ?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>

<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<fieldset>

	<?php if ($user_ID) : ?>

		<p class="info">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout</a>.</p>

<?php else : ?>

			<p><label for="author">Name</label> <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" /> <?php if ($req) echo "<em>Required</em>"; ?></p>
			<p><label for="email">Email</label> <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" /> <em><?php if ($req) echo "Required, "; ?>hidden</em></p>
			<p><label for="url">Url</label> <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /></p>

<?php endif; ?>

			<p><label for="comment">Comment</label> <textarea name="comment" id="comment" cols="45" rows="10" tabindex="4"></textarea></p>
			<p><?php comment_id_fields(); ?>
			<input type="submit" name="submit" value="Submit" class="button" tabindex="5" /></p>

	  	</fieldset>
	<?php do_action('comment_form', $post->ID); ?>
	</form>

	<p><strong>Some HTML allowed:</strong><br/><?php echo allowed_tags(); ?></p>
<?php endif; // If registration required and not logged in ?>
	</div>
<?php endif; // if you delete this the sky will fall on your head ?>

<?php if (comments_open() && pings_open()) { ?>
	<p><a href="<?php trackback_url(display); ?>">Trackback this post</a> &nbsp;|&nbsp; <?php comments_rss_link('Subscribe to the comments via RSS Feed'); ?></p>
<?php } elseif (comments_open()) {?>
	<p><?php comments_rss_link('Subscribe to the comments via RSS Feed'); ?></p>
<?php } elseif (pings_open() ) {?>
	<p><a href="<?php trackback_url(display); ?>">Trackback this post</a></p>
<?php } ?>

</div> <!-- /comments -->
