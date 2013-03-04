<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?></p>
<?php
	return;
}


function daydream_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<?php if ($comment->comment_approved == '0') : ?>
	<p class="await_mod">Your comment is awaiting moderation.</p>
	<?php endif; ?>

	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	
	<?php comment_text(); ?>
	
	<div class="comment-author vcard cmntmeta comment-meta commentmetadata"><span class="fn"><?php comment_author_link() ?></span> - <?php comment_date() ?> at <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></div>
	
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
}

if (have_comments()) : ?>

	<h4 id="comments"><?php comments_number('No Responses Yet', 'One Response', '% Responses' );?></h4> 

	<ol class="commentlist">
	<?php wp_list_comments(array(
		'callback'=>'daydream_comment',
		'avatar_size'=>48,
	)); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	
	<?php if ('closed' == $post->comment_status) : ?> 
		<h4>Comments are closed.</h4>
	<?php endif; ?>

	<?php else : // this is displayed if there are no comments so far ?>
		<?php if ('open' == $post->comment_status) : ?> 
			<h4>There are no comments on this <?php if ( is_page() ) echo 'page'; else echo 'post'; ?></h4>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ('open' == $post->comment_status) : ?>
		<div id="respond">
		<div id="commentformarea">
		
			<h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>
			<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
			
			<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
				<p class="mustbe">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
			<?php else : ?>
		
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
				
				<?php if ( $user_ID ) : ?>
				
					<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
				
				<?php else : ?>
				
					<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
					<label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label></p>
					
					<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
					<label for="email"><small>E-mail (not published) <?php if ($req) echo "(required)"; ?></small></label></p>
					
					<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
					<label for="url"><small>Website</small></label></p>
				
				<?php endif; ?>
				
				<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->
				
				<p><textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea></p>
				
				<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
				<?php comment_id_fields(); ?>
				</p>
				<?php do_action('comment_form', $post->ID); ?>
				
				</form>
			<?php endif; // If registration required and not logged in ?>
		</div>
		</div>
	<?php endif; // if you delete this the sky will fall on your head ?>
