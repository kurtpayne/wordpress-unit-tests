<?php // Do not delete these lines

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?><p>
<?php
	return;
}
?>

<div id="comments">

<?php 
	
	
	function pressrow_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
	?>
	
		<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
			<div id="div-comment-<?php comment_ID() ?>">
			<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.'); ?></em>
			<?php else : ?>
			<div class="comment-author vcard">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				<div class="comment_intro">
					<span class="comment_author fn"><?php comment_author_link() ?></span><br />
					<span class="comment_meta comment-meta commentmetadata">
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" title=""><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?></a>
						<?php edit_comment_link(__('Edit'), ' &#183; ', ''); ?>
					</span>
				</div>
			</div>
				
				<div class="entry">
					<?php comment_text() ?>
				</div>
				<div class="reply">
					<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			<?php endif; ?>
			</div>
	<?php
	}
	
	if (have_comments()) : ?>
		<h2 class="comment_head"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments') );?></h2> 
	
		<ul class="comment_list">
		<?php wp_list_comments(array('callback'=>'pressrow_comment', 'avatar_size'=>48)); ?>
		</ul>
	
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
		<br style="clear:both;" />
		<?php if (!comments_open()) : ?> 
			<h2 class="comment_head"><?php _e('Comments are closed.'); ?></h2>
		<?php endif; ?>
	<?php endif; ?>
	
	
	<?php if (comments_open()) : ?>
		<div id="respond">
		<h2 class="form_head"><?php comment_form_title(__('Leave a Reply'),__('Leave a Reply to %s')); ?></h2>
		<small id="cancel-comment-reply"><?php cancel_comment_reply_link() ?></small>
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
		<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
	<?php else : ?>
	
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment_form">
	
		<?php if ( $user_ID ) : ?>
		
			<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account', 'kubrick'); ?>"><?php _e('Logout &raquo;'); ?></a></p>
		
		<?php else : ?>
		
			<p><input type="text" class="text_input" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" /><label for="author"><?php _e('Name'); ?> <?php if ($req) _e("(required)"); ?></label></p>
			<p><input type="text" class="text_input" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" /><label for="email"><?php _e('E-mail (will not be published)'); ?> <?php if ($req) _e("(required)"); ?></label></p>
			<p><input type="text" class="text_input" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /><label for="url"><?php _e('Website'); ?></label></p>
		
		<?php endif; ?>
		
		<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->
		
		<p><textarea class="text_area" name="comment" id="comment" rows="10" tabindex="4"></textarea></p>	
		<p>
		<input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Submit Comment')); ?>" />
		<?php comment_id_fields(); ?>
		</p>
		<?php do_action('comment_form', $post->ID); ?>
	
	</form>
	
	<?php endif; // If registration required and not logged in ?>
		<br style="clear:both" />		
		</div>
		
	<?php endif; // if you delete this the sky will fall on your head ?>

</div>
