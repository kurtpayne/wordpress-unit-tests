<?php 
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p><?php _e('Enter your password to view comments.','andreas04'); ?></p>
<?php
	return;
}

function andreas04_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<?php comment_text() ?>
	<p class="vcard"><cite>
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php comment_type(__('Comment','andreas04'), __('Trackback','andreas04'), __('Pingback','andreas04')); ?> 
	<?php _e('by','andreas04'); ?> 
	<span class="fn"><?php comment_author_link() ?></span> | 
	<?php comment_date() ?> <!-- @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a> --> 
	<?php edit_comment_link(__('Edit','andreas04'), ' | '); ?>
	<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'before'=>' | ', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?> 
	</cite></p>
	</div>
<?php
}

if ( have_comments() ) : ?>
<h2 id="comments"><?php comments_number(__('No Comments Yet','andreas04'), __('1 Comment','andreas04'), __('% Comments','andreas04')); ?> 
<?php if ( comments_open() ) : ?>
	<a href="#postcomment" title="<?php _e('Leave a comment','andreas04'); ?>">&raquo;</a>
<?php endif; ?>
</h2>

<ol id="commentlist">
<?php wp_list_comments(array('callback'=>'andreas04_comment', 'avatar_size'=>16)); ?>
</ol>

<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
</div>
<br />	
	
<?php elseif (comments_open()) : // If there are no comments yet ?>
	<p><?php _e('No comments yet.','andreas04'); ?></p>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
<div id="respond">
<h2 id="postcomment"><?php comment_form_title( __('Leave a comment','andreas04'), __('Leave a comment to %s','andreas04') ); ?></h2>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be','andreas04'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in','andreas04'); ?></a> <?php _e('to post a comment.','andreas04'); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as','andreas04'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','andreas04') ?>"><?php _e('Logout','andreas04'); ?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name','andreas04'); ?> <?php if ($req) _e('(required)','andreas04'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail','andreas04'); ?>E-mail <?php if ($req) _e('(required - will not be published)','andreas04'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','andreas04'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment','andreas04'); ?>" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php elseif ($comments) : ?>
	<p><?php _e('Sorry, the comment form is closed at this time.','andreas04'); ?></p>
<?php endif; ?>
