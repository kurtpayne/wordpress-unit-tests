<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','greenmarinee'); ?></p>
<?php
	return;
}


function green_marinee_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<div class="comment_author">
			<span class="fn"><?php comment_author_link() ?></span> <?php _e('said','greenmarinee'); ?>,
		</div>
	</div>
	
	<?php if ($comment->comment_approved == '0') : ?>
	<em><?php _e('Your comment is awaiting moderation.','greenmarinee'); ?></em>
	<?php endif; ?>
	<br />

	<p class="metadate comment-meta commentmetadata"><?php _e('on','greenmarinee'); ?> <?php comment_date() ?> <?php _e('on','greenmarinee'); ?> <?php comment_time() ?></p>

	<?php comment_text() ?>

	<p class="replylink">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</p>
	</div>
<?php
}

if (have_comments()) : ?>
	<h3 class="reply"><?php comments_number(__('No Responses Yet','greenmarinee'),__('One Response','greenmarinee'),__('% Responses','greenmarinee'));?> <?php _e('to','greenmarinee'); ?> '<?php the_title(); ?>'</h3> 
<p class="comment_meta"><?php _e('Subscribe to comments with','greenmarinee'); ?> <?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr>')); ?> 
<?php if ( pings_open() ) : ?>
	<?php _e('or','greenmarinee'); ?> <a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack','greenmarinee');?></a> <?php _e('to','greenmarinee'); ?> '<?php the_title(); ?>'.
<?php endif; ?>
</p>
	<ol class="commentlist">

	<?php wp_list_comments(array('callback'=>'green_marinee_comment', 'avatar_size'=>48)); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<br />
<?php endif; ?>


<?php if (comments_open()) : ?>
<div id="respond">
<h3 class="reply"><?php comment_form_title( __('Leave a Reply','greenmarinee'), __('Leave a Reply to %s','greenmarinee') ); ?></h3>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be','greenmarinee'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in','greenmarinee'); ?></a> <?php _e('to post a comment.','greenmarinee'); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as','greenmarinee'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','greenmarinee') ?>"><?php _e('Logout','greenmarinee'); ?> &raquo;</a></p>

<?php else : ?>
<div class="postinput">
<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name','greenmarinee'); ?> <?php if ($req) _e('(required)','greenmarinee'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)','greenmarinee'); ?> <?php if ($req) _e('(required)','greenmarinee'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','greenmarinee'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment','greenmarinee'); ?>" title="<?php _e('Please review your comment before submitting','greenmarinee'); ?>" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>
</div>
</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php elseif ( have_comments() ) : ?>
	<p class="nocomments"><?php _e('Comments are closed.','greenmarinee'); ?></p>
<?php endif; // if you delete this the sky will fall on your head ?>
