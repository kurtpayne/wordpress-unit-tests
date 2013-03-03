<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) {
		echo '<p class="nocomments">'.__('This post is password protected. Enter the password to view comments.', 'albeo').'</p>';
		return;
	}
?>

<?php
function albeo_comment_start($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	?>

	<div <?php comment_class('com-entry'); ?> id="comment-<?php comment_ID(); ?>">
	<div class="com-entry-bot">
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/com-top.png" width="100%" height="10" />
		<div class="com-con">
			<p class="commentmetadata">
				<?php if ($args['avatar_size'] != 0) echo '<span class="avatar">'.get_avatar( $comment, $args['avatar_size'] ).'</span>'; ?>
				<span class="com-name"><?php if ( 0 == $comment->comment_parent || !get_option('thread_comments') ) { global $commentNumber; $commentNumber++; echo $commentNumber; ?> | <?php } comment_author_link(); ?></span><br />
				<span class="com-date"><a href="#comment-<?php comment_ID() ?>"><?php comment_date() ?> <?php _e('at', 'albeo'); ?> <?php comment_time() ?></a>  <?php edit_comment_link(__('edit', 'albeo'),'|&nbsp;',''); ?></span>
			</p>
	
			<?php if ($comment->comment_approved == '0') : ?>
				<p><em><?php _e('Your comment is awaiting moderation.', 'albeo'); ?></em></p>
			<?php endif; ?>									
			<?php comment_text(); ?>
			<div class="reply" id="comment-reply-<?php comment_ID(); ?>">
			<?php comment_reply_link(array_merge( $args, array('add_below' => 'comment-reply', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
<?php }

function albeo_comment_end() { ?>
		</div>
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/com-bot.png" width="100%" height="10" />
	</div>
	</div>
<?php 
}
?>

<?php if ( have_comments() ) : ?>
<div class="com-list">
<h3 id="comments"><?php comments_number(__('No Responses Yet', 'albeo'), __('1 Response', 'albeo'), __('% Responses' , 'albeo')); ?> <?php _e('to', 'albeo'); ?> "<?php the_title(); ?>"</h3>

<?php wp_list_comments(array(
	'callback' => 'albeo_comment_start',
	'end-callback' =>'albeo_comment_end',
	'style'=>'div',
)); ?>
 
<div class="navigation">
<div class="alignleft"><?php previous_comments_link() ?></div>
<div class="alignright"><?php next_comments_link() ?></div>
</div>
</div>
<?php else : // this is displayed if there are no comments so far ?>
	<?php if (comments_open()) :
		// If comments are open, but there are no comments.
	elseif ( have_comments() ) : // comments are closed 
	?>
	<p><?php _e('Comments are closed.', 'albeo'); ?></p>
	<?php
	endif;
endif;
?>

<?php if (!comments_open() && have_comments()) : ?>
<p><?php _e('Comments are closed.', 'albeo'); ?></p>
<?php endif; ?>					

<?php if (comments_open()) : ?>

<div class="com-form" id="respond"><div class="com-form-bot">
<h3><?php comment_form_title( __('Leave a Reply', 'albeo'), __('Leave a Reply to %s', 'albeo') ); ?></h3>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
<form id="comment-form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'albeo'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>
<?php if ( $user_ID ) : ?>
    <p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'albeo'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'albeo'); ?>"><?php _e('Log out &raquo;', 'albeo'); ?></a></p>

<?php else : ?>
<p>
<label for="comment-name"><?php _e('Your Name', 'albeo'); ?> <strong><?php if ($req) echo __("(required)", 'albeo'); ?></strong></label>
<input id="comment-name" value="<?php echo $comment_author; ?>" name="author"  type="text" style="width: 230px;" />
</p>
<p>
<label for="comment-name"><?php _e('Your Email', 'albeo'); ?> <strong><?php if ($req) echo __("(required)", 'albeo'); ?></strong></label>
<input id="comment-email" name="email" value="<?php echo $comment_author_email; ?>" type="text" style="width: 230px;" />
</p>
<p>
<label for="comment-name"><?php _e('Your URL', 'albeo'); ?></label>
<input id="comment-url" name="url" value="<?php echo $comment_author_url; ?>" type="text" style="width: 230px;" />
</p>
<?php endif; ?>
<p><textarea name="comment" id="comment" cols="50" rows="10"></textarea></p>

<button name="submit" type="submit"><?php _e('Post', 'albeo'); ?></button>
<?php comment_id_fields(); ?>
<?php endif; ?>
<?php do_action('comment_form', $id); ?>
</form>

</div></div>
<?php endif; ?>
