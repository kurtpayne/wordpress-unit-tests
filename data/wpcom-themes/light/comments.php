<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?></p>
<?php
	return;
}


function light_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>

<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
<div id="div-comment-<?php comment_ID() ?>">
      <div class="commentname comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <span class="fn"><?php comment_author_link()?></span>
        on
        <span class="comment-meta commentmetadata">
        <?php comment_date() ?>
        <?php edit_comment_link(__("Edit This"), ''); ?>
        </span>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
      <em><?php _e('Your comment is awaiting moderation.'); ?></em>
      <?php endif; ?>
      <div class='commenttext'>
        <div class="commentp">
          <?php comment_text();?>
        </div>
      </div>
      <div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
</div>
<?php
}

?>
<div id="commentblock">
  <!--comments area-->
  <?php if ( have_comments() || comments_open() ) { ?>
  <h2 id="comments">
    <?php comments_number(__('No comments yet'), __('1 comment so far'), __('% comments so far')); ?>
  </h2>
  <?php } ?>

  <?php if ( have_comments() ) : ?>
	  <ol class="commentlist" id='commentlist'>
	  <?php wp_list_comments(array('callback'=>'light_comment', 'avatar_size'=>16)); ?>
	  </ol>
	  <div class="commentnav">
	    	<div class="alignleft"><?php previous_comments_link() ?></div>
    		<div class="alignright"><?php next_comments_link() ?></div>
  	</div>
  	<br />
	<?php if ( !comments_open() ) { ?>
		<p><?php _e('Comments are closed.'); ?></p>
	<?php } ?>
  <?php endif; ?>

  <div id="loading" style="display: none;"><?php _e('Posting your comment.'); ?></div>
  <div id="errors"></div>
  <?php if (comments_open()) : ?>
  <div id="respond">
  <h2><?php comment_form_title( __('Leave a reply'), __('Leave a reply to %s') ); ?><?php ; ?></h2>
  <div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
  <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
  <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
  <?php else : ?>
  <div id="commentsform">
    <form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
      <?php if ( $user_ID ) : ?>
      <p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('Log out &raquo;'); ?></a></p>
      <?php else : ?>
      <p>
        <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
        <label for="author"><small>
        <?php _e('name');?>
        <?php if ($req) _e('(required)'); ?>
        </small></label>
      </p>
      <p>
        <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
        <label for="email"><small>
        <?php _e('email');?>
        (
        <?php _e('will not be shown');?>
        )
        <?php if ($req) _e('(required)'); ?>
        </small></label>
      </p>
      <p>
        <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
        <label for="url"><small>
        <?php _e('website');?>
        </small></label>
      </p>
      <?php endif; ?>
      <p>
        <textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea>
      </p>
      <p>
        <input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Submit Comment')); ?>" />
        <?php comment_id_fields(); ?>
      </p>
      <?php do_action('comment_form', $post->ID); ?>
    </form>
  </div>
  <?php endif; // If registration required and not logged in ?>
  </div>
  <?php endif; // if you delete this the sky will fall on your head ?>
</div>
