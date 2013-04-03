<?php if ('open' == $post->comment_status || $comments) : ?>                     

<div class="narrowcolumnwrapper"><div class="narrowcolumn">
	<div class="content">
	<div <?php post_class('post'); ?>>

<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", 'digg3'); ?></p></div></div></div></div>
<?php
	return;
}


function digg3_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>

<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
<div id="div-comment-<?php comment_ID() ?>">
	<div class="comment-meta commentmetadata">
		<?php if ($args['avatar_size'] != 0) { ?><div class="avatar"><?php echo get_avatar( $comment, $args['avatar_size'] ); ?></div><?php } ?>
		<span class="comment-author vcard"><strong class="fn"><?php comment_author_link() ?></strong>, <?php _e('on', 'digg3'); ?> <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> <?php _e('at', 'digg3');?> <?php comment_time() ?></a> <?php _e('Said&#58;', 'digg3'); ?> <?php edit_comment_link('Edit Comment','',''); ?></span>
		<?php if ($comment->comment_approved == '0') : ?>
		<em><?php _e('Your comment is awaiting moderation.', 'digg3'); ?></em>
		<?php endif; ?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
</div>
<?php
}

if (have_comments()) :
?>
	<h3 id="comments"><?php comments_number(__('No Responses Yet'), __('One Response'), __('% Responses') );?></h3>

	<ol class="commentlist">
	<?php wp_list_comments(array('callback'=>'digg3_comment')); ?>
	</ol>

	<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	
	<?php if (!comments_open()) : ?>
	<p class="nocomments"><?php _e('Comments are closed.', 'digg3'); ?></p>
	<?php endif; ?>

<?php endif; ?>


<?php if (comments_open()) : ?>
<div id="respond">
<h3 id="respondtitle"><?php comment_form_title( __('Leave a Reply'), __('Leave a Reply to %s') ); ?></h3>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'digg3'), get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink()); ?></p>
 
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>

<p><?php printf(__('Logged in as <a href="%s">%s</a>', 'digg3'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account', 'digg3'); ?>"><?php _e('Logout &raquo;', 'digg3'); ?></a></p>
<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
<label for="author"><small><?php _e('Name', 'digg3'); ?> <?php if ($req) echo __('(required)', 'digg3'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)', 'digg3'); ?> <?php if ($req) echo __('(required)', 'digg3'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
<label for="url"><small><?php _e('Website', 'digg3'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags&#58;', 'digg3'); ?> <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<?php comment_id_fields(); ?>
</p>

<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
	</div>
	</div>
</div></div>

<?php endif; ?>
