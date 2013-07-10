<?php
	// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','mistylook'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
<h3 id="comments"><?php comments_number(__('No Responses Yet','mistylook'), __('One Response','mistylook'), __('% Responses','mistylook'));?></h3>

	<ol class="commentlist">
	<?php wp_list_comments(array('callback' => 'mistylook_comment')); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<br />

  <?php if (!comments_open()) : ?> 
	<p class="nocomments"><?php _e('Comments are closed.','mistylook'); ?></p>
  <?php endif; ?>
<?php endif; ?>
<div class="post-content">
<p>
<?php if (comments_open()) {?>
	<span class="commentsfeed"><?php comments_rss_link(__('Comments RSS','mistylook')); ?></span>
<?php }; ?>
</p>
</div>

<?php if ( comments_open() ) : ?>

<div id="respond">

<h3><?php comment_form_title( __('Leave a Reply','mistylook'), __('Leave a Reply to %s','mistylook') ); ?></h3>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link() ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.','mistylook'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.','mistylook'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','mistylook'); ?>"><?php _e('Logout &raquo;','mistylook'); ?></a></p>

<?php else : ?>

<p><input class="textbox" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name','mistylook'); ?> <?php if ($req) _e('(required)','mistylook'); ?></small></label></p>

<p><input class="textbox" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)','mistylook'); ?> <?php if ($req) _e('(required)','mistylook'); ?></small></label></p>

<p><input class="textbox" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','mistylook'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment','mistylook'); ?>" />
<?php comment_id_fields(); ?></p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

</div>

<?php endif; // if you delete this the sky will fall on your head ?>
