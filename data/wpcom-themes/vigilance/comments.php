<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'vigilance'); ?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
  <div class="comment-number" id="comments">
    <span><?php comments_number(__('No Responses', 'vigilance'), __('One Response', 'vigilance'), __('% Responses', 'vigilance') );?></span>
    <?php if( comments_open() ) : ?><a id="leavecomment" href="#respond" title="<?php _e("Leave One"); ?>"> <?php _e('leave one &rarr;', 'vigilance'); ?></a> <?php endif; ?>
  </div><!--end comment-number-->
  <ol class="commentlist">
    <?php wp_list_comments('type=comment&callback=custom_comment'); ?>
  </ol>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
  <?php if ( ! empty($comments_by_type['pings']) ) : ?>
    <h3 class="pinghead"><?php _e('Trackbacks &amp; Pingbacks', 'vigilance'); ?></h3>
    <ol class="pinglist">
      <?php wp_list_comments('type=pings&callback=list_pings'); ?>
    </ol>
  <?php endif; ?>
  
	<?php if (!comments_open()) : ?>
		<p class="note"><?php _e('Comments are closed for this entry.', 'vigilance'); ?></p>
	<?php endif; ?>
<?php elseif ( comments_open() ) : ?>
    <div class="comment-number">
      <span><?php _e('No comments yet', 'vigilance'); ?></span>
    </div>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>
  
  <div id="respond">
    <div class="cancel-comment-reply">
      <small><?php cancel_comment_reply_link(); ?></small>
    </div>
    <h4 id="postcomment"><?php comment_form_title( __('Leave a Reply', 'vigilance'), __('Leave a Reply to %s', 'vigilance') ); ?></h4>
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
      <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'vigilance'), get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink($post->ID)); ?></p>
      </div><!--end respond-->
    <?php else : ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) : ?>
        <p><?php printf(__('Logged in as <a href="%s">%s</a>', 'vigilance'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account', 'vigilance'); ?>"><?php _e('Logout &raquo;', 'vigilance'); ?></a></p>
      <?php else : ?>
        <p><label for="author" class="comment-field"><small><?php _e('Name', 'vigilance'); ?> <?php if ($req) _e('(required)', 'vigilance'); ?>:</small></label><input class="text-input" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /></p>
        <p><label for="email" class="comment-field"><small><?php _e('Email', 'vigilance'); ?> <?php if ($req) _e('(required)', 'vigilance'); ?>:</small></label><input class="text-input" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /></p>
        <p><label for="url" class="comment-field"><small><?php _e('Website:', 'vigilance'); ?></small></label><input class="text-input" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></p>
      <?php endif; ?>
      <p><label for="comment" class="comment-field"><small><?php _e('Comment:', 'vigilance'); ?></small></label><textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea></p>
      <p class="guidelines"><?php _e('<strong>Note:</strong> You can use basic XHTML in your comments. Your email address will <strong>never</strong> be published.', 'vigilance'); ?></p>
      <p class="comments-rss"><?php comments_rss_link(__('Subscribe to this comment feed via RSS', 'vigilance')); ?></p>
      <?php do_action('comment_form', $post->ID); ?>
      <p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'vigilance'); ?>" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
      <?php comment_id_fields(); ?>
    </form><!--end commentform-->
  </div><!--end respond-->

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
