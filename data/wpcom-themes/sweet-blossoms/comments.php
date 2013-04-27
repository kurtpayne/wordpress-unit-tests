<?php // Do not delete these lines

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?></p>
<?php
	return;
}

global $commentcount;
$commentcount = 1;

function sweet_blossoms_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $commentcount, $comment_alt;
	extract($args, EXTR_SKIP);
?>

	<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<p class="header<?php if ($comment_alt % 2 ) echo 'alt'; ?>"><strong><?php echo $commentcount ?>.</strong>
	<span class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<span class="fn"><?php if (get_comment_type() == "comment") comment_author_link();
		  else {
		  		strlen($comment->comment_author)?$author=substr($comment->comment_author,0,25)."&hellip":$author=substr($comment->comment_author,0,25);
		  		echo '<a href="'.$comment->comment_author_url.'">'.$author.'</a>';

		  }
	?></span></span> &nbsp;|&nbsp; <?php comment_date() ?> at <?php comment_time() ?></p>
	<?php if ($comment->comment_approved == '0') : ?><p><em>Your comment is awaiting moderation.</em></p><?php endif; ?>
	<?php comment_text() ?>
	<?php edit_comment_link('Edit Comment','<span class="editlink">','</span>'); ?>
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
	$commentcount++;
}

?>

<?php if (have_comments()) : ?>

		<div style="padding:20px 0px 0px 0px;"></div>
		
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/divider.gif" alt="" />
		
		<div style="padding:20px 0px 0px 0px;"></div>


	<h2><?php comments_number('No Comments Yet', '1 Comment', '% Comments' ); if($post->comment_status == "open") { ?> <a href="#commentform" class="more">Add your own</a><?php } ?></h2>

	<ul class="commentlist">
	<?php wp_list_comments(array('callback'=>'sweet_blossoms_comment', 'avatar_size'=>16)); ?>
	</ul>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<br />

<?php endif; ?>

<?php if (comments_open()) : ?>

		<div style="padding:20px 0px 0px 0px;"></div>
		
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/divider.gif" alt="" />
		
		<div style="padding:20px 0px 0px 0px;"></div>
<div id="respond">
	<h2><?php comment_form_title( 'Leave a Comment', 'Leave a Comment to %s' ); ?></h2>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

	<?php if (get_option('comment_registration') && !$user_ID) : ?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>

<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ($user_ID) : ?>

		<p class="info">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout</a>.</p>

<?php else : ?>

			<p><label for="author">Name</label> <?php if ($req) echo "<em>Required</em>"; ?> <br /> <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" /></p>
			<p><label for="email">Email</label> <em><?php if ($req) echo "Required, "; ?>hidden</em> <br /> <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" /></p>
			<p><label for="url">Url</label><br /> <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /></p>

<?php endif; ?>

			<p><label for="comment">Comment</label><br /> <textarea name="comment" id="comment" cols="25" rows="10" tabindex="4"></textarea></p>
			<p><?php comment_id_fields(); ?>
			<input type="submit" name="submit" value="Submit" class="button" tabindex="5" /></p>

	<?php do_action('comment_form', $post->ID); ?>
	</form>

	<p><strong>Some HTML allowed:</strong><br/><?php echo allowed_tags(); ?></p>

<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>

<?php if (comments_open() && pings_open()) { ?>
	<p><a href="<?php trackback_url(display); ?>">Trackback this post</a> &nbsp;|&nbsp; <?php comments_rss_link('Subscribe to comments via RSS Feed'); ?></p>
<?php } elseif (comments_open()) {?>
	<p><?php comments_rss_link('Subscribe to comments via RSS Feed'); ?></p>
<?php } elseif (pings_open()) {?>
	<p><a href="<?php trackback_url(display); ?>">Trackback</a></p>
<?php } ?>

		<div style="padding:20px 0px 0px 0px;"></div>
		
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/divider.gif" alt="" />
