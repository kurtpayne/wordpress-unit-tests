<?php // Do not delete these lines - borrowed directly from Kubrick
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
	?>
	<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", 'black-letterhead'); ?><p>
	<?php
	return;
}


function black_letterhead_callback($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="comment-author vcard">
	<div class="comment-avatar"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
	<cite class="fn"><?php comment_author_link() ?></cite> <span class="says"><?php _e('Says:', 'black-letterhead'); ?></span>
	
	<?php if ($comment->comment_approved == '0') : ?>
		<em><?php _e('Your comment is awaiting moderation.', 'black-letterhead'); ?></em>
	<?php endif; ?>
	<br />

	<small class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" title=""><?php comment_date(); ?> <?php _e('at', 'black-letterhead'); ?> <?php comment_time(); ?></a> <?php edit_comment_link('e','',''); ?></small>
	</div>
	<?php comment_text(); ?>
	
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php 
}

if (have_comments()) :
?>
	<h3 id="comments"><?php comments_number(__('No Responses Yet'), __('One Response'), __('% Responses') );?> <?php _e('to'); ?> &#8220;<?php the_title(); ?>&#8221;</h3> 

	<ol class="commentlist">
	<?php wp_list_comments(array('callback'=>'black_letterhead_callback')); ?>
	</ol>

	<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
	</div>
<?php endif; ?>

<?php if ( have_comments() && !comments_open() ) : ?>
	<p class="nocomments"><?php _e('Comments are closed.', 'black-letterhead'); ?></p>
<?php endif; ?>

<?php if (comments_open()) : ?>

<div id="respond">
<h3><?php comment_form_title( __('Leave a Reply'), __('Leave a Reply to %s') ); ?></h3>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'black-letterhead'), get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php printf(__('Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'sandbox', 'black-letterhead'),
	get_option('siteurl') . '/wp-admin/profile.php',
	wp_specialchars($user_identity, true),
	get_option('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . get_permalink() ) ?>
</p>
<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name', 'black-letterhead'); ?> <?php if ($req) _e('(required)', 'black-letterhead'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)', 'black-letterhead'); ?> <?php if ($req) _e('(required)', 'black-letterhead'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website', 'black-letterhead'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'black-letterhead'); ?>" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>
<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
