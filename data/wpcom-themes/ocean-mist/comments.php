<?php // Do not delete these lines
	$req = get_option('require_name_email'); // Checks if fields are required.

	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!'));

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
					<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?><p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if (have_comments()) : ?>
		<div class="title">
		<h2 id="comments"><?php _e('Responses'); ?></h2>
		</div>
		<ol class="commentlist">
		<?php wp_list_comments(array('callback' => 'oceanmist_comment')); ?>	
		</ol>
		
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
		<br />
		
<?php endif; ?>

<?php if (comments_open()) : ?>
<div id='respond'>
	
		<div class="title">
		<h2><?php _e('Leave a response'); ?></h2>
		</div>
		<div class="cancel-comment-reply">
			<small><?php cancel_comment_reply_link() ?></small>
		</div>
		<div <?php post_class(); ?>>

  <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
  <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
  </div>
 
  <?php else : ?>
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php comment_id_fields(); ?>
  <div class="postinfo">
  
    <?php if ( $user_ID ) : ?>
    <p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> </p>
    <ul class="buttons">
      <li><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account'); ?>"><?php _e('Logout &raquo;'); ?></a></li>
    </ul>

    <?php else : ?>
	<p><label for="author"><?php _e('Name'); ?><?php if ($req) _e('<span class="req">*</span>'); ?></label><br />
    <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1"  class="field"/><br />
	<label for="email"><?php _e('Email'); ?><?php if ($req) _e('<span class="req">*</span>'); ?></label><br />
    <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" class="field" /><br />
	<label for="url"><?php _e('Website'); ?></label><br />
    <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" class="field" /></p>

    <?php endif; ?>
  
  </div>
  <div class="entry">
  <!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

  <p><?php _e('Your response:'); ?><br />
  <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

  <p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Submit Comment')); ?>" />
  <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
  </p>
  <?php do_action('comment_form', $post->ID); ?>
  </div>
  </form>
  </div>
  <?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
