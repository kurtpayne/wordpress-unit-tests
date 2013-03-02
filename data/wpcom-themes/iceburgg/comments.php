<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php
	return;
}
		

		/* Function for seperating comments from track- and pingbacks. */
	function comment_type_detection($commenttxt = 'Comment', $trackbacktxt = 'Trackback', $pingbacktxt = 'Pingback') {
		global $comment;
		if (preg_match('|trackback|', $comment->comment_type))
			return $trackbacktxt;
		elseif (preg_match('|pingback|', $comment->comment_type))
			return $pingbacktxt;
		else
			return $commenttxt;
	}

function iceburgg_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
 <li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
 <div id="div-comment-<?php comment_ID() ?>">
      <span class="comment-author vcard">
      <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
      <span class="cauthor fn">
      <?php comment_author_link() ?>
      </span>
      </span>
      <?php if ($comment->comment_approved == '0') : ?>
      <em>Your comment is awaiting moderation.</em>
      <?php endif; ?>
      <br />
      <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" class="permalink" title=""></a>
      <?php comment_text() ?>
      <div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
 </div>
<?php
}
?>
<div id="commentarea">
  <?php if ($comments) : ?>
  <div id="precomments">
    <div class="comleft">
      <h3 id="comments">
        <?php comments_number('No Responses Yet', 'One Response', '% Responses' );?>
        to &#8220;
        <?php the_title(); ?>
        &#8221;</h3>
    </div>
    <div class="comright">
      <?php comments_rss_link(); ?>
    </div>
    <div style="clear: both"></div>
  </div>
  <div style="clear: both"></div>
  <ol class="commentlist">
  
  <?php wp_list_comments(array('callback'=>'iceburgg_comment', 'avatar_size'=>48)); ?>
  </ol>

  <div class="navigation">
  	<div class="alignleft"><?php previous_comments_link() ?></div>
  	<div class="alignright"><?php next_comments_link() ?></div>
  </div>
	
  <?php else : // this is displayed if there are no comments so far ?>
  <?php if (comments_open()) : ?>
  <!-- If comments are open, but there are no comments. -->
  <?php else : // comments are closed ?>
  <!-- If comments are closed. -->
  <?php endif; ?>
  <?php endif; ?>
  <?php if (comments_open()) : ?>
  <div style="clear: both"></div>
  <div id="respond">
  <div id="dropsome">
    <h3 id="commentsreply"><?php comment_form_title( 'Respond now.', 'Respond to %s now.' ); ?></h3>
  </div>
  <div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
  <div style="clear: both"></div>
  <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
  <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged
      in</a> to post a comment.</p>
  <?php else : ?>
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    <?php if ( $user_ID ) : ?>
    <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
    <?php else : ?>
    <p>
      <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
      <label for="author"><small>Name
      <?php if ($req) echo "(required)"; ?>
      </small></label>
    </p>
    <p>
      <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
      <label for="email"><small>E-mail (will not be published)
      <?php if ($req) echo "(required)"; ?>
      </small></label>
    </p>
    <p>
      <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
      <label for="url"><small>Website</small></label>
    </p>
    <?php endif; ?>

    <p>
      <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4">
</textarea>
    </p>
    <p>
      <input name="submit" class="submitbutton" type="submit" id="submit" tabindex="5" value="Submit Comment" />
      <?php comment_id_fields(); ?>
    </p>
    <?php do_action('comment_form', $post->ID); ?>
  </form>
  <?php endif; // If registration required and not logged in ?>
  </div>
  <?php endif; // if you delete this the sky will fall on your head ?>
</div>
