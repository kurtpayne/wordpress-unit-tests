<?php 
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p><?php _e('Enter your password to view comments.','benevolence'); ?></p>
<?php
	return;
}

function benevolence_callback($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<div <?php comment_class(empty( $args['has_children'] ) ? 'commentBox' : 'commentBox parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php comment_text() ?>
	<span class="comment-author vcard">
	<i><?php comment_type(__('Comment','benevolence'), __('Trackback','benevolence'), __('Pingback','benevolence')); ?> <?php _e('by','benevolence'); ?> <cite class="fn"><?php comment_author_link() ?></cite>
	</span>
	<span class="comment-meta commentmetadata">
	<?php comment_date(); ?> @ <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time() ?></a> <?php edit_comment_link(__('Edit This','benevolence'), ' |'); ?></i>
	</span>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
	<br />
<?php 
}

if ( comments_open() || have_comments() ) : ?>
<b><?php comments_number(__('No Comments Yet','benevolence'), __('1 Comment','benevolence'), __('% Comments','benevolence')); ?> <?php if ( comments_open() ) _e('so far','benevolence'); ?></b>
<?php else : // If there are no comments yet ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?><br /> 
<a href="#postcomment" title="<?php _e('Leave a comment','benevolence'); ?>"><?php _e('Leave a comment','benevolence'); ?></a>
<?php endif; ?>
<br /><br />
<a name="comments"></a>
<?php if ( $comments ) : ?>

<div class="commentlist">
<?php wp_list_comments(array('callback'=>'benevolence_callback', 'style'=>'div')); ?>
</div>
<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
</div>
<br />

<?php else : // If there are no comments yet ?>

<?php endif; ?>

<div class="right"><?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.','benevolence')); ?> 
<?php if ( pings_open() ) : ?>
	<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Uniform Resource Identifier">URI</abbr>','benevolence'); ?></a>
<?php endif; ?>
</div>

<br /><br />

<a name="postcomment"></a>
<?php if ( comments_open() ) : ?>
<div id="respond">
<b><?php comment_form_title( __('Leave a comment','benevolence'), __('Leave a comment to %s','benevolence') ); ?></b><br />
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>
<?php _e('Line and paragraph breaks automatic, e-mail address never displayed, <acronym title=\"Hypertext Markup Language\">HTML</acronym> allowed:','benevolence'); ?> <code><?php echo allowed_tags(); ?></code>

<form action="<?php echo get_settings('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as','benevolence'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','benevolence') ?>"><?php _e('Logout','benevolence') ?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name','benevolence'); ?> <?php if ($req) _e('(required)','benevolence'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)','benevolence'); ?> <?php if ($req) _e('(required)','benevolence'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','benevolence'); ?></small></label></p>

<?php endif; ?>

	<p>
	  <label for="comment"><?php _e('Your Comment','benevolence'); ?></label>
	<br />
	  <textarea name="comment" style="border: 1px solid #000;" id="comment" cols="50" rows="6" tabindex="4"></textarea>
	</p>

	<p>
	  <input name="submit" id="submit" type="submit" tabindex="5" value="<?php _e('Say It!','benevolence'); ?>" />
	  <?php comment_id_fields(); ?>
	</p>
	<?php do_action('comment_form', $post->ID); ?>
</form>
</div>
<?php else : // Comments are closed ?>

<?php endif; ?>
